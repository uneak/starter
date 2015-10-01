<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	interface ServerOAuth2ConfigurationInterface extends ServerConfigurationInterface {

		public function getAuthEndpoint();
		public function getTokenEndpoint();
	}
