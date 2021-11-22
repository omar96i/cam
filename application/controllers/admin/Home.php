<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistronomina');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Madelantos');
		$this->load->model('MporcentajeDias');
		$this->load->model('MporcentajeMetas');
		$this->load->model('Mmetas');
		$this->load->model('MsalarioEmpleados');
		$this->load->model('MfacturasSupervisor');
		$this->load->model('MfacturaGeneral');
		$this->load->model('Masistencia');

	}

	public function index() {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['user'] = $this->Musuarios->getUser($this->session->userdata('usuario')['id_usuario']);

		$this->load->view('includes_admin/header');
		$this->load->view('admin/home', $data);
		$this->load->view('includes_admin/footer');
	}

	public function nomina($fecha_inicial = "", $fecha_final = ""){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['factura']     = $this->Mregistronomina->verRegistrosAdmin();

			if(!$data['factura']) {
				$data['factura'] = 0;
			} 
			else {
				$data['factura'] = count($this->Mregistronomina->verRegistrosAdmin());
			}
			$data['fecha_inicial'] = $fecha_inicial;
			$data['fecha_final'] = $fecha_final;

			$this->load->view('includes_admin/header');
			$this->load->view('admin/factura' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	/// ASIGNACIONES SUPERVISOR INICIO ///

	public function asignaciones(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['supervisores']     = $this->Masignaciones->getrelaciones();

		if(!$data['supervisores']) {
			$data['supervisores'] = 0;
		} 
		else {
			$data['supervisores'] = count($this->Masignaciones->getrelaciones());
		}

		$this->load->view('includes_admin/header');
		$this->load->view('admin/asignaciones' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function verasignacionsupervisor($id_persona){

		$data['supervisor'] = $this->Masignaciones->obtenersupervisor($id_persona);

		if(!$data['supervisor']) {
			$data['supervisor'] = 0;
		}else{
			$data['usuarios'] = $this->Masignaciones->getusuarios($id_persona);
			if (!$data['usuarios']) {
				$data['usuarios'] = 0;
			}
		}

		

		$this->load->view('includes_admin/header');
		$this->load->view('admin/infasignadosupervisor' , $data);
		$this->load->view('includes_admin/footer');

	}

	public function versupervisores(){

		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

	
		$usuarios         = $this->Masignaciones->getsupervisor();

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

	public function asignarsupervisor(){

		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['lista_supervisor'] = $this->Masignaciones->getrelaciones();
		$data['lista_empleado'] = $this->Masignaciones->getempleados();

		$this->load->view('includes_admin/header');
		$this->load->view('admin/addasignarsupervisor', $data);
		$this->load->view('includes_admin/footer');

	}


	public function addasignacionsupervisor(){

		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}


		$data['id_supervisor'] = $this->input->post('supervisor');
		$data['id_empleado'] = $this->input->post('empleado');
		$data['estado'] = "activo";


		$respuesta = $this->Masignaciones->addasignacion($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
			return;
		}

		if($this->ActualizarMetas()){
			echo json_encode(['status' => true]);
			return;
		}

		echo json_encode(['status' => false, 'msg' => 'No se pudo Actualizar metas']);
		
	}

	public function verusuariosasignados(){

		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id_supervisor    = $this->input->post('id_supervisor');
		$usuarios         = $this->Masignaciones->getasignacionsupervisor($id_supervisor);

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

	public function delete_empleado(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_persona'] = $this->input->post('id_persona');
		$data['id_supervisor'] = $this->input->post('id_supervisor');

		$respuesta = $this->Masignaciones->delete_empleado($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
			return;
		}

		
		if($this->ActualizarMetas()){
			echo json_encode(['status' => true]);
			return;
		}
		echo json_encode(['status' => false, 'msg' => 'No se pudo actualizar las metas del supervisor']);
		
	}

	/// ASIGNACIONES SUPERVISOR FIN ///

	/// PAGINAS INICIO //////

	public function paginas(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['paginas']     = $this->Mpaginas->getpaginas();

		if(!$data['paginas']) {
			$data['paginas'] = 0;
		} 
		else {
			$data['paginas'] = count($this->Mpaginas->getpaginas());
		}

		$this->load->view('includes_admin/header');
		$this->load->view('admin/paginas' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function verpaginas() {
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$paginas         = $this->Mpaginas->getpages(); 

		if(!$paginas) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $paginas
		]);
	}

	public function addpaginas(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$this->load->view('includes_admin/header');
		$this->load->view('admin/addpaginas');
		$this->load->view('includes_admin/footer');
	}

	public function addpage(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['url_pagina'] = $this->input->post('url_pagina');
		$data['estado'] = "activo";
		$respuesta = $this->Mpaginas->registrarpagina($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
			return;
		}

		echo json_encode(['status' => true]);
	}

	public function editarpaginas($id_pagina) {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$inf_pagina = $this->Mpaginas->datapaginas($id_pagina);

		

		if(!$inf_pagina) {
			$this->load->view('404error');
			die;
		}
		$data['paginas']   = $inf_pagina;
		//$data['categorias']  = $this->Mcategorias->getcategorias();
		$this->load->view('includes_admin/header');
		$this->load->view('admin/storepaginas' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function storepaginas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}
		$data['url_pagina'] = $this->input->post('url_pagina');
		$data['estado'] = $this->input->post('estado');
		$id_pagina = $this->input->post('id_pagina');

		$respuesta = $this->Mpaginas->updatepaginas($data, $id_pagina);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, no se pudo editar']);
			return;
		}

		echo json_encode(['status' => true]);	

	}

	public function asignarpaginas(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['lista_usuarios'] = $this->Musuarios->getusuarioempleado();
		$data['lista_paginas'] = $this->Mpaginas->getpaginasactivas();

		$this->load->view('includes_admin/header');
		$this->load->view('admin/addasignacion', $data);
		$this->load->view('includes_admin/footer');

	}

	public function addasignacion(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['id_pagina'] = $this->input->post('paginas');
		$data['id_persona'] = $this->input->post('usuario');
		$data['correo'] = $this->input->post('correo');
		$data['clave'] = $this->input->post('clave');
		$data['estado'] = "activo";


		$respuesta = $this->Mpaginas->asignarpage($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, no se pudo Registrar']);
			return;
		}

		echo json_encode(['status' => true]);


	}

	public function editarasignaciones($id_relacion){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$respuesta = $this->Mpaginas->getDataEditPages($id_relacion);

		if(!$respuesta){
			$data['lista'] = 0;
		}else{
			$data['lista'] = $respuesta;
			$data['id_relacion'] = $id_relacion;
		}

		$this->load->view('includes_admin/header');
		$this->load->view('admin/editasignacionpaginas' , $data);
		$this->load->view('includes_admin/footer');


	}

	public function infasignados($id_pagina){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['asignaciones'] = $this->Mpaginas->asignaciones($id_pagina);

		if(!$data['asignaciones']) {
			$data['asignaciones'] = 0;
		} 
		else {
			$data['id_relacion'] = $this->Mpaginas->asignaciones($id_pagina);
			$data['asignaciones'] = count($this->Mpaginas->asignaciones($id_pagina));
		}

		$this->load->view('includes_admin/header');
		$this->load->view('admin/infasignados' , $data);
		$this->load->view('includes_admin/footer');

	}

	public function verasignaciones(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id_pagina        = $this->input->post('id_pagina');
		$paginas         = $this->Mpaginas->getasignaciones($id_pagina);

		if(!$paginas) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $paginas
		]);
	}

	public function editasignacionpages(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['correo'] = $this->input->post('usuario');
		$data['clave'] = $this->input->post('clave');
		$id_relacion = $this->input->post('id_relacion');
		$respuesta = $this->Mpaginas->editPagesAsignados($data, $id_relacion);
		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, no se pudo editar']);
		}

		echo json_encode(['status' => true]);
	}

	public function delete_relacion_pages(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id = $this->input->post('id_relacion');

		$respuesta = $this->Mpaginas->delete_relacion_pages($id);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, no se pudo editar']);
		}

		echo json_encode(['status' => true]);
	}

	public function verificarasignacion(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id = $this->input->post('id');

		$respuesta = $this->Mpaginas->verificarAsignacion($id);

		if(!$respuesta) {
			echo json_encode(['status' => false]);
			return;
		}

		$data['status'] = true;
		$data['lista'] = $respuesta;

		echo json_encode($data);


	}

	public function getpagesusuario(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id = $this->input->post('id_usuario');

		$respuesta = $this->Mpaginas->getPagesUsuario($id);

		if(!$respuesta) {
			echo json_encode(['status' => false]);
			return;
		}

		$data['status'] = true;
		$data['lista'] = $respuesta;

		echo json_encode($data);


	}
	/// PAGINAS FIN ////////


	/// USUARIOS INICIO /// 

	public function usuarios($tittle = "activo") {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['usuarios']     = $this->Musuarios->getusuarios();

		if(!$data['usuarios']) {
			$data['usuarios'] = 0;
		} 
		else {
			$data['usuarios'] = count($this->Musuarios->getusuarios());
		}
		$data['tittle'] = $tittle;

		$this->load->view('includes_admin/header');
		$this->load->view('admin/usuarios', $data);
		$this->load->view('includes_admin/footer');
	}

	public function addusuario(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$this->load->view('includes_admin/header');
		$this->load->view('admin/addusuario');
		$this->load->view('includes_admin/footer');
	}

	public function detele_personal(){

		$id_persona = $this->input->post('id_persona');
		$respuesta = $this->Musuarios->delete_usuario($id_persona);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return;
		}

		echo json_encode(['status' => true]);

	}
	public function actualizarDatosUsuario(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['fecha_entrada'] = $this->input->post('fecha_ingreso');
		$data['id_persona'] = $this->input->post('id_persona');

		if($this->input->post('tipo_cuenta') == "supervisor" || $this->input->post('tipo_cuenta') == "tecnico sistemas" || $this->input->post('tipo_cuenta') == "empleado"){
			$data['sueldo_aux'] = $this->input->post('salario_aux');
		}else{
			$sueldo = $this->MsalarioEmpleados->getSalarioTipoCuenta($this->input->post('tipo_cuenta'));
			$data['sueldo_aux'] = $sueldo[0]->sueldo;
		}
		$response = $this->Musuarios->updatePersona($data);
		if(!$response){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return;
		}
		echo json_encode(['status' => true]);

	}

	public function viewusuarios() {
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$tittle           = $this->input->post('tittle');
		$usuarios         = $this->Musuarios->getusuary($tittle);

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

	public function editarusuarios($id_usuario, $tittle = "activo") {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$info_usuario = $this->Musuarios->datausuarios($id_usuario);

		

		if(!$info_usuario) {
			$this->load->view('404error');
			die;
		}
		$data['usuarios']   = $info_usuario;
		$data['tittle'] = $tittle;
		//$data['categorias']  = $this->Mcategorias->getcategorias();
		$this->load->view('includes_admin/header');
		$this->load->view('admin/storeusuary' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function addnewusuario() {
	 	if(!$this->input->is_ajax_request()){
	 		echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
	 		return; 
	 	}

	 	$data['documento'] = $this->input->post('cedula');
	 	$data['nombres'] = $this->input->post('nombres');
	 	$data['apellidos'] = $this->input->post('apellidos');
	 	$data['fecha_entrada'] = $this->input->post('fecha_entrada');
	 	$data['ciudad'] = $this->input->post('ciudad');
	 	$data['direccion'] = $this->input->post('direccion');
	 	$data['correo_personal'] = $this->input->post('correo_personal');
	 	$data['sexo'] = $this->input->post('sexo');
	 	$data['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
	 	$data['telefono'] = $this->input->post('telefono');
	 	$data['observaciones'] = $this->input->post('observaciones');
	 	$data['numero_cuenta_banco'] = $this->input->post('num_cuenta_banco');
	 	$data['tipo_cuenta_banco'] = $this->input->post('tipo_cuenta_banco');
	 	$data['nombre_banco'] = $this->input->post('name_banco');
	 	$data2['tipo_cuenta'] = $this->input->post('tipo_cuenta');
	 	$data2['correo'] = $this->input->post('correo');
	 	$data2['clave'] = $this->input->post('clave');

		$response = $this->Musuarios->verificarUsuario($data2['correo']);
		if($response){
			echo json_encode(['status' => false, 'msg' => 'El correo ya se encuentra registrado']);
	 		return;
		}
		$response = $this->Musuarios->verificarPersona($data['documento']);
		if($response){
			echo json_encode(['status' => false, 'msg' => 'El documento ya se encuentra registrado']);
	 		return;
		}

	 	/////  FOTO UPLOAD  /////
		$config['upload_path']          = './assets/images/imagenes_usuario/';
        $config['allowed_types']        = 'jpg|png';
        $config['file_name']			= $data['documento'];
        $config['overwrite']			= true;
		$this->load->library('upload' , $config);
	 	if($this->upload->do_upload('imagen')) {
	 		$data_image = ['upload_data' => $this->upload->data()];

	 		$data['foto'] = $data_image['upload_data']['file_name'];
	 	}else{
			echo json_encode(['status' => false, 'msg' => 'Error al subir la imagen']);
			return;
		}

	 	////// FOTO UPLOAD //////

		$registro_usuarios = $this->Musuarios->registrarusuarios($data, $data2);
		$this->output->delete_cache();


	 	if(!$registro_usuarios) {
	 		echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
	 		return;
	 	}
	 	echo json_encode(['status' => true]);
	} 

	public function addpersonal() {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['categorias'] = $this->Mcategorias->getcategorias();
		$this->load->view('includes_admin/header');
		$this->load->view('admin/addpersonal' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function getfacturas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		
		$data['fecha_inicio'] = $this->input->post('fecha_inicio');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$usuarios  = $this->Mregistronomina->getFacturasAdmin($data);

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

	public function verRegistrosFactura($id_registro){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['registro_horas'] = $this->Mregistrohoras->t_h_registro_horas_factura($id_registro);
			$data['id_factura'] = $id_registro;

			if(!$data['registro_horas']) {
				$data['registro_horas'] = 0;
			}
			else {
				$data['registro_horas'] = count($this->Mregistrohoras->t_h_registro_horas_factura($id_registro));
			}

			$this->load->view('includes_admin/header');
			$this->load->view('admin/registrohoras' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function getDatosRegistros(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$id = $this->input->post('id');
			$respuesta = $this->Mregistrohoras->getDatosRegistros($id);
			if(!$respuesta) {
				echo json_encode(['status' => false]);
				return;
			}
			echo json_encode(
				[
					'status'          => true, 
					'data'            => $respuesta
				]);
		}else{
			redirect('Home');
		}
		
	}

	public function updateDatosRegistros(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['cantidad_horas'] = $this->input->post('cantidad_horas');
		$data['descuento'] = $this->input->post('descuento');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['fecha_registro'] = $this->input->post('fecha_registro');
		$data2['id_registro_horas'] = $this->input->post('id_registro');
		$id_factura = $this->input->post('id_factura');
		
		$respuesta = $this->Mregistrohoras->updateRegistroHoras($data,$data2,$id_factura);

		if(!$respuesta) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(['status' => true]);
	}

	public function storeUsuario(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['id_persona'] = $this->input->post('id_persona_u');
		$data['documento'] = $this->input->post('documento_u');
		$data['nombres'] = $this->input->post('nombre_u');
		$data['fecha_entrada'] = $this->input->post('fecha_entrada');
		$data['apellidos'] = $this->input->post('apellidos_u');
		$data['ciudad'] = $this->input->post('ciudad_u');
		$data['direccion'] = $this->input->post('direccion_u');
		$data['correo_personal'] = $this->input->post('correo_personal_u');
		$data['sexo'] = $this->input->post('sexo_u');
		$data['fecha_nacimiento'] = $this->input->post('fecha_u');
		$data['telefono'] = $this->input->post('telefono_u');
		$data['observaciones'] = $this->input->post('observaciones_u');
		$data['numero_cuenta_banco'] = $this->input->post('num_cuenta_banco_u');
		$data['tipo_cuenta_banco'] = $this->input->post('tipo_cuenta_banco_u');
		$data['nombre_banco'] = $this->input->post('name_banco_u');

		$data2['correo'] = $this->input->post('correo_u');
		$data2['clave'] = $this->input->post('clave_u');
		$data2['tipo_cuenta'] = $this->input->post('cuenta_tipo_u');
		if(isset($_POST['estado'])){
			$data2['estado'] = $this->input->post('estado');
		}
		/////  FOTO UPLOAD  /////
		$config['upload_path']          = './assets/images/imagenes_usuario/';
        $config['allowed_types']        = 'jpg|png';
        $config['file_name']			= $data['documento'];
        $config['overwrite']			= true;
		$this->load->library('upload' , $config);
	 	if($this->upload->do_upload('imagen')) {
	 		$data_image = ['upload_data' => $this->upload->data()];

	 		$data['foto'] = $data_image['upload_data']['file_name'];
	 	}

	 	////// FOTO UPLOAD //////
		$this->output->delete_cache();
		$update_usuarios     = $this->Musuarios->updateusuarios($data, $data2);
		if(!$update_usuarios) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, no se pudo editar']);
		}

		echo json_encode(['status' => true]);	

	}

	/// USUARIOS FIN ///

	/// EMPLEADOS INICIO ///

	public function empleados($tittle = "activo") {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['usuarios']     = $this->Musuarios->getempleados();

		if(!$data['usuarios']) {
			$data['usuarios'] = 0;
		} 
		else {
			$data['usuarios'] = count($this->Musuarios->getempleados());
		}

		$data['tittle'] = $tittle;

		$this->load->view('includes_admin/header');
		$this->load->view('admin/empleados' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function addempleados(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}
		$this->load->view('includes_admin/header');
		$this->load->view('admin/addempleados');
		$this->load->view('includes_admin/footer');
	}

	public function viewempleados() {
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$tittle           = $this->input->post('tittle');
		$usuarios         = $this->Musuarios->get_empleados_users($tittle);
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

	public function addnewempleado() {
	 	if(!$this->input->is_ajax_request()){
	 		echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
	 		return; 
	 	}

	 	$data['documento'] = $this->input->post('cedula');
	 	$data['nombres'] = $this->input->post('nombres');
	 	$data['apellidos'] = $this->input->post('apellidos');
	 	$data['ciudad'] = $this->input->post('ciudad');
	 	$data['direccion'] = $this->input->post('direccion');
	 	$data['fecha_entrada'] = $this->input->post('fecha_entrada');
	 	$data['correo_personal'] = $this->input->post('correo_personal');
	 	$data['sexo'] = $this->input->post('sexo');
	 	$data['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
	 	$data['telefono'] = $this->input->post('telefono');
	 	$data['observaciones'] = $this->input->post('observaciones');
	 	$data['numero_cuenta_banco'] = $this->input->post('num_cuenta_banco');
	 	$data['tipo_cuenta_banco'] = $this->input->post('tipo_cuenta_banco');
	 	$data['nombre_banco'] = $this->input->post('name_banco');
	 	$data2['tipo_cuenta'] = 'empleado';
	 	$data2['correo'] = $this->input->post('correo');
	 	$data2['clave'] = $this->input->post('clave');
		
		$response = $this->Musuarios->verificarUsuario($data2['correo']);
		if($response){
			echo json_encode(['status' => false, 'msg' => 'El correo ya se encuentra registrado']);
	 		return;
		}
		$response = $this->Musuarios->verificarPersona($data['documento']);
		if($response){
			echo json_encode(['status' => false, 'msg' => 'El documento ya se encuentra registrado']);
	 		return;
		}

	 	
		/////  FOTO UPLOAD  /////
		$config['upload_path']          = './assets/images/imagenes_empleado/';
        $config['allowed_types']        = 'jpg|png';
        $config['file_name']			= $data['documento'];
        $config['overwrite']			= true;
		$this->load->library('upload' , $config);
	 	if($this->upload->do_upload('imagen')) {
	 		$data_image = ['upload_data' => $this->upload->data()];
	 		$data['foto'] = $data_image['upload_data']['file_name'];
	 	}else{
			echo json_encode(['status' => false, 'msg' => 'Error al subir la imagen']);
			return;
		}

		 ////// FOTO UPLOAD //////

		$registro_usuarios = $this->Musuarios->registrarusuarios($data, $data2);
		$this->output->delete_cache();

	 	if(!$registro_usuarios) {
	 		echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
	 		return;
	 	}
	 	echo json_encode(['status' => true]);
	} 

	public function editarempleados($id_usuario, $tittle) {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$info_usuario = $this->Musuarios->datausuarios($id_usuario);

		

		if(!$info_usuario) {
			$this->load->view('404error');
			die;
		}
		$data['usuarios']   = $info_usuario;
		$data['tittle'] = $tittle;
		//$data['categorias']  = $this->Mcategorias->getcategorias();
		$this->load->view('includes_admin/header');
		$this->load->view('admin/storeEmpleados' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function storeempleado(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['id_persona'] = $this->input->post('id_persona_u');
		$data['documento'] = $this->input->post('documento_u');
		$data['nombres'] = $this->input->post('nombre_u');
		$data['apellidos'] = $this->input->post('apellidos_u');
		$data['ciudad'] = $this->input->post('ciudad_u');
		$data['fecha_entrada'] = $this->input->post('fecha_entrada');
		$data['direccion'] = $this->input->post('direccion_u');
		$data['correo_personal'] = $this->input->post('correo_personal_u');
		$data['sexo'] = $this->input->post('sexo_u');
		$data['fecha_nacimiento'] = $this->input->post('fecha_u');
		$data['telefono'] = $this->input->post('telefono_u');
		$data['observaciones'] = $this->input->post('observaciones_u');
		$data['numero_cuenta_banco'] = $this->input->post('num_cuenta_banco_u');
		$data['tipo_cuenta_banco'] = $this->input->post('tipo_cuenta_banco_u');
		$data['nombre_banco'] = $this->input->post('name_banco_u');

		$data2['correo'] = $this->input->post('correo_u');
		$data2['clave'] = $this->input->post('clave_u');
		$data2['tipo_cuenta'] = $this->input->post('cuenta_tipo_u');
		if(isset($_POST['estado'])){
			$data2['estado'] = $this->input->post('estado');
		}
		/////  FOTO UPLOAD  /////
		$config['upload_path']          = './assets/images/imagenes_empleado/';
        $config['allowed_types']        = 'jpg|png';
        $config['file_name']			= $data['documento'];
        $config['overwrite']			= true;
		$this->load->library('upload' , $config);
	 	if($this->upload->do_upload('imagen')) {
	 		$data_image = ['upload_data' => $this->upload->data()];
	 		$data['foto'] = $data_image['upload_data']['file_name'];
	 	}

		 ////// FOTO UPLOAD //////
		$this->output->delete_cache();

		
		$update_usuarios = $this->Musuarios->updateusuarios($data, $data2);
		if(!$update_usuarios) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, no se pudo editar']);
		}

		echo json_encode(['status' => true]);	

	}

	public function viewHorasEmpleados(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$id_empleado = $this->input->post('id_usuario');

		$respuesta = $this->Mregistrohoras->getHorasUsuariosAdmin($id_empleado);

		echo json_encode($respuesta);
	}
	/// EMPLEADOS FIN ///

	/// PENALIZACIONES INICIO ///

	public function penalizaciones(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			
			$this->load->view('includes_admin/header');
			$this->load->view('admin/penalizaciones');
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}

		
	}

	public function addpenalizaciones(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$this->load->view('includes_admin/header');
			$this->load->view('admin/addpenalizacion');
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
		
	}

	public function verpenalizaciones(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$penalizaciones         = $this->Mpenalizaciones->get_penalizaciones();

		if(!$penalizaciones) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $penalizaciones
		]);
	}

	public function agregarAsignacion(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['nombre_penalizacion'] = $this->input->post('nombre_p');
		$data['puntos'] = $this->input->post('puntos');
		$data['estado'] = "activo";
		$insert_penalizacion = $this->Mpenalizaciones->addPenalizacion($data);

		if(!$insert_penalizacion) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);	

	}

	public function editarPenalizaciones($id_penalizacion){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['penalizaciones'] = $this->Mpenalizaciones->dataPenalizacion($id_penalizacion);
			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarPenalizaciones' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function storePenalizacion(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['nombre_penalizacion'] = $this->input->post('nombre_p');
		$data['puntos'] = $this->input->post('puntos');
		$data['id_penalizacion'] = $this->input->post('id_penalizacion');
		$update_penalizacion = $this->Mpenalizaciones->updatePenalizacion($data);

		if(!$update_penalizacion) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Update']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function deletePenalizacion(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$id_penalizacion = $this->input->post('id_penalizacion');

		$respuesta = $this->Mpenalizaciones->deletePenalizacion($id_penalizacion);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Delete']);
			return;
		}

		echo json_encode(['status' => true]);	

	}
	/// PENALIZACIONES FIN /// 

	/// ASISTENCIAS INICIO ///

	public function asistencias(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {

			$this->load->view('includes_admin/header');
			$this->load->view('admin/asistencias' );
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function verasistencias(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		
		$asistencias         = $this->Masistencia->get_motivoAsistencias();

		if(empty($asistencias)) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode([
			'status'          => true, 
			'data'            => $asistencias
		]);
	}	

	public function addasistencia(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$this->load->view('includes_admin/header');
			$this->load->view('admin/addAsistencia');
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}	
	}

	public function agregarAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['nombre'] = $this->input->post('nombre_a');
		$data['descuenta'] = $this->input->post('descuenta');
		$data['estado'] = "activo";

		if(!$this->Masistencia->add_motivoAsistencia($data)) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function editarAsistencia($id_asistencia){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['asistencia'] = $this->Masistencia->data_motivoAsistencia($id_asistencia);

		$this->load->view('includes_admin/header');
		$this->load->view('admin/editarAsistencia' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function storeAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['nombre'] = $this->input->post('nombre_a');
		$data['id_motivo'] = $this->input->post('id_motivo');
		$data['descuenta'] = $this->input->post('descuenta');

		if(!$this->Masistencia->update_motivoAsistencia($data)) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Update']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function deleteAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$id_asistencia = $this->input->post('id_asistencia');
		if(!$this->Masistencia->delete_motivoAsistencia($id_asistencia)) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, intentelo más tarde.']);
			return;
		}

		echo json_encode(['status' => true]);	
	}
	/// ASITENCIAS FIN

	/// ADELANTOS INICIO ///

	public function adelantos($tittle = "general"){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {

			$data['tittle'] = $tittle;

			$this->load->view('includes_admin/header');
			$this->load->view('admin/adelantos' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function addAdelanto(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['personas'] = $this->Musuarios->getUsuariosAdelantos();

			$this->load->view('includes_admin/header');
			$this->load->view('admin/addAdelanto', $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function agregarAdelanto(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['id_empleado'] = $this->input->post('usuario');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['valor'] = $this->input->post('valor');
		$data['valor_aux'] = $this->input->post('valor');
		$data['cuota'] = $this->input->post('cuota');
		$data['cuota_aux'] = $this->input->post('cuota');
		$data['estado'] = "sin registrar";

		$insert_adelanto = $this->Madelantos->addAdelanto($data);

		if(!$insert_adelanto) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function veradelantos(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$adelantos         = $this->Madelantos->get_adelantos();

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

	public function veradelantosSinVerificar(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$adelantos         = $this->Madelantos->get_adelantos_sin_verificar();

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

	public function editaradelantos($id_adelanto, $tittle = "general"){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['adelantos'] = $this->Madelantos->dataAdelantos($id_adelanto);
			$data['personas'] = $this->Musuarios->getUsuariosAdelantos();
			$data['tittle'] = $tittle;

			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarAdelantos' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function verificarAdelantos(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['id_adelanto'] = $this->input->post('id_adelanto');
		$data['id_empleado'] = $this->input->post('usuario');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['valor'] = $this->input->post('valor');
		$data['valor_aux'] = $this->input->post('valor');
		$data['cuota'] = $this->input->post('cuota');
		$data['cuota_aux'] = $this->input->post('cuota');
		$data['estado'] = "sin registrar";
		$update_adelanto = $this->Madelantos->updateAdelanto($data);

		if(!$update_adelanto) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Update']);
			return;
		}

		echo json_encode(['status' => true]);
	}

	public function cancelarAdelanto(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['id_adelanto'] = $this->input->post('id_adelanto');
		$data['id_empleado'] = $this->input->post('usuario');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['valor'] = $this->input->post('valor');
		$data['estado'] = "cancelado";
		$update_adelanto = $this->Madelantos->updateAdelanto($data);


		if(!$update_adelanto) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Update']);
			return;
		}

		echo json_encode(['status' => true]);
	}

	public function storeAdelantos(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['id_adelanto'] = $this->input->post('id_adelanto');
		$data['id_empleado'] = $this->input->post('usuario');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['valor'] = $this->input->post('valor');
		$data['valor_aux'] = $this->input->post('valor');
		$data['cuota'] = $this->input->post('cuota');
		$data['cuota_aux'] = $this->input->post('cuota');

		$update_adelanto = $this->Madelantos->updateAdelanto($data);

		if(!$update_adelanto) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Update']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	/// ADELANTOS FIN ///

	/// PORCENTAJES INICIO ///
		/// DIAS INICIO ///
	public function diasPorcentajes($tipo = "general"){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			if($tipo == "general"){
				$data['porcentajes'] = $this->MporcentajeDias->getPorcentajes();
				if(!$data['porcentajes']) {
					$data['porcentajes'] = 0;
				} 
				else {
					$data['porcentajes'] = count($this->MporcentajeDias->getPorcentajes());
				}
				$data['tittle'] = "General";
				$this->load->view('includes_admin/header');
				$this->load->view('admin/porcentajeDias' , $data);
				$this->load->view('includes_admin/footer');
			}else{
				$data['porcentajes'] = $this->MporcentajeDias->getPorcentajesBonga();
				if(!$data['porcentajes']) {
					$data['porcentajes'] = 0;
				} 
				else {
					$data['porcentajes'] = count($this->MporcentajeDias->getPorcentajesBonga());
				}
				$data['tittle'] = "Bongacams";
				$this->load->view('includes_admin/header');
				$this->load->view('admin/porcentajeDias' , $data);
				$this->load->view('includes_admin/footer');
			}	
		}else{
			redirect('Home');
		}
	}
	public function verPorcentajeDias(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$porcentaje       = $this->MporcentajeDias->get_porcentaje();

		if(!$porcentaje) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $porcentaje
		]);
	}

	public function verPorcentajeDiasBomga(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$porcentaje       = $this->MporcentajeDias->get_porcentaje_bonga();

		if(!$porcentaje) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $porcentaje
		]);
	}


	public function addPorcentajesDias(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$this->load->view('includes_admin/header');
			$this->load->view('admin/addPorcentajesDias');
			$this->load->view('includes_admin/footer');
 		}else{
			redirect('Home');
		}
		
	}
	public function agregarPorcentajeDias(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['cantidad_dias'] = $this->input->post('dias');
		$data['valor'] = $this->input->post('valor');
		$data['estado_meta'] = $this->input->post('estado_meta');
		$data['valor_multiplicar'] = $this->input->post('valor_multiplicar');
		$data['tipo'] = $this->input->post('tipo');
		$data['estado'] = "activo";

		$insert_porcentaje_dias = $this->MporcentajeDias->addPorcentajeDias($data);

		if(!$insert_porcentaje_dias) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function editarPorcentajesDias($id_porcentaje){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['porcentaje'] = $this->MporcentajeDias->dataPorcentajes($id_porcentaje);

			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarPorcentajeDias' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function storePorcentajeDias(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['cantidad_dias'] = $this->input->post('dias');
		$data['valor'] = $this->input->post('valor');
		$data['estado'] = $this->input->post('estado');
		$data['estado_meta'] = $this->input->post('estado_meta');
		$data['valor_multiplicar'] = $this->input->post('valor_multiplicar');
		$data['tipo'] = $this->input->post('tipo');

		$data['id_porcentajes_dias'] = $this->input->post('id_porcentajes');

		$updatePorcentajeDias = $this->MporcentajeDias->updatePorcentajesDias($data);

		if(!$updatePorcentajeDias) {
			echo json_encode(['status' => false, 'msg' => 'Los datos ingresados ya existen en otro registro']);
			return;
		}

		echo json_encode(['status' => true]);	

	}

	/// DIAS FIN ///

	// METAS INICIO //
	public function metasPorcentajes(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['porcentajes'] = $this->MporcentajeMetas->getPorcentajes();

			if(!$data['porcentajes']) {
				$data['porcentajes'] = 0;
			} 
			else {
				$data['porcentajes'] = count($this->MporcentajeMetas->getPorcentajes());
			}

			$this->load->view('includes_admin/header');
			$this->load->view('admin/porcentajeMetas' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}

		
	}

	public function addPorcentajesMetas(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$this->load->view('includes_admin/header');
			$this->load->view('admin/addPorcentajesMetas');
			$this->load->view('includes_admin/footer');
 		}else{
			redirect('Home');
		}
		
	}

	public function agregarPorcentajeMetas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['valor'] = $this->input->post('valor');
		$data['estado'] = "activo";

		$insert_porcentaje_metas = $this->MporcentajeMetas->addPorcentajeMetas($data);

		if(!$insert_porcentaje_metas) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function verPorcentajeMetas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$porcentaje         = $this->MporcentajeMetas->get_porcentaje($valor , $inicio , $cantidad);
		$total_registros  = count($this->MporcentajeMetas->get_porcentaje($valor)); 

		if(!$porcentaje) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
		[
			'status'          => true, 
			'data'            => $porcentaje,
			'cantidad'        => $cantidad,
			'total_registros' => $total_registros
		]);
	}
	public function editarPorcentajesMetas($id_porcentaje){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['porcentaje'] = $this->MporcentajeMetas->dataPorcentajes($id_porcentaje);

			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarPorcentajeMetas' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}

		
	}

	public function storePorcentajeMetas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó!']);
			return; 
		}

		$data['valor'] = $this->input->post('valor');
		$data['estado'] = $this->input->post('estado');
		$data['id_porcentaje_metas'] = $this->input->post('id_porcentajes');

		$updatePorcentajeMetas = $this->MporcentajeMetas->updatePorcentajesMetas($data);

		if(!$updatePorcentajeMetas) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Update']);
			return;
		}

		echo json_encode(['status' => true]);
	}
		// METAS FIN //
	/// PORCENTAJES FIN  ////

	/// METAS INICIO ///
	public function metasSupervisor($tittle = "general"){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano' || $this->session->userdata('usuario')['tipo']=='tecnico sistemas') {
			
			$data['tittle'] = $tittle;
			$this->load->view('includes_admin/header');
			$this->load->view('admin/metasSupervisor' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}

		
	}
	public function metas($tittle = "general"){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano' || $this->session->userdata('usuario')['tipo']=='tecnico sistemas') {

			$data['tipo_cuenta'] = $this->session->userdata('usuario')['tipo'];
			$data['tittle'] = $tittle;

			$this->load->view('includes_admin/header');
			$this->load->view('admin/metas' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function addMetas(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['empleados'] = $this->Musuarios->getempleadosMetas(); 
			$this->load->view('includes_admin/header');
			$this->load->view('admin/addMetasUsuario', $data);
			$this->load->view('includes_admin/footer');
			
 		}else{
			redirect('Home');
		}
	}

	public function consultarEmpleadoMetasNull(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_empleado = $this->input->post('id_usuario');

		$bandera = $this->Mmetas->getEmpleadosNullMetas($id_empleado);

		echo json_encode($bandera);

	}

	public function ActualizarMetas(){
		$respuesta = $this->Mmetas->actualizarMetasGeneral($this->session->userdata('usuario')['id_usuario']);
		$respuesta2 = $this->Mmetas->actualizarMetaTecnicoSistemas($this->session->userdata('usuario')['id_usuario']);

		return true;
		
	}

	public function agregarMetas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id_empleado'] = $this->input->post('empleado');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['num_horas'] = $this->input->post('cantidad_horas');
		$data['estado_meta'] = $this->input->post('estado_meta');
		$data['estado'] = "sin registrar";

		$insert_metas = $this->Mmetas->insertMetas($data);

		if(!$insert_metas) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
			return;
		}else{
			if($data['estado_meta'] == "con_meta"){
				$update_supervisor = $this->Mmetas->actualizarMetaSupervisor($data['id_empleado'], $data['id_administrador']);
				if (!$update_supervisor) {
					echo json_encode(['status' => false, 'msg' => 'Algo pasó, Supervisor']);
					return;
				}
				$update_tecnico_sistemas = $this->Mmetas->actualizarMetaTecnicoSistemas($data['id_administrador']);
				if (!$update_tecnico_sistemas) {
					echo json_encode(['status' => false, 'msg' => 'Algo pasó, Tecnico sistema']);
					return;
				}
			}
		}

		echo json_encode(['status' => true]);	

	}

	public function verMetas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$metas            = $this->Mmetas->verMetas();

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
	public function verMetasSupervisor(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		
		$metas            = $this->Mmetas->verMetasSupervisor();

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

	public function editarmetas($id){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano' || $this->session->userdata('usuario')['tipo']=='tecnico sistemas') {
			$data['meta'] = $this->Mmetas->dataMetas($id);
			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarMetas' , $data);
			$this->load->view('includes_admin/footer');
 		}else{
			redirect('Home');
		}
	}

	public function storeMetas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_meta'] = $this->input->post('id_meta');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['num_horas'] = $this->input->post('num_horas');
		$data['estado_meta'] = $this->input->post('estado_meta');

		$updateMeta = $this->Mmetas->editarMeta($data);

		$datos_usuario = $this->Mmetas->consultarOnlyEmpleado($data['id_meta']);

		if(!$updateMeta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Update']);
			return;
		}
		$this->Mmetas->actualizarMetaSupervisor($datos_usuario[0]->id_empleado, $datos_usuario[0]->id_administrador);
		$this->Mmetas->actualizarMetaTecnicoSistemas($datos_usuario[0]->id_administrador);

		echo json_encode(['status' => true]);

	}

	public function consultarMetasEmpleados(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id_supervisor = $this->input->post('id_supervisor');

		$respuesta = $this->Mmetas->consultarMetasEmpleados($id_supervisor);

		echo json_encode($respuesta);
	}

	/// INICIO SALARIO ///

	public function salario_empleados(){

		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['salario']     = $this->MsalarioEmpleados->getSalarios();
			if(!$data['salario']) {
				$data['salario'] = 0;
			} 
			else {
				$data['salario'] = count($this->MsalarioEmpleados->getSalarios());
			}

			$this->load->view('includes_admin/header');
			$this->load->view('admin/salarioempleados' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
		
	}

	public function getsalarios(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$usuarios         = $this->MsalarioEmpleados->verSalarios();

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

	public function addSalario(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$this->load->view('includes_admin/header');
			$this->load->view('admin/addSalario');
			$this->load->view('includes_admin/footer');
 		}else{
			redirect('Home');
		}
	}

	public function agregarSalario(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];
		$data['tipo_usuario'] = $this->input->post('tipo_empleado');
		$data['sueldo'] = $this->input->post('sueldo');

		$respuesta = $this->MsalarioEmpleados->addSalario($data);

		if (!$respuesta) {
			echo json_encode(['status' => false]);
			return;
		}
		echo json_encode(['status' => true]);
	}

	public function registrarFacturasEmpleados(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['fecha_inicial'] = $this->input->post('fecha_inicial');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];

		$respuesta = $this->MsalarioEmpleados->generarFacturaEmpleados($data);

		if ($respuesta) {
			echo json_encode(['status' => true]);
			return;
		}
		echo json_encode(['status' => false, 'msn' => 'NO SE PUDO REALIZAR EL REGISTRO']);
	}

	public function registrarFacturasGeneral(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['fecha_inicial'] = $this->input->post('fecha_inicial');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$data['id_administrador'] = $this->session->userdata('usuario')['id_usuario'];

		$respuesta = $this->MsalarioEmpleados->generarFacturaGeneral($data);
		if ($respuesta) {
			echo json_encode(['status' => true]);
			return;
		}
		echo json_encode(['status' => false, 'msn' => 'NO SE PUDO REALIZAR EL REGISTRO']);
	}

	/// FIN SALARIO ///

	/// INICIO FACTURA SUPERVISOR ///

	public function factura_supervisor($fecha_inicial = "", $fecha_final = ""){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['factura'] = $this->MfacturasSupervisor->getFacturas();
			if(!$data['factura']) {
				$data['factura'] = 0;
			} 
			else {
				$data['factura'] = count($this->MfacturasSupervisor->getFacturas());
			}
			$data['fecha_inicial'] = $fecha_inicial;
			$data['fecha_final'] = $fecha_final;

			$this->load->view('includes_admin/header');
			$this->load->view('admin/factura_supervisor' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}

		
	}

	public function getfacturasSupervisor(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['fecha_inicio'] = $this->input->post('fecha_inicio');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$usuarios         = $this->MfacturasSupervisor->getFacturasSupervisor($data);

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
	/// FIN FACTURA SUPERVISOR ///

	/// INICIO FACTURA GENERAL ///

	public function factura_general($fecha_inicial = "", $fecha_final = ""){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			$data['factura'] = $this->MfacturaGeneral->getFacturas();
			if(!$data['factura']) {
				$data['factura'] = 0;
			} 
			else {
				$data['factura'] = count($this->MfacturaGeneral->getFacturas());
			}
			$data['fecha_inicial'] = $fecha_inicial;
			$data['fecha_final'] = $fecha_final;

			$this->load->view('includes_admin/header');
			$this->load->view('admin/factura_general' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function getfacturasGeneral(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['fecha_inicio'] = $this->input->post('fecha_inicio');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$usuarios         = $this->MfacturaGeneral->getFacturasGeneral($data);

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

	/// FIN FACTURA GENERAL ///

	/// NOMINA GENERAL ///

	public function consultarNominaGeneral(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['fecha_inicial'] = $this->input->post('fecha_inicial');
		$data['fecha_final'] = $this->input->post('fecha_final');

		$respuesta = $this->Mregistronomina->consultarNominaGeneral($data);

		echo json_encode(number_format($respuesta));


	}

	public function consultarGrafica(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['fecha_inicial'] = $this->input->post('fecha_inicial');
		$data['fecha_final'] = $this->input->post('fecha_final');
		$respuesta = $this->Mpaginas->graficaConsulta($data);

		echo json_encode($respuesta);
	}

	public function consultarGraficaMonitor(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data_tokens = [];
		$data = $this->Musuarios->getMonitorUsers();
		if(!$data == false){
			foreach ($data as $key => $persona){
				$persona->id_persona;
				$aux_bonga = $this->Mmetas->getNumHorasSupervisorBonga($persona->id_persona);
		
				if(!$aux_bonga){
					$aux_bonga = 0;
				}else{
					$aux_bonga = $aux_bonga[0]->cantidad_horas;
				}

				$aux_general = $this->Mmetas->getNumHorasSupervisorGeneral($persona->id_persona);

				if(!$aux_general){
					$aux_general = 0;
				}else{
					$aux_general = $aux_general[0]->cantidad_horas;
				}

				$data_tokens[$key] = $aux_general+(round($aux_bonga/2));

			}
		}
		echo json_encode(['data' => $data, 'tokens' => $data_tokens]);
	}

	public function editarFactura($id){
		if($this->session->userdata('usuario')['tipo']=='administrador') {
			$data['factura'] = $this->Mregistronomina->getFactura($id);

			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarFactura' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function editarFacturaMonitor($id){
		if($this->session->userdata('usuario')['tipo']=='administrador') {
			$data['factura'] = $this->Mregistronomina->getFacturaMonitor($id);

			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarFacturaMonitor' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function editarFacturaSupervisor($id){
		if($this->session->userdata('usuario')['tipo']=='administrador') {
			$data['factura'] = $this->Mregistronomina->getFacturaSupervisor($id);

			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarFacturaSupervisor' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function editarFacturaGeneral($id){
		if($this->session->userdata('usuario')['tipo']=='administrador') {
			$data['factura'] = $this->Mregistronomina->getFacturaGeneral($id);

			$this->load->view('includes_admin/header');
			$this->load->view('admin/editarFacturaGeneral' , $data);
			$this->load->view('includes_admin/footer');
		}else{
			redirect('Home');
		}
	}

	public function editFactura(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id_factura'] = $this->input->post('id_factura');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['total_a_pagar'] = $this->input->post('total_a_pagar');
		$data['nuevo_valor'] = $this->input->post('nuevo_valor');

		$respuesta = $this->Mregistronomina->editFactura($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Editar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function editFacturaMonitor(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id_factura_supervisor'] = $this->input->post('id_factura_supervisor');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['total_paga'] = $this->input->post('total_paga');
		$data['nuevo_valor'] = $this->input->post('nuevo_valor');

		$respuesta = $this->Mregistronomina->editFacturaMonitor($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Editar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function editFacturaSupervisor(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id'] = $this->input->post('id');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['total_paga'] = $this->input->post('total_paga');
		$data['nuevo_valor'] = $this->input->post('nuevo_valor');

		$respuesta = $this->Mregistronomina->editFacturaSupervisor($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Editar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function editFacturaGeneral(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['id_factura_general'] = $this->input->post('id_factura_general');
		$data['descripcion'] = $this->input->post('descripcion');
		$data['total_a_pagar'] = $this->input->post('total_a_pagar');
		$data['nuevo_valor'] = $this->input->post('nuevo_valor');

		$respuesta = $this->Mregistronomina->editFacturaGeneral($data);

		if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Algo pasó, Editar']);
			return;
		}

		echo json_encode(['status' => true]);	
	}

	public function logout() {
		unset($_SESSION['usuario']);
		redirect('home');
	}
}
