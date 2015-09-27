<?php

namespace Uneak\OAuth2Client\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuth2Client\Credentials;
use Uneak\OAuth2Client\Server;
use Uneak\OAuth2Client\TokenRequester;

class ClientCredentials extends Grant {

	public function buildRequestOptions(Credentials $credentials, Server $server, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
	}

	public function getName() {
		return 'client_credentials';
	}

}
