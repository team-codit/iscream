<?php

require '/home/iscream.mages.agency/public_html/GETTER/vendor/autoload.php';

use JonnyW\PhantomJs\Client;

$client = Client::getInstance();
$client->setBinDir('/home/iscream.mages.agency/public_html/GETTER/vendor/jonnyw/php-phantomjs/bin');

$request  = $client->getMessageFactory()->createRequest($_GET['url']);
$response = $client->getMessageFactory()->createResponse();

$client->send($request, $response);
echo $response->getContent();