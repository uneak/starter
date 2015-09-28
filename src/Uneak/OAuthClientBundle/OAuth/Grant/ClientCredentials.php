<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Authentication;
use Uneak\OAuthClientBundle\OAuth\Credentials;
use Uneak\OAuthClientBundle\OAuth\Server;
use Uneak\OAuthClientBundle\OAuth\TokenRequester;

class ClientCredentials extends Grant {

	public function buildRequestOptions(Credentials $credentials, Server $server, Authentication $authentication, $authType, array &$options) {
		parent::buildRequestOptions($credentials, $server, $authentication, $authType, $options);
		$options['parameters']['grant_type'] = $this->getName();
	}

	public function getName() {
		return 'client_credentials';
	}

}
