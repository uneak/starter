<?php

	/*
	 * This file is part of the FOSUserBundle package.
	 *
	 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace MemberBundle\Controller;

	use FOS\UserBundle\FOSUserEvents;
	use FOS\UserBundle\Event\FormEvent;
	use FOS\UserBundle\Event\GetResponseUserEvent;
	use FOS\UserBundle\Event\FilterUserResponseEvent;
	use FOS\UserBundle\Model\UserInterface;
	use MemberBundle\Form\Type\ResettingFormType;
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
	class ResettingController extends Controller {
		/**
		 * Request reset user password: show form
		 */
		public function requestAction() {
			$templates = $this->get("uneak.templatesmanager");
			return $this->render($templates->get("member_resetting_request"));
		}

		/**
		 * Request reset user password: submit form and send email
		 */
		public function sendEmailAction(Request $request) {
			$username = $request->request->get('username');
			$templates = $this->get("uneak.templatesmanager");


			/** @var $user UserInterface */
			$user = $this->get('uneak.member_manager')->findUserByUsernameOrEmail($username);

			if (null === $user) {
				return $this->render($templates->get("member_resetting_request"), array(
					'invalid_username' => $username
				));
			}

			if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
				return $this->render($templates->get("member_resetting_password_already_requested"));
			}



			if (null === $user->getConfirmationToken()) {
				/** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
				$tokenGenerator = $this->get('fos_user.util.token_generator');
				$user->setConfirmationToken($tokenGenerator->generateToken());
			}

			$this->get('fos_user.mailer')->sendResettingEmailMessage($user);
			$user->setPasswordRequestedAt(new \DateTime());
			$this->get('uneak.member_manager')->updateUser($user);

			return new RedirectResponse($this->generateUrl('member_resetting_check_email',
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
				return new RedirectResponse($this->generateUrl('member_resetting_request'));
			}

			return $this->render($templates->get("member_resetting_check_email"), array(
				'email' => $email,
			));
		}

		/**
		 * Reset user password
		 */
		public function resetAction(Request $request, $token) {
			/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
			$userManager = $this->get('uneak.member_manager');
			$templates = $this->get("uneak.templatesmanager");

			$user = $userManager->findUserByConfirmationToken($token);

			if (null === $user) {
				throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
			}

			$form = $this->createForm(new ResettingFormType(), $user);
			$form->handleRequest($request);


			if ($form->isValid()) {
				$userManager->updateUser($user);
				$url = $this->generateUrl('member_profile_show');
				$response = new RedirectResponse($url);

				return $response;
			}


			return $this->render($templates->get("member_resetting_reset"), array(
				'token' => $token,
				'form'  => $form->createView(),
			));
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
