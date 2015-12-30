<?php

	namespace Uneak\PortoAdminBundle\Controller;


    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\EventDispatcher\EventDispatcher;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Event\LayoutCrudBuildEvent;
    use Uneak\PortoAdminBundle\Event\LayoutCrudCompletedFormEvent;
    use Uneak\PortoAdminBundle\Event\LayoutCrudEvents;
    use Uneak\PortoAdminBundle\Event\LayoutCrudFormEvent;
    use Uneak\PortoAdminBundle\Event\LayoutCrudInitializeEvent;
    use Uneak\PortoAdminBundle\Event\LayoutCrudSubmittedFormEvent;
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



        public function indexAction(FlattenRoute $route) {

            //
            $event = new LayoutCrudInitializeEvent($route, null, null);
            $this->dispatcher->dispatch(LayoutCrudEvents::INITIALIZE, $event);
            $route = $event->getRoute();
            //

            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);
            $layout->buildGridPage($route);

            //
            $event = new LayoutCrudBuildEvent($route, null, null, $layout);
            $this->dispatcher->dispatch(LayoutCrudEvents::LAYOUT_BUILD, $event);
            //


            return $blockBuilder->renderResponse("layout");
        }

        public function showAction(FlattenRoute $route) {

            //
            $event = new LayoutCrudInitializeEvent($route, null, null);
            $this->dispatcher->dispatch(LayoutCrudEvents::INITIALIZE, $event);
            $route = $event->getRoute();
            //


            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            //
            $event = new LayoutCrudBuildEvent($route, null, null, $layout);
            $this->dispatcher->dispatch(LayoutCrudEvents::LAYOUT_BUILD, $event);
            //

            return $blockBuilder->renderResponse("layout");

        }




        public function editAction(FlattenRoute $route, Request $request) {

            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");


            //
            $event = new LayoutCrudInitializeEvent($route, $request, $crudHandler);
            $this->dispatcher->dispatch(LayoutCrudEvents::INITIALIZE, $event);
            $route = $event->getRoute();
            $request = $event->getRequest();
            $crudHandler = $event->getCrudHandler();
            //


            $blockBuilder->addBlock("layout", "block_main_interface");
            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $crudHandler->getForm($route, Request::METHOD_POST);
            $form->add('submit', 'submit', array('label' => 'Modifier'));


            //
            $event = new LayoutCrudFormEvent($route, $request, $crudHandler, $form);
            $this->dispatcher->dispatch(LayoutCrudEvents::FORM_INITIALIZE, $event);
            $form = $event->getForm();
            //


            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);

                if ($form->isValid()) {

                    $flash = array(
                        'type' => 'info',
                        'title' => 'Formulaire',
                        'text' => 'L\'édition a été réalisé avec succes',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom',
                        'icon' => 'fa fa-'.$route->getMetaData('_icon')
                    );

                    //
                    $event = new LayoutCrudSubmittedFormEvent($route, $request, $crudHandler, $form, $flash);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_SUCCESS, $event);
                    $form = $event->getForm();
                    $flash = $event->getFlash();
                    //

                    $crudHandler->persistEntity($form);
                    $this->addFlash($flash['type'], new PNotify($flash));


                    $entityRoute = $route;
                    while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                        $entityRoute = $entityRoute->getParent();
                    }
                    $redirectRoute = $entityRoute->getChild('show');
                    $url = ($redirectRoute) ? $redirectRoute->getRoutePath() : null;
                    

                    //
                    $event = new LayoutCrudCompletedFormEvent($route, $request, $crudHandler, $form, $url);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_COMPLETE, $event);
                    $url = $event->getRedirectUrl();
                    //

                    if ($url) {
                        return $this->redirect($url);
                    }
                    


                } else {

                    $flash = array(
                        'type' => 'error',
                        'title' => 'Formulaire',
                        'text' => 'Votre formulaire est invalide.',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom'
                        //				'icon' => 'fa fa-twitter'
                    );

                    //
                    $event = new LayoutCrudSubmittedFormEvent($route, $request, $crudHandler, $form, $flash);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_ERROR, $event);
                    $flash = $event->getFlash();
                    //

                    $this->addFlash($flash['type'], new PNotify($flash));
                }
            }


            $formsManager = $this->get('uneak.formsmanager');
            $formView = $formsManager->createView($form);
            $layout->buildFormPage($formView, $route->getMetaData('_label'));

            //
            $event = new LayoutCrudBuildEvent($route, null, null, $layout);
            $this->dispatcher->dispatch(LayoutCrudEvents::LAYOUT_BUILD, $event);
            //

            return $blockBuilder->renderResponse("layout");
        }

        public function newAction(FlattenRoute $route, Request $request) {

            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");


            //
            $event = new LayoutCrudInitializeEvent($route, $request, $crudHandler);
            $this->dispatcher->dispatch(LayoutCrudEvents::INITIALIZE, $event);
            $route = $event->getRoute();
            $request = $event->getRequest();
            $crudHandler = $event->getCrudHandler();
            //


            $blockBuilder->addBlock("layout", "block_main_interface");
            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $crudHandler->getForm($route, Request::METHOD_POST);
            $form->add('submit', 'submit', array('label' => 'Créer'));


            //
            $event = new LayoutCrudFormEvent($route, $request, $crudHandler, $form);
            $this->dispatcher->dispatch(LayoutCrudEvents::FORM_INITIALIZE, $event);
            $form = $event->getForm();
            //


            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $flash = array(
                        'type' => 'info',
                        'title' => 'Formulaire',
                        'text' => 'La création a été réalisé avec succes',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom',
                        'icon' => 'fa fa-'.$route->getMetaData('_icon')
                    );

                    //
                    $event = new LayoutCrudSubmittedFormEvent($route, $request, $crudHandler, $form, $flash);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_SUCCESS, $event);
                    $form = $event->getForm();
                    $flash = $event->getFlash();
                    //

                    $crudHandler->persistEntity($form);
                    $this->addFlash($flash['type'], new PNotify($flash));


                    $redirectRoute = $route->getChild('*/index');
                    $url = ($redirectRoute) ? $redirectRoute->getRoutePath() : null;


                    //
                    $event = new LayoutCrudCompletedFormEvent($route, $request, $crudHandler, $form, $url);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_COMPLETE, $event);
                    $url = $event->getRedirectUrl();
                    //

                    if ($url) {
                        return $this->redirect($url);
                    }
                    


                } else {

                    $flash = array(
                        'type' => 'error',
                        'title' => 'Formulaire',
                        'text' => 'Votre formulaire est invalide.',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom'
                        //				'icon' => 'fa fa-twitter'
                    );

                    //
                    $event = new LayoutCrudSubmittedFormEvent($route, $request, $crudHandler, $form, $flash);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_ERROR, $event);
                    $flash = $event->getFlash();
                    //

                    $this->addFlash($flash['type'], new PNotify($flash));

                }
            }

            $formsManager = $this->get('uneak.formsmanager');
            $formView = $formsManager->createView($form);
            $layout->buildFormPage($formView, $route->getMetaData('_label'));

            //
            $event = new LayoutCrudBuildEvent($route, null, null, $layout);
            $this->dispatcher->dispatch(LayoutCrudEvents::LAYOUT_BUILD, $event);
            //

            return $blockBuilder->renderResponse("layout");
        }



        public function deleteAction(FlattenRoute $route, Request $request) {
            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");


            //
            $event = new LayoutCrudInitializeEvent($route, $request, $crudHandler);
            $this->dispatcher->dispatch(LayoutCrudEvents::INITIALIZE, $event);
            $route = $event->getRoute();
            $request = $event->getRequest();
            $crudHandler = $event->getCrudHandler();
            //


            $blockBuilder->addBlock("layout", "block_main_interface");
            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $this->createForm($route->getFormType(), array('confirm' => false));
            $form->add('submit', 'submit', array('label' => 'Confirmer'));


            //
            $event = new LayoutCrudFormEvent($route, $request, $crudHandler, $form);
            $this->dispatcher->dispatch(LayoutCrudEvents::FORM_INITIALIZE, $event);
            $form = $event->getForm();
            //




            $entityRoute = $route;
            while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                $entityRoute = $entityRoute->getParent();
            }

            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $flash = array(
                        'type' => 'info',
                        'title' => 'Formulaire',
                        'text' => 'La suppression a été réalisé avec succes',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom',
                        'icon' => 'fa fa-'.$route->getMetaData('_icon')
                    );

                    //
                    $event = new LayoutCrudSubmittedFormEvent($route, $request, $crudHandler, $form, $flash);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_SUCCESS, $event);
                    $form = $event->getForm();
                    $flash = $event->getFlash();
                    //

                    $crudHandler->deleteEntity($form, $entityRoute->getParameterSubject());
                    $this->addFlash($flash['type'], new PNotify($flash));


                    $redirectRoute = $route->getChild('*/index');
                    $url = ($redirectRoute) ? $redirectRoute->getRoutePath() : null;
                    

                    //
                    $event = new LayoutCrudCompletedFormEvent($route, $request, $crudHandler, $form, $url);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_COMPLETE, $event);
                    $url = $event->getRedirectUrl();
                    //


                    if ($url) {
                        return $this->redirect($url);
                    }


                } else {


                    $flash = array(
                        'type' => 'error',
                        'title' => 'Formulaire',
                        'text' => 'Votre formulaire est invalide.',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom'
                    );

                    //
                    $event = new LayoutCrudSubmittedFormEvent($route, $request, $crudHandler, $form, $flash);
                    $this->dispatcher->dispatch(LayoutCrudEvents::FORM_ERROR, $event);
                    $flash = $event->getFlash();
                    //

                    $this->addFlash($flash['type'], new PNotify($flash));

                }
            }


            $formsManager = $this->get('uneak.formsmanager');
            $formView = $formsManager->createView($form);
            $layout->buildFormPage($formView, $route->getMetaData('_label'));

            //
            $event = new LayoutCrudBuildEvent($route, null, null, $layout);
            $this->dispatcher->dispatch(LayoutCrudEvents::LAYOUT_BUILD, $event);
            //

            return $blockBuilder->renderResponse("layout");
        }

        public function indexGridAction(FlattenRoute $route, Request $request) {

            $crudHandler = $route->getCRUD()->getHandler();

            //
            $event = new LayoutCrudInitializeEvent($route, $request, $crudHandler);
            $this->dispatcher->dispatch(LayoutCrudEvents::INITIALIZE, $event);
            $route = $event->getRoute();
            $request = $event->getRequest();
            $crudHandler = $event->getCrudHandler();
            //


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
