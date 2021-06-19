<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mreportes');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
        }

        $data['reportes'] = $this->Mreportes->getReportesAdmin();

		if(!$data['reportes']) {
			$data['reportes'] = 0;
		} 
		else {
			$data['reportes'] = count($this->Mreportes->getReportesAdmin());
		}
        
        $this->load->view('includes_admin/header');
		$this->load->view('admin/reportes', $data);
		$this->load->view('includes_admin/footer');
	}

	public function getReportes(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial    = $this->input->post('fecha_inicio');    
		$fecha_final 	  = $this->input->post('fecha_final');
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$informes         = $this->Mreportes->getDataReportesAdmin($fecha_inicial, $fecha_final, $inicio, $cantidad);
		$total_registros  = count($this->Mreportes->getDataReportesAdmin($fecha_inicial, $fecha_final)); 

		if(!$informes) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $informes,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);
	}
	
}
