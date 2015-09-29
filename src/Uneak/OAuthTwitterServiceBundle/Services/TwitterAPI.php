<?php

	namespace Uneak\OAuthTwitterServiceBundle\Services;

    use Uneak\OAuthClientBundle\OAuth\API;
    use Uneak\OAuthClientBundle\OAuth\APIException;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
    use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;


    class TwitterAPI extends API {

        public function __construct(TwitterService $twitterService, $apiUrl) {
            parent::__construct($twitterService, $apiUrl);
        }


        public function me() {
            return $this->call('userinfo', array(
                'parameters' => array(
                ),
                'http_method' => CurlRequest::HTTP_METHOD_GET
            ));
        }




    }
