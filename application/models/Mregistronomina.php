<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mregistronomina extends CI_Model {

	public function getFactura($id){
		return $this->db->select('*')->from('factura')->where('id_factura', $id)->get()->result();
	}
	public function getFacturaMonitor($id){
		return $this->db->select('*')->from('factura_supervisor')->where('id_factura_supervisor', $id)->get()->result();
	}

	public function getFacturaSupervisor($id){
		return $this->db->select('*')->from('factura_tecnico')->where('id', $id)->get()->result();
	}

	public function getFacturaGeneral($id){
		return $this->db->select('*')->from('factura_general')->where('id_factura_general', $id)->get()->result();
	}

	public function VerificarMeta($data){
		$consulta_meta = $this->db->select('*')->from('metas')->where('id_empleado', $data['id_persona'])->where('estado', 'sin registrar')->get();
		if($consulta_meta->num_rows() > 0){
			return true;
		}
		return false;
	}
	
	public function registrarNomina($data){

		/// SACAMOS LA CANTIDAD DE ASISTENCIA DEL EMPLEADO ///
		$sub_consulta='(asistencia_empleado.estado = "registrado" OR asistencia_empleado.motivo IN (SELECT id_motivo FROM motivo_asistencia WHERE descuenta = "No"))';

		$consulta_asistencia = $this->db->select('asistencia_empleado.*, asistencia.fecha')->from('asistencia_empleado')->join('asistencia', 'asistencia.id_asistencia = asistencia_empleado.id_asistencia')->where('asistencia.fecha <=', $data['fecha_final'])->where('asistencia.fecha >=', $data['fecha_inicial'])->where('id_empleado', $data['id_persona'])->where($sub_consulta)->get()->result();

		$numero_dias = count($consulta_asistencia);

		
		////////////////////////////////////////////////////

		

		/// CONSULTAMOS PENALIZACIONES ///
		$consulta_penalizaciones = $this->db->select_sum('puntos')->from('empleado_penalizacion')
										->where('estado', 'sin registrar')
										->where('id_empleado', $data['id_persona'])
										->where('fecha_registrado <=', $data['fecha_final'])
										->where('fecha_registrado >=', $data['fecha_inicial'])
										->get()->result();
		if($consulta_penalizaciones[0]->puntos == null){
			$num_penalizacion = 0;
		}else{
			$num_penalizacion = $consulta_penalizaciones[0]->puntos;
		}


		/////////////////////////////////

		/// CONSULTAMOS LOS TOKENS DE LOS EMPLEADOS /////
		$consulta_bonga = 0;
		$tokens_general = 0;
		$tokens_bonga = 0;
		$response =	$this->db->select('paginas.id_pagina')->from('persona_pagina')
							->join('paginas', 'persona_pagina.id_pagina = paginas.id_pagina')
							->where('url_pagina', 'bongacams')
							->where('id_persona', $data['id_persona'])
							->get();
		if($response->num_rows() > 0) {
			$consulta_bonga = $response->result();
			$tokens_bonga = $this->db->select_sum('cantidad_horas')
							->from('registro_horas')
							->where('id_empleado', $data['id_persona'])
							->where('estado_registro', 'verificado')
							->where('fecha_registro <=', $data['fecha_final'])
							->where('fecha_registro >=', $data['fecha_inicial'])
							->where('id_pagina', $consulta_bonga[0]->id_pagina)
							->get();
			if(!$tokens_bonga->num_rows() > 0){
				$tokens_bonga = 0;
			}else{
				$tokens_bonga = $tokens_bonga->result();

				$tokens_bonga = $tokens_bonga[0]->cantidad_horas;
			}
		}else{
			$tokens_bonga = 0;
		}
			
	

		$tokens_general = $this->db->select_sum('cantidad_horas')->from('registro_horas')
									->where('id_empleado', $data['id_persona'])
									->where('estado_registro', 'verificado')
									->where('fecha_registro <=', $data['fecha_final'])
									->where('fecha_registro >=', $data['fecha_inicial'])
									->where('id_pagina !=', 6)
									->get()->result();
		if($tokens_general[0]->cantidad_horas == null){
			$tokens_general[0]->cantidad_horas = 0;
		}

		$cantidad_horas = $tokens_general[0]->cantidad_horas-$num_penalizacion;
		$total_horas = $tokens_general[0]->cantidad_horas+$tokens_bonga;
		$tokens_subtotal = $cantidad_horas+$tokens_bonga;
		/////////////////////////////////////////
		/// CONSULTAMOS LA META DEL EMPLEADO Y VERIFICAMOS SI CUMPLIO LA META ///
		$consulta_meta = $this->db->select('*')->from('metas')->where('id_empleado', $data['id_persona'])->where('estado', 'sin registrar')->get()->result();
		$estado_meta = "incompleta";
		if ($tokens_subtotal>=$consulta_meta[0]->num_horas) {
			$estado_meta = "completa";
		}
		/////////////////////////////////////////////////////////////////////////

		/// CONSULTAMOS EL PORCENTAJE DE LOS DIAS GENERAL///

		// Consultamos la fecha de entrada de la modelo 
		$fecha_entrada = $this->db->select('fecha_entrada')->from('persona')->where('id_persona', $data['id_persona'])->get()->result();
		$consulta_porcentaje_dias = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta,valor_multiplicar,fecha_accion')->from('porcentajes_dias')
											->where('estado', 'activo')
											->where('tipo', 'general')
											->order_by('fecha_accion', 'desc')
											->get()->result();
		$consulta_porcentaje_dias_bonga = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta,valor_multiplicar,fecha_accion')->from('porcentajes_dias')
											->where('estado', 'activo')
											->where('tipo', 'bongacams')
											->order_by('fecha_accion', 'desc')
											->get()->result();
		$porcentaje_dias = 0;
		$porcentaje_dias_bonga = 0;
		$porcentaje_dias_porcentaje = 0;
		$id_porcentaje_dias = null;
		////////////////////////////////////////////

		foreach ($consulta_porcentaje_dias as $key => $value) {
			if($fecha_entrada[0]->fecha_entrada >= $value->fecha_accion){
				$subconsulta = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta,valor_multiplicar,fecha_accion')->from('porcentajes_dias')
										->where('estado', 'activo')
										->where('tipo', 'general')
										->where('fecha_accion', $value->fecha_accion)
										->order_by('cantidad_dias', 'desc')
										->get()->result();
				$bandera = false;
				foreach ($subconsulta as $key => $val) {
					if ($numero_dias >= $val->cantidad_dias && $val->estado_meta == $estado_meta) {
						/// ASIGNAMOS EL VALOR DEL % SI CuMPLE CON LOS DIAS Y META ///
						$porcentaje_dias_porcentaje = $val->valor;
						$porcentaje_dias = $val->valor_multiplicar;
						$id_porcentaje_dias = $subconsulta[$key]->id_porcentajes_dias;
						$bandera = true;
						break;
					}
				}
				if($bandera){
					break;
				}
			}
		}
		///////////////////////////////////////////////////

		foreach ($consulta_porcentaje_dias_bonga as $key => $value) {
			if($fecha_entrada[0]->fecha_entrada >= $value->fecha_accion){
				$subconsulta = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta,valor_multiplicar,fecha_accion')->from('porcentajes_dias')
										->where('estado', 'activo')
										->where('tipo', 'bongacams')
										->where('fecha_accion', $value->fecha_accion)
										->order_by('cantidad_dias', 'desc')
										->get()->result();
				$bandera = false;
				foreach ($subconsulta as $key => $val) {
					if ($numero_dias >= $val->cantidad_dias && $val->estado_meta == $estado_meta) {
						/// ASIGNAMOS EL VALOR DEL % SI CuMPLE CON LOS DIAS Y META ///
						$porcentaje_dias_bonga = $val->valor_multiplicar;
						$bandera = true;
						break;
					}
				}
				if($bandera){
					break;
				}
			}
		}

		if($consulta_meta[0]->estado_meta == "sin_meta"){
			$consulta_porcentaje_dias = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta,valor_multiplicar')->from('porcentajes_dias')
												->where('estado', 'activo')
												->where('tipo', 'general')
												->where('valor', 60)
												->order_by('fecha_accion', 'desc')
												->get()->result();
			$consulta_porcentaje_dias_bonga = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta,valor_multiplicar')->from('porcentajes_dias')
												->where('estado', 'activo')
												->where('tipo', 'bongacams')
												->where('valor', 60)
												->order_by('fecha_accion', 'desc')
												->get()->result();
			$porcentaje_dias = $consulta_porcentaje_dias[0]->valor_multiplicar;
			$id_porcentaje_dias = $consulta_porcentaje_dias[0]->id_porcentajes_dias;
			$porcentaje_dias_bonga = $consulta_porcentaje_dias_bonga[0]->valor_multiplicar;
			$porcentaje_dias_porcentaje = 60;
		}
		///////////////////////////////////////////////////
		/// CONSULTAMOS ADELANTOS ///
		$id_adelanto = 0;
		$aux_adelanto = 0;
		$adelanto_cantidad_cuotas = 0;
		$adelanto_cantidad_cuotas_aux = 0;
		$adelanto_cantidad_total = 0;
		$adelanto_cantidad_total_aux = 0;
		$estado_adelanto = "";
		$bandera_adelanto = false;
		$bandera_adelanto_proceso = false;

		$consulta_adelantos = $this->db->select('*')->from('adelanto')->where('id_empleado', $data['id_persona'])->where('estado', 'sin registrar')->get();

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
		$consulta_adelantos_proceso = $this->db->select('*')->from('adelanto')->where('id_empleado', $data['id_persona'])->where('estado', 'pagando')->get();
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

		$adelanto = $aux_adelanto;
		////////////////////////////

		/// CONSULTAMOS DESCUENTOS ///
		$aux_descuentos = 0;

		$consulta_descuentos_dias = $this->db->select_sum('valor')->from('dias_descontados')->where('id_persona', $data['id_persona'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->get();
		if($consulta_descuentos_dias->num_rows() > 0){
			foreach ($consulta_descuentos_dias->result() as $key => $descuento) {
				$aux_descuentos = $aux_descuentos+$descuento->valor;
			}
		}


		$adelanto = $adelanto+$aux_descuentos;
		/////////////////////////////////
		/// CONSULTAMOS VALOR DOLAR ///
		$consulta_valor_dolar = $this->db->select('valor_dolar,id_dolar')->from('dolar')->where('estado', 'activo')->get()->result();
		if (empty($consulta_valor_dolar)) {
			return false;
		}
		$valor_dolar = $consulta_valor_dolar[0]->valor_dolar;
		//////////////////////////////

		/// AUMENTOS ////
		$aux_aumentos = 0;
		$aumentos = $this->db->select('id, valor')->from('aumentos')->where('id_persona', $data['id_persona'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->get();
		if($aumentos->num_rows() > 0){
			foreach ($aumentos->result() as $key => $aumento) {
				$aux_aumentos = $aux_aumentos+$aumento->valor;
			}
		}

		/// CALCULOS EMPLEADOS ///


		// CALCULOS PAGINAS GENERALES //
		$sub_total_generales = ($cantidad_horas*$porcentaje_dias)*$valor_dolar;
		// CALCULOS PAGINAS BONGACAMS
		$sub_total_bongacams = ($tokens_bonga*$porcentaje_dias_bonga)*$valor_dolar;

		

		$sub_total = $sub_total_generales+$sub_total_bongacams;

		$total = ($sub_total+$aux_aumentos)-$adelanto;

		///////////////

		/// CALCULOS INGRESOS ///

		// $porcentaje_ingreso = 100-$porcentaje_dias;

		//  $total_ingreso = ($sub_total/100)*$porcentaje_ingreso;

		//////////////////////////



		/// INSERT DATOS A FACTURA ///
		$datos['id_meta'] = $consulta_meta[0]->id_meta;
		$datos['estado_meta'] = $estado_meta;
		$datos['id_usuario'] = $data['id_persona'];
		$datos['id_talento_humano'] = $data['id_talento'];
		$datos['id_dolar'] = $consulta_valor_dolar[0]->id_dolar;
		$datos['id_porcentaje_dias'] = $id_porcentaje_dias;
		$datos['descuento'] = $adelanto;
		$datos['aumentos'] = $aux_aumentos;
		$datos['total_horas'] = $total_horas;
		$datos['total_a_pagar'] = $total;
		$datos['estado_factura'] = "sin registrar";
		$datos['penalizacion_horas'] = $num_penalizacion;
		$datos['porcentaje_paga'] = $porcentaje_dias_porcentaje;
		$datos['cant_dias'] = $numero_dias;
		$datos['fecha_inicio'] = $data['fecha_inicial'];
		$datos['fecha_final'] = $data['fecha_final'];
		$this->db->insert('factura', $datos);

		$id = $this->db->insert_id();

		/// DATOS INSERT INGRESOS ///

		//$data_ingreso['id_factura'] = $id;
		//$data_ingreso['valor'] = $total_ingreso;
		//$data_ingreso['porcentaje'] = $porcentaje_ingreso;

		////////////////////////////

		//$this->db->insert('ingresos', $data_ingreso);

		if(!$aux_aumentos == 0){
			$this->db->set('id_factura', $id)->set('estado', 'registrado')->where('id_persona', $data['id_persona'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->update('aumentos');
		}

		if($bandera_adelanto){
			$datos_insert_adelantos['id_adelanto'] = $id_adelanto;
			$datos_insert_adelantos['id_factura'] = $id;
			$datos_insert_adelantos['valor'] = $aux_adelanto;
			$this->db->insert('adelanto_factura', $datos_insert_adelantos);
			if($adelanto_cantidad_cuotas_aux == 0){
				$this->db->set('estado', 'registrado')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $data['id_persona'])->where('estado', $estado_adelanto)->update('adelanto');
			}else{
				$this->db->set('estado', 'pagando')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $data['id_persona'])->where('estado', $estado_adelanto)->update('adelanto');
			}
		}
		if($bandera_adelanto_proceso){
			$datos_insert_adelantos['id_adelanto'] = $id_adelanto;
			$datos_insert_adelantos['id_factura'] = $id;
			$datos_insert_adelantos['valor'] = $aux_adelanto;
			$this->db->insert('adelanto_factura', $datos_insert_adelantos);
			if($adelanto_cantidad_cuotas_aux == 0){
				$this->db->set('estado', 'registrado')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $data['id_persona'])->where('estado', $estado_adelanto)->update('adelanto');
			}else{
				$this->db->set('estado', 'pagando')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $data['id_persona'])->where('estado', $estado_adelanto)->update('adelanto');
			}
		}
		if(!$aux_descuentos == 0){
			$this->db->set('id_factura', $id)->set('estado', 'registrado')->where('id_persona', $datos['id_usuario'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->update('dias_descontados');
		}
		$this->db->set('id_factura', $id)->set('estado', 'registrado')->where('id_empleado', $datos['id_usuario'])->where('fecha_registrado >=', $data['fecha_inicial'])->where('fecha_registrado <=', $data['fecha_final'])->update('empleado_penalizacion');

		$this->db->set('estado', 'registrado')->where('id_meta', $datos['id_meta'])->update('metas');

		return $this->db->set('id_factura', $id)->set('estado_registro', 'registrado')->where('id_empleado', $datos['id_usuario'])->where('fecha_registro >=', $data['fecha_inicial'])->where('fecha_registro <=', $data['fecha_final'])->where('estado_registro', 'verificado')->update('registro_horas');
	}

	public function editFactura($data){
		$this->db->where('id_factura', $data['id_factura']);
		return $this->db->update('factura', $data);
	}

	public function editFacturaMonitor($data){
		$this->db->where('id_factura_supervisor', $data['id_factura_supervisor']);
		return $this->db->update('factura_supervisor', $data);
	}

	public function editFacturaSupervisor($data){
		$this->db->where('id', $data['id']);
		return $this->db->update('factura_tecnico', $data);
	}

	public function editFacturaGeneral($data){
		$this->db->where('id_factura_general', $data['id_factura_general']);
		return $this->db->update('factura_general', $data);
	}

	public function verRegistrosAdmin(){
		$this->db->select('*');
		$this->db->from('factura');
		$facturas = $this->db->get();
		if($facturas->num_rows() > 0) {
			return $facturas->result();
		}
		return false;
	}
	
	public function verRegistrosNomina($id){
		$this->db->select('*');
		$this->db->from('factura');
		$this->db->where('id_talento_humano', $id);
		$facturas = $this->db->get();

		if($facturas->num_rows() > 0) {
			return $facturas->result();
		}
		return false;
	}

	public function getFacturasAdmin($data) {
		$this->db->select('b.*, factura.*,dolar.*, metas.num_horas');
		$this->db->from('factura');
		$this->db->join('dolar', 'dolar.id_dolar = factura.id_dolar');
		$this->db->join('persona as b', 'b.id_persona = factura.id_usuario');
		$this->db->join('metas', 'metas.id_meta = factura.id_meta');
		if($data['fecha_inicio'] != ""){
			$this->db->where('fecha_inicio >=', $data['fecha_inicio']);
		}
		if($data['fecha_final'] != ""){
			$this->db->where('fecha_inicio <=', $data['fecha_final']);
		}
		$this->db->order_by('factura.fecha_registrado' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getFacturas() {
		$this->db->select('b.*, factura.*,dolar.*');
		$this->db->from('factura');
		$this->db->join('dolar', 'dolar.id_dolar = factura.id_dolar');
		$this->db->join('persona as b', 'b.id_persona = factura.id_usuario');


		$this->db->order_by('factura.fecha_registrado' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			
			return $usuarios->result();
		}

		return false;
	}

	public function getRegistrosFacturas($id_factura) {
		$this->db->select('registro_horas.*,persona.*,paginas.*');
		$this->db->from('registro_horas');
		$this->db->join('persona', 'persona.id_persona = registro_horas.id_empleado');
		$this->db->join('paginas', 'paginas.id_pagina = registro_horas.id_pagina');
		$this->db->where('registro_horas.id_factura', $id_factura);
		
		$this->db->order_by('registro_horas.fecha_registro' , 'DESC');
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function consultarNominaGeneral($data){
		$facturas_empleados = $this->db->select_sum('total_a_pagar')->where('fecha_registrado <=', $data['fecha_final'])->where('fecha_registrado >=', $data['fecha_inicial'])->from('factura')->get()->result();
		$facturas_supervisor = $this->db->select_sum('total_paga')->where('fecha_registro <=', $data['fecha_final'])->where('fecha_registro >=', $data['fecha_inicial'])->from('factura_supervisor')->get()->result();
		$facturas_general = $this->db->select_sum('total_a_pagar')->where('fecha_registrado <=', $data['fecha_final'])->where('fecha_registrado >=', $data['fecha_inicial'])->from('factura_general')->get()->result();

		$total = $facturas_empleados[0]->total_a_pagar + $facturas_supervisor[0]->total_paga + $facturas_general[0]->total_a_pagar;

		return $total;
	}

	public function getLastFactura($id_usuario){
		$consulta = $this->db->select('estado_meta, cant_dias, descuento, penalizacion_horas, total_horas, porcentaje_paga, total_a_pagar, fecha_registrado, fecha_inicio, fecha_final, id_porcentaje_dias, id_factura, nuevo_valor')->from('factura')->where('id_usuario', $id_usuario)->order_by('fecha_registrado', 'DESC')->get();
		if ($consulta->num_rows() > 0) {
			return $consulta->result();
		}
		return false;
	}

	public function getDatosFacturaImprimir($id){

		$consulta = $this->db->select('factura.*, usuarios.tipo_cuenta, persona.documento, persona.nombres, persona.apellidos, dolar.valor_dolar, registro_horas.cantidad_horas, registro_horas.fecha_registro as horas_factura, EXTRACT(MONTH FROM factura.fecha_registrado) as mes, EXTRACT(DAY FROM factura.fecha_inicio) as dia1, EXTRACT(DAY FROM factura.fecha_final) as dia2, EXTRACT(YEAR FROM factura.fecha_inicio) as year')->from('factura')->join('persona', 'persona.id_persona = factura.id_usuario')->join('usuarios', 'persona.id_persona = usuarios.id_persona')->join('dolar', 'dolar.id_dolar = factura.id_dolar')->join('registro_horas', 'registro_horas.id_factura = factura.id_factura')->where('factura.id_factura', $id)->get()->result();
		return $consulta;
	}

	public function getDatosFacturaImprimirMonitor($id){

		$consulta = $this->db->select('factura_supervisor.*, usuarios.tipo_cuenta, persona.documento, persona.nombres, persona.apellidos, EXTRACT(MONTH FROM factura_supervisor.fecha_registro) as mes, EXTRACT(DAY FROM factura_supervisor.fecha_inicial) as dia1, EXTRACT(DAY FROM factura_supervisor.fecha_final) as dia2, EXTRACT(YEAR FROM factura_supervisor.fecha_inicial) as year')->from('factura_supervisor')->join('persona', 'persona.id_persona = factura_supervisor.id_empleado')->join('usuarios', 'persona.id_persona = usuarios.id_persona')->where('factura_supervisor.id_factura_supervisor', $id)->get()->result();
		return $consulta;
	}

	public function getDatosFacturaImprimirSupervisor($id){

		$consulta = $this->db->select('factura_tecnico.*, usuarios.tipo_cuenta, persona.documento, persona.nombres, persona.apellidos, EXTRACT(MONTH FROM factura_tecnico.created_at) as mes, EXTRACT(DAY FROM factura_tecnico.fecha_inicial) as dia1, EXTRACT(DAY FROM factura_tecnico.fecha_final) as dia2, EXTRACT(YEAR FROM factura_tecnico.fecha_inicial) as year')->from('factura_tecnico')->join('persona', 'persona.id_persona = factura_tecnico.id_empleado')->join('usuarios', 'persona.id_persona = usuarios.id_persona')->where('factura_tecnico.id', $id)->get()->result();
		return $consulta;
	}

	public function getDatosFacturaImprimirGeneral($id){

		$consulta = $this->db->select('factura_general.*, usuarios.tipo_cuenta, persona.documento, persona.nombres, persona.apellidos, EXTRACT(MONTH FROM factura_general.fecha_registrado) as mes, EXTRACT(DAY FROM factura_general.fecha_inicial) as dia1, EXTRACT(DAY FROM factura_general.fecha_final) as dia2, EXTRACT(YEAR FROM factura_general.fecha_inicial) as year')->from('factura_general')->join('persona', 'persona.id_persona = factura_general.id_empleado')->join('usuarios', 'persona.id_persona = usuarios.id_persona')->where('factura_general.id_factura_general', $id)->get()->result();
		return $consulta;
	}
	
	public function get_fecha_incialNomina($empleada){
		$this->db->select('DATE_ADD(MAX(`fecha_final`), INTERVAL 1 DAY) AS fecha', false);
		$this->db->where('id_usuario', $empleada);
		$dato=$this->db->get('factura')->row();

		if (empty($dato->fecha)) {
			$this->db->select('MIN(`fecha_registro`) AS fecha', false);
			$this->db->where('id_empleado', $empleada);
			$dato=$this->db->get('registro_horas')->row();
		}

		return $dato->fecha;
	}
}
