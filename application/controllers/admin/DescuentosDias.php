<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DescuentosDias extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MdescuentosDias');
		$this->load->model('Musuarios');
		$this->load->model('Mcitas');

	}

	public function index(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['descuentos'] = $this->MdescuentosDias->getDatos();

			if(!$data['descuentos']) {
				$data['descuentos'] = 0;
			} 
			else {
				$data['descuentos'] = count($this->MdescuentosDias->getDatos());
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
			$this->load->view('admin/descuentosDias', $data);
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}
	public function verDescuentos(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		
		$adelantos = $this->MdescuentosDias->getDescuentosTable();
		if(!$adelantos) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $adelantos
		]);
	}

	public function addDescuento(){
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
			$data['usuarios'] = $this->Musuarios->getDatosDescuentos();
			$this->load->view('includes_admin/header', $data);
			$this->load->view('admin/addDescuento', $data);
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

		$data['id_persona'] = $this->input->post('usuario');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['fecha'] = $this->input->post('fecha');
		$data['valor'] = $this->input->post('valor');
		$data['estado'] = "sin registrar";

		$respuesta = $this->MdescuentosDias->store($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function editDescuento($id){
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
			$data['descuento'] = $this->MdescuentosDias->getDataOnly($id);
			$data['usuarios'] = $this->Musuarios->getDatosDescuentos();
			$this->load->view('includes_admin/header', $data);
			$this->load->view('admin/editDescuento', $data);
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
		$data['id_persona'] = $this->input->post('usuario');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['fecha'] = $this->input->post('fecha');
		$data['valor'] = $this->input->post('valor');

		$respuesta = $this->MdescuentosDias->edit($data);

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
		$data['id'] = $this->input->post('id_descuento');
		$data['estado'] = 'inactivo';
		$respuesta = $this->MdescuentosDias->delete($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Delete']);
			return;
		}

		echo json_encode(['status' => true]);

	}

}
