<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	use Symfony\Component\OptionsResolver\OptionsResolver;


	class AuthenticationOAuth2Configuration extends Configuration implements AuthenticationOAuth2ConfigurationInterface {

		const AUTH_TYPE_URI = "AUTH_TYPE_URI";
		const AUTH_TYPE_AUTHORIZATION_BASIC = "AUTH_TYPE_AUTHORIZATION_BASIC";
		const AUTH_TYPE_FORM = "AUTH_TYPE_FORM";


		public function __construct(array $options = array()) {
			parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service_type'    => 'oauth2',
				'response_type'   => 'code',
				'approval_prompt' => 'auto',
				'scope'           => null,
				'state'           => uniqid(),
				'auth_type'       => self::AUTH_TYPE_URI,
				'redirect_uri'    => null,
			));

			$resolver->setRequired('redirect_uri');
			$resolver->setAllowedTypes('redirect_uri', 'string');
			$resolver->setAllowedTypes('scope', array('null', 'string'));
			$resolver->setAllowedTypes('state', array('null', 'string'));
			$resolver->setAllowedValues('auth_type', array(
				self::AUTH_TYPE_URI,
				self::AUTH_TYPE_AUTHORIZATION_BASIC,
				self::AUTH_TYPE_FORM
			));

		}

		public function getAuthType() {
			return $this->getOption('auth_type');
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


		public function getAuthenticationPathArray(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration) {
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


		public function getAuthenticationPath(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration) {
			$array = $this->getAuthenticationPathArray($credentialsConfiguration, $serverConfiguration);

			return $array['url'] . '?' . http_build_query($array['parameters'], null, '&');
		}


	}
