<?php

	namespace CampaignBundle\Handler;


	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\APIHandlerInterface;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class CampaignCRUDHandler extends CRUDHandler {


		public function __construct(APIHandlerInterface $apiHandler) {
			parent::__construct($apiHandler);
		}



		/**
		 * @param FlattenRoute $route
		 * @param string $method
		 * @return FormInterface
		 */
		public function getCampaignForm(FlattenRoute $route, $method = Request::METHOD_POST) {
			$client = $route->getParameter('clients')->getParameterSubject();
			$entity = ($route->hasParameter('campaigns')) ? $route->getParameter('campaigns')->getParameterSubject() : $this->createEntity();
			$entity->setClient($client);
			$formType = $route->getFormType();
			return $this->apiHandler->getForm($formType, $entity, $method);
		}



		private function _qb($gridHelper, $params, $clientID) {
			$qb = $gridHelper->createGridQueryBuilder('CampaignBundle\Entity\Campaign', $params);
			$qb->innerjoin('o.client', 'client');
			$qb->andWhere($qb->expr()->eq('client.id', ':clientID'));
			$qb->setParameter('clientID', $clientID);
			return $qb;
		}

		public function getCampaignDatatableArray(FlattenRoute $route, array $params, GridHelper $gridHelper) {

			$nestedGridRoute = $route->getParent()->getNestedRoute();
			$ids = $nestedGridRoute->getIds();

			$client = $route->getParameter('clients')->getParameterSubject()->getId();

			$gridData = $gridHelper->gridFields($this->_qb($gridHelper, $params, $client), $params, $ids);
			$recordsTotal = $gridHelper->gridFieldsCount($this->_qb($gridHelper, $params, $client));
			$recordsFiltered = $gridHelper->gridFieldsCount($this->_qb($gridHelper, $params, $client));

			$gridDataArray = $this->getGridDataArray($gridData, $ids, $params['columns']);

			return array_merge($gridDataArray, array(
				'draw'            => $params["draw"],
				'recordsTotal'    => $recordsTotal,
				'recordsFiltered' => $recordsFiltered,
			));


		}


	}