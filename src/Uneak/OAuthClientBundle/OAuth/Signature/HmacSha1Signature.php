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


class HmacSha1Signature extends Signature {

	public function buildRequestOptions(CredentialsConfigurationInterface $credentialsConfiguration, ServerOAuth1ConfigurationInterface $serverConfiguration, AuthenticationConfigurationInterface $authenticationConfiguration, array &$options) {
		parent::buildRequestOptions($credentialsConfiguration, $serverConfiguration, $authenticationConfiguration, $options);


//		POST&https%3A%2F%2Fapi.twitter.com%2Foauth%2Frequest_token&oauth_callback%3Dhttp%253A%252F%252Fdev.starter.com%252Fapp_dev.php%252Fauthentication%252Fcode%252Fresponse%252Ftwitter%26oauth_consumer_key%3DwWw1hP1RbJgjC6LyS9QmY3aKv%26oauth_nonce%3Dc47b2c99d8c00b22d588f9a56726acad%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D1443658313%26oauth_version%3D1.0
//		POST&https%3A%2F%2Fapi.twitter.com%2Foauth%2Frequest_token&oauth_callback%3Dhttp%253A%252F%252Fdev.starter.com%252Fapp_dev.php%252Fauthentication%252Fcode%252Fresponse%252Ftwitter%26oauth_consumer_key%3DwWw1hP1RbJgjC6LyS9QmY3aKv%26oauth_nonce%3D6b96dc81629118ea1f78445603a205c2%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D1443658445%26oauth_version%3D1.0
//		POST&https%3A%2F%2Fapi.twitter.com%2Foauth%2Frequest_token&oauth_callback%3Dhttp%253A%252F%252Fdev.starter.com%252Fapp_dev.php%252Fauthentication%252Fcode%252Fresponse%252Ftwitter%26oauth_consumer_key%3DwWw1hP1RbJgjC6LyS9QmY3aKv%26oauth_nonce%3D6b96dc81629118ea1f78445603a205c2%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D1443658445%26oauth_version%3D1.0

//		W2jNbO9cgNqniTjdPM%2FLWYM4tE0%3D
//		jyWpIJ3wv8gdz%2FkWmTP4xIrku9o%3D


		var_dump($options['_base_string']);

		$keyParts = array(
			rawurlencode($credentialsConfiguration->getClientId()),
//			rawurlencode($credentialsConfiguration->getClientSecret()),
			rawurlencode(''),
		);

		$signature = hash_hmac('sha1', $options['_base_string'], implode('&', $keyParts), true);

		$options['_oauth']['oauth_signature'] = "W2jNbO9cgNqniTjdPM%2FLWYM4tE0%3D"; //base64_encode($signature);



		foreach ($options['_oauth'] as $key => $value) {
			$options['_oauth'][$key] = $key . '="' . rawurlencode($value) . '"';
		}

//		if (!$this->options['realm']) {
//			array_unshift($parameters, 'realm="' . rawurlencode($this->options['realm']) . '"');
//		}

//		$options['http_headers']['Authorization'] = 'OAuth ' . implode(', ', $options['_oauth']);
		$options['http_headers']['Authorization'] = 'OAuth oauth_consumer_key="wWw1hP1RbJgjC6LyS9QmY3aKv", oauth_nonce="6f34b2e5a587bbebccf71c303e253f2f", oauth_signature="7dqd1vxEFned%2BwOBEtKWu%2BenxG4%3D", oauth_signature_method="HMAC-SHA1", oauth_timestamp="1443658987", oauth_version="1.0"';




		var_dump($options['http_headers']['Authorization']);
		unset($options['_base_string']);
		unset($options['_oauth']);
	}


	public function getName() {
		return 'HMAC-SHA1';
	}

}
