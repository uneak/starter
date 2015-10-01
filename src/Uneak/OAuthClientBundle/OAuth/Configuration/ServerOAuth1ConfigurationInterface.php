<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	interface ServerOAuth1ConfigurationInterface extends ConfigurationInterface {
		public function getRequestTokenUrl();
		public function getAccessTokenUrl();
		public function getAuthorizeUrl();
	}
