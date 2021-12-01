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
		$this->load->model('Mcitas');

	}

	public function index(){
		if($this->session->userdata('usuario')['tipo']=='talento humano' || $this->session->userdata('usuario')['tipo']=='supervisor') {
			$id_usuario = $this->session->userdata('usuario')['id_usuario'];

			$data['asistencia']     = $this->Masistencia->t_h_getDatosAsistencia();

			if(!$data['asistencia']) {
				$data['asistencia'] = 0;
			} 
			else {
				$data['asistencia'] = count($this->Masistencia->t_h_getDatosAsistencia());
			}

			$data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_usuario);        
			$data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_usuario);


			if (!$data['cant_notificaciones']) {
				$data['cant_notificaciones'] = "vacio";
			}

			if (!$data['notificaciones']) {
				$data['notificaciones'] = "vacio";
			}

			
			$this->load->view('includes_admin/header', $data);
			$this->load->view('talento_humano/asistencia', $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}

		
	}

	public function getAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$usuarios         = $this->Masistencia->t_h_getDataAsistencia();

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
