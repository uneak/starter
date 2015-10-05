<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2ConfigurationInterface;


interface GrantInterface {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration, AuthenticationOAuth2ConfigurationInterface $authenticationConfiguration, array &$options);
	public function getName();

}
