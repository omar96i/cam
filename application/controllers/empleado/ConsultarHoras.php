<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultarHoras extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mmetas');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Madelantos');

	}

	public function verhoras(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial 	  = $this->input->post('fecha_inicial_buscar');
		$fecha_final  	  = $this->input->post('fecha_final_buscar');
		$id_usuario 	  = $this->session->userdata('usuario')['id_usuario'];
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$usuarios         = $this->Mregistrohoras->getHoras($valor , $id_usuario, $fecha_inicial, $fecha_final, $inicio, $cantidad);
		$total_registros  = count($this->Mregistrohoras->getHoras($valor, $id_usuario, $fecha_inicial, $fecha_final)); 

		if(!$usuarios) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $usuarios,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);

	}

	
}
