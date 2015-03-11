<?php

function clean($text){

	$replace = array(
		'([@|#]\w+|(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?)' => ' ',
		'(\d+)' => ' ',
		'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
		'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
		'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
		'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
		'Œ' => 'oe', 'œ' => 'oe',
		'$' => ' ',
		'^(.*)s$' => '$1',
		'(m+d+r+)' => ' ',
		'(➡|▶|\.|:|\?|,|!|…|\/|\\\|"|\'|-|_|\(|\)|\+)' => ' ',
		'\w*(ai(s|t|ent)?|i?ez)' => ' ',
	);
	$text = strtolower($text);
	$text = strip_tags($text);
	foreach ($replace as $key => $val)
	{
		$text = preg_replace('/'.$key.'/i', $val, $text);
	}
	return $text;
}

function recent($tweets, $time) {
	foreach ($tweets as $key => $tweet)
	{
		$date_du_tweet = (time() -  date('U', strtotime($tweet['created_at']))) / 60;
		if ($date_du_tweet < $time)
			$mots .= clean($tweet['text']);
	}
	preg_match_all("/(\w+)/", $mots, $mots);
	return $mots[0];
}

function clean_black_list($recents_words) {
	$mots_interdits = array(
		'ont', 'les', 'une', 'aux', 'des', 'cet', 'cette', 'ces', 'mon', 'ton', 'son', 'mes', 'tes', 'ses', 'ils', 'elles', 'vous',
		'nous', 'notre', 'votre', 'leurs', 'leur', 'nos', 'vos', 'quel', 'quelle', 'quels', 'quelles', 'aucun', 'aucune',
		'aucuns', 'aucunes', 'maint', 'mainte', 'maints', 'maintes', 'quel', 'que', 'quelle', 'quels', 'quelles', 'tel', 'telle', 'tels', 'telles',
		'tout', 'toute', 'tous', 'toutes', 'chaque', 'plusieurs', 'divers', 'autre', 'autres', 'même', 'mêmes', 'quelque', 'quelques',
		'quelconque', 'quelconques', 'certain', 'certaine', 'certains', 'certaines', 'divers', 'diverse', 'divers', 'diverses', 'différent',
		'différente', 'différents', 'différentes', 'nul', 'nulle', 'nuls', 'nulles', 'mais', 'donc', 'car', 'http', 'qui', 'est', 'pas', 'pour',
		'contre', 'lui', 'plus', 'moins', 'srt', 'avec', 'sont', 'dans', 'puis', 'elle', 'soiree', 'aussi', 'trop', 'soir', 'follow', 'tweet', 'suivre',
		'suivez', 'actualite', 'hashtag', 'abonne', 'message', 'info', 'nement', 'tres', 'etre', 'avoir', 'quelqu', 'quoi', 'quand', 'quant', 'http', 'https'
	);

	foreach ($recents_words as $key => $mot) {
		if (!in_array($mot, $mots_interdits) && strlen($mot) > 3)
			$mots[] = $mot;
	}
	return $mots;
}

function clean_by_wikipedia($best_words) {
	$i = 0;
	foreach ($best_words as $mot => $occurences) {
		$definition = file_get_contents("http://fr.wiktionary.org/w/api.php?format=json&action=query&rvprop=content&prop=revisions&titles=" . $mot);
		if (stripos($definition, "|adjectif|") === false && stripos($definition, "|pronom|") === false && stripos($definition, "|adverbe|") === false && stripos($definition, "|verbe|") === false && stripos($definition, "|conjonction|") === false && stripos($definition, "|adverbe") === false)
		{
			$new_count[$mot] = $occurences;
			$i++;
		}
		if ($i == 10)
			break;
	}

	return $new_count;
}

