<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SolicitarAdelanto extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mmetas');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Madelantos');
		$this->load->model('Mregistronomina');
		$this->load->model('Mcitas');
		$this->load->model('Madelantos');
    }
    
    public function index(){
		$this->load->view('includes_admin/header');
		$this->load->view('solicitarAdelanto');
		$this->load->view('includes_admin/footer');
	}
}
