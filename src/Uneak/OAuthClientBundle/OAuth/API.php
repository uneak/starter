<?php

	namespace Uneak\OAuthClientBundle\OAuth;


    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;

    class API {

        protected $apiUrl;
        /**
         * @var Service
         */
        private $service;

        public function __construct(Service $service, $apiUrl) {
            $this->apiUrl = $apiUrl;
            $this->service = $service;
        }

        public function call($function, $parameters) {
            $response = $this->service->fetch(array_merge(array(
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
