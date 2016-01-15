<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class LayoutEntityFlashEvent extends LayoutEntityEntityEvent {

		/**
		 * @var array
		 */
		protected $flash = null;

		public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, FormInterface $form, $entity) {
			parent::__construct($route, $request, $crudHandler, $form, $entity);
		}


		/**
		 * @param array $flash
		 */
		public function setFlash($flash) {
			$this->flash = $flash;
		}

		/**
		 * @return array
		 */
		public function getFlash() {
			return $this->flash;
		}


	}
