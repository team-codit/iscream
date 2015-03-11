<?php
	
	header('Content-Type: text/html; charset=utf-8');
	
	require_once('liste-hashtags.php');
	require_once('twitter-search.php');
	require_once('api-functions.php');

	foreach ($hashtags as $hashtag => $name)
	{
		if (clean($name) == clean($h))
			$tags[] = $hashtag;
	}
	$tags[] = $_GET['h'];
	$tags[] = $_GET['c'];
	foreach ($tags as $tag) {
		$occurences = cache_top(urlencode($tag));
		foreach ($occurences as $mot => $times)
			$mots[$mot] = $mot;
	}
	echo json_encode(array_slice($mots, 0 ,10));