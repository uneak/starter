<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;


class Password extends Grant {

	protected $username;
	protected $password;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function buildRequestOptions(CredentialsConfigurationInterface $credentials, ServerConfigurationInterface $server, AuthenticationConfigurationInterface $authentication, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authentication, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['username'] = $this->username;
		$options['parameters']['password'] = $this->password;
	}

	public function getName() {
		return 'password';
	}



}
