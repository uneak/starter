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
				'service'         => 'twitter',
			));
		}


		/**
		 * @param \Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface $accessToken
		 */
		public function setTokenData(AccessTokenInterface $accessToken) {
			$fields = array('id', 'name', 'first_name', 'last_name', 'email', 'birthday', 'picture.type(large)');

			$response = OAuth::fetch($accessToken, array(
				'url' => 'https://graph.twitter.com/me',
				'parameters' => array(
					'fields' => join(',', $fields)
				),
				'http_method' => CurlRequest::HTTP_METHOD_GET
			));

			$this->setData($response->getResult());
		}


		protected function resolve() {
			if ($this->getData()) {
				$options = $this->adapter($this->getData(), array(
					'id'     => 'id_str',
					'username'       => 'screen_name',
					'picture' => 'profile_image_url_https',
				));
			} else {
				$options = $this->options;
			}

			$this->options = $this->resolver->resolve($options);
			$this->resolved = true;
		}

	}
