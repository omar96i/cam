<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
	}

	
	public function getUser()	{

		
		$data['email'] = $this->input->post('email');
		$data['clave'] = $this->input->post('password');
		$validate = $this->Mlogin->valid_login($data);

		echo json_encode($validate);
	}
}
