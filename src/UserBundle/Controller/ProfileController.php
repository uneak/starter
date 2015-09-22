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
	use FOS\UserBundle\FOSUserEvents;
	use FOS\UserBundle\Event\FormEvent;
	use FOS\UserBundle\Event\FilterUserResponseEvent;
	use FOS\UserBundle\Event\GetResponseUserEvent;
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
	class ProfileController extends LayoutProfileController {
		/**
		 * Show the user
		 */
		public function showAction() {

			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}

			$content = new Twig('fos_profile_show', array(
				'user' => $user
			));
			$this->entityLayoutContentBody->addBlock($content);
		}

		/**
		 * Edit the user
		 */
		public function editAction(Request $request) {
			$templates = $this->get("uneak.templatesmanager");

			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}

			$form = $this->createForm(new ProfileFormType(), $user);
			$form->handleRequest($request);

			if ($form->isValid()) {
				/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
				$userManager = $this->get('uneak.user_manager');
				$userManager->updateUser($user);
				$url = $this->generateUrl('user_profile_show');
				$response = new RedirectResponse($url);
				return $response;
			}


			$formBlock = new Form($form);
			$formBlock->addClass("form-horizontal");
			$formBlock->addClass("form-bordered");

			$panel = new Panel();
			$panel->setTitle("Edition");
			$panel->isCollapsed(false);
			$panel->isDismiss(false);
			$panel->isToggle(false);
			$panel->addBlock($formBlock);
			$this->entityLayoutContentBody->addBlock($panel, 'form');


		}
	}
