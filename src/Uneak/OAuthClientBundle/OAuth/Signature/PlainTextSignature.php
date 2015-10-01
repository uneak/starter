<?php

namespace Uneak\OAuthClientBundle\OAuth\Signature;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1Configuration;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Exception;
use Uneak\OAuthClientBundle\OAuth\OAuth;


class PlainTextSignature extends Signature {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, array &$options) {
		parent::buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);

		$options['_oauth']['oauth_signature'] = base64_encode($options['_base_string']);

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
		return 'PLAINTEXT';
	}

}
