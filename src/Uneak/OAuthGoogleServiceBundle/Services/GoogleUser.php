<?php

	namespace Uneak\OAuthGoogleServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\OAuth;
	use Uneak\OAuthClientBundle\OAuth\ServiceUser;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenInterface;

	class GoogleUser extends ServiceUser {


		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service'         => 'google',
			));
		}



		public function setTokenData(TokenInterface $token) {
			$options = array(
				'url' => 'https://www.googleapis.com/oauth2/v1/userinfo',
				'http_method' => CurlRequest::HTTP_METHOD_GET,
			);

			$response = $this->service->fetch($token, $options);

			$this->setData($response->getResult());
		}

		public function setData(array $data) {
			$this->options = $this->adapter($data, array(
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
		}

	}
