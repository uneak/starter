<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;


class AuthorizationCode extends Grant {

	protected $code;

	public function __construct($code) {
		$this->code = $code;
	}

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, $authType, array &$options) {
		parent::buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['redirect_uri'] = $authenticationConfiguration->getOption('redirect_uri');
		$options['parameters']['code'] = $this->code;
	}


	public function getName() {
		return 'authorization_code';
	}



}
