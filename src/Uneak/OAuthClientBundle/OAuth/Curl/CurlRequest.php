<?php

	namespace Uneak\OAuthClientBundle\OAuth\Curl;


	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Exception;

	class CurlRequest {

		const HTTP_METHOD_GET = 'GET';
		const HTTP_METHOD_POST = 'POST';
		const HTTP_METHOD_PUT = 'PUT';
		const HTTP_METHOD_DELETE = 'DELETE';
		const HTTP_METHOD_HEAD = 'HEAD';
		const HTTP_METHOD_PATCH = 'PATCH';
		//
		const HTTP_FORM_CONTENT_TYPE_APPLICATION = 0;
		const HTTP_FORM_CONTENT_TYPE_MULTIPART = 1;


		protected $options;

		public function __construct(array $options = array()) {
			$resolver = new OptionsResolver();
			$this->configureOptions($resolver);
			$this->options = $resolver->resolve($options);
		}

		protected function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array(
				'url'               => '',
				'parameters'        => array(),
				'http_method'       => self::HTTP_METHOD_GET,
				'http_headers'      => array(),
				'form_content_type' => self::HTTP_FORM_CONTENT_TYPE_MULTIPART,
				'curl_extras'       => array(),
				'certificate_file'  => null,
			));

			$resolver->setRequired('url');
			$resolver->setAllowedTypes('url', 'string');
			$resolver->setAllowedTypes('parameters', 'array');
			$resolver->setAllowedValues('http_method', array(
				self::HTTP_METHOD_GET,
				self::HTTP_METHOD_POST,
				self::HTTP_METHOD_PUT,
				self::HTTP_METHOD_DELETE,
				self::HTTP_METHOD_HEAD,
				self::HTTP_METHOD_PATCH
			));
			$resolver->setAllowedTypes('http_headers', 'array');
			$resolver->setAllowedValues('form_content_type', array(
				self::HTTP_FORM_CONTENT_TYPE_APPLICATION,
				self::HTTP_FORM_CONTENT_TYPE_MULTIPART,
			));
			$resolver->setAllowedTypes('curl_extras', 'array');
		}


		public function getResponse() {

			$curl_options = array();
			$curl_options[CURLOPT_RETURNTRANSFER] = true;
			$curl_options[CURLOPT_SSL_VERIFYPEER] = true;
			$curl_options[CURLOPT_CUSTOMREQUEST] = $this->options['http_method'];

			switch ($this->options['http_method']) {
				case self::HTTP_METHOD_POST:
					$curl_options[CURLOPT_POST] = true;
				case self::HTTP_METHOD_PUT:
				case self::HTTP_METHOD_PATCH:
					if (is_array($this->options['parameters']) && self::HTTP_FORM_CONTENT_TYPE_APPLICATION === $this->options['form_content_type']) {
						$this->options['parameters'] = http_build_query($this->options['parameters'], null, '&');
					}
					$curl_options[CURLOPT_POSTFIELDS] = $this->options['parameters'];
					break;
				case self::HTTP_METHOD_HEAD:
					$curl_options[CURLOPT_NOBODY] = true;
				case self::HTTP_METHOD_DELETE:
				case self::HTTP_METHOD_GET:
						$this->options['url'] .= '?' . http_build_query($this->options['parameters'], null, '&');
					break;
				default:
					break;
			}

			$curl_options[CURLOPT_URL] = $this->options['url'];

			if (is_array($this->options['http_headers'])) {
				$header = array();
				foreach ($this->options['http_headers'] as $key => $parsed_urlvalue) {
					$header[] = "$key: $parsed_urlvalue";
				}
				$curl_options[CURLOPT_HTTPHEADER] = $header;
			}



			$ch = curl_init();
			curl_setopt_array($ch, $curl_options);

			// https handling
			if (!empty($this->options['certificate_file'])) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_CAINFO, $this->options['certificate_file']);
			} else {
				// bypass ssl verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			}

			if (!empty($this->options['curl_extras'])) {
				curl_setopt_array($ch, $this->options['curl_extras']);

				if (isset($this->options['curl_extras'][CURLOPT_VERBOSE]) && $this->options['curl_extras'][CURLOPT_VERBOSE] == true) {
					$verbose = fopen('php://temp', 'w+');
					curl_setopt($ch, CURLOPT_STDERR, $verbose);
				}
			}



			$result = curl_exec($ch);

			if (isset($verbose)) {
				rewind($verbose);
				$verboseLog = stream_get_contents($verbose);
				echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
			}


			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

			$curl_error = curl_error($ch);
			if ($curl_error) {
				throw new Exception($curl_error, Exception::CURL_ERROR);
			} else {
				$json_decode = json_decode($result, true);
			}
			curl_close($ch);

			return new CurlResponse($http_code, $content_type, (null === $json_decode) ? $result : $json_decode);
		}

	}
