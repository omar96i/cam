<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imprimir_factura extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mregistronomina');
		$this->load->model('Musuarios');
	}

	public function getFacturaInf($id){
			
		$data['consulta1'] = $this->Mregistronomina->getDatosFacturaImprimir($id);

		$this->load->view('includes_admin/imprimir_header');
		$this->load->view('imprimir_factura', $data);
		$this->load->view('includes_admin/imprimir_footer');
	}
	public function getFacturaInfMonitor($id){
			
		$data['consulta1'] = $this->Mregistronomina->getDatosFacturaImprimirMonitor($id);

		$this->load->view('includes_admin/imprimir_header');
		$this->load->view('imprimir_factura_monitor', $data);
		$this->load->view('includes_admin/imprimir_footer');
	}
	public function getFacturaInfSupervisor($id){
			
		$data['consulta1'] = $this->Mregistronomina->getDatosFacturaImprimirSupervisor($id);

		$this->load->view('includes_admin/imprimir_header');
		$this->load->view('imprimir_factura_supervisor', $data);
		$this->load->view('includes_admin/imprimir_footer');
	}
	public function getFacturaInfGeneral($id){
			
		$data['consulta1'] = $this->Mregistronomina->getDatosFacturaImprimirGeneral($id);

		$this->load->view('includes_admin/imprimir_header');
		$this->load->view('imprimir_factura_general', $data);
		$this->load->view('includes_admin/imprimir_footer');
	}
}
