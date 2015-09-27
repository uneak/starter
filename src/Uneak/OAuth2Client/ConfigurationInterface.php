<?php

	namespace Uneak\OAuth2Client;


	use Symfony\Component\OptionsResolver\OptionsResolver;

	interface ConfigurationInterface extends \Serializable {
		function configureOptions(OptionsResolver $resolver);
		function getOption($key);
	}


