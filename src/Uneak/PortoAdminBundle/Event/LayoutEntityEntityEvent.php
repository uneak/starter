<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class LayoutEntityEntityEvent extends LayoutEntityFormEvent {

		protected $entity;

		public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, FormInterface $form = null, $entity = null) {
			parent::__construct($route, $request, $crudHandler, $form);
			$this->entity = $entity;
		}

		/**
		 * @return mixed
		 */
		public function getEntity() {
			return $this->entity;
		}

	}
