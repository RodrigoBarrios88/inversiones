<?php
require_once ("ClsConex.php");

class ClsNotasprom extends ClsConex{
	
	//---------- NOTAS DE ALUMNOS ---------//

	function get_notas_alumno($alumno,$pensum,$nivel,$grado,$materia = '',$parcial = '',$tipo = '',$seccion = '',$fini = '',$ffin = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_unidades, academ_notas, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND uni_pensum = mat_pensum";
		$sql.= " AND uni_nivel = mat_nivel";
		$sql.= " AND not_pensum = gra_pensum";
		$sql.= " AND not_nivel = gra_nivel";
		$sql.= " AND not_grado = gra_codigo";
		$sql.= " AND not_parcial = uni_unidad";
		$sql.= " AND not_alumno = alu_cui";
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND not_materia IN($materia)"; 
		}
		if(strlen($parcial)>0) { 
			  $sql.= " AND not_parcial IN($parcial)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND not_seccion = $seccion"; 
		}
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			$fini = $this->regresa_fechaHora($fini);
			$ffin = $this->regresa_fechaHora($ffin);
			
			$sql.= " AND not_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, uni_pensum ASC, uni_nivel ASC, uni_grado ASC, uni_materia ASC, uni_situacion DESC, uni_tipo DESC, uni_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function count_notas_alumno($alumno,$pensum,$nivel,$grado,$materia = '',$parcial = '',$tipo = '',$seccion = '',$fini = '',$ffin = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_unidades, academ_notas, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND uni_pensum = mat_pensum";
		$sql.= " AND uni_nivel = mat_nivel";
		$sql.= " AND not_pensum = gra_pensum";
		$sql.= " AND not_nivel = gra_nivel";
		$sql.= " AND not_grado = gra_codigo";
		$sql.= " AND not_parcial = uni_unidad";
		$sql.= " AND not_alumno = alu_cui";
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND not_materia IN($materia)"; 
		}
		if(strlen($parcial)>0) { 
			  $sql.= " AND not_parcial IN($parcial)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND not_seccion = $seccion"; 
		}
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			$fini = $this->regresa_fechaHora($fini);
			$ffin = $this->regresa_fechaHora($ffin);
			
			$sql.= " AND not_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function comprueba_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial){
		
        $sql= "SELECT *";
		$sql.= " FROM academ_notas";
		$sql.= " WHERE 1 = 1";
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND not_materia = $materia"; 
		}
		if(strlen($parcial)>0) { 
			  $sql.= " AND not_parcial = $parcial"; 
		}
		$sql.= " ORDER BY not_pensum ASC, not_nivel ASC, not_grado ASC, not_materia ASC, not_parcial ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_notas_alumno_tarjeta($alumno,$pensum,$nivel,$grado,$seccion = '',$materia = '',$num_parcial = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT * ";
		$sql.= " FROM academ_materia, academ_notas";
		$sql.= " WHERE not_pensum = mat_pensum";
		$sql.= " AND not_nivel = mat_nivel";
		$sql.= " AND not_grado = mat_grado";
		$sql.= " AND not_materia = mat_codigo";
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND not_seccion = $seccion"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND not_materia = $materia"; 
		}
		if(strlen($num_parcial)>0) { 
			  $sql.= " AND not_parcial IN($num_parcial)"; 
		}
		$sql.= " ORDER BY mat_tipo ASC, not_materia ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_promedios_seccion($pensum,$nivel,$grado,$seccion,$parcial){
		
		$sql.= "SELECT *, sum(not_total) AS nota_total_alumno, count(not_total) AS notas_conteo,(sum(not_total) / count(not_total)) AS nota_promedio";
		$sql.= " FROM academ_notas";
		$sql.= " WHERE 1 = 1";
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND not_seccion = $seccion"; 
		}
		if(strlen($parcial)>0) { 
			  $sql.= " AND not_parcial = $parcial"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		$sql.= " GROUP BY not_alumno";
		$sql.= " ORDER BY nota_promedio DESC, not_alumno ASC, not_materia ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_promedios_alumno($pensum,$nivel,$grado,$alumno,$parcial = ''){
		
		$sql.= "SELECT *, sum(not_total) AS nota_total, count(not_total) AS notas_conteo,(sum(not_total) / count(not_total)) AS nota_promedio";
		$sql.= " FROM academ_notas";
		$sql.= " WHERE 1 = 1";
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($parcial)>0) { 
			  $sql.= " AND not_parcial = '$parcial'"; 
		}
		$sql.= " GROUP BY not_parcial";
		$sql.= " ORDER BY not_parcial ASC, not_materia ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_promedios_materia($pensum,$nivel,$grado,$alumno,$materia = '',$unidades = ''){
		
		$sql.= "SELECT *, sum(not_total) AS nota_total, count(not_total) AS notas_conteo,";
		if(strlen($unidades)>0) { 
			$sql.= "(sum(not_total) / $unidades) AS nota_promedio";
		}else{
			$sql.= "(sum(not_total) / count(not_total)) AS nota_promedio";
		}
		$sql.= " FROM academ_notas";
		$sql.= " WHERE 1 = 1";
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND not_materia = '$materia'"; 
		}
		$sql.= " GROUP BY not_materia";
		$sql.= " ORDER BY not_materia ASC, not_parcial ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
		
	function insert_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial,$zona,$nota,$seccion,$tipo_calificacion,$cantidadtotal){
		$fechor = date("Y-m-d H:i:s");
		$usuario = $_SESSION["codigo"];
		$totalporcent = ($zona + $nota);
	    $total = round(100 * $totalporcent / $cantidadtotal);
		
		$sql = "INSERT INTO academ_notas ";
		$sql.= " VALUES ('$alumno',$pensum,$nivel,$grado,$materia,$parcial,'$zona','$nota','$total',$seccion,$tipo_calificacion,'$fechor',$usuario,0,1) ";
		$sql.= " ON DUPLICATE KEY UPDATE ";
		$sql.= "not_zona = '$zona',"; 
		$sql.= "not_nota = '$nota',"; 
		$sql.= "not_total = '$total',"; 
		$sql.= "not_tipo_calificacion = '$tipo_calificacion',"; 
		$sql.= "not_fechor = '$fechor',"; 
		$sql.= "not_usuario = $usuario;"; 
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial,$zona,$nota){
		$fechor = date("Y-m-d H:i:s");
		$usuario = $_SESSION["codigo"];
		$total = ($zona+$nota);
		
		$sql = "UPDATE academ_notas SET ";
		$sql.= "not_zona = '$zona',"; 
		$sql.= "not_nota = '$nota',"; 
		$sql.= "not_total = '$total',"; 
		$sql.= "not_fechor = '$fechor',"; 
		$sql.= "not_usuario = $usuario"; 
		
		$sql.= " WHERE not_alumno = '$alumno'"; 	
		$sql.= " AND not_pensum = $pensum"; 	
		$sql.= " AND not_nivel = $nivel"; 	
		$sql.= " AND not_grado = $grado"; 	
		$sql.= " AND not_materia = $materia"; 	
		$sql.= " AND not_parcial = $parcial;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function certificar_notas_alumno($pensum,$nivel,$grado,$seccion,$materia,$parcial){
		$fechor = date("Y-m-d H:i:s");
		$usuario = $_SESSION["codigo"];
		
		$sql = "UPDATE academ_notas SET ";
		$sql.= "not_situacion = '2',"; 
		$sql.= "not_fechor = '$fechor',"; 
		$sql.= "not_certifica  = $usuario"; 
		
		$sql.= " WHERE not_pensum = $pensum"; 	
		$sql.= " AND not_nivel = $nivel"; 	
		$sql.= " AND not_grado = $grado"; 	
		$sql.= " AND not_seccion = $seccion"; 	
		$sql.= " AND not_materia = $materia"; 	
		$sql.= " AND not_parcial = $parcial;"; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_notas_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial){ //elimina notas ingresadas por error
		$fechor = date("Y-m-d H:i:s");
		
		$sql = "DELETE FROM academ_notas ";
		
		$sql.= " WHERE not_alumno = '$alumno'"; 	
		$sql.= " AND not_pensum = $pensum"; 	
		$sql.= " AND not_nivel = $nivel"; 	
		$sql.= " AND not_grado = $grado"; 	
		$sql.= " AND not_materia = $materia"; 	
		$sql.= " AND not_parcial = $parcial;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_toda_notas_alumno($pensum,$sit){
		
		$sql = "UPDATE academ_notas SET ";
		$sql.= "not_situacion = $sit"; 
				
		$sql.= " WHERE not_pensum = $pensum; "; 	
		
		return $sql;
	}
	
	
