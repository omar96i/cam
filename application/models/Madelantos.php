<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Madelantos extends CI_Model {
	public function getAdelantos() {
		$this->db->select('*');
		$this->db->from('adelanto');
		$adelantos = $this->db->get();

		if($adelantos->num_rows() > 0) {
			return $adelantos->result();
		}

		return false;
	}

	public function addAdelanto($data){
		return $this->db->insert('adelanto', $data);
	}

	public function get_adelantos($valor , $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('adelanto.*, persona.*');
		$this->db->from('adelanto');
		$this->db->join('persona', 'persona.id_persona = adelanto.id_empleado');
		$this->db->like('persona.nombres' , $valor);
		$this->db->order_by('adelanto.estado' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$penalizaciones = $this->db->get();

		if($penalizaciones->num_rows() > 0) {
			return $penalizaciones->result();
		}

		return false;

	}

	public function dataAdelantos($id_adelanto){
		$this->db->select('*');
		$this->db->from('adelanto');
		$this->db->where('id_adelanto', $id_adelanto);

		$adelantos = $this->db->get();

		if($adelantos->num_rows() > 0) {
			return $adelantos->result();
		}

		return false;
	}

	public function getAdelantosEmpleado($id_empleado){
		$this->db->select('*');
		$this->db->from('adelanto');
		$this->db->where('id_empleado', $id_empleado);
		$this->db->where('estado', 'sin registrar');
		$consulta = $this->db->get();

		if ($consulta->num_rows()>0) {
			return $consulta->result();
		}
		return false;
	}

	public function updateAdelanto($data){
		$this->db->where('id_adelanto', $data['id_adelanto']);
		return $this->db->update('adelanto', $data);
	}

}
