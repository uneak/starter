<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class LayoutEntityInitializeEvent extends LayoutEntityActionEvent {

		/** @var CRUDHandler */
		protected $crudHandler;

		public function __construct(FlattenRoute $route, Request $request = null) {
			parent::__construct($route, $request);
		}

		/**
		 * @param FlattenRoute $route
		 */
		public function setRoute($route) {
			$this->route = $route;
		}

		/**
		 * @param Request $request
		 */
		public function setRequest($request) {
			$this->request = $request;
		}


		/**
		 * @param CRUDHandler $crudHandler
		 */
		public function setCrudHandler($crudHandler) {
			$this->crudHandler = $crudHandler;
		}

		/**
		 * @return CRUDHandler
		 */
		public function getCrudHandler() {
			return $this->crudHandler;
		}


	}
