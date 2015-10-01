<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	interface ServerOAuth1ConfigurationInterface extends ServerConfigurationInterface {
		public function getRequestTokenUrl();
		public function getAccessTokenUrl();
	}
