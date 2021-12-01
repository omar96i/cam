<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FacturaMonitor extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MfacturaMonitor');
		$this->load->model('Mcitas');
	}

	public function index($fecha_inicial = "", $fecha_final = ""){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['factura'] = $this->MfacturaMonitor->getFacturas();
			if(!$data['factura']) {
				$data['factura'] = 0;
			} 
			else {
				$data['factura'] = count($this->MfacturaMonitor->getFacturas());
			}
			$data['fecha_inicial'] = $fecha_inicial;
			$data['fecha_final'] = $fecha_final;
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
			$this->load->view('admin/factura_monitor' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function registrarFactura(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['fecha_inicial'] = $this->input->post('fecha_inicial');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];

		$respuesta = $this->MfacturaMonitor->generarFactura($data);


		if ($respuesta) {
			echo json_encode(['status' => true]);
			return;
		}
		echo json_encode(['status' => false, 'msn' => 'NO SE PUDO REALIZAR EL REGISTRO']);
	}

	public function getFacturas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['fecha_inicio'] = $this->input->post('fecha_inicio');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$usuarios         = $this->MfacturaMonitor->getFacturasTable($data);
		if(!$usuarios) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $usuarios
			]);
	}

}
