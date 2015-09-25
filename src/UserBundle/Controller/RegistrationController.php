<?php

	/*
	 * This file is part of the FOSUserBundle package.
	 *
	 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace UserBundle\Controller;

	use FOS\UserBundle\FOSUserEvents;
	use FOS\UserBundle\Event\FormEvent;
	use FOS\UserBundle\Event\GetResponseUserEvent;
	use FOS\UserBundle\Event\FilterUserResponseEvent;
	use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
	use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use Symfony\Component\PropertyAccess\PropertyAccess;
	use Symfony\Component\Security\Core\Exception\AccessDeniedException;
	use FOS\UserBundle\Model\UserInterface;
	use Uneak\PortoAdminBundle\Blocks\Content\Twig;
	use Uneak\PortoAdminBundle\Controller\LayoutFormInterfaceController;
	use UserBundle\Form\Type\RegistrationFormType;

	/**
	 * Controller managing the registration
	 *
	 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
	 * @author Christophe Coevoet <stof@notk.org>
	 */
	class RegistrationController extends LayoutFormInterfaceController {

		public function registerAction(Request $request, $key = null) {
			$userManager = $this->get('uneak.user_manager');
			$templates = $this->get("uneak.templatesmanager");

			$hasUser = $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED');
			if ($hasUser) {
				throw new AccessDeniedException('Cannot register already registered account.');
			}

			$user = $userManager->createUser();
			$userInformation = null;

			if ($key) {
				$session = $request->getSession();
				$error = $session->get('_user_oauth.registration_error.' . $key);
				$session->remove('_user_oauth.registration_error.' . $key);

				$key = time();
				$session->set('_user_oauth.registration_error.' . $key, $error);


				if (!($error instanceof AccountNotLinkedException) || (time() - $key > 300)) {
					// todo: fix this
					throw new \Exception('Cannot register an account.');
				}

				$userInformation = $this->getResourceOwnerByName($error->getResourceOwnerName())->getUserInformation($error->getRawToken());
				$this->updateUserInformation($user, $userInformation);
			}


			$form = $this->createForm(new RegistrationFormType(), $user);
			$form->handleRequest($request);

			if ($form->isValid()) {

				$emailHaveToConfirm = true;
				$emailConfirmed = false;

				if ($userInformation) {
					$this->container->get('user_oauth.account.connector')->connect($user, $userInformation);
					$this->updateSocialPhoto($user, $userInformation->getProfilePicture());
					$emailConfirmed = $userInformation->getEmail() == $user->getEmail();
					$user->setEmailConfirmed($emailConfirmed);
				}


				if ($emailHaveToConfirm && !$emailConfirmed) {

					$tokenGenerator = $this->get("fos_user.util.token_generator");
					$mailer = $this->get("mailer");

					if (null === $user->getConfirmationToken()) {
						$user->setConfirmationToken($tokenGenerator->generateToken());
					}

					// SEND EMAIL

					$rendered = $this->render($templates->getTemplate("user_registration_email_txt"), array(
						'user' => $user,
						'confirmationUrl' =>  $this->generateUrl('user_registration_confirm', array('token' => $user->getConfirmationToken()), true)
					));

					$renderedLines = explode("\n", trim($rendered));
					$subject = $renderedLines[0];
					$body = implode("\n", array_slice($renderedLines, 1));

					$message = \Swift_Message::newInstance()
						->setSubject($subject)
						->setFrom('mgaloyer@uneak.fr')
						->setTo($user->getEmail())
						->setBody($body);

					$mailer->send($message);

					$userManager->updateUser($user);

					$url = $this->generateUrl('user_registration_check_email', array("username" => $user->getUsername()));
					return new RedirectResponse($url);

				} else {

					$userManager->updateUser($user);

					$url = $this->generateUrl('user_registration_confirmed', array("username" => $user->getUsername()));
					return new RedirectResponse($url);
				}



			}



			$this->layout->setIcon("user");
			$this->layout->setTitle("Register");
			$content = new Twig('user_registration_register', array(
				'form' => $form->createView(),
				'userInformation' => $userInformation,
				'key' => $key
			));
			$this->layout->setContent($content);


		}




		/**
		 * Tell the user to check his email provider
		 */
		public function checkEmailAction($username) {
			$userManager = $this->get('uneak.user_manager');
			$user = $userManager->findUserByUsername($username);

			if (null === $user) {
				throw new NotFoundHttpException(sprintf('The user with username "%s" does not exist', $username));
			}

			//
			//
			$this->layout->setIcon("user");
			$this->layout->setTitle("Register");
			$content = new Twig('user_registration_check_email', array(
				'user' => $user,
			));
			$this->layout->setContent($content);

		}


		/**
		 * Receive the confirmation token from user email provider, login the user
		 */
		public function emailConfirmAction(Request $request, $token) {
			$userManager = $this->get('uneak.user_manager');
			$user = $userManager->findUserByConfirmationToken($token);

			if (null === $user) {
				throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
			}

			$user->setConfirmationToken(null);
			$user->setEmailConfirmed(true);
			$userManager->updateUser($user);

			return new RedirectResponse($this->generateUrl('user_registration_email_confirmed', array("username" => $user->getUsername())));
		}


		/**
		 * Tell the user his account is now confirmed
		 */
		public function emailConfirmedAction($username) {
			$userManager = $this->get('uneak.user_manager');
			$user = $userManager->findUserByUsername($username);

			$this->layout->setIcon("user");
			$this->layout->setTitle("Register");
			$content = new Twig('user_registration_email_confirmed', array(
				'user' => $user,
			));
			$this->layout->setContent($content);

		}



		/**
		 * Tell the user his account is now confirmed
		 */
		public function confirmedAction($username) {
			$userManager = $this->get('uneak.user_manager');
			$user = $userManager->findUserByUsername($username);

			$this->layout->setIcon("user");
			$this->layout->setTitle("Register");
			$content = new Twig('user_registration_confirmed', array(
				'user' => $user,
			));
			$this->layout->setContent($content);
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

		protected function updateUserInformation(UserInterface $user, UserResponseInterface $userInformation)
		{
			$accessor = PropertyAccess::createPropertyAccessor();
			$accessor->setValue($user, 'username', $userInformation->getNickname());
			$accessor->setValue($user, 'firstName', $userInformation->getFirstName());
			$accessor->setValue($user, 'lastName', $userInformation->getLastName());

			if ($accessor->isWritable($user, 'email')) {
				$accessor->setValue($user, 'email', $userInformation->getEmail());
			}
		}
	}
