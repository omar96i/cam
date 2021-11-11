<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Citas extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mcitas');
	}

	public function index(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			
			
			$this->load->view('includes_admin/header');
			$this->load->view('admin/citas');
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

}
