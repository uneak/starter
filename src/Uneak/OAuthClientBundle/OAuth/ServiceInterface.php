<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;
    use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;
    use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;

    interface ServiceInterface {

        public function authenticationUrl();
        /**
         * @return CurlResponse
         */
        public function fetch(array $options);
        /**
         * @return ServiceUserInterface
         */
        public function getUser();
        /**
         * @return ServiceAPI
         */
        public function api();
        /**
         * @return TokenResponse
         */
        public function requestToken(GrantInterface $grant, $authType = OAuth::AUTH_TYPE_URI);
        /**
         * @return TokenResponse
         */
        public function getTokenResponse();
        /**
         * @return CredentialsConfigurationInterface
         */
        public function getCredentialsConfiguration();
        /**
         * @return ServerConfigurationInterface
         */
        public function getServerConfiguration();
        /**
         * @return AuthenticationConfigurationInterface
         */
        public function getAuthenticationConfiguration();


	}

