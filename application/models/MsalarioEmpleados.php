<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MsalarioEmpleados extends CI_Model {
	
	public function getSalarios() {
		$this->db->select('*');
		$this->db->from('sueldos_empleados');
		$salario = $this->db->get();

		if($salario->num_rows() > 0) {
			return $salario->result();
		}

		return false;
	}

	public function verSalarios($valor, $fecha_inicial, $fecha_final, $inicio = FALSE , $registros_pagina = FALSE){
		$this->db->select('*');
		$this->db->from('sueldos_empleados');
		$this->db->like('tipo_usuario' , $valor);
		if ($fecha_inicial != null) {
			$this->db->where('fecha_registrado >=', $fecha_inicial);
		}
		if ($fecha_final != null) {
			$this->db->where('fecha_registrado <=', $fecha_final);
		}
		$this->db->order_by('estado' , 'asc');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function addSalario($data){
		$verificacion = $this->db->select('id_sueldos_empleados')->from('sueldos_empleados')->where('tipo_usuario', $data['tipo_usuario'])->where('estado', 'activo')->get();

		if ($verificacion->num_rows() > 0) {
			$id = $verificacion->result();

			$this->db->set('estado', 'inactivo')->where('id_sueldos_empleados', $id[0]->id_sueldos_empleados)->update('sueldos_empleados');
		}

		return $this->db->insert('sueldos_empleados', $data);

	}

	public function generarFacturaEmpleados($data){
		$supervisores = $this->db->select('persona.id_persona')->from('persona')->join('usuarios', 'usuarios.id_persona = persona.id_persona')->where('usuarios.estado', 'activo')->where('tipo_cuenta', 'supervisor')->get();

		if ($supervisores->num_rows() > 0) {
			$adelantos_supervisor = [];
			$metas_supervisor = [];
			$acum = 0;

			foreach ($supervisores->result() as $key => $value) {
				$consulta_adelantos_supervisor = $this->db->select('id_adelanto, valor, id_empleado')->from('adelanto')->where('id_empleado', $value->id_persona)->where('estado', 'sin registrar')->get();
				if ($consulta_adelantos_supervisor->num_rows()>0) {
					$adelantos_supervisor[$acum] = $consulta_adelantos_supervisor->result();
					$acum = $acum+1;
				}
			}

			$acum = 0;
			foreach ($supervisores->result() as $key => $value) {
				$consulta_metas_supervisor = $this->db->select('id_meta, num_horas, id_empleado')->from('metas')->where('id_empleado', $value->id_persona)->where('estado', 'sin registrar')->get();
				if ($consulta_metas_supervisor->num_rows() > 0) {
					$metas_supervisor[$acum] = $consulta_metas_supervisor->result();
					$acum = $acum+1;
				}
			}

			$sueldo_supervisor = $this->db->select('sueldo,id_sueldos_empleados')->from('sueldos_empleados')->where('tipo_usuario', 'supervisor')->where('estado', 'activo')->get()->result();

			

			foreach ($supervisores->result() as $i => $valor_s) {
				$aux_adelanto = 0;
				$datos_insert = [];
				$aux_cant_horas = 0;
				$datos_insert['descuento'] = 0;
				foreach ($adelantos_supervisor as $j => $valor_a) {
					foreach ($adelantos_supervisor[$j] as $k => $valor_l) {
						if ($valor_s->id_persona == $valor_l->id_empleado) {
							$aux_adelanto = $valor_l->id_adelanto;
							$datos_insert['descuento'] = $datos_insert['descuento']+$valor_l->valor;
						}
					}
				}
				foreach ($metas_supervisor as $a => $valor_m) {
					foreach ($metas_supervisor[$a] as $s => $valor_q) {
						if ($valor_q->id_empleado == $valor_s->id_persona) {
						 	$aux_cant_horas = $valor_q->num_horas;
						 	$datos_insert['id_meta'] = $valor_q->id_meta;
						 } 
						

					}
				}

				$datos_insert['id_empleado'] = $valor_s->id_persona;
				$datos_insert['id_administrador'] = $data['id_administrador'];
				$datos_insert['id_sueldo'] = $sueldo_supervisor[0]->id_sueldos_empleados;
				$num_horas_empleados = $this->db->select_sum('cantidad_horas')->from('registro_horas')->where('id_supervisor', $valor_s->id_persona)->where('fecha_registro <=', $data['fecha_final'])->where('fecha_registro >=', $data['fecha_inicial'])->get()->result();

				if (empty($num_horas_empleados[0]->cantidad_horas)) {
					$datos_insert['cant_horas'] = 0;
					$datos_insert['estado_meta'] = "incompleta";
				}else{
					if ($num_horas_empleados[0]->cantidad_horas >= $aux_cant_horas) {
						$datos_insert['cant_horas'] = $num_horas_empleados[0]->cantidad_horas;
						$datos_insert['estado_meta'] = "completada";
					}else{
						$datos_insert['cant_horas'] = $num_horas_empleados[0]->cantidad_horas;
						$datos_insert['estado_meta'] = "incompleta";
					}
				}

				if ($datos_insert['estado_meta'] == "completada") {
					$valor_dolar = $this->db->select('valor_dolar')->where('estado', 'activo')->from('dolar')->get()->result();

					$datos_insert['total_comision'] = ($datos_insert['cant_horas'] * $valor_dolar[0]->valor_dolar)*0.015;
					
				}else{
					$datos_insert['total_comision'] = 0;
				}

				$datos_insert['total_paga'] = ($sueldo_supervisor[0]->sueldo+$datos_insert['total_comision'])-$datos_insert['descuento'];
				$datos_insert['fecha_inicial'] = $data['fecha_inicial']; 
				$datos_insert['fecha_final'] = $data['fecha_final'];
				$datos_insert['estado_factura'] = "sin registrar";

				

				$this->db->insert('factura_supervisor', $datos_insert);

				$id = $this->db->insert_id();

				if (!$aux_adelanto == 0) {
					$this->db->set('id_factura_supervisor', $id)->set('estado', 'registrado')->where('id_empleado', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->update('adelanto');
				}

				$this->db->set('estado', 'registrado')->where('id_empleado', $valor_s->id_persona)->update('metas');
			}
			return true;
		}
		return false;
	}

	public function generarFacturaGeneral($data){
		$empleados = $this->db->select('persona.id_persona, usuarios.tipo_cuenta')
		->from('persona')->join('usuarios', 'usuarios.id_persona = persona.id_persona')
			->where('estado', 'activo')
			->where('tipo_cuenta', 'administrador')
			->or_where('tipo_cuenta', 'talento humano')
			->or_where('tipo_cuenta', 'tecnico sistemas')
			->or_where('tipo_cuenta', 'servicios generales')
			->or_where('tipo_cuenta', 'psicologa')
			->or_where('tipo_cuenta', 'operario de mantenimiento')
			->or_where('tipo_cuenta', 'maquillador')
			->or_where('tipo_cuenta', 'fotografo')
			->or_where('tipo_cuenta', 'community manager')
			->or_where('tipo_cuenta', 'operativo')
			->or_where('tipo_cuenta', 'supervisor de los monitores')
			->get();

		if ($empleados->num_rows() > 0) {
			$adelantos_general = [];
			$metas_supervisor = [];
			$acum = 0;
			$insert_data = [];

			foreach ($empleados->result() as $key => $value) {
				$sueldo_general = 0;
				$adelanto = 0;
				$id_adelanto = 0;
				$consulta_adelantos = $this->db->select_sum('valor')->from('adelanto')->where('id_empleado', $value->id_persona)->where('estado', 'sin registrar')->get()->result();
				$adelanto = 0;
				if (!empty($consulta_adelantos[0]->valor)) {
					$adelanto = $consulta_adelantos[0]->valor;
				}
				if ($value->tipo_cuenta == "administrador") {
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'administrador')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "talento humano"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'talento humano')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "tecnico sistemas"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'tecnico sistemas')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "servicios generales"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'servicios generales')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "psicologa"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'psicologa')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "operario de mantenimiento"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'operario de mantenimiento')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "maquillador"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'maquillador')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "fotografo"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'fotografo')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "community manager"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'community manager')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "operativo"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'operativo')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "supervisor de los monitores"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'supervisor de los monitores')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}

				$insert_data['id_empleado'] = $value->id_persona;
				$insert_data['descuentos'] = $adelanto;
				$insert_data['total_a_pagar'] = $sueldo_general-$adelanto;
				$insert_data['fecha_inicial'] = $data['fecha_inicial'];
				$insert_data['fecha_final'] = $data['fecha_final'];
				$insert_data['estado'] = "sin registrar";

				$this->db->insert('factura_general', $insert_data);

				$id = $this->db->insert_id();
				$this->db->set('id_factura_general', $id)->set('estado', 'registrado')->where('id_empleado', $insert_data['id_empleado'])->where('estado', 'sin registrar')->update('adelanto');
			}

			return true;
		}
		return false;
	}
}
