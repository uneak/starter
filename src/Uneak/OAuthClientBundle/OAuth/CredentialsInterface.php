<?php

	namespace Uneak\OAuthClientBundle\OAuth;


    interface CredentialsInterface extends ConfigurationInterface {

		public function getClientId();
		public function getClientSecret();
		public function getCertificateFile();
	}
