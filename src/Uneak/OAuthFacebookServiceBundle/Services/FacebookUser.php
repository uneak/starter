<?php

	namespace Uneak\OAuthFacebookServiceBundle\Services;

	use Uneak\OAuthClientBundle\OAuth\ServiceUser;

	class FacebookUser extends ServiceUser {

		protected function resolve() {
			$options = $this->adapter($this->getData(), array(
				'id'         => 'id',
				'first_name' => 'first_name',
				'last_name'  => 'last_name',
				'username'   => 'name',
				'email'      => 'email',
				'picture'    => 'picture.data.url'
			));

			$this->options = $this->resolver->resolve($options);
			$this->resolved = true;
		}

	}
