<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mreportes');
	}

	public function index(){
		if($this->session->userdata('usuario')['tipo']=='administrador' || $this->session->userdata('usuario')['tipo']=='talento humano') {
			
			
			$this->load->view('includes_admin/header');
			$this->load->view('admin/reportes');
			$this->load->view('includes_admin/footer');
			
        }else{
			redirect('Home');
		}

        
	}

	public function getReportes(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}


		$informes         = $this->Mreportes->getDataReportesAdmin();

		if(!$informes) {
			echo json_encode(['status' => false]);
			return;
		}

		echo json_encode(
			[
				'status'          => true, 
				'data'            => $informes
			]);
	}
	
}
