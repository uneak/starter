<?php

namespace Uneak\OAuthClientBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Uneak\OAuthClientBundle\OAuth\Service;

class OAuthAutenticationResponseEvent extends Event {

    protected $serviceAlias;
    protected $service;
    protected $action;

    public function __construct($serviceAlias) {
        $this->serviceAlias = $serviceAlias;
    }

    public function getServiceAlias()
    {
        return $this->serviceAlias;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param Service $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }



}