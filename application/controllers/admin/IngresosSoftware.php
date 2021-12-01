<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IngresosSoftware extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MingresosSoftware');
		$this->load->model('Mcitas');
	}

	public function index() {
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
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
			$this->load->view('admin/ingresosSoftware');
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

	public function getIngresos(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$ingresos         = $this->MingresosSoftware->getDataGeneral();

		if(!$ingresos) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $ingresos
			]);
	}
}
