<?php

namespace Uneak\OAuthFacebookServiceBundle\Services;


    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\Service;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;


    class FacebookService extends Service {

        public function __construct(CredentialsConfigurationInterface $credentials, FacebookServerConfiguration $server, AuthenticationConfigurationInterface $authentication) {
            parent::__construct($credentials, $server, $authentication);
            $this->api = new FacebookAPI($this);
        }

        public function getUser() {
            return new FacebookUser($this->api()->userInformation());
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
                $token = new FacebookAccessToken($tokenArray);
            }

            return new TokenResponse($code, $token, $type, $message);
        }

    }
