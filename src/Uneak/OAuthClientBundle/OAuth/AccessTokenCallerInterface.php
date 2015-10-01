<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 30/09/15
	 * Time: 07:11
	 */

	namespace Uneak\OAuthClientBundle\OAuth;

	use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;

	interface AccessTokenCallerInterface {

		/**
		 * @return AccessTokenInterface
		 */
		public function getAccessToken();

		/**
		 * @param AccessTokenInterface $accessToken
		 */
		public function setAccessToken(AccessTokenInterface $accessToken);

		/**
		 * @param array $options
		 *
		 * @return \Uneak\OAuthClientBundle\OAuth\Curl\CurlResponse
		 */
		public function fetch(array $options);

	}