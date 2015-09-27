<?php

namespace Uneak\OAuth2Client\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuth2Client\Credentials;
use Uneak\OAuth2Client\Curl\CurlRequest;
use Uneak\OAuth2Client\Exception;
use Uneak\OAuth2Client\Server;
use Uneak\OAuth2Client\Token;
use Uneak\OAuth2Client\TokenRequester;

class Grant implements GrantInterface {

	public function buildRequestOptions(Credentials $credentials, Server $server, $authType, array &$options) {

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
