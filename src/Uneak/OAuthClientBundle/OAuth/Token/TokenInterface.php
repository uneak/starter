<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;


	use Uneak\OAuthClientBundle\OAuth\ConfigurationInterface;

    interface TokenInterface extends ConfigurationInterface {
        public function hasExpired();
        public function getExpiresTime();
        public function generateMACSignature(array $options);
	}


