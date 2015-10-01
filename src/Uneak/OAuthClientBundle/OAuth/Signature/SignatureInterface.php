<?php

namespace Uneak\OAuthClientBundle\OAuth\Signature;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth1ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1Configuration;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1ConfigurationInterface;


interface SignatureInterface {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentials, ServerOAuth1ConfigurationInterface $server, AuthenticationOAuth1ConfigurationInterface $authenticationConfiguration, array &$options);
	public function getName();

}
