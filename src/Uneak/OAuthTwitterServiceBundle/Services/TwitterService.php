<?php

namespace Uneak\OAuthTwitterServiceBundle\Services;


    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\Service;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;


    class TwitterService extends Service {

        public function __construct(CredentialsConfigurationInterface $credentials, TwitterServerConfiguration $server, AuthenticationConfigurationInterface $authentication) {
            parent::__construct($credentials, $server, $authentication);
        }


        protected function buildResponseToken(CurlRequest $request) {
            $response = $request->getResponse();
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
                $token = new TwitterAccessToken($tokenArray);
            }

            return new TokenResponse($code, $token, $type, $message);
        }

    }
