<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;


    interface AuthenticationOAuth2ConfigurationInterface extends AuthenticationConfigurationInterface {

		public function getScope();
		public function getState();
		public function getRedirectUri();
		public function getAuthType();

		public function getAuthenticationPathArray(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration);
		public function getAuthenticationPath(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration);
	}
