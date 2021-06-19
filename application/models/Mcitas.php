<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcitas extends CI_Model {
	public function getCitas($id_fotografo){
		$consulta = $this->db->select('*')->from('citas')->where('id_fotografo', $id_fotografo)->get();

		if($consulta->num_rows() > 0) {
			return $consulta->result();
		}

		return false;
	}
	public function getCitasAdmin(){
		$consulta = $this->db->select('*')->from('citas')->get();

		if($consulta->num_rows() > 0) {
			return $consulta->result();
		}

		return false;
	}
    
    public function addCita($data){
        return $this->db->insert('citas', $data);
	}
	
	public function getDataCitas($id_fotografo, $fecha_inicio, $fecha_final, $valor, $inicio = FALSE, $registros_pagina = FALSE){
		$this->db->select('nombres,apellidos,documento,citas.*')->from('citas')->join('persona', 'citas.id_empleado = persona.id_persona')->where('id_fotografo', $id_fotografo)->where('estado !=', 'eliminado');
		if ($fecha_inicio != "") {
			$this->db->where('citas.fecha >=', $fecha_inicio);
		}
		if ($fecha_final != "") {
			$this->db->where('citas.fecha <=', $fecha_final);
		}
		$this->db->like('documento', $valor);
		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$this->db->order_by('fecha', 'DESC');
		$consulta = $this->db->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;
	}

	public function getDataCitasAdmin($fecha_inicio, $fecha_final, $valor, $inicio = FALSE, $registros_pagina = FALSE){
		$this->db->select('nombres,apellidos,documento,citas.*')->from('citas')->join('persona', 'citas.id_empleado = persona.id_persona')->where('estado !=', 'eliminado');
		if ($fecha_inicio != "") {
			$this->db->where('citas.fecha >=', $fecha_inicio);
		}
		if ($fecha_final != "") {
			$this->db->where('citas.fecha <=', $fecha_final);
		}
		$this->db->like('documento', $valor);
		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$this->db->order_by('fecha', 'DESC');
		$consulta = $this->db->get();

		if ($consulta->num_rows() > 0) {
			$this->db->select('nombres,apellidos,documento')->from('citas')->join('persona', 'citas.id_fotografo = persona.id_persona')->where('estado !=', 'eliminado');
			if ($fecha_inicio != "") {
				$this->db->where('citas.fecha >=', $fecha_inicio);
			}
			if ($fecha_final != "") {
				$this->db->where('citas.fecha <=', $fecha_final);
			}
			$this->db->like('documento', $valor);
			if($inicio !== FALSE && $registros_pagina !== FALSE) {
				$this->db->limit($registros_pagina , $inicio);
			}
			$this->db->order_by('fecha', 'DESC');
			$consulta2 = $this->db->get()->result();
			$data['fotografo'] = $consulta2;
			$data['empleado'] = $consulta->result();
			return $data;
		}
		return false;
	}

	public function getDataOnlyCita($id){
		return $this->db->select('*')->from('citas')->where('id_citas', $id)->get()->result();
	}

	public function editarCita($data){
		$this->db->where('id_citas', $data['id_citas']);
		return $this->db->update('citas', $data);
	}

	public function getCitasEmpleado($id_empleado){
		
		$consulta = $this->db->select('*')->from('citas')->where('id_empleado', $id_empleado)->where('estado !=', 'eliminado')->order_by('fecha', 'DESC')->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;

	}

	public function getCantCitasEmpleado($id_empleado){
		
		$consulta = $this->db->select('*')->from('citas')->where('id_empleado', $id_empleado)->where('estado', 'pendiente')->order_by('fecha', 'DESC')->get();

		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;

	}
	public function getCitaNotificacion($id_notificacion){
		return $this->db->select('citas.*, persona.documento, persona.nombres, persona.apellidos')->from('citas')->join('persona', 'persona.id_persona = citas.id_fotografo')->where('id_citas', $id_notificacion)->get()->result();
	}

	public function actualizarCita($fecha){
		$this->db->set('estado', 'antigua');
		$this->db->where('fecha <', $fecha);
		return $this->db->update('citas');
	}

	public function delete_cita($id){
		$this->db->set('estado', 'eliminado');
		$this->db->where('id_citas', $id);
		return $this->db->update('citas');
	}
}
