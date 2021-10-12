<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MdescuentosDias extends CI_Model {
	public function getDatos(){
		$this->db->select('*');
		$this->db->from('dias_descontados');
		$this->db->where('estado !=', 'inactivo');

		$descuentos = $this->db->get();

		if($descuentos->num_rows() > 0) {
			return $descuentos->result();
		}

		return false;
	}

	public function getDescuentosTable(){
		$response = $this->db->select('*')->from('dias_descontados')
								->join('persona', 'persona.id_persona = dias_descontados.id_persona')
								->where('estado !=', 'inactivo')
								->get();
		if ($response->num_rows() > 0) {
			return $response->result();
		}
		return false;
	}
	
	public function store($data){
		return $this->db->insert('dias_descontados', $data);
	}

	public function edit($data){
		$this->db->where('id', $data['id']);
		return $this->db->update('dias_descontados', $data);
	}

	public function delete($data){
		$this->db->where('id', $data['id']);
		return $this->db->update('dias_descontados', $data);
	}

	public function getDataOnly($id){
		$response = $this->db->select('*')->from('dias_descontados')->where('id', $id)->get();
		if ($response->num_rows() > 0) {
			return $response->result();
		}
		return false;
	}
}
