<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2Configuration;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Exception;


class Grant implements GrantInterface {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration, AuthenticationOAuth2ConfigurationInterface $authenticationConfiguration, array &$options) {

		$options['url'] = $serverConfiguration->getTokenEndpoint();
		$options['certificate_file'] = $credentialsConfiguration->getCertificateFile();
		$options['http_method'] = CurlRequest::HTTP_METHOD_POST;
		$options['form_content_type'] = CurlRequest::HTTP_FORM_CONTENT_TYPE_APPLICATION;

		switch ($authenticationConfiguration->getAuthType()) {
			case AuthenticationOAuth2Configuration::AUTH_TYPE_URI:
			case AuthenticationOAuth2Configuration::AUTH_TYPE_FORM:
				$options['parameters']['client_id'] = $credentialsConfiguration->getClientId();
				$options['parameters']['client_secret'] = $credentialsConfiguration->getClientSecret();
				break;
			case AuthenticationOAuth2Configuration::AUTH_TYPE_AUTHORIZATION_BASIC:
				$options['parameters']['client_id'] = $credentialsConfiguration->getClientId();
				$options['http_headers']['Authorization'] = 'Basic ' . base64_encode($credentialsConfiguration->getClientId() . ':' . $credentialsConfiguration->getClientSecret());
				break;
			default:
				throw new Exception('Unknown auth type.', Exception::INVALID_CLIENT_AUTHENTICATION_TYPE);
		}

	}


	public function getName() {
		return 'grant';
	}

}
