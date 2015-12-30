<?php

namespace Uneak\PortoAdminBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Uneak\PortoAdminBundle\Handler\CRUDHandler;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class LayoutCrudActionEvent extends Event
{

    /**
     * @var FlattenRoute
     */
    protected $route;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var CRUDHandler
     */
    protected $crudHandler;

    public function __construct(FlattenRoute $route, Request $request = null, CRUDHandler $crudHandler = null)
    {
        $this->route = $route;
        $this->request = $request;
        $this->crudHandler = $crudHandler;
    }

    /**
     * @return FlattenRoute
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return CRUDHandler
     */
    public function getCrudHandler()
    {
        return $this->crudHandler;
    }



}
