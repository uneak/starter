<?php

	namespace Uneak\OAuthGoogleServiceBundle\Services;

    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\ServiceAPI;


    class GoogleAPI extends ServiceAPI {

        public function __construct(GoogleService $googleService) {
            parent::__construct($googleService);
            $this->apiUrl = "https://www.googleapis.com/oauth2/v1";
        }

        public function userInformation() {
            $this->userinfo();
        }

        public function userinfo() {
            return $this->call('userinfo', array(
                'parameters' => array(),
                'http_method' => CurlRequest::HTTP_METHOD_GET
            ));
        }



    }
