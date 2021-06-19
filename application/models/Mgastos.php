<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mgastos extends CI_Model {

	public function getGastos($valor, $inicio = FALSE, $registros_pagina = FALSE) {
		$this->db->select('nombres, descripcion, fecha, valor, id_gasto')->from('gastos')->join('persona', 'persona.id_persona = gastos.id_empleado')->like('documento', $valor);

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$gastos = $this->db->get();

		if($gastos->num_rows() > 0) {
			return $gastos->result();
		}

		return false;
	}

	public function addGasto($data){
		return $this->db->insert('gastos',$data);
	}

	public function getGeneral($data){
		$this->db->select_sum('valor')->from('gastos');
		if ($data['fecha_inicio'] != "") {
			$this->db->where('fecha >=', $data['fecha_inicio']);
		}
		if ($data['fecha_final'] != "") {
			$this->db->where('fecha <=', $data['fecha_final']);
		}
		$consulta = $this->db->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;
	}

	public function getDataEditGasto($id){
		$consulta = $this->db->select('*')->from('gastos')->where('id_gasto', $id)->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}

		return false;
	}

	public function editGasto($data){
		$this->db->where('id_gasto', $data['id_gasto']);
		return $this->db->update('gastos', $data);
	}
}
