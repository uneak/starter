<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2ConfigurationInterface;


class RefreshToken extends Grant {

	protected $refreshToken;

	public function __construct($refreshToken) {
		$this->refreshToken = $refreshToken;
	}

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration, AuthenticationOAuth2ConfigurationInterface $authenticationConfiguration, array &$options) {
		parent::buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['refresh_token'] = $this->refreshToken;
	}

	public function getName() {
		return 'refresh_token';
	}

}
