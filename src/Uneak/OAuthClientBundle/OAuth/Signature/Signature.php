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


class Signature implements SignatureInterface {

	const SIGNATURE_METHOD_HMAC      = 'HMAC-SHA1';
	const SIGNATURE_METHOD_RSA       = 'RSA-SHA1';
	const SIGNATURE_METHOD_PLAINTEXT = 'PLAINTEXT';


	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, array &$options) {

		$options['http_method'] = CurlRequest::HTTP_METHOD_POST;
		$options['_oauth']['oauth_callback'] = $authenticationConfiguration->getOption('redirect_uri');
		$options['_oauth']['oauth_signature_method'] = $this->getName();
		$options['_oauth']['oauth_consumer_key'] = $credentialsConfiguration->getClientId();
		$options['_oauth']['oauth_timestamp'] = "1443658445"; //time();
		$options['_oauth']['oauth_nonce'] = "6b96dc81629118ea1f78445603a205c2";//md5(microtime(true).uniqid('', true));
		$options['_oauth']['oauth_version'] = '1.0';


		// URL
		$url = parse_url($serverConfiguration->getRequestTokenUrl());
		if (isset($url['query'])) {
			parse_str($url['query'], $queryParams);
			$options['_oauth'] += $queryParams;
		}
		$explicitPort = isset($url['port']) ? $url['port'] : null;
		if (('https' === $url['scheme'] && 443 === $explicitPort) || ('http' === $url['scheme'] && 80 === $explicitPort)) {
			$explicitPort = null;
		}
		$options['url'] = sprintf('%s://%s%s%s', $url['scheme'], $url['host'], ($explicitPort ? ':'.$explicitPort : ''), isset($url['path']) ? $url['path'] : '');
		//


		uksort($options['_oauth'], 'strcmp');

		$parts = array(
			strtoupper($options['http_method']),
			rawurlencode($options['url']),
			rawurlencode(str_replace(array('%7E', '+'), array('~', '%20'), http_build_query($options['_oauth'], '', '&'))),
		);

		$options['_base_string'] = implode('&', $parts);


	}


	public function getName() {
		return 'signature';
	}

}
