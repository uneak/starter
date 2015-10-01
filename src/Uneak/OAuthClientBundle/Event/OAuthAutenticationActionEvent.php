<?php

namespace Uneak\OAuthClientBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Uneak\OAuthClientBundle\OAuth\Service;
use Uneak\OAuthClientBundle\OAuth\ServiceInterface;
use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;
use Uneak\OAuthClientBundle\OAuth\Token\TokenInterface;

class OAuthAutenticationActionEvent extends Event {


    protected $service;
    protected $serviceAlias;
    protected $action;
    protected $token;
    protected $response = null;

    public function __construct(ServiceInterface $service, TokenInterface $token, $serviceAlias, $action) {
        $this->service = $service;
        $this->serviceAlias = $serviceAlias;
        $this->action = $action;
        $this->token = $token;
    }

    /**
     * @return TokenInterface
     */
    public function getToken()
    {
        return $this->token;
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