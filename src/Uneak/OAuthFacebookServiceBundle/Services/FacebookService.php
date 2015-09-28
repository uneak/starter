<?php

namespace Uneak\OAuthFacebookServiceBundle\Services;


    use Symfony\Component\PropertyAccess\PropertyAccess;
    use Uneak\OAuthClientBundle\OAuth\Authentication;
    use Uneak\OAuthClientBundle\OAuth\Credentials;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\Server;
    use Uneak\OAuthClientBundle\OAuth\Service;
    use Uneak\OAuthClientBundle\OAuth\Token\AccessToken;
    use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;


    class FacebookService extends Service {

        public function __construct(Credentials $credentials, Server $server, Authentication $authentication = null, $apiUrl = null ) {
            parent::__construct($credentials, $server, $authentication, $apiUrl);
            $this->api = new FacebookAPI($this, $apiUrl);
        }

        /**
         * @return FacebookAPI
         */
        public function api() {
            return $this->api;
        }


        public function getUserInformations() {

            $data = $this->api->me();

            $array = array(
                'id' => 'id',
                'firstName' => 'first_name',
                'lastName' => 'last_name',
                'username' => 'name',
                'email' => 'email',
                'picture' => 'picture.data.url'
            );

            foreach ($array as $internal => $external) {
                $externalPath = explode('.', $external);
                $value = $data;
                for($i=0; $i < count($externalPath); $i++) {
                    $value = $value[$externalPath[$i]];
                }
                $array[$internal] = $value;
            }

            return $array;
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
                $token = new AccessToken($tokenArray);
            }

            return new TokenResponse($code, $token, $type, $message);
        }

    }
