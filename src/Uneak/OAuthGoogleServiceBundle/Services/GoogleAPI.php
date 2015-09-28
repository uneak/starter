<?php

	namespace Uneak\OAuthGoogleServiceBundle\Services;

    use Uneak\OAuthClientBundle\OAuth\API;
    use Uneak\OAuthClientBundle\OAuth\APIException;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;


    class GoogleAPI extends API {

        public function __construct(GoogleService $googleService, $apiUrl) {
            parent::__construct($googleService, $apiUrl);
        }


        public function me() {
            return $this->call('userinfo', array(
                'parameters' => array(
                ),
                'http_method' => CurlRequest::HTTP_METHOD_GET
            ));
        }




    }
