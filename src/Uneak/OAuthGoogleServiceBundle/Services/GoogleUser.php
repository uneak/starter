<?php

	namespace Uneak\OAuthGoogleServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\OAuth;
	use Uneak\OAuthClientBundle\OAuth\ServiceUser;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;

	class GoogleUser extends ServiceUser {


		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service'         => 'google',
			));
		}


		/**
		 * @param \Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface $accessToken
		 */
		public function setTokenData(AccessTokenInterface $accessToken) {
			$response = OAuth::fetch($accessToken, array(
				'url' => 'https://www.googleapis.com/oauth2/v1/userinfo',
				'parameters' => array(),
				'http_method' => CurlRequest::HTTP_METHOD_GET
			));

			$this->setData($response->getResult());
		}



		protected function resolve() {
			$options = $this->adapter($this->getData(), array(
				'id'         => 'id',
				'first_name' => 'given_name',
				'last_name'  => 'family_name',
				'link'       => 'link',
				'username'   => 'name',
				'email'      => 'email',
				'picture'    => 'picture',
				'gender'     => 'gender',
				'locale'     => 'locale'
			));

			$this->options = $this->resolver->resolve($options);
			$this->resolved = true;
		}


	}
