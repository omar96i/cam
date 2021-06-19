<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddGasto extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistronomina');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Madelantos');
		$this->load->model('MporcentajeDias');
		$this->load->model('MporcentajeMetas');
		$this->load->model('Mmetas');
		$this->load->model('Mgastos');
		$this->load->model('Mingresos');
		$this->load->model('MsalarioEmpleados');
		$this->load->model('MfacturasSupervisor');
		$this->load->model('MfacturaGeneral');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}


		$this->load->view('includes_admin/header');
		$this->load->view('admin/addGasto');
		$this->load->view('includes_admin/footer');
	}

	public function addGasto(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['descripcion'] = $this->input->post('descripcion');
		$data['valor'] = $this->input->post('valor');
		$data['fecha'] = $this->input->post('fecha');
		$data['id_empleado'] = $this->session->userdata('usuario')['id_usuario'];

		$respuesta = $this->Mgastos->addGasto($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
			return;
		}

		echo json_encode(['status' => true]);
	}

}
