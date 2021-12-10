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

	public function verSalarios(){
		$this->db->select('*');
		$this->db->from('sueldos_empleados');
		$this->db->where('estado', 'activo');
		$this->db->order_by('estado' , 'asc');
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
				$bandera_adelanto = false;
				$bandera_adelanto_proceso = false;
				$id_adelanto = 0;
				$aux_adelanto = 0;
				$aux_descuentos = 0;
				$aux_aumentos = 0;
				$datos_insert = [];
				$datos_insert['descuento'] = 0;
				$adelanto_cantidad_cuotas = 0;
				$adelanto_cantidad_cuotas_aux = 0;
				$adelanto_cantidad_total = 0;
				$adelanto_cantidad_total_aux = 0;
				$estado_adelanto = "";

				// Consultamos si tiene un adelanto
				$consulta_adelantos = $this->db->select('*')->from('adelanto')->where('id_empleado', $valor_s->id_persona)->where('estado', 'sin registrar')->get();

				if($consulta_adelantos->num_rows() > 0){
					$bandera_adelanto = true;
					$consulta_adelantos = $consulta_adelantos->result();
					$adelanto_cantidad_cuotas = $consulta_adelantos[0]->cuota;
					$adelanto_cantidad_total = $consulta_adelantos[0]->valor;
					$id_adelanto = $consulta_adelantos[0]->id_adelanto;
					$aux_adelanto = $adelanto_cantidad_total/$adelanto_cantidad_cuotas;
					$adelanto_cantidad_total_aux = $adelanto_cantidad_total-$aux_adelanto;
					$adelanto_cantidad_cuotas_aux = $adelanto_cantidad_cuotas-1;
					$estado_adelanto = $consulta_adelantos[0]->estado;
				}
				// Consultamos si tiene un adelanto activo
				$consulta_adelantos_proceso = $this->db->select('*')->from('adelanto')->where('id_empleado', $valor_s->id_persona)->where('estado', 'pagando')->get();
				if($consulta_adelantos_proceso->num_rows() > 0){
					$bandera_adelanto_proceso = true;
					$consulta_adelantos_proceso = $consulta_adelantos_proceso->result();
					$adelanto_cantidad_cuotas = $consulta_adelantos_proceso[0]->cuota;
					$adelanto_cantidad_total = $consulta_adelantos_proceso[0]->valor;
					$id_adelanto = $consulta_adelantos_proceso[0]->id_adelanto;

					$aux_adelanto = $adelanto_cantidad_total/$adelanto_cantidad_cuotas;
					$adelanto_cantidad_total_aux = $consulta_adelantos_proceso[0]->valor_aux-$aux_adelanto;
					$adelanto_cantidad_cuotas_aux = $consulta_adelantos_proceso[0]->cuota_aux-1;
					$estado_adelanto = $consulta_adelantos_proceso[0]->estado;
				}


				////////////////////////////////////
				
				// CONSULTAMOS AUMENTOS

				$aumentos = $this->db->select('id, valor')->from('aumentos')->where('id_persona', $valor_s->id_persona)->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->get();
				if($aumentos->num_rows() > 0){
					foreach ($aumentos->result() as $key => $aumento) {
						$aux_aumentos = $aux_aumentos+$aumento->valor;
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
				$aux_horas_bonga = 0;
				$aux_horas_general = 0;
				// CONSULTAMOS LAS HORAS DE LAS MODELOS
				$modelos = $this->db->select('id_empleado')->from('empleado_supervisor')->where('id_supervisor', $valor_s->id_persona)->where('estado', 'activo')->get();
				if($modelos->num_rows() > 0){
					foreach ($modelos->result() as $key => $modelo) {
						$nomina_modelo_bonga = $this->db->select_sum('cantidad_horas')->from('registro_horas')
													->join('paginas', 'paginas.id_pagina = registro_horas.id_pagina')
													->where('paginas.url_pagina', 'bongacams')
													->where('registro_horas.id_empleado', $modelo->id_empleado)
													->where('registro_horas.id_supervisor', $valor_s->id_persona)
													->where('fecha_registro >=', $data['fecha_inicial'])
													->where('fecha_registro <=', $data['fecha_final'])
													->where('estado_registro', 'registrado')->get();
						$nomina_modelo_general = $this->db->select_sum('cantidad_horas')->from('registro_horas')
															->join('paginas', 'paginas.id_pagina = registro_horas.id_pagina')
															->where('paginas.url_pagina !=', 'bongacams')
															->where('registro_horas.id_empleado', $modelo->id_empleado)
															->where('registro_horas.id_supervisor', $valor_s->id_persona)
															->where('fecha_registro >=', $data['fecha_inicial'])
															->where('fecha_registro <=', $data['fecha_final'])
															->where('estado_registro', 'registrado')->get();
						if($nomina_modelo_general->num_rows()>0){
							$nomina_modelo_general = $nomina_modelo_general->result();
							$aux_horas_general = $aux_horas_general+$nomina_modelo_general[0]->cantidad_horas;
						}
						if($nomina_modelo_bonga->num_rows()>0){
							$nomina_modelo_bonga = $nomina_modelo_bonga->result();
							$aux_horas_bonga = $aux_horas_bonga+$nomina_modelo_bonga[0]->cantidad_horas;
						}
					}
				}

				$aux_horas_bonga = round($aux_horas_bonga/2);

				$aux_horas_total = $aux_horas_bonga+$aux_horas_general;

				
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
				$datos_insert['aumento'] = $aux_aumentos;
				$datos_insert['total_paga'] = ((($sueldo_supervisor[0]->sueldo/2)+$datos_insert['total_comision'])-$datos_insert['descuento'])+$aux_aumentos;
				$datos_insert['fecha_inicial'] = $data['fecha_inicial']; 
				$datos_insert['fecha_final'] = $data['fecha_final'];
				$datos_insert['estado_factura'] = "sin registrar";

				$this->db->insert('factura_supervisor', $datos_insert);

				$id = $this->db->insert_id();
				// VERIFICAMOS SI TENIA ADELANTOS, SI LO TENIA FINALIZAMOS EL DESCUENTO DEL ADELANTO
				if($bandera_adelanto){
					$datos_insert_adelantos['id_adelanto'] = $id_adelanto;
					$datos_insert_adelantos['id_factura_supervisor'] = $id;
					$datos_insert_adelantos['valor'] = $aux_adelanto;
					$this->db->insert('adelanto_factura', $datos_insert_adelantos);
					if($adelanto_cantidad_cuotas_aux == 0){
						$this->db->set('estado', 'registrado')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $datos_insert['id_empleado'])->where('estado', $estado_adelanto)->update('adelanto');
					}else{
						$this->db->set('estado', 'pagando')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $datos_insert['id_empleado'])->where('estado', $estado_adelanto)->update('adelanto');
					}
				}
				if($bandera_adelanto_proceso){
					$datos_insert_adelantos['id_adelanto'] = $id_adelanto;
					$datos_insert_adelantos['id_factura_supervisor'] = $id;
					$datos_insert_adelantos['valor'] = $aux_adelanto;
					$this->db->insert('adelanto_factura', $datos_insert_adelantos);
					if($adelanto_cantidad_cuotas_aux == 0){
						$this->db->set('estado', 'registrado')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $datos_insert['id_empleado'])->where('estado', $estado_adelanto)->update('adelanto');
					}else{
						$this->db->set('estado', 'pagando')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $datos_insert['id_empleado'])->where('estado', $estado_adelanto)->update('adelanto');
					}
				}

				if(!$aux_descuentos == 0){
					$this->db->set('id_factura_supervisor', $id)->set('estado', 'registrado')->where('id_persona', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->update('dias_descontados');
				}

				if(!$aux_aumentos == 0){
					$this->db->set('id_factura_supervisor', $id)->set('estado', 'registrado')->where('id_persona', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->update('aumentos');
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
			->where('usuarios.estado', 'activo')
			->group_start()
			->where('tipo_cuenta', 'administrador')
			->or_where('tipo_cuenta', 'talento humano')
			->or_where('tipo_cuenta', 'servicios generales')
			->or_where('tipo_cuenta', 'psicologa')
			->or_where('tipo_cuenta', 'operario de mantenimiento')
			->or_where('tipo_cuenta', 'maquillador')
			->or_where('tipo_cuenta', 'fotografo')
			->or_where('tipo_cuenta', 'community manager')
			->or_where('tipo_cuenta', 'operativo')
			->group_end()
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
				$aux_aumento = 0;
				$adelanto_cantidad_cuotas = 0;
				$adelanto_cantidad_cuotas_aux = 0;
				$adelanto_cantidad_total = 0;
				$adelanto_cantidad_total_aux = 0;
				$estado_adelanto = "";
				$bandera_adelanto = false;
				$bandera_adelanto_proceso = false;


				// adelantos
				// Consultamos si tiene un adelanto
				$consulta_adelantos = $this->db->select('*')->from('adelanto')->where('id_empleado', $value->id_persona)->where('estado', 'sin registrar')->get();

				if($consulta_adelantos->num_rows() > 0){
					$bandera_adelanto = true;
					$consulta_adelantos = $consulta_adelantos->result();
					$adelanto_cantidad_cuotas = $consulta_adelantos[0]->cuota;
					$adelanto_cantidad_total = $consulta_adelantos[0]->valor;
					$id_adelanto = $consulta_adelantos[0]->id_adelanto;
					$aux_adelanto = $adelanto_cantidad_total/$adelanto_cantidad_cuotas;
					$adelanto_cantidad_total_aux = $adelanto_cantidad_total-$aux_adelanto;
					$adelanto_cantidad_cuotas_aux = $adelanto_cantidad_cuotas-1;
					$estado_adelanto = $consulta_adelantos[0]->estado;
				}
				// Consultamos si tiene un adelanto activo
				$consulta_adelantos_proceso = $this->db->select('*')->from('adelanto')->where('id_empleado', $value->id_persona)->where('estado', 'pagando')->get();
				if($consulta_adelantos_proceso->num_rows() > 0){
					$bandera_adelanto_proceso = true;
					$consulta_adelantos_proceso = $consulta_adelantos_proceso->result();
					$adelanto_cantidad_cuotas = $consulta_adelantos_proceso[0]->cuota;
					$adelanto_cantidad_total = $consulta_adelantos_proceso[0]->valor;
					$id_adelanto = $consulta_adelantos_proceso[0]->id_adelanto;

					$aux_adelanto = $adelanto_cantidad_total/$adelanto_cantidad_cuotas;
					$adelanto_cantidad_total_aux = $consulta_adelantos_proceso[0]->valor_aux-$aux_adelanto;
					$adelanto_cantidad_cuotas_aux = $consulta_adelantos_proceso[0]->cuota_aux-1;
					$estado_adelanto = $consulta_adelantos_proceso[0]->estado;
				}


				////////////////////////////////////

				$consulta_aumentos = $this->db->select('valor')->from('aumentos')->where('id_persona', $value->id_persona)->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->get();
				$consulta_descuentos_dias = $this->db->select_sum('valor')->from('dias_descontados')->where('id_persona', $value->id_persona)->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->get();

				if($consulta_descuentos_dias->num_rows() > 0){
					foreach ($consulta_descuentos_dias->result() as $key => $descuento) {
						$aux_descuentos = $aux_descuentos+$descuento->valor;
					}
				}
				if($consulta_aumentos->num_rows() > 0){
					foreach ($consulta_aumentos->result() as $key => $aumento) {
						$aux_aumento = $aux_aumento+$aumento->valor;
					}
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
				$insert_data['aumento'] = $aux_aumento;
				$insert_data['total_a_pagar'] = (($sueldo_general/2)-$adelanto)+$aux_aumento;
				$insert_data['fecha_inicial'] = $data['fecha_inicial'];
				$insert_data['fecha_final'] = $data['fecha_final'];
				$insert_data['estado'] = "sin registrar";

				$this->db->insert('factura_general', $insert_data);

				$id = $this->db->insert_id();

				if(!$aux_descuentos == 0){
					$this->db->set('id_factura_general', $id)->set('estado', 'registrado')->where('id_persona', $insert_data['id_empleado'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->update('dias_descontados');
				}

				if(!$aux_aumento == 0){
					$this->db->set('id_factura_general', $id)->set('estado', 'registrado')->where('id_persona', $insert_data['id_empleado'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->update('aumentos');
				}
				if($bandera_adelanto){
					$datos_insert_adelantos['id_adelanto'] = $id_adelanto;
					$datos_insert_adelantos['id_factura_general'] = $id;
					$datos_insert_adelantos['valor'] = $aux_adelanto;
					$this->db->insert('adelanto_factura', $datos_insert_adelantos);
					if($adelanto_cantidad_cuotas_aux == 0){
						$this->db->set('estado', 'registrado')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $insert_data['id_empleado'])->where('estado', $estado_adelanto)->update('adelanto');
					}else{
						$this->db->set('estado', 'pagando')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $insert_data['id_empleado'])->where('estado', $estado_adelanto)->update('adelanto');
					}
				}
				if($bandera_adelanto_proceso){
					$datos_insert_adelantos['id_adelanto'] = $id_adelanto;
					$datos_insert_adelantos['id_factura_general'] = $id;
					$datos_insert_adelantos['valor'] = $aux_adelanto;
					$this->db->insert('adelanto_factura', $datos_insert_adelantos);
					if($adelanto_cantidad_cuotas_aux == 0){
						$this->db->set('estado', 'registrado')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $insert_data['id_empleado'])->where('estado', $estado_adelanto)->update('adelanto');
					}else{
						$this->db->set('estado', 'pagando')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $insert_data['id_empleado'])->where('estado', $estado_adelanto)->update('adelanto');
					}
				}
				

			}
			return true;
		}
		return false;
	}
}
