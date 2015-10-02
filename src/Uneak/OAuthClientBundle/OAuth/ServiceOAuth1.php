<?php

	namespace Uneak\OAuthClientBundle\OAuth;


	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth1ConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1ConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse;
	use Uneak\OAuthClientBundle\OAuth\Token\OAuthToken;
	use Uneak\OAuthClientBundle\OAuth\Token\RequestToken;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;


	class ServiceOAuth1 extends Service implements ServiceOAuth1Interface {



		public function __construct(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationOAuth1ConfigurationInterface $authenticationConfiguration) {
			parent::__construct($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration);
		}

		/**
		 * @return string
		 */
		public function getAuthenticationUrl(TokenResponse $tokenResponse) {
			return OAuth1::getAuthenticationUrl($this->getAuthenticationConfiguration(), $tokenResponse);
		}



		public function getRequestToken() {
			$response = OAuth1::getRequestToken($this->credentialsConfiguration, $this->getServerConfiguration(), $this->getAuthenticationConfiguration());
			$oauthToken = $this->buildRequestToken($response);
			return $oauthToken;
		}

		public function getOAuthToken($oauthToken, $oauthVerifier) {
			$response = OAuth1::getOAuthToken($this->credentialsConfiguration, $this->getServerConfiguration(), $this->getAuthenticationConfiguration(), $oauthToken, $oauthVerifier);
			$oauthToken = $this->buildOAuthToken($response);
			return $oauthToken;
		}


		protected function buildRequestToken(CurlResponse $response) {
			$result = $response->getResult();

			$code = $response->getCode();
			$message = "Error";
			$type = "OAuthError";
			$token = null;

			if (is_string($result)) {
				parse_str($result, $result);
			}

			if (is_array($result)) {
				if (isset($result['errors'])) {
					$messageArray = array();
					foreach ($result['errors'] as $error) {
						$messageArray[] = "error " . $error['code'] . ":" . $error['message'];
					}
					$message = join(" / ", $messageArray);
				} else {
					$token = new RequestToken($result);
					$type = "OAuthSuccess";
					$message = "Success";
				}
			}

			return new TokenResponse($code, $token, $type, $message);
		}


		protected function buildOAuthToken(CurlResponse $response) {
			$result = $response->getResult();

			$code = $response->getCode();
			$message = "Error";
			$type = "OAuthError";
			$token = null;

			if (is_string($result)) {
				parse_str($result, $result);
			}

			if (is_array($result)) {
				if (isset($result['error'])) {
					$message = $result['error'];
				} else {
					$token = new OAuthToken($result);
					$type = "OAuthSuccess";
					$message = "Success";
				}
			}

			return new TokenResponse($code, $token, $type, $message);
		}






		/**
		 * @return CredentialsConfigurationInterface
		 */
		public function getCredentialsConfiguration() {
			return $this->credentialsConfiguration;
		}

		/**
		 * @return ServerOAuth1ConfigurationInterface
		 */
		public function getServerConfiguration() {
			return $this->serverConfiguration;
		}

		/**
		 * @return AuthenticationOAuth1ConfigurationInterface
		 */
		public function getAuthenticationConfiguration() {
			return $this->authenticationConfiguration;
		}



	}
