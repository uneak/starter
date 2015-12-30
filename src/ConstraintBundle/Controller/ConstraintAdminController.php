<?php

	namespace ConstraintBundle\Controller;

    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Uneak\PortoAdminBundle\PNotify\PNotify;

    class ConstraintAdminController extends LayoutEntityController {


        public function indexAction(FlattenRoute $route) {

            $crudHandler = $route->getHandler();

            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $layout->getLayoutContentHeader()->setTitle($route->getMetaData('_label'));
            $layout->getSubLayoutContentBody()->addBlock($crudHandler->getConstraintsPanel($route), 'liste');


            return $blockBuilder->renderResponse("layout");
        }


        public function newAction(FlattenRoute $route, Request $request) {

            $blockBuilder = $this->get("uneak.blocksmanager.builder");
            $blockBuilder->addBlock("layout", "block_main_interface");

            $layout = $this->get("uneak.admin.page.entity.layout");
            $layout->setLayout($blockBuilder->getBlock("layout"));
            $layout->buildEntityLayout($route);

            $layout->getLayoutContentHeader()->setTitle($route->getMetaData('_label'));


            $form = $this->createFormBuilder()
                ->add('type', 'constraints_selector', array('label' => 'Contrainte'))
                ->add('submit', 'submit', array('label' => 'Ajouter'))
                ->getForm();

            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    return $this->redirect($route->getChild("*/type/new", array('typeconstraint' => $form->get('type')->getData()))->getRoutePath());
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

            $formsManager = $this->get('uneak.formsmanager');
            $formView = $formsManager->createView($form);
            $layout->buildFormPage($formView, "Ajouter une contrainte");


            return $blockBuilder->renderResponse("layout");
        }


        public function typenewAction(FlattenRoute $route, Request $request) {
            return parent::newAction($route, $request);
        }


	}
