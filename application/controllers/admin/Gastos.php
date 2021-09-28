<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gastos extends CI_Controller {
	

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

	public function index() {
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$this->load->view('includes_admin/header');
			$this->load->view('admin/gastos');
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function getGastos(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$usuarios         = $this->Mgastos->getGastos($valor ,  $inicio, $cantidad);

		if(!$usuarios) {
			echo json_encode(['status' => false]);
			return;
		}

		$total_registros  = count($this->Mgastos->getGastos($valor)); 
		

		

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $usuarios,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);
	}

	public function getIngresos(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$usuarios         = $this->Mingresos->getIngresos($valor ,  $inicio, $cantidad);
		
		if(!$usuarios) {
			echo json_encode(['status' => false]);
			return;
		}

		$total_registros  = count($this->Mingresos->getIngresos($valor)); 
		

		

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $usuarios,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);
	}

	public function getDataAnalisis(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$datos = [];

		$data['fecha_inicio'] = $this->input->post('fecha_inicio');
		$data['fecha_final'] = $this->input->post('fecha_final');

		$ingresos = $this->Mingresos->getGeneral($data);
		$gastos = $this->Mgastos->getGeneral($data);

		if ($ingresos[0]->valor == null) {
			$ingresos[0]->valor = 0;
		}
		if ($gastos[0]->valor == null) {
			$gastos[0]->valor = 0;
		}

		$datos['gastos'] = $gastos[0]->valor;
		$datos['ingresos'] = $ingresos[0]->valor;
		$datos['total'] = $datos['ingresos']-$datos['gastos'];

		if ($datos['total'] >= 0) {
			$datos['estado'] = "OK";
		}else{
			$datos['estado'] = "ERROR";
		}

		echo json_encode($datos);
	}
}
