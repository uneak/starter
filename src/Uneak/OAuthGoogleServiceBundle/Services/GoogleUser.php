<?php

	namespace Uneak\OAuthGoogleServiceBundle\Services;

	use Uneak\OAuthClientBundle\OAuth\ServiceUser;

	class GoogleUser extends ServiceUser {

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
