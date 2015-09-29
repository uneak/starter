<?php

namespace Uneak\OAuthGoogleServiceBundle\Services;





    use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\Service;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;

    class GoogleService extends Service {

        public function __construct(CredentialsConfigurationInterface $credentials, GoogleServerConfiguration $server, AuthenticationConfigurationInterface $authentication) {
            parent::__construct($credentials, $server, $authentication);
            $this->api = new GoogleAPI($this);
        }

        public function getUser() {
            return new GoogleUser($this->api()->userInformation());
        }

        protected function buildResponseToken(CurlRequest $request) {
            $response = $request->getResponse();
            $result = $response->getResult();

            $code = $response->getCode();
            $message = "Success";
            $type = "OAuthSuccess";
            $token = null;

            if (is_array($result)) {
                $token = new GoogleAccessToken($result);
            }

            return new TokenResponse($code, $token, $type, $message);
        }

    }
