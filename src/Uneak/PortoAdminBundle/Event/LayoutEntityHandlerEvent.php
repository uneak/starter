<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	abstract class LayoutEntityHandlerEvent extends LayoutEntityActionEvent {

		/** @var CRUDHandler */
		protected $crudHandler;

		public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null) {
			parent::__construct($route, $request);
			$this->crudHandler = $crudHandler;
		}

		/**
		 * @return CRUDHandler
		 */
		public function getCrudHandler() {
			return $this->crudHandler;
		}


	}
