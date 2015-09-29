<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	interface ServerConfigurationInterface extends ConfigurationInterface {

		public function getAuthEndpoint();
		public function getTokenEndpoint();
	}
