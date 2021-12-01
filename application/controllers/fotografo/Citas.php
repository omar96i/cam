<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Citas extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mcitas');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='fotografo') {
			redirect('Home');
        }

        $id_fotografo = $this->session->userdata('usuario')['id_usuario'];

        $data['citas'] = $this->Mcitas->getCitas($id_fotografo);

        $data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_fotografo);        
        $data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_fotografo);


        if (!$data['cant_notificaciones']) {
			$data['cant_notificaciones'] = "vacio";
		}

        if (!$data['notificaciones']) {
            $data['notificaciones'] = "vacio";
        }

		if(!$data['citas']) {
			$data['citas'] = 0;
		} 
		else {
			$data['citas'] = count($this->Mcitas->getCitas($id_fotografo));
		}
        
        $this->load->view('includes_admin/header', $data);
		$this->load->view('fotografo/citas', $data);
		$this->load->view('includes_admin/footer');
	}



	public function getCitas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_usuario       = $this->session->userdata('usuario')['id_usuario'];
		$citas         = $this->Mcitas->getDataCitas($id_usuario);

		if(!$citas) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $citas
			]);
	}

	public function getCitasAdmin(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$citas            = $this->Mcitas->getDataCitasAdmin();

		if(!$citas) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $citas
			]);
	}

	public function delete_cita(){
		$id = $this->input->post('id_cita');
		$respuesta = $this->Mcitas->delete_cita($id);
		if (!$respuesta) {
			echo json_encode(['status' => false , 'msg' => 'Error al eliminar']);
			return;
		}
		echo json_encode(['status' => true]);
	}
	
}
