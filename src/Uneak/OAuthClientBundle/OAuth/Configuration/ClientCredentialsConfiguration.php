<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;


	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\InvalidArgumentException;

	class ClientCredentialsConfiguration extends Configuration implements CredentialsConfigurationInterface {


		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'clientId'        => null,
				'clientSecret'    => null
			));

			$resolver->setRequired(array('clientId', 'clientSecret'));
			$resolver->setAllowedTypes('clientId', 'string');
			$resolver->setAllowedTypes('clientSecret', 'string');
			$resolver->setAllowedTypes('certificateFile', array('null', 'string'));
			$resolver->setNormalizer('certificateFile', function ($options, $value) {
				if (!empty($value) && !is_file($value)) {
					throw new InvalidArgumentException('The certificate file was not found', InvalidArgumentException::CERTIFICATE_NOT_FOUND);
				}

				return $value;
			});

		}

		public function getClientId() {
			return $this->getOption('clientId');
		}

		public function getClientSecret() {
			return $this->getOption('clientSecret');
		}

		public function getCertificateFile() {
			return $this->getOption('certificateFile');
		}


	}
