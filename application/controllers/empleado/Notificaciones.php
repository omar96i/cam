<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones extends CI_Controller {
	

	public function __construct() {
		parent::__construct();
		$this->load->model('Mcitas');
    }
    
    public function verNotificacion($id){
        $fecha = date("Y-m-d");

        $this->Mcitas->actualizarCita($fecha);
        $id_usuario = $this->session->userdata('usuario')['id_usuario'];
        $data['notificaciones'] = $this->Mcitas->getCitasEmpleado($id_usuario);
        
        $data['cant_notificaciones'] = $this->Mcitas->getCantCitasEmpleado($id_usuario);
        if (!$data['cant_notificaciones']) {
			$data['cant_notificaciones'] = "vacio";
		}

        if (!$data['notificaciones']) {
            $data['notificaciones'] = "vacio";
        }

        $data['notificacion'] = $this->Mcitas->getCitaNotificacion($id);
        

        $this->load->view('includes_admin/header', $data);
		$this->load->view('empleado/notificaciones');
		$this->load->view('includes_admin/footer');
    }

    public function actualizarNotificaciones(){
        $fecha = date("Y-m-d");

        $this->Mcitas->actualizarCita($fecha);
    }

	

	
}
