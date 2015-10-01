<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	use Symfony\Component\OptionsResolver\OptionsResolver;

	class ServerOAuth1Configuration extends Configuration implements ServerOAuth1ConfigurationInterface {


		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service_type'  => 'oauth1',
				'request_token_url'  => null,
				'access_token_url' => null
			));

			$resolver->setRequired(array('request_token_url', 'access_token_url'));
			$resolver->setAllowedTypes('request_token_url', 'string');
			$resolver->setAllowedTypes('access_token_url', 'string');
		}

		public function getRequestTokenUrl() {
			return $this->getOption('request_token_url');
		}

		public function getAccessTokenUrl() {
			return $this->getOption('access_token_url');
		}


	}
