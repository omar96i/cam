<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mcitas');

	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='fotografo') {
			redirect('Home');
		}
		
		$fecha = date("Y-m-d");

        $this->Mcitas->actualizarCita($fecha);
        
        $this->load->view('includes_admin/header');
		$this->load->view('fotografo/home');
		$this->load->view('includes_admin/footer');
	}


	
}
