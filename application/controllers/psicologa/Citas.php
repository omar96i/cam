<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Citas extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mcitas');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='psicologa') {
			redirect('Home');
        }

        $id_psicologa = $this->session->userdata('usuario')['id_usuario'];

        $data['citas'] = $this->Mcitas->getCitas($id_psicologa);

		if(!$data['citas']) {
			$data['citas'] = 0;
		} 
		else {
			$data['citas'] = count($this->Mcitas->getCitas($id_psicologa));
		}


        $data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_psicologa);        
        $data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_psicologa);


        if (!$data['cant_notificaciones']) {
			$data['cant_notificaciones'] = "vacio";
		}

        if (!$data['notificaciones']) {
            $data['notificaciones'] = "vacio";
        }
        
        $this->load->view('includes_admin/header', $data);
		$this->load->view('psicologa/citas', $data);
		$this->load->view('includes_admin/footer');
	}



	public function getCitas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial    = $this->input->post('fecha_inicio');    
		$fecha_final 	  = $this->input->post('fecha_final');
		$id_usuario       = $this->session->userdata('usuario')['id_usuario'];
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$citas         = $this->Mcitas->getDataCitas($id_usuario , $fecha_inicial, $fecha_final, $valor, $inicio, $cantidad);
		$total_registros  = count($this->Mcitas->getDataCitas($id_usuario, $fecha_inicial, $fecha_final, $valor)); 

		if(!$citas) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $citas,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);
	}

	public function getCitasAdmin(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$fecha_inicial    = $this->input->post('fecha_inicio');    
		$fecha_final 	  = $this->input->post('fecha_final');
		$valor            = $this->input->post('valor');
		$pagina           = $this->input->post('pagina');
		$cantidad         = 4;
		$inicio           = ($pagina - 1) * $cantidad;
		$citas            = $this->Mcitas->getDataCitasAdmin($fecha_inicial, $fecha_final, $valor, $inicio, $cantidad);
		$total_registros  = count($this->Mcitas->getDataCitasAdmin($fecha_inicial, $fecha_final, $valor)); 

		if(!$citas) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $citas,
				'cantidad'        => $cantidad,
				'total_registros' => $total_registros
			]);
	}

	public function delete_cita(){
		$id = $this->input->post('id_cita');
		$respuesta = $this->Mcitas->delete_cita($id);
		if (!$respuesta) {
			echo json_encode(['status' => false , 'msg' => 'Error al eliminar']);
			return;
		}
		echo json_encode(['status' => true]);
	}
	
}
