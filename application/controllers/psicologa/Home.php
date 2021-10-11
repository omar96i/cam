<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='psicologa') {
			redirect('Home');
        }

        
        $this->load->view('includes_admin/header');
		$this->load->view('psicologa/home');
		$this->load->view('includes_admin/footer');
	}
}
