<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MinformeEmpleados extends CI_Model {

	public function getGastos($valor, $inicio = FALSE, $registros_pagina = FALSE) {
		$this->db->select('nombres, descripcion, fecha, valor, id_gasto')->from('gastos')->join('persona', 'persona.id_persona = gastos.id_empleado')->like('documento', $valor);

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$gastos = $this->db->get();

		if($gastos->num_rows() > 0) {
			return $gastos->result();
		}

		return false;
	}

	public function verificarInforme($data){
		$consulta = $this->db->select('*')->from('informe_empleados')->where('fecha', $data['fecha'])->where('id_empleado', $data['id_empleado'])->get();
		if ($consulta->num_rows() > 0) {
			return true;
		}
		return false;
	}

	public function addInforme($data){
		return $this->db->insert('informe_empleados', $data);
	}

	public function getInforme($id_empleado){
		$consulta = $this->db->select('*')->from('informe_empleados')->where('id_empleado', $id_empleado)->get();
		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;
	}

	public function getDataInformes($id_usuario) {
		$this->db->select('*')->from('informe_empleados')->join('persona', 'persona.id_persona = informe_empleados.id_empleado')->where('id_empleado', $id_usuario);
		$informes = $this->db->get();

		if($informes->num_rows() > 0) {
			return $informes->result();
		}

		return false;
	}

	public function getOnlyInforme($id){
		$consulta = $this->db->select('*')->from('informe_empleados')->where('id_informe_empleado', $id)->get()->result();
		return $consulta;
	}

	public function editarInforme($data){
		$this->db->where('id_informe_empleado', $data['id_informe_empleado']);
		return $this->db->update('informe_empleados', $data);
	}

	
}
