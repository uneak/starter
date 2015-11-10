<?php


	namespace UserBundle\Controller;

	use FOS\UserBundle\Model\UserInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Security\Core\Exception\AccessDeniedException;
	use Uneak\PortoAdminBundle\Blocks\Form\Form;
	use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
	use UserBundle\Form\Type\ChangePasswordFormType;

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
			$form->add('submit', 'submit', array('label' => 'Modifier'));
			$form->handleRequest($request);

			if ($form->isValid()) {
				$userManager = $this->get('uneak.user_manager');
				$userManager->updateUser($user);
				$url = $this->generateUrl('user_profile_show');
				return new RedirectResponse($url);
			}


            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.profile.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildProfileLayout($user);

            $formBlock = new Form($form);
            $formBlock->addClass("form-horizontal");
            $formBlock->addClass("form-bordered");

            $panel = new Panel();
            $panel->setTitle("Modification du mot de passe");
            $panel->isCollapsed(false);
            $panel->isDismiss(false);
            $panel->isToggle(false);
            $panel->addBlock($formBlock);
            $layout->getSubLayoutContentBody()->addBlock($panel, 'form');

            return $blockBuilder->renderResponse("layout");




		}
	}
