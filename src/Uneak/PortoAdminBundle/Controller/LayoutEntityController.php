<?php

	namespace Uneak\PortoAdminBundle\Controller;


    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Doctrine\ORM\Query\Expr;


    class LayoutEntityController extends Controller {

        public function indexAction(FlattenRoute $route) {
            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);
            $layout->buildGridPage($route);

            return $blockBuilder->render("layout");
        }

        public function showAction(FlattenRoute $route) {

            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            return $blockBuilder->render("layout");

        }

        public function editAction(FlattenRoute $route, Request $request) {
            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");

            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $crudHandler->getForm($route, Request::METHOD_POST);
            $form->add('submit', 'submit', array('label' => 'Modifier'));

            $layout->buildFormPage($form, $route->getMetaData('_label'));

            $entityRoute = $route;
            while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                $entityRoute = $entityRoute->getParent();
            }

            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $crudHandler->persistEntity($form);
                    return $this->redirect($entityRoute->getChild('show')->getRoutePath());
                } else {
                    $this->addFlash('error', 'Votre formulaire est invalide.');
                }
            }


            return $blockBuilder->render("layout");
        }

        public function newAction(FlattenRoute $route, Request $request) {
            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");

            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $crudHandler->getForm($route, Request::METHOD_POST);
            $form->add('submit', 'submit', array('label' => 'Créer'));

            $layout->buildFormPage($form, $route->getMetaData('_label'));

            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $crudHandler->persistEntity($form);

                    return $this->redirect($route->getChild('*/index')->getRoutePath());
                } else {
                    $this->addFlash('error', 'Votre formulaire est invalide.');
                }
            }


            return $blockBuilder->render("layout");
        }



        public function indexGridAction(FlattenRoute $route, Request $request) {

            $crudHandler = $route->getCRUD()->getHandler();
            $gridHelper = $this->get("uneak.routesmanager.grid.helper");
            $menuHelper = $this->get("uneak.routesmanager.menu.helper");
            $blockBuilder = $this->get("uneak.blocksmanager.builder");

            $entityClass = $route->getCRUD()->getEntity();
            $params = $request->query->all();

            $datatableArray = $crudHandler->getDatatableArray($entityClass, $params, $gridHelper);

            for($i = 0; $i < count($datatableArray['data']); $i++) {
                $id = $datatableArray['data'][$i]['DT_RowId'];

                $menu = new Menu();
                $menu->setTemplateAlias("block_template_grid_actions_menu");
                $rowActions = $route->getParent()->getNestedRoute()->getRowActions();
                $root = $menuHelper->createMenu($rowActions, $route, array($id));
                $menu->setRoot($root);
                $blockBuilder->addBlock("row_actions", $menu);
                $datatableArray['data'][$i]['_actions'] = $this->renderView("<div class='menu-bullets'>{{ renderBlock('row_actions') }}</div>");
            }

            return new JsonResponse($datatableArray);

        }




    }
