<?php
require_once ("ClsConex.php");

class ClsTarea extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  TAREAS ACADEMICAS //////////////////////////////////////
      function get_tarea($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$unidad = '',$tema = '',$tipo = '',$desde = '',$fecha = '',$sit = '',$orderby = 'DESC') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT *, ";
		//--- subquery de situaciones --//
		$sql.= " (SELECT COUNT(*) FROM academ_det_tarea";
		$sql.= " WHERE dtar_tarea = tar_codigo";
		$sql.= " AND dtar_situacion = '1') as tar_pendientes, ";
		$sql.= " (SELECT COUNT(*) FROM academ_resolucion_tarea";
		$sql.= " WHERE reso_tarea = tar_codigo) as tar_entregadas, ";
		$sql.= " (SELECT COUNT(*) FROM academ_det_tarea";
		$sql.= " WHERE dtar_tarea = tar_codigo";
		$sql.= " AND dtar_situacion = '2') as tar_calificadas, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = tar_pensum"; 
		$sql.= " AND gra_nivel = tar_nivel"; 
		$sql.= " AND gra_codigo = tar_grado) as tar_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = tar_pensum"; 
		$sql.= " AND sec_nivel = tar_nivel"; 
		$sql.= " AND sec_grado = tar_grado"; 
		$sql.= " AND sec_codigo = tar_seccion) as tar_seccion_desc, ";
		//--- subquery de materias --//
		$sql.= " (SELECT mat_descripcion FROM academ_nivel, academ_grado, academ_materia";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND mat_pensum = tar_pensum"; 
		$sql.= " AND mat_nivel = tar_nivel"; 
		$sql.= " AND mat_grado = tar_grado"; 
		$sql.= " AND mat_codigo = tar_materia) as tar_materia_desc,";
		//--- subquery de maestro --//
		$sql.= " (SELECT CONCAT(TRIM(mae_nombre),' ',TRIM(mae_apellido)) FROM app_maestros";
		$sql.= " WHERE mae_cui = tar_maestro LIMIT 0, 1) as tar_maestro_nombre"; 
		//--	
		$sql.= " FROM academ_tarea, academ_tema";
		$sql.= " WHERE tem_codigo = tar_tema";
		$sql.= " AND tar_situacion != 0";
		$sql.= " AND YEAR(tar_fecha_entrega) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND tar_codigo IN($codigo)"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND tar_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND tar_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND tar_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND tar_seccion IN($seccion)";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND tar_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND tar_maestro = $maestro"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND tem_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND tar_tema = $tema"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND tar_tipo IN($tipo)";
		}
		if(strlen($nom)>0) { 
		    $sql.= " AND tar_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0) { 
		    $sql.= " AND tar_descripcion like '%$desc%'"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND tar_fecha_entrega > '$desde 00:00:00'"; 
		}else{
			//$sql.= " AND tar_fecha_entrega > '".date("Y-m-d H:i:s")."'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND tar_fecha_entrega BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND tar_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY tar_fecha_entrega $orderby, tar_maestro ASC, tem_unidad ASC, tar_tema ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_tarea($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$unidad = '',$tema = '',$tipo = '',$desde = '',$fecha = '',$sit = '',$orderby = 'DESC') {
		$nom = trim($nom);
		$desc = trim($desc);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_tarea, academ_tema";
		$sql.= " WHERE tem_codigo = tar_tema";
		$sql.= " AND tar_situacion != 0";
		$sql.= " AND YEAR(tar_fecha_entrega) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND tar_codigo IN($codigo)"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND tar_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND tar_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND tar_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND tar_seccion IN($seccion)";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND tar_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND tar_maestro = $maestro"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND tem_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND tar_tema = $tema"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND tar_tipo IN($tipo)";
		}
		if(strlen($nom)>0) { 
		    $sql.= " AND tar_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0) { 
		    $sql.= " AND tar_descripcion like '%$desc%'"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND tar_fecha_entrega > '$desde 00:00:00'"; 
		}else{
			//$sql.= " AND tar_fecha_entrega > '".date("Y-m-d H:i:s")."'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND tar_fecha_entrega BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND tar_situacion = '$sit'"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_tarea($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$tema,$nom,$desc,$tipo,$ponderacion,$tipocalifica,$fecha,$link){
		$nom = trim($nom);
		$desc = trim($desc);
		$fecha = $this->regresa_fechaHora($fecha);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO academ_tarea";
		$sql.= " VALUES ($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$tema,'$nom','$desc','$tipo','$ponderacion','$tipocalifica','$fecha','$freg','$link',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_tarea_datos($codigo,$tema,$maestro,$nom,$desc,$tipo,$ponderacion,$tipocalifica,$fecha,$link){
		$nom = trim($nom);
		$desc = trim($desc);
		$fecha = $this->regresa_fechaHora($fecha);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE academ_tarea SET ";
		$sql.= "tar_tema = '$tema',"; 
		$sql.= "tar_maestro = '$maestro',"; 
		$sql.= "tar_nombre = '$nom',"; 
		$sql.= "tar_descripcion = '$desc',";
		$sql.= "tar_tipo = '$tipo',"; 
		$sql.= "tar_ponderacion = '$ponderacion',"; 
		$sql.= "tar_tipo_calificacion = '$tipocalifica',"; 
		$sql.= "tar_link = '$link',"; 
		$sql.= "tar_fecha_entrega = '$fecha',";
		$sql.= "tar_fecha_registro = '$freg'";
		
		$sql.= " WHERE tar_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function modifica_tareas_materia($codigo,$pensum,$nivel,$grado,$materia,$tema){
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE academ_tarea SET ";
		$sql.= "tar_pensum = '$pensum',"; 
		$sql.= "tar_nivel = '$nivel',"; 		
		$sql.= "tar_grado = '$grado',";
		$sql.= "tar_materia = '$materia',";
		$sql.= "tar_tema = '$tema'";
		
		$sql.= " WHERE tar_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function modifica_tareas_aulumnos($codigo,$pensum,$nivel,$grado,$seccion){
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE academ_tarea SET ";
		$sql.= "tar_pensum = '$pensum',"; 
		$sql.= "tar_nivel = '$nivel',"; 		
		$sql.= "tar_grado = '$grado',";
		$sql.= "tar_seccion = '$seccio'";
		
		$sql.= " WHERE tar_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_tarea($codigo,$sit){
		$sql = "UPDATE academ_tarea SET ";
		$sql.= "tar_situacion = $sit"; 
				
		$sql.= " WHERE tar_codigo = $codigo ;"; 	
		
		return $sql;
	}
	
	function delete_tarea($codigo){
		$sql = "DELETE FROM academ_resolucion_tarea_archivo";
		$sql.= " WHERE arch_tarea = '$codigo';";
		
		$sql.= "DELETE FROM academ_resolucion_tarea";
		$sql.= " WHERE reso_tarea = '$codigo';";
		
		$sql.= "DELETE FROM academ_det_tarea ";
		$sql.= " WHERE dtar_tarea = $codigo; ";
		
		$sql.= "DELETE FROM academ_tarea ";
		$sql.= " WHERE tar_codigo = $codigo;"; 	
		
		return $sql;
	}

	function max_tarea(){
	  
	    $sql = "SELECT max(tar_codigo) as max ";
		$sql.= " FROM academ_tarea";
		$sql.= " WHERE 1 = 1";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
///////////////////////////// DETALLE DE TAREAS ACADEMICAS //////////////////////////////////////
	
	function get_det_tarea($tarea,$alumno = '',$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$unidad = '',$tema = '',$tipo = '',$sit = '',$orderby = 'DESC') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT *, ";
		//--- subquery resolucion de tarea --//
		$sql.= " (SELECT COUNT(*) FROM academ_resolucion_tarea";
		$sql.= " WHERE reso_tarea = dtar_tarea";
		$sql.= " AND reso_alumno = dtar_alumno) as dtar_resolucion, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = tar_pensum"; 
		$sql.= " AND gra_nivel = tar_nivel"; 
		$sql.= " AND gra_codigo = tar_grado) as tar_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = tar_pensum"; 
		$sql.= " AND sec_nivel = tar_nivel"; 
		$sql.= " AND sec_grado = tar_grado"; 
		$sql.= " AND sec_codigo = tar_seccion) as tar_seccion_desc, ";
		//--- subquery de materias --//
		$sql.= " (SELECT mat_descripcion FROM academ_nivel, academ_grado, academ_materia";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND mat_pensum = tar_pensum"; 
		$sql.= " AND mat_nivel = tar_nivel"; 
		$sql.= " AND mat_grado = tar_grado"; 
		$sql.= " AND mat_codigo = tar_materia) as tar_materia_desc,"; 
		//--- subquery de maestro --//
		$sql.= " (SELECT CONCAT(TRIM(mae_nombre),' ',TRIM(mae_apellido)) FROM app_maestros";
		$sql.= " WHERE mae_cui = tar_maestro LIMIT 0, 1) as tar_maestro_nombre,"; 
		//--- subquery de solucion de tarea de alumnos --//
		$sql.= " (SELECT reso_fecha_registro FROM academ_resolucion_tarea";
		$sql.= " WHERE reso_tarea = dtar_tarea AND reso_alumno = dtar_alumno) as tar_fecha_resolucion_alumno"; 
		//--	
		$sql.= " FROM academ_det_tarea, academ_tarea, app_alumnos, academ_tema";
		$sql.= " WHERE tar_codigo = dtar_tarea";
		$sql.= " AND tar_tema = tem_codigo";
		$sql.= " AND alu_cui = dtar_alumno";
		$sql.= " AND tar_situacion != 0";
		$sql.= " AND alu_situacion != 0";
		$sql.= " AND YEAR(tar_fecha_entrega) BETWEEN $anio1 AND $anio2";
		
		if(strlen($tarea)>0) { 
		    $sql.= " AND dtar_tarea IN($tarea)"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND dtar_alumno IN($alumno)"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND tar_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND tar_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND tar_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND tar_seccion = $seccion";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND tar_materia = $materia"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND tem_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND tar_tema = $tema"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND tar_tipo IN($tipo)";
		}
		if(strlen($sit)>0) { 
			$sql.= " AND dtar_situacion = $sit"; 
		}
		$sql.= " ORDER BY alu_apellido ASC, alu_nombre ASC, dtar_alumno ASC, tar_fecha_entrega $orderby ";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
	
	
	function get_notas_tarea($tarea,$alumno = '',$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$unidad = '',$tema = '',$tipo_calificacion = '',$situacion = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT SUM(dtar_nota) as puntos ";
		$sql.= " FROM academ_det_tarea, academ_tarea, academ_tema";
		$sql.= " WHERE tar_codigo = dtar_tarea";
		$sql.= " AND tar_tema = tem_codigo";
		$sql.= " AND tar_situacion != 0";
		$sql.= " AND YEAR(tar_fecha_entrega) BETWEEN $anio1 AND $anio2";
		
		if(strlen($tarea)>0) { 
		    $sql.= " AND dtar_tarea IN($tarea)"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND dtar_alumno IN($alumno)"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND tar_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND tar_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND tar_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND tar_seccion = $seccion";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND tar_materia = $materia"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND tem_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND tar_tema = $tema"; 
		}
		if(strlen($tipo_calificacion)>0) { 
			$sql.= " AND tar_tipo_calificacion = '$tipo_calificacion'";
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND dtar_situacion IN($situacion)"; 
		}
		$sql.= " ORDER BY dtar_alumno ASC, tar_fecha_entrega DESC ";
		
		//echo $sql;
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$puntos = $row['puntos'];
			}
		}
		return $puntos;

	}

	function get_notasmax_tarea($tarea,$alumno = '',$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$unidad = '',$tema = '',$tipo_calificacion = '',$situacion = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT SUM(tar_ponderacion) as puntos ";
		$sql.= ",(SELECT count(tar_ponderacion))as cantidad";
		$sql.= " FROM academ_det_tarea, academ_tarea, academ_tema";
		$sql.= " WHERE tar_codigo = dtar_tarea";
		$sql.= " AND tar_tema = tem_codigo";
		$sql.= " AND tar_situacion != 0";
		$sql.= " AND YEAR(tar_fecha_entrega) BETWEEN $anio1 AND $anio2";
		
		if(strlen($tarea)>0) { 
		    $sql.= " AND dtar_tarea IN($tarea)"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND dtar_alumno IN($alumno)"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND tar_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND tar_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND tar_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND tar_seccion = $seccion";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND tar_materia = $materia"; 
		}
		if(strlen($unidad)>0) { 
		    $sql.= " AND tem_unidad = $unidad"; 
		}
		if(strlen($tema)>0) { 
		    $sql.= " AND tar_tema = $tema"; 
		}
		if(strlen($tipo_calificacion)>0) { 
			$sql.= " AND tar_tipo_calificacion = '$tipo_calificacion'";
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND dtar_situacion IN($situacion)"; 
		}
		$sql.= " ORDER BY dtar_alumno ASC, tar_fecha_entrega DESC ";
		
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}	
	
	function insert_det_tarea($tarea,$alumno,$nota,$obs,$sit){
		$obs = trim($obs);
		
		$sql = "INSERT INTO academ_det_tarea";
		$sql.= " VALUES ('$tarea','$alumno','$nota','$obs',$sit)";
		$sql.= " ON DUPLICATE KEY UPDATE dtar_nota = '$nota', dtar_observaciones = '$obs', dtar_situacion = '$sit'; ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_det_tarea($tarea,$alumno,$nota,$obs){
		$obs = trim($obs);
		
		$sql = "UPDATE academ_det_tarea SET ";
		$sql.= "dtar_nota = '$nota',"; 
		$sql.= "dtar_observaciones = '$obs'"; 		
		
		$sql.= " WHERE dtar_tarea = $tarea";
		$sql.= " AND dtar_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambiar_sit_det_tarea($tarea,$alumno,$sit){
		
		$sql = "UPDATE academ_det_tarea SET ";
		$sql.= "dtar_situacion = '$sit'"; 
		
		$sql.= " WHERE dtar_tarea = $tarea";
		$sql.= " AND dtar_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_det_tarea_alumnos($tarea){
		
		$sql = "DELETE FROM academ_det_tarea ";
		
		$sql.= " WHERE dtar_tarea = $tarea; ";
		//echo $sql;
		return $sql;
	}
	
	
	
	
