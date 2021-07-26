<?php
require_once ("ClsConex.php");

class ClsConducta extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  POST-IT o Notificaciones //////////////////////////////////////
//////////////  TODOS //////////////////
  
      function get_conducta($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$alumno = '',$desde = '',$fecha = '',$sit = '') {
		
		$sql= "SELECT *, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = con_pensum"; 
		$sql.= " AND gra_nivel = con_nivel"; 
		$sql.= " AND gra_codigo = con_grado) as con_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = con_pensum"; 
		$sql.= " AND sec_nivel = con_nivel"; 
		$sql.= " AND sec_grado = con_grado"; 
		$sql.= " AND sec_codigo = con_seccion) as con_seccion_desc,";
		//--- subquery target --//
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = con_alumno) as alu_foto";
		//--
		$sql.= " FROM app_conducta,app_alumnos";
		$sql.= " WHERE alu_cui = con_alumno";
		if(strlen($codigo)>0) { 
		    $sql.= " AND con_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND con_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND con_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND con_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND con_seccion IN($seccion)";
		}	
		if(strlen($alumno)>0) { 
			$sql.= " AND con_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND con_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND con_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND con_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND con_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY con_fecha_registro DESC, con_nivel ASC, con_grado ASC, con_seccion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_conducta($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$alumno = '',$desde = '',$fecha = '',$sit = '') {
		$calificacion = trim($calificacion);
		$obs = trim($obs);
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_conducta";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
		    $sql.= " AND con_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND con_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND con_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND con_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND con_seccion IN($seccion)";
		}	
		if(strlen($alumno)>0) { 
			$sql.= " AND con_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND con_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND con_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND con_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND con_situacion = '$sit'"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_conducta($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$calificacion,$obs,$usu = ''){
		$obs = trim($obs);
		$usu = ($usu == "")?$_SESSION["codigo"]:$usu;
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_conducta";
		$sql.= " VALUES ($codigo,$pensum,$nivel,$grado,$seccion,'$alumno','$calificacion','$obs','$freg','$usu',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_conducta($codigo,$alumno,$calificacion,$obs){
		$obs = trim($obs);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_conducta SET ";
		$sql.= "con_alumno = '$alumno',"; 
		$sql.= "con_calificacion = '$calificacion',"; 
		$sql.= "con_observaciones = '$obs'"; 		
		
		$sql.= " WHERE con_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_conducta($codigo,$sit){
		$sql = "UPDATE app_conducta SET ";
		$sql.= "con_situacion = $sit";
		$sql.= " WHERE con_codigo = $codigo ;"; 	
		
		return $sql;
	}
	
	function delete_conducta($codigo){
		$sql = "DELETE FROM app_conducta ";
		$sql.= " WHERE con_codigo = $codigo;"; 	
		
		return $sql;
	}

	function max_conducta(){
	  
	    $sql = "SELECT max(con_codigo) as max ";
		$sql.= " FROM app_conducta";
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
