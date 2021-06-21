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

    public function getDataGeneral($fecha_inicio, $fecha_final, $inicio = FALSE, $registros_pagina = FALSE){
		$this->db->select('nombres, apellidos, documento, tipo_cuenta, ingresos_software.*')->from('ingresos_software')->join('persona', 'persona.id_persona = ingresos_software.id_usuario')->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		if ($fecha_inicio != "") {
			$this->db->where('ingresos_software.fecha >=', $fecha_inicio);
		}
		if ($fecha_final != "") {
			$this->db->where('ingresos_software.fecha <=', $fecha_final);
		}
		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$this->db->order_by('fecha', 'DESC');
		$consulta = $this->db->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;
	}
}
