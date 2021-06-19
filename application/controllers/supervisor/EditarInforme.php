<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditarInforme extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MinformeEmpleados');
	}

	public function editInforme($id, $id_empleada){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}

		$data['informe'] = $this->MinformeEmpleados->getOnlyInforme($id);
		$data['id_empleada'] = $id_empleada;

		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/editarInforme' , $data);
		$this->load->view('includes_admin/footer');
    }
    
    public function editarInforme(){
        $data['id_informe_empleado'] = $this->input->post('id');
        $data['fecha'] = $this->input->post('fecha');
        $data['descripcion'] = $this->input->post('descripcion');


        $respuesta = $this->MinformeEmpleados->editarInforme($data);

        if (!$respuesta) {
			echo json_encode(['status' => false, 'msn' => 'Ago paso ups']);
			return;
		}

		echo json_encode(['status' => true]);

    }

	
}
