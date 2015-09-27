<?php

	namespace Uneak\OAuth2Client\Token;


	class TokenResponse {

		protected $token;
		protected $code;
		protected $message;

		public function __construct($code, $message = null, $token = null) {
			$this->code = $code;
			$this->message = $message;
			$this->token = $token;
		}

		/**
		 * @return null
		 */
		public function getToken() {
			return $this->token;
		}

		/**
		 * @param null $token
		 */
		public function setToken($token) {
			$this->token = $token;
		}

		/**
		 * @return mixed
		 */
		public function getCode() {
			return $this->code;
		}

		/**
		 * @param mixed $code
		 */
		public function setCode($code) {
			$this->code = $code;
		}

		/**
		 * @return null
		 */
		public function getMessage() {
			return $this->message;
		}

		/**
		 * @param null $message
		 */
		public function setMessage($message) {
			$this->message = $message;
		}


	}