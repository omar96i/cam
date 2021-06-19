<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masignaciones extends CI_Model {
	
	public function getrelaciones() {
		$this->db->select('persona.*, tipo_cuenta');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('tipo_cuenta', 'supervisor');
		$this->db->where('estado', 'activo');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getsupervisor($valor , $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('persona.*, correo, tipo_cuenta');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->like('nombres' , $valor);
		$this->db->where('tipo_cuenta', 'supervisor');
		$this->db->order_by('id_persona' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getusuarios($id_supervisor){
		$this->db->select('persona.*');
		$this->db->from('empleado_supervisor');
		$this->db->join('persona', 'persona.id_persona = empleado_supervisor.id_empleado');
		$this->db->where('id_supervisor', $id_supervisor);
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getempleados(){
		$this->db->select('persona.*');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('tipo_cuenta', 'empleado');
		$this->db->where('estado', 'activo');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			$lista_usuarios = $usuarios->result();
			$acum = 0;
			$datos = [];
			foreach ($lista_usuarios as $key => $value) {
				$this->db->select('*');
				$this->db->from('empleado_supervisor');
				$this->db->where('id_empleado', $value->id_persona);
				$this->db->where('estado', 'activo');
				$usuario = $this->db->get();
				
				if (!$usuario->num_rows()>0) {
					$datos[$acum] = $lista_usuarios[$key];
					$acum = $acum+1;
				}
			}

			return $datos;
		}

		return false;
	}

	public function obtenersupervisor($id_supervisor) {
		$this->db->select('persona.*, tipo_cuenta');
		$this->db->from('persona');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('tipo_cuenta', 'supervisor');
		$this->db->where('persona.id_persona', $id_supervisor);
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}


	public function asignaciones($id_supervisor){
		$this->db->select('persona.*');
		$this->db->from('empleado_supervisor');
		$this->db->join('usuarios', 'usuarios.id_persona = empleado_supervisor.id_empleado');
		$this->db->where('id_supervisor', $id_supervisor);
		$this->db->where('estado', 'activo');
		$lista = $this->db->get();
		if($lista->num_rows() > 0) {
			return $lista->result();
		}

		return false;

	}


	public function addasignacion($data){
		$this->db->insert('empleado_supervisor', $data);

		if ($this->db->affected_rows()>0){
			return true;
		}

		return false;
	}

	public function getasignacionsupervisor($valor ,$id_supervisor , $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('persona.*');
		$this->db->from('empleado_supervisor');
		$this->db->join('persona', 'persona.id_persona = empleado_supervisor.id_empleado');
		$this->db->like('nombres' , $valor);
		$this->db->where('id_supervisor', $id_supervisor);
		$this->db->where('empleado_supervisor.estado', 'activo');

		$this->db->order_by('id_persona' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function delete_empleado($data){
		$this->db->set('estado', 'inactivo');
		$this->db->where('id_empleado' , $data['id_persona']);
		$this->db->where('id_supervisor' , $data['id_supervisor']);
		$this->db->update('empleado_supervisor');

		if ($this->db->affected_rows()>0) {
				return true;
		}
		return false;
		
	}

	public function obtener_supervisor($id_usuario){
		$this->db->select('persona.*');
		$this->db->from('empleado_supervisor');
		$this->db->join('persona', 'empleado_supervisor.id_supervisor = persona.id_persona');
		$this->db->where('empleado_supervisor.id_empleado', $id_usuario);
		$this->db->where('empleado_supervisor.estado', 'activo');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;

	}

	public function getOnlyEmpleados($id_supervisor){
		$this->db->select('persona.*');
		$this->db->from('empleado_supervisor');
		$this->db->join('persona', 'persona.id_persona = empleado_supervisor.id_empleado');
		$this->db->where('id_supervisor', $id_supervisor);
		$this->db->where('estado', 'activo');

		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;


	}

	public function getAllUsuarios($valor , $id_usuario , $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('persona.*');
		$this->db->from('empleado_supervisor');
		$this->db->join('persona', 'persona.id_persona = empleado_supervisor.id_empleado');
		$this->db->like('persona.id_persona' , $valor);
		$this->db->where('empleado_supervisor.estado', 'activo');
		$this->db->where('empleado_supervisor.id_supervisor', $id_usuario);
		$this->db->order_by('persona.id_persona' , 'DESC');

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
