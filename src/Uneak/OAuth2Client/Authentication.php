<?php

namespace Uneak\OAuth2Client;


class Authentication {

	protected $credentials;
	protected $server;
	protected $state;

	public function __construct(Credentials $credentials, Server $server) {
		$this->credentials = $credentials;
		$this->server = $server;
		$this->state = uniqid();
	}

	public function getState() {
		return $this->state;
	}

	public function getUrlArray(array $scope = array(), $state = null) {
        if (!is_null($state)) {
            $this->state = $state;
        }

		return array(
			'url' => $this->server->getAuthEndpoint(),
			'parameters' => array(
				'response_type' => 'code',
				'client_id' => $this->credentials->getClientId(),
				'redirect_uri' => $this->server->getRedirectUrl(),
				'scope' => $scope,
				'state' => $this->state,
				'approval_prompt' => 'auto'
			)
		);
	}

	public function getUrl(array $scope = array()) {
		$array = $this->getUrlArray($scope);
		return $array['url'] . '?' . http_build_query($array['parameters'], null, '&');
	}


}
