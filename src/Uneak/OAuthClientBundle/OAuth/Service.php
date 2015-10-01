<?php

	namespace Uneak\OAuthClientBundle\OAuth;


	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessToken;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;

	abstract class Service implements ServiceInterface {

		/**
		 * @var TokenResponse
		 */
		protected $tokenResponse = null;
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

		/**
		 * @return string
		 */
		public function authenticationUrl() {
			return OAuth::authenticationUrl($this->credentialsConfiguration, $this->serverConfiguration, $this->authenticationConfiguration);
		}

		/**
		 * @param \Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface $grant
		 * @param int                                                 $authType
		 *
		 * @return \Uneak\OAuthClientBundle\OAuth\Token\TokenResponse
		 */
		public function requestToken(GrantInterface $grant, $authType = OAuth::AUTH_TYPE_URI) {
			$request = OAuth::requestToken($this->credentialsConfiguration, $this->serverConfiguration, $this->authenticationConfiguration, $grant, $authType);
			$this->tokenResponse = $this->buildResponseToken($request);
			return $this->tokenResponse;
		}

		/**
		 * @param \Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest $request
		 *
		 * @return \Uneak\OAuthClientBundle\OAuth\Token\TokenResponse
		 * @throws \Uneak\OAuthClientBundle\OAuth\Exception
		 */
		protected function buildResponseToken(CurlRequest $request) {
			$response = $request->getResponse();
			$result = $response->getResult();
			$token = array();
			if (is_string($result)) {
				parse_str($result, $token);
			} else {
				$token = $result;
			}

			$code = $response->getCode();
			$accessToken = ($code == 200) ? new AccessToken($token) : null;
			$message = (isset($token['error_message'])) ? $token['error_message'] : null;

			return new TokenResponse($code, $message, $accessToken);
		}



		/**
		 * @return \Uneak\OAuthClientBundle\OAuth\Token\TokenResponse
		 */
		public function getTokenResponse() {
			return $this->tokenResponse;
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
