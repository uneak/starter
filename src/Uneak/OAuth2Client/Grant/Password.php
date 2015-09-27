<?php

namespace Uneak\OAuth2Client\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuth2Client\Credentials;
use Uneak\OAuth2Client\Server;
use Uneak\OAuth2Client\TokenRequester;

class Password extends Grant {

	protected $username;
	protected $password;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function buildRequestOptions(Credentials $credentials, Server $server, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
		$options['parameters']['username'] = $this->username;
		$options['parameters']['password'] = $this->password;
	}

	public function getName() {
		return 'password';
	}



}
