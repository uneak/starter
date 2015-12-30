<?php

namespace Uneak\RoutesManagerBundle\Routes;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Uneak\RoutesManagerBundle\Routes\FlattenParameterRoute;

class FlattenEntityRoute extends FlattenParameterRoute {

    protected $entity;
    protected $formType;
    protected $handler;
    protected $parameterSubject = null;
	protected $em;

    public function __construct(Router $router, FlattenRouteManager $flattenRouteManager, EntityManager $em, $data = null) {
        parent::__construct($router, $flattenRouteManager, $data);
		$this->em = $em;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getFormType() {
        return $this->formType;
    }

    public function getHandler() {
        return $this->handler;
    }

	public function setParameterValue($parameterValue) {
		parent::setParameterValue($parameterValue);
		$this->parameterSubject = $this->getNestedRoute()->findEntity($this->em, $this->getEntity(), $parameterValue);
		return $this;
	}

    public function getParameterSubject() {
            return $this->parameterSubject;
    }

    public function getArray() {
        $array = parent::getArray();
        $array['entity'] = $this->entity;
        $array['formType'] = $this->formType;
        $array['handler'] = $this->handler;
        return $array;
    }

    public function buildArray($array) {
        parent::buildArray($array);
        $this->entity = (isset($array['entity'])) ? $array['entity'] : '';
        $this->formType = (isset($array['formType'])) ? $array['formType'] : '';
        $this->handler = (isset($array['handler'])) ? $array['handler'] : '';
    }
    
    
}
