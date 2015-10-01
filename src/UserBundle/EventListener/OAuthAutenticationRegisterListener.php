<?php

namespace UserBundle\EventListener;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Uneak\OAuthClientBundle\Entity\OAuthUser;
use Uneak\OAuthClientBundle\Event\OAuthAutenticationActionEvent;
use Uneak\OAuthClientBundle\OAuth\ServicesManager;

class OAuthAutenticationRegisterListener {

    /**
     * @var Router
     */
    private $router;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var UserManagerInterface
     */
    private $userManager;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * @var \Uneak\OAuthClientBundle\OAuth\ServicesManager
     */
    private $servicesManager;

    public function __construct(ServicesManager $servicesManager, Router $router, Session $session, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker, EntityManager $em) {
        $this->router = $router;
        $this->session = $session;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->em = $em;
        $this->servicesManager = $servicesManager;
    }

    public function onAutenticationRegister(OAuthAutenticationActionEvent $event) {

        $serviceUser = $this->servicesManager->getUser($event->getToken());

        $key = time();
        $this->session->set('authentication_service_user_' . $key, $serviceUser->getOptions());
        $redirectUrl = $this->router->generate('user_registration_register', array('key' => $key));
        $event->setResponse(new RedirectResponse($redirectUrl));
    }

    public function onAutenticationConnect(OAuthAutenticationActionEvent $event) {

        $serviceUser = $this->servicesManager->getUser($event->getToken());
        $user = $this->tokenStorage->getToken()->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $oAuthUser = $this->em->getRepository("UserBundle:User")->findOAuthUser($event->getServiceAlias(), $serviceUser->getId());
        if (!$oAuthUser) {
            $oAuthUser = new OAuthUser();
            $oAuthUser->setService($serviceUser->getService());
            $oAuthUser->setId($serviceUser->getId());
            $this->em->persist($oAuthUser);
        }
        $oAuthUser->setData($serviceUser->getOptions());
        $oAuthUser->setToken($event->getToken()->getOptions());
        $oAuthUser->setUser($user);

        $this->em->flush();

        $redirectUrl = $this->router->generate('user_profile_connect');
        $event->setResponse(new RedirectResponse($redirectUrl));

    }

    public function onAutenticationLogin(OAuthAutenticationActionEvent $event) {

        $serviceUser = $this->servicesManager->getUser($event->getToken());
        $user = $this->userManager->findOAuthUser($serviceUser->getService(), $serviceUser->getId());

        if (null === $user) {

            $key = time();
            $this->session->set('authentication_service_user_' . $key, $serviceUser->getOptions());
            $redirectUrl = $this->router->generate('user_registration_register', array('key' => $key));
            $event->setResponse(new RedirectResponse($redirectUrl));

        } else {

            $token = new UsernamePasswordToken($user, $user->getPassword(), 'user', $user->getRoles());
            $this->tokenStorage->setToken($token);

            $redirectUrl = $this->router->generate('user_profile_show');
            $event->setResponse(new RedirectResponse($redirectUrl));

        }

    }
}