//---------- NOTAS DE RECUPERACION DE ALUMNOS ---------//

	function get_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia = '',$recuperacion = '',$tipo = '',$seccion = '',$fini = '',$ffin = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_notas_recuperacion, app_alumnos";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND uni_pensum = mat_pensum";
		$sql.= " AND uni_nivel = mat_nivel";
		$sql.= " AND uni_grado = mat_grado";
		$sql.= " AND uni_materia = mat_codigo";
		$sql.= " AND not_pensum = mat_pensum";
		$sql.= " AND not_nivel = uni_nivel";
		$sql.= " AND not_grado = mat_grado";
		$sql.= " AND not_materia = mat_codigo";
		$sql.= " AND not_alumno = alu_cui";
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND not_materia IN($materia)"; 
		}
		if(strlen($recuperacion)>0) { 
			  $sql.= " AND not_recuperacion IN($recuperacion)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND not_seccion = $seccion"; 
		}
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			$fini = $this->regresa_fechaHora($fini);
			$ffin = $this->regresa_fechaHora($ffin);
			
			$sql.= " AND not_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, mat_pensum ASC, mat_nivel ASC, mat_grado ASC, mat_codigo ASC, mat_situacion DESC, mat_tipo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia = '',$recuperacion = '',$tipo = '',$seccion = '',$fini = '',$ffin = '',$sit = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_notas_recuperacion, app_alumnos";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND uni_pensum = mat_pensum";
		$sql.= " AND uni_nivel = mat_nivel";
		$sql.= " AND uni_grado = mat_grado";
		$sql.= " AND uni_materia = mat_codigo";
		$sql.= " AND not_pensum = mat_pensum";
		$sql.= " AND not_nivel = uni_nivel";
		$sql.= " AND not_grado = mat_grado";
		$sql.= " AND not_materia = mat_codigo";
		$sql.= " AND not_alumno = alu_cui";
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND not_materia IN($materia)"; 
		}
		if(strlen($recuperacion)>0) { 
			  $sql.= " AND not_recuperacion IN($recuperacion)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND not_seccion = $seccion"; 
		}
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			$fini = $this->regresa_fechaHora($fini);
			$ffin = $this->regresa_fechaHora($ffin);
			
			$sql.= " AND not_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND alu_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function comprueba_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion){
		
        $sql= "SELECT *";
		$sql.= " FROM academ_notas_recuperacion";
		$sql.= " WHERE not_situacion = 1";
		if(strlen($alumno)>0) { 
			  $sql.= " AND not_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND not_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND not_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND not_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND not_materia = $materia"; 
		}
		if(strlen($recuperacion)>0) { 
			  $sql.= " AND not_recuperacion = $recuperacion"; 
		}
		$sql.= " ORDER BY not_pensum ASC, not_grado ASC, not_nivel ASC, not_materia ASC, not_recuperacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
		
	function insert_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion,$zona,$nota,$seccion){
		$fechor = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO academ_notas_recuperacion ";
		$sql.= " VALUES ('$alumno',$pensum,$nivel,$grado,$materia,$recuperacion,'$zona','$nota',$seccion,'$fechor',1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion,$zona,$nota){
		$fechor = date("Y-m-d H:i:s");
		
		$sql = "UPDATE academ_notas_recuperacion SET ";
		$sql.= "not_zona = '$zona',"; 
		$sql.= "not_nota = '$nota',"; 
		$sql.= "not_fechor = '$fechor'"; 
		
		$sql.= " WHERE not_alumno = '$alumno'"; 	
		$sql.= " AND not_pensum = $pensum"; 	
		$sql.= " AND not_grado = $grado"; 	
		$sql.= " AND not_nivel = $nivel"; 	
		$sql.= " AND not_materia = $materia"; 	
		$sql.= " AND not_recuperacion = $recuperacion;"; 	
		//echo $sql;
		return $sql;
	}
	
		
	function cambia_sit_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion,$sit){
		
		$sql = "UPDATE academ_notas_recuperacion SET ";
		$sql.= "not_situacion = $sit"; 
				
		$sql.= " WHERE not_alumno = '$alumno'"; 	
		$sql.= " AND not_pensum = $pensum"; 	
		$sql.= " AND not_grado = $grado"; 	
		$sql.= " AND not_nivel = $nivel"; 	
		$sql.= " AND not_materia = $materia"; 	
		$sql.= " AND not_recuperacion = $recuperacion;";	
		
		return $sql;
	}
	
	function delete_notas_alumno_recuperacion($alumno,$pensum,$nivel,$grado,$materia,$recuperacion){ //elimina notas ingresadas por error
		
		$sql = "DELETE FROM academ_notas_recuperacion ";	
		$sql.= " WHERE not_alumno = '$alumno'"; 	
		$sql.= " AND not_pensum = $pensum"; 	
		$sql.= " AND not_grado = $grado"; 	
		$sql.= " AND not_nivel = $nivel"; 	
		$sql.= " AND not_materia = $materia"; 	
		$sql.= " AND not_recuperacion = $recuperacion;";	
		//echo $sql;
		return $sql;
	}
	
