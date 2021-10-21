<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmetas extends CI_Model {

	public function getMetas() {
		$this->db->select('*');
		$this->db->from('metas');
		$metas = $this->db->get();

		if($metas->num_rows() > 0) {
			return $metas->result();
		}

		return false;
	}

	public function getMetasMonitor(){
		$this->db->select('persona.*, metas.*, usuarios.tipo_cuenta');
		$this->db->from('metas');
		$this->db->join('persona', 'persona.id_persona = metas.id_empleado');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.tipo_cuenta', 'tecnico sistemas');
		$this->db->where('metas.estado !=', 'eliminado');
		$this->db->order_by('metas.estado' , 'DESC');
		$response =  $this->db->get();

		if($response->num_rows() > 0) {
			return $response->result();
		}

		return false;
	}

	public function verMetasMonitor(){
		$this->db->select('persona.*, metas.*, usuarios.tipo_cuenta');
		$this->db->from('metas');
		$this->db->join('persona', 'persona.id_persona = metas.id_empleado');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.tipo_cuenta', 'tecnico sistemas');

		$this->db->where('metas.estado !=', 'eliminado');
		$this->db->order_by('metas.estado' , 'DESC');

		$metas = $this->db->get();

		if($metas->num_rows() > 0) {
			return $metas->result();
		}

		return false;
	}

	public function getNumHorasSupervisor($id_supervisor){
		$consulta = $this->db->select_sum('cantidad_horas')->from('registro_horas')->where(['id_supervisor' => $id_supervisor, 'estado_registro' => 'verificado'])->get();
		if($consulta->num_rows() > 0) {
			return $consulta->result();
		}

		return false;

	}

	public function getEmpleadosNullMetas($id_persona){
		$this->db->select('persona.*');
		$this->db->from('persona');
		$this->db->join('metas', 'metas.id_empleado = persona.id_persona');
		$this->db->where('metas.estado', 'sin registrar');
		$this->db->where('metas.id_empleado', $id_persona);
		$usuarios = $this->db->get();
		if($usuarios->num_rows() > 0) {
			return true;
		}

		return false;
	}
	public function getMetasOnlyEmpleado($id_persona){
		$this->db->select('metas.*');
		$this->db->from('persona');
		$this->db->join('metas', 'metas.id_empleado = persona.id_persona');
		$this->db->where('metas.estado', 'sin registrar');
		$this->db->where('metas.id_empleado', $id_persona);
		$usuarios = $this->db->get();

		return $usuarios->row();
	}

	public function verMetas(){
		$this->db->select('persona.*, metas.*, usuarios.tipo_cuenta');
		$this->db->from('metas');
		$this->db->join('persona', 'persona.id_persona = metas.id_empleado');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.tipo_cuenta', 'empleado');

		$this->db->where('metas.estado !=', 'eliminado');
		$this->db->order_by('metas.estado' , 'DESC');
		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}
	public function verMetasSupervisor(){
		$this->db->select('persona.*, metas.*, usuarios.tipo_cuenta');
		$this->db->from('metas');
		$this->db->join('persona', 'persona.id_persona = metas.id_empleado');
		$this->db->join('usuarios', 'usuarios.id_persona = persona.id_persona');
		$this->db->where('usuarios.tipo_cuenta', 'supervisor');
		$this->db->where('metas.estado !=', 'eliminado');
		$this->db->order_by('metas.estado' , 'DESC');
		$paginas = $this->db->get();

		if($paginas->num_rows() > 0) {
			return $paginas->result();
		}

		return false;
	}

	public function dataMetas($id){
		$this->db->select('*');
		$this->db->from('metas');
		$this->db->where('id_meta', $id);
		$metas = $this->db->get();
		if($metas->num_rows() > 0) {
			return $metas->result();
		}

		return false;
	}

	public function insertMetas($data){
		return $this->db->insert('metas', $data);
	}

	public function editarMeta($data){
		$this->db->where('id_meta', $data['id_meta']);
		return $this->db->update('metas', $data);
	}
	
	public function deleteMeta($id){
		$this->db->where('id_meta', $id);
		$this->db->set('estado', 'eliminado');
		return $this->db->update('metas');
	}

	public function consultarOnlyEmpleado($id_meta){
		$this->db->select('id_empleado, id_administrador');
		$this->db->from('metas');
		$this->db->where('id_meta', $id_meta);
		$consulta = $this->db->get();
		return $consulta->result();
	}

	public function actualizarMetasGeneral($id_administrador){

		$id_supervisores = $this->db->select('id_supervisor')->from('empleado_supervisor')->where('estado', 'activo')->group_by('id_supervisor')->get();
		if($id_supervisores->num_rows() > 0){
			$id_supervisores = $id_supervisores->result();
			foreach ($id_supervisores as $key => $value) {
				$this->db->select('*');
				$this->db->from('metas');
				$this->db->where('id_empleado', $value->id_supervisor);
				$this->db->where('estado', 'sin registrar');
				///////////////////////////////////////////////////////////

				$consulta_supervisor_metas = $this->db->get();

				/// Consulta para sacar ID de empleados del supervisor ///
				$this->db->select('id_empleado');
				$this->db->where('id_supervisor', $value->id_supervisor);
				$this->db->where('estado', 'activo');
				$this->db->from('empleado_supervisor');
				/////////////////////////////////////////////////////////

				$consulta_id_empleados = $this->db->get();

				if ($consulta_supervisor_metas->num_rows() > 0) {

					$consulta_supervisor_metas = $consulta_supervisor_metas->result();

					if($consulta_id_empleados->num_rows() > 0){

						$consulta_id_empleados = $consulta_id_empleados->result();
						$acum = 0;
						foreach ($consulta_id_empleados as $key => $id_empleado) {

							$this->db->select('num_horas');
							$this->db->where('estado', 'sin registrar');
							$this->db->where('id_empleado', $id_empleado->id_empleado);
							$this->db->from('metas');
		
							$consulta_cantidad_horas = $this->db->get();
							if ($consulta_cantidad_horas->num_rows() > 0) {
								$consulta_cantidad_horas = $consulta_cantidad_horas->result();
								$acum = $acum + $consulta_cantidad_horas[0]->num_horas;
							}
						}

						$data['num_horas'] = $acum;
		
						/// Update Meta supervisor ///
						$this->db->where('id_meta', $consulta_supervisor_metas[0]->id_meta);
						$this->db->update('metas', $data);
						/////////////////////////////

					}else{
						$data['num_horas'] = 0;
		
						/// Update Meta supervisor ///
						$this->db->where('id_meta', $consulta_supervisor_metas[0]->id_meta);
						$this->db->update('metas', $data);

					}

				}else{
					/// Consulta SUM para sumar cantidad horas Metas Empleados-supervisor ///
					if($consulta_id_empleados->num_rows() > 0){
						$consulta_id_empleados = $consulta_id_empleados->result();
						$acum = 0;
						foreach ($consulta_id_empleados as $key => $id_empleado) {
							$this->db->select('num_horas');
							$this->db->where('estado', 'sin registrar');
							$this->db->where('id_empleado', $id_empleado->id_empleado);
							$this->db->from('metas');
							/////////////////////////////////////////////////////////////////////////
		
							$consulta_cantidad_horas = $this->db->get();
							if ($consulta_cantidad_horas->num_rows() > 0) {
								$datos_consulta_cantidad_horas = $consulta_cantidad_horas->result();
								$acum = $acum + $datos_consulta_cantidad_horas[0]->num_horas;
							}
						}
						/////////////////////////////////////////////////////////////////////////
		
						/// Datos insert ///
						$data['num_horas'] = $acum;
						$data['id_empleado'] = $value->id_supervisor;
						$data['id_administrador'] = $id_administrador;
						$data['descripcion'] = "ninguna";
						$data['estado'] = "sin registrar";
						///////////////////
		
						/// Insert Meta Supervisor ///
						$this->db->insert('metas', $data);
						/////////////////////////////
					}else{
						continue;
					}
				}
			}
			return true;
		}else{
			return false;
		}
		

	}

	public function actualizarMetaSupervisor($id_empleado, $id_administrador){

		/// Consulta Si existe relacion con supervisor  ////
		$this->db->select('id_supervisor');
		$this->db->where('estado', 'activo');
		$this->db->where('id_empleado', $id_empleado);
		$this->db->from('empleado_supervisor');
		///////////////////////////////////////////////////

		$consulta_id_supervisor = $this->db->get();
		if($consulta_id_supervisor->num_rows() > 0) {
			$datos_supervisor = $consulta_id_supervisor->result();

			/// Consulta Si el supervisor tiene alguna meta activa ////
			$this->db->select('*');
			$this->db->from('metas');
			$this->db->where('id_empleado', $datos_supervisor[0]->id_supervisor);
			$this->db->where('estado', 'sin registrar');
			///////////////////////////////////////////////////////////

			$consulta_supervisor_metas = $this->db->get();

			/// Consulta para sacar ID de empleados del supervisor ///
			$this->db->select('id_empleado');
			$this->db->where('id_supervisor', $datos_supervisor[0]->id_supervisor);
			$this->db->where('estado', 'activo');
			$this->db->from('empleado_supervisor');
			/////////////////////////////////////////////////////////

			$consulta_id_empleados = $this->db->get();
			$datos_consulta_id_empleados = $consulta_id_empleados->result();

			if ($consulta_supervisor_metas->num_rows() > 0) {
				$datos_consulta_supervisor_metas = $consulta_supervisor_metas->result();

				/// Consulta SUM para sumar cantidad horas Metas Empleados-supervisor ///
				$acum = 0;
				foreach ($datos_consulta_id_empleados as $key => $value) {
					$this->db->select('num_horas');
					$this->db->where('estado', 'sin registrar');
					$this->db->where('id_empleado', $value->id_empleado);
					$this->db->from('metas');
					/////////////////////////////////////////////////////////////////////////

					$consulta_cantidad_horas = $this->db->get();
					if ($consulta_cantidad_horas->num_rows() > 0) {
						$datos_consulta_cantidad_horas = $consulta_cantidad_horas->result();
						$acum = $acum + $datos_consulta_cantidad_horas[0]->num_horas;
					}
				}
				$data['num_horas'] = $acum;

				/// Update Meta supervisor ///
				$this->db->where('id_meta', $datos_consulta_supervisor_metas[0]->id_meta);
				return $this->db->update('metas', $data);
				/////////////////////////////

			}else{
				/// Consulta SUM para sumar cantidad horas Metas Empleados-supervisor ///
				$acum = 0;
				foreach ($datos_consulta_id_empleados as $key => $value) {
					$this->db->select('num_horas');
					$this->db->where('estado', 'sin registrar');
					$this->db->where('id_empleado', $value->id_empleado);
					$this->db->from('metas');
					/////////////////////////////////////////////////////////////////////////

					$consulta_cantidad_horas = $this->db->get();
					if ($consulta_cantidad_horas->num_rows() > 0) {
						$datos_consulta_cantidad_horas = $consulta_cantidad_horas->result();
						$acum = $acum + $datos_consulta_cantidad_horas[0]->num_horas;
					}
				}
				/////////////////////////////////////////////////////////////////////////

				/// Datos insert ///
				$data['num_horas'] = $acum;
				$data['id_empleado'] = $datos_supervisor[0]->id_supervisor;
				$data['id_administrador'] = $id_administrador;
				$data['descripcion'] = "ninguna";
				$data['estado'] = "sin registrar";
				///////////////////

				/// Insert Meta Supervisor ///
				return $this->db->insert('metas', $data);
				/////////////////////////////
			}

		}else{
			return false;
		}
	}

	public function actualizarMetaTecnicoSistemas($id_administrador){
		// Sacamos al tecnico en sistemas
		$this->db->select('id_persona');
		$this->db->where('estado', 'activo');
		$this->db->where('tipo_cuenta', 'tecnico sistemas');
		$this->db->from('usuarios');
		$response = $this->db->get();
		if($response->num_rows() > 0){
			$datos = $response->result();
			// Consultamos si tiene meta activa
			$this->db->select('*');
			$this->db->from('metas');
			$this->db->where('id_empleado', $datos[0]->id_persona);
			$this->db->where('estado', 'sin registrar');
			$meta = $this->db->get();
			////////////////////////////////////
			// Consultamos los supervisores 
			$this->db->select('id_persona');
			$this->db->where('estado', 'activo');
			$this->db->where('tipo_cuenta', 'supervisor');
			$this->db->from('usuarios');
			$supervisores = $this->db->get();
			$supervisores_datos = $supervisores->result();
			//////////////////////////////////////////////
			if ($meta->num_rows() > 0) {
				$datos_meta = $meta->result();

				/// Consulta SUM para sumar cantidad horas Metas de los supervisores ///
				$acum = 0;
				foreach ($supervisores_datos as $key => $value) {
					$this->db->select('num_horas');
					$this->db->where('estado', 'sin registrar');
					$this->db->where('id_empleado', $value->id_persona);
					$this->db->from('metas');
					/////////////////////////////////////////////////////////////////////////

					$consulta_cantidad_horas = $this->db->get();
					if ($consulta_cantidad_horas->num_rows() > 0) {
						$datos_consulta_cantidad_horas = $consulta_cantidad_horas->result();
						$acum = $acum + $datos_consulta_cantidad_horas[0]->num_horas;
					}
				}
				$data['num_horas'] = $acum;

				/// Update Meta supervisor ///
				$this->db->where('id_meta', $datos_meta[0]->id_meta);
				return $this->db->update('metas', $data);
				/////////////////////////////
			}else{
				/// Consulta SUM para sumar cantidad horas Metas de los supervisores ///
				$acum = 0;
				foreach ($supervisores_datos as $key => $value) {
					$this->db->select('num_horas');
					$this->db->where('estado', 'sin registrar');
					$this->db->where('id_empleado', $value->id_persona);
					$this->db->from('metas');
					/////////////////////////////////////////////////////////////////////////

					$consulta_cantidad_horas = $this->db->get();
					if ($consulta_cantidad_horas->num_rows() > 0) {
						$datos_consulta_cantidad_horas = $consulta_cantidad_horas->result();
						$acum = $acum + $datos_consulta_cantidad_horas[0]->num_horas;
					}
				}
				/////////////////////////////////////////////////////////////////////////

				/// Datos insert ///
				$data['num_horas'] = $acum;
				$data['id_empleado'] = $datos[0]->id_persona;
				$data['id_administrador'] = $id_administrador;
				$data['descripcion'] = "ninguna";
				$data['estado'] = "sin registrar";
				///////////////////

				/// Insert Meta Supervisor ///
				return $this->db->insert('metas', $data);
				/////////////////////////////
			}
			
		}else{
			return false;
		}
	}

	public function consultarMetasEmpleados($id_supervisor){
		$this->db->select('id_empleado');
		$this->db->from('empleado_supervisor');
		$this->db->where('id_supervisor', $id_supervisor);
		$this->db->where('estado', 'activo');
		$consulta_id_empleados = $this->db->get();
		$datos_consulta_id_empleados = $consulta_id_empleados->result();

		$this->db->select('metas.*, persona.*');
		$this->db->from('metas');
		$this->db->join('persona', 'persona.id_persona = metas.id_empleado');
		$this->db->where('metas.estado', 'sin registrar');

		foreach ($datos_consulta_id_empleados as $key => $value) {
			if ($key == 0) {
				$this->db->where('id_empleado', $value->id_empleado);
			}else{
				$this->db->or_where('id_empleado', $value->id_empleado);
			}
		}

		$consulta_id_metas = $this->db->get();
		return $consulta_id_metas->result();

	}

	// public function actualizarMetaSupervisorDelete($id_empleado, $id_meta){
	// 	$this->db->select('num_horas');
	// 	$this->db->where('id_meta', $id_meta);
	// 	$this->db->from('metas');
	// 	$consulta_num_horas = $this->db->get();
	// 	$datos_consulta_num_horas = $consulta_num_horas->result();

	// 	/// Consulta Si existe relacion con supervisor  ////
	// 	$this->db->select('id_supervisor');
	// 	$this->db->where('estado', 'activo');
	// 	$this->db->where('id_empleado', $id_empleado);
	// 	$this->db->from('empleado_supervisor');
	// 	///////////////////////////////////////////////////

	// 	$consulta_id_supervisor = $this->db->get();
	// 	if($consulta_id_supervisor->num_rows() > 0) {
	// 		$datos_supervisor = $consulta_id_supervisor->result();

	// 		/// Consulta Si el supervisor tiene alguna meta activa ////
	// 		$this->db->select('*');
	// 		$this->db->from('metas');
	// 		$this->db->where('id_empleado', $datos_supervisor[0]->id_supervisor);
	// 		$this->db->where('estado', 'sin registrar');
	// 		///////////////////////////////////////////////////////////

	// 		$consulta_supervisor_metas = $this->db->get();

	// 		/// Consulta para sacar ID de empleados del supervisor ///
	// 		$this->db->select('id_empleado');
	// 		$this->db->where('id_supervisor', $datos_supervisor[0]->id_supervisor);
	// 		$this->db->where('estado', 'activo');
	// 		$this->db->from('empleado_supervisor');
	// 		/////////////////////////////////////////////////////////

	// 		$consulta_id_empleados = $this->db->get();
	// 		$datos_consulta_id_empleados = $consulta_id_empleados->result();

	// 		if ($consulta_supervisor_metas->num_rows() > 0) {
	// 			$datos_consulta_supervisor_metas = $consulta_supervisor_metas->result();

	// 			/// Consulta SUM para sumar cantidad horas Metas Empleados-supervisor ///
	// 			$this->db->select_sum('num_horas');
	// 			$this->db->where('estado', 'sin registrar');
	// 			foreach ($datos_consulta_id_empleados as $key => $value) {
	// 				if ($key == 0) {
	// 					$this->db->where('id_empleado', $value->id_empleado);
	// 				}else{
	// 					$this->db->or_where('id_empleado', $value->id_empleado);
	// 				}
	// 			}
	// 			$this->db->from('metas');
	// 			/////////////////////////////////////////////////////////////////////////

	// 			$consulta_cantidad_horas = $this->db->get();
	// 			$datos_consulta_cantidad_horas = $consulta_cantidad_horas->result();
	// 			$data['num_horas'] = $datos_consulta_cantidad_horas[0]->num_horas - $datos_consulta_num_horas[0]->num_horas;

	// 			/// Update Meta supervisor ///
	// 			$this->db->where('id_meta', $datos_consulta_supervisor_metas[0]->id_meta);
	// 			return $this->db->update('metas', $data);
	// 			/////////////////////////////

	// 		}

	// 	}else{
	// 		return false;
	// 	}
	// }	
}
