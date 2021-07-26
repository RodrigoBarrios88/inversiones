<?php
require_once ("ClsConex.php");

class ClsCursoLibre extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */

	//---------- CURSO ----------//
    function get_curso($cod,$sede = '',$clase = '',$nom = '',$anio = '',$mes = '',$fini = '',$ffin = ''){
		$nom = trim($nom);
		
        $sql= "SELECT * ";
		$sql.= " FROM lms_curso, lms_sede";
		$sql.= " WHERE cur_sede = sed_codigo";
		$sql.= " AND cur_situacion = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND cur_codigo IN($cod)"; 
		}
		if(strlen($sede)>0) { 
			  $sql.= " AND cur_sede = '$sede'"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND cur_clasificacion = '$clase'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND cur_nombre like '%$nom%'"; 
		}
		if(strlen($anio)>0) { 
			  $sql.= " AND YEAR(cur_fecha_inicio) = $anio"; 
		}
		if(strlen($mes)>0 && strlen($anio)>0) { 
			  $sql.= " AND YEAR(cur_fecha_inicio) = $anio";
			  $sql.= " AND MONTH(cur_fecha_inicio) = $mes"; 
		}
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND cur_fecha_inicio BETWEEN '$fini' AND '$ffin'"; 
		}
		$sql.= " ORDER BY cur_sede ASC, cur_clasificacion ASC, cur_fecha_inicio ASC, cur_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_curso($cod,$sede = '',$clase = '',$nom = '',$anio = '',$mes = '',$fini = '',$ffin = ''){
		$nom = trim($nom);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_curso, lms_sede";
		$sql.= " WHERE cur_sede = sed_codigo";
		$sql.= " AND cur_situacion = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND cur_codigo = $cod"; 
		}
		if(strlen($sede)>0) { 
			  $sql.= " AND cur_sede = '$sede'"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND cur_clasificacion = '$clase'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND cur_nombre like '%$nom%'"; 
		}
		if(strlen($anio)>0) { 
			  $sql.= " AND YEAR(cur_fecha_inicio) = $anio"; 
		}
		if(strlen($mes)>0 && strlen($anio)>0) { 
			  $sql.= " AND YEAR(cur_fecha_inicio) = $anio";
			  $sql.= " AND MONTH(cur_fecha_inicio) = $mes"; 
		}
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			
			$sql.= " AND cur_fecha_inicio BETWEEN '$fini' AND '$ffin'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_curso($cod,$nom,$desc,$clase,$sede,$cupo,$fini,$ffin){
		$nom = trim($nom);
		$desc = trim($desc);
		$fini = $this->regresa_fecha($fini);
		$ffin = $this->regresa_fecha($ffin);
		
		$sql = "INSERT INTO lms_curso";
		$sql.= " VALUES ($cod,'$nom','$desc','$clase','$sede','$cupo','$fini','$ffin',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_curso($cod,$nom,$desc,$clase,$sede,$cupo,$fini,$ffin){
		$nom = trim($nom);
		$desc = trim($desc);
		$fini = $this->regresa_fecha($fini);
		$ffin = $this->regresa_fecha($ffin);
		
		$sql = "UPDATE lms_curso SET ";
		$sql.= "cur_nombre = '$nom',"; 
		$sql.= "cur_descripcion = '$desc',"; 
		$sql.= "cur_clasificacion = '$clase',"; 
		$sql.= "cur_sede = '$sede',"; 
		$sql.= "cur_cupo_max = '$cupo',"; 
		$sql.= "cur_fecha_inicio = '$fini',"; 
		$sql.= "cur_fecha_fin = '$ffin'"; 
		
		$sql.= " WHERE cur_codigo = $cod;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_curso($cod){
		$sql = "UPDATE lms_tema SET tem_situacion = 0";
		$sql.= " WHERE tem_curso = '$curso';";
		//--
		$sql.= "UPDATE lms_curso SET cur_situacion = 0";
		$sql.= " WHERE cur_codigo = $cod;"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_curso() {
		
        $sql = "SELECT max(cur_codigo) as max ";
		$sql.= " FROM lms_curso";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	//---------- TEMA ---------//
    function get_tema($cod,$curso = '',$nom = '',$desc = ''){
		$nom = trim($nom);
		$desc = trim($desc);
		
        $sql= "SELECT * ";
		$sql.= " FROM lms_tema, lms_curso";
		$sql.= " WHERE tem_curso = cur_codigo";
		$sql.= " AND tem_situacion = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND tem_codigo = $cod"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND tem_curso = '$curso'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND tem_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND tem_descripcion like '%$desc%'"; 
		}
		$sql.= " ORDER BY tem_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_tema($cod,$curso = '',$nom = '',$desc = ''){
		$nom = trim($nom);
		$desc = trim($desc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_tema, lms_curso";
		$sql.= " WHERE tem_curso = cur_codigo";
		$sql.= " AND tem_situacion = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND tem_codigo = $cod"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND tem_curso = '$curso'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND tem_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND tem_descripcion like '%$desc%'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_tema($cod,$curso,$nom,$desc,$periodos){
		$nom = trim($nom);
		$desc = trim($desc);
		
		$sql = "INSERT INTO lms_tema (tem_codigo,tem_curso,tem_nombre,tem_descripcion,tem_cantidad_periodos,tem_situacion)";
		$sql.= " VALUES ($cod,'$curso','$nom','$desc','$periodos',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_tema($cod,$curso,$nom,$desc,$periodos){
		$nom = trim($nom);
		$desc = trim($desc);
		
		$sql = "UPDATE lms_tema SET ";
		$sql.= "tem_nombre = '$nom',"; 
		$sql.= "tem_descripcion = '$desc',"; 
		$sql.= "tem_cantidad_periodos = '$periodos'"; 
		
		$sql.= " WHERE tem_codigo = $cod"; 	
		$sql.= " AND tem_curso = '$curso';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_tema($cod,$curso){
		$sql = "UPDATE lms_tema SET tem_situacion = 0";
		$sql.= " WHERE tem_codigo = $cod"; 	
		$sql.= " AND tem_curso = '$curso';"; 
		//echo $sql;
		return $sql;
	}
	
	
	function max_tema($curso) {
		
        $sql = "SELECT max(tem_codigo) as max ";
		$sql.= " FROM lms_tema";
		$sql.= " WHERE tem_curso = '$curso'"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	//--- Archivos de temas ---//
	
	function get_tema_archivo($cod,$curso,$tema,$nom = ''){
		$nom = trim($nom);
		
        $sql= "SELECT * ";
		$sql.= " FROM lms_tema_archivo";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND arch_codigo = $cod"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND arch_curso = '$curso'"; 
		}
		if(strlen($tema)>0) { 
			  $sql.= " AND arch_tema = '$tema'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND arch_nombre like '%$nom%'"; 
		}
		$sql.= " ORDER BY arch_extencion ASC, arch_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function insert_tema_archivo($cod,$curso,$tema,$nom,$desc,$extension){
		$nom = trim($nom);
		$desc = trim($desc);
		$freg = date("Y-m-d H:m:s");
		
		$sql = "INSERT INTO lms_tema_archivo";
		$sql.= " VALUES ($cod,$curso,$tema,'$nom','$desc','$extension','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_tema_archivo($cod,$curso,$tema){
		$sql = "DELETE FROM lms_tema_archivo";
		$sql.= " WHERE arch_codigo = $cod"; 	
		$sql.= " AND arch_curso = '$curso'"; 
		$sql.= " AND arch_tema = '$tema';"; 
		//echo $sql;
		return $sql;
	}
	
	function max_tema_archivo($curso,$tema) {
		
        $sql = "SELECT max(arch_codigo) as max ";
		$sql.= " FROM lms_tema_archivo";
		$sql.= " WHERE arch_curso = '$curso'"; 
		$sql.= " AND arch_tema = '$tema'";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	

	//---------- CURSO - ALUMNO ---------//
	function get_alumno_curso($cui,$nom = '',$ape = '',$curso = '',$pensum) {
		$cui = trim($cui);
	    $sql= "SELECT *, ";
		if(strlen($curso)>0) { 
			$sql.= " (SELECT asi_curso FROM lms_curso_alumno WHERE asi_alumno = alu_cui AND asi_curso = $curso) as alu_curso_asignado,"; 
		}
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM app_alumnos,academ_seccion_alumno";
		$sql.= " WHERE alu_situacion = 1";
		$sql.= " AND seca_pensum = $pensum";
		$sql.= " AND seca_alumno = alu_cui";
		if(strlen($cui)>0) { 
			  $sql.= " AND alu_cui = '$cui'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND UPPER(alu_nombre) like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND UPPER(alu_apellido) like '%$ape%'"; 
		}
		$sql.= " ORDER BY alu_fecha_nacimiento DESC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_alumno($cui,$nom = '',$ape = '',$curso = '') {
		$cui = trim($cui);
		
	    $sql= "SELECT *, ";
		if(strlen($curso)>0) { 
			$sql.= " (SELECT asi_curso FROM lms_curso_alumno WHERE asi_alumno = alu_cui AND asi_curso = $curso) as alu_curso_asignado,"; 
		}
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM app_alumnos,lms_curso_alumno";
		$sql.= " WHERE alu_situacion = 1";
		$sql.= " AND alu_cui = asi_alumno";

		if(strlen($curso)>0) { 
			  $sql.= " AND asi_curso = '$curso'"; 
		}
		if(strlen($cui)>0) { 
			  $sql.= " AND alu_cui = '$cui'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND UPPER(alu_nombre) like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND UPPER(alu_apellido) like '%$ape%'"; 
		}
		$sql.= " ORDER BY alu_fecha_nacimiento DESC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	

	function get_curso_alumno($curso,$alumno,$sede = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT * ";
		$sql.= " FROM lms_curso_alumno, app_alumnos, lms_curso, lms_sede";
		$sql.= " WHERE asi_alumno = alu_cui";
		$sql.= " AND asi_curso = cur_codigo";
		$sql.= " AND cur_sede = sed_codigo";
		$sql.= " AND alu_situacion = 1"; 
		if(strlen($curso)>0) { 
			  $sql.= " AND asi_curso = $curso"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($sede)>0) { 
			  $sql.= " AND cur_sede = $sede"; 
		}
		$sql.= " ORDER BY cur_sede ASC, cur_clasificacion ASC, cur_fecha_inicio ASC, cur_nombre ASC, alu_apellido ASC, alu_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function count_curso_alumno($curso,$alumno,$sede = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_curso_alumno, app_alumnos, lms_curso, lms_sede";
		$sql.= " WHERE asi_alumno = alu_cui";
		$sql.= " AND asi_curso = cur_codigo";
		$sql.= " AND cur_sede = sed_codigo";
		$sql.= " AND alu_situacion = 1"; 
		if(strlen($curso)>0) { 
			  $sql.= " AND asi_curso = $curso"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($sede)>0) { 
			  $sql.= " AND cur_sede = $sede"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
		
	function insert_curso_alumno($curso,$alumno){
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO lms_curso_alumno";
		$sql.= " VALUES ($curso,'$alumno','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_curso_alumno($curso,$alumno){
		
		$sql = "DELETE FROM lms_curso_alumno ";
		
		$sql.= " WHERE asi_curso = $curso"; 	
		$sql.= " AND asi_alumno = '$alumno';";
		
		//echo $sql;
		return $sql;
	}
	
	
	//---------- CURSO - MAESTRO ---------//

	function get_curso_maestro($curso,$maestro,$sede = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT * ";
		$sql.= " FROM lms_curso_maestro, app_maestros, lms_curso, lms_sede";
		$sql.= " WHERE asi_maestro = mae_cui";
		$sql.= " AND asi_curso = cur_codigo";
		$sql.= " AND cur_sede = sed_codigo";
		$sql.= " AND mae_situacion = 1"; 
		if(strlen($curso)>0) { 
			  $sql.= " AND asi_curso = $curso"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND asi_maestro = '$maestro'"; 
		}
		if(strlen($sede)>0) { 
			  $sql.= " AND cur_sede = $sede"; 
		}
		$sql.= " ORDER BY cur_sede ASC, cur_clasificacion ASC, cur_fecha_inicio ASC, cur_nombre ASC, mae_apellido ASC, mae_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function count_curso_maestro($curso,$maestro,$sede = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_curso_maestro, app_maestros, lms_curso, lms_sede";
		$sql.= " WHERE asi_maestro = mae_cui";
		$sql.= " AND asi_curso = cur_codigo";
		$sql.= " AND cur_sede = sed_codigo";
		$sql.= " AND mae_situacion = 1"; 
		if(strlen($curso)>0) { 
			  $sql.= " AND asi_curso = $curso"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND asi_maestro = '$maestro'"; 
		}
		if(strlen($sede)>0) { 
			  $sql.= " AND cur_sede = $sede"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
		
	function insert_curso_maestro($curso,$maestro){
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO lms_curso_maestro";
		$sql.= " VALUES ($curso,'$maestro','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_curso_maestro($curso,$maestro){
		
		$sql = "DELETE FROM lms_curso_maestro ";
		
		$sql.= " WHERE asi_curso = $curso"; 	
		$sql.= " AND asi_maestro = '$maestro';";
		
		//echo $sql;
		return $sql;
	}
	
	
	function delete_grupo_curso_maestro($maestro){
		
		$sql = "DELETE FROM lms_curso_maestro ";
		$sql.= " WHERE asi_maestro = '$maestro';";
		
		//echo $sql;
		return $sql;
	}
	
	//---------- CURSO - AUTORIDAD ---------//

	function get_curso_autoridad($curso,$autoridad,$sede = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT * ";
		$sql.= " FROM lms_curso_autoridad, app_otros_usuarios, lms_curso, lms_sede";
		$sql.= " WHERE asi_autoridad = otro_cui";
		$sql.= " AND asi_curso = cur_codigo";
		$sql.= " AND cur_sede = sed_codigo";
		$sql.= " AND otro_situacion = 1"; 
		if(strlen($curso)>0) { 
			  $sql.= " AND asi_curso = $curso"; 
		}
		if(strlen($autoridad)>0) { 
			  $sql.= " AND asi_autoridad = '$autoridad'"; 
		}
		if(strlen($sede)>0) { 
			  $sql.= " AND cur_sede = $sede"; 
		}
		$sql.= " ORDER BY cur_sede ASC, cur_clasificacion ASC, cur_fecha_inicio ASC, cur_nombre ASC, otro_apellido ASC, otro_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function count_curso_autoridad($curso,$autoridad,$sede = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM lms_curso_autoridad, app_otros_usuarios, lms_curso, lms_sede";
		$sql.= " WHERE asi_autoridad = otro_cui";
		$sql.= " AND asi_curso = cur_codigo";
		$sql.= " AND cur_sede = sed_codigo";
		$sql.= " AND otro_situacion = 1"; 
		if(strlen($curso)>0) { 
			  $sql.= " AND asi_curso = $curso"; 
		}
		if(strlen($autoridad)>0) { 
			  $sql.= " AND asi_autoridad = '$autoridad'"; 
		}
		if(strlen($sede)>0) { 
			  $sql.= " AND cur_sede = $sede"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
		
	function insert_curso_autoridad($curso,$autoridad){
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO lms_curso_autoridad";
		$sql.= " VALUES ($curso,'$autoridad','$freg'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_curso_autoridad($curso,$autoridad){
		
		$sql = "DELETE FROM lms_curso_autoridad ";
		
		$sql.= " WHERE asi_curso = $curso"; 	
		$sql.= " AND asi_autoridad = '$autoridad';";
		
		//echo $sql;
		return $sql;
	}
	
	
	function delete_grupo_curso_autoridad($autoridad){
		
		$sql = "DELETE FROM lms_curso_autoridad ";
		$sql.= " WHERE asi_autoridad = '$autoridad';";
		
		//echo $sql;
		return $sql;
	}
	
	
}	
?>