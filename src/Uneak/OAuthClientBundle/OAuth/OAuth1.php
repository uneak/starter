<?php

namespace Uneak\OAuthClientBundle\OAuth;


use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth1ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Token\OAuthTokenInterface;
use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;


class OAuth1 {




	public static function getRequestToken(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationOAuth1ConfigurationInterface $authenticationConfiguration) {
		$options = array();

		$options['http_method'] = CurlRequest::HTTP_METHOD_POST;
		$options['url'] = $serverConfiguration->getRequestTokenUrl();

		$options['oauth_parameters'] = array();
		$options['oauth_parameters']['oauth_consumer_key'] = $credentialsConfiguration->getClientId();
		$options['oauth_parameters']['oauth_nonce'] = md5(microtime(true).uniqid('', true));
		$options['oauth_parameters']['oauth_signature_method'] = $authenticationConfiguration->getSignature()->getName();
		$options['oauth_parameters']['oauth_timestamp'] = time();
		$options['oauth_parameters']['oauth_version'] = '1.0';

//		$options['oauth_parameters']['oauth_callback'] = $authenticationConfiguration->getRedirectUri();

		$authenticationConfiguration->getSignature()->buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);

		unset($options['oauth_parameters']);

		$request = new CurlRequest($options);
		return $request->getResponse();
	}


	public static function getOAuthToken(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationOAuth1ConfigurationInterface $authenticationConfiguration, $oauthToken, $oauthVerifier) {
		$options = array();

		$options['http_method'] = CurlRequest::HTTP_METHOD_POST;
		$options['url'] = $serverConfiguration->getAccessTokenUrl();

		$options['oauth_parameters'] = array();
		$options['oauth_parameters']['oauth_consumer_key'] = $credentialsConfiguration->getClientId();
		$options['oauth_parameters']['oauth_nonce'] = md5(microtime(true).uniqid('', true));
		$options['oauth_parameters']['oauth_signature_method'] = $authenticationConfiguration->getSignature()->getName();
		$options['oauth_parameters']['oauth_timestamp'] = time();
		$options['oauth_parameters']['oauth_version'] = '1.0';

		$options['oauth_parameters']['oauth_verifier'] = $oauthVerifier;
		$options['oauth_parameters']['oauth_token'] = $oauthToken;

		$authenticationConfiguration->getSignature()->buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);

		unset($options['oauth_parameters']);

		$request = new CurlRequest($options);
		return $request->getResponse();
	}


	public static function fetch(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationOAuth1ConfigurationInterface $authenticationConfiguration, OAuthTokenInterface $oauthToken, array $options) {

		$options['oauth_parameters'] = array();
		$options['oauth_parameters']['oauth_consumer_key'] = $credentialsConfiguration->getClientId();
		$options['oauth_parameters']['oauth_nonce'] = md5(microtime(true).uniqid('', true));
		$options['oauth_parameters']['oauth_signature_method'] = $authenticationConfiguration->getSignature()->getName();
		$options['oauth_parameters']['oauth_timestamp'] = time();
		$options['oauth_parameters']['oauth_version'] = '1.0';

		$options['oauth_parameters']['oauth_token'] = $oauthToken->getOAuthToken();
		$options['oauth_parameters']['oauth_token_secret'] = $oauthToken->getOAuthTokenSecret();


		if (isset($options['parameters']) && count($options['parameters'])) {
			$options['oauth_parameters'] = array_merge($options['oauth_parameters'], $options['parameters']);
		}

		$authenticationConfiguration->getSignature()->buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);

		unset($options['oauth_parameters']);

		$request = new CurlRequest($options);
		return $request->getResponse();
	}

	public static function getAuthenticationUrl(AuthenticationOAuth1ConfigurationInterface $authenticationConfiguration, TokenResponse $tokenResponse) {
		return $authenticationConfiguration->getAuthenticationPath($tokenResponse);

	}


}
