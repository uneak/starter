<?php

	namespace Uneak\OAuthClientBundle\OAuth;


    use Uneak\OAuthClientBundle\OAuth\Configuration\ConfigurationInterface;

	interface ServiceUserInterface extends ConfigurationInterface {

		public function getId();
		public function getFirstName();
		public function getLastName();
		public function getLink();
		public function getUsername();
		public function getEmail();
		public function getPicture();
		public function getGender();
		public function getLocale();

		public function getData();
		public function setData(array $data);
	}
