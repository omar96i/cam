<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MmetasSupervisor extends CI_Model {

	public function getDatos(){
		$consulta = $this->db->select('*')->from('metas_supervisor')->where('estado', 'activo')->get();
		if($consulta->num_rows()>0){
			return $consulta->result();
		}
		return false;
	}

	public function store($data){
		return $this->db->insert('metas_supervisor', $data);
	}

	public function getMetasTable(){
		$consulta = $this->db->select('*')->from('metas_supervisor')->where('estado', 'activo')->get();
		if($consulta->num_rows()>0){
			return $consulta->result();
		}
		return false;
	}

	public function getDataOnly($id){
		return $this->db->select('*')->from('metas_supervisor')->where('id', $id)->get()->result();
	}

	public function edit($data){
		$this->db->where('id', $data['id']);
		return $this->db->update('metas_supervisor', $data);
	}

	public function delete($data){
		$this->db->where('id', $data['id']);
		return $this->db->update('metas_supervisor', $data);
	}
}
