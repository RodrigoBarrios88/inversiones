<?php
require_once ("ClsConex.php");

class ClsEducacion extends ClsConex{
   
//---------- Educacion ---------//
    function get_educacion($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_educacion";
		$sql.= " WHERE edu_personal = $personal"; 
		$sql.= " ORDER BY edu_personal ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
			
	function insert_educacion($edu_personal,$edu_grado_primaria,$edu_lugar_primaria,$edu_grado_secundaria,$edu_lugar_secundaria,$edu_carrera_secundaria) {
	     //-- UPPERCASE
			$edu_lugar_primaria = trim($edu_lugar_primaria);
			$edu_lugar_secundaria = trim($edu_lugar_secundaria);
			$edu_carrera_secundaria = trim($edu_carrera_secundaria);
		//--
		$sql = "INSERT INTO rrhh_educacion ";
		$sql.= "VALUES ('$edu_personal','$edu_grado_primaria','$edu_lugar_primaria','$edu_grado_secundaria','$edu_lugar_secundaria','$edu_carrera_secundaria'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_educacion($edu_personal,$edu_grado_primaria,$edu_lugar_primaria,$edu_grado_secundaria,$edu_lugar_secundaria,$edu_carrera_secundaria) {
	     //-- UPPERCASE
			$edu_lugar_primaria = trim($edu_lugar_primaria);
			$edu_lugar_secundaria = trim($edu_lugar_secundaria);
			$edu_carrera_secundaria = trim($edu_carrera_secundaria);
		//--
		$sql = "UPDATE rrhh_educacion SET";
		$sql.= " edu_grado_primaria = '$edu_grado_primaria',";
		$sql.= " edu_lugar_primaria = '$edu_lugar_primaria',";
		$sql.= " edu_grado_secundaria = '$edu_grado_secundaria',";
		$sql.= " edu_lugar_secundaria = '$edu_lugar_secundaria',";
		$sql.= " edu_carrera_secundaria = '$edu_carrera_secundaria' ";
		
		$sql.= " WHERE edu_personal = '$edu_personal'; ";
		//echo $sql;
		return $sql;
	}
	
	function delete_educacion($personal){
		$sql = "DELETE FROM rrhh_educacion  ";
		$sql.= " WHERE edu_personal = $personal; "; 	
		return $sql;
	}
	
	
//---------- Cursos ---------//
	function get_cursos($personal,$tipo="") {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_cursos, mast_paises";
		$sql.= " WHERE pai_id = cur_pais";
		$sql.= " AND cur_personal = $personal";
		if(strlen($tipo)>0) { 
			$sql.= " AND cur_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY cur_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_cursos($personal,$tipo="") {
		
	    	$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM rrhh_cursos, mast_paises";
		$sql.= " WHERE pai_id = cur_pais";
		$sql.= " AND cur_personal = $personal";
		if(strlen($tipo)>0) { 
			$sql.= " AND cur_tipo = '$tipo'"; 
		}
			
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_cursos($cur_codigo,$cur_personal,$cur_tipo,$cur_nivel,$cur_titulo,$cur_lugar,$cur_pais,$cur_anio,$cur_semestre,$cur_graduado) {
	     //-- UPPERCASE
			$cur_nivel = trim($cur_nivel);
			$cur_titulo = trim($cur_titulo);
			$cur_lugar = trim($cur_lugar);
			$cur_semestre = trim($cur_semestre);
			$cur_graduado = trim($cur_graduado);
		//--
		$sql = "INSERT INTO rrhh_cursos ";
		$sql.= "VALUES ('$cur_codigo','$cur_personal','$cur_tipo','$cur_nivel','$cur_titulo','$cur_lugar','$cur_pais','$cur_anio','$cur_semestre','$cur_graduado'); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_cursos($personal){
		$sql = "DELETE FROM rrhh_cursos  ";
		$sql.= " WHERE cur_personal = $personal; "; 	
		return $sql;
	}
	
	
	//---------- Idiomas ---------//
	function get_idiomas($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_idiomas";
		$sql.= " WHERE idi_personal = $personal"; 
		$sql.= " ORDER BY idi_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_idiomas($personal) {
		
	    	$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM rrhh_idiomas";
		$sql.= " WHERE idi_personal = $personal"; 
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_idiomas($idi_codigo,$idi_personal,$idi_idioma,$idi_habla,$idi_lee,$idi_escribe) {
	     //-- UPPERCASE
			$idi_idioma = trim($idi_idioma);
		//--
		$sql = "INSERT INTO rrhh_idiomas ";
		$sql.= "VALUES ('$idi_codigo','$idi_personal','$idi_idioma','$idi_habla','$idi_lee','$idi_escribe'); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_idiomas($personal){
		$sql = "DELETE FROM rrhh_idiomas  ";
		$sql.= " WHERE idi_personal = $personal; "; 	
		return $sql;
	}
	
}	
?>
