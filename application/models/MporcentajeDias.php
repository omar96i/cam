<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MporcentajeDias extends CI_Model {

	public function getPorcentajes(){
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$this->db->where('tipo', 'general');
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return $porcentajes->result();
		}

		return false;
	
	}

	public function getPorcentajesBonga(){
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$this->db->where('tipo', 'bongacams');
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return $porcentajes->result();
		}

		return false;
	
	}

	public function get_porcentaje() {
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$this->db->where('tipo' , 'general');
		$this->db->where('estado' , 'activo');
		$this->db->order_by('cantidad_dias' , 'ASC');
		$porcentajes = $this->db->get();

		if($porcentajes->num_rows() > 0) {
			return $porcentajes->result();
		}

		return false;

	}
	
	public function get_porcentaje_bonga(){
		$this->db->select('*');
		$this->db->from('porcentajes_dias');
		$this->db->where('estado' , 'activo');
		$this->db->where('tipo' , 'bongacams');
		$this->db->order_by('cantidad_dias' , 'ASC');
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
		$this->db->where('tipo', $data['tipo']);
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
		$this->db->where('tipo', $data['tipo']);
		
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
