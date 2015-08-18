<?php


	namespace MemberBundle\Controller;

	use FOS\UserBundle\Model\UserInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Security\Core\Exception\AccessDeniedException;
	use MemberBundle\Form\Type\ChangePasswordFormType;

	class ChangePasswordController extends Controller {
		/**
		 * Change user password
		 */
		public function changePasswordAction(Request $request) {
			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}

			$form = $this->createForm(new ChangePasswordFormType(), $user);
			$form->handleRequest($request);

			if ($form->isValid()) {
				$userManager = $this->get('uneak.member_manager');
				$userManager->updateUser($user);
				$url = $this->generateUrl('member_profile_show');
				return new RedirectResponse($url);
			}

			return $this->render('MemberBundle:Member/ChangePassword:changePassword.html.twig', array(
				'form' => $form->createView()
			));
		}
	}
