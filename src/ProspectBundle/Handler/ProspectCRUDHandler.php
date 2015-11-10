<?php

	namespace ProspectBundle\Handler;


	use Symfony\Component\HttpFoundation\Request;
	use Uneak\PortoAdminBundle\Handler\APIHandlerInterface;
	use Uneak\PortoAdminBundle\Handler\CRUDHandler;
	use Uneak\RoutesManagerBundle\Helper\GridHelper;
	use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

	class ProspectCRUDHandler extends CRUDHandler {


		public function __construct(APIHandlerInterface $apiHandler) {
			parent::__construct($apiHandler);
		}


		/**
		 * @param FlattenRoute $route
		 * @param string       $method
		 *
		 * @return FormInterface
		 */
		public function getProspectForm(FlattenRoute $route, $method = Request::METHOD_POST) {
			$client = $route->getParameter('groups')->getParameterSubject();
			$entity = ($route->hasParameter('prospects')) ? $route->getParameter('prospects')->getParameterSubject() : $this->createEntity();
			$entity->setGroup($client);
			$formType = $route->getFormType();

			return $this->apiHandler->getForm($formType, $entity, $method);
		}


		private function _qb($gridHelper, $params, $groupID) {
			$qb = $gridHelper->createGridQueryBuilder('ProspectBundle\Entity\Prospect', $params);
			$qb->innerjoin('o.group', 'group_current');
			$qb->andWhere($qb->expr()->eq('group_current.id', ':groupID'));
			$qb->setParameter('groupID', $groupID);

			return $qb;
		}

		public function getProspectDatatableArray($clientID, array $ids, array $params, GridHelper $gridHelper) {
			$gridData = $gridHelper->gridFields($this->_qb($gridHelper, $params, $clientID), $params, $ids);
			$recordsTotal = $gridHelper->gridFieldsCount($this->_qb($gridHelper, $params, $clientID));
			$recordsFiltered = $gridHelper->gridFieldsCount($this->_qb($gridHelper, $params, $clientID));


			$data = array();
			$id = array();
			foreach ($gridData as $object) {
				$row = array();
				foreach ($ids as $key => $path) {
					$row[$key] = $object['idkey_' . $key];
				}
				array_push($id, $row);
				$row = array();
				foreach ($params['columns'] as $columns) {
					if ($columns['name'] && substr($columns['name'], 0, 1) != '_') {
						$value = $object[str_replace(".", "_", $columns['name'])];
						if ($value instanceof \DateTime) {
							$value = $value->format('d/m/Y H:m:s');
						}
						$row[$columns['data']] = $value;
					} else {
						$row[$columns['data']] = "";
					}
				}
				array_push($data, $row);
			}

			return array(
				'draw'            => $params["draw"],
				'recordsTotal'    => $recordsTotal,
				'recordsFiltered' => $recordsFiltered,
				'data'            => $data,
				'id'              => $id,
			);
		}


	}