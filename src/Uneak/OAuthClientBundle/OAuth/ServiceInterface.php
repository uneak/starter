<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;

    interface ServiceInterface {

        public function api();
        public function getUserInformations();
        public function getAuthentication();
        public function fetch(array $options);
        public function requestToken(GrantInterface $grant, $authType = Token::AUTH_TYPE_URI);
        public function getTokenResponse();

	}
