<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mregistronomina extends CI_Model {
	
	public function registrarNomina($data){

		/// SACAMOS LA CANTIDAD DE ASISTENCIA DEL EMPLEADO ///
		$sub_consulta='(asistencia_empleado.estado = "registrado" OR asistencia_empleado.motivo IN (SELECT id_motivo FROM motivo_asistencia WHERE descuenta = "No"))';

		$consulta_asistencia = $this->db->select('asistencia_empleado.*, asistencia.fecha')->from('asistencia_empleado')->join('asistencia', 'asistencia.id_asistencia = asistencia_empleado.id_asistencia')->where('asistencia.fecha <=', $data['fecha_final'])->where('asistencia.fecha >=', $data['fecha_inicial'])->where('id_empleado', $data['id_persona'])->where($sub_consulta)->get()->result();

		$numero_dias = count($consulta_asistencia);
		////////////////////////////////////////////////////

		

		/// CONSULTAMOS PENALIZACIONES ///
		$consulta_penalizaciones = $this->db->select_sum('puntos')->from('empleado_penalizacion')->where('estado', 'sin registrar')->where('id_empleado', $data['id_persona'])->where('fecha_registrado <=', $data['fecha_final'])->where('fecha_registrado >=', $data['fecha_inicial'])->get()->result();
		$num_penalizacion = $consulta_penalizaciones[0]->puntos;
		if (empty($consulta_penalizaciones[0]->puntos)) {
			$num_penalizacion = 0;
		}
		/////////////////////////////////

		/// CONSULTAMOS LAS HORAS DEL EMPLEADO ///
		$consulta_registro_horas = $this->db->select_sum('cantidad_horas')->from('registro_horas')->where('id_empleado', $data['id_persona'])->where('estado_registro', 'verificado')->where('fecha_registro <=', $data['fecha_final'])->where('fecha_registro >=', $data['fecha_inicial'])->get()->result();


		$cantidad_horas = $consulta_registro_horas[0]->cantidad_horas-$num_penalizacion;
		/////////////////////////////////////////
		/// CONSULTAMOS LA META DEL EMPLEADO Y VERIFICAMOS SI CUMPLIO LA META ///
		$consulta_meta = $this->db->select('num_horas, id_meta')->from('metas')->where('id_empleado', $data['id_persona'])->where('estado', 'sin registrar')->get()->result();
		$estado_meta = "incompleta";
		if ($cantidad_horas>=$consulta_meta[0]->num_horas) {
			$estado_meta = "completa";
		}
		/////////////////////////////////////////////////////////////////////////

		/// CONSULTAMOS EL PORCENTAJE DE LOS DIAS ///
		$consulta_porcentaje_dias = $this->db->select('cantidad_dias,valor,id_porcentajes_dias,estado_meta')->from('porcentajes_dias')->where('estado', 'activo')->order_by('cantidad_dias', 'desc')->get()->result();
		$porcentaje_dias = 0;
		$id_porcentaje_dias = null;
		////////////////////////////////////////////

		/// VERIFICAMOS SI CUMPLE CON EL MINIMO DE DIAS ///
		foreach ($consulta_porcentaje_dias as $key => $value) {
			if ($numero_dias >= $value->cantidad_dias && $value->estado_meta == $estado_meta) {
				/// ASIGNAMOS EL VALOR DEL % SI CuMPLE CON LOS DIAS Y META ///
				$porcentaje_dias = $value->valor;
				$id_porcentaje_dias = $consulta_porcentaje_dias[$key]->id_porcentajes_dias;
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

		$sub_total = $valor_dolar*$cantidad_horas;

		$total = (($sub_total+(($sub_total/100)*$porcentaje_dias))-$adelanto);

		///////////////

		/// CALCULOS INGRESOS ///

		$porcentaje_ingreso = 100-$porcentaje_dias;

		$total_ingreso = ($sub_total/100)*$porcentaje_ingreso;

		//////////////////////////



		/// INSERT DATOS A FACTURA ///
		$datos['id_meta'] = $consulta_meta[0]->id_meta;
		$datos['estado_meta'] = $estado_meta;
		$datos['id_usuario'] = $data['id_persona'];
		$datos['id_talento_humano'] = $data['id_talento'];
		$datos['id_dolar'] = $consulta_valor_dolar[0]->id_dolar;
		$datos['id_porcentaje_dias'] = $id_porcentaje_dias;
		$datos['descuento'] = $adelanto;
		$datos['total_horas'] = $cantidad_horas;
		$datos['total_a_pagar'] = $total;
		$datos['estado_factura'] = "sin registrar";
		$datos['penalizacion_horas'] = $num_penalizacion;
		$datos['porcentaje_paga'] = $porcentaje_dias;
		$datos['cant_dias'] = $numero_dias;
		$datos['fecha_inicio'] = $data['fecha_inicial'];
		$datos['fecha_final'] = $data['fecha_final'];

		$this->db->insert('factura', $datos);

		$id = $this->db->insert_id();

		/// DATOS INSERT INGRESOS ///

		$data_ingreso['id_factura'] = $id;
		$data_ingreso['valor'] = $total_ingreso;
		$data_ingreso['porcentaje'] = $porcentaje_ingreso;

		////////////////////////////

		$this->db->insert('ingresos', $data_ingreso);

		$this->db->set('id_factura', $id)->set('estado', 'registrado')->where('id_empleado', $datos['id_usuario'])->where('estado', 'sin registrar')->update('adelanto');

		$this->db->set('id_factura', $id)->set('estado', 'registrado')->where('id_empleado', $datos['id_usuario'])->where('fecha_registrado >=', $data['fecha_inicial'])->where('fecha_registrado <=', $data['fecha_final'])->update('empleado_penalizacion');

		$this->db->set('estado', 'registrado')->where('id_meta', $datos['id_meta'])->update('metas');

		return $this->db->set('id_factura', $id)->set('estado_registro', 'registrado')->where('id_empleado', $datos['id_usuario'])->where('fecha_registro >=', $data['fecha_inicial'])->where('fecha_registro <=', $data['fecha_final'])->where('estado_registro', 'verificado')->update('registro_horas');
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

	public function getFacturasAdmin($valor, $fecha_inicial, $fecha_final, $inicio = FALSE, $registros_pagina = FALSE) {
		$this->db->select('b.*, factura.*,dolar.*, metas.num_horas');
		$this->db->from('factura');
		$this->db->join('dolar', 'dolar.id_dolar = factura.id_dolar');
		$this->db->join('persona as b', 'b.id_persona = factura.id_usuario');
		$this->db->join('metas', 'metas.id_meta = factura.id_meta');

		if ($fecha_inicial != null) {
			$this->db->where('factura.fecha_registrado >=', $fecha_inicial);
		}
		if ($fecha_final != null) {
			$this->db->where('factura.fecha_registrado <=', $fecha_final);
		}
		
		$this->db->order_by('factura.fecha_registrado' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function getFacturas($valor, $id_usuario, $fecha_inicial, $fecha_final, $inicio = FALSE, $registros_pagina = FALSE) {
		$this->db->select('b.*, factura.*,dolar.*');
		$this->db->from('factura');
		$this->db->join('dolar', 'dolar.id_dolar = factura.id_dolar');

		$this->db->join('persona as b', 'b.id_persona = factura.id_usuario');
		$this->db->where('factura.id_talento_humano', $id_usuario);

		if ($fecha_inicial != null) {
			$this->db->where('factura.fecha_registrado >=', $fecha_inicial);
		}
		if ($fecha_final != null) {
			$this->db->where('factura.fecha_registrado <=', $fecha_final);
		}
		
		$this->db->order_by('factura.fecha_registrado' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			
			return $usuarios->result();
		}

		return false;
	}

	public function getRegistrosFacturas($valor, $id_factura, $fecha_inicial, $fecha_final, $inicio = FALSE, $registros_pagina = FALSE) {
		$this->db->select('registro_horas.*,persona.*,paginas.*');
		$this->db->from('registro_horas');
		$this->db->join('persona', 'persona.id_persona = registro_horas.id_empleado');
		$this->db->join('paginas', 'paginas.id_pagina = registro_horas.id_pagina');
		$this->db->where('registro_horas.id_factura', $id_factura);

		if ($fecha_inicial != null) {
			$this->db->where('registro_horas.fecha_registro >=', $fecha_inicial);
		}
		if ($fecha_final != null) {
			$this->db->where('registro_horas.fecha_registro <=', $fecha_final);
		}
		
		$this->db->order_by('registro_horas.fecha_registro' , 'DESC');

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
		}
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

		$consulta = $this->db->select('factura.*, persona.documento, persona.nombres, persona.apellidos, dolar.valor_dolar, registro_horas.cantidad_horas, registro_horas.fecha_registro as horas_factura')->from('factura')->join('persona', 'persona.id_persona = factura.id_usuario')->join('dolar', 'dolar.id_dolar = factura.id_dolar')->join('registro_horas', 'registro_horas.id_factura = factura.id_factura')->where('factura.id_factura', $id)->get()->result();
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