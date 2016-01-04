<?php

	namespace Uneak\PortoAdminBundle\Handler;


	use Doctrine\ORM\EntityManager;
	use Symfony\Component\Form\FormFactoryInterface;
	use Symfony\Component\Form\FormInterface;
	use Uneak\PortoAdminBundle\Exception\NotFoundException;

	class EntityAPIHandler extends AbstractAPIHandler implements APIHandlerInterface {

		/**
		 * @var EntityManager
		 */
		protected $em;
		protected $entityClass;


		public function __construct(FormFactoryInterface $formFactory, EntityManager $em) {
			parent::__construct($formFactory);
			$this->em = $em;
		}

		public function setEntityClass($entityClass) {
			$this->entityClass = $entityClass;
		}

		protected function getRepository() {
			return $this->em->getRepository($this->entityClass);
		}

		public function createEntity() {
			return new $this->entityClass();
		}

		public function persistEntity(FormInterface $form) {
			$entity = $form->getData();
			$this->em->persist($entity);
			$this->em->flush($entity);

			return $entity;
		}

		public function get($id) {
			$entity = $this->getRepository()->findOneById($id);
			if (!$entity) {
				throw new NotFoundException($this->entityClass." $id not found", $id);
			}
			return $entity;
		}


		public function delete($id) {
			$entity = $this->get($id);
			$this->em->remove($entity);
			$this->em->flush();
		}

		public function all(array $criteria) {
			return $this->getRepository()->getAll($criteria);
		}

		public function count(array $criteria = null) {
			return $this->getRepository()->getCount($criteria);
		}

	}