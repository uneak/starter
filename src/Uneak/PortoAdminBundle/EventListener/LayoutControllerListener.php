<?php

namespace Uneak\PortoAdminBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Routing\Router;
use Uneak\PortoAdminBundle\Controller\LayoutController;
use Uneak\PortoAdminBundle\Controller\LayoutControllerInterface;
use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;

class LayoutControllerListener {

    private $controller = null;
    private $router;

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function onKernelController(FilterControllerEvent $event) {
        $controller = $event->getController();
        $this->controller = $controller[0];

        if ($this->controller instanceof LayoutEntityController) {

            $request = $event->getRequest();
            $routeCollection = $this->router->getRouteCollection();
            $route = $routeCollection->get($request->attributes->get('_route'));

            if ($route instanceof FlattenRoute) {
                $this->controller->setRoute($route);
            }

        }

    }

    public function onKernelView(GetResponseForControllerResultEvent $event) {

        if ($this->controller instanceof LayoutControllerInterface) {

            $result = $event->getControllerResult();
            $parameters = (is_array($result)) ? $result : array();

            $event->setResponse($this->controller->render('{{ renderBlock("layout") }}', $parameters));

        }
    }


}
