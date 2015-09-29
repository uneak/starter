<?php

	namespace Uneak\OAuthClientBundle\OAuth\Token;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration\Configuration;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;

	class AccessToken extends Configuration implements AccessTokenInterface {

		const ACCESS_TOKEN_URI = "uri";
		const ACCESS_TOKEN_BEARER = "bearer";
		const ACCESS_TOKEN_OAUTH = "oauth";
		const ACCESS_TOKEN_MAC = "mac";

		public function __construct(array $options = array()) {
            parent::__construct($options);
		}

		public function configureOptions(OptionsResolver $resolver) {
			parent::configureOptions($resolver);
			$resolver->setDefined("expires");
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
			$resolver->setAllowedTypes('expires_in', array('null', 'string', 'integer'));
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

			$resolver->setNormalizer('token_type', function ($options, $value) {
				$type = strtolower($value);
				if (!in_array($type, array(
					self::ACCESS_TOKEN_URI,
					self::ACCESS_TOKEN_BEARER,
					self::ACCESS_TOKEN_OAUTH,
					self::ACCESS_TOKEN_MAC
				))) {
					throw new \Exception("Unknow Token type ".$type);
				}
				return $type;
			});

		}

		public function hasExpired() {
			return ($this->getOptions('expires_in')) ? $this->getOptions('expires_in') < time() : false;
		}

		public function getExpiresTime() {
			return ($this->getOptions('expires_in')) ? $this->getOptions('expires_in') - time() : 0;
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

			$signature = base64_encode(hash_hmac($this->getOptions('token_algorithm'), $timestamp . "\n"
				. $nonce . "\n"
				. $options['http_method'] . "\n"
				. $parsed_url['path'] . "\n"
				. $parsed_url['host'] . "\n"
				. $parsed_url['port'] . "\n\n"
				, $this->getOptions('token_secret'), true));

			return 'id="' . $this->getOptions('access_token') . '", ts="' . $timestamp . '", nonce="' . $nonce . '", mac="' . $signature . '"';
		}


    }