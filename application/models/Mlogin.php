<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlogin extends CI_Model {
	
	public function valid_login($data) {
		$this->db->select('id_usuario,correo,tipo_cuenta,estado,nombres,apellidos,foto');
		$this->db->from('usuarios');
		$this->db->join('persona', 'persona.id_persona = usuarios.id_persona');
		$this->db->where(['correo' => $data['email'] , 'clave' => $data['clave']]);
		$user = $this->db->get();

		if(!empty($user->row())) {
			return $user->row();
		}
		
		return false;
	}
}
