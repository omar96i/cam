<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MingresosSoftware extends CI_Model {
	
	public function insertIngreso($id_usuario){
        $this->db->set('id_usuario', $id_usuario);
        $this->db->insert('ingresos_software');
    }

    public function getDataIngresos(){
        $consulta = $this->db->select('*')->from('ingresos_software')->get();

        if($consulta->num_rows() > 0) {
			return $consulta->result();
		}

		return false;
    }

    public function getDataGeneral(){
		$this->db->select('nombres, apellidos, documento, tipo_cuenta, ingresos_software.*')->from('ingresos_software')->join('persona', 'persona.id_persona = ingresos_software.id_usuario')->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		
		$this->db->order_by('fecha', 'DESC');
		$consulta = $this->db->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;
	}
}
