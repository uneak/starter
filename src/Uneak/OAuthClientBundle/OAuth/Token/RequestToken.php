<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration\Configuration;

	class RequestToken extends Configuration implements RequestTokenInterface {

		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'oauth_token'    => null,
				'oauth_token_secret'    => null,
				'oauth_callback_confirmed' => null,
			));

			$resolver->setRequired(array('oauth_token', 'oauth_token_secret', 'oauth_callback_confirmed'));
			$resolver->setAllowedTypes('oauth_token', 'string');
			$resolver->setAllowedTypes('oauth_token_secret', 'string');
			$resolver->setAllowedTypes('oauth_callback_confirmed', 'string');

		}


		public function getRequestToken() {
			return $this->getOption('oauth_token');
		}

		public function getRequestTokenSecret() {
			return $this->getOption('oauth_token_secret');
		}

		public function getRequestCallbackConfirmed() {
			return $this->getOption('oauth_callback_confirmed');
		}
	}