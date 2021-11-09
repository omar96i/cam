<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aumentos extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Maumentos');
	}

	public function index($tipo = "sin_registrar"){

		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$this->load->view('includes_admin/header');
			$this->load->view('admin/aumentos/index', ['tipo' => $tipo]);
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

	public function getDataTable(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		
		$aumentos = $this->Maumentos->getDataTable();
		if(!$aumentos) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $aumentos
		]);
	}

	public function addAumento(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['usuarios'] = $this->Musuarios->getDatosDescuentos();
			$this->load->view('includes_admin/header');
			$this->load->view('admin/aumentos/store', $data);
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

		$data['id_persona'] = $this->input->post('id_persona');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['fecha'] = $this->input->post('fecha');
		$data['valor'] = $this->input->post('valor');

		$respuesta = $this->Maumentos->store($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function edit($id){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['aumento'] = $this->Maumentos->getAumento($id);
			$data['usuarios'] = $this->Musuarios->getDatosDescuentos();
			$this->load->view('includes_admin/header');
			$this->load->view('admin/aumentos/edit', $data);
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

	public function update(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id'] = $this->input->post('id');
		$data['id_persona'] = $this->input->post('id_persona');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['fecha'] = $this->input->post('fecha');
		$data['valor'] = $this->input->post('valor');

		$respuesta = $this->Maumentos->update($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Editar']);
			return;
		}

		echo json_encode(['status' => $data]);	
	}

	public function delete(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id'] = $this->input->post('id');
		$data['estado'] = 'inactivo';
		$respuesta = $this->Maumentos->update($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Delete']);
			return;
		}

		echo json_encode(['status' => true]);
	}

}
