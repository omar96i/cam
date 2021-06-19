<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mmetas');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Madelantos');
		$this->load->model('Mregistronomina');
		$this->load->model('Mcitas');
	}

	public function index() {
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='empleado') {
			redirect('Home');
		}
		$id_usuario = $this->session->userdata('usuario')['id_usuario'];

        $fecha = date("Y-m-d");
        $this->Mcitas->actualizarCita($fecha);

		$data['supervisor'] = $this->Masignaciones->obtener_supervisor($id_usuario);
		$data['meta'] = $this->Mmetas->getMetasOnlyEmpleado($id_usuario);
		$data['num_horas'] = $this->Mregistrohoras->getNumHoras($id_usuario);
		$data['factura'] = $this->Mregistronomina->getLastFactura($id_usuario);
        $data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_usuario);        
        $data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_usuario);
		$data['estado'] = true;

		if (!$data['supervisor']) {
			$data['supervisor'] = 0;
			$data['estado'] = false;

		}
		if (!empty($data['meta'])) {
			if (empty($data['num_horas']['verificados']->cantidad_horas)) {
				$data['num_horas']['verificados']->cantidad_horas = 0;
			}
			$data['total'] = $data['meta']->num_horas-$data['num_horas']['verificados']->cantidad_horas;
		}

        if (!$data['cant_notificaciones']) {
			$data['cant_notificaciones'] = "vacio";
		}

        if (!$data['notificaciones']) {
            $data['notificaciones'] = "vacio";
        }

		$this->load->view('includes_admin/header', $data);
		$this->load->view('empleado/home');
		$this->load->view('includes_admin/footer');
	}

	public function consultarhoras(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='empleado') {
			redirect('Home');
		}

		$id_usuario = $this->session->userdata('usuario')['id_usuario'];

		$data['horas']     = $this->Mregistrohoras->getHorasEmpleado($id_usuario);
        $data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_usuario);        
        $data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_usuario);

		if(!$data['horas']) {
			$data['horas'] = 0;
		} 
		else {
			$data['horas'] = count($this->Mregistrohoras->getHorasEmpleado($id_usuario));
		}

        if (!$data['cant_notificaciones']) {
			$data['cant_notificaciones'] = "vacio";
		}

        if (!$data['notificaciones']) {
            $data['notificaciones'] = "vacio";
        }

		$this->load->view('includes_admin/header', $data);
		$this->load->view('empleado/consultarhoras');
		$this->load->view('includes_admin/footer');
	}


	public function getPenalizaciones(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$id_usuario 	  = $this->session->userdata('usuario')['id_usuario'];
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$usuarios         = $this->Mpenalizaciones->getPenalizacionesUsuarioNew($valor , $id_usuario, $inicio, $cantidad);
		$total_registros  = count($this->Mpenalizaciones->getPenalizacionesUsuarioNew($valor, $id_usuario)); 

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

	public function getAdelanto(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_usuario 	  = $this->session->userdata('usuario')['id_usuario'];

		$adelantos = $this->Madelantos->getAdelantosEmpleado($id_usuario);
		if (!$adelantos) {
			echo json_encode(['status'=>false]);
			return;
		}
		echo json_encode(['status' => true, 'data' => $adelantos]);
	}

	public function logout() {
		unset($_SESSION['usuario']);
		redirect('home');
	}
}
