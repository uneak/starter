<?php

namespace Uneak\RoutesManagerBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Twig_Environment;
use Uneak\RoutesManagerBundle\Security\Authorization\Voter\RouteVoter;
use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
use Uneak\RoutesManagerBundle\Twig\Extension\RoutesManagerExtension;

class FlattenRouteControllerListener {

    private $router;
    private $twig;
	private $authorization;

    public function __construct(Router $router, Twig_Environment $twig, AuthorizationChecker $authorization) {
        $this->router = $router;
        $this->twig = $twig;
		$this->authorization = $authorization;
    }

    public function onKernelController(FilterControllerEvent $event) {

        $request = $event->getRequest();
        $routeCollection = $this->router->getRouteCollection();
        $route = $routeCollection->get($request->attributes->get('_route'));

        if ($route instanceof FlattenRoute) {

            $routeParams = $request->attributes->get('_route_params');

            foreach ($route->getParameters() as $key => $paramRoute) {
                $paramRoute->setParameterValue($routeParams[$key]);
                if ($paramRoute instanceof FlattenEntityRoute) {
                    $request->attributes->set($key, $paramRoute->getParameterSubject());
                }
            }


			if ($this->authorization->isGranted(RouteVoter::ROUTE_GRANTED, $route) === false) {
				throw new AccessDeniedException('Unauthorised access!');
			}

            $request->attributes->set('route', $route);

            $this->twig->addExtension(new RoutesManagerExtension($route));

        }
    }

}
