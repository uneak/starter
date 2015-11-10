<?php

	namespace Uneak\PortoAdminBundle\Controller;


    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\PNotify\PNotify;
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

            return $blockBuilder->renderResponse("layout");
        }

        public function showAction(FlattenRoute $route) {

            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            return $blockBuilder->renderResponse("layout");

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

            $formsManager = $this->get('uneak.formsmanager');
            $formView = $formsManager->createView($form);

            $layout->buildFormPage($formView, $route->getMetaData('_label'));

            $entityRoute = $route;
            while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                $entityRoute = $entityRoute->getParent();
            }





            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $crudHandler->persistEntity($form);

                    $this->addFlash('info', new PNotify(array(
                        'type' => 'info',
                        'title' => 'Formulaire',
                        'text' => 'L\'édition a été réalisé avec succes',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom',
                        'icon' => 'fa fa-'.$route->getMetaData('_icon')
                    )));


                    return $this->redirect($entityRoute->getChild('show')->getRoutePath());
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

        public function newAction(FlattenRoute $route, Request $request) {
            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");

            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $crudHandler->getForm($route, Request::METHOD_POST);
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

        public function deleteAction(FlattenRoute $route, Request $request) {
            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");

            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $this->createForm($route->getFormType(), array('confirm' => false));
            $form->add('submit', 'submit', array('label' => 'Confirmer'));

            $formsManager = $this->get('uneak.formsmanager');
            $formView = $formsManager->createView($form);

            $layout->buildFormPage($formView, $route->getMetaData('_label'));

            $entityRoute = $route;
            while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                $entityRoute = $entityRoute->getParent();
            }

            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $crudHandler->deleteEntity($form, $entityRoute->getParameterSubject());

                    $this->addFlash('info', new PNotify(array(
                        'type' => 'info',
                        'title' => 'Formulaire',
                        'text' => 'La suppression a été réalisé avec succes',
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
                    )));
                }
            }


            return $blockBuilder->renderResponse("layout");
        }

        public function indexGridAction(FlattenRoute $route, Request $request) {

            $crudHandler = $route->getCRUD()->getHandler();
            $gridHelper = $this->get("uneak.routesmanager.grid.helper");
            $menuHelper = $this->get("uneak.routesmanager.menu.helper");
            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $params = $request->query->all();

            $datatableArray = $crudHandler->getDatatableArray($route, $params, $gridHelper);
            $crudHandler->addDatatableArrayActions($datatableArray, $route, $menuHelper, $blockBuilder);

            unset($datatableArray['id']);
            return new JsonResponse($datatableArray);

        }




    }
