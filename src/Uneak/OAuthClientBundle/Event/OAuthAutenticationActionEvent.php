<?php

namespace Uneak\OAuthClientBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Uneak\OAuthClientBundle\OAuth\Service;
use Uneak\OAuthClientBundle\OAuth\ServiceInterface;
use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;

class OAuthAutenticationActionEvent extends Event {


    protected $service;
    protected $serviceAlias;
    protected $action;
    protected $accessToken;
    protected $response = null;

    public function __construct(ServiceInterface $service, AccessTokenInterface $accessToken, $serviceAlias, $action) {
        $this->service = $service;
        $this->serviceAlias = $serviceAlias;
        $this->action = $action;
        $this->accessToken = $accessToken;
    }

    /**
     * @return AccessTokenInterface
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return ServiceInterface
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