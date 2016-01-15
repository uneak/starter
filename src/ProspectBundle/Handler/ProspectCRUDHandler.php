<?php

	namespace ProspectBundle\Handler;


    use Uneak\FieldGroupBundle\Entity\FieldGroup;
    use Symfony\Component\Form\FormInterface;
    use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\APIHandlerInterface;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
    use Uneak\ProspectBundle\Entity\Prospect;
    use Uneak\RoutesManagerBundle\Helper\GridHelper;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ProspectCRUDHandler extends CRUDHandler {


		public function __construct(APIHandlerInterface $apiHandler) {
			parent::__construct($apiHandler);
		}


        /**
         * @param FlattenRoute $route
         * @param string $method
         * @return FormInterface
         */
        public function getForm(FlattenRoute $route, $method = Request::METHOD_POST) {
            if ($route->hasParameter('groups')) {
                /** @var $group FieldGroup*/
                $group = $route->getParameter('groups')->getParameterSubject();
                $groupSlug = $group->getSlug();
            } else {
                $groupSlug = null;
            }

            /** @var $prospect Prospect */
            $prospect = ($route->hasParameter('prospects')) ? $route->getParameter('prospects')->getParameterSubject() : null;
            return $this->apiHandler->getForm($groupSlug, $prospect, $method);
        }



        public function getColumns(FlattenRoute $route) {
            if ($route->hasParameter('groups')) {
                /** @var $group FieldGroup*/
                $group = $route->getParameter('groups')->getParameterSubject();
                $groupSlug = $group->getSlug();
            } else {
                $groupSlug = null;
            }

            return $this->apiHandler->getProspectsFieldsByGroup($groupSlug);
        }



        public function getDatatableArray(FlattenRoute $route, array $params, GridHelper $gridHelper) {


            $criteria = array();
            if ($route->hasParameter('groups')) {
                /** @var $group FieldGroup*/
                $group = $route->getParameter('groups')->getParameterSubject();
                $criteria['eq'] = array();
                $criteria['eq']['group'] = $group->getSlug();
            }


            $allCriteria = array_merge_recursive($params, $criteria);

            $gridData = array();


            $results = $this->apiHandler->all($allCriteria);
            $recordsFiltered = $this->apiHandler->count($allCriteria);
            $recordsTotal = $this->apiHandler->count($criteria);


            

            foreach ($results as $result) {
                $gridDataRow = $result;
                $gridDataRow['idkey_prospects'] = $result['id'];
                $gridData[] = $gridDataRow;
            }


            $nestedGridRoute = $route->getParent()->getNestedRoute();
            $ids = $nestedGridRoute->getIds();
            $gridDataArray = $this->getGridDataArray($gridData, $ids, $params['columns']);

            return array_merge($gridDataArray, array(
                'draw'            => intval($params["draw"] + 1),
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
            ));


        }




    }