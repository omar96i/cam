<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MetasSupervisor extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MdescuentosDias');
		$this->load->model('Mmetas');
		$this->load->model('Mcitas');
	}

	public function index($tittle = "general"){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano' || $this->session->userdata('usuario')['tipo']=='tecnico sistemas') {
			$data['tittle'] = $tittle;
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
			$this->load->view('admin/metasMonitor', $data);
			$this->load->view('includes_admin/footer');
        }else{
			redirect('Home');
		}
	}

	public function verMetasSupervisor(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$metas = $this->Mmetas->verMetasMonitor();

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

}
