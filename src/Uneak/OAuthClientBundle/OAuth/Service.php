<?php

namespace Uneak\OAuthClientBundle\OAuth;


use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;
use Uneak\OAuthClientBundle\OAuth\Token\AccessToken;
use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;

abstract class Service implements ServiceInterface {

	protected $credentials;
	protected $server;
	protected $tokenResponse = null;
	protected $authentication;
	protected $api;

	public function __construct(Credentials $credentials, Server $server, Authentication $authentication = null, $apiUrl = null) {
		$this->credentials = $credentials;
		$this->server = $server;
		$this->authentication = $authentication;
        $this->api = new API($this, $apiUrl);
	}

    public function api() {
        return $this->api;
    }

    public function getUserInformations() {
        return $this->api->me();
    }

    public function getAuthentication() {
        return $this->authentication;
    }

	public function fetch(array $options) {
        if (!$this->getTokenResponse()) {
            // todo: exeption
            return null;
        }
		return Token::fetch($this->getTokenResponse(), $options);
	}

    public function requestToken(GrantInterface $grant, $authType = Token::AUTH_TYPE_URI) {
        $request = Token::request($this->credentials, $this->server, $this->authentication, $grant, $authType);
        $this->tokenResponse = $this->buildResponseToken($request);
        return $this->tokenResponse;
    }

    public function getTokenResponse() {
        return $this->tokenResponse;
    }

    protected function buildResponseToken(CurlRequest $request) {
        $response = $request->getResponse();
        $result = $response->getResult();
        $token = array();
        if (is_string($result)) {
            parse_str($result, $token);
        } else {
            $token = $result;
        }

        $code = $response->getCode();
        $accessToken = ($code == 200) ? new AccessToken($token) : null;
        $message = (isset($token['error_message'])) ? $token['error_message'] : null;

        return new TokenResponse($code, $message, $accessToken);
    }



}
