<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Authentication;
use Uneak\OAuthClientBundle\OAuth\Credentials;
use Uneak\OAuthClientBundle\OAuth\Server;
use Uneak\OAuthClientBundle\OAuth\TokenRequester;

class Password extends Grant {

	protected $username;
	protected $password;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function buildRequestOptions(Credentials $credentials, Server $server, Authentication $authentication, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authentication, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['username'] = $this->username;
		$options['parameters']['password'] = $this->password;
	}

	public function getName() {
		return 'password';
	}



}
