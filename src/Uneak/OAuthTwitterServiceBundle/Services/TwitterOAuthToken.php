<?php

	namespace Uneak\OAuthTwitterServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessToken;
	use Uneak\OAuthClientBundle\OAuth\Token\OAuthToken;

	class TwitterOAuthToken extends OAuthToken {

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service'  => 'twitter',
			));
		}

	}