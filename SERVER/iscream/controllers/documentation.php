<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentation extends CI_Controller {
	public function index()
	{
		$this->load->view('documentation');
	}
}