//---------- UNIDADES POR NIVELES ---------//

	function get_unidades($pensum,$nivel = '',$unidad = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_unidades";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = uni_pensum";
		$sql.= " AND niv_codigo = uni_nivel";
		if(strlen($pensum)>0) { 
			  $sql.= " AND uni_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND uni_nivel = $nivel"; 
		}
		if(strlen($unidad)>0) { 
			  $sql.= " AND uni_unidad IN($unidad)"; 
		}
		$sql.= " ORDER BY pen_anio ASC, uni_pensum ASC, uni_nivel ASC, uni_unidad ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_unidades($pensum,$nivel = '',$unidad = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_unidades";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = uni_pensum";
		$sql.= " AND niv_codigo = uni_nivel";
		if(strlen($pensum)>0) { 
			  $sql.= " AND uni_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND uni_nivel = $nivel"; 
		}
		if(strlen($unidad)>0) { 
			  $sql.= " AND uni_unidad IN($unidad)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_unidades($pensum,$nivel,$unidad,$descripcion,$porcent){
		$descripcion = trim($descripcion);
		
		$sql = "INSERT INTO academ_unidades ";
		$sql.= " VALUES ($pensum,$nivel,$unidad,'$descripcion',$porcent); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_unidades($pensum,$nivel,$unidad,$descripcion,$porcent){
		
		$sql = "UPDATE academ_unidades SET ";
		$sql.= "uni_descripcion = '$descripcion',"; 
		$sql.= "uni_porcentaje = '$porcent'"; 
		
		$sql.= " WHERE uni_pensum = $pensum"; 	
		$sql.= " AND uni_nivel = $nivel"; 	
		$sql.= " AND uni_unidad = $unidad;"; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_unidades($pensum,$nivel,$unidad){
		
		$sql = "DELETE FROM academ_unidades ";
		$sql.= " WHERE uni_pensum = $pensum"; 	
		$sql.= " AND uni_nivel = $nivel"; 	
		$sql.= " AND uni_unidad = $unidad;"; 
		
		return $sql;
	}
	

	function max_unidades($pensum,$nivel){
		
        $sql = "SELECT max(uni_unidad) as max ";
		$sql.= " FROM academ_unidades";
		$sql.= " WHERE uni_pensum = $pensum"; 	
		$sql.= " AND uni_nivel = $nivel"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
//---------- LITERALES ---------//

	function get_literales($codigo = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM academ_notas_literales";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND lit_codigo IN($codigo)"; 
		}
		$sql.= " ORDER BY lit_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function count_literales($codigo = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_notas_literales";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND lit_codigo IN($codigo)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_literales($codigo,$alta,$baja,$letra){
		$letra = trim($letra);
		
		$sql = "INSERT INTO academ_notas_literales ";
		$sql.= " VALUES ($codigo,'$alta','$baja','$letra'); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_literales($codigo,$alta,$baja,$letra){
		
		$sql = "UPDATE academ_notas_literales SET ";
		$sql.= "lit_alta = '$alta',"; 
		$sql.= "lit_baja = '$baja',"; 
		$sql.= "lit_letra  = '$letra' "; 
		
		$sql.= " WHERE lit_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_literales($pensum,$nivel,$codigo){
		
		$sql = "DELETE FROM academ_notas_literales ";
		$sql.= " WHERE lit_codigo = $codigo;"; 
		
		return $sql;
	}
	

	function max_literales(){
		
        $sql = "SELECT max(lit_codigo) as max ";
		$sql.= " FROM academ_notas_literales";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
               $max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

//---------- TIPIFICACION ---------//

	function get_tipificacion($codigo = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM academ_notas_tipifica";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND tip_codigo IN($codigo)"; 
		}
		$sql.= " ORDER BY tip_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_tipificacion($codigo = ''){
		
          $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_notas_tipifica";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND tip_codigo IN($codigo)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_tipificacion($codigo,$alta,$baja,$letra){
		$letra = trim($letra);
		
		$sql = "INSERT INTO academ_notas_tipifica ";
		$sql.= " VALUES ($codigo,'$alta','$baja','$letra'); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_tipificacion($codigo,$alta,$baja,$letra){
		
		$sql = "UPDATE academ_notas_tipifica SET ";
		$sql.= "tip_alta = '$alta',"; 
		$sql.= "tip_baja = '$baja',"; 
		$sql.= "tip_califcacion  = '$letra' "; 
		
		$sql.= " WHERE tip_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_tipificacion($pensum,$nivel,$codigo){
		
		$sql = "DELETE FROM academ_notas_tipifica ";
		$sql.= " WHERE tip_codigo = $codigo;"; 
		
		return $sql;
	}
	

	function max_tipificacion(){
		
        $sql = "SELECT max(tip_codigo) as max ";
		$sql.= " FROM academ_notas_tipifica";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
               $max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

	//---------- COMENTARIOS DE NOTAS DEL ALUMNOS ---------//

	function get_comentario_alumno($alumno,$pensum,$nivel,$grado,$materia = '',$parcial = '',$fini = '',$ffin = ''){
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, ";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_id = comen_usuario ORDER BY usu_usuario DESC LIMIT 0,1) as comen_usuario_nombre ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_unidades, academ_notas_comentario, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND uni_pensum = mat_pensum";
		$sql.= " AND uni_nivel = mat_nivel";
		$sql.= " AND comen_pensum = gra_pensum";
		$sql.= " AND comen_nivel = gra_nivel";
		$sql.= " AND comen_grado = gra_codigo";
		$sql.= " AND comen_materia = mat_codigo";
		$sql.= " AND comen_unidad = uni_unidad";
		$sql.= " AND comen_alumno = alu_cui";
		if(strlen($alumno)>0) { 
			  $sql.= " AND comen_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND comen_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND comen_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND comen_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND comen_materia IN($materia)"; 
		}
		if(strlen($parcial)>0) { 
			  $sql.= " AND comen_unidad IN($parcial)"; 
		}
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			$fini = $this->regresa_fechaHora($fini);
			$ffin = $this->regresa_fechaHora($ffin);
			$sql.= " AND comen_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'"; 
		}
		$sql.= " ORDER BY pen_anio ASC, comen_pensum ASC, comen_nivel ASC, comen_grado ASC, comen_materia ASC, uni_unidad ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
		
	function insert_comentario_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial,$comentario){
		$fechor = date("Y-m-d H:i:s");
		$usuario = $_SESSION["codigo"];
		$sql = "INSERT INTO academ_notas_comentario ";
		$sql.= " VALUES ('$alumno',$pensum,$nivel,$grado,$materia,$parcial,'$comentario','$fechor',$usuario)";
		$sql.= " ON DUPLICATE KEY UPDATE "; 
		$sql.= "comen_comentario = '$comentario',"; 
		$sql.= "comen_fechor = '$fechor',"; 
		$sql.= "comen_usuario = $usuario;"; 
		//echo $sql;
		return $sql;
	}
	
	
	function delete_comentario_alumno($alumno,$pensum,$nivel,$grado,$materia,$parcial){ //elimina notas ingresadas por error
		$fechor = date("Y-m-d H:i:s");
		
		$sql = "DELETE FROM academ_notas_comentario ";
		
		$sql.= " WHERE comen_alumno = '$alumno'"; 	
		$sql.= " AND comen_pensum = $pensum"; 	
		$sql.= " AND comen_nivel = $nivel"; 	
		$sql.= " AND comen_grado = $grado"; 	
		$sql.= " AND comen_materia = $materia"; 	
		$sql.= " AND comen_unidad = $parcial;"; 	
		//echo $sql;
		return $sql;
	}

	//---------- MODIFICACIONES DE NOTAS DEL ALUMNOS ---------//

	function get_modificacion_nota($codigo,$alumno = '',$pensum = '',$nivel = '',$grado = '',$materia = '',$unidad = '',$fini = '',$ffin = ''){
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, ";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_id = mod_usuario ORDER BY usu_usuario DESC LIMIT 0,1) as mod_usuario_nombre ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia, academ_unidades, academ_notas_modificacion, app_alumnos";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND uni_pensum = mat_pensum";
		$sql.= " AND uni_nivel = mat_nivel";
		$sql.= " AND mod_pensum = gra_pensum";
		$sql.= " AND mod_nivel = gra_nivel";
		$sql.= " AND mod_grado = gra_codigo";
		$sql.= " AND mod_materia = mat_codigo";
		$sql.= " AND mod_unidad = uni_unidad";
		$sql.= " AND mod_alumno = alu_cui";
		if(strlen($codigo)>0) { 
			  $sql.= " AND mod_codigo = '$codigo'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND mod_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND mod_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND mod_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND mod_grado = $grado"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND mod_materia IN($materia)"; 
		}
		if(strlen($unidad)>0) { 
			  $sql.= " AND mod_unidad IN($unidad)"; 
		}
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			$fini = $this->regresa_fechaHora($fini);
			$ffin = $this->regresa_fechaHora($ffin);
			$sql.= " AND mod_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'"; 
		}
		$sql.= " ORDER BY mod_fechor DESC, mod_pensum ASC, mod_nivel ASC, mod_grado ASC, mod_materia ASC, uni_unidad ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
	
	
		
	function insert_modificacion_nota($codigo,$alumno,$pensum,$nivel,$grado,$materia,$unidad,$zona,$nota,$total,$justificacion){
		$fechor = date("Y-m-d H:i:s");
		$usuario = $_SESSION["codigo"];
		$sql = "INSERT INTO academ_notas_modificacion ";
		$sql.= " VALUES ($codigo,'$alumno',$pensum,$nivel,$grado,$materia,$unidad,'$zona','$nota','$total','$justificacion','$fechor',$usuario,0,1)";
		$sql.= " ON DUPLICATE KEY UPDATE "; 
		$sql.= "mod_zona_anterior = '$zona',"; 
		$sql.= "mod_nota_anterior = '$nota',"; 
		$sql.= "mod_total_anterior = '$total',"; 
		$sql.= "mod_justificacion = '$justificacion',"; 
		$sql.= "mod_fechor = '$fechor',"; 
		$sql.= "mod_usuario = $usuario;"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_modificacion() {
		
        $sql = "SELECT max(mod_codigo) as max ";
		$sql.= " FROM academ_notas_modificacion";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	
}	
?>