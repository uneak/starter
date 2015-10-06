<?php

	namespace UserBundle\Handler;

	use FOS\UserBundle\Model\UserManagerInterface;
	use Symfony\Component\Form\FormFactoryInterface;
	use Symfony\Component\Form\FormInterface;
	use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
	use Uneak\PortoAdminBundle\Handler\CrudHandler;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
	use Uneak\RoutesManagerBundle\Helper\MenuHelper;
	use UserBundle\Entity\User;


	class UserCrudHandler extends CrudHandler {

		/**
		 * @var \FOS\UserBundle\Model\UserManagerInterface
		 */
		private $userManager;


		public function __construct(FormFactoryInterface $formFactory, BlockBuilder $blockBuilder, GridHelper $gridHelper, MenuHelper $menuHelper, UserManagerInterface $userManager) {
			parent::__construct($formFactory, $blockBuilder, $gridHelper, $menuHelper);
			$this->userManager = $userManager;
		}


		public function persistAccountEntity(FormInterface $form) {
			$entity = $form->getData();

			$entity->setEnabled($entity->getStateProfile() == User::STATE_PROFILE_ACCEPT);
			$entity->setRoles(array($form->get('role')->getData()));

			$this->userManager->updateUser($entity);
			return $entity;
		}

		public function persistEntity(FormInterface $form) {
			$entity = $form->getData();
			$this->userManager->updateUser($entity);
			return $entity;
		}

	}