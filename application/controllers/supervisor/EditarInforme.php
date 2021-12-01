<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditarInforme extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MinformeEmpleados');
		$this->load->model('Mcitas');
	}

	public function editInforme($id, $id_empleada){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}

		$data['informe'] = $this->MinformeEmpleados->getOnlyInforme($id);
		$data['id_empleada'] = $id_empleada;

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
