<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Madelantos extends CI_Model {
	public function getAdelantos() {
		$this->db->select('*');
		$this->db->from('adelanto');
		$adelantos = $this->db->get();

		if($adelantos->num_rows() > 0) {
			return $adelantos->result();
		}

		return false;
	}

	public function getAdelantosSinVerificar() {
		$this->db->select('*');
		$this->db->from('adelanto');
		$this->db->where('estado', 'por verificar');
		$adelantos = $this->db->get();

		if($adelantos->num_rows() > 0) {
			return $adelantos->result();
		}

		return false;
	}

	public function addAdelanto($data){
		return $this->db->insert('adelanto', $data);
	}

	public function verificarAdelanto($data){
		$respuesta = $this->db->select('*')->from('adelanto')->where('id_empleado', $data['id_empleado'])->where('estado', 'por verificar')->get();
		if($respuesta->num_rows() > 0){
			return true;
		}
		return false;
	}

	public function getLastAdelanto($id_empleado){
		$respuesta = $this->db->select('*')->from('adelanto')->where('id_empleado', $id_empleado)->where('estado', 'por verificar')->get();
		if($respuesta->num_rows() > 0){
			return $respuesta->result();
		}
		return false;
	}

	public function get_adelantos() {
		$this->db->select('adelanto.*, persona.*');
		$this->db->from('adelanto');
		$this->db->join('persona', 'persona.id_persona = adelanto.id_empleado');
		$this->db->where('adelanto.estado !=', 'por verificar');
		$this->db->order_by('adelanto.estado' , 'DESC');

		$adelantos = $this->db->get();

		if($adelantos->num_rows() > 0) {
			return $adelantos->result();
		}
		return false;
	}

	public function get_adelantos_sin_verificar() {
		$this->db->select('adelanto.*, persona.*');
		$this->db->from('adelanto');
		$this->db->join('persona', 'persona.id_persona = adelanto.id_empleado');
		$this->db->where('adelanto.estado', 'por verificar');
		$this->db->order_by('adelanto.estado' , 'DESC');

		$adelantos = $this->db->get();

		if($adelantos->num_rows() > 0) {
			return $adelantos->result();
		}
		return false;
	}

	public function dataAdelantos($id_adelanto){
		$this->db->select('*');
		$this->db->from('adelanto');
		$this->db->where('id_adelanto', $id_adelanto);

		$adelantos = $this->db->get();

		if($adelantos->num_rows() > 0) {
			return $adelantos->result();
		}

		return false;
	}

	public function getAdelantosEmpleado($id_empleado){
		$this->db->select('*');
		$this->db->from('adelanto');
		$this->db->where('id_empleado', $id_empleado);
		$this->db->where('estado', 'sin registrar');
		$consulta = $this->db->get();

		if ($consulta->num_rows()>0) {
			return $consulta->result();
		}
		return false;
	}

	public function updateAdelanto($data){
		$this->db->where('id_adelanto', $data['id_adelanto']);
		return $this->db->update('adelanto', $data);
	}

}
