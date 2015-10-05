<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2ConfigurationInterface;


class Password extends Grant {

	protected $username;
	protected $password;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration, AuthenticationOAuth2ConfigurationInterface $authenticationConfiguration, array &$options) {
		parent::buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['username'] = $this->username;
		$options['parameters']['password'] = $this->password;
	}

	public function getName() {
		return 'password';
	}



}
