<?php

	namespace Uneak\OAuthClientBundle\OAuth;


    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;

    abstract class ServiceAPI {

        protected $apiUrl;
        /**
         * @var ServiceInterface
         */
        private $service;

        public function __construct(ServiceInterface $service) {
            $this->apiUrl = "";
            $this->service = $service;
        }


        abstract public function userInformation();


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
