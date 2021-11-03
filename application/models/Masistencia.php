<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masistencia extends CI_Model {
	public function getAsistencias($id_supervisor) {
		$this->db->select('*');
		$this->db->from('asistencia');
		$this->db->where('id_supervisor', $id_supervisor);
		$this->db->where('estado', 'activo');
		$asistencia = $this->db->get();

		if($asistencia->num_rows() > 0) {
			return $asistencia->result();
		}

		return false;
	}

	public function getDataAsistencia($id_usuario) {
		$this->db->select('*');
		$this->db->from('asistencia');
		$this->db->where('id_supervisor', $id_usuario);
		$this->db->order_by('fecha' , 'DESC');
		$asistencia = $this->db->get();

		if($asistencia->num_rows() > 0) {
			return $asistencia->result();
		}

		return false;
	}

	public function t_h_getDataAsistencia(){
		$this->db->select('*');
		$this->db->from('asistencia')->join('persona', 'persona.id_persona = asistencia.id_supervisor');
		$this->db->order_by('fecha' , 'DESC');

		$asistencia = $this->db->get();

		if($asistencia->num_rows() > 0) {
			return $asistencia->result();
		}

		return false;
	}

	public function getDatosAsistencia($id_supervisor){
		$consulta = $this->db->select('*')->from('asistencia')->where('id_supervisor', $id_supervisor)->where('estado', 'finalizado')->get();

		if($consulta->num_rows() > 0) {
			return $consulta->result();
		}

		return false;

	}

	public function t_h_getDatosAsistencia(){
		$consulta = $this->db->select('*')->from('asistencia')->where('estado', 'finalizado')->get();

		if($consulta->num_rows() > 0) {
			return $consulta->result();
		}

		return false;

	}

	public function extraerEmpleadosAsistencia($id_asistencia){
		$this->db->select('asistencia_empleado.id_asistencia, asistencia_empleado.estado, asistencia_empleado.motivo, persona.documento, persona.nombres, persona.apellidos, persona.id_persona');
		$this->db->from('asistencia_empleado');
		$this->db->join('persona', 'persona.id_persona = asistencia_empleado.id_empleado');
		$this->db->where('id_asistencia', $id_asistencia);

		$asistencia = $this->db->get();

		if($asistencia->num_rows() > 0) {
			return $asistencia->result();
		}

		return false;
	}

	public function get_regitroAsistencias($id_asistencia){
		$this->db->select('asistencia_empleado.estado, persona.nombres, motivo_asistencia.nombre');
		$this->db->from('asistencia_empleado');
		$this->db->join('persona', 'persona.id_persona = asistencia_empleado.id_empleado');
		$this->db->join('motivo_asistencia', 'motivo_asistencia.id_motivo = asistencia_empleado.motivo', 'left');
		$this->db->where('id_asistencia', $id_asistencia);

		$asistencia = $this->db->get();

		if($asistencia->num_rows() > 0) {
			return $asistencia->result();
		}

		return false;
	}

	public function verificarAsistenciaFecha($fecha, $id_supervisor){
		$this->db->select('*');
		$this->db->from('asistencia');
		$this->db->where('id_supervisor', $id_supervisor);
		$this->db->where('fecha', $fecha);
		$consulta = $this->db->get();

		if ($consulta->num_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function insertAsistencia($id_supervisor, $tipo_usuario, $fecha){
		if($tipo_usuario == "tecnico sistemas"){
			$this->db->select('id_usuario');
			$this->db->from('usuarios');
			$this->db->where('tipo_cuenta', 'supervisor');
			$this->db->where('estado', 'activo');
		}else{
			$this->db->select('id_empleado');
			$this->db->from('empleado_supervisor');
			$this->db->where('id_supervisor', $id_supervisor);
			$this->db->where('estado', 'activo');
		}
		
		$consulta_items_empleados = $this->db->get();

		if($consulta_items_empleados->num_rows() > 0) {
			$datos_consulta_items_empleados = $consulta_items_empleados->result();	
			$data['fecha'] = $fecha;
			$data['id_supervisor'] = $id_supervisor;
			$data['estado'] = "activo";
			$this->db->insert('asistencia', $data);

			$data2['id_asistencia'] = $this->db->insert_id();
			foreach ($datos_consulta_items_empleados as $key => $value) {
				$data2['id_empleado'] = ($tipo_usuario == "tecnico sistemas") ? $value->id_usuario : $value->id_empleado;
				$data2['estado'] = "sin registrar";
				$this->db->insert('asistencia_empleado', $data2);
			}

			return true;

		}

		return false;
	}

	public function updateAsistencia($items_usuario, $id_asistencia){
		foreach ($items_usuario as $key => $value) {
			$this->db->set('estado', $value[0]);
			$this->db->set('motivo', $value[1]=='' ? null : $value[1]);
			$this->db->where('id_empleado', $value[2]);
			$this->db->where('id_asistencia', $id_asistencia);
			$this->db->update('asistencia_empleado');
		}
		return true;
	}

	public function finalizarAsistencia($id_asistencia){
		$this->db->set('estado', 'finalizado');
		$this->db->where('id_asistencia', $id_asistencia);
		return $this->db->update('asistencia');
	}

	public function getPersonalAsistencia($id_factura){
		$datos = $this->db->select('fecha_inicio, fecha_final, id_usuario')->from('factura')->where('id_factura', $id_factura)->get()->result();
		$consulta = $this->db->select('asistencia.fecha, asistencia_empleado.estado, motivo_asistencia.nombre, motivo_asistencia.descuenta')->from('asistencia_empleado')->join('asistencia', 'asistencia.id_asistencia = asistencia_empleado.id_asistencia')->join('motivo_asistencia', 'motivo_asistencia.id_motivo = asistencia_empleado.motivo', 'left')->where('asistencia_empleado.id_empleado', $datos[0]->id_usuario)->where('asistencia.fecha >=', $datos[0]->fecha_inicio)->where('asistencia.fecha <=', $datos[0]->fecha_final)->order_by('fecha', 'asc')->get()->result();
		
		return $consulta;
	}

	public function nums_motivoAsistencias(){
		$this->db->where('estado', 'activo');
		$nums=$this->db->get('motivo_asistencia');

		return $nums->num_rows();
	}

	public function get_motivoAsistencias($valor , $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('*');
		$this->db->from('motivo_asistencia');
		$this->db->like('nombre' , $valor);
		$this->db->where('estado', 'activo');
		$this->db->order_by('nombre' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}

		$asistencias = $this->db->get();
		return $asistencias->result();
	}

	public function add_motivoAsistencia($datos){
		$this->db->insert('motivo_asistencia', $datos);

		return $this->db->affected_rows() > 0 ? true : false;
	}

	public function data_motivoAsistencia($id_asistencia){
		$this->db->where('id_motivo', $id_asistencia);
		$datos=$this->db->get('motivo_asistencia');

		return $datos->row();
	}

	public function update_motivoAsistencia($datos){
		$this->db->where('id_motivo', $datos['id_motivo']);
		$this->db->update('motivo_asistencia', $datos);

		return $this->db->affected_rows() > 0 ? true : false;
	}

	public function delete_motivoAsistencia($id_asistencia){
		$this->db->where('id_motivo', $id_asistencia);
		$this->db->update('motivo_asistencia', ['estado' => 'inactivo']);

		return $this->db->affected_rows() > 0 ? true : false;
	}

}
