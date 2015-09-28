<?php

	/*
	 * This file is part of the HWIOAuthBundle package.
	 *
	 * (c) Hardware.Info <opensource@hardware.info>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace UserBundle\Controller;

	use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
	use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
	use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
	use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\DependencyInjection\ContainerAware;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

	use Symfony\Component\PropertyAccess\PropertyAccess;
	use Symfony\Component\Security\Core\Exception\AccessDeniedException;
	use Symfony\Component\Security\Core\Exception\AccountStatusException;
    use Symfony\Component\Security\Core\Security;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
	use Symfony\Component\Security\Http\SecurityEvents;
	use Uneak\PortoAdminBundle\Blocks\Content\Twig;
	use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
	use Uneak\PortoAdminBundle\Controller\LayoutFormInterfaceController;
	use UserBundle\Form\Type\RegistrationFormType;

	class ConnectController extends Controller {

		/**
		 * Action that handles the login 'form'. If connecting is enabled the
		 * user will be redirected to the appropriate login urls or registration forms.
		 *
		 * @param Request $request
		 *
		 * @return Response
		 */
		public function connectAction(Request $request) {
			$connect = $this->container->getParameter('user_oauth.connect');
			$hasUser = $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED');

			$error = $this->getErrorForRequest($request);

			// if connecting is enabled and there is no user, redirect to the registration form
			if ($connect && !$hasUser && $error instanceof AccountNotLinkedException) {
				$key = time();
				$session = $request->getSession();
				$session->set('_user_oauth.registration_error.' . $key, $error);

				return new RedirectResponse($this->generate('user_registration_register', array('key' => $key)));
			}


			if ($error) {
				// TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
				$error = $error->getMessage();
			}

			$this->entityLayoutContent->setTitle("Réseaux sociaux");

			$content = new Twig('user_connect_login', array(
				'error' => $error,
				'user' => $this->entity,
			));

			$panel = new Panel();
			$panel->setTitle("Edition");
			$panel->isCollapsed(false);
			$panel->isDismiss(false);
			$panel->isToggle(false);
			$panel->addBlock($content);
			$this->entityLayoutContentBody->addBlock($panel, 'social');


		}






		public function disconnectServiceAction(Request $request, $service) {
			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}
			$this->container->get('user_oauth.account.connector')->disconnect($user, $service);

			return new RedirectResponse($this->generateUrl('user_oauth_connect'));
		}






		protected function updateSocialPhoto(UserInterface $user, $photoPath) {

			$propertyMapping = $this->get('vich_uploader.property_mapping_factory');

			$mapping = $propertyMapping->fromField($user, 'imageFile');
			$destDir = $mapping->getUploadDestination();
			$extension = pathinfo(parse_url($photoPath, PHP_URL_PATH), PATHINFO_EXTENSION);
			$destName = uniqid().".".$extension;

			$destPath = $destDir."/".$destName;
			$file = fopen($photoPath, "rb");
			if ($file) {
				$newfile = fopen($destPath, "wb");
				if ($newfile) {
					while(!feof($file)) {
						fwrite($newfile, fread($file, 1024 * 8 ), 1024 * 8 );
					}
					fclose($newfile);
				}
				fclose($file);
			}

			$user->setImage($destName);
		}





		public function registerServiceAction(Request $request, $service) {
			$connect = $this->container->getParameter('user_oauth.connect');
			if (!$connect) {
				throw new NotFoundHttpException();
			}

			$hasUser = $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED');
			if (!$hasUser) {
				throw new AccessDeniedException('Cannot connect an account.');
			}

			// Get the data from the resource owner
			$resourceOwner = $this->getResourceOwnerByName($service);

			$session = $request->getSession();
			$key = $request->query->get('key', time());

			if ($resourceOwner->handles($request)) {
				$accessToken = $resourceOwner->getAccessToken(
					$request,
					$this->container->get('user_oauth.security.oauth_utils')->getServiceAuthUrl($request, $resourceOwner)
				);

				// save in session
				$session->set('_user_oauth.connect_confirmation.' . $key, $accessToken);
			} else {
				$accessToken = $session->get('_user_oauth.connect_confirmation.' . $key);
			}

			$userInformation = $resourceOwner->getUserInformation($accessToken);

			// Show confirmation page?
			if (!$this->container->getParameter('user_oauth.connect.confirmation')) {
				goto show_confirmation_page;
			}





			// Handle the form
			/** @var $form FormInterface */
			$form = $this->container->get('form.factory')
				->createBuilder('form')
				->getForm();

			if ($request->isMethod('POST')) {
				$form->bind($request);

				if ($form->isValid()) {
					show_confirmation_page:

					/** @var $currentToken OAuthToken */
					$currentToken = $this->container->get('security.token_storage')->getToken();
					$currentUser = $currentToken->getUser();

					$this->container->get('user_oauth.account.connector')->connect($currentUser, $userInformation);

					if ($currentToken instanceof OAuthToken) {
						// Update user token with new details
						$this->authenticateUser($request, $currentUser, $service, $currentToken->getRawToken(), false);
					}

					return new RedirectResponse($this->generateUrl('user_oauth_connect'));

				}
			}



			//
			//
			$this->layout->setIcon("user");
			$this->layout->setTitle("Identification");

			$content = new Twig('user_connect_connect_confirm', array(
				'key'             => $key,
				'service'         => $service,
				'form'            => $form->createView(),
				'userInformation' => $userInformation,
			));

			$this->layout->setContent($content);

		}








		/**
		 * Connects a user to a given account if the user is logged in and connect is enabled.
		 *
		 * @param Request $request The active request.
		 * @param string  $service Name of the resource owner to connect to.
		 *
		 * @throws \Exception
		 *
		 * @return Response
		 *
		 * @throws NotFoundHttpException if `connect` functionality was not enabled
		 * @throws AccessDeniedException if no user is authenticated
		 */
		public function connectServiceAction(Request $request, $service) {
			$connect = $this->container->getParameter('user_oauth.connect');
			if (!$connect) {
				throw new NotFoundHttpException();
			}

			$hasUser = $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED');
			if (!$hasUser) {
				throw new AccessDeniedException('Cannot connect an account.');
			}

			// Get the data from the resource owner
			$resourceOwner = $this->getResourceOwnerByName($service);

			$session = $request->getSession();
			$key = $request->query->get('key', time());

			if ($resourceOwner->handles($request)) {
				$accessToken = $resourceOwner->getAccessToken(
					$request,
					$this->container->get('user_oauth.security.oauth_utils')->getServiceAuthUrl($request, $resourceOwner)
				);

				// save in session
				$session->set('_user_oauth.connect_confirmation.' . $key, $accessToken);
			} else {
				$accessToken = $session->get('_user_oauth.connect_confirmation.' . $key);
			}

			$userInformation = $resourceOwner->getUserInformation($accessToken);

			// Show confirmation page?
			if (!$this->container->getParameter('user_oauth.connect.confirmation')) {
				goto show_confirmation_page;
			}





			// Handle the form
			/** @var $form FormInterface */
			$form = $this->container->get('form.factory')
				->createBuilder('form')
				->getForm();

			if ($request->isMethod('POST')) {
				$form->bind($request);

				if ($form->isValid()) {
					show_confirmation_page:

					/** @var $currentToken OAuthToken */
					$currentToken = $this->container->get('security.token_storage')->getToken();
					$currentUser = $currentToken->getUser();

					$this->container->get('user_oauth.account.connector')->connect($currentUser, $userInformation);

					if ($currentToken instanceof OAuthToken) {
						// Update user token with new details
						$this->authenticateUser($request, $currentUser, $service, $currentToken->getRawToken(), false);
					}

					return new RedirectResponse($this->generateUrl('user_oauth_connect'));

				}
			}



			//
			//
			$this->layout->setIcon("user");
			$this->layout->setTitle("Identification");

			$content = new Twig('user_connect_connect_confirm', array(
				'key'             => $key,
				'service'         => $service,
				'form'            => $form->createView(),
				'userInformation' => $userInformation,
			));

			$this->layout->setContent($content);

		}

		/**
		 * @param Request $request
		 * @param string  $service
		 *
		 * @return RedirectResponse
		 */
		public function redirectToServiceAction(Request $request, $service) {


			$authorizationUrl = $this->container->get('user_oauth.security.oauth_utils')->getAuthorizationUrl($request, $service);
			// Check for a return path and store it before redirect
			if ($request->hasSession()) {
				// initialize the session for preventing SessionUnavailableException
				$session = $request->getSession();
				$session->start();


//				$state = uniqid();
//				$session->set("_authorization_state_".$state, array(
//					"state" => $state,
//					"action" => $action,
//				));


				$providerKey = $this->container->getParameter('user_oauth.firewall_name');
				$sessionKey = '_security.' . $providerKey . '.target_path';


				$param = $this->container->getParameter('hwi_oauth.target_path_parameter');
				if (!empty($param) && $targetUrl = $request->get($param, null, true)) {
					$session->set($sessionKey, $targetUrl);
				}


				if ($this->container->getParameter('hwi_oauth.use_referer') && !$session->has($sessionKey) && ($targetUrl = $request->headers->get('Referer')) && $targetUrl !== $authorizationUrl) {
					$session->set($sessionKey, $targetUrl);
				}



			}




			return new RedirectResponse($authorizationUrl."&state=marcopolo");
		}

		/**
		 * Get the security error for a given request.
		 *
		 * @param Request $request
		 *
		 * @return string|\Exception
		 */
		protected function getErrorForRequest(Request $request) {
			$session = $request->getSession();
			if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
				$error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
			} elseif (null !== $session && $session->has(Security::AUTHENTICATION_ERROR)) {
				$error = $session->get(Security::AUTHENTICATION_ERROR);
				$session->remove(Security::AUTHENTICATION_ERROR);
			} else {
				$error = '';
			}

			return $error;
		}

		/**
		 * Get a resource owner by name.
		 *
		 * @param string $name
		 *
		 * @return ResourceOwnerInterface
		 *
		 * @throws \RuntimeException if there is no resource owner with the given name.
		 */
		protected function getResourceOwnerByName($name) {
			$ownerMap = $this->container->get('hwi_oauth.resource_ownermap.' . $this->container->getParameter('user_oauth.firewall_name'));

			if (null === $resourceOwner = $ownerMap->getResourceOwnerByName($name)) {
				throw new \RuntimeException(sprintf("No resource owner with name '%s'.", $name));
			}

			return $resourceOwner;
		}

		/**
		 * Generates a route.
		 *
		 * @param string  $route    Route name
		 * @param array   $params   Route parameters
		 * @param boolean $absolute Absolute url or note.
		 *
		 * @return string
		 */
		protected function generate($route, $params = array(), $absolute = false) {
			return $this->container->get('router')->generate($route, $params, $absolute);
		}

		/**
		 * Authenticate a user with Symfony Security
		 *
		 * @param Request       $request
		 * @param UserInterface $user
		 * @param string        $resourceOwnerName
		 * @param string        $accessToken
		 * @param boolean       $fakeLogin
		 */
		protected function authenticateUser(Request $request, UserInterface $user, $resourceOwnerName, $accessToken, $fakeLogin = true) {
			try {
				$this->container->get('hwi_oauth.user_checker')->checkPostAuth($user);
			} catch (AccountStatusException $e) {
				// Don't authenticate locked, disabled or expired users
				return;
			}

			$token = new OAuthToken($accessToken, $user->getRoles());
			$token->setResourceOwnerName($resourceOwnerName);
			$token->setUser($user);
			$token->setAuthenticated(true);

			$this->container->get('security.token_storage')->setToken($token);

			if ($fakeLogin) {
				// Since we're "faking" normal login, we need to throw our INTERACTIVE_LOGIN event manually
				$this->container->get('event_dispatcher')->dispatch(
					SecurityEvents::INTERACTIVE_LOGIN,
					new InteractiveLoginEvent($request, $token)
				);
			}
		}


	}
