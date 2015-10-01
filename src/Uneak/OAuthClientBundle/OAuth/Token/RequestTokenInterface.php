<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;


    interface RequestTokenInterface extends TokenInterface {
        public function getRequestToken();
        public function getRequestTokenSecret();
        public function getRequestCallbackConfirmed();
	}


