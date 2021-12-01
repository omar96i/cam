<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistorialTokens extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mcitas');
	}

	public function index($fecha_inicial = "", $fecha_final = "", $id_supervisor = false, $id_empleado = false, $estado_registro=""){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			
			$data['fecha_inicial'] = $fecha_inicial;
			$data['fecha_final'] = $fecha_final;
			$data['id_supervisor'] = $id_supervisor;
			$data['id_empleado'] = $id_empleado;
			$data['estado_registro'] = $estado_registro;
			$data['modelos'] = $this->Musuarios->get_empleados();
			$data['monitores'] = $this->Musuarios->getMonitor();
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
			$this->load->view('admin/historialTokens/historialTokens', $data);
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

	public function getDataTable(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['fecha_inicial'] = $this->input->post('fecha_inicial');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$data['id_modelo'] = $this->input->post('id_modelo');
		$data['id_monitor'] = $this->input->post('id_monitor');
		$data['estado_registro'] = $this->input->post('estado_registro');
		$tokens  = $this->Mregistrohoras->getDataTableFiltro($data);
		if(!$tokens) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $tokens
			]);
	}

}
