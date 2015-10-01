<?php

namespace Uneak\OAuthClientBundle\OAuth;

use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;
use Uneak\OAuthClientBundle\OAuth\Signature\SignatureInterface;


class OAuth1 {


	public static function getRequestToken(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, SignatureInterface $signature) {
		$options = array();
		$signature->buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);

		ld($options);
		$request = new CurlRequest($options);
		return $request->getResponse();
	}


	public static function getAccessToken(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, GrantInterface $grant, $authType = OAuth::AUTH_TYPE_URI) {
		$options = array();
		$grant->buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $authType, $options);
		return new CurlRequest($options);
	}



}
