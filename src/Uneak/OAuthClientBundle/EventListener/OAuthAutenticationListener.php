<?php

namespace Uneak\OAuthClientBundle\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Uneak\OAuthClientBundle\Event\OAuthAutenticationRequestEvent;
use Uneak\OAuthClientBundle\Event\OAuthAutenticationResponseEvent;
use Uneak\OAuthClientBundle\OAuth\Authentication;
use Uneak\OAuthClientBundle\OAuth\Grant\AuthorizationCode;
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
        $redirectUrl = $this->router->generate('oauth_authentication_code_response', array('service' => $event->getServiceAlias()), Router::ABSOLUTE_URL);
        $authentication = $service->getAuthentication()->getUrl($redirectUrl);

        $state = $service->getAuthentication()->getState();
        $this->session->set('authentication_state', $state);
        $this->session->set('authentication_action', $event->getAction());

        $event->setAuthentication($authentication);

    }


    public function onAutenticationResponse(OAuthAutenticationResponseEvent $event) {

        $state = $this->session->get('authentication_state');
        $this->session->remove('authentication_state');

        $action = $this->session->get('authentication_action');
        $this->session->remove('authentication_action');

        $request = $this->requestStack->getCurrentRequest();
        $stateResponse = $request->query->get('state');
        $code = $request->query->get('code');

        if (!$code) {
            // exeption
            ldd("no code");
        }

        if ($state != $stateResponse) {
            // exeption
            ldd("invalid state");
        }

        $service = $this->servicesManager->getService($event->getServiceAlias());
        $redirectUrl = $this->router->generate('oauth_authentication_code_response', array('service' => $event->getServiceAlias()), Router::ABSOLUTE_URL);
        $authentication = $service->getAuthentication()->getUrl($redirectUrl);

        $service->requestToken(new AuthorizationCode($code));

        $event->setAction($action);
        $event->setService($service);
    }
}