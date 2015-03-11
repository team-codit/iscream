<?php

	
	function get_twitter($h, $token = 1) {
		$url = "search/tweets.json?q=". $h ."&result_type=recent&count=100&lang=fr";
		$tok['3'] = array(
			'oauth_access_token' => '389857357-VCkTGZK7O72qvsFtKcPjI2344ZqM6PeHScKT5DFC',
			'oauth_access_token_secret' => 'RH9WydQUaZaWAfgJlDVsVhAf7Oh3EO4UmxCY03egLVb2d',
			'consumer_key' => 'pUfI23kadu0Uq2NRkZUyWuRfJ',
			'consumer_secret' => 'WgIEY0YaEGkVdlv2AFbPnk3r8YSPgiaXCeAXmaQhlcrLAb1l81',
			'base_url' => 'https://api.twitter.com/1.1/'
		);
		
		$tok['2'] = array(
			'oauth_access_token' => '112490870-919Z938MeQEVYZ9FKBY9zFCu4FMEDfPAD55CpYjj',
			'oauth_access_token_secret' => 'pCuj6CiUb29janKpXw49GPK4Mid3qIqmMHbzPrVLxbjri',
			'consumer_key' => 'M3bHpMDcWNy541giSbCPTnGyU',
			'consumer_secret' => 'SOQGv2GvzHE5yZhxoH8ZeTP53l6kMXDRk8r2ahWdMtHYmC8Aqv',
			'base_url' => 'https://api.twitter.com/1.1/'
		);
		
		$tok['1'] = array(
			'oauth_access_token' => '3006856992-MQvH6OR4zmAR0YO3qm45vsMpWkKnM705hqO03bY',
			'oauth_access_token_secret' => 'NgQQ6BGbye14gLvKSWe38uL7odVCSOpqFCPvj2W65uXbu',
			'consumer_key' => '0z1YNNV8CEFvz1cK79FIc5jck',
			'consumer_secret' => 'dDB1fXhmiBJganKPEFPYV4uIOgJ4PKgRTiQQK7nl1iH8G6BGyy',
			'base_url' => 'https://api.twitter.com/1.1/'
		);
		
		/*
$tok['1'] = array(
			'oauth_access_token' => '586996465-aHLLoeeTYNJ0fDMRrxEeoPlBhhO6P85lPuyVqLsF',
			'oauth_access_token_secret' => 'jJHsekslexkliwqxVaHS8dMo7EREYqBP1003aQvgHupaz',
			'consumer_key' => 'HtUrqYIcPr1KjU9OgjMRdmX0F',
			'consumer_secret' => 'fpUhLMxdDaf6FM6f1oUam2lf6ll2Z1sbhfSxZzAuYCUU5AGpYa',
			'base_url' => 'https://api.twitter.com/1.1/'
		);
*/
		$config = $tok[$token];
		$url_parts = parse_url($url);
		parse_str($url_parts['query'], $url_arguments);
		
		$full_url = $config['base_url'].$url;
		$base_url = $config['base_url'].$url_parts['path'];
		
		$oauth = array(
			'oauth_consumer_key' => $config['consumer_key'],
			'oauth_nonce' => time(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_token' => $config['oauth_access_token'],
			'oauth_timestamp' => time(),
			'oauth_version' => '1.0'
		);
			
		$base_info = buildBaseString($base_url, 'GET', array_merge($oauth, $url_arguments));
		$composite_key = rawurlencode($config['consumer_secret']) . '&' . rawurlencode($config['oauth_access_token_secret']);
		$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
		$oauth['oauth_signature'] = $oauth_signature;
		
		
		$header = array(
			buildAuthorizationHeader($oauth), 
			'Expect:'
		);
		$options = array(
			CURLOPT_HTTPHEADER => $header,
			CURLOPT_HEADER => false,
			CURLOPT_URL => $full_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false
		);
		
		$feed = curl_init();
		curl_setopt_array($feed, $options);
		$result = curl_exec($feed);
		$info = curl_getinfo($feed);
		curl_close($feed);
		
		if(isset($info['content_type']) && isset($info['size_download'])){
			header('Content-Type: '.$info['content_type']);
			header('Content-Length: '.$info['size_download']);
		
		}
		if (isset($result['errors']) && isset($tok[$token + 1]))
		{
			return get_twitter($h, $token + 1);
		}
		else
		{
			$tweets = json_decode($result, TRUE);
			$tweets = $tweets['statuses'];
			return $tweets;			
		}
	}
	
	function buildBaseString($baseURI, $method, $params) {
		$r = array();
		ksort($params);
		foreach($params as $key=>$value){
		$r[] = "$key=" . rawurlencode($value);
		}
		return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
	}
	
	function buildAuthorizationHeader($oauth) {
		$r = 'Authorization: OAuth ';
		$values = array();
		foreach($oauth as $key=>$value)
		$values[] = "$key=\"" . rawurlencode($value) . "\"";
		$r .= implode(', ', $values);
		return $r;
	}
	
	