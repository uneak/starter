<?php

namespace Uneak\OAuth2Client;


use Symfony\Component\HttpFoundation\Session\Session;

abstract class OAuth2 {

	protected $credentials = null;
	protected $server = null;

	public function __construct(Credentials $credentials, Server $server) {
		$this->credentials = $credentials;
		$this->server = $server;
	}

	public function fetch(array $options) {
		return Token::fetch($this->getTokenContainer(), $options);
	}

	abstract public function getTokenContainer();

}
