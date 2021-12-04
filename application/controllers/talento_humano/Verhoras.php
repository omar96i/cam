<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verhoras extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Musuarios');
		$this->load->model('Mpaginas');
		$this->load->model('Masignaciones');
		$this->load->model('Mregistrohoras');
		$this->load->model('Mdolar');
		$this->load->model('Mregistronomina');
		$this->load->model('Mpenalizaciones');
	}

	public function verificarHoras(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}
		$data['fecha_inicial'] = $this->input->post('fecha_inicial_v');
		$data['fecha_final'] = $this->input->post('fecha_final_v');
		$data['id_usuario'] = $this->input->post('id_usuario');

		$respuesta = $this->Mregistrohoras->verificarHoras($data);
		if(!$respuesta) {
			echo json_encode(['status' => false, 'msn' => 'Error al actualizar los datos']);
			return;
		}

		echo json_encode(['status' => true]);
	}


	public function registrar_horas(){
		if(!$this->input->is_ajax_request()){
			echo json_encode(['status' => false, 'msg' => 'Ups, algo pasó']);
			return; 
		}

		$data['id_persona'] = $this->input->post('id_persona');
		$data['fecha_inicial'] = $this->Mregistronomina->get_fecha_incialNomina($data['id_persona']);
		$data['fecha_final'] = $this->input->post('fecha_final');
		$data['id_talento'] = $this->session->userdata('usuario')['id_usuario'];

		if (!empty($data['fecha_inicial'])) {
			if (new DateTime($data['fecha_final']) >= new DateTime($data['fecha_inicial'])) {
				if ($this->Mregistrohoras->falta_validarTokens($data)) {
					echo json_encode(['status' => false, 'msg' =>'Faltan regitros de token por verificar dentro del rango de fechas.']);
					return;	

				}else{
					if($this->Mregistronomina->VerificarMeta($data)){
						$respuesta = $this->Mregistronomina->registrarNomina($data);
					}else{
						echo json_encode(['status' => false, 'msg' =>'El usuario actualmente no tiene meta']);
						return;	
					}	
				}

			}else{
				echo json_encode(['status' => false, 'msg' => 'La fecha final debe ser mayor a la incial.']);
				return;
			}

		}else{
			echo json_encode(['status' => false, 'msg' => 'no se a podido realizar el registro.']);
			return;
		}

		if (!$respuesta) {
			echo json_encode(['status' => false, 'msg' => 'no se a podido realizar el registro.']);
			return;
		}
		
		$fecha=strtotime($data['fecha_final']."+ 1 days");
		echo json_encode(['status' => true, 'fecha_inicial' => date('Y-m-d', $fecha)]);
	}

	
}
