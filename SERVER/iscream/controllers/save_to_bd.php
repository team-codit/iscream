<?php
//header('Content-Type: application/json');
set_time_limit(1200);

class Save_to_bd extends CI_Controller
{

	public function index()
	{
		$this->load->database();
		
		$this->load->helper('get');
		$this->load->helper('allocine');
		$this->load->model('Products_model');

		$filter_set				= false;
		$attributes				= array(
			'sort' 					=> array("toprank", "datedesc", "dateasc"),
			'filter'				=> array("genres", "languages")
		);

		$allocine 			= new Allocine('100043982026', '29d185d98c984a359e6e6f26a0474269');
		$result 			= (isset($_GET["page"]) && preg_match('/\d+/', $_GET["page"])) ?
								$allocine->topList_save($_GET["limit"], $_GET["sort"], $_GET["page"]) :
								$allocine->topList_save($_GET["limit"], $_GET["sort"]);
		$result = json_decode($result, TRUE);
		foreach ($result['feed']['movie'] as $movie) {
			$query = $this->db->query("SELECT * FROM `cards` WHERE `code` = " . $movie['code'] . " LIMIT 0,1");
			if ($query->num_rows() < 1) {
				$insert = array(
					'code' => (isset($movie['code'])) ? $movie['code'] : '',
					'title' => (isset($movie['title'])) ? $movie['title'] : '',
					'description' =>  (isset($movie['synopsisShort'])) ? $movie['synopsisShort'] : '',
					'genres' => $this->genres($movie['genre']),
					'runtime' => (isset($movie['runtime'])) ? date('j\h i\m\i\n', $movie['runtime']) : '',
					'runtime_timestamp' => (isset($movie['runtime'])) ? $movie['runtime'] : '',
					'release_date' => (isset($movie['productionYear'])) ? $movie['productionYear'] : '',
					'release_timestamp' => (isset($movie['release']['releaseDate'])) ? strtotime($movie['release']['releaseDate']) : 0,
					'rating' => ((isset($movie['statistics']['userRating'], $movie['statistics']['pressRating'])) ? ((($movie['statistics']['pressRating'] + $movie['statistics']['userRating']) / 2)  * 100 / 5) : 0),
					'shop' => (isset($movie['hasBlueray'], $movie['hasDVD'])) ? 1 : 0,
					'vod' => (isset($movie['hasVOD'])) ? 1 : 0,
					'cinema' => (isset($movie['hasShowtime'])) ? 1 : 0,
					'allocine' => json_encode($movie),
				);
				try {
					$this->db->insert('cards', $insert);
				} catch (Exception $e) {}
			}
		}
		print_r("OK");
	}
	
	private function genres($genres) {
		$a_genres = array();
		foreach ($genres as $genre)
			foreach ($genre as $key => $name)
				if ($key == '$')
					$a_genres[] = $name;
		return json_encode($a_genres);
	}
}