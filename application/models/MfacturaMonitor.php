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
	public function getFacturasTable() {
		$this->db->select('persona.*, factura_tecnico.*,metas_supervisor.tokens');
		$this->db->from('factura_tecnico');
		$this->db->join('persona', 'persona.id_persona = factura_tecnico.id_empleado');
		$this->db->join('metas_supervisor', 'factura_tecnico.id_meta_supervisor = metas_supervisor.id');

		
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
				$datos_insert['id_empleado'] = $valor_s->id_persona;
				$datos_insert['id_administrador'] = $data['id_administrador'];
				$datos_insert['id_sueldo'] = $sueldo_supervisor[0]->id_sueldos_empleados;
				$datos_insert['id_meta'] = $meta[0]->id_meta;
				$datos_insert['total_paga'] = ($sueldo_supervisor[0]->sueldo+$datos_insert['comision'])-$datos_insert['descuento'];
				$datos_insert['fecha_inicial'] = $data['fecha_inicial']; 
				$datos_insert['fecha_final'] = $data['fecha_final'];
				$datos_insert['estado'] = "sin registrar";

				$this->db->insert('factura_tecnico', $datos_insert);

				$id = $this->db->insert_id();
				// VERIFICAMOS SI TENIA ADELANTOS, SI LO TENIA FINALIZAMOS EL DESCUENTO DEL ADELANTO
				if (!$aux_adelanto == 0) {
					$this->db->set('id_factura_tecnico', $id)->set('estado', 'registrado')->where('id_empleado', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->update('adelanto');
				}
				if(!$aux_descuentos == 0){
					$this->db->set('id_factura_tecnico', $id)->set('estado', 'registrado')->where('id_persona', $datos_insert['id_empleado'])->where('estado', 'sin registrar')->update('dias_descontados');
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
