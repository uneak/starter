<?php

namespace Uneak\OAuth2Client;

use Uneak\OAuth2Client\Curl\CurlRequest;
use Uneak\OAuth2Client\Grant\GrantInterface;
use Uneak\OAuth2Client\Token\AccessToken;
use Uneak\OAuth2Client\Token\TokenResponse;

class Token {

	const AUTH_TYPE_URI = 0;
	const AUTH_TYPE_AUTHORIZATION_BASIC = 1;
	const AUTH_TYPE_FORM = 2;
	
	
	public static function fetch(TokenResponse $tokenResponse, array $options) {

		if ($tokenResponse->getCode() == 200) {
			$token = $tokenResponse->getToken();
		} else if ($tokenResponse->getCode() >= 400) {
			throw new Exception($tokenResponse->getCode()." : ".$tokenResponse->getMessage(), Exception::REQUEST_ACCESS_TOKEN_ERROR);
		}

		switch ($token->getOption('token_type')) {
			case AccessToken::ACCESS_TOKEN_URI:
				if (is_array($options['parameters'])) {
					$options['parameters']['access_token'] = $token->getOption('access_token');
				} else {
					throw new InvalidArgumentException(
						'You need to give parameters as array if you want to give the token within the URI.', InvalidArgumentException::REQUIRE_PARAMS_AS_ARRAY
					);
				}
				break;
			case AccessToken::ACCESS_TOKEN_BEARER:
				$options['http_headers']['Authorization'] = 'Bearer ' . $token->getOption('access_token');
				break;
			case AccessToken::ACCESS_TOKEN_OAUTH:
				$options['http_headers']['Authorization'] = 'OAuth ' . $token->getOption('access_token');
				break;
			case AccessToken::ACCESS_TOKEN_MAC:
				$options['http_headers']['Authorization'] = 'MAC ' . $token->generateMACSignature($options);
				break;
			default:
				throw new Exception('Unknown access token type.', Exception::INVALID_ACCESS_TOKEN_TYPE);
		}

		$request = new CurlRequest($options);
		return $request->getResponse();
	}



	public static function request(Credentials $credentials, Server $server, GrantInterface $grant, $authType = Token::AUTH_TYPE_URI) {
		$options = array();
		$grant->buildRequestOptions($credentials, $server, $authType, $options);

		$request = new CurlRequest($options);
		$response = $request->getResponse();

		return $response;

//		$code = $response->getCode();
//		$result = $response->getResult();
//
//		$token = null;
//		if ($code == 200) {
//			$token = new AccessToken($result);
//
//		} else if ($code >= 400) {
//			ldd($result);
//			throw new Exception($result['code']."/".$result['error_message']."/".$result['error_message'], Exception::REQUEST_ACCESS_TOKEN_ERROR);
//		}
//
//		return $token;
	}

}
