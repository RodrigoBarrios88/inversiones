<?php
require_once ("ClsConex.php");

class ClsGolpe extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
 
      function get_golpe($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$alumno = '',$desde = '',$fecha = '',$sit = '') {
		
		$sql= "SELECT *, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = gol_pensum"; 
		$sql.= " AND gra_nivel = gol_nivel"; 
		$sql.= " AND gra_codigo = gol_grado) as gol_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = gol_pensum"; 
		$sql.= " AND sec_nivel = gol_nivel"; 
		$sql.= " AND sec_grado = gol_grado"; 
		$sql.= " AND sec_codigo = gol_seccion) as gol_seccion_desc,";
		//--- subquery target --//
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = gol_alumno) as alu_foto";
		//--
		$sql.= " FROM app_golpe,app_alumnos";
		$sql.= " WHERE alu_cui = gol_alumno";
		if(strlen($codigo)>0) { 
		    $sql.= " AND gol_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND gol_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND gol_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND gol_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND gol_seccion IN($seccion)";
		}	
		if(strlen($alumno)>0) { 
			$sql.= " AND gol_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND gol_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND gol_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND gol_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND gol_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY gol_fecha_registro DESC, gol_nivel ASC, gol_grado ASC, gol_seccion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_golpe($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$alumno = '',$desde = '',$fecha = '',$sit = '') {
		$lugar = trim($lugar);
		$medida = trim($medida);
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_golpe";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
		    $sql.= " AND gol_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND gol_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND gol_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND gol_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND gol_seccion IN($seccion)";
		}	
		if(strlen($alumno)>0) { 
			$sql.= " AND gol_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND gol_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND gol_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND gol_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND gol_situacion = '$sit'"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_golpe($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$lugar,$hora,$desc,$medida,$dosis,$usu = ''){
		$desc = trim($desc);
		$medida = trim($medida);
		$usu = ($usu == "")?$_SESSION["codigo"]:$usu;
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_golpe";
		$sql.= " VALUES ($codigo,$pensum,$nivel,$grado,$seccion,'$alumno','$lugar','$hora','$desc','$medida','$dosis','$freg','$usu',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_golpe($codigo,$alumno,$lugar,$hora,$desc,$medida,$dosis){
		$desc = trim($desc);
		$medida = trim($medida);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_golpe SET ";
		$sql.= "gol_alumno = '$alumno',"; 
		$sql.= "gol_lugar = '$lugar',"; 
		$sql.= "gol_hora = '$hora',"; 
		$sql.= "gol_descripcion = '$desc',"; 
		$sql.= "gol_medida = '$medida',"; 		
		$sql.= "gol_dosis = '$dosis',"; 		
		$sql.= "gol_fecha_registro = '$freg'";
		
		$sql.= " WHERE gol_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_golpe($codigo,$sit){
		$sql = "UPDATE app_golpe SET ";
		$sql.= "gol_situacion = $sit";
		$sql.= " WHERE gol_codigo = $codigo ;"; 	
		
		return $sql;
	}
	
	function delete_golpe($codigo){
		$sql = "DELETE FROM app_golpe ";
		$sql.= " WHERE gol_codigo = $codigo;"; 	
		
		return $sql;
	}

	function max_golpe(){
	  
	    $sql = "SELECT max(gol_codigo) as max ";
		$sql.= " FROM app_golpe";
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
