<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mregistrohoras extends CI_Model {
	
	public function getHorasEmpleado($id_empleado) {
		$this->db->select('registro_horas.*');
		$this->db->from('registro_horas');
		$this->db->join('persona', 'persona.id_persona = registro_horas.id_empleado');
		$this->db->join('persona_pagina', 'persona_pagina.id_persona = persona.id_persona');
		$this->db->where('persona_pagina.estado', 'activo');


		$this->db->where('id_empleado', $id_empleado);
		
		$usuarios = $this->db->get();
		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getNumHoras($id_usuario){
		//tokens validados
		$this->db->select_sum('cantidad_horas');
		$this->db->where(['id_empleado' => $id_usuario, 'estado_registro' => 'verificado', 'id_factura' => null]);
		$consulta['verificados']=$this->db->get('registro_horas')->row();

		//tokens por validar
		$this->db->select_sum('cantidad_horas');
		$this->db->where(['id_empleado' => $id_usuario, 'estado_registro' => 'sin registrar']);
		$consulta['por_verificar']=$this->db->get('registro_horas')->row();

		return $consulta;
	}

	public function verificarHoras($data){
		
		$this->db->set('estado_registro', 'verificado');
		$this->db->where('fecha_registro >=', $data['fecha_inicial']);
		$this->db->where('fecha_registro <=', $data['fecha_final']);
		$this->db->where('id_empleado', $data['id_usuario']);
		$this->db->where('estado_registro', 'sin registrar');
		return $this->db->update('registro_horas');

	}

	public function getHoras($id_usuario) {
		$this->db->select('paginas.url_pagina, registro_horas.*');
		$this->db->from('registro_horas');
		$this->db->join('paginas', 'paginas.id_pagina = registro_horas.id_pagina');
		$this->db->where('registro_horas.id_empleado', $id_usuario);
		$this->db->where('registro_horas.estado_registro', 'verificado');
		$this->db->order_by('estado_registro' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getHorasUsuario($id_usuario) {
		$this->db->select('paginas.url_pagina, registro_horas.*, persona_pagina.*');
		$this->db->from('registro_horas');
		$this->db->join('paginas', 'paginas.id_pagina = registro_horas.id_pagina');
		$this->db->join('persona_pagina', 'persona_pagina.id_pagina = paginas.id_pagina');
		$this->db->where('persona_pagina.estado', 'activo');
		$this->db->where('persona_pagina.id_persona', $id_usuario);
		$this->db->where('registro_horas.id_empleado', $id_usuario);
		
		$this->db->order_by('estado_registro' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function addHoras($data){
		$this->db->insert('registro_horas', $data);
		if ($this->db->affected_rows()>0) {
			$id = $this->db->insert_id();
			return $id;
		}
		return false;
	} 

	public function dataregistro($id_registro){
		$this->db->select('*');
		$this->db->from('registro_horas');
		$this->db->where('id_registro_horas', $id_registro);
		$registros = $this->db->get();

		if($registros->num_rows() > 0) {
			return $registros->result();
		}

		return false;
	}

	public function editarregistro($data, $id_registro){
		$this->db->where('id_registro_horas', $id_registro);
		return $this->db->update('registro_horas', $data);
	}

	public function t_h_get_horas_usuario($id_usuario, $tipo) {
		$this->db->select('paginas.url_pagina, registro_horas.*, persona_pagina.*');
		$this->db->from('registro_horas');
		$this->db->join('paginas', 'paginas.id_pagina = registro_horas.id_pagina');
		$this->db->join('persona_pagina', 'persona_pagina.id_persona = registro_horas.id_empleado');
		$this->db->where('persona_pagina.estado', 'activo');
		if($tipo == "sin_registrar"){
			$this->db->where('registro_horas.estado_registro', 'sin registrar');
		}else if($tipo == "verificados"){
			$this->db->where('registro_horas.estado_registro', 'verificado');
		}else if($tipo == "registrados"){
			$this->db->where('registro_horas.estado_registro', 'registrado');
		}
		$this->db->where('registro_horas.id_empleado', $id_usuario);
		$this->db->order_by('estado_registro' , 'DESC');

		$registros = $this->db->get();

		if($registros->num_rows() > 0) {
			return $registros->result();
		}

		return false;
	}

	public function t_h_registro_horas_null($id_empleado){
		$this->db->select('*');
		$this->db->from('registro_horas');
		$this->db->where('id_empleado', $id_empleado);
		$this->db->where('estado_registro', 'sin registrar');

		$registros = $this->db->get();

		if($registros->num_rows() > 0) {
			return $registros->num_rows();
		}else{
			$registros = 0;
			return $registros;
		}
	}

	public function t_h_registro_horas_factura($id_factura){
		$this->db->select('*');
		$this->db->from('registro_horas');
		$this->db->where('id_factura', $id_factura);
		$registros = $this->db->get();

		if($registros->num_rows() > 0) {
			return $registros->result();
		}

		return false;
	}

	public function verificarTokens($data){
		$registros = $this->db->select('*')->from('registro_horas')
							->where('id_empleado', $data['id_empleado'])
							->where('id_pagina', $data['id_pagina'])
							->where('fecha_registro', $data['fecha_registro'])
							->get();

		if($registros->num_rows() > 0){
			return true;
		}

		return false;

	}

	public function getDataTableFiltro($data){
		$this->db->select('paginas.url_pagina, registro_horas.*, persona.*');
		$this->db->from('registro_horas');
		$this->db->join('persona', 'persona.id_persona = registro_horas.id_empleado');
		$this->db->join('paginas', 'paginas.id_pagina = registro_horas.id_pagina');
		if($data['id_modelo'] != "false"){
			$this->db->where('registro_horas.id_empleado', $data['id_modelo']);
		}
		if($data['id_monitor'] != "false"){
			$this->db->where('registro_horas.id_supervisor', $data['id_monitor']);
		}
		if($data['estado_registro'] != "false"){
			$data['estado_registro'] = ($data['estado_registro'] == "sin_registrar")? "sin registrar": $data['estado_registro'];
			$this->db->where('registro_horas.estado_registro', $data['estado_registro']);
		}

		if($data['fecha_inicial'] != ""){
			$this->db->where('registro_horas.fecha_registro >=', $data['fecha_inicial']);
		}
		if($data['fecha_final'] != ""){
			$this->db->where('registro_horas.fecha_registro <=', $data['fecha_final']);
		}

		$registros = $this->db->get();

		if($registros->num_rows() > 0) {
			return $registros->result();
		}

		return false;
	}

	public function getDatosRegistros($id){
		$this->db->select('*');
		$this->db->from('registro_horas');
		$this->db->where('id_registro_horas', $id);
		$arreglo = $this->db->get();

		if($arreglo->num_rows() > 0) {
			return $arreglo->result();
		}

		return false;
	}

	public function getHorasUsuariosAdmin($id_empleado){
		$consulta_paginas = $this->db->select('*')->from('persona_pagina')->join('paginas', 'paginas.id_pagina = persona_pagina.id_pagina')->where('persona_pagina.estado', 'activo')->where('id_persona', $id_empleado)->get()->result();
		$datos = [];

		foreach ($consulta_paginas as $key => $value) {
			$data = [];
			$consulta = $this->db->select_sum('cantidad_horas')->from('registro_horas')->where('id_pagina', $value->id_pagina)->where('id_empleado', $id_empleado)->where('estado_registro', 'verificado')->get()->result();
			if (empty($consulta[0]->cantidad_horas)) {
				$data['url_pagina'] = $value->url_pagina;
				$data['valor'] = 0;
			}else{
				$data['url_pagina'] = $value->url_pagina;
				$data['valor'] = $consulta[0]->cantidad_horas;
			}
			$datos[$key] = $data;
		}

		return $datos;

	}

	public function falta_validarTokens($datos){
		$this->db->select('id_empleado');
		$this->db->where('estado_registro', 'sin registrar');
		$this->db->where('id_empleado', $datos['id_persona']);
		$this->db->where('fecha_registro >=', $datos['fecha_inicial']);
		$this->db->where('fecha_registro <=', $datos['fecha_final']);
		$datos=$this->db->get('registro_horas');

		return $datos->num_rows() > 0 ? true : false;
	}


	/// EDITAR HORAS NO SIRVE MOMENTANEAMENTE ///
	// public function updateRegistroHoras($data,$data2,$id_factura){
	// 	// DOLAR INICIO //
	// 	$this->db->select('dolar.*');
	// 	$this->db->from('factura');
	// 	$this->db->join('dolar', 'dolar.id_dolar = factura.id_dolar');
	// 	$this->db->where('factura.id_factura', $id_factura);
	// 	$array = $this->db->get();
	// 	$array2 = $array->result();
	// 	$valor_dolar = $array2[0]->valor_dolar;

	// 	// DOLAR FIN //
	// 	// UPDATE REGISTROS HORAS INICIO //
	// 	$this->db->where('id_registro_horas', $data2['id_registro_horas']);
	// 	$this->db->update('registro_horas', $data);
	// 	// UPDATE REGISTROS HORAS FIN //
	// 	if ($this->db->affected_rows() > 0) {
	// 		// UPDATE FACTURA INICIO //
	// 		$this->db->select('*');
	// 		$this->db->from('registro_horas');
	// 		$this->db->where('id_factura', $id_factura);
	// 		$arreglo = $this->db->get();
	// 		$descuento = 0;
	// 		$cant_horas = 0;
	// 		foreach ($arreglo->result() as $key => $value) {
	// 			$descuento = $descuento + $value->descuento;
	// 			$cant_horas = $cant_horas + $value->cantidad_horas;
	// 		}

	// 		$total = ($cant_horas*$valor_dolar)-$descuento;
			
	// 		$data_update_factura['descuento'] = $descuento;
	// 		$data_update_factura['total_horas'] = $cant_horas;
	// 		$data_update_factura['total_a_pagar'] = $total;
	// 		$this->db->where('id_factura', $id_factura);
	// 		return $this->db->update('factura', $data_update_factura);

	// 		// UPDATE FACTURA FIN //
	// 	}
	// }
}
