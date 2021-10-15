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

	public function getSalarioTipoCuenta($tipo_cuenta){
		$this->db->select('sueldo');
		$this->db->from('sueldos_empleados');
		$this->db->where('tipo_usuario', $tipo_cuenta);
		$this->db->where('estado', 'activo');
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
		// Consultamos a los supervisores 
		$supervisores = $this->db->select('persona.id_persona')->from('persona')->join('usuarios', 'usuarios.id_persona = persona.id_persona')->where('usuarios.estado', 'activo')->where('tipo_cuenta', 'supervisor')->get();
		if ($supervisores->num_rows() > 0) {

			// sueldo del supervisor
			$sueldo_supervisor = $this->db->select('sueldo,id_sueldos_empleados')->from('sueldos_empleados')->where('tipo_usuario', 'supervisor')->where('estado', 'activo')->get()->result();

			foreach ($supervisores->result() as $i => $valor_s) {

				// CONSULTAMOS SI EL SUPERVISOR TIENE META SI NO TIENE META NO SE LE PAGA
				$meta = $this->db->select('*')->from('metas')->where('id_empleado', $valor_s->id_persona)->where('estado', 'sin registrar')->get();
				if($meta->num_rows() > 0){
					$meta = $meta->result();
				}else{
					continue;
				}
				$aux_adelanto = 0;
				$aux_descuentos = 0;
				$datos_insert = [];
				$datos_insert['descuento'] = 0;

				// CONSULTAMOS ADELANTOS
				$adelantos = $this->db->select('id_adelanto, valor')->from('adelanto')->where('id_empleado', $valor_s->id_persona)->where('estado', 'sin registrar')->where('fecha_registrado >=', $data['fecha_inicial'])->where('fecha_registrado <=', $data['fecha_final'])->get();
				if($adelantos->num_rows() > 0){
					foreach ($adelantos->result() as $key => $adelanto) {
						$aux_adelanto = $aux_adelanto+$adelanto->valor;
					}
				}

				// CONSULTAMOS DESCUENTOS DE DIAS

				$descuentos = $this->db->select('id, valor')->from('dias_descontados')->where('id_persona', $valor_s->id_persona)->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->where('estado', 'sin registrar')->get();
				if($descuentos->num_rows() > 0){
					foreach ($descuentos->result() as $key => $descuento) {
						$aux_descuentos = $aux_descuentos+$descuento->valor;
					}
				}
				
				$aux_horas_total = 0;
				// CONSULTAMOS LAS HORAS DE LAS MODELOS
				$modelos = $this->db->select('id_empleado')->from('empleado_supervisor')->where('id_supervisor', $valor_s->id_persona)->where('estado', 'activo')->get();
				if($modelos->num_rows() > 0){
					foreach ($modelos->result() as $key => $modelo) {
						$nomina_modelo = $this->db->select('total_horas')->from('factura')->where('id_usuario', $modelo->id_empleado)->where('fecha_inicio >=', $data['fecha_inicial'])->where('fecha_inicio <=', $data['fecha_final'])->where('id_factura_supervisor', null)->get();
						if($nomina_modelo->num_rows()>0){
							$nomina_modelo = $nomina_modelo->result();
							$aux_horas_total = $aux_horas_total+$nomina_modelo[0]->total_horas;
						}
					}
				}
				
				// VERIFICAMOS SI EL SUPERVISOR CUMPLE LAS METAS DE HORAS

				if($aux_horas_total >= $meta[0]->num_horas){
					$datos_insert['estado_meta'] = "completada";
				}else{
					$datos_insert['estado_meta'] = "incompleta";
				}
				
				//////////////////////////////////////////

				// SI CUMPLE LA META SE LE DA COMISION
				if ($datos_insert['estado_meta'] == "completada") {
					$valor_dolar = $this->db->select('valor_dolar')->where('estado', 'activo')->from('dolar')->get()->result();
					$datos_insert['total_comision'] = ((($aux_horas_total*1.5)/100)*0.03)*$valor_dolar[0]->valor_dolar;
				}else{
					$datos_insert['total_comision'] = 0;
				}

				/////////////////////////////////////////////////
				//INSERTAMOS LOS DATOS
				$datos_insert['descuento'] = $aux_descuentos+$aux_adelanto;
				$datos_insert['cant_horas'] = $aux_horas_total;
				$datos_insert['id_empleado'] = $valor_s->id_persona;
				$datos_insert['id_administrador'] = $data['id_administrador'];
				$datos_insert['id_sueldo'] = $sueldo_supervisor[0]->id_sueldos_empleados;
				$datos_insert['id_meta'] = $meta[0]->id_meta;
				$datos_insert['total_paga'] = ($sueldo_supervisor[0]->sueldo+$datos_insert['total_comision'])-$datos_insert['descuento'];
				$datos_insert['fecha_inicial'] = $data['fecha_inicial']; 
				$datos_insert['fecha_final'] = $data['fecha_final'];
				$datos_insert['estado_factura'] = "sin registrar";

				$this->db->insert('factura_supervisor', $datos_insert);

				$id = $this->db->insert_id();
				// VERIFICAMOS SI TENIA ADELANTOS, SI LO TENIA FINALIZAMOS EL DESCUENTO DEL ADELANTO
				if (!$aux_adelanto == 0) {
					$this->db->set('id_factura_supervisor', $id)->set('estado', 'registrado')->where('id_empleado', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->update('adelanto');
				}
				if(!$aux_descuentos == 0){
					$this->db->set('id_factura_supervisor', $id)->set('estado', 'registrado')->where('id_persona', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->update('dias_descontados');
				}
				// ASIGNAMOS LA NOMINA DEL SUPERVISOR A LA NOMINA DE LA MODELO

				$modelos = $this->db->select('id_empleado')->from('empleado_supervisor')->where('id_supervisor', $valor_s->id_persona)->where('estado', 'activo')->get();
				if($modelos->num_rows() > 0){
					foreach ($modelos->result() as $key => $modelo) {
						$nomina_modelo = $this->db->select('total_horas')->from('factura')->where('id_usuario', $modelo->id_empleado)->where('fecha_inicio >=', $data['fecha_inicial'])->where('fecha_inicio <=', $data['fecha_final'])->where('id_factura_supervisor', null)->get();
						if($nomina_modelo->num_rows()>0){
							$this->db->set('id_factura_supervisor', $id)->where('id_usuario', $modelo->id_empleado)->where('fecha_inicio >=', $data['fecha_inicial'])->where('fecha_inicio <=', $data['fecha_final'])->where('id_factura_supervisor', null)->update('factura');
						}
					}
				}
				// FINALIZAMOS LA META DEL SUPERVISOR
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
				$aux_adelanto = 0;
				$aux_descuentos = 0;

				$consulta_adelantos = $this->db->select_sum('valor')->from('adelanto')->where('id_empleado', $value->id_persona)->where('estado', 'sin registrar')->get();
				$consulta_descuentos_dias = $this->db->select_sum('valor')->from('dias_descontados')->where('id_persona', $value->id_persona)->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->get();

				if($consulta_descuentos_dias->num_rows() > 0){
					$consulta_descuentos_dias = $consulta_descuentos_dias->result();
					$aux_descuentos = $consulta_descuentos_dias[0]->valor;
				}
				if ($consulta_adelantos->num_rows() > 0) {
					$consulta_adelantos = $consulta_adelantos->result();
					$aux_adelanto = $consulta_adelantos[0]->valor;
				}

				$adelanto = $aux_descuentos+$aux_adelanto;

				if ($value->tipo_cuenta == "administrador") {
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'administrador')->where('estado', 'activo')->get()->result();
					$insert_data['id_sueldo'] = $datos_sueldo[0]->id_sueldos_empleados;
					$sueldo_general = $datos_sueldo[0]->sueldo;
				}else if($value->tipo_cuenta == "talento humano"){
					$datos_sueldo = $this->db->select('id_sueldos_empleados, sueldo')->from('sueldos_empleados')->where('tipo_usuario', 'talento humano')->where('estado', 'activo')->get()->result();
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
				$this->db->set('id_factura_general', $id)->set('estado', 'registrado')->where('id_persona', $insert_data['id_empleado'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->update('dias_descontados');

			}
			return true;
		}
		return false;
	}
}
