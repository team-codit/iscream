<?php
	header('Content-Type: application/json; charset=utf-8');
	
	$part = 0;
	$url = "http://94.23.253.36:8080/TiVineWS_V1.0/GetAllContentForPart";
	$code = "http://94.23.253.36:8080/TiVineWS_V1.0/GetAllContentForPart".$part."10989845";
	$encoded = hash_hmac ( 'sha512', $code , 'd82b2bfee4445353d219461942b3ab18');
	
	echo exec("curl '". $url ."'  --data 'part=".$part ."&clientId=10989845&encodedKey=". $encoded ."' --compressed");
