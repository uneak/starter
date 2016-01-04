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

	use Uneak\PortoAdminBundle\Blocks\Content\Twig;
	use Uneak\PortoAdminBundle\Blocks\Form\Form;
	use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
	use UserBundle\Form\Type\ProfileFormType;
	use FOS\UserBundle\Model\UserInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Security\Core\Exception\AccessDeniedException;

	/**
	 * Controller managing the user profile
	 *
	 * @author Christophe Coevoet <stof@notk.org>
	 */
	class ProfileController extends Controller {
		/**
		 * Show the user
		 */
		public function showAction() {

			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}


            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.profile.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildProfileLayout($user);

            $layout->getSubLayoutContentBody()->addBlock(new Twig('user_profile_show', array(
                'user' => $user
            )));

            return $blockBuilder->renderResponse("layout");

		}


        public function connectAction() {
            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }


            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.profile.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildProfileLayout($user);

            $layout->getSubLayoutContent()->setTitle("Réseaux sociaux");
            $oAuthUser = $this->getDoctrine()->getRepository("UneakOAuthClientBundle:OAuthUser")->findOAuthUser($user);

            $panel = new Panel();
            $panel->setTitle("Edition");
            $panel->setCollapsed(false);
            $panel->setDismiss(false);
            $panel->setToggle(false);
            $panel->addBlock(new Twig('user_connect_login', array(
                'user' => $user,
                'oAuthUser' => $oAuthUser,
            )));
            $layout->getSubLayoutContentBody()->addBlock($panel, 'social');

            return $blockBuilder->renderResponse("layout");
        }


		public function disconnectServiceAction($service) {
			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}

			$em = $this->getDoctrine()->getManager();
			$oAuthUser = $em->getRepository("UneakOAuthClientBundle:OAuthUser")->findOAuthUser($user, $service);
			$em->remove($oAuthUser);
			$em->flush();

			return new RedirectResponse($this->generateUrl('user_profile_connect'));
		}




		/**
		 * Edit the user
		 */
		public function editAction(Request $request) {

			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}

			$form = $this->createForm(new ProfileFormType(), $user);
			$form->add('submit', 'submit', array('label' => 'Modifier'));
			$form->handleRequest($request);

			if ($form->isValid()) {
				/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
				$userManager = $this->get('uneak.user_manager');
				$userManager->updateUser($user);
				return new RedirectResponse($this->generateUrl('user_profile_show'));
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
            $panel->setTitle("Edition");
            $panel->setCollapsed(false);
            $panel->setDismiss(false);
            $panel->setToggle(false);
            $panel->addBlock($formBlock);
            $layout->getSubLayoutContentBody()->addBlock($panel, 'form');


            return $blockBuilder->renderResponse("layout");







		}
	}
