<?php

	namespace ProspectGroupBundle\Controller;

	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\PortoAdminBundle\Event\LayoutCrudBuildEvent;
    use Uneak\PortoAdminBundle\Event\LayoutCrudCompletedFormEvent;
    use Uneak\PortoAdminBundle\Event\LayoutCrudEvents;
    use Uneak\PortoAdminBundle\Event\LayoutCrudFormEvent;
    use Uneak\PortoAdminBundle\Event\LayoutCrudInitializeEvent;
    use Uneak\PortoAdminBundle\PNotify\PNotify;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


    class ProspectGroupAdminController extends LayoutEntityController {


        //
        // FIELDS
        //
        public function fieldsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:index', array('route' => $route->getParameter('groups')->getChild('fields/index'), 'request' => $request));
        }

        public function fieldsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:new', array('route' => $route->getParameter('groups')->getChild('fields/new'), 'request' => $request));
        }

        public function fieldsShowAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:show', array('route' => $route->getParameter('fields')->getChild('show'), 'request' => $request));
        }

        public function fieldsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:edit', array('route' => $route->getParameter('fields')->getChild('edit'), 'request' => $request));
        }

        public function fieldsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:delete', array('route' => $route->getParameter('fields')->getChild('delete'), 'request' => $request));
        }

        public function fieldsConfigAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:config', array('route' => $route->getParameter('fields')->getChild('config'), 'request' => $request));
        }

        //
        // FIELDS / CONSTRAINTS
        //
        public function fieldsConstraintsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:constraintsIndex', array('route' => $route->getParameter('fields')->getChild('constraints/index'), 'request' => $request));
        }
        public function fieldsConstraintsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:constraintsNew', array('route' => $route->getParameter('fields')->getChild('constraints/new'), 'request' => $request));
        }
        public function fieldsConstraintsTypenewAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectGroupFieldBundle:ProspectGroupFieldAdmin:constraintsTypenew', array('route' => $route->getParameter('typeconstraint')->getChild('new'), 'request' => $request));
        }






        //
        // PROSPECTS
        //
        public function prospectsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectBundle:ProspectAdmin:index', array('route' => $route->getParameter('groups')->getChild('prospects/index'), 'request' => $request));
        }

        public function prospectsIndexGridAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectBundle:ProspectAdmin:indexGrid', array('route' => $route->getParameter('groups')->getChild('prospects/index/_grid'), 'request' => $request));
        }

        public function prospectsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectBundle:ProspectAdmin:new', array('route' => $route->getParameter('groups')->getChild('prospects/new'), 'request' => $request));
        }

        public function prospectsShowAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectBundle:ProspectAdmin:show', array('route' => $route->getParameter('prospects')->getChild('show'), 'request' => $request));
        }

        public function prospectsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectBundle:ProspectAdmin:edit', array('route' => $route->getParameter('prospects')->getChild('edit'), 'request' => $request));
        }

        public function prospectsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('ProspectBundle:ProspectAdmin:delete', array('route' => $route->getParameter('prospects')->getChild('delete'), 'request' => $request));
        }






        public function editAction(FlattenRoute $route, Request $request) {

//            $this->dispatcher->addListener(LayoutCrudEvents::INITIALIZE, function (LayoutCrudInitializeEvent $event) {
//                $event->setCrudHandler(null);
//            });

//            $this->dispatcher->addListener(LayoutCrudEvents::FORM_INITIALIZE, function (LayoutCrudFormEvent $event) {
//                $form = $event->getForm();
//                $form->add('submit2', 'submit', array('label' => 'YEP Modifier'));
//            });
//
//            $this->dispatcher->addListener(LayoutCrudEvents::FORM_COMPLETE, function (LayoutCrudCompletedFormEvent $event) {
//                $url = $event->getRedirectUrl();
//                $event->setRedirectUrl($url);
//            });
//
//            $this->dispatcher->addListener(LayoutCrudEvents::LAYOUT_BUILD, function (LayoutCrudBuildEvent $event) {
//                $layout = $event->getLayout();
//            });


            return parent::editAction($route, $request);
        }


