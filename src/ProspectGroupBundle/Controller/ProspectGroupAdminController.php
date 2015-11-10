<?php

	namespace ProspectGroupBundle\Controller;

	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
	use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
	use Uneak\PortoAdminBundle\PNotify\PNotify;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


    class ProspectGroupAdminController extends LayoutEntityController {





		public function prospectsIndexAction(FlattenRoute $route) {
			$blockBuilder = $this->get("uneak.blocksmanager.builder");
			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);
			$layout->buildGridPage($route);

			return $blockBuilder->renderResponse("layout");
		}


		public function prospectsNewAction(FlattenRoute $route, Request $request) {
			$crudHandler = $route->getHandler();
			$blockBuilder = $this->get("uneak.blocksmanager.builder");

			$blockBuilder->addBlock("layout", "block_main_interface");

			$layout = $this->get("uneak.admin.page.entity.layout");
			$layout->setLayout($blockBuilder->getBlock("layout"));
			$layout->buildEntityLayout($route);


			$form = $crudHandler->getProspectForm($route, Request::METHOD_POST);
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




		public function prospectsIndexGridAction(FlattenRoute $route, Request $request) {

			$group = $route->getParameter('groups')->getParameterSubject()->getId();

			$nestedGridRoute = $route->getParent()->getNestedRoute();
			$rowActions = $nestedGridRoute->getRowActions();
			$ids = $nestedGridRoute->getIds();


			$crudHandler = $route->getCRUD()->getHandler();
			$gridHelper = $this->get("uneak.routesmanager.grid.helper");
			$menuHelper = $this->get("uneak.routesmanager.menu.helper");
			$blockBuilder = $this->get("uneak.blocksmanager.builder");

			$params = $request->query->all();

			$datatableArray = $crudHandler->getProspectDatatableArray($group, $ids, $params, $gridHelper);

			for($i = 0; $i < count($datatableArray['data']); $i++) {

				$menu = new Menu();
				$menu->setTemplateAlias("block_template_grid_actions_menu");
				$root = $menuHelper->createMenu($rowActions, $route, $datatableArray['id'][$i]);
				$menu->setRoot($root);
				$blockBuilder->addBlock("row_actions", $menu);
				$datatableArray['data'][$i]['_actions'] = $this->renderView("<div class='menu-bullets'>{{ renderBlock('row_actions') }}</div>");
			}

			unset($datatableArray['id']);
			return new JsonResponse($datatableArray);

		}
		
		
	}
