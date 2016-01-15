<?php

	namespace Uneak\PortoAdminBundle\Event;

	use Symfony\Component\EventDispatcher\Event;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class LayoutEntityFormCompleteEvent extends LayoutEntityEntityEvent {

		protected $redirectUrl;

		public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null, FormInterface $form, $entity) {
			parent::__construct($route, $request, $crudHandler, $form, $entity);
		}


		/**
		 * @return mixed
		 */
		public function getRedirectUrl() {
			return $this->redirectUrl;
		}

		/**
		 * @param mixed $redirectUrl
		 */
		public function setRedirectUrl($redirectUrl) {
			$this->redirectUrl = $redirectUrl;
		}

	}
