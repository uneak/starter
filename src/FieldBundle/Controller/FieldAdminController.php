<?php

	namespace FieldBundle\Controller;

    use Uneak\FieldBundle\Entity\Field;
    use Uneak\PortoAdminBundle\Event\LayoutEntityEvents;
    use Uneak\PortoAdminBundle\Event\LayoutEntityFormCreateEvent;
    use Uneak\PortoAdminBundle\Event\LayoutEntityFormSubmitEvent;
    use Uneak\PortoAdminBundle\Event\LayoutEntityLayoutEvent;
    use Uneak\PortoAdminBundle\PNotify\PNotify;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

    class FieldAdminController extends LayoutEntityController {


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
        public function constraintsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('ConstraintBundle:ConstraintAdmin:edit', array('route' => $route->getParameter('constraints')->getChild('edit'), 'request' => $request));
        }
        public function constraintsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('ConstraintBundle:ConstraintAdmin:delete', array('route' => $route->getParameter('constraints')->getChild('delete'), 'request' => $request));
        }



        public function indexAction(FlattenRoute $route, Request $request) {

            $this->on(LayoutEntityEvents::LAYOUT_INITIALIZE, function (LayoutEntityLayoutEvent $event) {
                $route = $event->getRoute();
                $layout = $event->getLayout();
                $crudHandler = $event->getCrudHandler();

                $layout->getLayoutContentHeader()->setTitle($route->getMetaData('_label'));
                $layout->getSubLayoutContentBody()->addBlock($crudHandler->getFieldsPanel($route), 'liste');

                $event->stopPropagation();
            }, false, 10);

            return parent::indexAction($route, $request);

        }

        public function configAction(FlattenRoute $route, Request $request) {

            $this->on(LayoutEntityEvents::FORM_CREATE, function (LayoutEntityFormCreateEvent $event) {
                $crudHandler = $event->getCrudHandler();
                $route = $event->getRoute();
                $form = $crudHandler->getConfigForm($route, Request::METHOD_POST);
                $event->setForm($form);

                $event->stopPropagation();
            }, false, 10);

            $this->on(LayoutEntityEvents::FORM_SUCCESS, function (LayoutEntityFormSubmitEvent $event) {
                $form = $event->getForm();
                $crudHandler = $event->getCrudHandler();
                $entity = $crudHandler->persistConfig($form);
                $event->setEntity($entity);

                $event->stopPropagation();
            }, false, 10);

            return parent::editAction($route, $request);
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
