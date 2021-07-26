<?php
require_once ("ClsConex.php");

class ClsPanial extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  POST-IT o Notificaciones //////////////////////////////////////
//////////////  TODOS //////////////////
  
    function get_panial($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$alumno = '',$desde = '',$fecha = '',$sit = '') {
		
		$sql= "SELECT *, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = pan_pensum"; 
		$sql.= " AND gra_nivel = pan_nivel"; 
		$sql.= " AND gra_codigo = pan_grado) as pan_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = pan_pensum"; 
		$sql.= " AND sec_nivel = pan_nivel"; 
		$sql.= " AND sec_grado = pan_grado"; 
		$sql.= " AND sec_codigo = pan_seccion) as pan_seccion_desc,";
        //--- subquery target --//
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = pan_alumno) as alu_foto";
		//--
		$sql.= " FROM app_panial,app_alumnos";
		$sql.= " WHERE alu_cui = pan_alumno";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pan_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND pan_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND pan_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND pan_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND pan_seccion IN($seccion)";
		}	
		if(strlen($alumno)>0) { 
			$sql.= " AND pan_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND pan_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND pan_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND pan_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pan_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY pan_fecha_registro DESC, pan_nivel ASC, pan_grado ASC, pan_seccion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_panial($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$alumno = '',$desde = '',$fecha = '',$sit = '') {
		$pipi = trim($pipi);
		$obs = trim($obs);
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_panial";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pan_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND pan_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND pan_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND pan_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND pan_seccion IN($seccion)";
		}	
		if(strlen($alumno)>0) { 
			$sql.= " AND pan_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND pan_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND pan_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND pan_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pan_situacion = '$sit'"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	

	
	function insert_panial($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$pipi,$popo,$tipo,$obs,$usu=''){
		$tipo = trim($tipo);
		$obs = trim($obs);
		$usu = ($usu == "")?$_SESSION["codigo"]:$usu;
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_panial";
		$sql.= " VALUES ($codigo,$pensum,$nivel,$grado,$seccion,'$alumno','$pipi','$popo','$tipo','$obs','$freg','$usu',1);";
		//echo $sql;
		return $sql;
	}
    
    
	
	function modifica_panial($codigo,$alumno,$pipi,$popo,$tipo,$obs){
		$tipo = trim($tipo);
		$obs = trim($obs);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_panial SET ";
		$sql.= "pan_alumno = '$alumno',"; 
		$sql.= "pan_cant_pipi = '$pipi',"; 
		$sql.= "pan_cant_popo = '$popo',"; 
		$sql.= "pan_tipo = '$tipo',"; 
		$sql.= "pan_observaciones = '$obs',"; 		
		$sql.= "pan_fecha_registro = '$freg'";
		
		$sql.= " WHERE pan_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_panial($codigo,$sit){
		$sql = "UPDATE app_panial SET ";
		$sql.= "pan_situacion = $sit";
		$sql.= " WHERE pan_codigo = $codigo ;"; 	
		
		return $sql;
	}
	
	function delete_panial($codigo){
		$sql = "DELETE FROM app_panial ";
		$sql.= " WHERE pan_codigo = $codigo;"; 	
		
		return $sql;
	}

	function max_panial(){
	  
	    $sql = "SELECT max(pan_codigo) as max ";
		$sql.= " FROM app_panial";
		$sql.= " WHERE 1 = 1";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
