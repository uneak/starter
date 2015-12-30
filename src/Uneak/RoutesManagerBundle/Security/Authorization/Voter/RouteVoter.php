<?php

namespace Uneak\RoutesManagerBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 *
 *
 * @author marc
 */
class RouteVoter extends AbstractVoter {

	const ROUTE_GRANTED = "ROUTE_GRANTED";

	protected function getSupportedAttributes() {
		return array(self::ROUTE_GRANTED);
	}

	protected function getSupportedClasses() {
		return array('Uneak\RoutesManagerBundle\Routes\FlattenRoute');
	}

	protected function isGranted($attribute, $flattenRoute, $user = null) {

		if (!$user instanceof UserInterface) {
			return false;
		}

		return $flattenRoute->isGranted($attribute, $user);

	}


}
