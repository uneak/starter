<?php

	namespace Uneak\OAuthFacebookServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\ServiceUser;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenInterface;

	class FacebookUser extends ServiceUser {


		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service'         => 'facebook',
			));
		}

		public function setTokenData(TokenInterface $token) {

			$fields = array('id', 'name', 'first_name', 'last_name', 'email', 'birthday', 'picture.type(large)');

			$options = array(
				'url' => 'https://graph.facebook.com/me',
				'parameters' => array(
					'fields' => join(',', $fields)
				),
				'http_method' => CurlRequest::HTTP_METHOD_GET
			);

			$response = $this->service->fetch($token, $options);

			$this->setData($response->getResult());
		}

		public function setData(array $data) {
			$this->options = $this->adapter($data, array(
				'id'         => 'id',
				'first_name' => 'first_name',
				'last_name'  => 'last_name',
				'username'   => 'name',
				'email'      => 'email',
				'picture'    => 'picture.data.url'
			));
		}


	}