//
//
//		public function prospectsIndexAction(FlattenRoute $route) {
//			$blockBuilder = $this->get("uneak.blocksmanager.builder");
//			$blockBuilder->addBlock("layout", "block_main_interface");
//
//			$layout = $this->get("uneak.admin.page.entity.layout");
//			$layout->setLayout($blockBuilder->getBlock("layout"));
//			$layout->buildEntityLayout($route);
//			$layout->buildGridPage($route);
//
//			return $blockBuilder->renderResponse("layout");
//		}
//
//
//		public function prospectsNewAction(FlattenRoute $route, Request $request) {
//			$crudHandler = $route->getHandler();
//			$blockBuilder = $this->get("uneak.blocksmanager.builder");
//
//			$blockBuilder->addBlock("layout", "block_main_interface");
//
//			$layout = $this->get("uneak.admin.page.entity.layout");
//			$layout->setLayout($blockBuilder->getBlock("layout"));
//			$layout->buildEntityLayout($route);
//
//
//			$form = $crudHandler->getProspectForm($route, Request::METHOD_POST);
//			$form->add('submit', 'submit', array('label' => 'Créer'));
//
//
//			$formsManager = $this->get('uneak.formsmanager');
//			$formView = $formsManager->createView($form);
//
//			$layout->buildFormPage($formView, $route->getMetaData('_label'));
//
//			if ($request->getMethod() == Request::METHOD_POST) {
//				$form->handleRequest($request);
//				if ($form->isValid()) {
//
//					$crudHandler->persistEntity($form);
//
//
//					$this->addFlash('info', new PNotify(array(
//						'type' => 'info',
//						'title' => 'Formulaire',
//						'text' => 'La création a été réalisé avec succes',
//						'shadow' => true,
//						'stack' => 'stack-bar-bottom',
//						'icon' => 'fa fa-'.$route->getMetaData('_icon')
//					)));
//
//
//					return $this->redirect($route->getChild('*/index')->getRoutePath());
//				} else {
//					$this->addFlash('error', new PNotify(array(
//						'type' => 'error',
//						'title' => 'Formulaire',
//						'text' => 'Votre formulaire est invalide.',
//						'shadow' => true,
//						'stack' => 'stack-bar-bottom'
//						//				'icon' => 'fa fa-twitter'
//					)));
//				}
//			}
//
//
//			return $blockBuilder->renderResponse("layout");
//		}
//

//
//
//
//
//
//		public function prospectsIndexGridAction(FlattenRoute $route, Request $request) {
//
//            if ($route->hasParameter('clients')) {
//                $client = $route->getParameter('clients')->getParameterSubject()->getId();
//            } else {
//                $client = null;
//            }
//
//            if ($route->hasParameter('groups')) {
//                $group = $route->getParameter('groups')->getParameterSubject()->getId();
//            } else {
//                $group = null;
//            }
//
//
//			$nestedGridRoute = $route->getParent()->getNestedRoute();
//			$rowActions = $nestedGridRoute->getRowActions();
//			$ids = $nestedGridRoute->getIds();
//
//
//			$crudHandler = $route->getCRUD()->getHandler();
//			$gridHelper = $this->get("uneak.routesmanager.grid.helper");
//			$menuHelper = $this->get("uneak.routesmanager.menu.helper");
//			$blockBuilder = $this->get("uneak.blocksmanager.builder");
//
//			$params = $request->query->all();
//
//			$datatableArray = $crudHandler->getProspectDatatableArray($client, $group, $ids, $params, $gridHelper);
//
//			for($i = 0; $i < count($datatableArray['data']); $i++) {
//
//				$menu = new Menu();
//				$menu->setTemplateAlias("block_template_grid_actions_menu");
//				$root = $menuHelper->createMenu($rowActions, $route, $datatableArray['id'][$i]);
//				$menu->setRoot($root);
//				$blockBuilder->addBlock("row_actions", $menu);
//				$datatableArray['data'][$i]['_actions'] = $this->renderView("<div class='menu-bullets'>{{ renderBlock('row_actions') }}</div>");
//			}
//
//			unset($datatableArray['id']);
//			return new JsonResponse($datatableArray);
//
//		}
//
		
	}
