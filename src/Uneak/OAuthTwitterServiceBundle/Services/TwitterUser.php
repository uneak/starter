<?php

	namespace Uneak\OAuthTwitterServiceBundle\Services;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\OAuth;
	use Uneak\OAuthClientBundle\OAuth\ServiceInterface;
	use Uneak\OAuthClientBundle\OAuth\ServiceUser;
	use Uneak\OAuthClientBundle\OAuth\Token\AccessTokenInterface;
	use Uneak\OAuthClientBundle\OAuth\Token\TokenInterface;

	class TwitterUser extends ServiceUser {


		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefaults(array(
				'service' => 'twitter',
			));
		}


		public function setTokenData(TokenInterface $token) {
			$options = array(
				'url' => 'https://api.twitter.com/1.1/account/verify_credentials.json',
				'http_method' => CurlRequest::HTTP_METHOD_GET,
				//                'curl_extras' => array(CURLOPT_VERBOSE => true),
				'parameters' => array(
					'include_email' => true,
				)
			);

			$response = $this->service->fetch($token, $options);
			$this->setData($response->getResult());
		}


		public function setData(array $data) {
			$this->options = $this->adapter($data, array(
				'id'       => 'id_str',
				'username' => 'screen_name',
				'picture'  => 'profile_image_url',
				'locale'   => 'lang',
			));
		}



	}
