<?php

namespace Uneak\RoutesManagerBundle\Routes;

use Doctrine\ORM\EntityManager;

class NestedEntityRoute extends NestedParameterRoute {

    protected $entity = null;
    protected $formType = null;
    protected $handler = null;

	public function __construct($id, $entity = null, $parameterName = null, $parameterDefault = null, $parameterPattern = null) {
		parent::__construct($id, $parameterName, $parameterDefault, $parameterPattern);
		$this->entity = $entity;
	}

	public function getNestedType() {
		return "NestedEntityRoute";
	}

	public function findEntity(EntityManager $em, $entityClass, $parameter) {
		$entityRepository = $em->getRepository($entityClass);
		return $entityRepository->find($parameter);
	}

	public function getEntity() {
		return $this->entity;
	}

	public function setEntity($entity) {
		$this->entity = $entity;
		return $this;
	}

    public function getFormType() {
        return $this->formType;
    }

    public function setFormType($formType) {
        $this->formType = $formType;
        return $this;
    }

    public function getHandler() {
        return $this->handler;
    }

    public function setHandler($handler) {
        $this->handler = $handler;
        return $this;
    }
}
