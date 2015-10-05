<?php

	namespace Uneak\OAuthClientBundle\OAuth;


	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenInterface;

	class Service implements ServiceInterface {

		/**
		 * @var \Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface
		 */
		protected $credentialsConfiguration;
		/**
		 * @var \Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface
		 */
		protected $serverConfiguration;
		/**
		 * @var \Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface
		 */
		protected $authenticationConfiguration;


		public function __construct(CredentialsConfigurationInterface $credentialsConfiguration, ServerConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration) {
			$this->credentialsConfiguration = $credentialsConfiguration;
			$this->serverConfiguration = $serverConfiguration;
			$this->authenticationConfiguration = $authenticationConfiguration;
		}

		public function fetch(TokenInterface $token, array $options) {
			// abstract
		}


		/**
		 * @return CredentialsConfigurationInterface
		 */
		public function getCredentialsConfiguration() {
			return $this->credentialsConfiguration;
		}

		/**
		 * @return ServerConfigurationInterface
		 */
		public function getServerConfiguration() {
			return $this->serverConfiguration;
		}

		/**
		 * @return AuthenticationConfigurationInterface
		 */
		public function getAuthenticationConfiguration() {
			return $this->authenticationConfiguration;
		}


	}
