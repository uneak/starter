<?php

	namespace Uneak\OAuthClientBundle\OAuth;


    use Uneak\OAuthClientBundle\OAuth\Signature\SignatureInterface;

	interface ServiceOAuth1Interface extends ServiceInterface {

		public function getRequestToken();

	}
