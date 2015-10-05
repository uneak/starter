<?php

namespace Uneak\OAuthTwitterServiceBundle\Services;


    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth1ConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;
    use Uneak\OAuthClientBundle\OAuth\ServiceOAuth1;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;


    class TwitterService extends ServiceOAuth1 {

        public function __construct(CredentialsConfigurationInterface $credentials, TwitterServerConfiguration $server, AuthenticationOAuth1ConfigurationInterface $authentication) {
            parent::__construct($credentials, $server, $authentication);
        }


        protected function buildRequestToken(CurlResponse $response) {
            $result = $response->getResult();

            $code = $response->getCode();
            $message = "Error";
            $type = "OAuthError";
            $token = null;

            if (is_string($result)) {
                parse_str($result, $result);
            }

            if (is_array($result)) {
                if (isset($result['errors'])) {
                    $messageArray = array();
                    foreach ($result['errors'] as $error) {
                        $messageArray[] = "error " . $error['code'] . ":" . $error['message'];
                    }
                    $message = join(" / ", $messageArray);
                } else {
                    $token = new TwitterRequestToken($result);
                    $type = "OAuthSuccess";
                    $message = "Success";
                }
            }

            return new TokenResponse($code, $token, $type, $message);
        }


        protected function buildOAuthToken(CurlResponse $response) {
            $result = $response->getResult();

            $code = $response->getCode();
            $message = "Error";
            $type = "OAuthError";
            $token = null;

            if (is_string($result)) {
                parse_str($result, $result);
            }

            if (is_array($result)) {
                if (isset($result['error'])) {
                    $message = $result['error'];
                } else {
                    $token = new TwitterOAuthToken($result);
                    $type = "OAuthSuccess";
                    $message = "Success";
                }
            }

            return new TokenResponse($code, $token, $type, $message);
        }

    }
