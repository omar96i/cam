<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musuarios extends CI_Model {

	public function getusuarios() {
		$this->db->select('persona.*, correo');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}
	public function getUser($id){
		return $this->db->select('persona.*')->from('persona')->where('id_persona', $id)->get()->result();
	}

	public function getTypeUser($id){
		return $this->db->select('tipo_cuenta')->from('usuarios')->where('id_usuario', $id)->get()->result();
	}

	public function getModelsMonitor($id){
		return $this->db->select('persona.id_persona, persona.nombres, persona.apellidos')->from('empleado_supervisor')->join('persona', 'persona.id_persona = empleado_supervisor.id_empleado')->where('id_supervisor', $id)->where('empleado_supervisor.estado', 'activo')->get()->result();
	}

	public function getMonitorUsers(){
		$this->db->select('persona.nombres, persona.apellidos, persona.id_persona, metas.*');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->join('metas', 'persona.id_persona = metas.id_empleado');
		$this->db->where('usuarios.estado', 'activo');
		$this->db->where('metas.estado', 'sin registrar');
		$this->db->where('usuarios.tipo_cuenta', 'supervisor');
		$usuarios = $this->db->get();
		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getUsuariosAdelantos(){
		$this->db->select('persona.*, usuarios.*');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.estado', 'activo');

		$this->db->order_by('tipo_cuenta' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getempleados() {
		$this->db->select('persona.*, correo');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('tipo_cuenta', 'empleado');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}
	public function getempleadosMetas() {
		////
		$this->db->select('persona.*, correo');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('tipo_cuenta', 'empleado');
		$this->db->where('usuarios.estado', 'activo');
		$usuarios = $this->db->get();
		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getusuary($tipo) {
		$this->db->select('persona.*, correo, tipo_cuenta');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.estado', $tipo);
		$this->db->where('tipo_cuenta !=', 'empleado');
		$this->db->order_by('tipo_cuenta' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function get_empleados() {
		$this->db->select('persona.*, correo, tipo_cuenta');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.estado', 'activo');
		$this->db->where('tipo_cuenta', 'empleado');
		$this->db->order_by('documento' , 'DESC');

		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function get_empleados_users($tipo) {
		$this->db->select('persona.*, correo, tipo_cuenta');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.estado', $tipo);
		$this->db->where('tipo_cuenta', 'empleado');
		$this->db->order_by('documento' , 'DESC');

		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getMonitor(){
		$this->db->select('persona.*, correo, tipo_cuenta');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.estado', 'activo');
		$this->db->where('tipo_cuenta', 'supervisor');
		$this->db->order_by('documento' , 'DESC');

		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function datausuarios($id_usuario) {
		$this->db->select('persona.*, correo, tipo_cuenta, clave, estado');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('persona.id_persona' , $id_usuario);
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->row();
		}

		return false;
	}

	public function updateusuarios($data, $data2) {

		$this->db->where('id_persona' , $data['id_persona']);
		$this->db->update('persona' , $data);

		$this->db->where('id_persona' , $data['id_persona']);
		
		return $this->db->update('usuarios' , $data2);
	}

	public function updatePersona($data){
		$this->db->where('id_persona' , $data['id_persona']);
		return $this->db->update('persona' , $data);
	}

	public function get_id($correo)	{
		$this->db->select('id_usuario, estado');
		$this->db->from('usuarios');
		$this->db->where('correo', $correo);
		$this->db->where('tipo_usuario', 'cliente');
		$datos=$this->db->get();
		return $datos->row();
	}

	public function registrarusuarios($data, $data2){
		$this->db->insert('persona', $data);
		if ($this->db->affected_rows()>0) {
			$data2['id_persona'] = $this->db->insert_id();
			$data2['id_usuario'] = $this->db->insert_id();
			$data2['estado'] = "activo";
			$this->db->insert('usuarios', $data2);
			if ($this->db->affected_rows()>0) {
				return true;
			}
		}
		return false;
	}

	public function verificarUsuario($correo){
		$this->db->select('*')->from('usuarios')->where('correo', $correo)->where('estado', 'activo');
		$find = $this->db->get();
		if($find->num_rows() > 0) {
			return true;
		}
		return false;
	}

	public function verificarPersona($documento){
		$this->db->select('*')->from('persona')->where('documento', $documento);
		$find = $this->db->get();
		if($find->num_rows() > 0) {
			return true;
		}
		return false;
	}

	public function getusuarioempleado(){
		$this->db->select('persona.*, correo, tipo_cuenta');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.tipo_cuenta' , 'empleado');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function t_h_get_empleados(){
		$this->db->select('persona.*');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.tipo_cuenta', 'empleado');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}
		return false;
	}

	public function t_h_ver_empleados() {
		$this->db->select('persona.*');
		$this->db->from('usuarios');
		$this->db->join('persona', 'persona.id_persona = usuarios.id_persona');
		$this->db->where('usuarios.tipo_cuenta', 'empleado');
		$this->db->where('usuarios.estado', 'activo');
		$this->db->order_by('id_persona' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getUsuariosFotografo(){
		$this->db->select('persona.id_persona, persona.documento, persona.nombres, persona.apellidos');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('tipo_cuenta', 'empleado');
		$this->db->where('estado', 'activo');
		$datos=$this->db->get();

		return $datos->result();
	}

	public function getUsuariosPsicologa(){
		$this->db->select('persona.id_persona, persona.documento, persona.nombres, persona.apellidos');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('estado', 'activo');
		$datos=$this->db->get();

		return $datos->result();
	}
	
	public function delete_usuario($id_usuario){
		$this->db->where('id_persona', $id_usuario);
		return $this->db->update('usuarios', ['estado' => 'inactivo']);
	}

	public function getDatosPDF($id_usuario){
		$this->db->select('persona.*, usuarios.tipo_cuenta, usuarios.created_at');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('persona.id_persona', $id_usuario);
		$datos=$this->db->get();
		return $datos->result();
	}

	public function getSueldoUsuario($tipo_usuario){
		$consulta = $this->db->select('sueldo')->from('sueldos_empleados')->where('tipo_usuario', $tipo_usuario)->where('estado', 'activo')->get();
		if($consulta->num_rows() > 0){
			return $consulta->result();
		}
		return false;
	}

	public function getDatosDescuentos(){
		$datos = $this->db->select('persona.*')->from('usuarios')
							->join('persona', 'persona.id_persona = usuarios.id_persona')
							->where('estado', 'activo')
							->get();
		return $datos->result();
	}

	public function getDatosAumentos(){
		$datos = $this->db->select('persona.*')->from('usuarios')
							->join('persona', 'persona.id_persona = usuarios.id_persona')
							->where('estado', 'activo')
							->get();
		return $datos->result();
	}
}
