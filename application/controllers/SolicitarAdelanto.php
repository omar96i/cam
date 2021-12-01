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
		$id_usuario = $this->session->userdata('usuario')['id_usuario'];

        $data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_usuario);        
        $data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_usuario);


        if (!$data['cant_notificaciones']) {
			$data['cant_notificaciones'] = "vacio";
		}

        if (!$data['notificaciones']) {
            $data['notificaciones'] = "vacio";
        }
		$this->load->view('includes_admin/header', $data);
		$this->load->view('solicitarAdelanto');
		$this->load->view('includes_admin/footer');
	}
}
