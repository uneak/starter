<?php

namespace Uneak\OAuthClientBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Uneak\OAuthClientBundle\OAuth\Service;
use Uneak\OAuthClientBundle\OAuth\ServiceInterface;

class OAuthAutenticationResponseEvent extends Event {

    protected $serviceAlias;
    protected $service;
    protected $action;
    protected $accessToken;

    public function __construct($serviceAlias) {
        $this->serviceAlias = $serviceAlias;
    }

    public function getServiceAlias()
    {
        return $this->serviceAlias;
    }

    /**
     * @return ServiceInterface
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param ServiceInterface $service
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

    /**
     * @return mixed
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }



}