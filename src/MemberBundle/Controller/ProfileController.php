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

	use MemberBundle\Form\Type\ProfileFormType;
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
	class ProfileController extends Controller {
		/**
		 * Show the user
		 */
		public function showAction() {
			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}

			return $this->render('MemberBundle:Member/Profile:show.html.twig', array(
				'user' => $user
			));
		}

		/**
		 * Edit the user
		 */
		public function editAction(Request $request) {
			$user = $this->getUser();
			if (!is_object($user) || !$user instanceof UserInterface) {
				throw new AccessDeniedException('This user does not have access to this section.');
			}

			/** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
			$dispatcher = $this->get('event_dispatcher');

			$event = new GetResponseUserEvent($user, $request);
			$dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

			if (null !== $event->getResponse()) {
				return $event->getResponse();
			}


			$form = $this->createForm(new ProfileFormType(), $user);

			$form->handleRequest($request);

			if ($form->isValid()) {
				/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
				$userManager = $this->get('uneak.member_manager');

				$event = new FormEvent($form, $request);
				$dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

				$userManager->updateUser($user);

				if (null === $response = $event->getResponse()) {
					$url = $this->generateUrl('member_profile_show');
					$response = new RedirectResponse($url);
				}

				$dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

				return $response;
			}

			return $this->render('MemberBundle:Member/Profile:edit.html.twig', array(
				'form' => $form->createView()
			));
		}
	}