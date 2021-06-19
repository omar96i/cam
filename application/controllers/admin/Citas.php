<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Citas extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mcitas');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
        }

       

        $data['citas'] = $this->Mcitas->getCitasAdmin();

		if(!$data['citas']) {
			$data['citas'] = 0;
		} 
		else {
			$data['citas'] = count($this->Mcitas->getCitasAdmin());
		}
        
        $this->load->view('includes_admin/header');
		$this->load->view('admin/citas', $data);
		$this->load->view('includes_admin/footer');
	}

	

}
