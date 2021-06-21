<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Mlogin');
		$this->load->model('MingresosSoftware');
	}

	public function loguear() {
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return;
		}

		$data['email'] = $this->input->post('email');
		$data['clave'] = $this->input->post('clave');


		if(!filter_var( $data['email'] , FILTER_VALIDATE_EMAIL)) {
			echo json_encode(['status' => false, 'msg' => 'El correo que intentas acceder no es válido']);
			return;
		}

		$validate = $this->Mlogin->valid_login($data);

		if(!$validate) {
			echo json_encode(['status' => false, 'msg' => 'Los datos son incorrectos, intente de nuevo']);
			return;
		}else if($validate->estado == 'inactivo'){
			echo json_encode(['status' => false, 'msg' => 'Lo sentimos, cuenta inactiva']);
			return;
		}

		$usuario = [
			'id_usuario' => $validate->id_usuario,
			'nombre'     => $validate->nombres,
			'foto'		 => $validate->foto,
			'email'      => $validate->correo, 
			'tipo'       => $validate->tipo_cuenta,
			'login'      => TRUE
		];	
		

		$this->MingresosSoftware->insertIngreso($validate->id_usuario); 
		$_SESSION['usuario'] = $usuario;

		echo json_encode(['status' => true]);
	}
}

