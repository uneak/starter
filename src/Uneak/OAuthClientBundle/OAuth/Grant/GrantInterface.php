<?php

namespace Uneak\OAuthClientBundle\OAuth\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Authentication;
use Uneak\OAuthClientBundle\OAuth\Credentials;
use Uneak\OAuthClientBundle\OAuth\Server;

interface GrantInterface {

	public function buildRequestOptions(Credentials $credentials, Server $server, Authentication $authentication, $authType, array &$options);
	public function getName();

}
