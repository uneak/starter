<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2ConfigurationInterface;

class ClientCredentials extends Grant {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration, AuthenticationOAuth2ConfigurationInterface $authenticationConfiguration, array &$options) {
		parent::buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);
		$options['parameters']['grant_type'] = $this->getName();
	}

	public function getName() {
		return 'client_credentials';
	}

}
