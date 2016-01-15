<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	abstract class LayoutEntityActionEvent extends Event {

		/**
		 * @var FlattenRoute
		 */
		protected $route;
		/**
		 * @var Request
		 */
		protected $request;

		public function __construct(FlattenRoute $route, Request $request = null) {
			$this->route = $route;
			$this->request = $request;
		}

		/**
		 * @return FlattenRoute
		 */
		public function getRoute() {
			return $this->route;
		}

		/**
		 * @return Request
		 */
		public function getRequest() {
			return $this->request;
		}


	}
