<?php

	namespace Uneak\OAuthTwitterServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\OAuth;
	use Uneak\OAuthClientBundle\OAuth\ServiceUser;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;

	class TwitterUser extends ServiceUser {


		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service' => 'twitter',
			));
		}


		/**
		 * @param \Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface $accessToken
		 */
		public function setTokenData(AccessTokenInterface $accessToken) {
			$options = array(
				'url' => 'https://api.twitter.com/1.1/account/verify_credentials.json',
				'http_method' => CurlRequest::HTTP_METHOD_GET,
				//                'curl_extras' => array(CURLOPT_VERBOSE => true),
				'parameters' => array(
					'include_email' => true,
				)
			);

			$result = OAuth1::fetch($service->getCredentialsConfiguration(), $service->getServerConfiguration(), $service->getAuthenticationConfiguration(), $token, $options);
			ldd($result);



			$this->setData($response->getResult());
		}


		protected function resolve() {
			if ($this->getData()) {
				$options = $this->adapter($this->getData(), array(
					'id'       => 'id_str',
					'username' => 'screen_name',
					'picture'  => 'profile_image_url',
					'locale'   => 'lang',
				));
			} else {
				$options = $this->options;
			}

			$this->options = $this->resolver->resolve($options);
			$this->resolved = true;
		}

	}
