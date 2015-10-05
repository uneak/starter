<?php

namespace Uneak\OAuthFacebookServiceBundle\Services;


    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;
    use Uneak\OAuthClientBundle\OAuth\Service;
    use Uneak\OAuthClientBundle\OAuth\ServiceOAuth2;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;


    class FacebookService extends ServiceOAuth2 {

        public function __construct(CredentialsConfigurationInterface $credentials, FacebookServerConfiguration $server, AuthenticationOAuth2ConfigurationInterface $authentication) {
            parent::__construct($credentials, $server, $authentication);
        }


        protected function buildAccessToken(CurlResponse $response) {
            $result = $response->getResult();

            $code = $response->getCode();
            $message = "Success";
            $type = "OAuthSuccess";
            $token = null;

            if (is_array($result)) {
                $code = $result['error']['code'];
                $message = $result['error']['message'];
                $type = $result['error']['type'];

            } else {
                $tokenArray = array();
                parse_str($result, $tokenArray);
                $token = new FacebookAccessToken($tokenArray);
            }

            return new TokenResponse($code, $token, $type, $message);
        }

    }
