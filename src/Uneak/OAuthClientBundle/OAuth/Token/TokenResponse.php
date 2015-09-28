<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;


	class TokenResponse {

		protected $token;
		protected $code;
		protected $message;
		protected $type;

		public function __construct($code, $token = null, $type = null, $message = null) {
			$this->code = $code;
            $this->token = $token;
            $this->type = $type;
            $this->message = $message;
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

        /**
         * @return null
         */
        public function getType()
        {
            return $this->type;
        }

        /**
         * @param null $type
         */
        public function setType($type)
        {
            $this->type = $type;
        }


	}