<?php

	namespace Uneak\OAuth2Client;


    interface CredentialsInterface extends ConfigurationInterface {

		public function getClientId();
		public function getClientSecret();
		public function getCertificateFile();
	}
