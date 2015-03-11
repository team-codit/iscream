<?php

header('Content-Type: text/html; charset=utf-8');
setlocale(LC_TIME, 'fr_FR.utf8','fra');

require_once ('twitter-search.php');
require_once ('api-functions.php');


foreach ($hashtags as $hashtag => $name)
{
	if (clean($name) == clean($h))
		$tags[] = $hashtag;
}
$tags[] = $_GET['h'];
$tags[] = $_GET['c'];

foreach ($tags as $tag) {
	$tweets = cache_twitter(urlencode($tag));
	$bests[] = cache_best($tweets);
}

$bests = json_encode($bests);
echo $bests;