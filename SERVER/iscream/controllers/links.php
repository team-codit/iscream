<?php
	
class Links extends CI_Controller
{
	public function index()
	{
		$this->load->driver('cache');
		if (!($response = $this->cache->file->get($_GET['code'])))
		{
			require_once '../GETTER/Amazon/lib/AmazonECS.class.php';
			
			$i 								= 0;
			$page 							= file_get_contents('http://getter.iscream.mages.agency/?url=http://www.allocine.fr/film/fichefilm-' . $_GET['code'] . '/telecharger-vod/');
			preg_match_all("#<table(.*?)</table>#ism", $page, $matches);
			$result 						= array_slice($matches[0], 1);
			$response						= [];
			$response['vod']				= [];
	 		foreach ($result as &$value)
	 		{
		 		$elem						= [];
		 		if (preg_match('#<div class="logo_cnc_sm_inner">(.*?)</div>#ism', $value, $matches))
		 		{
			 		if (preg_match_all('#"([^""]+)"#', $matches[1], $matches))
			 		{
				 		$elem['alt'] 		= $matches[1][0];
				 		$elem['img']		= $matches[1][1];
			 		}
			 		
			 		preg_match('#<tbody>(.*?)</tbody>#ism', $value, $matches);
			 		preg_match_all('#<tr>(.*?)</tr>#ism', $matches[1], $matches);
			 		$vod					= array();
			 		$min 					= null;
			 		foreach ($matches[1] as $match)
			 		{
			 			$infovod 			= [];
				 		preg_match_all('#<td>(.*?)</td>#ism', $match, $matches2);
				 		$matches2			= array_slice($matches2[1], 3);
				 		$infovod['price']	= (preg_match('#<span class="insist">(.*?)</span>#ism',$matches2[0], $matches3)) ?  $matches3[1] : "";
				 		$infovod['url']		= (preg_match('#<a href="(.*?)"#ism',$matches2[1], $matches3)) ? $matches3[1] : "";
				 		$infovod['type']	= (preg_match('#<a[^>]+>(.*?)</a>#ism',$matches2[1], $matches3)) ? trim($matches3[1]) : "";
				 		if (!$min)
				 		{
					 		$min 			= $infovod['price'];
					 		$url 			= $infovod['url'];
					 	}
				 		if ($min && strcmp($infovod['price'], $min) <= 0)
				 		{
					 		$min 			= $infovod['price'];
					 		$url 			= $infovod['url'];
				 		}
				 		$vod[]				= $infovod;
		 			}
		 			$elem['vod']			= $vod;
		 			$elem['min_price']		= $min;
		 			$elem['min_url']		= $url;
		 		}
		 		$response['vod'][]			= $elem;
	 		}
	 		
	 		$response['dvd']				= [];
			$client 						= new AmazonECS('AKIAJMGFA7KZ2N6IASEA', 'T/fwUlzJHQA7nnuzUwt0AIaWKphjhkaMSq1iiv9c', 'FR', 'mageagen-21');
			$amazon  						= $client->responseGroup('Offers')->category('DVD')->search($_GET['name']);
			foreach ($amazon->Items->Item as $key => $value)
			{
				$elem						= [];
				if ($i >= 3) break;
				if (isset($value->OfferSummary->LowestNewPrice->Amount, $value->Offers->MoreOffersUrl) && $value->Offers->MoreOffersUrl)
				{
					$elem['price']			= ($value->OfferSummary->LowestNewPrice->Amount / 100) . " €";
					$elem['url']			= $value->Offers->MoreOffersUrl;
					$i++;
					$response['dvd'][]		= $elem;
				}
			}
			$response 						= json_encode($response);
			$this->cache->file->save($_GET['code'], $response, 2678400);
		}
		
 		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		echo $response;
	}
	
}