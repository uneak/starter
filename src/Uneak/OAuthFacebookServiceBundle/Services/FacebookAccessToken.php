<?php

	namespace Uneak\OAuthFacebookServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessToken;

	class FacebookAccessToken extends AccessToken {

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
		}


	}