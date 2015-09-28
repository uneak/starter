<?php

	namespace Uneak\OAuthClientBundle\OAuth;


	use Symfony\Component\OptionsResolver\OptionsResolver;

	interface ConfigurationInterface {
        public function configureOptions(OptionsResolver $resolver);
        public function getOption($key);
        public function getOptions();
        public function setOptions(array $options);
	}


