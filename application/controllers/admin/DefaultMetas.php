<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DefaultMetas extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MmetasSupervisor');
		$this->load->model('Mmetas');
		$this->load->model('Mcitas');

	}

	public function index(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['metas'] = $this->MmetasSupervisor->getDatos();

			if(!$data['metas']) {
				$data['metas'] = 0;
			} 
			else {
				$data['metas'] = count($this->MmetasSupervisor->getDatos());
			}
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
			$this->load->view('admin/defaultMetas', $data);
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

	public function addMetaDefault(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
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
			$this->load->view('admin/addMetaDefault');
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

	public function store(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['tokens'] = $this->input->post('tokens');
		$data['aumento'] = $this->input->post('aumento');

		$respuesta = $this->MmetasSupervisor->store($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);
	}

	public function verMetas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		
		$metas = $this->MmetasSupervisor->getMetasTable();
		if(!$metas) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $metas
		]);
	}

	public function editMeta($id){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$id_usuario = $this->session->userdata('usuario')['id_usuario'];

			$data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_usuario);        
			$data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_usuario);


			if (!$data['cant_notificaciones']) {
				$data['cant_notificaciones'] = "vacio";
			}

			if (!$data['notificaciones']) {
				$data['notificaciones'] = "vacio";
			}
			$data['meta'] = $this->MmetasSupervisor->getDataOnly($id);
			$this->load->view('includes_admin/header', $data);
			$this->load->view('admin/editMetaDefault', $data);
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

	public function edit(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id'] = $this->input->post('id');
		$data['tokens'] = $this->input->post('tokens');
		$data['aumento'] = $this->input->post('aumento');

		$respuesta = $this->MmetasSupervisor->edit($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Editar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function delete(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id'] = $this->input->post('id');
		$data['estado'] = 'inactivo';
		$respuesta = $this->MmetasSupervisor->delete($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Delete']);
			return;
		}

		echo json_encode(['status' => true]);

	}

}
