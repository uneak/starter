<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;


	use Symfony\Component\OptionsResolver\OptionsResolver;

	interface ConfigurationInterface {
        public function configureOptions(OptionsResolver $resolver);
        public function getOption($key);
		public function setOption($key, $value);
        public function getOptions();
        public function setOptions(array $options);
		public function getService();
		public function getServiceType();
	}


