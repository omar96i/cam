<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditarGasto extends CI_Controller {
	

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

	public function index($id){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['respuesta'] = $this->Mgastos->getDataEditGasto($id);

		if (!$data['respuesta']) {
			$data['respuesta'] = "NO##ENCONTRO##NADA";
		}

		$this->load->view('includes_admin/header');
		$this->load->view('admin/editarGasto', $data);
		$this->load->view('includes_admin/footer');
	}


	public function EditGasto(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['descripcion'] = $this->input->post('descripcion');
		$data['valor'] = $this->input->post('valor');
		$data['id_gasto'] = $this->input->post('id');
		$data['fecha'] = $this->input->post('fecha');

		$respuesta = $this->Mgastos->editGasto($data);

		if (!$respuesta) {
			echo json_encode(['status' => false, 'msn' => 'Ago paso ups']);
			return;
		}

		echo json_encode(['status' => true]);
	}
}
