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
		$consulta_meta = $this->db->select('num_horas, id_meta')->from('metas')->where('id_empleado', $data['id_persona'])->where('estado', 'sin registrar')->get()->result();
		$estado_meta = "incompleta";
		if ($tokens_subtotal>=$consulta_meta[0]->num_horas) {
			$estado_meta = "completa";
		}
		/////////////////////////////////////////////////////////////////////////

		/// CONSULTAMOS EL PORCENTAJE DE LOS DIAS GENERAL///
		$consulta_porcentaje_dias = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta,valor_multiplicar')->from('porcentajes_dias')
											->where('estado', 'activo')
											->where('tipo', 'general')
											->order_by('cantidad_dias', 'desc')
											->get()->result();
		$consulta_porcentaje_dias_bonga = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta,valor_multiplicar')->from('porcentajes_dias')
											->where('estado', 'activo')
											->where('tipo', 'bongacams')
											->order_by('cantidad_dias', 'desc')
											->get()->result();
		$porcentaje_dias = 0;
		$porcentaje_dias_bonga = 0;
		$porcentaje_dias_porcentaje = 0;
		$id_porcentaje_dias = null;
		////////////////////////////////////////////

		/// VERIFICAMOS SI CUMPLE CON EL MINIMO DE DIAS GENERAL ///
		foreach ($consulta_porcentaje_dias as $key => $value) {
			if ($numero_dias >= $value->cantidad_dias && $value->estado_meta == $estado_meta) {
				/// ASIGNAMOS EL VALOR DEL % SI CuMPLE CON LOS DIAS Y META ///
				$porcentaje_dias_porcentaje = $value->valor;
				$porcentaje_dias = $value->valor_multiplicar;
				$id_porcentaje_dias = $consulta_porcentaje_dias[$key]->id_porcentajes_dias;
				break;
			}
		}
		///////////////////////////////////////////////////

		/// VERIFICAMOS SI CUMPLE CON EL MINIMO DE DIAS BONGACAMS ///
		foreach ($consulta_porcentaje_dias_bonga as $key => $value) {
			if ($numero_dias >= $value->cantidad_dias && $value->estado_meta == $estado_meta) {
				/// ASIGNAMOS EL VALOR DEL % SI CuMPLE CON LOS DIAS Y META ///
				$porcentaje_dias_bonga = $value->valor_multiplicar;
				break;
			}
		}
		///////////////////////////////////////////////////
		/// CONSULTAMOS ADELANTOS ///
		$consulta_adelantos = $this->db->select_sum('valor')->from('adelanto')->where('id_empleado', $data['id_persona'])->where('estado', 'sin registrar')->get()->result();
		$adelanto = 0;
		if (!empty($consulta_adelantos[0]->valor)) {
			$adelanto = $consulta_adelantos[0]->valor;
		}
		////////////////////////////
		/// CONSULTAMOS VALOR DOLAR ///
		$consulta_valor_dolar = $this->db->select('valor_dolar,id_dolar')->from('dolar')->where('estado', 'activo')->get()->result();
		if (empty($consulta_valor_dolar)) {
			return false;
		}
		$valor_dolar = $consulta_valor_dolar[0]->valor_dolar;
		//////////////////////////////

		/// CALCULOS EMPLEADOS ///


		// CALCULOS PAGINAS GENERALES //
		$sub_total_generales = ($cantidad_horas*$porcentaje_dias)*$valor_dolar;
		// CALCULOS PAGINAS BONGACAMS
		$sub_total_bongacams = ($tokens_bonga*$porcentaje_dias_bonga)*$valor_dolar;
		

		$sub_total = $sub_total_generales+$sub_total_bongacams;

		$total = $sub_total-$adelanto;

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

		$this->db->set('id_factura', $id)->set('estado', 'registrado')->where('id_empleado', $datos['id_usuario'])->where('estado', 'sin registrar')->update('adelanto');

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
		$consulta = $this->db->select('estado_meta, cant_dias, descuento, penalizacion_horas, total_horas, porcentaje_paga, total_a_pagar, fecha_registrado, fecha_inicio, fecha_final, id_porcentaje_dias, id_factura')->select_max('fecha_registrado')->from('factura')->where('id_usuario', $id_usuario)->get();
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
