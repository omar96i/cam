<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MporcentajeDias extends CI_Model {

	public function getPorcentajes(){
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return $porcentajes->result();
		}

		return false;
	
	}

	public function get_porcentaje($valor , $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$this->db->like('cantidad_dias' , $valor);
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

	public function addPorcentajeDias($data){
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$this->db->where('cantidad_dias', $data['cantidad_dias']);
		$this->db->where('estado_meta', $data['estado_meta']);
		$this->db->where('estado', 'activo');
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return false;
		}else{
			return $this->db->insert('porcentajes_dias', $data);
		}

		return false;
	}

	public function dataPorcentajes($id_porcentaje){
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$this->db->where('id_porcentajes_dias', $id_porcentaje);
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return $porcentajes->result();
		}

		return false;

	}

	public function updatePorcentajesDias($data){
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$this->db->where('cantidad_dias', $data['cantidad_dias']);
		$this->db->where('estado_meta', $data['estado_meta']);
		$this->db->where('id_porcentajes_dias !=', $data['id_porcentajes_dias']);
		$this->db->where('estado', 'activo');
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return false;
		}else{
			$this->db->where('id_porcentajes_dias', $data['id_porcentajes_dias']);
			return $this->db->update('porcentajes_dias', $data);
		}
		
	}



}