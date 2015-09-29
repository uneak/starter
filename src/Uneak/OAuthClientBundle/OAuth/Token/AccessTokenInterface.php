<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;


    use Uneak\OAuthClientBundle\OAuth\Configuration\ConfigurationInterface;

    interface AccessTokenInterface extends ConfigurationInterface {
        public function hasExpired();
        public function getExpiresTime();
        public function generateMACSignature(array $options);
	}


