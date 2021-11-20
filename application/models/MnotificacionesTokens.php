<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MnotificacionesTokens extends CI_Model {

	public function store($data){
		return $this->db->insert('notificaciones_tokens', $data);
	}
}
