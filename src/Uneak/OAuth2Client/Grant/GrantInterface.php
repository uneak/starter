<?php

namespace Uneak\OAuth2Client\Grant;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuth2Client\Credentials;
use Uneak\OAuth2Client\Server;

interface GrantInterface {

	public function buildRequestOptions(Credentials $credentials, Server $server, $authType, array &$options);
	public function getName();

}
