<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddReportes extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mreportes');
		$this->load->model('Mcitas');

	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='tecnico sistemas') {
			redirect('Home');
        }

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
		$this->load->view('tecnico_sistemas/addReportes');
		$this->load->view('includes_admin/footer');
	}

	public function addReporte(){
		$data['descripcion'] = $this->input->post('descripcion');	
		$data['id_tecnico'] = $this->session->userdata('usuario')['id_usuario'];
		$data['fecha'] = $this->input->post('fecha');

		$respuesta = $this->Mreportes->addReporte($data);

		if (!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Error al insertar el registro']);
			return;
		}

		echo json_encode(['status' => true]);
	}
	
}
