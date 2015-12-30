<?php

	namespace ProspectGroupFieldBundle\Controller;

    use Uneak\FieldBundle\Entity\Field;
    use Uneak\PortoAdminBundle\PNotify\PNotify;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

    class ProspectGroupFieldAdminController extends LayoutEntityController {




        //
        // CONSTRAINTS
        //
        public function constraintsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('ConstraintBundle:ConstraintAdmin:index', array('route' => $route->getParameter('fields')->getChild('constraints/index'), 'request' => $request));
        }
        public function constraintsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('ConstraintBundle:ConstraintAdmin:new', array('route' => $route->getParameter('fields')->getChild('constraints/new'), 'request' => $request));
        }
        public function constraintsTypenewAction(FlattenRoute $route, Request $request) {
            return $this->forward('ConstraintBundle:ConstraintAdmin:typenew', array('route' => $route->getParameter('typeconstraint')->getChild('new'), 'request' => $request));
        }




        public function indexAction(FlattenRoute $route) {

            $crudHandler = $route->getHandler();

            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $layout->getLayoutContentHeader()->setTitle($route->getMetaData('_label'));
            $layout->getSubLayoutContentBody()->addBlock($crudHandler->getFieldsPanel($route), 'liste');


            return $blockBuilder->renderResponse("layout");
        }

        public function configAction(FlattenRoute $route, Request $request) {

            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");

            $blockBuilder->addBlock("layout", "block_main_interface");
            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $crudHandler->getConfigForm($route, Request::METHOD_POST);
            $form->add('submit', 'submit', array('label' => 'Modifier'));


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

                    $crudHandler->persistConfig($form);

                    $this->addFlash($flash['type'], new PNotify($flash));


                    $entityRoute = $route;
                    while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                        $entityRoute = $entityRoute->getParent();
                    }
                    $url = $entityRoute->getChild('show')->getRoutePath();


                    return $this->redirect($url);


                } else {

                    $flash = array(
                        'type' => 'error',
                        'title' => 'Formulaire',
                        'text' => 'Votre formulaire est invalide.',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom'
                        //				'icon' => 'fa fa-twitter'
                    );

                    $this->addFlash($flash['type'], new PNotify($flash));
                }
            }


            $formsManager = $this->get('uneak.formsmanager');
            $formView = $formsManager->createView($form);
            $layout->buildFormPage($formView, $route->getMetaData('_label'));

            return $blockBuilder->renderResponse("layout");
        }


        public function constraintAction(FlattenRoute $route, Request $request) {

            $crudHandler = $route->getHandler();
            $blockBuilder = $this->get("uneak.blocksmanager.builder");

            $blockBuilder->addBlock("layout", "block_main_interface");
            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $form = $crudHandler->getConfigForm($route, Request::METHOD_POST);
            $form->add('submit', 'submit', array('label' => 'Modifier'));


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

                    $crudHandler->persistConfig($form);

                    $this->addFlash($flash['type'], new PNotify($flash));


                    $entityRoute = $route;
                    while($entityRoute && !$entityRoute instanceof FlattenEntityRoute) {
                        $entityRoute = $entityRoute->getParent();
                    }
                    $url = $entityRoute->getChild('show')->getRoutePath();


                    return $this->redirect($url);


                } else {

                    $flash = array(
                        'type' => 'error',
                        'title' => 'Formulaire',
                        'text' => 'Votre formulaire est invalide.',
                        'shadow' => true,
                        'stack' => 'stack-bar-bottom'
                        //				'icon' => 'fa fa-twitter'
                    );

                    $this->addFlash($flash['type'], new PNotify($flash));
                }
            }


            $formsManager = $this->get('uneak.formsmanager');
            $formView = $formsManager->createView($form);
            $layout->buildFormPage($formView, $route->getMetaData('_label'));

            return $blockBuilder->renderResponse("layout");
        }





        public function indexCheckAction(FlattenRoute $route, Request $request) {

            $data = $request->request->get("data");
            $data = preg_replace('/^todo_/', '', $data);
            $checked = ($request->request->get("checked") == "true") ? true : false;

            $em = $this->getDoctrine()->getEntityManager();
            /** @var $field Field */
            $field = $em->getRepository("UneakFieldBundle:Field")->findOneBy(array('slug' => $data));
            $field->setEnabled($checked);
            $em->flush();

            return new JsonResponse(array('checked' => $checked));
        }


        public function indexSortAction(FlattenRoute $route, Request $request) {

            $data = $request->request->get("data");
            $group = $request->query->get("groups");

            $em = $this->getDoctrine()->getEntityManager();

            $fields = $em->getRepository("UneakFieldBundle:Field")->findFields($group);
            /** @var $field Field */
            foreach ($fields as $field) {
                $sort = array_search("todo_".$field->getSlug(), $data);
                if ($sort !== null) {
                    $field->setSort($sort);
                }
            }

            $em->flush();

            return new JsonResponse(array('data' => $data));
        }

	}
