<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mreportes');
		$this->load->model('Mcitas');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='tecnico sistemas') {
			redirect('Home');
        }

        $id_tecnico = $this->session->userdata('usuario')['id_usuario'];

        $data['reportes'] = $this->Mreportes->getReportes($id_tecnico);

		if(!$data['reportes']) {
			$data['reportes'] = 0;
		} 
		else {
			$data['reportes'] = count($this->Mreportes->getReportes($id_tecnico));
		}

        $data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_tecnico);        
        $data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_tecnico);


        if (!$data['cant_notificaciones']) {
			$data['cant_notificaciones'] = "vacio";
		}

        if (!$data['notificaciones']) {
            $data['notificaciones'] = "vacio";
        }
        
        $this->load->view('includes_admin/header', $data);
		$this->load->view('tecnico_sistemas/reportes', $data);
		$this->load->view('includes_admin/footer');
	}

	public function getReportes(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial    = $this->input->post('fecha_inicio');    
		$fecha_final 	  = $this->input->post('fecha_final');
		$id_usuario       = $this->session->userdata('usuario')['id_usuario'];
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$informes         = $this->Mreportes->getDataReportes($id_usuario , $fecha_inicial, $fecha_final, $inicio, $cantidad);
		$total_registros  = count($this->Mreportes->getDataReportes($id_usuario, $fecha_inicial, $fecha_final)); 

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
