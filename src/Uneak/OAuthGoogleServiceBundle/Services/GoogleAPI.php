<?php

	namespace Uneak\OAuthGoogleServiceBundle\Services;

    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\ServiceAPI;


    class GoogleAPI extends ServiceAPI {

        public function __construct($apiUrl) {
            parent::__construct($apiUrl);
        }


        public function userinfo() {
            return $this->call('userinfo', array(
                'parameters' => array(),
                'http_method' => CurlRequest::HTTP_METHOD_GET
            ));
        }



    }
