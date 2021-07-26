<?php
require_once ("ClsConex.php");

class ClsTempBoletaCobro extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
  
//----------Temporal de Boleta de Cobro con Temporal Alumno ---------//
	function get_boleta_cobro_temportal_temporal($pensum = '',$nivel = '',$grado = '',$seccion = '',$cuenta = '',$banco = '',$sit = '') {
		$cod = trim($cod);	
	    $sql= "SELECT * ";
		$sql.= " FROM temp_alumnos, temp_boleta_cobro";
		$sql.= " WHERE talu_codigo = bol_alumno_codigo";
		if(strlen($pensum)>0) { 
			  $sql.= " AND talu_pensum = '$pensum'"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND talu_nivel = '$nivel'"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND talu_grado = '$grado'"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND talu_seccion = '$seccion'"; 
		}
		if(strlen($cuenta)>0) { 
			  $sql.= " AND bol_cuenta = '$cuenta'"; 
		}
		if(strlen($banco)>0) { 
			  $sql.= " AND bol_banco = '$banco'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND talu_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY talu_pensum ASC, talu_nivel ASC, talu_grado ASC, talu_seccion ASC, talu_apellido ASC, talu_nombre ASC, bol_banco ASC, bol_cuenta ASC, bol_fecha_pago ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	

//----------Temporal de Boleta de Cobro con Tabla Alumno ---------//	

	function get_boleta_cobro_temporal_alumno($pensum = '',$nivel = '',$grado = '',$seccion = '',$cuenta = '',$banco = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT * ";
		$sql.= " FROM academ_seccion_alumno, app_alumnos, temp_boleta_cobro";
		$sql.= " WHERE seca_alumno COLLATE utf8_unicode_ci = alu_cui";
		$sql.= " AND alu_codigo_interno = bol_alumno_codigo";
		
		if(strlen($pensum)>0) { 
			  $sql.= " AND seca_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND seca_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND seca_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND seca_seccion = $seccion"; 
		}
		if(strlen($cuenta)>0) { 
			  $sql.= " AND bol_cuenta = '$cuenta'"; 
		}
		if(strlen($banco)>0) { 
			  $sql.= " AND bol_banco = '$banco'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		$sql.= " ORDER BY seca_pensum ASC, seca_nivel ASC, seca_grado ASC, seca_seccion ASC, alu_apellido ASC, alu_nombre ASC, bol_banco ASC, bol_cuenta ASC, bol_fecha_pago ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	//----------Temporal de Boleta Pagada con Tabla Alumno ---------//	

	function get_boleta_pagada_temporal_alumno($ncuenta){
		$tipo = trim($tipo);
		
        $sql= "SELECT * ";
		$sql.= " FROM temp_boleta_pagada LEFT JOIN app_alumnos";
		$sql.= " ON alu_codigo_interno = pag_alumno";
		
		if(strlen($ncuenta)>0) { 
			  $sql.= " WHERE pag_cuenta = $ncuenta"; 
		}
		$sql.= " ORDER BY alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
}	
?>
