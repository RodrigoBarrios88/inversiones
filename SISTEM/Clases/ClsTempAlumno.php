<?php
require_once ("ClsConex.php");

class ClsTempAlumno extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
      function get_alumno($cod,$nom = '',$ape = '',$pensum = '',$nivel = '',$grado = '',$seccion = '',$sit = '') {
		$cod = trim($cod);
		
	      $sql= "SELECT * ";
		$sql.= " FROM temp_alumnos";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND talu_codigo = '$cod'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND UPPER(talu_nombre) like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND UPPER(talu_apellido) like '%$ape%'"; 
		}
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
		if(strlen($sit)>0) { 
			  $sql.= " AND talu_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY talu_pensum ASC, talu_nivel ASC, talu_grado ASC, talu_seccion ASC, talu_apellido ASC, talu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_alumno($cod,$nom = '',$ape = '',$pensum = '',$nivel = '',$grado = '',$seccion = '',$sit = '') {
		$cod = trim($cod);
		$nom = trim($nom);
		$ape = trim($ape);
		
	      $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM temp_alumnos";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND talu_codigo = '$cod'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND UPPER(talu_nombre) like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND UPPER(talu_apellido) like '%$ape%'"; 
		}
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
		if(strlen($sit)>0) { 
			  $sql.= " AND talu_situacion IN($sit)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function insert_alumno($cod,$nom,$ape,$pensum,$nivel,$grado,$seccion){
		$cod = trim($cod);
		$nom = trim($nom);
		$ape = trim($ape);
		//--
		$fecnac = $this->regresa_fecha($fecnac);
		$freg = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		
		$sql = "INSERT INTO temp_alumnos";
		$sql.= " VALUES ('$cod','$nom','$ape',$pensum,$nivel,$grado,$seccion,1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_alumno($cod,$nom,$ape,$pensum,$nivel,$grado,$seccion){
		$cod = trim($cod);
		$nom = trim($nom);
		$ape = trim($ape);
		//--
		
		$sql = "UPDATE temp_alumnos SET ";
		$sql.= "talu_nombre = '$nom',"; 
		$sql.= "talu_apellido = '$ape',"; 
		$sql.= "talu_pensum = '$pensum',"; 
		$sql.= "talu_nivel = '$nivel',"; 
		$sql.= "talu_grado = '$grado',"; 
		$sql.= "talu_seccion = '$seccion'"; 
		
		$sql.= " WHERE talu_codigo = '$cod'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function sincroniza_alumno($cui,$codigo,$nom,$ape){
		$nom = trim($nom);
		$ape = trim($ape);
		
		$sql = "UPDATE app_alumnos SET ";
		$sql.= "alu_nombre = '$nom',"; 
		$sql.= "alu_apellido = '$ape',"; 
		$sql.= "alu_codigo_interno = '$codigo'"; 
		
		$sql.= " WHERE alu_cui = '$cui'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_alumno($cod,$sit){
		
		$sql = "UPDATE temp_alumnos SET ";
		$sql.= "talu_situacion = $sit"; 
				
		$sql.= " WHERE talu_codigo = '$cod'; "; 	
		
		return $sql;
	}
	
}	
		
?>
