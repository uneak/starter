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
	use FOS\UserBundle\Model\UserInterface;
	use Uneak\PortoAdminBundle\Blocks\Content\Twig;
	use Uneak\PortoAdminBundle\Controller\LayoutFormInterfaceController;
	use UserBundle\Form\Type\ResettingFormType;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

	/**
	 * Controller managing the resetting of the password
	 *
	 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
	 * @author Christophe Coevoet <stof@notk.org>
	 */
	class ResettingController extends LayoutFormInterfaceController {
		/**
		 * Request reset user password: show form
		 */
		public function requestAction() {

			//
			//
			$this->layout->setIcon("key");
			$this->layout->setTitle("Réinitialisation du mot de passe");
			$content = new Twig('user_resetting_request');
			$this->layout->setContent($content);


		}

		/**
		 * Request reset user password: submit form and send email
		 */
		public function sendEmailAction(Request $request) {
			$username = $request->request->get('username');
			$templates = $this->get("uneak.templatesmanager");


			/** @var $user UserInterface */
			$user = $this->get('uneak.user_manager')->findUserByUsernameOrEmail($username);

			if (null === $user) {

				//TODO: renderbylayout
				return $this->render($templates->getTemplate("user_resetting_request"), array(
					'invalid_username' => $username
				));
			}

			if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {

				//TODO: renderbylayout
				return $this->render($templates->getTemplate("user_resetting_password_already_requested"));
			}



			if (null === $user->getConfirmationToken()) {
				/** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
				$tokenGenerator = $this->get('fos_user.util.token_generator');
				$user->setConfirmationToken($tokenGenerator->generateToken());
			}


			// SEND EMAIL
			$mailer = $this->get("mailer");
			$rendered = $this->render($templates->getTemplate("user_resetting_email_txt"), array(
				'user' => $user,
				'confirmationUrl' =>  $this->generateUrl('user_resetting_reset', array('token' => $user->getConfirmationToken()), true)
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


			$user->setPasswordRequestedAt(new \DateTime());
			$this->get('uneak.user_manager')->updateUser($user);

			return new RedirectResponse($this->generateUrl('user_resetting_check_email',
				array('email' => $this->getObfuscatedEmail($user))
			));
		}

		/**
		 * Tell the user to check his email provider
		 */
		public function checkEmailAction(Request $request) {
			$email = $request->query->get('email');
			$templates = $this->get("uneak.templatesmanager");

			if (empty($email)) {
				// the user does not come from the sendEmail action
				return new RedirectResponse($this->generateUrl('user_resetting_request'));
			}

			//
			//
			$this->layout->setIcon("key");
			$this->layout->setTitle("Réinitialisation du mot de passe");
			$content = new Twig('user_resetting_check_email', array(
				'email' => $email,
			));
			$this->layout->setContent($content);

		}

		/**
		 * Reset user password
		 */
		public function resetAction(Request $request, $token) {
			/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
			$userManager = $this->get('uneak.user_manager');

			$user = $userManager->findUserByConfirmationToken($token);

			if (null === $user) {
				throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
			}

			$form = $this->createForm(new ResettingFormType(), $user);
			$form->handleRequest($request);

			if ($form->isValid()) {
				$userManager->updateUser($user);
				return new RedirectResponse($this->generateUrl('user_profile_show'));
			}


			//
			//
			$this->layout->setIcon("key");
			$this->layout->setTitle("Réinitialisation du mot de passe");
			$content = new Twig('user_resetting_reset', array(
				'token' => $token,
				'form' => $form->createView(),
			));
			$this->layout->setContent($content);


		}

		/**
		 * Get the truncated email displayed when requesting the resetting.
		 *
		 * The default implementation only keeps the part following @ in the address.
		 *
		 * @param \FOS\UserBundle\Model\UserInterface $user
		 *
		 * @return string
		 */
		protected function getObfuscatedEmail(UserInterface $user) {
			$email = $user->getEmail();
			if (false !== $pos = strpos($email, '@')) {
				$email = '...' . substr($email, $pos);
			}

			return $email;
		}
	}
