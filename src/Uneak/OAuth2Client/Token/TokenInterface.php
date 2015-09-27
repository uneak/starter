<?php

	namespace Uneak\OAuth2Client\Token;


	use Uneak\OAuth2Client\ConfigurationInterface;

    interface TokenInterface extends ConfigurationInterface {
        public function hasExpired();
        public function getExpiresTime();
        public function generateMACSignature(array $options);
	}


