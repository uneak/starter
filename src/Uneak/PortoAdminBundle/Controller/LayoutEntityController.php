<?php

	namespace Uneak\PortoAdminBundle\Controller;


	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\EventDispatcher\EventDispatcher;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Event\LayoutEntityEvents;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFlashEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFormCompleteEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFormCreateEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFormEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityFormSubmitEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityGridDatatableEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityGridParamEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityGridParamInitializeEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityInitializeEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityLayoutCreateEvent;
	use Uneak\PortoAdminBundle\Event\LayoutEntityLayoutEvent;
	use Uneak\PortoAdminBundle\PNotify\PNotify;
	use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


	class LayoutEntityController extends Controller {

		/**
		 * @var EventDispatcher
		 */
		protected $dispatcher;

		public function __construct() {
			$this->dispatcher = new EventDispatcher();
		}


//		public function registerEvent($routeName) {
//			ldd($routeName);
//			switch ($routeName) {
//				case 'index':
//					$this->on(LayoutEntityEvents::INITIALIZE, array($this, "_eventInitialize"));
//					$this->on(LayoutEntityEvents::LAYOUT_CREATE, array($this, "_eventLayoutCreate"));
//					$this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, array($this, "_eventLayoutGridInitialize"));
//					break;
//				case 1:
//					echo "i égal 1";
//					break;
//				case 2:
//					echo "i égal 2";
//					break;
//			}
//		}

		/**
		 * alias
		 * @param     $eventName
		 * @param     $listener
		 * @param int $priority
		 *
		 */
		protected function on($eventName, $listener, $clear = false, $priority = 0) {
			if ($clear) {
				$listeners = $this->dispatcher->getListeners($eventName);
				foreach ($listeners as $listene) {
					$this->dispatcher->removeListener($eventName, $listene);
				}
			}

			$this->dispatcher->addListener($eventName, $listener, $priority);
		}



		public function indexAction(FlattenRoute $route, Request $request) {
			$this->on(LayoutEntityEvents::INITIALIZE, array($this, "_eventInitialize"));
			$this->on(LayoutEntityEvents::LAYOUT_CREATE, array($this, "_eventLayoutCreate"));
			$this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, array($this, "_eventLayoutGridInitialize"));
			return $this->_page($route, $request);
		}

		public function showAction(FlattenRoute $route, Request $request) {
			$this->on(LayoutEntityEvents::INITIALIZE, array($this, "_eventInitialize"));
			$this->on(LayoutEntityEvents::LAYOUT_CREATE, array($this, "_eventLayoutCreate"));
			return $this->_page($route, $request);

		}

		public function editAction(FlattenRoute $route, Request $request) {
			$this->on(LayoutEntityEvents::INITIALIZE, array($this, "_eventInitialize"));
			$this->on(LayoutEntityEvents::FORM_CREATE, array($this, "_eventFormCreate"));
			$this->on(LayoutEntityEvents::FORM_INITIALIZE, array($this, "_eventFormEditInitialize"));
			$this->on(LayoutEntityEvents::FORM_SUCCESS, array($this, "_eventFormSuccess"));
			$this->on(LayoutEntityEvents::FLASH_SUCCESS, array($this, "_eventFlashEditSuccess"));
			$this->on(LayoutEntityEvents::FORM_COMPLETE, array($this, "_eventFormEditComplete"));
			//$this->on(LayoutEntityEvents::FORM_ERROR, array($this, "_eventFormError"));
			$this->on(LayoutEntityEvents::FLASH_ERROR, array($this, "_eventFlashError"));
			$this->on(LayoutEntityEvents::LAYOUT_CREATE, array($this, "_eventLayoutCreate"));
			$this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, array($this, "_eventLayoutFormInitialize"));
			return $this->_form($route, $request);
		}

		public function newAction(FlattenRoute $route, Request $request) {
			$this->on(LayoutEntityEvents::INITIALIZE, array($this, "_eventInitialize"));
			$this->on(LayoutEntityEvents::FORM_CREATE, array($this, "_eventFormCreate"));
			$this->on(LayoutEntityEvents::FORM_INITIALIZE, array($this, "_eventFormNewInitialize"));
			$this->on(LayoutEntityEvents::FORM_SUCCESS, array($this, "_eventFormSuccess"));
			$this->on(LayoutEntityEvents::FLASH_SUCCESS, array($this, "_eventFlashNewSuccess"));
			$this->on(LayoutEntityEvents::FORM_COMPLETE, array($this, "_eventFormNewComplete"));
			//$this->on(LayoutEntityEvents::FORM_ERROR, array($this, "_eventFormError"));
			$this->on(LayoutEntityEvents::FLASH_ERROR, array($this, "_eventFlashError"));
			$this->on(LayoutEntityEvents::LAYOUT_CREATE, array($this, "_eventLayoutCreate"));
			$this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, array($this, "_eventLayoutFormInitialize"));
			return $this->_form($route, $request);
		}

		public function deleteAction(FlattenRoute $route, Request $request) {
			$this->on(LayoutEntityEvents::INITIALIZE, array($this, "_eventInitialize"));
			$this->on(LayoutEntityEvents::FORM_CREATE, array($this, "_eventFormDeleteCreate"));
			$this->on(LayoutEntityEvents::FORM_INITIALIZE, array($this, "_eventFormDeleteInitialize"));
			$this->on(LayoutEntityEvents::FORM_SUCCESS, array($this, "_eventFormDeleteSuccess"));
			$this->on(LayoutEntityEvents::FLASH_SUCCESS, array($this, "_eventFlashDeleteSuccess"));
			$this->on(LayoutEntityEvents::FORM_COMPLETE, array($this, "_eventFormNewComplete"));
			//$this->on(LayoutEntityEvents::FORM_ERROR, array($this, "_eventFormError"));
			$this->on(LayoutEntityEvents::FLASH_ERROR, array($this, "_eventFlashError"));
			$this->on(LayoutEntityEvents::LAYOUT_CREATE, array($this, "_eventLayoutCreate"));
			$this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, array($this, "_eventLayoutFormInitialize"));
			return $this->_form($route, $request);
		}


		public function indexGridAction(FlattenRoute $route, Request $request) {
			$this->on(LayoutEntityEvents::INITIALIZE, array($this, "_eventGridInitialize"));
			$this->on(LayoutEntityEvents::GRID_PARAMS_CREATE, array($this, "_eventGridParamsCreate"));
			$this->on(LayoutEntityEvents::GRID_PARAMS_INITIALIZE, array($this, "_eventGridParamsInitialize"));
			$this->on(LayoutEntityEvents::GRID_DATATABLE, array($this, "_eventGridDatatable"));
			return $this->_grid($route, $request);
		}


		protected function _grid(FlattenRoute $route, Request $request) {

			$event = new LayoutEntityInitializeEvent($route, $request);
			$this->dispatcher->dispatch(LayoutEntityEvents::INITIALIZE, $event);
			$route = $event->getRoute();
			$request = $event->getRequest();
			$crudHandler = $event->getCrudHandler();

			$event = new LayoutEntityGridParamEvent($route, $request, $crudHandler);
			$this->dispatcher->dispatch(LayoutEntityEvents::GRID_PARAMS_CREATE, $event);
			$params = $event->getParams();

			$event = new LayoutEntityGridParamInitializeEvent($route, $request, $crudHandler, $params);
			$this->dispatcher->dispatch(LayoutEntityEvents::GRID_PARAMS_INITIALIZE, $event);
			$params = $event->getParams();


			$gridHelper = $this->get("uneak.routesmanager.grid.helper");
			$menuHelper = $this->get("uneak.routesmanager.menu.helper");
			$blockBuilder = $this->get("uneak.blocksmanager.builder");

			$event = new LayoutEntityGridDatatableEvent($route, $request, $crudHandler, $gridHelper, $menuHelper, $blockBuilder, $params);
			$this->dispatcher->dispatch(LayoutEntityEvents::GRID_DATATABLE, $event);
			$datatable = $event->getDatatable();

			return new JsonResponse($datatable);
		}

		protected function _page(FlattenRoute $route, Request $request) {
			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$entity = null;

			$event = new LayoutEntityInitializeEvent($route, $request);
			$this->dispatcher->dispatch(LayoutEntityEvents::INITIALIZE, $event);
			$route = $event->getRoute();
			$request = $event->getRequest();
			$crudHandler = $event->getCrudHandler();


			$event = new LayoutEntityLayoutCreateEvent($route, $request, $crudHandler, $blockBuilder);
			$this->dispatcher->dispatch(LayoutEntityEvents::LAYOUT_CREATE, $event);
			$layout = $event->getLayout();

			$event = new LayoutEntityLayoutEvent($route, $request, $crudHandler, null, null, $blockBuilder, $layout);
			$this->dispatcher->dispatch(LayoutEntityEvents::LAYOUT_INITIALIZE, $event);

			return $blockBuilder->renderResponse("layout");
		}


		protected function _form(FlattenRoute $route, Request $request) {
			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$entity = null;

			$event = new LayoutEntityInitializeEvent($route, $request);
			$this->dispatcher->dispatch(LayoutEntityEvents::INITIALIZE, $event);
			$route = $event->getRoute();
			$request = $event->getRequest();
			$crudHandler = $event->getCrudHandler();


			$event = new LayoutEntityFormCreateEvent($route, $request, $crudHandler);
			$this->dispatcher->dispatch(LayoutEntityEvents::FORM_CREATE, $event);
			/** @var $form FormInterface */
			$form = $event->getForm();

			$event = new LayoutEntityFormEvent($route, $request, $crudHandler, $form);
			$this->dispatcher->dispatch(LayoutEntityEvents::FORM_INITIALIZE, $event);
			$form = $event->getForm();

			if ($request->getMethod() == Request::METHOD_POST) {
				$form->handleRequest($request);

				if ($form->isValid()) {

					$event = new LayoutEntityFormSubmitEvent($route, $request, $crudHandler, $form);
					$this->dispatcher->dispatch(LayoutEntityEvents::FORM_SUCCESS, $event);
					$form = $event->getForm();
					$entity = $event->getEntity();


					$event = new LayoutEntityFlashEvent($route, $request, $crudHandler, $form, $entity);
					$this->dispatcher->dispatch(LayoutEntityEvents::FLASH_SUCCESS, $event);
					$flash = $event->getFlash();

					if ($flash) {
						$this->addFlash($flash['type'], new PNotify($flash));
					}

					$event = new LayoutEntityFormCompleteEvent($route, $request, $crudHandler, $form, $entity);
					$this->dispatcher->dispatch(LayoutEntityEvents::FORM_COMPLETE, $event);
					$redirectUrl = $event->getRedirectUrl();

					if ($redirectUrl) {
						return $this->redirect($redirectUrl);
					}

				} else {

					$event = new LayoutEntityFormSubmitEvent($route, $request, $crudHandler, $form);
					$this->dispatcher->dispatch(LayoutEntityEvents::FORM_ERROR, $event);
					$form = $event->getForm();
					$entity = $event->getEntity();

					$event = new LayoutEntityFlashEvent($route, $request, $crudHandler, $form, $entity);
					$this->dispatcher->dispatch(LayoutEntityEvents::FLASH_ERROR, $event);
					$flash = $event->getFlash();

					if ($flash) {
						$this->addFlash($flash['type'], new PNotify($flash));
					}
				}
			}


			$event = new LayoutEntityLayoutCreateEvent($route, $request, $crudHandler, $blockBuilder);
			$this->dispatcher->dispatch(LayoutEntityEvents::LAYOUT_CREATE, $event);
			$layout = $event->getLayout();

			$event = new LayoutEntityLayoutEvent($route, $request, $crudHandler, $form, $entity, $blockBuilder, $layout);
			$this->dispatcher->dispatch(LayoutEntityEvents::LAYOUT_INITIALIZE, $event);


			return $blockBuilder->renderResponse("layout");
		}




		public function _eventGridDatatable(LayoutEntityGridDatatableEvent $event) {
			$params = $event->getParams();
			$gridHelper = $event->getGridHelper();
			$menuHelper = $event->getMenuHelper();
			$blockBuilder = $event->getBlockBuilder();
			$crudHandler = $event->getCrudHandler();
			$route = $event->getRoute();

			$datatable = $crudHandler->getDatatableArray($route, $params, $gridHelper);
			$crudHandler->addDatatableArrayActions($datatable, $route, $menuHelper, $blockBuilder);
			unset($datatable['id']);

			$event->setDatatable($datatable);
		}


		public function _eventGridParamsCreate(LayoutEntityGridParamEvent $event) {
			$request = $event->getRequest();
			$params = $request->request->all();
			$event->setParams($params);
		}

		public function _eventGridParamsInitialize(LayoutEntityGridParamInitializeEvent $event) {
			$params = $event->getParams();

			// convert datatable param
			if (isset($params['order'])) {
				$pOrder = array();
				foreach ($params['order'] as $order) {
					$plOrder = '';
					$plOrder .= ($order['dir'] == 'asc') ? '+' : '-';
					$plOrder .= $params['columns'][$order['column']]['name'];
					$pOrder[] = $plOrder;
				}
				$params['sort'] = join(',', $pOrder);
			}

			if (isset($params['start'])) {
				$params['offset'] = $params['start'];
			}

			if (isset($params['length'])) {
				$params['limit'] = $params['length'];
			}

			$event->setParams($params);
		}
		

		public function _eventLayoutGridInitialize(LayoutEntityLayoutEvent $event) {
			$route = $event->getRoute();
			$layout = $event->getLayout();
			$layout->buildGridPage($route);
		}


		public function _eventLayoutFormInitialize(LayoutEntityLayoutEvent $event) {
			$route = $event->getRoute();
			$form = $event->getForm();
			$layout = $event->getLayout();

			$formsManager = $this->get('uneak.formsmanager');
			$formView = $formsManager->createView($form);
			$layout->buildFormPage($formView, $route->getMetaData('_label'));
		}

		public function _eventLayoutCreate(LayoutEntityLayoutCreateEvent $event) {
			$blockBuilder = $event->getBlockBuilder();
			$route = $event->getRoute();
			$blockBuilder->addBlock("layout", "block_main_interface");
			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);

			$event->setLayout($layout);
		}


		public function _eventGridInitialize(LayoutEntityInitializeEvent $event) {
			$crudHandler = $event->getRoute()->getCRUD()->getHandler();
			$event->setCrudHandler($crudHandler);
		}

		public function _eventInitialize(LayoutEntityInitializeEvent $event) {
			$crudHandler = $event->getRoute()->getHandler();
			$event->setCrudHandler($crudHandler);
		}

		public function _eventFormCreate(LayoutEntityFormCreateEvent $event) {
			$crudHandler = $event->getCrudHandler();
			$route = $event->getRoute();
			$form = $crudHandler->getForm($route, Request::METHOD_POST);
			$event->setForm($form);
		}

		public function _eventFormDeleteCreate(LayoutEntityFormEvent $event) {
			$route = $event->getRoute();
			$form = $this->createForm($route->getFormType(), array('confirm' => false));
			$event->setForm($form);
		}

		public function _eventFormDeleteInitialize(LayoutEntityFormEvent $event) {
			$form = $event->getForm();
			$form->add('submit', 'submit', array('label' => 'Confirmer'));
		}

		public function _eventFormEditInitialize(LayoutEntityFormEvent $event) {
			$form = $event->getForm();
			$form->add('submit', 'submit', array('label' => 'Modifier'));
		}

		public function _eventFormNewInitialize(LayoutEntityFormEvent $event) {
			$form = $event->getForm();
			$form->add('submit', 'submit', array('label' => 'Créer'));
		}

		public function _eventFormSuccess(LayoutEntityFormSubmitEvent $event) {
			$form = $event->getForm();
			$crudHandler = $event->getCrudHandler();
			$entity = $crudHandler->persistEntity($form);
			$event->setEntity($entity);
		}

		public function _eventFormDeleteSuccess(LayoutEntityFormSubmitEvent $event) {
			$form = $event->getForm();
			$crudHandler = $event->getCrudHandler();
			$route = $event->getRoute();
			$entityRoute = $route;
			while ($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
				$entityRoute = $entityRoute->getParent();
			}
			$entity = $crudHandler->deleteEntity($form, $entityRoute->getParameterSubject());
			$event->setEntity($entity);
		}

		public function _eventFormEditComplete(LayoutEntityFormCompleteEvent $event) {
			$route = $event->getRoute();
			$entityRoute = $route;
			while ($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
				$entityRoute = $entityRoute->getParent();
			}
			$redirectRoute = $entityRoute->getChild('show');
			$url = ($redirectRoute) ? $redirectRoute->getRoutePath() : null;
			$event->setRedirectUrl($url);
		}

		public function _eventFormNewComplete(LayoutEntityFormCompleteEvent $event) {
			$route = $event->getRoute();
			$redirectRoute = $route->getChild('*/index');
			$url = ($redirectRoute) ? $redirectRoute->getRoutePath() : null;
			$event->setRedirectUrl($url);
		}

		public function _eventFlashEditSuccess(LayoutEntityFlashEvent $event) {
			$flash = array(
				'type'   => 'info',
				'title'  => 'Formulaire',
				'text'   => 'L\'édition a été réalisé avec succes',
				'shadow' => true,
				'stack'  => 'stack-bar-bottom',
				'icon'   => 'fa fa-' . $event->getRoute()->getMetaData('_icon')
			);
			$event->setFlash($flash);
		}

		public function _eventFlashNewSuccess(LayoutEntityFlashEvent $event) {
			$flash = array(
				'type'   => 'info',
				'title'  => 'Formulaire',
				'text'   => 'La création a été réalisé avec succes',
				'shadow' => true,
				'stack'  => 'stack-bar-bottom',
				'icon'   => 'fa fa-' . $event->getRoute()->getMetaData('_icon')
			);
			$event->setFlash($flash);
		}

		public function _eventFlashDeleteSuccess(LayoutEntityFlashEvent $event) {
			$flash = array(
				'type'   => 'info',
				'title'  => 'Formulaire',
				'text'   => 'La suppression a été réalisé avec succes',
				'shadow' => true,
				'stack'  => 'stack-bar-bottom',
				'icon'   => 'fa fa-' . $event->getRoute()->getMetaData('_icon')
			);
			$event->setFlash($flash);
		}

		public function _eventFlashError(LayoutEntityFlashEvent $event) {
			$flash = array(
				'type'   => 'error',
				'title'  => 'Formulaire',
				'text'   => 'Votre formulaire est invalide.',
				'shadow' => true,
				'stack'  => 'stack-bar-bottom'
				//				'icon' => 'fa fa-twitter'
			);
			$event->setFlash($flash);
		}





	}
