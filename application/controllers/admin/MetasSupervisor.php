<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MetasSupervisor extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MdescuentosDias');
		$this->load->model('Mmetas');
	}

	public function index($tittle = "general"){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano' || $this->session->userdata('usuario')['tipo']=='tecnico sistemas') {
			$data['tittle'] = $tittle;
			
			$this->load->view('includes_admin/header');
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
