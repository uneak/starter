<?php

	namespace Uneak\OAuthClientBundle\OAuth;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration\Configuration;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;

	class AccessTokenCaller implements AccessTokenCallerInterface {

		/**
		 * @var AccessTokenInterface
		 */
		protected $accessToken;

		/**
		 * @return AccessTokenInterface
		 */
		public function getAccessToken() {
			return $this->accessToken;
		}

		/**
		 * @param AccessTokenInterface $accessToken
		 */
		public function setAccessToken(AccessTokenInterface $accessToken) {
			$this->accessToken = $accessToken;
		}

		/**
		 * @param array $options
		 *
		 * @return \Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse
		 */
		public function fetch(array $options) {
			return OAuth2::fetch($this->getAccessToken(), $options);
		}


	}

