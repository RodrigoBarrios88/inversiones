<?php
require_once ("ClsConex.php");

class ClsExamen extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  EXAMENES ACADEMICO  //////////////////////////////////////
  
    function get_examen($cod,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$unidad = '',$tema = '',$tipo = '',$sit = '',$fini = '',$ffin = '') {
		$titulo = trim($titulo);
		$curso = trim($curso);
		
	    $sql= "SELECT *, ";
		//--- subquery de punteo --//
		$sql.= " (SELECT SUM(pre_puntos)";
        $sql.= " FROM academ_examen_preguntas";
		$sql.= " WHERE pre_examen = exa_codigo) as exa_ponderacion, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = exa_pensum"; 
		$sql.= " AND gra_nivel = exa_nivel"; 
		$sql.= " AND gra_codigo = exa_grado) as exa_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = exa_pensum"; 
		$sql.= " AND sec_nivel = exa_nivel"; 
		$sql.= " AND sec_grado = exa_grado"; 
		$sql.= " AND sec_codigo = exa_seccion) as exa_seccion_desc, ";
		//--- subquery de materias --//
		$sql.= " (SELECT mat_descripcion FROM academ_nivel, academ_grado, academ_materia";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND mat_pensum = exa_pensum"; 
		$sql.= " AND mat_nivel = exa_nivel"; 
		$sql.= " AND mat_grado = exa_grado"; 
		$sql.= " AND mat_codigo = exa_materia) as exa_materia_desc, ";
		//--- subquery de temas --//
		$sql.= " (SELECT tem_nombre FROM academ_tema";
		$sql.= " WHERE tem_codigo = exa_tema) as exa_tema_desc";
		//--	
		$sql.= " FROM academ_examen";
		$sql.= " WHERE exa_situacion != 0";
		if(strlen($cod)>0) { 
			$sql.= " AND exa_codigo = $cod"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND exa_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND exa_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND exa_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND exa_seccion IN($seccion)";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND exa_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND exa_maestro = $maestro"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND exa_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND exa_tema = $tema"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND exa_tipo = $tipo"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND exa_situacion = $sit"; 
		}
		if(strlen($fini)>0) {
			$fini = $this->cambia_fecha($fini);
			$sql.= " AND exa_fecha_inicio < '$fini'";
		}
		if(strlen($ffin)>0) {
			$ffin = $this->cambia_fecha($ffin);
			$sql.= " AND exa_fecha_limite > '$ffin'";
		}
		$sql.= " ORDER BY exa_fecha_limite DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_examen($cod,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$unidad = '',$tema = '',$tipo = '',$sit = '',$fini = '',$ffin = '') {
		$titulo = trim($titulo);
		$curso = trim($curso);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_examen,academ_tema";
		$sql.= " WHERE exa_tema = tem_codigo";
		$sql.= " AND exa_situacion != 0";
		if(strlen($cod)>0) { 
			$sql.= " AND exa_codigo = $cod"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND exa_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND exa_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND exa_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND exa_seccion IN($seccion)";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND exa_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND exa_maestro = $maestro"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND exa_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND exa_tema = $tema"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND exa_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND exa_situacion = $sit"; 
		}
		if(strlen($fini)>0) {
			$fini = $this->cambia_fecha($fini);
			$sql.= " AND exa_fecha_inicio < '$fini'";
		}
		if(strlen($ffin)>0) {
			$ffin = $this->cambia_fecha($ffin);
			$sql.= " AND exa_fecha_limite > '$ffin'";
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_examen($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,$tipo,$titulo,$desc,$tipocalifica,$fini,$feclimit){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$curso = trim($curso);
		$fsist = date("Y-m-d H:i:s");
		$fini = $this->regresa_fechaHora($fini);
		$feclimit = $this->regresa_fechaHora($feclimit);
		
		$sql = "INSERT INTO academ_examen";
		$sql.= " VALUES ($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$unidad,$tema,'$tipo','$titulo','$desc','$tipocalifica','$fini','$feclimit','$fsist',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_examen($cod,$unidad,$tema,$tipo,$titulo,$desc,$tipocalifica,$fini,$feclimit){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$curso = trim($curso);
		$fsist = date("Y-m-d H:i:s");
		$fini = $this->regresa_fechaHora($fini);
		$feclimit = $this->regresa_fechaHora($feclimit);
		
		$sql = "UPDATE academ_examen SET ";
		$sql.= "exa_unidad = '$unidad',"; 		
		$sql.= "exa_tema = '$tema',"; 		
		$sql.= "exa_tipo = '$tipo',"; 		
		$sql.= "exa_titulo = '$titulo',"; 
		$sql.= "exa_descripcion = '$desc',";
		$sql.= "exa_tipo_calificacion = '$tipocalifica',"; 
		$sql.= "exa_fecha_inicio = '$fini',"; 
		$sql.= "exa_fecha_limite = '$feclimit',"; 
		$sql.= "exa_fecha_registro = '$fsist'"; 		
		
		$sql.= " WHERE exa_codigo = $cod; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_examen($cod,$sit){
		
		$sql = "UPDATE academ_examen SET ";
		$sql.= "exa_situacion = $sit"; 
				
		$sql.= " WHERE exa_codigo = $cod; "; 	
		
		return $sql;
	}
	
	function max_examen(){
	    $sql = "SELECT max(exa_codigo) as max ";
		$sql.= " FROM academ_examen";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////////////////////////////  PREGUNTAS  //////////////////////////////////////
  
    function get_pregunta($codigo,$examen,$tipo = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM academ_examen, academ_examen_preguntas";
		$sql.= " WHERE exa_codigo = pre_examen";
		if(strlen($codigo)>0) { 
			$sql.= " AND pre_codigo = $codigo"; 
		}
		if(strlen($examen)>0) { 
			$sql.= " AND pre_examen = '$examen'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND pre_tipo = $tipo"; 
		}
		$sql.= " ORDER BY exa_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_pregunta($codigo,$examen,$tipo = '') {
		$sql= "SELECT COUNT(*) as total";
        $sql.= " FROM academ_examen, academ_examen_preguntas";
		$sql.= " WHERE exa_codigo = pre_examen";
		if(strlen($codigo)>0) { 
			$sql.= " AND pre_codigo = $codigo"; 
		}
		if(strlen($examen)>0) { 
			$sql.= " AND pre_examen = '$examen'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND pre_tipo = $tipo"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_examen_sumatoria_preguntas($examen) {
		$sql= "SELECT SUM(pre_puntos) as total";
        $sql.= " FROM academ_examen_preguntas";
		$sql.= " WHERE pre_examen = '$examen'"; 
		//echo $sql;
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$total = $row['total'];
			}
		}else{
			$total = 0;
		}
		return $total;
	}
	
	
	function insert_pregunta($codigo,$examen,$desc,$tipo,$puntos){
        $desc = trim($desc);
		
		$sql = "INSERT INTO academ_examen_preguntas";
		$sql.= " VALUES ($codigo,$examen,'$desc',$tipo,'$puntos');";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_pregunta($codigo,$examen,$desc,$tipo,$puntos){
		$desc = trim($desc);
		
		$sql = "UPDATE academ_examen_preguntas SET ";
		$sql.= "pre_descripcion = '$desc',"; 
		$sql.= "pre_tipo = '$tipo',"; 		
		$sql.= "pre_puntos = '$puntos'"; 		
		
		$sql.= " WHERE pre_codigo = $codigo";
        $sql.= " AND pre_examen = $examen; "; 
		//echo $sql;
		return $sql;
	}
	
	
	function delete_pregunta($codigo,$examen){
		
		$sql = "DELETE FROM academ_examen_preguntas  ";
		$sql.= " WHERE pre_codigo = $codigo";
        $sql.= " AND pre_examen = $examen; "; 
		
		return $sql;
	}
	
	function max_pregunta($examen){
	    $sql = "SELECT max(pre_codigo) as max ";
		$sql.= " FROM academ_examen_preguntas";
        $sql.= " WHERE pre_examen = $examen ";
        
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
///////////////////////////// DETALLE DE EXAMENES ACADEMICOS //////////////////////////////////////
	
	function get_det_examen($examen,$alumno = '',$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$unidad = '',$tema = '',$tipo = '',$sit = '',$orderby = 'ASC') {
		
		$sql= "SELECT *, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = exa_pensum"; 
		$sql.= " AND gra_nivel = exa_nivel"; 
		$sql.= " AND gra_codigo = exa_grado) as exa_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = exa_pensum"; 
		$sql.= " AND sec_nivel = exa_nivel"; 
		$sql.= " AND sec_grado = exa_grado"; 
		$sql.= " AND sec_codigo = exa_seccion) as exa_seccion_desc, ";
		//--- subquery de materias --//
		$sql.= " (SELECT mat_descripcion FROM academ_nivel, academ_grado, academ_materia";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND mat_pensum = exa_pensum"; 
		$sql.= " AND mat_nivel = exa_nivel"; 
		$sql.= " AND mat_grado = exa_grado"; 
		$sql.= " AND mat_codigo = exa_materia) as exa_materia_desc, ";
		//--- subquery de maestro --//
		$sql.= " (SELECT CONCAT(TRIM(mae_nombre),' ',TRIM(mae_apellido)) FROM app_maestros";
		$sql.= " WHERE mae_cui = exa_maestro LIMIT 0, 1) as exa_maestro_nombre, "; 
		//--- subquery de temas --//
		$sql.= " (SELECT tem_nombre FROM academ_tema";
		$sql.= " WHERE tem_codigo = exa_tema) as exa_tema_desc";
		//--	
		$sql.= " FROM academ_det_examen, academ_examen, app_alumnos";
		$sql.= " WHERE exa_codigo = dexa_examen";
		$sql.= " AND alu_cui = dexa_alumno";
		$sql.= " AND exa_situacion != 0";
		$sql.= " AND alu_situacion != 0";
		
		if(strlen($examen)>0) { 
		    $sql.= " AND dexa_examen = $examen"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND dexa_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND exa_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND exa_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND exa_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND exa_seccion IN($seccion)";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND exa_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND exa_maestro = $maestro"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND exa_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND exa_tema = $tema"; 
		}
		if(strlen($tipo)>0) { 
		    $sql.= " AND exa_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND dexa_situacion = $sit"; 
		}
		$sql.= " ORDER BY alu_apellido ASC, alu_nombre ASC, dexa_alumno ASC, exa_fecha_inicio $orderby";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    
    function get_notas_examen($examen,$alumno = '',$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$unidad = '',$tema = '',$tipo_calificacion = '',$situacion = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
        
		$sql= "SELECT SUM(dexa_nota) as puntos ";
		$sql.= " FROM academ_det_examen, academ_examen";
		$sql.= " WHERE exa_codigo = dexa_examen";
		$sql.= " AND exa_situacion != 0";
        $sql.= " AND YEAR(exa_fecha_limite) BETWEEN $anio1 AND $anio2";
		
		if(strlen($examen)>0) { 
		    $sql.= " AND dexa_examen = $examen"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND dexa_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND exa_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND exa_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND exa_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND exa_seccion IN($seccion)";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND exa_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND exa_maestro = $maestro"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND exa_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND exa_tema = $tema"; 
		}
		if(strlen($tipo_calificacion)>0) { 
		    $sql.= " AND exa_tipo_calificacion = '$tipo_calificacion'";
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND dexa_situacion IN($situacion)"; 
		}
		$sql.= " ORDER BY dexa_alumno ASC, exa_fecha_inicio DESC";
		
		//echo $sql;
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$puntos = $row['puntos'];
			}
		}
		return $puntos;

	}
    
	
	function insert_det_examen($examen,$alumno,$nota,$obs,$sit){
		$obs = trim($obs);
		
		$sql = "INSERT INTO academ_det_examen";
		$sql.= " VALUES ('$examen','$alumno','$nota','$obs',$sit)";
		$sql.= " ON DUPLICATE KEY UPDATE dexa_nota = '$nota', dexa_observaciones = '$obs', dexa_situacion = '$sit'; ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_det_examen($examen,$alumno,$nota,$obs){
		$obs = trim($obs);
		
		$sql = "UPDATE academ_det_examen SET ";
		$sql.= "dexa_nota = '$nota',"; 
		$sql.= "dexa_observaciones = '$obs'"; 		
		
		$sql.= " WHERE dexa_examen = $examen";
		$sql.= " AND dexa_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambiar_sit_det_examen($examen,$alumno,$sit){
		
		$sql = "UPDATE academ_det_examen SET ";
		$sql.= "dexa_situacion = '$sit'"; 
		
		$sql.= " WHERE dexa_examen = $examen";
		$sql.= " AND dexa_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_det_examen_alumnos($examen){
		
		$sql = "DELETE FROM academ_det_examen ";
		$sql.= " WHERE dexa_examen = $examen; ";
		//echo $sql;
		return $sql;
	}
	
/////////////////////////////  CLAVE DE EXAMENES ACADEMICOS  //////////////////////////////////////
	
	function insert_clave($examen,$pregunta,$tipo,$ponderacion,$respuesta){
        $respuesta = trim($respuesta);
		
		$sql = "INSERT INTO academ_examen_clave";
		$sql.= " VALUES ('$examen','$pregunta','$tipo','$ponderacion','$respuesta')";
		$sql.= " ON DUPLICATE KEY UPDATE cla_ponderacion = '$ponderacion', cla_respuesta = '$respuesta'; ";
		//echo $sql;
		return $sql;
	}
	
	function get_clave_directa($examen,$pregunta) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM academ_examen_clave";
		$sql.= " WHERE cla_examen = '$examen'"; 
		$sql.= " AND cla_pregunta = '$pregunta'"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_pregunta_clave($examen,$pregunta,$alumno,$tipo = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM academ_examen, academ_examen_preguntas, academ_examen_clave";
		$sql.= " WHERE exa_codigo = pre_examen";
		$sql.= " AND cla_examen = pre_examen";
		$sql.= " AND cla_pregunta = pre_codigo";
		if(strlen($examen)>0) { 
			$sql.= " AND pre_examen = '$examen'"; 
		}
		if(strlen($pregunta)>0) { 
			$sql.= " AND pre_codigo = '$pregunta'"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND cla_alumno = '$alumno'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cla_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY exa_codigo, pre_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
/////////////////////////////  RESPUESTA DE EXAMENES ACADEMICOS  //////////////////////////////////////
	
	function insert_respuesta($examen,$pregunta,$alumno,$tipo,$ponderacion,$respuesta){
        $respuesta = trim($respuesta);
		
		$sql = "INSERT INTO academ_examen_respuestas";
		$sql.= " VALUES ('$examen','$pregunta','$alumno','$tipo','$ponderacion','$respuesta')";
		$sql.= " ON DUPLICATE KEY UPDATE resp_ponderacion = '$ponderacion', resp_respuesta = '$respuesta'; ";
		//echo $sql;
		return $sql;
	}
	
	function get_respuesta_directa($examen,$pregunta,$alumno) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM academ_examen_respuestas";
		$sql.= " WHERE resp_examen = '$examen'"; 
		$sql.= " AND resp_pregunta = '$pregunta'"; 
		$sql.= " AND resp_alumno = '$alumno'"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_pregunta_respuesta($examen,$pregunta,$alumno,$tipo = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM academ_examen, academ_examen_preguntas, academ_examen_respuestas";
		$sql.= " WHERE exa_codigo = pre_examen";
		$sql.= " AND resp_examen = pre_examen";
		$sql.= " AND resp_pregunta = pre_codigo";
		if(strlen($examen)>0) { 
			$sql.= " AND pre_examen = '$examen'"; 
		}
		if(strlen($pregunta)>0) { 
			$sql.= " AND pre_codigo = '$pregunta'"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND resp_alumno = '$alumno'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND resp_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY exa_codigo, pre_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
//////////////////////////////////////////////////////////////////////////////////////////	
	//--- Archivos de Examenes de Examenes Academicos ---//
	
	function get_examen_archivo($cod,$examen,$nom = ''){
		$nom = trim($nom);
		
		$sql= "SELECT * ";
		$sql.= " FROM academ_examen_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND arch_codigo = $cod"; 
		}
		if(strlen($examen)>0) { 
			  $sql.= " AND arch_examen = '$examen'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_examen_archivo($cod,$examen,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO academ_examen_archivo";
		$sql.= " VALUES ($cod,$examen,'$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_examen_archivo($cod,$examen){
		$sql = "DELETE FROM academ_examen_archivo";
		$sql.= " WHERE arch_codigo = $cod"; 	
		$sql.= " AND arch_examen = '$examen';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_examen_archivo($examen) {
		
		$sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM academ_examen_archivo";
		$sql.= " WHERE arch_examen = '$examen'"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	//--- Archivos de Resolucion de Examenes Academicos ---//
	
	function get_resolucion_examen_archivo($cod,$examen,$alumno,$nom = ''){
		$nom = trim($nom);
		
		$sql= "SELECT * ";
		$sql.= " FROM academ_resolucion_examen_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND arch_codigo = $cod"; 
		}
		if(strlen($examen)>0) { 
			  $sql.= " AND arch_examen = '$examen'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND arch_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_resolucion_examen_archivo($cod,$examen,$alumno,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO academ_resolucion_examen_archivo";
		$sql.= " VALUES ($cod,$examen,'$alumno','$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_resolucion_examen_archivo($cod,$examen,$alumno){
		$sql = "DELETE FROM academ_resolucion_examen_archivo";
		$sql.= " WHERE arch_codigo = $cod"; 	
		$sql.= " AND arch_examen = '$examen'";
		$sql.= " AND arch_alumno = '$alumno';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_resolucion_examen_archivo($examen,$alumno) {
		
		$sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM academ_resolucion_examen_archivo";
		$sql.= " WHERE arch_examen = '$examen'";
		$sql.= " AND arch_alumno = '$alumno';"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}


/////////////////////////////  EXAMEN DE CURSOS LIBRES  //////////////////////////////////////
  
    function get_examen_curso($cod,$curso = '',$tema = '',$tipo = '',$sit = '',$fini = '',$ffin = '') {
		$titulo = trim($titulo);
		$curso = trim($curso);
		
	    $sql= "SELECT *, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT tem_nombre FROM lms_tema";
		$sql.= " WHERE tem_curso = exa_curso";
		$sql.= " AND tem_codigo = exa_tema) as exa_tema_nombre ";
		//--	
		$sql.= " FROM lms_examen,lms_curso";
		$sql.= " WHERE exa_curso = cur_codigo";
		$sql.= " AND exa_situacion != 0";
		if(strlen($cod)>0) { 
			$sql.= " AND exa_codigo = $cod"; 
		}
		if(strlen($curso)>0) { 
			$sql.= " AND exa_curso IN($curso)"; 
		}
		if(strlen($tema)>0) { 
			$sql.= " AND exa_tema IN($tema)"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND exa_tipo = $tipo"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND exa_situacion = $sit"; 
		}
		if(strlen($fini)>0) {
			$fini = $this->cambia_fecha($fini);
			$sql.= " AND exa_fecha_inicio < '$fini'";
		}
		if(strlen($ffin)>0) {
			$ffin = $this->cambia_fecha($ffin);
			$sql.= " AND exa_fecha_limite > '$ffin'";
		}
		$sql.= " ORDER BY exa_fecha_limite ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_examen_curso($cod,$curso = '',$tema = '',$tipo = '',$sit = '',$fini = '',$ffin = '') {
		$titulo = trim($titulo);
		$curso = trim($curso);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_examen,lms_curso";
		$sql.= " WHERE exa_curso = cur_codigo";
		$sql.= " AND exa_situacion != 0";
		if(strlen($cod)>0) { 
			$sql.= " AND exa_codigo = $cod"; 
		}
		if(strlen($curso)>0) { 
			$sql.= " AND exa_curso = '$curso'"; 
		}
		if(strlen($tema)>0) { 
			$sql.= " AND exa_tema = $tema"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND exa_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND exa_situacion = $sit"; 
		}
		if(strlen($fini)>0) {
			$fini = $this->cambia_fecha($fini);
			$sql.= " AND exa_fecha_inicio < '$fini'";
		}
		if(strlen($ffin)>0) {
			$ffin = $this->cambia_fecha($ffin);
			$sql.= " AND exa_fecha_limite > '$ffin'";
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_examen_curso($cod,$curso,$tema,$tipo,$titulo,$desc,$tipocalifica,$fini,$feclimit){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$curso = trim($curso);
		$fsist = date("Y-m-d H:i:s");
		$fini = $this->regresa_fechaHora($fini);
		$feclimit = $this->regresa_fechaHora($feclimit);
		
		$sql = "INSERT INTO lms_examen";
		$sql.= " VALUES ($cod,'$curso','$tema','$tipo','$titulo','$desc','$tipocalifica','$fini','$feclimit','$fsist',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_examen_curso($cod,$tipo,$titulo,$desc,$tipocalifica,$fini,$feclimit){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$curso = trim($curso);
		$fsist = date("Y-m-d H:i:s");
		$fini = $this->regresa_fechaHora($fini);
		$feclimit = $this->regresa_fechaHora($feclimit);
		
		$sql = "UPDATE lms_examen SET ";
		$sql.= "exa_tipo = '$tipo',"; 		
		$sql.= "exa_titulo = '$titulo',"; 
		$sql.= "exa_descripcion = '$desc',";
		$sql.= "exa_tipo_calificacion = '$tipocalifica',"; 
		$sql.= "exa_fecha_inicio = '$fini',"; 
		$sql.= "exa_fecha_limite = '$feclimit',"; 
		$sql.= "exa_fecha_registro = '$fsist'"; 		
		
		$sql.= " WHERE exa_codigo = $cod; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_examen_curso($cod,$sit){
		
		$sql = "UPDATE lms_examen SET ";
		$sql.= "exa_situacion = $sit"; 
				
		$sql.= " WHERE exa_codigo = $cod; "; 	
		
		return $sql;
	}
	
	function max_examen_curso(){
	    $sql = "SELECT max(exa_codigo) as max ";
		$sql.= " FROM lms_examen";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////////////////////////////  PREGUNTAS DE CURSOS LIBRES  //////////////////////////////////////
  
    function get_pregunta_curso($codigo,$examen,$tipo = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM lms_examen, lms_examen_preguntas";
		$sql.= " WHERE exa_codigo = pre_examen";
		if(strlen($codigo)>0) { 
			$sql.= " AND pre_codigo = $codigo"; 
		}
		if(strlen($examen)>0) { 
			$sql.= " AND pre_examen = '$examen'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND pre_tipo = $tipo"; 
		}
		$sql.= " ORDER BY exa_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_pregunta_curso($codigo,$examen,$tipo = '') {
		$sql= "SELECT COUNT(*) as total";
        $sql.= " FROM lms_examen, lms_examen_preguntas";
		$sql.= " WHERE exa_codigo = pre_examen";
		if(strlen($codigo)>0) { 
			$sql.= " AND pre_codigo = $codigo"; 
		}
		if(strlen($examen)>0) { 
			$sql.= " AND pre_examen = '$examen'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND pre_tipo = $tipo"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_examen_sumatoria_preguntas_curso($examen) {
		$sql= "SELECT SUM(pre_puntos) as total";
        $sql.= " FROM lms_examen_preguntas";
		$sql.= " WHERE pre_examen = '$examen'"; 
		//echo $sql;
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$total = $row['total'];
			}
		}else{
			$total = 0;
		}
		return $total;
	}
	
	
	function insert_pregunta_curso($codigo,$examen,$desc,$tipo,$puntos){
        $desc = trim($desc);
		
		$sql = "INSERT INTO lms_examen_preguntas";
		$sql.= " VALUES ($codigo,$examen,'$desc',$tipo,'$puntos');";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_pregunta_curso($codigo,$examen,$desc,$tipo,$puntos){
		$desc = trim($desc);
		
		$sql = "UPDATE lms_examen_preguntas SET ";
		$sql.= "pre_descripcion = '$desc',"; 
		$sql.= "pre_tipo = '$tipo',"; 		
		$sql.= "pre_puntos = '$puntos'"; 		
		
		$sql.= " WHERE pre_codigo = $codigo";
        $sql.= " AND pre_examen = $examen; "; 
		//echo $sql;
		return $sql;
	}
	
	
	function delete_pregunta_curso($codigo,$examen){
		
		$sql = "DELETE FROM lms_examen_preguntas  ";
		$sql.= " WHERE pre_codigo = $codigo";
        $sql.= " AND pre_examen = $examen; "; 
		
		return $sql;
	}
	
	function max_pregunta_curso($examen){
	    $sql = "SELECT max(pre_codigo) as max ";
		$sql.= " FROM lms_examen_preguntas";
        $sql.= " WHERE pre_examen = $examen ";
        
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
///////////////////////////// DETALLE DE EXAMEN DE CURSOS LIBRES //////////////////////////////////////
	
	function get_det_examen_curso($examen,$alumno = '',$curso = '',$tema = '',$tipo = '',$sit = '',$orderby = 'ASC') {
		
		$sql= "SELECT *, ";
		//--- subquery de curso --//
		$sql.= " (SELECT cur_nombre FROM lms_curso";
		$sql.= " WHERE cur_codigo = exa_curso) as exa_curso_nombre, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT tem_nombre FROM lms_tema";
		$sql.= " WHERE tem_curso = exa_curso";
		$sql.= " AND tem_codigo = exa_tema) as exa_tema_nombre ";
		//--	
		$sql.= " FROM lms_det_examen, lms_examen, app_alumnos";
		$sql.= " WHERE exa_codigo = dexa_examen";
		$sql.= " AND alu_cui = dexa_alumno";
		if(strlen($examen)>0) { 
		    $sql.= " AND dexa_examen = $examen"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND dexa_alumno = '$alumno'"; 
		}
		if(strlen($curso)>0) { 
			$sql.= " AND exa_curso IN($curso)"; 
		}
		if(strlen($tema)>0) { 
			$sql.= " AND exa_tema IN($tema)"; 
		}
		if(strlen($tipo)>0) { 
		    $sql.= " AND exa_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND dexa_situacion = $sit"; 
		}
		$sql.= " ORDER BY alu_apellido ASC, alu_nombre ASC, dexa_alumno ASC, exa_fecha_inicio $orderby";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function insert_det_examen_curso($examen,$alumno,$nota,$obs,$sit){
		$obs = trim($obs);
		
		$sql = "INSERT INTO lms_det_examen";
		$sql.= " VALUES ('$examen','$alumno','$nota','$obs',$sit)";
		$sql.= " ON DUPLICATE KEY UPDATE dexa_nota = '$nota', dexa_observaciones = '$obs', dexa_situacion = '$sit'; ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_det_examen_curso($examen,$alumno,$nota,$obs){
		$obs = trim($obs);
		
		$sql = "UPDATE lms_det_examen SET ";
		$sql.= "dexa_nota = '$nota',"; 
		$sql.= "dexa_observaciones = '$obs'"; 		
		
		$sql.= " WHERE dexa_examen = $examen";
		$sql.= " AND dexa_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambiar_sit_det_examen_curso($examen,$alumno,$sit){
		
		$sql = "UPDATE lms_det_examen SET ";
		$sql.= "dexa_situacion = '$sit'"; 
		
		$sql.= " WHERE dexa_examen = $examen";
		$sql.= " AND dexa_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_det_examen_alumnos_curso($examen){
		
		$sql = "DELETE FROM lms_det_examen ";
		$sql.= " WHERE dexa_examen = $examen; ";
		//echo $sql;
		return $sql;
	}
	
/////////////////////////////  CLAVE DE EXAMENES DE CURSOS LIBRES  //////////////////////////////////////
	
	function insert_clave_curso($examen,$pregunta,$tipo,$ponderacion,$respuesta){
        $respuesta = trim($respuesta);
		
		$sql = "INSERT INTO lms_examen_clave";
		$sql.= " VALUES ('$examen','$pregunta','$tipo','$ponderacion','$respuesta')";
		$sql.= " ON DUPLICATE KEY UPDATE cla_ponderacion = '$ponderacion', cla_respuesta = '$respuesta'; ";
		//echo $sql;
		return $sql;
	}
	
	function get_clave_directa_curso($examen,$pregunta) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM lms_examen_clave";
		$sql.= " WHERE cla_examen = '$examen'"; 
		$sql.= " AND cla_pregunta = '$pregunta'"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_pregunta_clave_curso($examen,$pregunta,$alumno,$tipo = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM lms_examen, lms_examen_preguntas, lms_examen_clave";
		$sql.= " WHERE exa_codigo = pre_examen";
		$sql.= " AND cla_examen = pre_examen";
		$sql.= " AND cla_pregunta = pre_codigo";
		if(strlen($examen)>0) { 
			$sql.= " AND pre_examen = '$examen'"; 
		}
		if(strlen($pregunta)>0) { 
			$sql.= " AND pre_codigo = '$pregunta'"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND cla_alumno = '$alumno'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cla_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY exa_codigo, pre_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
/////////////////////////////  RESPUESTA DE EXAMENES DE CURSOS LIBRES //////////////////////////////////////
	
	function insert_respuesta_curso($examen,$pregunta,$alumno,$tipo,$ponderacion,$respuesta){
        $respuesta = trim($respuesta);
		
		$sql = "INSERT INTO lms_examen_respuestas";
		$sql.= " VALUES ('$examen','$pregunta','$alumno','$tipo','$ponderacion','$respuesta')";
		$sql.= " ON DUPLICATE KEY UPDATE resp_ponderacion = '$ponderacion', resp_respuesta = '$respuesta'; ";
		//echo $sql;
		return $sql;
	}
	
	function get_respuesta_directa_curso($examen,$pregunta,$alumno) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM lms_examen_respuestas";
		$sql.= " WHERE resp_examen = '$examen'"; 
		$sql.= " AND resp_pregunta = '$pregunta'"; 
		$sql.= " AND resp_alumno = '$alumno'"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_pregunta_respuesta_curso($examen,$pregunta,$alumno,$tipo = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM lms_examen, lms_examen_preguntas, lms_examen_respuestas";
		$sql.= " WHERE exa_codigo = pre_examen";
		$sql.= " AND resp_examen = pre_examen";
		$sql.= " AND resp_pregunta = pre_codigo";
		if(strlen($examen)>0) { 
			$sql.= " AND pre_examen = '$examen'"; 
		}
		if(strlen($pregunta)>0) { 
			$sql.= " AND pre_codigo = '$pregunta'"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND resp_alumno = '$alumno'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND resp_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY exa_codigo, pre_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
//////////////////////////////////////////////////////////////////////////////////////////	
	//--- Archivos de Examenes de Cursos Libres ---//
	
	function get_examen_archivo_curso($cod,$examen,$nom = ''){
		$nom = trim($nom);
		
		$sql= "SELECT * ";
		$sql.= " FROM lms_examen_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND arch_codigo = $cod"; 
		}
		if(strlen($examen)>0) { 
			  $sql.= " AND arch_examen = '$examen'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_examen_archivo_curso($cod,$examen,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO lms_examen_archivo";
		$sql.= " VALUES ($cod,$examen,'$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_examen_archivo_curso($cod,$examen){
		$sql = "DELETE FROM lms_examen_archivo";
		$sql.= " WHERE arch_codigo = $cod"; 	
		$sql.= " AND arch_examen = '$examen';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_examen_archivo_curso($examen) {
		
		$sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM lms_examen_archivo";
		$sql.= " WHERE arch_examen = '$examen'"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	//--- Archivos de Resolucion de Examenes de Cursos Libres ---//
	
	function get_resolucion_examen_archivo_curso($cod,$examen,$alumno,$nom = ''){
		$nom = trim($nom);
		
		$sql= "SELECT * ";
		$sql.= " FROM lms_resolucion_examen_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND arch_codigo = $cod"; 
		}
		if(strlen($examen)>0) { 
			  $sql.= " AND arch_examen = '$examen'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND arch_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_resolucion_examen_archivo_curso($cod,$examen,$alumno,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO lms_resolucion_examen_archivo";
		$sql.= " VALUES ($cod,$examen,'$alumno','$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_resolucion_examen_archivo_curso($cod,$examen,$alumno){
		$sql = "DELETE FROM lms_resolucion_examen_archivo";
		$sql.= " WHERE arch_codigo = $cod"; 	
		$sql.= " AND arch_examen = '$examen'";
		$sql.= " AND arch_alumno = '$alumno';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_resolucion_examen_archivo_curso($examen,$alumno) {
		
		$sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM lms_resolucion_examen_archivo";
		$sql.= " WHERE arch_examen = '$examen'";
		$sql.= " AND arch_alumno = '$alumno';"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

}
?>