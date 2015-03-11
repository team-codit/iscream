<?php
// echo '<pre>'; print_r(json_decode($result)); echo '</pre>';
set_time_limit(1200);

class Products extends CI_Controller
{

	public function index()
	{
		show_404();
	}
	
	public function movies()
	{
		$this->load->helper('get');
		$this->load->helper('allocine');
		$this->load->model('Products_model');

		$filter_set				= false;
		$attributes				= array(
			'sort' 				=> array("toprank", "datedesc", "dateasc"),
			'filter'			=> array("genres", "languages")
		);

		if (!$this->check($attributes['sort'], $attributes['filter']))
			return (false);
		else
		{
			$allocine 			= new Allocine('100043982026', '29d185d98c984a359e6e6f26a0474269');
			$result 			= (isset($_GET["page"]) && preg_match('/\d+/', $_GET["page"])) ?
									$allocine->toplist($_GET["limit"], $_GET["sort"], $_GET["page"]) :
									$allocine->toplist($_GET["limit"], $_GET["sort"]);
			$toplist			= $this->makeTopMovie(json_decode($result)->feed->movie);
			$toplist			= $this->filterTopMovie($toplist, $attributes);
			
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');
			echo json_encode($toplist);
		}
	}
	
	private function filterTopMovie($toplist, $attributes)
	{
		$toplistfiltered							= array();
		foreach ($attributes['filter'] as $value)
			foreach ($toplist['list'] as $key => $movie)
			{
				if (isset($_GET[$value]) && in_array($_GET[$value], $movie[$value]))
				{
					if (!in_array($key, $toplistfiltered))
						$toplistfiltered[]			= $key;
				}
				else if (isset($_GET[$value]) && is_array($_GET[$value]))
					foreach ($_GET[$value] as $attr)
						if (in_array($attr, $movie[$value]))
							if (!in_array($key, $toplistfiltered))
								$toplistfiltered[]	= $key;
			}
		$counter 									= count($toplist['list']);
		if (!empty($toplistfiltered))
			for ($i = 0; $i < $counter; $i++)
				if (!in_array($i, $toplistfiltered))
					unset($toplist['list'][$i]);
		$toplist['list'] = array_values($toplist['list']);
		return ($toplist);
	}
	
	private function makeTopMovie($toplist, $type = 'movie')
	{
		$this->load->helper('images');
		
		$list											= array();
		$all_genres										= array();
		$all_languages									= array();
		$i 												= 0;
		foreach ($toplist as $film)
		{
			$list[$i]		 							= array();
			$list[$i]['code'] 							= $film->code;
			$list[$i]['title'] 							= $film->title;
			$list[$i]['genres'] 						= array();
			if (isset($film->genre))
				foreach ($film->genre as $genres)
					foreach ($genres as $key => $genre)
						if ($key == '$')
						{
							if (!in_array($genre, $all_genres))
								$all_genres[] 			= $genre;
							$list[$i]['genres'][] 		= $genre;
						}
			$list[$i]['languages'] 						= array();
			if (isset($film->language))
				foreach ($film->language as $languages)
					foreach ($languages as $key => $language)
						if ($key == '$')
						{
							if (!in_array($language, $all_languages))
								$all_languages[] 		= $language;
							$list[$i]['languages'][]	= $language;
						}
			$list[$i]['runtime'] 						= isset($film->runtime) ? date('j\h i\m\i\n', $film->runtime) : 0;
			$list[$i]['runtime_timestamp'] 				= isset($film->runtime) ? $film->runtime : 0;
			if (isset($film->poster->href))
				images_helper::save($film->poster->href, './img/', $film->code);
			$list[$i]['poster'] 						= (isset($film->poster->href)) ? 	'http://api.iscream.mages.agency/img/' . $film->code . '_thumb.jpg' : 
																							'http://scimath.unl.edu/csmce/images/directory/noimage.jpg';
			$list[$i]['release_date'] 					= date('Y', strtotime($film->release->releaseDate));
			$list[$i]['release_timestamp'] 				= strtotime($film->release->releaseDate);
			$list[$i]['rating'] 						= (isset($film->statistics->pressRating) && isset($film->statistics->userRating)) ?
															($film->statistics->pressRating + $film->statistics->userRating) / 2 : 0 ;
			$list[$i]['rating'] 						= $list[$i]['rating'] * 100 / 5;
			$list[$i]['shop']							= (isset($film->hasBlueray) || isset($film->hasDVD)) ? true : false;
			$list[$i]['vod']							= (isset($film->hasVOD)) ? true : false;
			$list[$i]['cinema']							= (isset($film->hasShowtime)) ? true : false;
			$i											= $i + 1;
		}
		return array(
			'genres' 									=> $all_genres, 
			'languages' 								=> $all_languages, 
			'list' 										=> $list
		);
	}
	
	private function check($sort, $filter)
	{
		if (!isset($_GET['limit']) || !isset($_GET['sort']))
			return(get_helper::error());
		else if (!get_helper::check(preg_match('/^\d+$/', $_GET["limit"]), 1))
			return(false);
		else if (!get_helper::check($_GET["sort"], $sort))
			return(false);
		else
			return(true);
	}
	
}