<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mdolar');
		$this->load->model('Mregistronomina');
		$this->load->model('Mpenalizaciones');

	}

	/// VIEWS  INICIO ////

	public function index() {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}

		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/home');
		$this->load->view('includes_admin/footer');
	}


	public function verRegistrosFactura($id_factura){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}

		$data['registro_horas'] = $this->Mregistrohoras->t_h_registro_horas_factura($id_factura);
		$data['id_factura'] = $id_factura;

		if(!$data['registro_horas']) {
			$data['registro_horas'] = 0;
		}
		else {
			$data['registro_horas'] = count($this->Mregistrohoras->t_h_registro_horas_factura($id_factura));
		}

		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/registroshoras' , $data);
		$this->load->view('includes_admin/footer');
	}

	
	public function facturas(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}

		$id_talento_humano = $this->session->userdata('usuario')['id_usuario'];

		$data['factura']     = $this->Mregistronomina->verRegistrosNomina($id_talento_humano);

		if(!$data['factura']) {
			$data['factura'] = 0;
		} 
		else {
			$data['factura'] = count($this->Mregistronomina->verRegistrosNomina($id_talento_humano));
		}

		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/facturas' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function usuarios(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}

		$id_usuario = $this->session->userdata('usuario')['id_usuario'];

		$data['empleados']     = $this->Musuarios->t_h_get_empleados();

		if(!$data['empleados']) {
			$data['empleados'] = 0;
		} 
		else {
			$data['empleados'] = count($this->Musuarios->t_h_get_empleados());
		}

		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/empleados' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function verhoras($id_usuario){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}

		$data['fecha_inicial'] = $this->Mregistronomina->get_fecha_incialNomina($id_usuario);
		$data['registro_horas'] = $this->Mregistrohoras->t_h_get_horas_usuario($id_usuario);
		$data['usuario'] = $id_usuario;

		if(!$data['registro_horas']) {
			$data['registro_horas'] = 0;
		}
		else {
			$data['registro_horas'] = count($this->Mregistrohoras->t_h_get_horas_usuario($id_usuario));
		}

		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/verhoras' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function edithoras($id_registro, $id_modelo){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}
		$inf_registro = $this->Mregistrohoras->dataregistro($id_registro);

		$data['registro_horas']   = $inf_registro;
		$data['id_modelo']   = $id_modelo;
		//$data['categorias']  = $this->Mcategorias->getcategorias();
		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/edithoras' , $data);
		$this->load->view('includes_admin/footer');
	}

	/// VIEWS  INICIO ////


	/// EMPLEADOS INICIO  ///
	public function verempleados(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$usuarios = $this->Musuarios->t_h_ver_empleados();
		

		if(!$usuarios) {
			echo json_encode(['status' => false]);
			return;
		}
		foreach ($usuarios as $key => $value) {
			$data[$key] = $this->Mregistrohoras->t_h_registro_horas_null($value->id_persona);
		}
		

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $usuarios,
				'can_registros'	  => $data
			]);
	}

	
	/// EMPLEADOS FIN  ///

	/// DOLAR INICIO ///
	public function getvalordolar(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$respuesta = $this->Mdolar->getValueDolar();

		if (!$respuesta) {
			$data['status'] = false;
			$data['lista'] = 0;
		}else{
			$data['status'] = true;
			$data['lista'] = $respuesta;
		}
		echo json_encode($data);
	}

	public function registrodolar(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['valor_dolar'] = $this->input->post('valor_dolar');
		$data['estado'] = "activo";
		$respuesta = $this->Mdolar->registrarDolar($data);

		if (!$respuesta) {
			echo json_encode(['status' => false, 'msn' => 'Error al ingresar']);
			return;
		}
		echo json_encode(['status' => true]);

	}
	/// DOLAR FIN  ///

	/// FACTURA INICIO ///

	public function getfacturas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial    = ($this->input->post('fecha_inicio')=="")?"":$this->input->post('fecha_inicio')." 00:00:00";    
		$fecha_final 	  = ($this->input->post('fecha_final')=="")?"":$this->input->post('fecha_final')." 23:59:59";
		$id_usuario 	  = $this->session->userdata('usuario')['id_usuario'];
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$usuarios         = $this->Mregistronomina->getFacturas($valor , $id_usuario, $fecha_inicial, $fecha_final, $inicio, $cantidad);
		$total_registros  = count($this->Mregistronomina->getFacturas($valor, $id_usuario, $fecha_inicial, $fecha_final)); 

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

	public function getRegistrosFactura(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial    = $this->input->post('fecha_inicio');    
		$fecha_final 	  = $this->input->post('fecha_final');
		$id_factura 	  = $this->input->post('id_factura');
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$usuarios         = $this->Mregistronomina->getRegistrosFacturas($valor , $id_factura, $fecha_inicial, $fecha_final, $inicio, $cantidad);
		$total_registros  = count($this->Mregistronomina->getRegistrosFacturas($valor, $id_factura, $fecha_inicial, $fecha_final)); 

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
	

	/// FACTURA FIN ///

	/// PENALIZACIONES INICIO ///

	public function verPenalizaciones($id_usuario){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}
		$data['penalizaciones'] = $this->Mpenalizaciones->dataPenalizacionesEmpleado($id_usuario); 

		if(!$data['penalizaciones']) {
			$data['penalizaciones'] = 0;
		}
		else {
			$data['penalizaciones'] = count($this->Mpenalizaciones->dataPenalizacionesEmpleado($id_usuario));
		}
		$data['id_usuario'] = $id_usuario;

		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/verPenalizaciones' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function getPenalizaciones(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_usuario 	  = $this->input->post('id_usuario');
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$penalizaciones   = $this->Mpenalizaciones->getPenalizacionesUsuario($valor , $id_usuario, $inicio, $cantidad);
		$total_registros  = count($this->Mpenalizaciones->getPenalizacionesUsuario($valor, $id_usuario)); 

		if(!$penalizaciones) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $penalizaciones,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);
	}

	public function editPenalizacion($id_penalizacion, $id_modelo){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='talento humano') {
			redirect('Home');
		}
		$data['id_modelo']   = $id_modelo;
		$data['penalizaciones'] = $this->Mpenalizaciones->getPenalizaciones();
		$data['penalizacion'] = $this->Mpenalizaciones->getDataPenalizacion($id_penalizacion); 

		$this->load->view('includes_admin/header');
		$this->load->view('talento_humano/editPenalizacion' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function storePenalizacion(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_penalizacion'] = $this->input->post('id_penalizacon');
		$data['id_empleado_penalizacion'] = $this->input->post('id_relacion');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['fecha_registrado'] = $this->input->post('fecha');

		$respuesta = $this->Mpenalizaciones->storePenalizacion($data);

		if(!$respuesta) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(['status' => true]);
	}

	/// PENALIZACIONES FIN ///


	public function logout() {
		unset($_SESSION['usuario']);
		redirect('home');
	}
}
