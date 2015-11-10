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

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Security\Core\Security;
	use Symfony\Component\Security\Core\Exception\AuthenticationException;
	use Uneak\PortoAdminBundle\Blocks\Content\Twig;
    use Uneak\PortoAdminBundle\Blocks\Layout\FormInterface;

    class SecurityController extends Controller {

		public function loginAction(Request $request) {


			/** @var $session \Symfony\Component\HttpFoundation\Session\Session */
			$session = $request->getSession();

            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;

//			$error = $this->getErrorForRequest($request);
//			if ($error) {
//				// TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
//				$error = $error->getMessage();
//			}

			// get the error if any (works with forward and redirect -- see below)
			if ($request->attributes->has($authErrorKey)) {
				$error = $request->attributes->get($authErrorKey);
			} elseif (null !== $session && $session->has($authErrorKey)) {
				$error = $session->get($authErrorKey);
				$session->remove($authErrorKey);
			} else {
				$error = null;
			}

			if (!$error instanceof AuthenticationException) {
				$error = null; // The value does not come from the security component.
			}

			// last username entered by the user
			$lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

			$csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();




            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", new FormInterface());

            $layout = $this->get("uneak.admin.form.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));

            $layout->getLayout()->setIcon("user");
            $layout->getLayout()->setTitle("Identification");

            $layout->getLayoutContent()->addBlock(new Twig('user_security_login', array(
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
            )));

            return $blockBuilder->renderResponse("layout");




		}


		public function checkAction() {
			throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
		}

		public function logoutAction() {
			throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
		}
	}
