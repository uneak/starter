<?php

namespace Uneak\OAuthFacebookServiceBundle\Services;

    use Uneak\OAuthClientBundle\OAuth\User;

    class FacebookUser extends User {

        public function __construct($data) {
            parent::__construct($data, array(
                'id' => 'id',
                'firstName' => 'first_name',
                'lastName' => 'last_name',
                'userName' => 'name',
                'email' => 'email',
                'picture' => 'picture.data.url'
            ));
        }


	}
