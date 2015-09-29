<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Exception;
use Uneak\OAuthClientBundle\OAuth\OAuth;


class Grant implements GrantInterface {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, $authType, array &$options) {

		$options['url'] = $serverConfiguration->getTokenEndpoint();
		$options['certificate_file'] = $credentialsConfiguration->getCertificateFile();
		$options['http_method'] = CurlRequest::HTTP_METHOD_POST;
		$options['form_content_type'] = CurlRequest::HTTP_FORM_CONTENT_TYPE_APPLICATION;

		switch ($authType) {
			case OAuth::AUTH_TYPE_URI:
			case OAuth::AUTH_TYPE_FORM:
				$options['parameters']['client_id'] = $credentialsConfiguration->getClientId();
				$options['parameters']['client_secret'] = $credentialsConfiguration->getClientSecret();
				break;
			case OAuth::AUTH_TYPE_AUTHORIZATION_BASIC:
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
