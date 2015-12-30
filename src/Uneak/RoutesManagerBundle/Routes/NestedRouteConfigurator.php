<?php

namespace Uneak\RoutesManagerBundle\Routes;

use Uneak\RoutesManagerBundle\Routes\NestedRouteManager;
use Uneak\RoutesManagerBundle\Routes\NestedRoute;

class NestedRouteConfigurator {

    protected $nRouteManager = null;

    public function __construct(NestedRouteManager $nRouteManager) {
        $this->nRouteManager = $nRouteManager;
    }

    public function configure(NestedRoute $nestedRoute) {
//		var_dump("configure ".$nestedRoute->getId());
        $path = $nestedRoute->getParentPath();
		if ($path) {
			$re = "/^(.*?)\\.(.*)$|^(.*?)$/m";
			preg_match($re, $path, $matches);

			if (isset($matches[3])) {
				$admin = $matches[3];
				$child = null;
			} else {
				$admin = $matches[1];
				$child = $matches[2];
			}

			$parentRoute = $this->nRouteManager->getNestedRoute($admin, $child);

			if ($parentRoute) {
				$parentRoute->addChild($nestedRoute);
			}
        }
        
    }

}
