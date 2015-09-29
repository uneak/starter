<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;


	class TokenResponse {

		protected $token;
		protected $code;
		protected $message;
		protected $type;

		public function __construct($code, AccessTokenInterface $token = null, $type = null, $message = null) {
			$this->code = $code;
            $this->token = $token;
            $this->type = $type;
            $this->message = $message;
		}

		/**
		 * @return AccessTokenInterface|null
		 */
		public function getToken() {
			return $this->token;
		}

		/**
		 * @param AccessTokenInterface $token
		 */
		public function setToken($token) {
			$this->token = $token;
		}

		/**
		 * @return string
		 */
		public function getCode() {
			return $this->code;
		}

		/**
		 * @param string $code
		 */
		public function setCode($code) {
			$this->code = $code;
		}

		/**
		 * @return string
		 */
		public function getMessage() {
			return $this->message;
		}

		/**
		 * @param string $message
		 */
		public function setMessage($message) {
			$this->message = $message;
		}

        /**
         * @return string
         */
        public function getType()
        {
            return $this->type;
        }

        /**
         * @param string $type
         */
        public function setType($type)
        {
            $this->type = $type;
        }


	}