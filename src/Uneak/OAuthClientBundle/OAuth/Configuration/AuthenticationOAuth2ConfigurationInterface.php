<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;


    interface AuthenticationOAuth2ConfigurationInterface extends AuthenticationConfigurationInterface {

		public function getScope();
		public function getState();
		public function getRedirectUri();

	}
