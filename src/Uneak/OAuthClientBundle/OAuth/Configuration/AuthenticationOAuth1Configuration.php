<?php

	namespace Uneak\OAuthClientBundle\OAuth\Configuration;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Signature\HmacSha1Signature;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenResponse;


	class AuthenticationOAuth1Configuration extends Configuration implements AuthenticationOAuth1ConfigurationInterface {

		protected $state;
		protected $scope;
		protected $redirectUrl;
		protected $signature;

		public function __construct(array $options = array()) {
			parent::__construct($options);
			$this->signature = new HmacSha1Signature();
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service_type'  => 'oauth2',
				'authorize_url' => null,
				'redirect_uri'  => null,
			));

			$resolver->setRequired('authorize_url');
			$resolver->setRequired('redirect_uri');
			$resolver->setAllowedTypes('redirect_uri', 'string');
			$resolver->setAllowedTypes('authorize_url', 'string');
		}


		public function getAuthorizeUrl() {
			return $this->getOption('authorize_url');
		}

		public function getRedirectUri() {
			return $this->getOption('redirect_uri');
		}

		public function getSignature() {
			return $this->signature;
		}

		public function getAuthenticationPathArray(TokenResponse $tokenResponse) {
			return array(
				'url'        => $this->getAuthorizeUrl(),
				'parameters' => array(
					'oauth_token' => $tokenResponse->getToken()->getRequestToken(),
				)
			);
		}

		public function getAuthenticationPath(TokenResponse $tokenResponse) {
			$array = $this->getAuthenticationPathArray($tokenResponse);

			return $array['url'] . '?' . http_build_query($array['parameters'], null, '&');
		}


	}
