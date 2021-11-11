<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MfacturaMonitor extends CI_Model {

	public function getFacturas(){
		$this->db->select('*');
		$this->db->from('factura_tecnico');
		$arreglo = $this->db->get();

		if($arreglo->num_rows() > 0) {
			return $arreglo->result();
		}

		return false;
	}
	public function getFacturasTable($data) {
		$this->db->select('persona.*, factura_tecnico.*');
		$this->db->from('factura_tecnico');
		$this->db->join('persona', 'persona.id_persona = factura_tecnico.id_empleado');
		if($data['fecha_inicio'] != ""){
			$this->db->where('fecha_inicial >=', $data['fecha_inicio']);
		}
		if($data['fecha_final'] != ""){
			$this->db->where('fecha_inicial <=', $data['fecha_final']);
		}
		
		$this->db->order_by('factura_tecnico.created_at' , 'DESC');

		$usuarios = $this->db->get();

		if($usuarios->num_rows() > 0) {
			return $usuarios->result();
		}

		return false;
	}

	public function generarFactura($data){
		// Consultamos a los supervisores 
		$supervisores = $this->db->select('persona.id_persona')->from('persona')->join('usuarios', 'usuarios.id_persona = persona.id_persona')->where('usuarios.estado', 'activo')->where('tipo_cuenta', 'tecnico sistemas')->get();
		if ($supervisores->num_rows() > 0) {

			// sueldo del supervisor
			$sueldo_supervisor = $this->db->select('sueldo,id_sueldos_empleados')->from('sueldos_empleados')->where('tipo_usuario', 'tecnico sistemas')->where('estado', 'activo')->get()->result();

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
				$aux_aumento = 0;
				$datos_insert = [];
				$datos_insert['descuento'] = 0;
				$id_adelanto = 0;
				$adelanto_cantidad_cuotas = 0;
				$adelanto_cantidad_cuotas_aux = 0;
				$adelanto_cantidad_total = 0;
				$adelanto_cantidad_total_aux = 0;
				$estado_adelanto = "";
				$bandera_adelanto = false;
				$bandera_adelanto_proceso = false;

				// CONSULTAMOS ADELANTOS
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

				// CONSULTAMOS DESCUENTOS DE DIAS

				$descuentos = $this->db->select('id, valor')->from('dias_descontados')->where('id_persona', $valor_s->id_persona)->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->where('estado', 'sin registrar')->get();
				if($descuentos->num_rows() > 0){
					foreach ($descuentos->result() as $key => $descuento) {
						$aux_descuentos = $aux_descuentos+$descuento->valor;
					}
				}

				// CONSULTAMOS AUMENTOS

				$aumentos = $this->db->select('valor')->from('aumentos')->where('id_persona', $valor_s->id_persona)->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->get();
				if($aumentos->num_rows() > 0){
					foreach ($aumentos->result() as $key => $aumento) {
						$aux_aumento = $aux_aumento+$aumento->valor;
					}
				}

				$aux_horas_total = 0;
				// CONSULTAMOS LAS HORAS DE LAS MODELOS
				$modelos = $this->db->select('id_persona')->from('usuarios')->where('estado', 'activo')->where('tipo_cuenta', 'supervisor')->get();
				if($modelos->num_rows() > 0){
					foreach ($modelos->result() as $key => $modelo) {
						$nomina_modelo = $this->db->select('cant_horas')->from('factura_supervisor')->where('id_empleado', $modelo->id_persona)->where('fecha_inicial >=', $data['fecha_inicial'])->where('fecha_inicial <=', $data['fecha_final'])->where('id_factura_tecnico', null)->get();
						if($nomina_modelo->num_rows()>0){
							$nomina_modelo = $nomina_modelo->result();
							$aux_horas_total = $aux_horas_total+$nomina_modelo[0]->cant_horas;
						}
					}
				}
				
				// VERIFICAMOS SI EL SUPERVISOR CUMPLE LAS METAS DE HORAS
				$aux_comision = 0;

				$meta_supervisor = $this->db->select('*')->from('metas_supervisor')->where('estado', 'activo')->order_by('tokens', 'DESC')->get();
				if($meta_supervisor->num_rows()>0){
					foreach ($meta_supervisor->result() as $key => $meta_sup) {
						if($aux_horas_total >= $meta_sup->tokens){
							$datos_insert['estado_meta'] = "completada";
							$datos_insert['id_meta_supervisor'] = $meta_sup->id;
							$aux_comision = $meta_sup->aumento;
						}else{
							$datos_insert['estado_meta'] = "incompleta";
						}
					}
				}else{
					break;
				}

				
				//////////////////////////////////////////

				// SI CUMPLE LA META SE LE DA COMISION
				if ($datos_insert['estado_meta'] == "completada") {
					$datos_insert['comision'] = $aux_comision;
				}else{
					$datos_insert['comision'] = 0;
				}

				/////////////////////////////////////////////////
				//INSERTAMOS LOS DATOS
				$datos_insert['descuento'] = $aux_descuentos+$aux_adelanto;
				$datos_insert['cant_horas'] = $aux_horas_total;
				$datos_insert['aumento'] = $aux_aumento;
				$datos_insert['id_empleado'] = $valor_s->id_persona;
				$datos_insert['id_administrador'] = $data['id_administrador'];
				$datos_insert['id_sueldo'] = $sueldo_supervisor[0]->id_sueldos_empleados;
				$datos_insert['id_meta'] = $meta[0]->id_meta;
				$datos_insert['total_paga'] = ((($sueldo_supervisor[0]->sueldo/2)+$datos_insert['comision'])-$datos_insert['descuento'])+$aux_aumento;
				$datos_insert['fecha_inicial'] = $data['fecha_inicial']; 
				$datos_insert['fecha_final'] = $data['fecha_final'];
				$datos_insert['estado'] = "sin registrar";

				$this->db->insert('factura_tecnico', $datos_insert);

				$id = $this->db->insert_id();
				// VERIFICAMOS SI TENIA ADELANTOS, SI LO TENIA FINALIZAMOS EL DESCUENTO DEL ADELANTO
				if($bandera_adelanto){
					$datos_insert_adelantos['id_adelanto'] = $id_adelanto;
					$datos_insert_adelantos['id_factura_tecnico'] = $id;
					$datos_insert_adelantos['valor'] = $aux_adelanto;
					$this->db->insert('adelanto_factura', $datos_insert_adelantos);
					if($adelanto_cantidad_cuotas_aux == 0){
						$this->db->set('estado', 'registrado')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $valor_s->id_persona)->where('estado', $estado_adelanto)->update('adelanto');
					}else{
						$this->db->set('estado', 'pagando')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $valor_s->id_persona)->where('estado', $estado_adelanto)->update('adelanto');
					}
				}
				if($bandera_adelanto_proceso){
					$datos_insert_adelantos['id_adelanto'] = $id_adelanto;
					$datos_insert_adelantos['id_factura_tecnico'] = $id;
					$datos_insert_adelantos['valor'] = $aux_adelanto;
					$this->db->insert('adelanto_factura', $datos_insert_adelantos);
					if($adelanto_cantidad_cuotas_aux == 0){
						$this->db->set('estado', 'registrado')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $valor_s->id_persona)->where('estado', $estado_adelanto)->update('adelanto');
					}else{
						$this->db->set('estado', 'pagando')->set('cuota_aux', $adelanto_cantidad_cuotas_aux)->set('valor_aux', $adelanto_cantidad_total_aux)->where('id_empleado', $valor_s->id_persona)->where('estado', $estado_adelanto)->update('adelanto');
					}
				}
				if(!$aux_descuentos == 0){
					$this->db->set('id_factura_tecnico', $id)->set('estado', 'registrado')->where('id_persona', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->update('dias_descontados');
				}
				if(!$aux_aumento == 0){
					$this->db->set('id_factura_tecnico', $id)->set('estado', 'registrado')->where('id_persona', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->where('fecha >=', $data['fecha_inicial'])->where('fecha <=', $data['fecha_final'])->update('aumentos');
				}
				// ASIGNAMOS LA NOMINA DEL SUPERVISOR A LA NOMINA DE LA MODELO

				$modelos = $this->db->select('id_persona')->from('usuarios')->where('estado', 'activo')->where('tipo_cuenta', 'supervisor')->get();
				if($modelos->num_rows() > 0){
					foreach ($modelos->result() as $key => $modelo) {
						$nomina_modelo = $this->db->select('*')->from('factura_supervisor')->where('id_empleado', $modelo->id_persona)->where('fecha_inicial >=', $data['fecha_inicial'])->where('fecha_inicial <=', $data['fecha_final'])->where('id_factura_tecnico', null)->get();
						if($nomina_modelo->num_rows()>0){
							$this->db->set('id_factura_tecnico', $id)->where('id_empleado', $modelo->id_persona)->where('fecha_inicial >=', $data['fecha_inicial'])->where('fecha_inicial <=', $data['fecha_final'])->where('id_factura_tecnico', null)->update('factura_supervisor');
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
}
