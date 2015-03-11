<?php

class Search extends CI_Controller
{

	public function index()
	{
		$this->load->helper('get');
		$this->load->helper('allocine');
		
		if (!$this->check())
			return (false);
		else
		{
			$allocine 				= new Allocine('100043982026', '29d185d98c984a359e6e6f26a0474269');
			$result 				= (isset($_GET["limit"])) ?
										json_decode($allocine->search($_GET["q"], $_GET["limit"]))->feed :
										json_decode($allocine->search($_GET["q"]))->feed;
			$searchlist				= array();
			if (isset($result->movie))
				$searchlist			= array_merge($this->makeSearch($result->movie, 'movie'), $searchlist);
			if (isset($result->tvseries))
				$searchlist			= array_merge($this->makeSearch($result->tvseries, 'serie'), $searchlist);
			usort($searchlist, function($a, $b){
				if ($a['rating'] > $b['rating'])
					return false;
				else
					return true;
			});
			$searchlist 			= (isset($_GET['limit'])) ? array_slice($searchlist, 0, $_GET['limit']) : array_slice($searchlist, 0, 5);
			
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');
			echo json_encode($searchlist);
		}
	}

	private function makeSearch($search, $type)
	{
		$searchlist									= array();
		$i 											= 0;
		foreach ($search as $film)
		{
			$searchlist[$i]		 					= array();
			$searchlist[$i]['code']					= $film->code;
			$searchlist[$i]['type']					= $type;
			$searchlist[$i]['title']				= (isset($film->title)) ? $film->title : $film->originalTitle;
			$searchlist[$i]['release_date']			= (isset($film->productionYear)) ? $film->productionYear : 
														((isset($film->yearStart)) ? $film->yearStart : "");
			$searchlist[$i]['poster']				= (isset($film->poster->href)) ? $film->poster->href : "";
			$searchlist[$i]['actors']				= (isset($film->castingShort->actors)) ? $film->castingShort->actors : "";
			$searchlist[$i]['rating']				= (isset($film->statistics->userRating)) ? $film->statistics->userRating : 0;
			$i										= $i + 1;
		}
		return $searchlist;
	}

	private function check()
	{
		if (!isset($_GET['q']))
			return(get_helper::error());
		else if (isset($_GET["limit"]) && !get_helper::check(preg_match('/^\d+$/', $_GET["limit"]), 1))
			return(false);
		else
			return(true);
	}

}
