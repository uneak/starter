<?php

namespace Uneak\OAuthClientBundle\OAuth;


class Authentication {

	protected $credentials;
	protected $server;
	protected $state;
    protected $redirectUrl;

    public function __construct(Credentials $credentials, Server $server) {
		$this->credentials = $credentials;
		$this->server = $server;
		$this->state = uniqid();
	}

    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

	public function getState() {
		return $this->state;
	}

	public function getUrlArray($redirectUrl = null, array $scope = array(), $state = null) {
        if (!is_null($state)) {
            $this->state = $state;
        }

        $this->redirectUrl = (!is_null($redirectUrl)) ? $redirectUrl : $this->server->getRedirectUrl();

		return array(
			'url' => $this->server->getAuthEndpoint(),
			'parameters' => array(
				'response_type' => 'code',
				'client_id' => $this->credentials->getClientId(),
				'redirect_uri' => $this->redirectUrl,
				'scope' => $scope,
				'state' => $this->state,
				'approval_prompt' => 'auto'
			)
		);
	}

	public function getUrl($redirectUrl = null, array $scope = array(), $state = null) {
		$array = $this->getUrlArray($redirectUrl, $scope, $state);
		return $array['url'] . '?' . http_build_query($array['parameters'], null, '&');
	}


}
