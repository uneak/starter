<?php

namespace Uneak\OAuthClientBundle\OAuth;

use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;
use Uneak\OAuthClientBundle\OAuth\Token\AccessToken;
use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;

class OAuth2 {

	const AUTH_TYPE_URI = 0;
	const AUTH_TYPE_AUTHORIZATION_BASIC = 1;
	const AUTH_TYPE_FORM = 2;


	/**
	 * @param \Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface $accessToken
	 * @param array                                                     $options
	 *
	 * @return \Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse
	 * @throws \Uneak\OAuthClientBundle\OAuth\Exception
	 */
	public static function fetch(AccessTokenInterface $accessToken, array $options) {

		switch ($accessToken->getOption('token_type')) {
			case AccessToken::ACCESS_TOKEN_URI:
				if (is_array($options['parameters'])) {
					$options['parameters']['access_token'] = $accessToken->getOption('access_token');
				} else {
					throw new InvalidArgumentException(
						'You need to give parameters as array if you want to give the token within the URI.', InvalidArgumentException::REQUIRE_PARAMS_AS_ARRAY
					);
				}
				break;
			case AccessToken::ACCESS_TOKEN_BEARER:
				$options['http_headers']['Authorization'] = 'Bearer ' . $accessToken->getOption('access_token');
				break;
			case AccessToken::ACCESS_TOKEN_OAUTH:
				$options['http_headers']['Authorization'] = 'OAuth ' . $accessToken->getOption('access_token');
				break;
			case AccessToken::ACCESS_TOKEN_MAC:
				$options['http_headers']['Authorization'] = 'MAC ' . $accessToken->generateMACSignature($options);
				break;
			default:
				throw new Exception('Unknown access token type.', Exception::INVALID_ACCESS_TOKEN_TYPE);
		}

		$request = new CurlRequest($options);
		return $request->getResponse();
	}


	/**
	 * @param \Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface    $credentialsConfiguration
	 * @param \Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface         $serverConfiguration
	 * @param \Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface $authenticationConfiguration
	 * @param \Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface                               $grant
	 * @param int                                                                               $authType
	 *
	 * @return \Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest
	 */
	public static function requestToken(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, GrantInterface $grant, $authType = OAuth::AUTH_TYPE_URI) {
		$options = array();
		$grant->buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $authType, $options);
		return new CurlRequest($options);
	}


	/**
	 * @param \Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface    $credentialsConfiguration
	 * @param \Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface         $serverConfiguration
	 * @param \Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface $authenticationConfiguration
	 *
	 * @return string
	 */
	public static function authenticationUrl(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration) {
		return $authenticationConfiguration->getRedirectUri($credentialsConfiguration, $serverConfiguration);

	}

}
