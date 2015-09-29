<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;


    interface AuthenticationConfigurationInterface extends ConfigurationInterface {

		public function getScope();
		public function getState();
		public function getRedirectUriArray(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration);
		public function getRedirectUri(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration);
	}
