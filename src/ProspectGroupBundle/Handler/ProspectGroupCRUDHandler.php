<?php

	namespace ProspectGroupBundle\Handler;


	use Symfony\Component\Form\FormInterface;
    use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\APIHandlerInterface;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ProspectGroupCRUDHandler extends CRUDHandler {


		public function __construct(APIHandlerInterface $apiHandler) {
			parent::__construct($apiHandler);
		}




        /**
         * @param FlattenRoute $route
         * @param string $method
         * @return FormInterface
         */
        public function getForm(FlattenRoute $route, $method = Request::METHOD_POST) {

            if ($route->hasParameter('clients')) {
                $client = $route->getParameter('clients')->getParameterSubject();
            } else {
                $client = null;
            }

            if ($route->hasParameter('groups')) {
                $group = $route->getParameter('groups')->getParameterSubject();
            } else {
                $group = null;
            }

            $entity = ($group) ? $group : $this->createEntity();
            $entity->setClient($client);
            $formType = $route->getFormType();
            return $this->apiHandler->getForm($formType, $entity, $method);
        }





		private function _qb($entityClass, $gridHelper, $params, $clientID) {
			$qb = $gridHelper->createGridQueryBuilder($entityClass, $params);
            if ($clientID) {
                $qb->innerjoin('o.client', 'client');
                $qb->andWhere($qb->expr()->eq('client.id', ':clientID'));
                $qb->setParameter('clientID', $clientID);
            }
			return $qb;
		}


        public function getDatatableArray(FlattenRoute $route, array $params, GridHelper $gridHelper) {

            if ($route->hasParameter('clients')) {
                $client = $route->getParameter('clients')->getParameterSubject()->getId();
            } else {
                $client = null;
            }

            $nestedGridRoute = $route->getParent()->getNestedRoute();
            $ids = $nestedGridRoute->getIds();
            $entityClass = $route->getCRUD()->getEntity();

            $gridData = $gridHelper->gridFields($this->_qb($entityClass, $gridHelper, $params, $client), $params, $ids);
            $recordsTotal = $gridHelper->gridFieldsCount($this->_qb($entityClass, $gridHelper, $params, $client));
            $recordsFiltered = $gridHelper->gridFieldsCount($this->_qb($entityClass, $gridHelper, $params, $client));


            $gridDataArray = $this->getGridDataArray($gridData, $ids, $params['columns']);

            return array_merge($gridDataArray, array(
                'draw'            => $params["draw"],
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
            ));
        }






	}