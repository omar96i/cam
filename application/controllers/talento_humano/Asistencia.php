<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mdolar');
		$this->load->model('Mregistronomina');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Masistencia');

	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}

		$id_usuario = $this->session->userdata('usuario')['id_usuario'];

		$data['asistencia']     = $this->Masistencia->t_h_getDatosAsistencia();

		if(!$data['asistencia']) {
			$data['asistencia'] = 0;
		} 
		else {
			$data['asistencia'] = count($this->Masistencia->t_h_getDatosAsistencia());
		}

		
		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/asistencia', $data);
		$this->load->view('includes_admin/footer');
	}

	public function getAsistencia(){
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
		$usuarios         = $this->Masistencia->t_h_getDataAsistencia($valor , $fecha_inicial, $fecha_final, $inicio, $cantidad);
		$total_registros  = count($this->Masistencia->t_h_getDataAsistencia($valor, $fecha_inicial, $fecha_final)); 

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

	public function getItemsAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_asistencia = $this->input->post('id_asistencia');

		$respuesta[] = $this->Masistencia->extraerEmpleadosAsistencia($id_asistencia);
		$respuesta['motivos'] = $this->Masistencia->get_motivoAsistencias('');

		echo json_encode($respuesta);
	}

	
}
