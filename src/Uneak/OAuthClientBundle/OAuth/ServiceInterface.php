<?php

	namespace Uneak\OAuthClientBundle\OAuth;

    use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;
    use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;

    interface ServiceInterface {

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

