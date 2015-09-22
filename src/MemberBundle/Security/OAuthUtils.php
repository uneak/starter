<?php

	namespace MemberBundle\Security;

	use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
	use HWI\Bundle\OAuthBundle\Security\OAuthUtils as HwiOAuthUtils;
	use Symfony\Component\HttpFoundation\Request;

	class OAuthUtils extends HwiOAuthUtils {

		/**
		 * @param Request                $request
		 * @param ResourceOwnerInterface $resourceOwner
		 *
		 * @return string
		 */
		public function getServiceAuthUrl(Request $request, ResourceOwnerInterface $resourceOwner) {
			if ($resourceOwner->getOption('auth_with_one_url')) {
				$redirectUrl = $this->httpUtils->generateUri($request, $this->ownerMap->getResourceOwnerCheckPath($resourceOwner->getName())) . '?authenticated=true';
			} else {
				$request->attributes->set('service', $resourceOwner->getName());
				$redirectUrl = $this->httpUtils->generateUri($request, 'member_oauth_connect_service');
			}

			return $redirectUrl;
		}

		/**
		 * @param Request $request
		 * @param string  $name
		 *
		 * @return string
		 */
		public function getLoginUrl(Request $request, $name) {
			// Just to check that this resource owner exists
			$this->getResourceOwner($name);

			$request->attributes->set('service', $name);

			return $this->httpUtils->generateUri($request, 'member_oauth_service_redirect');
		}
	}
