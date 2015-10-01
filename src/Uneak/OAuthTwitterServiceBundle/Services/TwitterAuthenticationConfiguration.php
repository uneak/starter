<?php

	namespace Uneak\OAuthTwitterServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth1Configuration;


	class TwitterAuthenticationConfiguration extends AuthenticationOAuth1Configuration {

		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

	}
