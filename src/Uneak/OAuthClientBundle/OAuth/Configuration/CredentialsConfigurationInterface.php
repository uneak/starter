<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;


    interface CredentialsConfigurationInterface extends ConfigurationInterface {

		public function getClientId();
		public function getClientSecret();
		public function getCertificateFile();
	}
