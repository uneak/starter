<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	use Uneak\OAuthClientBundle\OAuth\Signature\SignatureInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;

	interface AuthenticationOAuth1ConfigurationInterface extends AuthenticationConfigurationInterface {

		public function getAuthenticationPathArray(TokenResponse $tokenResponse);
		public function getAuthenticationPath(TokenResponse $tokenResponse);
		/**
		 * @return SignatureInterface
		 */
		public function getSignature();
	}
