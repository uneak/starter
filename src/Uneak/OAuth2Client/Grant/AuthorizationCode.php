<?php

namespace Uneak\OAuth2Client\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuth2Client\Credentials;
use Uneak\OAuth2Client\Server;
use Uneak\OAuth2Client\TokenRequester;

class AuthorizationCode extends Grant {

	protected $code;

	public function __construct($code) {
		$this->code = $code;
	}

	public function buildRequestOptions(Credentials $credentials, Server $server, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['redirect_uri'] = $server->getRedirectUrl();
		$options['parameters']['code'] = $this->code;
	}


	public function getName() {
		return 'authorization_code';
	}



}
