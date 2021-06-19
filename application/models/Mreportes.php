<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mreportes extends CI_Model {
    public function getReportes($id_tecnico){
        $consulta = $this->db->select('*')->from('reportes')->where('id_tecnico', $id_tecnico)->get();
        if ($consulta->num_rows() > 0) {
            return $consulta->result();
        }
        return false;
	}
	
	public function getReportesAdmin(){
        $consulta = $this->db->select('*')->from('reportes')->get();
        if ($consulta->num_rows() > 0) {
            return $consulta->result();
        }
        return false;
    }

    public function addReporte($data){
        return $this->db->insert('reportes', $data);
    }

    public function getDataReportes($id_usuario , $fecha_inicial, $fecha_final, $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('*')->from('reportes')->where('id_tecnico', $id_usuario);
		if ($fecha_inicial != null) {
			$this->db->where('fecha >=', $fecha_inicial);
		}
		if ($fecha_final != null) {
			$this->db->where('fecha <=', $fecha_final);
		}

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
        }
        
		$informes = $this->db->get();

		if($informes->num_rows() > 0) {
			return $informes->result();
		}

		return false;
	}

	public function getDataReportesAdmin($fecha_inicial, $fecha_final, $inicio = FALSE , $registros_pagina = FALSE) {
		$this->db->select('reportes.*, persona.nombres, persona.documento, persona.apellidos')->from('reportes')->join('persona', 'reportes.id_tecnico = persona.id_persona');
		if ($fecha_inicial != null) {
			$this->db->where('fecha >=', $fecha_inicial);
		}
		if ($fecha_final != null) {
			$this->db->where('fecha <=', $fecha_final);
		}

		if($inicio !== FALSE && $registros_pagina !== FALSE) {
			$this->db->limit($registros_pagina , $inicio);
        }
        
		$informes = $this->db->get();

		if($informes->num_rows() > 0) {
			return $informes->result();
		}

		return false;
	}



	public function getDataOnlyReporte($id){
		$consulta = $this->db->select('*')->from('reportes')->where('id_reporte', $id)->get()->result();
		return $consulta;
	}

	public function editarReporte($data){
		$this->db->where('id_reporte', $data['id_reporte']);
		return $this->db->update('reportes', $data);
	}
}
