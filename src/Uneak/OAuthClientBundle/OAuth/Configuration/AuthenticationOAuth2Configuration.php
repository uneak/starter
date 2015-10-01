<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	use Symfony\Component\OptionsResolver\OptionsResolver;


	class AuthenticationOAuth2Configuration extends Configuration implements AuthenticationOauth2ConfigurationInterface {

		protected $state;
		protected $scope;
		protected $redirectUrl;

		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service_type'  => 'oauth2',
				'response_type'   => 'code',
				'approval_prompt' => 'auto',
				'scope'           => null,
				'state'           => uniqid(),
				'redirect_uri'     => null,
			));

			$resolver->setRequired('redirect_uri');
			$resolver->setAllowedTypes('redirect_uri', 'string');
			$resolver->setAllowedTypes('scope', array('null', 'string'));
			$resolver->setAllowedTypes('state', array('null', 'string'));
		}


		public function getScope() {
			return $this->getOption('scope');
		}

		public function getState() {
			return $this->getOption('state');
		}

		public function getRedirectUri() {
			return $this->getOption('redirect_uri');
		}



		public function getAuthenticationPathArray(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration) {
			return array(
				'url'        => $serverConfiguration->getAuthEndpoint(),
				'parameters' => array(
					'response_type'   => $this->getOption('response_type'),
					'client_id'       => $credentialsConfiguration->getClientId(),
					'redirect_uri'    => $this->getOption('redirect_uri'),
					'scope'           => $this->getOption('scope'),
					'state'           => $this->getOption('state'),
					'approval_prompt' => $this->getOption('approval_prompt')
				)
			);
		}


		public function getAuthenticationPath(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration) {
			$array = $this->getAuthenticationPathArray($credentialsConfiguration, $serverConfiguration);
			return $array['url'] . '?' . http_build_query($array['parameters'], null, '&');
		}




	}
