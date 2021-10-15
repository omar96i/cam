<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	

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

	public function index() {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}
		$id_usuario = $this->session->userdata('usuario')['id_usuario'];
		$data['meta'] = $this->Mmetas->getMetasOnlyEmpleado($id_usuario);
		$data['num_horas'] = $this->Mmetas->getNumHorasSupervisor($id_usuario);

		if (!empty($data['meta'])) {
			if ($data['num_horas'][0]->cantidad_horas == null) {
				$data['num_horas'][0]->cantidad_horas = 0;
			}
			$data['total'] = $data['meta']->num_horas-$data['num_horas'][0]->cantidad_horas;
		}
		
		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/home', $data);
		$this->load->view('includes_admin/footer');
	}



	public function empleados(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}

		$id_usuario = $this->session->userdata('usuario')['id_usuario'];

		$data['empleados']     = $this->Masignaciones->getOnlyEmpleados($id_usuario);

		if(!$data['empleados']) {
			$data['empleados'] = 0;
		} 
		else {
			$data['empleados'] = count($this->Masignaciones->getOnlyEmpleados($id_usuario));
		}

		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/empleados' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function verempleados(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}


		$id_usuario 	  = $this->session->userdata('usuario')['id_usuario'];
		$usuarios         = $this->Masignaciones->getAllUsuarios($id_usuario);

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

	public function registrarHoras(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}
		$id_usuario = $this->session->userdata('usuario')['id_usuario'];
		$data['lista_usuarios'] = $this->Masignaciones->getOnlyEmpleados($id_usuario); 
		if(!$data['lista_usuarios']) {
			$data['lista_usuarios'] = 0;
		} 
		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/addhoras' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function addpages(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_usuario = $this->input->post('id_usuario');

		$respuesta = $this->Mpaginas->getPagesUsuario($id_usuario);

		if (!$respuesta) {
			$respuesta = 0;
		}

		echo json_encode($respuesta);
	}

	public function addHoras(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_empleado'] = $this->input->post('usuarios');
		$data['id_pagina'] = $this->input->post('paginas');
		$data['id_supervisor'] = $this->session->userdata('usuario')['id_usuario'];

		$data['cantidad_horas'] = $this->input->post('cantidad_horas');
		$data['fecha_registro'] = $this->input->post('fecha');
		$data['estado_registro'] = "sin registrar";

		$respuesta = $this->Mregistrohoras->addHoras($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
			return;
		}

		echo json_encode(['status' => true]);
	}

	public function verpaginas($id_usuario){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}

		$data['paginas'] = $this->Mpaginas->getPagesUsuario($id_usuario);
		$data['usuario'] = $id_usuario;

		if(!$data['paginas']) {
			$data['paginas'] = 0;
		} 
		else {
			$data['paginas'] = count($this->Mpaginas->getPagesUsuario($id_usuario));
		}

		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/verpaginas' , $data);
		$this->load->view('includes_admin/footer');

	}

	public function getpages(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id_usuario 	  = $this->input->post('id_usuario');
		$usuarios         = $this->Mpaginas->getPagesUsuarios($id_usuario);

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

	public function verhoras($id_usuario){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}

		$data['paginas'] = $this->Mregistrohoras->getHorasEmpleado($id_usuario);
		$data['usuario'] = $id_usuario;

		if(!$data['paginas']) {
			$data['paginas'] = 0;
		} 
		else {
			$data['paginas'] = count($this->Mregistrohoras->getHorasEmpleado($id_usuario));
		}

		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/verhorasregistradas' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function gethoras(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_usuario 	  = $this->input->post('id_usuario');
		$usuarios         = $this->Mregistrohoras->getHorasUsuario($id_usuario);

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

	public function editarhoras($id_registro, $id_empleado){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}
		$inf_registro = $this->Mregistrohoras->dataregistro($id_registro);

		$data['registro_horas']   = $inf_registro;
		$data['id_empleado']   = $id_empleado;
		//$data['categorias']  = $this->Mcategorias->getcategorias();
		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/editar_horas' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function editRegistroHoras(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['fecha_registro'] = $this->input->post('fecha_registro');
		$data['cantidad_horas'] = $this->input->post('cantidad_horas');
		$id_registro_horas = $this->input->post('id_registro_horas');

		$respuesta = $this->Mregistrohoras->editarregistro($data, $id_registro_horas);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
			return;
		}

		echo json_encode(['status' => true]);

	}

	/// ASISTENCIA INICIO ///

	public function asistencia(){
		if($this->session->userdata('usuario')['tipo']=='supervisor' || $this->session->userdata('usuario')['tipo']=='tecnico sistemas') {
			$id_supervisor = $this->session->userdata('usuario')['id_usuario'];

			$data['asistencia']     = $this->Masistencia->getAsistencias($id_supervisor);

			if(!$data['asistencia']) {
				$data['asistencia'] = 0;

			}else {
				$data['items_asistencia'] = $this->Masistencia->extraerEmpleadosAsistencia($data['asistencia'][0]->id_asistencia);
				$data['fecha'] = $data['asistencia'][0]->fecha;
				$data['asistencia'] = count($this->Masistencia->getAsistencias($id_supervisor));
				$data['motivos'] = $this->Masistencia->get_motivoAsistencias('');
			}

			$this->load->view('includes_admin/header');
			$this->load->view('supervisor/asistencia' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function verificarAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$tipo_usuario = $this->session->userdata('usuario')['tipo'];
		$id_supervisor = $this->session->userdata('usuario')['id_usuario'];
		$fecha = $this->input->post('fecha_asistencia');
		$bandera = $this->Masistencia->verificarAsistenciaFecha($fecha, $id_supervisor);
		if (!$bandera) {
			$respuesta = $this->Masistencia->insertAsistencia($id_supervisor, $tipo_usuario, $fecha);
			if ($respuesta) {
				echo json_encode(['status' => true]);
			}else{
				echo json_encode(['status' => false]);
			}
			return;
		}
		echo json_encode(['status' => false, 'mensaje' => 'Asistencia ya creada']);
	}

	public function actualizarAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$items_usuario = json_decode($this->input->post('items_usuario'));
		$id_asistencia = $this->input->post('id_asistencia');
		
		$respuesta = $this->Masistencia->updateAsistencia($items_usuario, $id_asistencia);

		echo json_encode($respuesta);

	}

	public function finalizarAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_asistencia = $this->input->post('id_asistencia');
		$respuesta = $this->Masistencia->finalizarAsistencia($id_asistencia);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'No se pudo Finalizar la lista']);
			return;
		}

		echo json_encode(['status' => true]);

	}

	/// ASISTENCIA FIN ///

	/// PENALIZACIONES INICIO ///

	public function registrarPenalizacion(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}

		$id_supervisor = $this->session->userdata('usuario')['id_usuario'];
		$data['lista_usuarios'] = $this->Masignaciones->getOnlyEmpleados($id_supervisor);
		$data['lista_penalizacion'] = $this->Mpenalizaciones->getPenalizaciones();

		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/addPenalizacion' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function addPenalizacion(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_empleado'] = $this->input->post('empleado');
		$data['id_penalizacion'] = $this->input->post('penalizacion');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['fecha_registrado'] = $this->input->post('fecha');
		$dataPenalizacion = $this->Mpenalizaciones->dataPenalizacion($data['id_penalizacion']);
		$data['puntos'] = $dataPenalizacion[0]->puntos;
		$data['id_supervisor'] = $this->session->userdata('usuario')['id_usuario'];
		$data['estado'] = "sin registrar";

		$respuesta = $this->Mpenalizaciones->addPenalizacionEmpleado($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Error, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);
	}

	public function getPenalizaciones(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_empleado = $this->input->post('id_empleado');

		$respuesta = $this->Mpenalizaciones->dataPenalizacionesEmpleado($id_empleado);

		if (!$respuesta) {
			echo json_encode(['status' => false]);
			return;
		}
		echo json_encode([
			'status' => true,
			'data' => $respuesta
		]);
	}

	/// PENALIZACIONES FIN ///

	/// METAS INICIO ///

	public function getMetasOnlyEmpleado(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_usuario = $this->input->post('id_empleado');
		$data['meta'] = $this->Mmetas->getMetasOnlyEmpleado($id_usuario);
		$data['num_horas'] = $this->Mregistrohoras->getNumHoras($id_usuario);
		
		if (empty($data['meta'])) {
			echo json_encode(['status' => false]);
			return;
		}

		$data['num_horas']['por_verificar']->cantidad_horas = $data['num_horas']['por_verificar']->cantidad_horas==null ? 0 : $data['num_horas']['por_verificar']->cantidad_horas;
		if (empty($data['num_horas']['verificados']->cantidad_horas)) {
			$data['num_horas']['verificados']->cantidad_horas = 0;
			$data['total'] = $data['meta']->num_horas;

		}else{
			$subtotal = $data['meta']->num_horas-$data['num_horas']['verificados']->cantidad_horas;
			if ($subtotal < 0) {
				$data['total'] = 0;
			}else{
				$data['total'] = $subtotal;
			}

		}
		echo json_encode(['status' => true, 'data' => $data]);

	}

	/// METAS FIN ///

	public function logout() {
		unset($_SESSION['usuario']);
		redirect('home');
	}








}