function clean_by_batsu($best_words, $on = 1) {
	$i = 0;
	$break = false;

	foreach ($best_words as $key => $mot)
	{
		$ocurences_mot[$mot] += 1;
	}
	arsort($ocurences_mot);
	foreach ($ocurences_mot as $mot => $occurences)
	{
		if ($on){
			$break = true;
			$def = substr(`sdcv -n $mot`, 0, 800);
			$black_list = array('adj.', 'v. a.', 'adv.');
			preg_match("/XMLittre\\n-->([^\s]*)/im", $def, $result);
			if (clean($result[1]) == clean($mot))
			{
				foreach ($black_list as $search)
				{
					if (stripos($def, $search))
						$break = false;
				}
				if ($break)
				{
					$new_ocurences_mot[$mot] = $occurences;
					$i++;
				}
			}
			else
			{
				$new_ocurences_mot[$mot] = $occurences;
				$i++;
			}
		}
		else {
			$new_ocurences_mot[$mot] = $occurences;
			$i++;
		}
		if ($i == 10)
			break;
	}
	return $new_ocurences_mot;
}


function cache_twitter($hashtag) {
	$tweets = get_twitter($hashtag);
	return  $tweets;
}


function cache_top($hashtag) {
	if (file_exists("cache-api/".$hashtag.".json") && ((time() - filemtime("cache-api/".$hashtag.".json")) / 60) < 1)
	{
		$tweets = file_get_contents("cache-api/".$hashtag.".json");
		$top_10 = json_decode($tweets, TRUE);
	}
	else
	{
		$tweets = get_twitter($hashtag);
		$tweets = cache_twitter($hashtag);
		$recents_words = recent($tweets, 60);
		$best_words = clean_black_list($recents_words);
		$best_words = clean_by_batsu($best_words, 0);
		$top_10 = array_slice($best_words, 0, 10);
		file_put_contents("cache-api/".$hashtag.".json", json_encode($top_10));
	}
	return  $top_10;
}

function cache_best($tweets) {
	if (file_exists("cache-best/".$hashtag.".json") && ((time() - filemtime("cache-best/".$hashtag.".json")) / 60) < 1)
	{
		$tweets = file_get_contents("cache-best/".$hashtag.".json");
		$cache = json_decode($tweets, TRUE);
	}
	else
	{
		$cache = best_tweet($tweets);
		file_put_contents("cache-best/".$hashtag.".json", json_encode($cache));
	}
	return  $cache;
}


function best_tweet($tweets) {
	foreach ($tweets as $key => $tweet)
	{
		$note = $tweet['retweet_count'] + $tweet['favourites_count'] + $tweet['friends_count'] + ($tweet['followers_count'] / 100) + $tweet['statuses_count'] / 1000;
		if (isset($tweet['retweeted_status']['text'])) {
			$best_tweet[$note] = array('tweet' => $tweet['retweeted_status']['text'],
				'id' => $tweet['retweeted_status']['id'],
				'time' => strftime("%H:%M - %d %b %Y", strtotime($tweet['retweeted_status']['created_at'])),
				'user_name' => $tweet['retweeted_status']['user']['name'],
				'user_screen_name' => "@".$tweet['retweeted_status']['user']['screen_name'],
				'favorite_count' => $tweet['retweeted_status']['favorite_count'],
				'retweet_count' => $tweet['retweeted_status']['retweet_count'],
				'url' => 'https://twitter.com/' . $tweet['retweeted_status']['user']['name']. '/status/'. $tweet['retweeted_status']['id'],
			);
		}
		else {
			$best_tweet[$note] = array('tweet' => $tweet['text'],
				'id' => $tweet['id'],
				'time' => strftime("%H:%M - %d %b %Y", strtotime($tweet['created_at'])),
				'user_name' => $tweet['user']['name'],
				'user_screen_name' => "@".$tweet['user']['screen_name'],
				'favorite_count' => $tweet['favorite_count'],
				'retweet_count' => $tweet['retweet_count'],
				'url' => 'https://twitter.com/' . $tweet['user']['name']. '/status/'. $tweet['id'],
			);
		}

	}
	krsort($best_tweet);
	$best_tweet = array_slice($best_tweet, 0, 1);
	return	$best_tweet; 
}