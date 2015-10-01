<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 01/10/15
	 * Time: 08:37
	 */

	namespace AppBundle;


	use Uneak\OAuthClientBundle\OAuth\Curl\CurlRequest;

	class Twitauth
	{
		var $key = 'wWw1hP1RbJgjC6LyS9QmY3aKv';
		var $secret = '7DXjAi9KGq7SbXvuFjWF4qVAJARUE7mNzodub2Q0VMWbmafDkz';

		var $request_token = "https://twitter.com/oauth/request_token";

		function Twitauth($config)
		{
//			$this->key = $config['key']; // consumer key from twitter
//			$this->secret = $config['secret']; // secret from twitter
		}

		function getRequestToken()
		{
			// Default params
			$params = array(
				"oauth_version" => "1.0",
				"oauth_nonce" => time(),
				"oauth_timestamp" => time(),
				"oauth_consumer_key" => $this->key,
				"oauth_signature_method" => "HMAC-SHA1"
			);

			// BUILD SIGNATURE
			// encode params keys, values, join and then sort.
//			$keys = $this->_urlencode_rfc3986(array_keys($params));
//			$values = $this->_urlencode_rfc3986(array_values($params));
//			$params = array_combine($keys, $values);
			uksort($params, 'strcmp');

			// convert params to string
			foreach ($params as $k => $v) {$pairs[] = $this->_urlencode_rfc3986($k).'='.$this->_urlencode_rfc3986($v);}
			$concatenatedParams = implode('&', $pairs);

			// form base string (first key)
			$baseString= "POST&".$this->_urlencode_rfc3986($this->request_token)."&".$this->_urlencode_rfc3986($concatenatedParams);
			// form secret (second key)
			$secret = $this->_urlencode_rfc3986($this->secret)."&";
			// make signature and append to params
			$params['oauth_signature'] = $this->_urlencode_rfc3986(base64_encode(hash_hmac('sha1', $baseString, $secret, TRUE)));

			// BUILD URL
			// Resort
			uksort($params, 'strcmp');
			// convert params to string
			foreach ($params as $k => $v) {$urlPairs[] = $k."=".$v;}
			$concatenatedUrlParams = implode(', ', $urlPairs);
			// form url
			$url = $this->request_token;


			$header = "OAuth ".$concatenatedUrlParams;


			var_dump($header);

			// Send to cURL

			$options = array();
			$options['url'] = $url;
			$options['http_method'] = CurlRequest::HTTP_METHOD_POST;
			$options['http_headers']['Authorization'] = $header;
			$options['curl_extras'] = array(
				CURLOPT_VERBOSE => true,
			);

			$request = new CurlRequest($options);
			ld($request);
			ldd($request->getResponse());

//			print $this->_http($url, $header);
		}

		function _http($url, $header = null)
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, true);

			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);


			$response = curl_exec($ch);
			$this->http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$this->last_api_call = $url;
			curl_close($ch);

			return $response;
		}

		function _urlencode_rfc3986($input)
		{
			if (is_array($input)) {
				return array_map(array($this, '_urlencode_rfc3986'), $input);
			}
			else if (is_scalar($input)) {
				return str_replace('+',' ',str_replace('%7E', '~', rawurlencode($input)));
			}
			else{
				return '';
			}
		}
	}