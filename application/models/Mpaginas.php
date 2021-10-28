<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpaginas extends CI_Model {

	public function getpaginas() {
		$this->db->select('*');
		$this->db->from('paginas');
		$this->db->where('estado', 'activo');
		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}
	
	public function getpages() {
		$this->db->select('*');
		$this->db->from('paginas');
		$this->db->where('estado', 'activo');
		$this->db->order_by('url_pagina' , 'DESC');
		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}

	public function registrarpagina($data){
		$this->db->insert('paginas', $data);
		if ($this->db->affected_rows()>0) {
			return true;
		}
		return false;
	}

	public function datapaginas($id_pagina) {
		$this->db->select('*');
		$this->db->from('paginas');
		$this->db->where('id_pagina' , $id_pagina);
		$pagina = $this->db->get();

		if($pagina->num_rows() > 0) {
			return $pagina->row();
		}

		return false;
	}

	public function updatepaginas($data, $id_pagina){
		$this->db->where('id_pagina', $id_pagina);
		return $this->db->update('paginas', ['url_pagina' => $data['url_pagina'], 'estado' => $data['estado']]);
	}
	
	public function getpaginasactivas() {
		$this->db->select('*');
		$this->db->from('paginas');
		$this->db->where('estado', 'activo');
		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}

	public function editPagesAsignados($data, $id_relacion){
		$this->db->where('id_persona_pag', $id_relacion);
		return $this->db->update('persona_pagina', $data);
	}

	public function getDataEditPages($id_relacion){
		$this->db->select('correo, clave');
		$this->db->from('persona_pagina');
		$this->db->where('id_persona_pag', $id_relacion);
		$elementos = $this->db->get();

		if($elementos->num_rows() > 0) {
			return $elementos->result();
		}

		return false;
	}

	public function asignarpage($data){
		$this->db->select('*');
		$this->db->from('persona_pagina');
		$this->db->where('id_persona', $data['id_persona']);
		$this->db->where('id_pagina', $data['id_pagina']);
		$this->db->where('persona_pagina.estado', 'activo');
		$arreglo = $this->db->get();
		if($arreglo->num_rows() > 0) {
			return false;
		}else{
			$this->db->insert('persona_pagina', $data);
			if ($this->db->affected_rows()>0) {
				return true;
			}
		}
		return false;
	}

	public function asignaciones($id_pagina){
		$this->db->select("persona.id_persona, persona.nombres, persona.apellidos, persona.documento, paginas.url_pagina, persona_pagina.*");
		$this->db->from('paginas');
		$this->db->join('persona_pagina', 'persona_pagina.id_pagina = paginas.id_pagina');
		$this->db->join('persona', 'persona.id_persona = persona_pagina.id_persona');
		$this->db->where('persona_pagina.estado', 'activo');
		$this->db->where('persona_pagina.id_pagina', $id_pagina);
		$lista = $this->db->get();
		if($lista->num_rows() > 0) {
			return $lista->result();
		}
		return false;
	}

	public function getasignaciones($id_pagina) {
		$this->db->select("persona.id_persona, persona.nombres, persona.apellidos, persona.documento, paginas.url_pagina, persona_pagina.*");
		$this->db->from('paginas');
		$this->db->join('persona_pagina', 'persona_pagina.id_pagina = paginas.id_pagina');
		$this->db->join('persona', 'persona.id_persona = persona_pagina.id_persona');
		$this->db->where('persona_pagina.estado', 'activo');
		$this->db->where('persona_pagina.id_pagina', $id_pagina);
		$this->db->order_by('persona.id_persona' , 'DESC');

		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}

	public function getPagesUsuario($id_usuario){
		$this->db->select('paginas.*, persona_pagina.correo, persona_pagina.clave');
		$this->db->from('persona_pagina');
		$this->db->join('paginas', 'persona_pagina.id_pagina = paginas.id_pagina');
		$this->db->where('persona_pagina.id_persona', $id_usuario);
		$this->db->where('persona_pagina.estado', 'activo');

		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}

	public function getPagesUsuarios($id_persona) {
		$this->db->select("paginas.*, persona_pagina.*");
		$this->db->from('persona_pagina');
		$this->db->join('paginas', 'paginas.id_pagina = persona_pagina.id_pagina');
		$this->db->where('persona_pagina.id_persona', $id_persona);
		$this->db->where('persona_pagina.estado', 'activo');
		$this->db->group_by('paginas.id_pagina');
		$this->db->order_by('paginas.url_pagina' , 'DESC');

		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}

	public function delete_relacion_pages($id){
		$this->db->where('id_persona_pag', $id);
		$this->db->set('estado', 'inactivo');
		return $this->db->update('persona_pagina');
	}
	
	public function verificarAsignacion($id){
		$this->db->select('*');
		$this->db->from('persona_pagina');
		$this->db->where('id_pagina', $id);
		$this->db->where('estado', 'activo');
		$paginas = $this->db->get();
		$arreglo = $paginas->result();
		if($paginas->num_rows() > 0) {
			$this->db->select('*');
			$this->db->from('persona');
			$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
			foreach ($arreglo as $key => $value) {
				$this->db->where('persona.id_persona !=',$value->id_persona);
			}
			$this->db->where('usuarios.tipo_cuenta', 'empleado');
			$this->db->where('usuarios.estado', 'activo');
			$usuarios = $this->db->get();
			if ($usuarios->num_rows() > 0) {
				return $usuarios->result();
			}
		}else{
			$this->db->select('persona.*');
			$this->db->from('persona');
			$this->db->join('usuarios', 'persona.id_persona = usuarios.id_persona');
			$this->db->where('usuarios.tipo_cuenta', 'empleado');
			$this->db->where('usuarios.estado', 'activo');
			$usuarios = $this->db->get();
			return $usuarios->result();
		}

		return false;
	}

	public function graficaConsulta($data){
		$consulta = $this->db->select('id_pagina')->from('paginas')->where('estado', 'activo')->get()->result();
		$items = [];
		$aux = 0;
		if (count($consulta)>0) {
			foreach ($consulta as $key => $value) {
				$this->db->select_sum('cantidad_horas')->select('url_pagina')->from('paginas')->join('registro_horas', 'registro_horas.id_pagina=paginas.id_pagina')->where('registro_horas.id_pagina', $value->id_pagina)->where('estado_registro !=', 'sin registrar');
				if ($data['fecha_inicial'] != "") {
					$this->db->where('fecha_registro >=', $data['fecha_inicial']);
				}
				if ($data['fecha_final'] != "") {
					$this->db->where('fecha_registro <=', $data['fecha_final']);
				}
				$datos = $this->db->get()->result();
				if ($datos[0]->url_pagina != null) {
					$items[$aux] = $datos;
					$aux = $aux+1;
				}
			}
		}
		return $items;
	}
}
