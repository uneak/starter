<?php

	namespace Uneak\OAuthClientBundle\OAuth\Signature;

	use Symfony\Component\OptionsResolver\OptionsResolver;
	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth1ConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1ConfigurationInterface;
	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
	use Uneak\OAuthClientBundle\OAuth\Exception;
	use Uneak\OAuthClientBundle\OAuth\OAuth;


	class Signature implements SignatureInterface {


		public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationOAuth1ConfigurationInterface $authenticationConfiguration, array &$options) {

			$url = parse_url($options['url']);
			if (isset($url['query'])) {
				$extraParameters = array();
				parse_str($url['query'], $extraParameters);
				$options['oauth_parameters'] = array_merge($options['oauth_parameters'], $extraParameters);
			}

			$port = isset($url['port']) ? $url['port'] : null;
			if (('https' === $url['scheme'] && 443 === $port) || ('http' === $url['scheme'] && 80 === $port)) {
				$port = null;
			}

			$options['url'] = sprintf('%s://%s%s%s', $url['scheme'], $url['host'], ($port ? ':' . $port : ''), isset($url['path']) ? $url['path'] : '');


			uksort($options['oauth_parameters'], 'strcmp');

		}



		protected function _getBaseString($http_method, $url, array $parameters) {

			$basePairs = array();
			foreach ($parameters as $key => $value) {
				$basePairs[] = $this->_urlencode_rfc3986($key).'='.$this->_urlencode_rfc3986($value);
			}

			return implode('&', array(
				strtoupper($http_method),
				$this->_urlencode_rfc3986($url),
				$this->_urlencode_rfc3986(implode('&', $basePairs)),
			));
		}




		protected function _urlencode_rfc3986($input) {
			if (is_array($input)) {
				return array_map(array($this, '_urlencode_rfc3986'), $input);
			} else if (is_scalar($input)) {
				return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($input)));
			} else {
				return '';
			}
		}


		public function getName() {
			return 'signature';
		}

	}
