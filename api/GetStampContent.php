<?php
	header('Content-Type: application/json; charset=utf-8');
	
	$stampID = (isset($_GET['stampId'])) ? $_GET['stampId'] : 0;
	$url = "http://94.23.253.36:8080/TiVineWS_V1.0/GetStampContent";
	$code = "http://94.23.253.36:8080/TiVineWS_V1.0/GetStampContent".$stampID."10989845";
	$encoded = hash_hmac ( 'sha512', $code , 'd82b2bfee4445353d219461942b3ab18');
	echo exec("curl '". $url ."'  --data 'stampId=". $stampID ."&clientId=10989845&encodedKey=". $encoded ."' --compressed");
