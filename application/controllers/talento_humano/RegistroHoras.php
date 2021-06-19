<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegistroHoras extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mdolar');
		$this->load->model('Mregistronomina');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Masistencia');

	}

	public function ConsultarAsistencia(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_factura = $this->input->post('id_factura');

		$respuesta = $this->Masistencia->getPersonalAsistencia($id_factura);

		echo json_encode($respuesta);
	}


	
}
