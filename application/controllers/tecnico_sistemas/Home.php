<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mcitas');

	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='tecnico sistemas') {
			redirect('Home');
        }

		$data['user'] = $this->Musuarios->getUser($this->session->userdata('usuario')['id_usuario']);
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
		$this->load->view('tecnico_sistemas/home', $data);
		$this->load->view('includes_admin/footer');
	}


	
}