//--- Archivos de Tareas Academicas ---//
	
	function get_tarea_archivo($codigo,$tarea,$nom = ''){
		$nom = trim($nom);
		
		$sql= "SELECT * ";
		$sql.= " FROM academ_tarea_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			  $sql.= " AND arch_codigo = $codigo"; 
		}
		if(strlen($tarea)>0) { 
			  $sql.= " AND arch_tarea = '$tarea'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_tarea_archivo($codigo,$tarea,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO academ_tarea_archivo";
		$sql.= " VALUES ($codigo,$tarea,'$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_tarea_archivo($codigo,$tarea){
		$sql = "DELETE FROM academ_tarea_archivo";
		$sql.= " WHERE arch_codigo = $codigo"; 	
		$sql.= " AND arch_tarea = '$tarea';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_tarea_archivo($tarea) {
		
		$sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM academ_tarea_archivo";
		$sql.= " WHERE arch_tarea = '$tarea'"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
/////////////////////////////  RESPUESTA DE TAREAS ACADEMICAS  //////////////////////////////////////
	
	function insert_respuesta_tarea($tarea,$alumno,$texto){
		$texto = trim($texto);
		$fsis = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO academ_resolucion_tarea";
		$sql.= " VALUES ('$tarea','$alumno','$texto','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE reso_texto = '$texto', reso_fecha_registro = '$fsis'; ";
		//echo $sql;
		return $sql;
	}
	
	function get_respuesta_directa($tarea,$alumno) {
		
		$sql= "SELECT * ";
		$sql.= " FROM academ_resolucion_tarea";
		$sql.= " WHERE reso_tarea = '$tarea'"; 
		$sql.= " AND reso_alumno = '$alumno'"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	//--- Archivos de Respusta para Tareas Academicas ---//
	
	function get_respuesta_tarea_archivo($codigo,$tarea,$alumno,$nom = ''){
		$nom = trim($nom);
		
		$sql= "SELECT * ";
		$sql.= " FROM academ_resolucion_tarea_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			  $sql.= " AND arch_codigo = $codigo"; 
		}
		if(strlen($tarea)>0) { 
			  $sql.= " AND arch_tarea = '$tarea'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND arch_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_respuesta_tarea_archivo($codigo,$tarea,$alumno,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO academ_resolucion_tarea_archivo";
		$sql.= " VALUES ('$codigo','$tarea','$alumno','$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_respuesta_tarea_archivo($codigo,$tarea,$alumno){
		$sql = "DELETE FROM academ_resolucion_tarea_archivo";
		$sql.= " WHERE arch_codigo = $codigo"; 	
		$sql.= " AND arch_tarea = '$tarea'"; 
		$sql.= " AND arch_alumno = '$alumno';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_respuesta_tarea_archivo($tarea,$alumno) {
		
		$sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM academ_resolucion_tarea_archivo";
		$sql.= " WHERE arch_tarea = '$tarea'"; 
		$sql.= " AND arch_alumno = '$alumno';"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////////////////////////////  TAREA DE CURSOS LIBRES //////////////////////////////////////
		
    function get_tarea_curso($codigo,$curso = '',$tema = '',$maestro = '',$tipo = '',$desde = '',$fecha = '',$sit = '',$orderby = 'DESC') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT *, ";
		//--- subquery de curso --//
		$sql.= " (SELECT cur_nombre FROM lms_curso";
		$sql.= " WHERE cur_codigo = tar_curso) as tar_curso_nombre, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT tem_nombre FROM lms_tema";
		$sql.= " WHERE tem_curso = tar_curso";
		$sql.= " AND tem_codigo = tar_tema) as tar_tema_nombre ";
		//--	
		$sql.= " FROM lms_tarea";
		$sql.= " WHERE tar_situacion != 0";
		$sql.= " AND YEAR(tar_fecha_entrega) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND tar_codigo = $codigo"; 
		}
		if(strlen($curso)>0) { 
			$sql.= " AND tar_curso IN($curso)"; 
		}
		if(strlen($tema)>0) { 
			$sql.= " AND tar_tema IN($tema)"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND tar_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
		    $sql.= " AND tar_tipo = '$tipo'"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND tar_fecha_entrega > '$desde 00:00:00'"; 
		}else{
			//$sql.= " AND tar_fecha_entrega > '".date("Y-m-d H:i:s")."'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND tar_fecha_entrega BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND tar_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY tar_fecha_entrega $orderby, tar_maestro ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_tarea_curso($codigo,$curso = '',$tema = '',$maestro = '',$tipo = '',$desde = '',$fecha = '',$sit = '') {
		$nom = trim($nom);
		$desc = trim($desc);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_tarea";
		$sql.= " WHERE tar_situacion != 0";
		$sql.= " AND YEAR(tar_fecha_entrega) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND tar_codigo = $codigo"; 
		}
		if(strlen($curso)>0) { 
			$sql.= " AND tar_curso IN($curso)"; 
		}
		if(strlen($tema)>0) { 
			$sql.= " AND tar_tema IN($tema)"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND tar_maestro = '$maestro'"; 
		}
		if(strlen($tipo)>0) { 
		    $sql.= " AND tar_tipo = '$tipo'"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND tar_fecha_entrega > '$desde 00:00:00'"; 
		}else{
			//$sql.= " AND tar_fecha_entrega > '".date("Y-m-d H:i:s")."'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND tar_fecha_entrega BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND tar_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_tarea_curso($codigo,$curso,$tema,$maestro,$nom,$desc,$tipo,$ponderacion,$tipocalifica,$fecha,$link){
		$nom = trim($nom);
		$desc = trim($desc);
		$fecha = $this->regresa_fechaHora($fecha);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO lms_tarea";
		$sql.= " VALUES ($codigo,$curso,$tema,$maestro,'$nom','$desc','$tipo','$ponderacion','$tipocalifica','$fecha','$freg','$link',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_tarea_curso($codigo,$nom,$desc,$tipo,$ponderacion,$tipocalifica,$fecha,$link){
		$nom = trim($nom);
		$desc = trim($desc);
		$fecha = $this->regresa_fechaHora($fecha);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE lms_tarea SET ";
		$sql.= "tar_nombre = '$nom',"; 
		$sql.= "tar_descripcion = '$desc',"; 		
		$sql.= "tar_tipo = '$tipo',"; 
		$sql.= "tar_ponderacion = '$ponderacion',"; 
		$sql.= "tar_tipo_calificacion = '$tipocalifica',"; 
		$sql.= "tar_link = '$link',"; 
		$sql.= "tar_fecha_entrega = '$fecha',";
		$sql.= "tar_fecha_registro = '$freg'";
		
		$sql.= " WHERE tar_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}

	
	function cambia_sit_tarea_curso($codigo,$sit){
		$sql = "UPDATE lms_tarea SET ";
		$sql.= "tar_situacion = $sit"; 
				
		$sql.= " WHERE tar_codigo = $codigo ;"; 	
		
		return $sql;
	}
	
	function delete_tarea_curso($codigo){
		$sql = "DELETE FROM lms_tarea_archivo";
		$sql.= " WHERE arch_tarea = '$codigo';";
		
		$sql.= "DELETE FROM lms_resolucion_tarea";
		$sql.= " WHERE reso_tarea = '$codigo';";
		
		$sql.= "DELETE FROM lms_det_tarea ";
		$sql.= " WHERE dtar_tarea = $codigo; ";
		
		$sql.= "DELETE FROM lms_tarea ";
		$sql.= " WHERE tar_codigo = $codigo;"; 	
		
		return $sql;
	}

	function max_tarea_curso(){
		$sql = "SELECT max(tar_codigo) as max ";
		$sql.= " FROM lms_tarea";
		$sql.= " WHERE 1 = 1";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
///////////////////////////// DETALLE DE TAREA DE CURSOS LIBRES //////////////////////////////////////
	
	function get_det_tarea_curso($tarea,$alumno = '',$curso = '',$tema = '',$tipo = '',$sit = '',$orderby = 'DESC') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT *, ";
		//--- subquery resolucion de tarea --//
		$sql.= " (SELECT COUNT(*) FROM lms_resolucion_tarea";
		$sql.= " WHERE reso_tarea = dtar_tarea";
		$sql.= " AND reso_alumno = dtar_alumno) as dtar_resolucion, ";
		//--- subquery de curso --//
		$sql.= " (SELECT cur_nombre FROM lms_curso";
		$sql.= " WHERE cur_codigo = tar_curso) as tar_curso_nombre, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT tem_nombre FROM lms_tema";
		$sql.= " WHERE tem_curso = tar_curso";
		$sql.= " AND tem_codigo = tar_tema) as tar_tema_nombre, ";
		//--- subquery de maestro --//
		$sql.= " (SELECT CONCAT(TRIM(mae_nombre),' ',TRIM(mae_apellido)) FROM app_maestros";
		$sql.= " WHERE mae_cui = tar_maestro) as tar_maestro_nombre,"; 
		//--- subquery de solucion de tarea de alumnos --//
		$sql.= " (SELECT reso_fecha_registro FROM lms_resolucion_tarea";
		$sql.= " WHERE reso_tarea = dtar_tarea AND reso_alumno = dtar_alumno) as tar_fecha_resolucion_alumno"; 
		//--	
		$sql.= " FROM lms_det_tarea, lms_tarea, app_alumnos";
		$sql.= " WHERE tar_codigo = dtar_tarea";
		$sql.= " AND alu_cui = dtar_alumno";
		$sql.= " AND YEAR(tar_fecha_entrega) BETWEEN $anio1 AND $anio2";
		if(strlen($tarea)>0) { 
		    $sql.= " AND dtar_tarea = $tarea"; 
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND dtar_alumno = '$alumno'"; 
		}
		if(strlen($curso)>0) { 
			$sql.= " AND tar_curso IN($curso)"; 
		}
		if(strlen($tema)>0) { 
			$sql.= " AND tar_tema IN($tema)"; 
		}
		if(strlen($tipo)>0) { 
		    $sql.= " AND tar_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND dtar_situacion = $sit"; 
		}
		$sql.= " ORDER BY alu_apellido ASC, alu_nombre ASC, dtar_alumno ASC, tar_fecha_entrega $orderby ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function insert_det_tarea_curso($tarea,$alumno,$nota,$obs,$sit){
		$obs = trim($obs);
		
		$sql = "INSERT INTO lms_det_tarea";
		$sql.= " VALUES ('$tarea','$alumno','$nota','$obs',$sit)";
		$sql.= " ON DUPLICATE KEY UPDATE dtar_nota = '$nota', dtar_observaciones = '$obs', dtar_situacion = '$sit'; ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_det_tarea_curso($tarea,$alumno,$nota,$obs){
		$obs = trim($obs);
		
		$sql = "UPDATE lms_det_tarea SET ";
		$sql.= "dtar_nota = '$nota',"; 
		$sql.= "dtar_observaciones = '$obs'"; 		
		
		$sql.= " WHERE dtar_tarea = $tarea";
		$sql.= " AND dtar_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambiar_sit_det_tarea_curso($tarea,$alumno,$sit){
		
		$sql = "UPDATE lms_det_tarea SET ";
		$sql.= "dtar_situacion = '$sit'"; 
		
		$sql.= " WHERE dtar_tarea = $tarea";
		$sql.= " AND dtar_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_det_tarea_alumnos_curso($tarea){
		
		$sql = "DELETE FROM lms_det_tarea ";
		$sql.= " WHERE dtar_tarea = $tarea; ";
		//echo $sql;
		return $sql;
	}
	
	//--- Archivos de Tareas de Cursos Libres ---//
	
	function get_tarea_curso_archivo($codigo,$tarea,$nom = ''){
		$nom = trim($nom);
		
		$sql= "SELECT * ";
		$sql.= " FROM lms_tarea_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			  $sql.= " AND arch_codigo = $codigo"; 
		}
		if(strlen($tarea)>0) { 
			  $sql.= " AND arch_tarea = '$tarea'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_tarea_curso_archivo($codigo,$tarea,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO lms_tarea_archivo";
		$sql.= " VALUES ($codigo,$tarea,'$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_tarea_curso_archivo($codigo,$tarea){
		$sql = "DELETE FROM lms_tarea_archivo";
		$sql.= " WHERE arch_codigo = $codigo"; 	
		$sql.= " AND arch_tarea = '$tarea';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_tarea_curso_archivo($tarea) {
		
		$sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM lms_tarea_archivo";
		$sql.= " WHERE arch_tarea = '$tarea'"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////////////////////////////  RESPUESTA DE CURSOS LIBRES  //////////////////////////////////////
	
	function insert_respuesta_tarea_curso($tarea,$alumno,$texto){
		$texto = trim($texto);
		$fsis = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO lms_resolucion_tarea";
		$sql.= " VALUES ('$tarea','$alumno','$texto','$fsis')";
		$sql.= " ON DUPLICATE KEY UPDATE reso_texto = '$texto', reso_fecha_registro = '$fsis'; ";
		//echo $sql;
		return $sql;
	}
	
	function get_respuesta_directa_curso($tarea,$alumno) {
		
		$sql= "SELECT * ";
		$sql.= " FROM lms_resolucion_tarea";
		$sql.= " WHERE reso_tarea = '$tarea'"; 
		$sql.= " AND reso_alumno = '$alumno'"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	//--- Archivos de Respusta para Tareas de Cursos Libres ---//
	
	function get_respuesta_tarea_curso_archivo($codigo,$tarea,$alumno,$nom = ''){
		$nom = trim($nom);
		
		$sql= "SELECT * ";
		$sql.= " FROM lms_resolucion_tarea_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			  $sql.= " AND arch_codigo = $codigo"; 
		}
		if(strlen($tarea)>0) { 
			  $sql.= " AND arch_tarea = '$tarea'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND arch_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_respuesta_tarea_curso_archivo($codigo,$tarea,$alumno,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO lms_resolucion_tarea_archivo";
		$sql.= " VALUES ($codigo,$tarea,'$alumno','$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_respuesta_tarea_curso_archivo($codigo,$tarea,$alumno){
		$sql = "DELETE FROM lms_resolucion_tarea_archivo";
		$sql.= " WHERE arch_codigo = $codigo"; 	
		$sql.= " AND arch_tarea = '$tarea'"; 
		$sql.= " AND arch_alumno = '$alumno';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_respuesta_tarea_curso_archivo($tarea,$alumno) {
		
		$sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM lms_resolucion_tarea_archivo";
		$sql.= " WHERE arch_tarea = '$tarea'"; 
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