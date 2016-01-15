<?php

	namespace FieldGroupBundle\Controller;

	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;


    class FieldGroupAdminController extends LayoutEntityController {


        //
        // FIELDS
        //
        public function fieldsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:index', array('route' => $route->getParameter('groups')->getChild('fields/index'), 'request' => $request));
        }
        public function fieldsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:new', array('route' => $route->getParameter('groups')->getChild('fields/new'), 'request' => $request));
        }
        public function fieldsShowAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:show', array('route' => $route->getParameter('fields')->getChild('show'), 'request' => $request));
        }
        public function fieldsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:edit', array('route' => $route->getParameter('fields')->getChild('edit'), 'request' => $request));
        }
        public function fieldsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:delete', array('route' => $route->getParameter('fields')->getChild('delete'), 'request' => $request));
        }
        public function fieldsConfigAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:config', array('route' => $route->getParameter('fields')->getChild('config'), 'request' => $request));
        }

        //
        // FIELDS / CONSTRAINTS
        //
        public function fieldsConstraintsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsIndex', array('route' => $route->getParameter('fields')->getChild('constraints/index'), 'request' => $request));
        }
        public function fieldsConstraintsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsNew', array('route' => $route->getParameter('fields')->getChild('constraints/new'), 'request' => $request));
        }
        public function fieldsConstraintsTypenewAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsTypenew', array('route' => $route->getParameter('typeconstraint')->getChild('new'), 'request' => $request));
        }
        public function fieldsConstraintsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsEdit', array('route' => $route->getParameter('constraints')->getChild('edit'), 'request' => $request));
        }
        public function fieldsConstraintsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsDelete', array('route' => $route->getParameter('constraints')->getChild('delete'), 'request' => $request));
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

        //
        // IMPORTS
        //
        public function importsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('ImportBundle:ImportAdmin:index', array('route' => $route->getParameter('groups')->getChild('imports/index'), 'request' => $request));
        }
        public function importsIndexGridAction(FlattenRoute $route, Request $request) {
            return $this->forward('ImportBundle:ImportAdmin:indexGrid', array('route' => $route->getParameter('groups')->getChild('imports/index/_grid'), 'request' => $request));
        }
        public function importsCsvAction(FlattenRoute $route, Request $request) {
            return $this->forward('ImportBundle:ImportAdmin:csv', array('route' => $route->getParameter('groups')->getChild('imports/csv'), 'request' => $request));
        }
        public function importsXlsAction(FlattenRoute $route, Request $request) {
            return $this->forward('ImportBundle:ImportAdmin:xls', array('route' => $route->getParameter('groups')->getChild('imports/xls'), 'request' => $request));
        }
        public function importsShowAction(FlattenRoute $route, Request $request) {
            return $this->forward('ImportBundle:ImportAdmin:show', array('route' => $route->getParameter('imports')->getChild('show'), 'request' => $request));
        }
        public function importsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('ImportBundle:ImportAdmin:delete', array('route' => $route->getParameter('imports')->getChild('delete'), 'request' => $request));
        }
        public function importsStatusAction(FlattenRoute $route, Request $request) {
            return $this->forward('ImportBundle:ImportAdmin:status', array('route' => $route->getParameter('imports')->getChild('status'), 'request' => $request));
        }
        public function importsStopAction(FlattenRoute $route, Request $request) {
            return $this->forward('ImportBundle:ImportAdmin:stop', array('route' => $route->getParameter('imports')->getChild('stop'), 'request' => $request));
        }




		
	}
