<?php

	namespace ClientBundle\Controller;

    use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
	use Uneak\PortoAdminBundle\PNotify\PNotify;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ClientAdminController extends LayoutEntityController {


		public function campaignsIndexAction(FlattenRoute $route) {
			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);
			$layout->buildGridPage($route);

			return $blockBuilder->renderResponse("layout");
		}


		public function campaignsNewAction(FlattenRoute $route, Request $request) {
			$crudHandler = $route->getHandler();
			$blockBuilder = $this->get("uneak.blocksmanager.builder");

			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);


			$form = $crudHandler->getCampaignForm($route, Request::METHOD_POST);
			$form->add('submit', 'submit', array('label' => 'Créer'));


			$formsManager = $this->get('uneak.formsmanager');
			$formView = $formsManager->createView($form);

			$layout->buildFormPage($formView, $route->getMetaData('_label'));

			if ($request->getMethod() == Request::METHOD_POST) {
				$form->handleRequest($request);
				if ($form->isValid()) {

					$crudHandler->persistEntity($form);


					$this->addFlash('info', new PNotify(array(
						'type' => 'info',
						'title' => 'Formulaire',
						'text' => 'La création a été réalisé avec succes',
						'shadow' => true,
						'stack' => 'stack-bar-bottom',
						'icon' => 'fa fa-'.$route->getMetaData('_icon')
					)));


					return $this->redirect($route->getChild('*/index')->getRoutePath());
				} else {
					$this->addFlash('error', new PNotify(array(
						'type' => 'error',
						'title' => 'Formulaire',
						'text' => 'Votre formulaire est invalide.',
						'shadow' => true,
						'stack' => 'stack-bar-bottom'
						//				'icon' => 'fa fa-twitter'
					)));
				}
			}


			return $blockBuilder->renderResponse("layout");
		}




		public function campaignsIndexGridAction(FlattenRoute $route, Request $request) {

			$crudHandler = $route->getCRUD()->getHandler();
			$gridHelper = $this->get("uneak.routesmanager.grid.helper");
			$menuHelper = $this->get("uneak.routesmanager.menu.helper");
			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$params = $request->query->all();

			$datatableArray = $crudHandler->getCampaignDatatableArray($route, $params, $gridHelper);
			$crudHandler->addDatatableArrayActions($datatableArray, $route, $menuHelper, $blockBuilder);

			unset($datatableArray['id']);
			return new JsonResponse($datatableArray);

		}









		public function groupsIndexAction(FlattenRoute $route) {
			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);
			$layout->buildGridPage($route);

			return $blockBuilder->renderResponse("layout");
		}


		public function groupsNewAction(FlattenRoute $route, Request $request) {
			$crudHandler = $route->getHandler();
			$blockBuilder = $this->get("uneak.blocksmanager.builder");

			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);


			$form = $crudHandler->getProspectGroupForm($route, Request::METHOD_POST);
			$form->add('submit', 'submit', array('label' => 'Créer'));


			$formsManager = $this->get('uneak.formsmanager');
			$formView = $formsManager->createView($form);

			$layout->buildFormPage($formView, $route->getMetaData('_label'));

			if ($request->getMethod() == Request::METHOD_POST) {
				$form->handleRequest($request);
				if ($form->isValid()) {

					$crudHandler->persistEntity($form);


					$this->addFlash('info', new PNotify(array(
						'type' => 'info',
						'title' => 'Formulaire',
						'text' => 'La création a été réalisé avec succes',
						'shadow' => true,
						'stack' => 'stack-bar-bottom',
						'icon' => 'fa fa-'.$route->getMetaData('_icon')
					)));


					return $this->redirect($route->getChild('*/index')->getRoutePath());
				} else {
					$this->addFlash('error', new PNotify(array(
						'type' => 'error',
						'title' => 'Formulaire',
						'text' => 'Votre formulaire est invalide.',
						'shadow' => true,
						'stack' => 'stack-bar-bottom'
						//				'icon' => 'fa fa-twitter'
					)));
				}
			}


			return $blockBuilder->renderResponse("layout");
		}


		public function groupsShowAction(FlattenRoute $route, Request $request) {
			return $this->forward('ProspectGroupBundle:ProspectGroupAdmin:show', array('route' => $route->getParameter('groups')->getChild('show'), 'request' => $request));
		}

		public function groupsEditAction(FlattenRoute $route, Request $request) {
			return $this->forward('ProspectGroupBundle:ProspectGroupAdmin:edit', array('route' => $route->getParameter('groups')->getChild('edit'), 'request' => $request));
		}

		public function groupsDeleteAction(FlattenRoute $route, Request $request) {
			return $this->forward('ProspectGroupBundle:ProspectGroupAdmin:delete', array('route' => $route->getParameter('groups')->getChild('delete'), 'request' => $request));
		}

		public function groupsProspectsIndexAction(FlattenRoute $route, Request $request) {
			return $this->forward('ProspectGroupBundle:ProspectGroupAdmin:prospectsIndex', array('route' => $route->getParameter('groups')->getChild('prospects/index'), 'request' => $request));
		}

		public function groupsProspectsShowAction(FlattenRoute $route, Request $request) {
			return $this->forward('ProspectBundle:ProspectAdmin:show', array('route' => $route->getParameter('prospects')->getChild('show'), 'request' => $request));
		}

		public function groupsProspectsEditAction(FlattenRoute $route, Request $request) {
			return $this->forward('ProspectBundle:ProspectAdmin:edit', array('route' => $route->getParameter('prospects')->getChild('edit'), 'request' => $request));
		}

		public function groupsProspectsDeleteAction(FlattenRoute $route, Request $request) {
			return $this->forward('ProspectBundle:ProspectAdmin:delete', array('route' => $route->getParameter('prospects')->getChild('delete'), 'request' => $request));
		}

		public function groupsProspectsIndexGridAction(FlattenRoute $route, Request $request) {
			return $this->forward('ProspectGroupBundle:ProspectGroupAdmin:prospectsIndexGrid', array('route' => $route->getParameter('groups')->getChild('prospects/index/_grid'), 'request' => $request));
		}




		public function groupsIndexGridAction(FlattenRoute $route, Request $request) {

			$crudHandler = $route->getCRUD()->getHandler();
			$gridHelper = $this->get("uneak.routesmanager.grid.helper");
			$menuHelper = $this->get("uneak.routesmanager.menu.helper");
			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$params = $request->query->all();

			$datatableArray = $crudHandler->getProspectGroupDatatableArray($route, $params, $gridHelper);
			$crudHandler->addDatatableArrayActions($datatableArray, $route, $menuHelper, $blockBuilder);

			unset($datatableArray['id']);
			return new JsonResponse($datatableArray);


		}
	}
