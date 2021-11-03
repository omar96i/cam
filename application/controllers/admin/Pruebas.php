<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
	}
	
	public function pruebas(){
		$respuesta = file_get_contents('https://chaturbate.com/statsapi/');

		var_dump($respuesta);
	}
	
}
