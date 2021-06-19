<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gastos extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mdolar');
		$this->load->model('Mregistronomina');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Masistencia');

	}

	public function index() {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}
		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/gastos');
		$this->load->view('includes_admin/footer');
	}


	
}
