<?php

	namespace Uneak\OAuthClientBundle\OAuth;

    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;

    abstract class ServiceAPI extends AccessTokenCaller {

        protected $apiUrl;

        public function __construct($apiUrl) {
            $this->apiUrl = $apiUrl;
        }

        public function call($function, $parameters) {
            $response = $this->fetch(array_merge(array(
                'url' => $this->apiUrl.'/'.$function,
            ), $parameters));
            return $this->_checkResponse($response);
        }

        protected function _checkResponse(CurlResponse $response) {
            $result = $response->getResult();
            if ($response->getCode() == 400) {
                throw new APIException($result['error']['message'], $result['error']['code']);
            }
            return $result;
        }

	}
