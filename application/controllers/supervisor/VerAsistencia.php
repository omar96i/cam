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
		$this->load->model('Mcitas');

	}

	public function getModels(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id_usuario = $this->session->userdata('usuario')['id_usuario'];

		$data['modelos'] = $this->Musuarios->getModelsMonitor($id_usuario);

		echo json_encode($data);
	}

	public function getModelsAssist(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id_asistencia = $this->input->post('id_asistencia');

		$data['modelos'] = $this->Masistencia->getModelsAssist($id_asistencia);

		echo json_encode($data);
	}

	public function AddModelo(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_empleado'] = $this->input->post('id_modelo');
		$data['id_asistencia'] = $this->input->post('id_asistencia');
		$data['estado'] = "registrado";
		$verificar = $this->Masistencia->VerificarModelo($data);
		if($verificar){
			echo json_encode(['status'=>false,'msg' => 'La modelo ya se encuentra registrada en la fecha seleccionada']);
			return;
		}
		$respuesta = $this->Masistencia->AddAsistenciaEmpleado($data);
		echo json_encode(['status' => true]);
	}

	public function DeleteModelo(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_empleado'] = $this->input->post('id_modelo');
		$data['id_asistencia'] = $this->input->post('id_asistencia');
		$data['estado'] = "registrado";
		$verificar = $this->Masistencia->VerificarModelo($data);
		if(!$verificar){
			echo json_encode(['status' => false, 'msg' => 'La no se encuentra en la Fecha seleccionada']);
			return;
		}
		$respuesta = $this->Masistencia->DeleteModeloAsistencia($data);
		echo json_encode(['status' => true]);
	}

	public function eliminarModeloAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id_empleado'] = $this->input->post('id_empleado');
		$data['id_asistencia'] = $this->input->post('id_asistencia');
		$verificar = $this->Masistencia->VerificarAsignaciones($data['id_empleado']);
		if($verificar){
			echo json_encode(['status' => false, 'msg' => 'La modelo seleccionada solo tiene una asignacion']);
			return;
		}
		$this->Masistencia->DeleteModeloAsistencia($data);
		echo json_encode(['status' => true]);
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

			$data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_usuario);        
			$data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_usuario);


			if (!$data['cant_notificaciones']) {
				$data['cant_notificaciones'] = "vacio";
			}

			if (!$data['notificaciones']) {
				$data['notificaciones'] = "vacio";
			}

			
			$this->load->view('includes_admin/header', $data);
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

		$id_usuario 	  = $this->session->userdata('usuario')['id_usuario'];
		$asistencia         = $this->Masistencia->getDataAsistencia($id_usuario);

		if(!$asistencia) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $asistencia
			]);
	}
}
