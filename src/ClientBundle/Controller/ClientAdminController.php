<?php

	namespace ClientBundle\Controller;

    use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
	use Uneak\PortoAdminBundle\PNotify\PNotify;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ClientAdminController extends LayoutEntityController {


        //
        // GROUPS
        //
        public function groupsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:index', array('route' => $route->getParameter('clients')->getChild('groups/index'), 'request' => $request));
        }
        public function groupsIndexGridAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:indexGrid', array('route' => $route->getParameter('clients')->getChild('groups/index/_grid'), 'request' => $request));
        }
        public function groupsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:new', array('route' => $route->getParameter('clients')->getChild('groups/new'), 'request' => $request));
        }
        public function groupsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:delete', array('route' => $route->getParameter('groups')->getChild('delete'), 'request' => $request));
        }
        public function groupsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:edit', array('route' => $route->getParameter('groups')->getChild('edit'), 'request' => $request));
        }
        public function groupsShowAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:show', array('route' => $route->getParameter('groups')->getChild('show'), 'request' => $request));
        }

        //
        // GROUPS / IMPORTS
        //
        public function groupsImportsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:importsIndex', array('route' => $route->getParameter('groups')->getChild('imports/index'), 'request' => $request));
        }
        public function groupsImportsIndexGridAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:importsIndexGrid', array('route' => $route->getParameter('groups')->getChild('imports/index/_grid'), 'request' => $request));
        }
        public function groupsImportsCsvAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:importsCsv', array('route' => $route->getParameter('groups')->getChild('imports/csv'), 'request' => $request));
        }
        public function groupsImportsXlsAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:importsXls', array('route' => $route->getParameter('groups')->getChild('imports/xls'), 'request' => $request));
        }
        public function groupsImportsShowAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:importsShow', array('route' => $route->getParameter('imports')->getChild('show'), 'request' => $request));
        }
        public function groupsImportsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:importsDelete', array('route' => $route->getParameter('imports')->getChild('delete'), 'request' => $request));
        }
        public function groupsImportsStatusAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:importsStatus', array('route' => $route->getParameter('imports')->getChild('status'), 'request' => $request));
        }
        public function groupsImportsStopAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:importsStop', array('route' => $route->getParameter('imports')->getChild('stop'), 'request' => $request));
        }


        //
        // GROUPS / PROSPECTS
        //
        public function groupsProspectsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:prospectsIndex', array('route' => $route->getParameter('groups')->getChild('prospects/index'), 'request' => $request));
        }
        public function groupsProspectsIndexGridAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:prospectsIndexGrid', array('route' => $route->getParameter('groups')->getChild('prospects/index/_grid'), 'request' => $request));
        }
        public function groupsProspectsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:prospectsNew', array('route' => $route->getParameter('groups')->getChild('prospects/new'), 'request' => $request));
        }
        public function groupsProspectsShowAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:prospectsShow', array('route' => $route->getParameter('prospects')->getChild('show'), 'request' => $request));
        }
        public function groupsProspectsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:prospectsEdit', array('route' => $route->getParameter('prospects')->getChild('edit'), 'request' => $request));
        }
        public function groupsProspectsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldGroupBundle:FieldGroupAdmin:prospectsDelete', array('route' => $route->getParameter('prospects')->getChild('delete'), 'request' => $request));
        }






        //
        // GROUPS / FIELDS
        //
        public function groupsFieldsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:index', array('route' => $route->getParameter('groups')->getChild('fields/index'), 'request' => $request));
        }

        public function groupsFieldsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:new', array('route' => $route->getParameter('groups')->getChild('fields/new'), 'request' => $request));
        }

        public function groupsFieldsShowAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:show', array('route' => $route->getParameter('fields')->getChild('show'), 'request' => $request));
        }

        public function groupsFieldsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:edit', array('route' => $route->getParameter('fields')->getChild('edit'), 'request' => $request));
        }

        public function groupsFieldsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:delete', array('route' => $route->getParameter('fields')->getChild('delete'), 'request' => $request));
        }

        public function groupsFieldsConfigAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:config', array('route' => $route->getParameter('fields')->getChild('config'), 'request' => $request));
        }

        //
        // GROUPS / FIELDS / CONSTRAINTS
        //
        public function groupsFieldsConstraintsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsIndex', array('route' => $route->getParameter('fields')->getChild('constraints/index'), 'request' => $request));
        }
        public function groupsFieldsConstraintsEditAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsEdit', array('route' => $route->getParameter('constraints')->getChild('edit'), 'request' => $request));
        }
        public function groupsFieldsConstraintsDeleteAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsDelete', array('route' => $route->getParameter('constraints')->getChild('delete'), 'request' => $request));
        }
        public function groupsFieldsConstraintsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsNew', array('route' => $route->getParameter('fields')->getChild('constraints/new'), 'request' => $request));
        }
        public function groupsFieldsConstraintsTypenewAction(FlattenRoute $route, Request $request) {
            return $this->forward('FieldBundle:FieldAdmin:constraintsTypenew', array('route' => $route->getParameter('typeconstraint')->getChild('new'), 'request' => $request));
        }



        //
        // CAMPAIGNS
        //
        public function campaignsIndexAction(FlattenRoute $route, Request $request) {
            return $this->forward('CampaignBundle:CampaignAdmin:index', array('route' => $route->getParameter('clients')->getChild('campaigns/index'), 'request' => $request));
        }

        public function campaignsIndexGridAction(FlattenRoute $route, Request $request) {
            return $this->forward('CampaignBundle:CampaignAdmin:indexGrid', array('route' => $route->getParameter('clients')->getChild('campaigns/index/_grid'), 'request' => $request));
        }

        public function campaignsNewAction(FlattenRoute $route, Request $request) {
            return $this->forward('CampaignBundle:CampaignAdmin:new', array('route' => $route->getParameter('clients')->getChild('campaigns/new'), 'request' => $request));
        }



	}
