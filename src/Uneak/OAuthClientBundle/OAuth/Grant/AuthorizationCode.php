<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Authentication;
use Uneak\OAuthClientBundle\OAuth\Credentials;
use Uneak\OAuthClientBundle\OAuth\Server;
use Uneak\OAuthClientBundle\OAuth\TokenRequester;

class AuthorizationCode extends Grant {

	protected $code;

	public function __construct($code) {
		$this->code = $code;
	}

	public function buildRequestOptions(Credentials $credentials, Server $server, Authentication $authentication, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authentication, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['redirect_uri'] = $authentication->getRedirectUrl();
		$options['parameters']['code'] = $this->code;
	}


	public function getName() {
		return 'authorization_code';
	}



}
