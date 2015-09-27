<?php

	namespace Uneak\OAuth2Client\Token;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuth2Client\Curl\CurlRequest;

	class AccessToken implements TokenInterface {

		const ACCESS_TOKEN_URI = "uri";
		const ACCESS_TOKEN_BEARER = "bearer";
		const ACCESS_TOKEN_OAUTH = "oauth";
		const ACCESS_TOKEN_MAC = "mac";

		protected $options;

		public function __construct(array $options = array()) {
			$resolver = new OptionsResolver();
			$this->configureOptions($resolver);
			$this->options = $resolver->resolve($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefined("user");
			$resolver->setDefaults(array(
				'access_token'    => null,
				'token_type'      => self::ACCESS_TOKEN_URI,
				'token_secret'    => null,
				'token_algorithm' => null,
				'scope'           => null,
				'refresh_token'   => null,
				'expires_in'      => null
			));

			$resolver->setRequired(array('access_token', 'token_type'));
			$resolver->setAllowedTypes('access_token', 'string');
			$resolver->setAllowedTypes('token_type', 'string');
			$resolver->setAllowedTypes('expires_in', array('null', 'string'));
			$resolver->setNormalizer('expires_in', function ($options, $value) {
				$now = time();
				$expires = null;
				if ($value != null) {
					$expires = $now + ((int)$value);
				} elseif (!empty($options['expires'])) {
					$expires = ((int)$options['expires']);
					if ($expires <= $now) {
						$expires = $now + $expires;
					}
				}

				return $expires;
			});
			$resolver->setAllowedValues('token_type', array(
				self::ACCESS_TOKEN_URI,
				self::ACCESS_TOKEN_BEARER,
				self::ACCESS_TOKEN_OAUTH,
				self::ACCESS_TOKEN_MAC
			));
		}

		public function hasExpired() {
			return ($this->options['expires_in']) ? $this->options['expires_in'] < time() : false;
		}

		public function getExpiresTime() {
			return ($this->options['expires_in']) ? $this->options['expires_in'] - time() : 0;
		}


		public function getOption($key) {
			return $this->options[$key];
		}


		public function generateMACSignature(array $options) {
			$timestamp = time();
			$nonce = uniqid();
			$parsed_url = parse_url($options['url']);
			if (!isset($parsed_url['port'])) {
				$parsed_url['port'] = ($parsed_url['scheme'] == 'https') ? 443 : 80;
			}
			if ($options['http_method'] == CurlRequest::HTTP_METHOD_GET) {
				$parsed_url['path'] .= '?' . http_build_query($options['parameters'], null, '&');
			}

			$signature = base64_encode(hash_hmac($this->options['token_algorithm'], $timestamp . "\n"
				. $nonce . "\n"
				. $options['http_method'] . "\n"
				. $parsed_url['path'] . "\n"
				. $parsed_url['host'] . "\n"
				. $parsed_url['port'] . "\n\n"
				, $this->options['token_secret'], true));

			return 'id="' . $this->options['access_token'] . '", ts="' . $timestamp . '", nonce="' . $nonce . '", mac="' . $signature . '"';
		}

        public function serialize()
        {
            return serialize($this->options);
        }

        public function unserialize($serialized)
        {
            $this->options = unserialize($serialized);
        }
    }