<?php

	namespace ConstraintBundle\Controller;

    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\PortoAdminBundle\Event\LayoutEntityEvents;
    use Uneak\PortoAdminBundle\Event\LayoutEntityFlashEvent;
    use Uneak\PortoAdminBundle\Event\LayoutEntityFormCompleteEvent;
    use Uneak\PortoAdminBundle\Event\LayoutEntityFormCreateEvent;
    use Uneak\PortoAdminBundle\Event\LayoutEntityFormSubmitEvent;
    use Uneak\PortoAdminBundle\Event\LayoutEntityLayoutEvent;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

    class ConstraintAdminController extends LayoutEntityController {


        public function indexAction(FlattenRoute $route, Request $request) {

            $this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, function (LayoutEntityLayoutEvent $event) {
                $route = $event->getRoute();
                $layout = $event->getLayout();
                $crudHandler = $event->getCrudHandler();

                $layout->getLayoutContentHeader()->setTitle($route->getMetaData('_label'));
                $layout->getSubLayoutContentBody()->addBlock($crudHandler->getConstraintsPanel($route), 'liste');

                $event->stopPropagation();
            }, false, 10);

            return parent::indexAction($route, $request);
        }


        public function newAction(FlattenRoute $route, Request $request) {

            $this->on(LayoutEntityEvents::FORM_CREATE, function (LayoutEntityFormCreateEvent $event) {
                $form = $this->createFormBuilder()
                    ->add('type', 'constraints_selector', array('label' => 'Contrainte'))
                    ->add('submit', 'submit', array('label' => 'Ajouter'))
                    ->getForm();
                $event->setForm($form);

                $event->stopPropagation();
            }, false, 10);

            $this->on(LayoutEntityEvents::FORM_SUCCESS, function (LayoutEntityFormSubmitEvent $event) {
                $event->stopPropagation();
            }, false, 10);

            $this->on(LayoutEntityEvents::FLASH_SUCCESS, function (LayoutEntityFlashEvent $event) {
                $event->setFlash(null);
                $event->stopPropagation();
            }, false, 10);

            $this->on(LayoutEntityEvents::FORM_COMPLETE, function (LayoutEntityFormCompleteEvent $event) {
                $route = $event->getRoute();
                $form = $event->getForm();

                $redirect = $route->getChild("*/type/new", array('typeconstraint' => $form->get('type')->getData()))->getRoutePath();
                $event->setRedirectUrl($redirect);

                $event->stopPropagation();
            }, false, 10);


            return parent::newAction($route, $request);

        }


        public function typenewAction(FlattenRoute $route, Request $request) {
            return parent::newAction($route, $request);
        }


        public function editAction(FlattenRoute $route, Request $request) {

            $this->on(LayoutEntityEvents::FORM_COMPLETE, function (LayoutEntityFormCompleteEvent $event) {
                $route = $event->getRoute();
                $url = $route->getChild('*/index')->getRoutePath();
                $event->setRedirectUrl($url);

                $event->stopPropagation();
            }, false, 10);

            return parent::editAction($route, $request);
        }

	}
