<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MporcentajeMetas extends CI_Model {


	public function getPorcentajes(){
		$this->db->select('*');
		$this->db->from('porcentajes_metas');
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return $porcentajes->result();
		}

		return false;
	
	}

	public function get_porcentaje($valor , $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('*');
		$this->db->from('porcentajes_metas');
		$this->db->like('valor' , $valor);
		$this->db->order_by('estado' , 'ASC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return $porcentajes->result();
		}

		return false;

	}

	public function addPorcentajeMetas($data){
		$this->db->set('estado', 'inactivo');
		$this->db->update('porcentajes_metas');

		return$this->db->insert('porcentajes_metas', $data);
	}

	public function dataPorcentajes($id_porcentaje){
		$this->db->select('*');
		$this->db->from('porcentajes_metas');
		$this->db->where('id_porcentaje_metas', $id_porcentaje);
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return $porcentajes->result();
		}

		return false;

	}

	public function updatePorcentajesMetas($data){
		if ($data['estado'] == 'activo') {
			$this->db->set('estado', 'inactivo');
			$this->db->update('porcentajes_metas');
		}
		$this->db->where('id_porcentaje_metas', $data['id_porcentaje_metas']);
		return $this->db->update('porcentajes_metas', $data);
	}

}