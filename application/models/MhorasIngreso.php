<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MhorasIngreso extends CI_Model {
	public function insertIngreso($id_usuario){
        $this->db->set('id_usuario', $id_usuario);
        $this->db->insert('horas_ingresos');
    }

    public function getDataIngresos(){
        $consulta = $this->db->select('*')->from('horas_ingresos')->get();

        if($consulta->num_rows() > 0) {
			return $consulta->result();
		}

		return false;
    }

    public function getDataGeneral($fecha_inicio, $fecha_final, $inicio = FALSE, $registros_pagina = FALSE){
		$this->db->select('nombres, apellidos, documento, tipo_cuenta, horas_ingresos.*')->from('horas_ingresos')->join('persona', 'persona.id_persona = horas_ingresos.id_usuario')->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		if ($fecha_inicio != "") {
			$this->db->where('horas_ingreso.fecha >=', $fecha_inicio);
		}
		if ($fecha_final != "") {
			$this->db->where('horas_ingreso.fecha <=', $fecha_final);
		}
		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$consulta = $this->db->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;
	}
}
