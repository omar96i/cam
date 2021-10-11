<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerAsistencia extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Masistencia');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Mmetas');


	}

	public function index(){
		if($this->session->userdata('usuario')['tipo']=='supervisor' || $this->session->userdata('usuario')['tipo']=='tecnico sistemas') {
			$id_usuario = $this->session->userdata('usuario')['id_usuario'];

			$data['asistencia']     = $this->Masistencia->getDatosAsistencia($id_usuario);

			if(!$data['asistencia']) {
				$data['asistencia'] = 0;
			} 
			else {
				$data['asistencia'] = count($this->Masistencia->getDatosAsistencia($id_usuario));
			}

			
			$this->load->view('includes_admin/header');
			$this->load->view('supervisor/verAsistencia', $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}

		
	}

	public function getItemsAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_asistencia = $this->input->post('id_asistencia');

		$respuesta = $this->Masistencia->get_regitroAsistencias($id_asistencia);

		echo json_encode($respuesta);
	}


	public function getAsistencias(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial    = $this->input->post('fecha_inicio');    
		$fecha_final 	  = $this->input->post('fecha_final');
		$id_usuario 	  = $this->session->userdata('usuario')['id_usuario'];
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$asistencia         = $this->Masistencia->getDataAsistencia($id_usuario, $fecha_inicial, $fecha_final, $inicio, $cantidad);
		$total_registros  = count($this->Masistencia->getDataAsistencia($id_usuario, $fecha_inicial, $fecha_final)); 

		if(!$asistencia) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $asistencia,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);
	}
}
