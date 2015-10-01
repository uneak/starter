<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration\Configuration;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;

	class OAuthToken extends Configuration implements OAuthTokenInterface {

		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefined('user_id');
			$resolver->setDefined('screen_name');
			$resolver->setDefaults(array(
				'oauth_token'        => null,
				'oauth_token_secret' => null,
				'x_auth_expires'     => null,

			));

			$resolver->setRequired(array('oauth_token', 'oauth_token_secret'));
			$resolver->setAllowedTypes('oauth_token', 'string');
			$resolver->setAllowedTypes('oauth_token_secret', 'string');

		}

		public function getOAuthToken() {
			return $this->getOption('oauth_token');
		}

		public function getOAuthTokenSecret() {
			return $this->getOption('oauth_token_secret');
		}

		public function getXAuthExpires() {
			return $this->getOption('x_auth_expires');
		}

	}