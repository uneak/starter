<?php

namespace Uneak\OAuthClientBundle\OAuth\Signature;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\AuthenticationOAuth1ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\CredentialsConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1Configuration;
use Uneak\OAuthClientBundle\OAuth\Configuration\ServerOAuth1ConfigurationInterface;
use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;
use Uneak\OAuthClientBundle\OAuth\Exception;
use Uneak\OAuthClientBundle\OAuth\OAuth;


class PlainTextSignature extends Signature {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationOAuth1ConfigurationInterface $authenticationConfiguration, array &$options) {
		parent::buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);


		$baseString = $this->_getBaseString($options['http_method'], $options['url'], $options['oauth_parameters']);

		//
		$options['oauth_parameters']['oauth_signature'] = $this->_urlencode_rfc3986(base64_encode($baseString));
		//

		uksort($options['oauth_parameters'], 'strcmp');

		$urlPairs = array();
		foreach ($options['oauth_parameters'] as $key => $value) {
			$urlPairs[] = $key . '=' . $value;
		}

		$options['http_headers']['Authorization'] = 'OAuth ' . implode(', ', $urlPairs);


	}


	public function getName() {
		return 'PLAINTEXT';
	}

}
