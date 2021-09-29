<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
	}

	public function getInfPdf($id){
		$data['consulta1'] = $this->Musuarios->getDatosPDF($id);
		$this->load->view('includes_admin/imprimir_header');
		$this->load->view('carta_laboral', $data);
		$this->load->view('includes_admin/imprimir_footer');
	}
}
