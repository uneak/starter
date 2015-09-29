<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;


class RefreshToken extends Grant {

	protected $refreshToken;

	public function __construct($refreshToken) {
		$this->refreshToken = $refreshToken;
	}

	public function buildRequestOptions(CredentialsConfigurationInterface $credentials, ServerConfigurationInterface $server, AuthenticationConfigurationInterface $authentication, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authentication, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['refresh_token'] = $this->refreshToken;
	}

	public function getName() {
		return 'refresh_token';
	}

}
