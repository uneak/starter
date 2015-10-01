<?php

namespace Uneak\OAuthClientBundle\OAuth\Signature;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Exception;
use Uneak\OAuthClientBundle\OAuth\OAuth;


class RsaSha1Signature extends Signature {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, array &$options) {
		parent::buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);


		if (!function_exists('openssl_pkey_get_private')) {
			throw new \RuntimeException('RSA-SHA1 signature method requires the OpenSSL extension.');
		}

//		$privateKey = openssl_pkey_get_private(file_get_contents($credentialsConfiguration->getClientId()), $credentialsConfiguration->getClientSecret());
		$privateKey = openssl_pkey_get_private(file_get_contents($credentialsConfiguration->getClientId()), '');
		$signature  = false;

		openssl_sign($options['_base_string'], $signature, $privateKey);
		openssl_free_key($privateKey);


		$options['_oauth']['oauth_signature'] = base64_encode($signature);




		$oAuthParams = array();
		foreach ($options['_oauth'] as $key => $value) {
			$oAuthParams[$key] = $key . '="' . rawurlencode($value) . '"';
		}

		//		if (!$this->options['realm']) {
		//			array_unshift($parameters, 'realm="' . rawurlencode($this->options['realm']) . '"');
		//		}

		$options['http_headers']['Authorization'] = 'OAuth ' . implode(', ', $oAuthParams);


		unset($options['_base_string']);
		unset($options['_oauth']);
	}


	public function getName() {
		return 'RSA-SHA1';
	}

}
