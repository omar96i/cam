<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maumentos extends CI_Model {

	public function getDatos(){
		$this->db->select('*');
		$this->db->from('aumentos');
		$this->db->where('estado !=', 'inactivo');

		$descuentos = $this->db->get();

		if($descuentos->num_rows() > 0) {
			return $descuentos->result();
		}

		return false;
	}

	public function getDataTable(){
		$response = $this->db->select('*')->from('aumentos')
								->join('persona', 'persona.id_persona = aumentos.id_persona')
								->where('estado !=', 'inactivo')
								->get();
		if ($response->num_rows() > 0) {
			return $response->result();
		}
		return false;
	}

	public function store($data){
		return $this->db->insert('aumentos', $data);
	}

	public function update($data){
		$this->db->where('id', $data['id']);
		return $this->db->update('aumentos', $data);
	}

	public function getAumento($id){
		return $this->db->select('*')->from('aumentos')->where('id', $id)->get()->result();
	}
}
