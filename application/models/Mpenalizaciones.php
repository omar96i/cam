<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpenalizaciones extends CI_Model {
	public function getPenalizaciones() {
		$this->db->select('*');
		$this->db->from('penalizaciones');
		$this->db->where('estado', 'activo');
		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}

	public function get_penalizaciones() {
		$this->db->select('*');
		$this->db->from('penalizaciones');
		$this->db->where('estado', 'activo');
		$this->db->order_by('nombre_penalizacion' , 'DESC');

		$penalizaciones = $this->db->get();

		if($penalizaciones->num_rows() > 0) {
			return $penalizaciones->result();
		}

		return false;

	}

	public function addPenalizacion($data){
		return $this->db->insert('penalizaciones', $data);
	}

	public function updatePenalizacion($data){
		$this->db->where('id_penalizacion', $data['id_penalizacion']);
		return $this->db->update('penalizaciones', $data);
	}

	public function dataPenalizacion($id_penalizacion){
		$this->db->select('*');
		$this->db->from('penalizaciones');
		$this->db->where('id_penalizacion', $id_penalizacion);
		$penalizaciones = $this->db->get();

		if($penalizaciones->num_rows() > 0) {
			return $penalizaciones->result();
		}

		return false;
	}

	public function deletePenalizacion($id_penalizacion){
		$this->db->set('estado', 'inactivo');
		$this->db->where('id_penalizacion', $id_penalizacion);
		return $this->db->update('penalizaciones');
	}

	public function addPenalizacionEmpleado($data){
		return $this->db->insert('empleado_penalizacion', $data);
	}

	public function dataPenalizacionesEmpleado($id_empleado){
		$this->db->select('empleado_penalizacion.estado, penalizaciones.nombre_penalizacion, empleado_penalizacion.descripcion, empleado_penalizacion.fecha_registrado');
		$this->db->from('empleado_penalizacion');
		$this->db->join('penalizaciones', 'penalizaciones.id_penalizacion = empleado_penalizacion.id_penalizacion');
		$this->db->where('empleado_penalizacion.estado', 'sin registrar');
		$this->db->where('id_empleado', $id_empleado);
		$penalizaciones = $this->db->get();

		if($penalizaciones->num_rows() > 0) {
			return $penalizaciones->result();
		}

		return false;

	}

	public function getPenalizacionesUsuario($valor ,$id_usuario, $inicio = FALSE , $registros_pagina = FALSE){
		$this->db->select('*');
		$this->db->from('empleado_penalizacion');
		$this->db->join('penalizaciones', 'penalizaciones.id_penalizacion = empleado_penalizacion.id_penalizacion');
		$this->db->like('nombre_penalizacion' , $valor);
		$this->db->where('empleado_penalizacion.id_empleado', $id_usuario);
		$this->db->where('empleado_penalizacion.estado', 'sin registrar');
		$this->db->order_by('nombre_penalizacion' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$penalizaciones = $this->db->get();

		if($penalizaciones->num_rows() > 0) {
			return $penalizaciones->result();
		}

		return false;
	}

	public function getDataPenalizacion($id_penalizacion){
		$this->db->select('*');
		$this->db->from('empleado_penalizacion');
		$this->db->join('penalizaciones', 'empleado_penalizacion.id_penalizacion = penalizaciones.id_penalizacion');
		$this->db->join('persona', 'persona.id_persona = empleado_penalizacion.id_empleado');
		$this->db->where('id_empleado_penalizacion', $id_penalizacion);
		$penalizaciones = $this->db->get();

		if($penalizaciones->num_rows() > 0) {
			return $penalizaciones->result();
		}

		return false;
	}

	public function storePenalizacion($data){
		$this->db->select('puntos');
		$this->db->from('penalizaciones');
		$this->db->where('id_penalizacion', $data['id_penalizacion']);
		$consult = $this->db->get();
		$datos = $consult->result();

		$this->db->where('id_empleado_penalizacion', $data['id_empleado_penalizacion']);
		return $this->db->update('empleado_penalizacion', ['id_penalizacion' => $data['id_penalizacion'], 'puntos' => $datos[0]->puntos, 'descripcion' => $data['descripcion'], 'fecha_registrado' => $data['fecha_registrado']]);
	}

	public function getPenalizacionesUsuarioNew($valor ,$id_usuario, $inicio = FALSE , $registros_pagina = FALSE){
		$this->db->select('*');
		$this->db->from('empleado_penalizacion');
		$this->db->join('penalizaciones', 'penalizaciones.id_penalizacion = empleado_penalizacion.id_penalizacion');
		$this->db->like('nombre_penalizacion' , $valor);
		$this->db->where('empleado_penalizacion.id_empleado', $id_usuario);
		$this->db->where('empleado_penalizacion.estado', 'sin registrar');
		$this->db->order_by('nombre_penalizacion' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$penalizaciones = $this->db->get();

		if($penalizaciones->num_rows() > 0) {
			return $penalizaciones->result();
		}

		return false;
	}

}
