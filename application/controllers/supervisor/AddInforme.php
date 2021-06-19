<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddInforme extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Masignaciones');
		$this->load->model('MinformeEmpleados');
	}

	public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor') {
			redirect('Home');
		}

		
		$id_supervisor = $this->session->userdata('usuario')['id_usuario'];
		$data['lista_usuarios'] = $this->Masignaciones->getOnlyEmpleados($id_supervisor);

		
		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/addInforme' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function AgregarInforme(){
        $data['id_empleado'] = $this->input->post('empleado');
        $data['id_supervisor'] = $this->session->userdata('usuario')['id_usuario'];
        $data['fecha'] = $this->input->post('fecha');
        $data['descripcion'] = $this->input->post('descripcion');


        $verificacion = $this->MinformeEmpleados->verificarInforme($data);
        if ($verificacion) {
            echo json_encode(['status' => false, 'msg' => 'El empleado ya dispone de un informe de esa fecha']);
            return;
        }

        $respuesta = $this->MinformeEmpleados->addInforme($data);

        if(!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el registro']);
			return;
		}

		echo json_encode(['status' => true]);

    }
}
