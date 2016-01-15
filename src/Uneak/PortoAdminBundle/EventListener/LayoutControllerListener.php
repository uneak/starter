<?php

namespace Uneak\PortoAdminBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\User\UserInterface;
use Uneak\BlocksManagerBundle\Blocks\BlockBuilder;
use Uneak\BlocksManagerBundle\Blocks\BlocksManager;
use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class LayoutControllerListener {



    public function onKernelController(FilterControllerEvent $event) {

        $controllerEvent = $event->getController();
        $controller = $controllerEvent[0];

        if ($controller instanceof LayoutEntityController) {
            $action = $controllerEvent[1];
            $controller->registerEvent($action);
        }

    }



}
