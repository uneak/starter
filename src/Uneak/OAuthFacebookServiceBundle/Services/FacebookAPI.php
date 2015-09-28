<?php

	namespace Uneak\OAuthFacebookServiceBundle\Services;

    use Uneak\OAuthClientBundle\OAuth\API;
    use Uneak\OAuthClientBundle\OAuth\APIException;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;


    class FacebookAPI extends API {

        public function __construct(FacebookService $facebookService, $apiUrl) {
            parent::__construct($facebookService, $apiUrl);
        }


        public function me(array $fields = array('id', 'name', 'first_name', 'last_name', 'email', 'birthday', 'picture.type(large)')) {
            return $this->call('me', array(
                'parameters' => array(
                    'fields' => join(',', $fields)
                ),
                'http_method' => CurlRequest::HTTP_METHOD_GET
            ));
        }



        public function meFeed($message) {
            return $this->call('me/feed', array(
                'parameters' => array(
                    'message' => $message
                ),
                'http_method' => CurlRequest::HTTP_METHOD_POST
            ));
        }



        protected function _checkResponse(CurlResponse $response) {
            $result = $response->getResult();
            if ($response->getCode() == 400) {
                throw new APIException($result['error']['message'], $result['error']['code']);
            }
            return $result;
        }


    }
