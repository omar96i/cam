<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MfacturaGeneral extends CI_Model {
	public function getFacturas(){
		$this->db->select('*');
		$this->db->from('factura_general');
		$arreglo = $this->db->get();

		if($arreglo->num_rows() > 0) {
			return $arreglo->result();
		}

		return false;
	}
	public function getFacturasGeneral($data) {
		$this->db->select('persona.*, factura_general.*, usuarios.tipo_cuenta');
		$this->db->from('factura_general');
		$this->db->join('persona', 'persona.id_persona = factura_general.id_empleado');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		if($data['fecha_inicio'] != ""){
			$this->db->where('fecha_inicial >=', $data['fecha_inicio']);
		}
		if($data['fecha_final'] != ""){
			$this->db->where('fecha_inicial <=', $data['fecha_final']);
		}
		$this->db->order_by('factura_general.fecha_registrado' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}
}
