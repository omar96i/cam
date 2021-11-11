<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SolicitarAdelanto extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mmetas');
		$this->load->model('Mpenalizaciones');
		$this->load->model('Madelantos');
		$this->load->model('Mregistronomina');
		$this->load->model('Mcitas');
		$this->load->model('Madelantos');
    }
    
    public function index(){
		if(!isset($_SESSION['usuario']) || $this->session->userdata('usuario')['tipo']!='empleado') {
			redirect('Home');
		}

		$id_usuario = $this->session->userdata('usuario')['id_usuario'];

		$data['horas']     = $this->Mregistrohoras->getHorasEmpleado($id_usuario);
        $data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_usuario);        
        $data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_usuario);

		if(!$data['horas']) {
			$data['horas'] = 0;
		} 
		else {
			$data['horas'] = count($this->Mregistrohoras->getHorasEmpleado($id_usuario));
		}

        if (!$data['cant_notificaciones']) {
			$data['cant_notificaciones'] = "vacio";
		}

        if (!$data['notificaciones']) {
            $data['notificaciones'] = "vacio";
        }

		$this->load->view('includes_admin/header', $data);
		$this->load->view('empleado/solicitarAdelanto');
		$this->load->view('includes_admin/footer');
	}

	public function AddAdelanto(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_empleado'] = $this->session->userdata('usuario')['id_usuario'];
		$data['descripcion'] = $this->input->post('descripcion');
		$data['valor'] = $this->input->post('valor');
		$data['cuota'] = $this->input->post('cuota');
		$data['cuota_aux'] = $this->input->post('cuota');
		$data['valor_aux'] = $this->input->post('valor');
		$data['estado'] = "por verificar";

		$verificar = $this->Madelantos->verificarAdelanto($data);

		if(!$verificar){
			$respuesta = $this->Madelantos->addAdelanto($data);

			if(!$respuesta) {
				echo json_encode(['status' => false, 'msg' => 'Algo pasó, Registrar']);
				return;
			}
			
		}else{
			echo json_encode(['status' => false, 'msg' => 'Ya dispones de un adelanto sin verificar']);
			return;
		}


		echo json_encode(['status' => true]);
		
		

	}
}
