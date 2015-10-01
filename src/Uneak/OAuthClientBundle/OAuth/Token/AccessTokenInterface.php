<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;


    interface AccessTokenInterface extends TokenInterface {
        public function hasExpired();
        public function getExpiresTime();
        public function generateMACSignature(array $options);
	}


