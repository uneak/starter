<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2ConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;
	use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessToken;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;

	class ServiceOAuth2 extends Service implements ServiceOAuth2Interface {



		public function __construct(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration, AuthenticationOAuth2ConfigurationInterface $authenticationConfiguration) {
			parent::__construct($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration);
		}

		/**
		 * @return string
		 */
		public function getAuthenticationUrl() {
			return OAuth2::getAuthenticationUrl($this->credentialsConfiguration, $this->serverConfiguration, $this->authenticationConfiguration);
		}


		public function fetch(TokenInterface $token, array $options) {
			return OAuth2::fetch($token, $options);
		}


		/**
		 * @param \Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface $grant
		 * @param int                                                 $authType
		 *
		 * @return \Uneak\OAuthClientBundle\OAuth\Token\TokenResponse
		 */
		public function getAccessToken(GrantInterface $grant) {
			$request = OAuth2::getAccessToken($this->credentialsConfiguration, $this->serverConfiguration, $this->authenticationConfiguration, $grant);
			return $this->buildAccessToken($request);
		}

		/**
		 *
		 * @return \Uneak\OAuthClientBundle\OAuth\Token\TokenResponse
		 * @throws \Uneak\OAuthClientBundle\OAuth\Exception
		 */
		protected function buildAccessToken(CurlResponse $response) {
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
		 * @return CredentialsConfigurationInterface
		 */
		public function getCredentialsConfiguration() {
			return $this->credentialsConfiguration;
		}

		/**
		 * @return ServerOAuth2ConfigurationInterface
		 */
		public function getServerConfiguration() {
			return $this->serverConfiguration;
		}

		/**
		 * @return AuthenticationOAuth2ConfigurationInterface
		 */
		public function getAuthenticationConfiguration() {
			return $this->authenticationConfiguration;
		}



	}
