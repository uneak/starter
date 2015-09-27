<?php

	namespace Uneak\OAuth2Client;

	interface ServerInterface extends ConfigurationInterface {

		public function getAuthEndpoint();
		public function getTokenEndpoint();
		public function getRedirectUrl();
	}
