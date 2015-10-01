<?php

	namespace Uneak\OAuthClientBundle\Event;

	use Symfony\Component\EventDispatcher\Event;

	class OAuthAutenticationRequestEvent extends Event {

		protected $serviceAlias;
		protected $action;
		protected $authentication;

		public function __construct($serviceAlias, $action) {
			$this->serviceAlias = $serviceAlias;
			$this->action = $action;
		}

		public function getServiceAlias() {
			return $this->serviceAlias;
		}


		public function getAction() {
			return $this->action;
		}

		/**
		 * @return mixed
		 */
		public function getAuthentication() {
			return $this->authentication;
		}

		/**
		 * @param mixed $authentication
		 */
		public function setAuthentication($authentication) {
			$this->authentication = $authentication;
		}


	}