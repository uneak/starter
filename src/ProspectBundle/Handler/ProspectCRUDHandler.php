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


	}