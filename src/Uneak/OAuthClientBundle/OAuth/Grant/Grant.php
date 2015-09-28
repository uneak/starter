<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Authentication;
use Uneak\OAuthClientBundle\OAuth\Credentials;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Exception;
use Uneak\OAuthClientBundle\OAuth\Server;
use Uneak\OAuthClientBundle\OAuth\Token;
use Uneak\OAuthClientBundle\OAuth\TokenRequester;

class Grant implements GrantInterface {

	public function buildRequestOptions(Credentials $credentials, Server $server, Authentication $authentication, $authType, array &$options) {

		$options['url'] = $server->getTokenEndpoint();
		$options['certificate_file'] = $credentials->getCertificateFile();
		$options['http_method'] = CurlRequest::HTTP_METHOD_POST;
		$options['form_content_type'] = CurlRequest::HTTP_FORM_CONTENT_TYPE_APPLICATION;

		switch ($authType) {
			case Token::AUTH_TYPE_URI:
			case Token::AUTH_TYPE_FORM:
				$options['parameters']['client_id'] = $credentials->getClientId();
				$options['parameters']['client_secret'] = $credentials->getClientSecret();
				break;
			case Token::AUTH_TYPE_AUTHORIZATION_BASIC:
				$options['parameters']['client_id'] = $credentials->getClientId();
				$options['http_headers']['Authorization'] = 'Basic ' . base64_encode($credentials->getClientId() . ':' . $credentials->getClientSecret());
				break;
			default:
				throw new Exception('Unknown auth type.', Exception::INVALID_CLIENT_AUTHENTICATION_TYPE);
		}

	}


	public function getName() {
		return 'grant';
	}



}
