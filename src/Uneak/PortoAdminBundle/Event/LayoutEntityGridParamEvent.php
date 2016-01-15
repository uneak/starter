<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class LayoutEntityGridParamEvent extends LayoutEntityHandlerEvent {

		/**
		 * @var array
		 */
		protected $params;

		public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null) {
			parent::__construct($route, $request, $crudHandler);
		}

		/**
		 * @return array
		 */
		public function getParams() {
			return $this->params;
		}

		/**
		 * @param array $params
		 */
		public function setParams($params) {
			$this->params = $params;
		}

	}
