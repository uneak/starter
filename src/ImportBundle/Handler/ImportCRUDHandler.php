<?php

	namespace ImportBundle\Handler;


	use Symfony\Component\Form\FormInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Uneak\ImportBundle\Entity\Import;
    use Uneak\PortoAdminBundle\Handler\APIHandlerInterface;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ImportCRUDHandler extends CRUDHandler {


		public function __construct(APIHandlerInterface $apiHandler) {
			parent::__construct($apiHandler);
		}

        public function persistImport(Import $import) {
            return $this->apiHandler->persistImport($import);
        }

        /**
         * @param FlattenRoute $route
         * @param string $method
         * @return FormInterface
         */
        public function getForm(FlattenRoute $route, $method = Request::METHOD_POST) {
            if ($route->hasParameter('groups')) {
                $groups = $route->getParameter('groups')->getParameterSubject();
            } else {
                $groups = null;
            }
            $entity = array('group' => $groups);
            $formType = $route->getFormType();
            return $this->apiHandler->getForm($formType, $entity, $method);
        }




        private function _qb($entityClass, $gridHelper, $params, $groupsId) {
            $qb = $gridHelper->createGridQueryBuilder($entityClass, $params);
            if ($groupsId) {
                $qb->innerjoin('o.group', 'fieldGroup');
                $qb->andWhere($qb->expr()->eq('fieldGroup.id', ':groupID'));
                $qb->setParameter('groupID', $groupsId);
            }
            return $qb;
        }



        public function getDatatableArray(FlattenRoute $route, array $params, GridHelper $gridHelper) {

            if ($route->hasParameter('groups')) {
                $groups = $route->getParameter('groups')->getParameterSubject()->getId();
            } else {
                $groups = null;
            }

            $nestedGridRoute = $route->getParent()->getNestedRoute();
            $ids = $nestedGridRoute->getIds();
            $entityClass = $route->getCRUD()->getEntity();

            $gridData = $gridHelper->gridFields($this->_qb($entityClass, $gridHelper, $params, $groups), $params, $ids);
            $recordsTotal = $gridHelper->gridFieldsCount($this->_qb($entityClass, $gridHelper, $params, $groups));
            $recordsFiltered = $gridHelper->gridFieldsCount($this->_qb($entityClass, $gridHelper, $params, $groups));


            $gridDataArray = $this->getGridDataArray($gridData, $ids, $params['columns']);

            return array_merge($gridDataArray, array(
                'draw'            => $params["draw"],
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
            ));
        }





	}