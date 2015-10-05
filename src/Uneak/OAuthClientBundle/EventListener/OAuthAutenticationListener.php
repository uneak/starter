<?php

namespace Uneak\OAuthClientBundle\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Uneak\OAuthClientBundle\Event\OAuthAutenticationRequestEvent;
use Uneak\OAuthClientBundle\Event\OAuthAutenticationResponseEvent;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Grant\AuthorizationCode;
use Uneak\OAuthClientBundle\OAuth\OAuth1;
use Uneak\OAuthClientBundle\OAuth\ServiceOAuth1;
use Uneak\OAuthClientBundle\OAuth\ServiceOAuth2;
use Uneak\OAuthClientBundle\OAuth\ServicesManager;

class OAuthAutenticationListener {

    /**
     * @var Session
     */
    protected $session;
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var ServicesManager
     */
    private $servicesManager;
    /**
     * @var Router
     */
    private $router;


    public function __construct(Session $session, ServicesManager $servicesManager, RequestStack $requestStack, Router $router) {
        $this->session = $session;
        $this->requestStack = $requestStack;
        $this->servicesManager = $servicesManager;
        $this->router = $router;
    }

    public function onAutenticationRequest(OAuthAutenticationRequestEvent $event) {

        $service = $this->servicesManager->getService($event->getServiceAlias());

        if ($service instanceof ServiceOAuth2) {
            $redirectUrl = $this->router->generate('oauth_authentication_code_response', array('service' => $event->getServiceAlias()), Router::ABSOLUTE_URL);
            $service->getAuthenticationConfiguration()->setOption('redirect_uri', $redirectUrl);

            $state = $service->getAuthenticationConfiguration()->getState();
            $this->session->set('authentication_state', $state);

            $event->setAuthentication($service->getAuthenticationUrl());
        }

        if ($service instanceof ServiceOAuth1) {
            $redirectUrl = $this->router->generate('oauth_authentication_code_response', array('service' => $event->getServiceAlias()), Router::ABSOLUTE_URL);
            $service->getAuthenticationConfiguration()->setOption('redirect_uri', $redirectUrl);

            $oauthToken = $service->getRequestToken();
            $this->session->set('oauth_token', $oauthToken->getToken()->getRequestToken());
            $event->setAuthentication($service->getAuthenticationUrl($oauthToken));
        }

        $this->session->set('authentication_action', $event->getAction());

    }


    public function onAutenticationResponse(OAuthAutenticationResponseEvent $event) {

        $service = $this->servicesManager->getService($event->getServiceAlias());
        $request = $this->requestStack->getCurrentRequest();
        $token = null;

        $action = $this->session->get('authentication_action');
        $this->session->remove('authentication_action');


        if ($service instanceof ServiceOAuth2) {

            $state = $this->session->get('authentication_state');
            $this->session->remove('authentication_state');
            $stateResponse = $request->query->get('state');

            if ($state != $stateResponse) {
                // exeption
                ldd("invalid state ".$state." != ".$stateResponse);
            }

            $code = $request->query->get('code');
            if (!$code) {
                // exeption
                ldd("no code");
            }

            $redirectUrl = $this->router->generate('oauth_authentication_code_response', array('service' => $event->getServiceAlias()), Router::ABSOLUTE_URL);
            $service->getAuthenticationConfiguration()->setOption('redirect_uri', $redirectUrl);

            $tokenResponse = $service->getAccessToken(new AuthorizationCode($code));

            if (!$tokenResponse->getToken()) {
                throw new \Exception($tokenResponse->getMessage(), $tokenResponse->getCode());
            }

            $token = $tokenResponse->getToken();
        }


        if ($service instanceof ServiceOAuth1) {

            $oauthToken = $request->query->get('oauth_token');
            $oauthVerifier = $request->query->get('oauth_verifier');
            $authOAuthToken = $this->session->get('oauth_token');
            $this->session->remove('oauth_token');

            if ($authOAuthToken != $oauthToken) {
                // exeption
                ldd("invalid token correspondance : Temporary identifier passed back by server does not match that of stored temporary credentials.
                Potential man-in-the-middle.");
            }


            $tokenResponse = $service->getOauthToken($oauthToken, $oauthVerifier);

            if (!$tokenResponse->getToken()) {
                throw new \Exception($tokenResponse->getMessage(), $tokenResponse->getCode());
            }

            $token = $tokenResponse->getToken();

        }







        $event->setToken($token);
        $event->setAction($action);
        $event->setService($service);
    }
}