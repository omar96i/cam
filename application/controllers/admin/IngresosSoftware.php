<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IngresosSoftware extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MhorasIngreso');
	}

	public function index() {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
        }

        $data['ingresos'] = $this->MhorasIngreso->getDataIngresos();

		if(!$data['ingresos']) {
			$data['ingresos'] = 0;
		} 
		else {
			$data['ingresos'] = count($this->MhorasIngreso->getDataIngresos());
		}
        
        $this->load->view('includes_admin/header');
		$this->load->view('admin/ingresosSoftware', $data);
		$this->load->view('includes_admin/footer');
	}

	public function getIngresos(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial    = $this->input->post('fecha_inicio');    
		$fecha_final 	  = $this->input->post('fecha_final');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$ingresos         = $this->MhorasIngreso->getDataGeneral($fecha_inicial, $fecha_final, $inicio, $cantidad);
		$total_registros  = count($this->MhorasIngreso->getDataGeneral($fecha_inicial, $fecha_final)); 

		if(!$ingresos) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $ingresos,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);
	}
}
