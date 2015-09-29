<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	use Symfony\Component\OptionsResolver\OptionsResolver;

	class ServerConfiguration extends Configuration implements ServerConfigurationInterface {


		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'authEndpoint'  => null,
				'tokenEndpoint' => null,
			));

			$resolver->setRequired(array('authEndpoint', 'tokenEndpoint'));
			$resolver->setAllowedTypes('authEndpoint', 'string');
			$resolver->setAllowedTypes('tokenEndpoint', 'string');
		}

		public function getAuthEndpoint() {
			return $this->getOption('authEndpoint');
		}

		public function getTokenEndpoint() {
			return $this->getOption('tokenEndpoint');
		}


	}
