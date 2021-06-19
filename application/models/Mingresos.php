<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mingresos extends CI_Model {
	public function getIngresos($valor, $inicio = FALSE, $registros_pagina = FALSE) {
		$this->db->select('ingresos.valor, ingresos.fecha_registro, factura.total_horas, total_a_pagar, ingresos.porcentaje')->from('ingresos')->join('factura', 'factura.id_factura = ingresos.id_factura')->join('dolar', 'dolar.id_dolar = factura.id_dolar');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$gastos = $this->db->get();

		if($gastos->num_rows() > 0) {
			return $gastos->result();
		}

		return false;
	}

	public function getGeneral($data){
		$this->db->select_sum('valor')->from('ingresos');
		if ($data['fecha_inicio'] != "") {
			$this->db->where('fecha_registro >=', $data['fecha_inicio']);
		}
		if ($data['fecha_final'] != "") {
			$this->db->where('fecha_registro <=', $data['fecha_final']);
		}
		$consulta = $this->db->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;
	}
}
