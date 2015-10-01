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
        }

        protected function buildResponseToken(CurlRequest $request) {
            $response = $request->getResponse();
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
