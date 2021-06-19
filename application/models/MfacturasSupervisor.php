<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MfacturasSupervisor extends CI_Model {
	public function getFacturas(){
		$this->db->select('*');
		$this->db->from('factura_supervisor');
		$arreglo = $this->db->get();

		if($arreglo->num_rows() > 0) {
			return $arreglo->result();
		}

		return false;
	}
	public function getFacturasSupervisor($valor, $fecha_inicial, $fecha_final, $inicio = FALSE, $registros_pagina = FALSE) {
		$this->db->select('persona.*, factura_supervisor.*,metas.num_horas');
		$this->db->from('factura_supervisor');
		$this->db->join('persona', 'persona.id_persona = factura_supervisor.id_empleado');
		$this->db->join('metas', 'factura_supervisor.id_meta = metas.id_meta');

		if ($fecha_inicial != null) {
			$this->db->where('factura_supervisor.fecha_registro >=', $fecha_inicial);
		}
		if ($fecha_final != null) {
			$this->db->where('factura_supervisor.fecha_registro <=', $fecha_final);
		}
		
		$this->db->order_by('factura_supervisor.fecha_registro' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}
}
