<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddReportes extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mreportes');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='tecnico sistemas') {
			redirect('Home');
        }
        
        $this->load->view('includes_admin/header');
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
