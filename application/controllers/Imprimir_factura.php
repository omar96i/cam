<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imprimir_factura extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mregistronomina');
	}

	public function getFacturaInf($id){

		$data['consulta1'] = $this->Mregistronomina->getDatosFacturaImprimir($id);
		$this->load->view('includes_admin/imprimir_header');
		$this->load->view('imprimir_factura', $data);
		$this->load->view('includes_admin/imprimir_footer');

	}
}
