<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;


    interface OAuthTokenInterface extends TokenInterface {
        public function getOAuthToken();
        public function getOAuthTokenSecret();
        public function getXAuthExpires();
	}


