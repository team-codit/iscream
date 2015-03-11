<?php

class Cards extends CI_Controller
{

	public function index()
	{
		$this->load->helper('get');
		$this->load->helper('allocine');
		
		if (!$this->check())
			return (false);
		else
		{
			$allocine 	= new Allocine('100043982026', '29d185d98c984a359e6e6f26a0474269');
			
			if (isset($_GET['type']) && $_GET['type'] == 'series')
			{
				$result 	= json_decode($allocine->getSeries($_GET["code"]));
				$result		= (isset($result->tvseries)) ? $result->tvseries : null;
			}
			else
			{
				$result 	= json_decode($allocine->getMovie($_GET["code"]));
				$result		= (isset($result->movie)) ? $result->movie : null;

			}
 			// echo '<pre>'; print_r($result); echo '</pre>'; die();
			if ($result)
			{
				$card 	= $this->makeCard($result);
				header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/json');
				echo json_encode($card);
			}
		}
	}

	private function makeCard($result)
	{
		$card									= array();
		$card['originaltitle'] 					= $result->originalTitle;
		$card['title'] 							= $result->title;
		$card['release_date'] 					= (isset($result->productionYear)) ? $result->productionYear : ((isset($result->yearStart)) ? $result->yearStart : "");
		$card['release_timestamp'] 				= (isset($result->release->releaseDate)) ? strtotime($result->release->releaseDate) : "";
		$card['genres'] 						= array();
		$card['genres_string'] 					= "";
		if (isset($result->genre))
			foreach ($result->genre as $genres)
				foreach ($genres as $key => $genre)
					if ($key == '$')
					{
						$card['genres_string']	.= ($card['genres_string'] != "") ? ', ' . $genre : $genre;
						$card['genres'][] 		= $genre;
					}
		$card['languages'] 						= array();
		if (isset($result->language))
			foreach ($result->language as $languages)
				foreach ($languages as $key => $language)
					if ($key == '$')
						$card['languages'][]	= $language;
		$card['directors'] 						= (isset($result->castingShort->directors)) ? $result->castingShort->directors : "";
		$card['actors'] 						= (isset($result->castingShort->actors)) ? $result->castingShort->actors : "";
		$card['runtime'] 						= (isset($result->runtime)) ? date('j\h i\m\i\n', $result->runtime) : ((isset($result->seasonCount)) ? 
													$result->seasonCount . " saison" . (($result->seasonCount > 1) ? "s" : "") : "");
		$card['runtime_timestamp'] 				= (isset($result->runtime)) ? $result->runtime : ((isset($result->seasonCount)) ? $result->seasonCount : 0);
		$card['synopsis'] 						= (isset($result->synopsis)) ? $result->synopsis : "";
		$card['trailer'] 						= (isset($result->trailer->href)) ? $result->trailer->href : "";
		$card['poster'] 						= (isset($result->poster->href)) ? $result->poster->href : "";
		$card['wallpaper'] 						= null;
		for ($i = 0; !$card['wallpaper'] && isset($result->media[$i]); $i++)
			foreach ($result->media[$i]->type as $key => $value)
				if ($key == '$' && $value == 'Photo')
					$card['wallpaper'] 			= (isset($result->media[$i]->thumbnail->href)) ? $result->media[$i]->thumbnail->href : "";
		$card['rating'] 						= (isset($result->statistics->pressRating) && isset($result->statistics->userRating)) ?
													($result->statistics->pressRating + $result->statistics->userRating) / 2 : 0 ;
		$card['rating'] 						= $card['rating'] * 100 / 5;
		$card['shop']							= (isset($result->hasBlueray) || isset($result->hasDVD)) ? true : false;
		$card['vod']							= (isset($result->hasVOD)) ? true : false;
		$card['cinema']							= (isset($result->hasShowtime)) ? true : false;
		return ($card);
	}

	private function check()
	{
		if (!isset($_GET['code']))
			return(get_helper::error());
		else if (!get_helper::check(preg_match('/^\d+$/', $_GET["code"]), 1))
			return(false);
		else
			return(true);
	}

}
