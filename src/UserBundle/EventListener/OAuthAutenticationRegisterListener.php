<?php

namespace UserBundle\EventListener;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Uneak\OAuthClientBundle\Event\OAuthAutenticationActionEvent;

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

    public function __construct(Router $router, Session $session, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker) {
        $this->router = $router;
        $this->session = $session;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAutenticationRegister(OAuthAutenticationActionEvent $event) {

        $userInformations = $event->getService()->getUserInformations();

        $key = time();
        $this->session->set('authentication_user_informations_' . $key, $userInformations);
        $redirectUrl = $this->router->generate('user_registration_register', array('key' => $key));
        $event->setResponse(new RedirectResponse($redirectUrl));
    }

    public function onAutenticationConnect(OAuthAutenticationActionEvent $event) {

        $userInformations = $event->getService()->getUserInformations();
        $user = $this->tokenStorage->getToken()->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
//            throw new AccessDeniedException('This user does not have access to this section.');
                //TODO: exeptocp,
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->setValue($user, $event->getServiceAlias()."Id", $userInformations['id']);

        $this->userManager->updateUser($user);

        $redirectUrl = $this->router->generate('user_profile_connect');
        $event->setResponse(new RedirectResponse($redirectUrl));

    }

    public function onAutenticationLogin(OAuthAutenticationActionEvent $event) {

        $userInformations = $event->getService()->getUserInformations();
        $user = $this->userManager->findUserBy(array($event->getServiceAlias().'Id' => $userInformations['id']));

        if (null === $user) {

            $key = time();
            $this->session->set('authentication_user_informations_' . $key, $userInformations);
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