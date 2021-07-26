<?php
require_once ("ClsConex.php");

class ClsEnfermedad extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
 
      function get_enfermedad($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$alumno = '',$desde = '',$fecha = '',$sit = '') {
		
		$sql= "SELECT *, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = enf_pensum"; 
		$sql.= " AND gra_nivel = enf_nivel"; 
		$sql.= " AND gra_codigo = enf_grado) as enf_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = enf_pensum"; 
		$sql.= " AND sec_nivel = enf_nivel"; 
		$sql.= " AND sec_grado = enf_grado"; 
		$sql.= " AND sec_codigo = enf_seccion) as enf_seccion_desc,";
		//--- subquery target --//
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = enf_alumno) as alu_foto";
		//--
		$sql.= " FROM app_enfermedad,app_alumnos";
		$sql.= " WHERE alu_cui = enf_alumno";
		if(strlen($codigo)>0) { 
		    $sql.= " AND enf_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND enf_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND enf_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND enf_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND enf_seccion IN($seccion)";
		}	
		if(strlen($alumno)>0) { 
			$sql.= " AND enf_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND enf_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND enf_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND enf_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND enf_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY enf_fecha_registro DESC, enf_nivel ASC, enf_grado ASC, enf_seccion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_enfermedad($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$alumno = '',$desde = '',$fecha = '',$sit = '') {
		$sintomas = trim($sintomas);
		$medida = trim($medida);
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_enfermedad";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
		    $sql.= " AND enf_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND enf_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND enf_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND enf_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND enf_seccion IN($seccion)";
		}	
		if(strlen($alumno)>0) { 
			$sql.= " AND enf_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND enf_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND enf_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND enf_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND enf_situacion = '$sit'"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_enfermedad($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$sintomas,$hora,$aviso,$medida,$dosis,$usu = ''){
		$aviso = trim($aviso);
		$medida = trim($medida);
		$usu = ($usu == "")?$_SESSION["codigo"]:$usu;
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_enfermedad";
		$sql.= " VALUES ($codigo,$pensum,$nivel,$grado,$seccion,'$alumno','$sintomas','$hora','$aviso','$medida','$dosis','$freg','$usu',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_enfermedad($codigo,$alumno,$sintomas,$hora,$aviso,$medida,$dosis){
		$aviso = trim($aviso);
		$medida = trim($medida);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_enfermedad SET ";
		$sql.= "enf_alumno = '$alumno',"; 
		$sql.= "enf_sintomas = '$sintomas',"; 
		$sql.= "enf_hora = '$hora',"; 
		$sql.= "enf_aviso = '$aviso',"; 
		$sql.= "enf_medida = '$medida',"; 		
		$sql.= "enf_dosis = '$dosis',"; 		
		$sql.= "enf_fecha_registro = '$freg'";
		
		$sql.= " WHERE enf_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_enfermedad($codigo,$sit){
		$sql = "UPDATE app_enfermedad SET ";
		$sql.= "enf_situacion = $sit";
		$sql.= " WHERE enf_codigo = $codigo ;"; 	
		
		return $sql;
	}
	
	function delete_enfermedad($codigo){
		$sql = "DELETE FROM app_enfermedad ";
		$sql.= " WHERE enf_codigo = $codigo;"; 	
		
		return $sql;
	}

	function max_enfermedad(){
	  
	    $sql = "SELECT max(enf_codigo) as max ";
		$sql.= " FROM app_enfermedad";
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
