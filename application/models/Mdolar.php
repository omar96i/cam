<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdolar extends CI_Model {
	public function getValueDolar(){
		$this->db->select('*');
		$this->db->from('dolar');
		$this->db->where('estado', 'activo');
		$arreglo = $this->db->get();

		if($arreglo->num_rows() > 0) {
			return $arreglo->row();
		}

		return false;
	}

	public function registrarDolar($data){
		$this->db->set('estado', 'inactivo');
		$this->db->update('dolar');
		return $this->db->insert('dolar', $data);
	}
	
}
