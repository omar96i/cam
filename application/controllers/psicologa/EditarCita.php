<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditarCita extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mcitas');
		$this->load->model('Musuarios');

	}

	public function editCita($id){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='psicologa') {
			redirect('Home');
		}
		
		$data['citas'] = $this->Mcitas->getDataOnlyCita($id);
		$data['empleados'] = $this->Musuarios->getUsuariosFotografo();
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
		$this->load->view('fotografo/editarCita', $data);
		$this->load->view('includes_admin/footer');
	}

	public function editarOnlyCita(){
		$data['descripcion'] = $this->input->post('descripcion');	
		$data['id_citas'] = $this->input->post('id_cita');
		$data['fecha'] = $this->input->post('fecha');
		$data['hora'] = $this->input->post('hora');
		$data['id_empleado'] = $this->input->post('id_usuario');
		$respuesta = $this->Mcitas->editarCita($data);

		if (!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'Error al Modificar el registro']);
			return;
		}

		echo json_encode(['status' => true]);
	}

	
	
}
