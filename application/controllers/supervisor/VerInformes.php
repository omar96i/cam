<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerInformes extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('MinformeEmpleados');
	}

	public function VerInformesEmpleado($id_empleado){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='supervisor' && $this->session->userdata('usuario')['tipo']!='administrador') {
			redirect('Home');
		}

		$data['lista_informes'] = $this->MinformeEmpleados->getInforme($id_empleado);

		if(!$data['lista_informes']) {
			$data['lista_informes'] = 0;
		} 
		else {
			$data['lista_informes'] = count($this->MinformeEmpleados->getInforme($id_empleado));
		}

		$data['id_empleado'] = $id_empleado;
		$data['tipo_usuario'] = $this->session->userdata('usuario')['tipo'];

		
		$this->load->view('includes_admin/header');
		$this->load->view('supervisor/verInforme' , $data);
		$this->load->view('includes_admin/footer');
	}

	public function getInformes(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$id_usuario 	  = $this->input->post('id_usuario');
		$informes       = $this->MinformeEmpleados->getDataInformes($id_usuario);

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
