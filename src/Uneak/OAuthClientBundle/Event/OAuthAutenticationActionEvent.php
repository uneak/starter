<?php

namespace Uneak\OAuthClientBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Uneak\OAuthClientBundle\OAuth\Service;

class OAuthAutenticationActionEvent extends Event {


    protected $service;
    protected $serviceAlias;
    protected $action;
    protected $response = null;

    public function __construct(Service $service, $serviceAlias, $action) {
        $this->service = $service;
        $this->serviceAlias = $serviceAlias;
        $this->action = $action;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    public function getServiceAlias()
    {
        return $this->serviceAlias;
    }

    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }




}