<?php

namespace Uneak\RoutesManagerBundle\Routes;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class FlattenAdminRoute extends FlattenRoute {

    protected $admin;
    protected $entity;
    protected $formType;
    protected $handler;

    public function __construct(Router $router, FlattenRouteManager $flattenRouteManager, $data = null) {
        parent::__construct($router, $flattenRouteManager, $data);
    }



    public function getAdmin() {
        return $this->admin;
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

    public function getArray() {
        $array = parent::getArray();
        $array['admin'] = $this->admin;
        $array['entity'] = $this->entity;
        $array['formType'] = $this->formType;
        $array['handler'] = $this->handler;
        return $array;
    }

    public function buildArray($array) {
        parent::buildArray($array);
        $this->admin = (isset($array['admin'])) ? $array['admin'] : null;
        $this->entity = (isset($array['entity'])) ? $array['entity'] : null;
        $this->formType = (isset($array['formType'])) ? $array['formType'] : null;
        $this->handler = (isset($array['handler'])) ? $array['handler'] : null;
    }

}
