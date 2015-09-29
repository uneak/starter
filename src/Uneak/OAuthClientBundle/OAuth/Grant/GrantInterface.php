<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;


interface GrantInterface {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentials, ServerConfigurationInterface $server, AuthenticationConfigurationInterface $authentication, $authType, array &$options);
	public function getName();

}
