<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth2ConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth2ConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessToken;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;

	class ServiceOAuth2 extends Service implements ServiceOAuth2Interface {



		public function __construct(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth2ConfigurationInterface $serverConfiguration, AuthenticationOAuth2ConfigurationInterface $authenticationConfiguration) {
			parent::__construct($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration);
		}

		/**
		 * @return string
		 */
		public function authenticationUrl() {
			return OAuth2::authenticationUrl($this->credentialsConfiguration, $this->serverConfiguration, $this->authenticationConfiguration);
		}

		/**
		 * @param \Uneak\OAuthClientBundle\OAuth\Grant\GrantInterface $grant
		 * @param int                                                 $authType
		 *
		 * @return \Uneak\OAuthClientBundle\OAuth\Token\TokenResponse
		 */
		public function requestToken(GrantInterface $grant, $authType = OAuth2::AUTH_TYPE_URI) {
			$request = OAuth2::requestToken($this->credentialsConfiguration, $this->serverConfiguration, $this->authenticationConfiguration, $grant, $authType);
			return $this->buildResponseToken($request);
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
