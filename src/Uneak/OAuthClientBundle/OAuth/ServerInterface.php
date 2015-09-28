<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	interface ServerInterface extends ConfigurationInterface {

		public function getAuthEndpoint();
		public function getTokenEndpoint();

        public function getName();
	}
