<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddCita extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
        $this->load->model('Mcitas');
		$this->load->model('Musuarios');
        
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='psicologa') {
			redirect('Home');
        }
        
        $data['empleados'] = $this->Musuarios->getUsuariosFotografo();

        $this->load->view('includes_admin/header');
		$this->load->view('psicologa/addCita', $data);
		$this->load->view('includes_admin/footer');
	}

	public function addCita(){
		$data['descripcion'] = $this->input->post('descripcion');	
		$data['id_fotografo'] = $this->session->userdata('usuario')['id_usuario'];
		$data['fecha'] = $this->input->post('fecha');
        $data['hora'] = $this->input->post('hora');
        $data['id_empleado'] = $this->input->post('id_usuario');
        $data['tipo'] = "psicologa";


		$respuesta = $this->Mcitas->addCita($data);

		if (!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Error al insertar el registro']);
			return;
		}

		echo json_encode(['status' => true]);
	}
	
}
