<?php

namespace Uneak\OAuth2Client\Grant;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuth2Client\Credentials;
use Uneak\OAuth2Client\Server;
use Uneak\OAuth2Client\TokenRequester;

class RefreshToken extends Grant {

	protected $refreshToken;

	public function __construct($refreshToken) {
		$this->refreshToken = $refreshToken;
	}

	public function buildRequestOptions(Credentials $credentials, Server $server, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['refresh_token'] = $this->refreshToken;
	}

	public function getName() {
		return 'refresh_token';
	}

}
