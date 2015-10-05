<?php

namespace Uneak\OAuthGoogleServiceBundle\Services;





    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;
    use Uneak\OAuthClientBundle\OAuth\ServiceOAuth2;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;

    class GoogleService extends ServiceOAuth2 {

        public function __construct(CredentialsConfigurationInterface $credentials, GoogleServerConfiguration $server, AuthenticationOAuth2ConfigurationInterface $authentication) {
            parent::__construct($credentials, $server, $authentication);
        }

        protected function buildAccessToken(CurlResponse $response) {
            $result = $response->getResult();

            $code = $response->getCode();
            $message = "Error";
            $type = "OAuthError";
            $token = null;

            if (is_array($result)) {
                if (isset($result['error'])) {
                    $message = $result['error'];
                } else {
                    $token = new GoogleAccessToken($result);
                    $type = "OAuthSuccess";
                    $message = "Success";
                }
            }

            return new TokenResponse($code, $token, $type, $message);
        }

    }
