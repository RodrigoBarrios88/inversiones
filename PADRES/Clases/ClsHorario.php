<?php
require_once ("ClsConex.php");

class ClsHorario extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
///////////////////////---------- ACADEMICO ---------/////////////////////
//---------- Tipo de Periodos Academicos ---------//

    function get_tipo_periodo($cod,$pensum,$nivel,$min = '',$desc = ''){
		$desc = trim($desc);
		
        $sql= "SELECT * ";
		$sql.= " FROM hor_tipo_periodo, academ_nivel, academ_pensum";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = tip_pensum";
		$sql.= " AND niv_codigo = tip_nivel";
		if(strlen($cod)>0) { 
			  $sql.= " AND tip_codigo = $cod"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND tip_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND tip_nivel = $nivel"; 
		}
		if(strlen($min)>0) { 
			  $sql.= " AND tip_minutos = $min"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND tip_descripcion like '%$desc%'"; 
		}
		$sql.= " ORDER BY tip_codigo ASC, tip_descripcion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_tipo_periodo($cod,$pensum,$nivel,$min = '',$desc = ''){
		$desc = trim($desc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM hor_tipo_periodo, academ_nivel, academ_pensum";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = tip_pensum";
		$sql.= " AND niv_codigo = tip_nivel";
		if(strlen($cod)>0) { 
			  $sql.= " AND tip_codigo = $cod"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND tip_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND tip_nivel = $nivel"; 
		}
		if(strlen($min)>0) { 
			  $sql.= " AND tip_minutos = $min"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND tip_descripcion like '%$desc%'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_tipo_periodo($cod,$pensum,$nivel,$min,$desc){
		$desc = trim($desc);
		
		$sql = "INSERT INTO hor_tipo_periodo (tip_codigo,tip_pensum,tip_nivel,tip_minutos,tip_descripcion)";
		$sql.= " VALUES ($cod,$pensum,$nivel,'$min','$desc'); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_tipo_periodo($cod,$pensum,$nivel,$min,$desc){
		$desc = trim($desc);
		
		$sql = "UPDATE hor_tipo_periodo SET ";
		$sql.= "tip_pensum = '$pensum',"; 
		$sql.= "tip_nivel = '$nivel',"; 
		$sql.= "tip_minutos = '$min',"; 
		$sql.= "tip_descripcion = '$desc'"; 
		
		$sql.= " WHERE tip_codigo = $cod"; 	
		$sql.= " AND tip_pensum = $pensum"; 	
		$sql.= " AND tip_nivel = $nivel;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function delete_tipo_periodo($cod,$pensum,$nivel){
		$sql = "DELETE FROM hor_tipo_periodo ";
		$sql.= " WHERE tip_codigo = $cod";
		$sql.= " AND tip_pensum = $pensum"; 	
		$sql.= " AND tip_nivel = $nivel;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function max_tipo_periodo($pensum,$nivel) {
		
        $sql = "SELECT max(tip_codigo) as max ";
		$sql.= " FROM hor_tipo_periodo";
		$sql.= " WHERE tip_pensum = $pensum"; 	
		$sql.= " AND tip_nivel = $nivel"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
//---------- Periodos---------//
    function get_periodos($cod,$dia = '',$tipo = '',$pensum = '',$nivel = '',$grado = '',$hini = '',$hfin = '') {
		
		$sql= "SELECT * ";
		$sql.= " FROM hor_periodos, hor_tipo_periodo, academ_nivel, academ_pensum";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = tip_pensum";
		$sql.= " AND niv_codigo = tip_nivel";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
		if(strlen($cod)>0) { 
			  $sql.= " AND per_codigo = $cod"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND per_dia = $dia"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND per_tipo = $tipo"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND per_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND per_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND per_grado = $grado"; 
		}
		if(strlen($hini)>0) { 
			  $sql.= " AND per_hini = '$hini'"; 
		}
		if(strlen($hfin)>0) { 
			  $sql.= " AND per_hfin = '$hfin'"; 
		}
		$sql.= " ORDER BY per_dia ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_periodos($cod,$dia = '',$tipo = '',$pensum = '',$nivel = '',$grado = '',$hini = '',$hfin = '') {
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM hor_periodos, hor_tipo_periodo, academ_nivel, academ_pensum";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = tip_pensum";
		$sql.= " AND niv_codigo = tip_nivel";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
		if(strlen($cod)>0) { 
			  $sql.= " AND per_codigo = $cod"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND per_dia = $dia"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND per_tipo = $tipo"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND per_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND per_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND per_grado = $grado"; 
		}
		if(strlen($hini)>0) { 
			  $sql.= " AND per_hini = '$hini'"; 
		}
		if(strlen($hfin)>0) { 
			  $sql.= " AND per_hfin = '$hfin'"; 
		}
		$sql.= " ORDER BY per_dia ASC, per_hini ASC, per_hfin ASC";
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_periodos($cod,$dia,$tipo,$pensum,$nivel,$grado,$hini,$hfin){
		
		$sql = "INSERT INTO hor_periodos";
		$sql.= " VALUES ($cod,$dia,$tipo,$pensum,$nivel,$grado,'$hini','$hfin'); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_periodos($cod,$dia,$tipo,$pensum,$nivel,$grado,$hini,$hfin){
		
		$sql = "UPDATE hor_periodos SET ";
		$sql.= "per_tipo = '$tipo',"; 
		$sql.= "per_pensum = '$pensum',"; 
		$sql.= "per_nivel = '$nivel',"; 
		$sql.= "per_grado = '$grado',"; 
		$sql.= "per_hini = '$hini',"; 
		$sql.= "per_hfin = '$hfin'"; 
		
		$sql.= " WHERE per_codigo = $cod "; 	
		$sql.= " AND per_dia = $dia; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function delete_periodos($cod,$dia){
		
		$sql = "DELETE FROM hor_periodos"; 
				
		$sql.= " WHERE per_codigo = $cod"; 	
		$sql.= " AND per_dia = $dia; "; 	
		
		return $sql;
	}
	
	
	function max_periodos($dia) {
		
        $sql = "SELECT max(per_codigo) as max ";
		$sql.= " FROM hor_periodos";
		$sql.= " WHERE per_dia = $dia; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

	
//---------- Horario ---------//
    function get_horario($codigo = '',$periodo = '',$dia = '',$hini = '',$hfin = '',$tipo = '',$pensum = '',$nivel = '',$grado = '', $seccion = '',$materia = '',$maestro = '',$aula = '') {
		
        $sql= "SELECT *, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo ";
		$sql.= " FROM hor_tipo_periodo, hor_periodos, hor_horario, academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_materia, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//-- relacion entre pensum, nivel, grado y seccion
		$sql.= " AND niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		//--- relacion entre pensum, nivel, grado y materia
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND mat_codigo = hor_materia";
		//--- relacion entre pensum, nivel, grado, seccion, materia y horario
		$sql.= " AND hor_pensum = sec_pensum";
		$sql.= " AND hor_nivel = sec_nivel";
		$sql.= " AND hor_grado = sec_grado";
		$sql.= " AND hor_seccion = sec_codigo";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($codigo)>0) { 
			  $sql.= " AND hor_codigo = $codigo"; 
		}
		if(strlen($periodo)>0) { 
			  $sql.= " AND hor_periodo = $periodo"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($hini)>0) { 
			  $sql.= " AND per_hini = '$hini'"; 
		}
		if(strlen($hfin)>0) { 
			  $sql.= " AND per_hfin = '$hfin'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND per_tipo = $tipo"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND hor_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND hor_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND hor_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND hor_seccion = $seccion"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND hor_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND hor_maestro = $maestro"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY hor_dia ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_horario($codigo = '',$periodo = '',$dia = '',$hini = '',$hfin = '',$tipo = '',$pensum = '',$nivel = '',$grado = '', $seccion = '',$materia = '',$maestro = '',$aula = '') {
		$barc = trim($barc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM hor_tipo_periodo, hor_periodos, hor_horario, academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_materia, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//-- relacion entre pensum, nivel, grado y seccion
		$sql.= " AND niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		//--- relacion entre pensum, nivel, grado y materia
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND mat_codigo = hor_materia";
		//--- relacion entre pensum, nivel, grado, seccion, materia y horario
		$sql.= " AND hor_pensum = sec_pensum";
		$sql.= " AND hor_nivel = sec_nivel";
		$sql.= " AND hor_grado = sec_grado";
		$sql.= " AND hor_seccion = sec_codigo";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($codigo)>0) { 
			  $sql.= " AND hor_codigo = $codigo"; 
		}
		if(strlen($periodo)>0) { 
			  $sql.= " AND hor_periodo = $periodo"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($hini)>0) { 
			  $sql.= " AND per_hini = '$hini'"; 
		}
		if(strlen($hfin)>0) { 
			  $sql.= " AND per_hfin = '$hfin'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND per_tipo = $tipo"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND hor_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND hor_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND hor_grado = $grado"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND hor_seccion = $seccion"; 
		}
		if(strlen($materia)>0) { 
			  $sql.= " AND hor_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND hor_maestro = $maestro"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_horario($codigo,$periodo,$dia,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula){
		//--
		$sql = "INSERT INTO hor_horario ";
		$sql.= " VALUES ($codigo,$periodo,$dia,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_horario($codigo,$periodo,$dia,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$aula){
		
		$sql = "UPDATE hor_horario SET ";
		$sql.= "hor_periodo = '$periodo',"; 
		$sql.= "hor_dia = '$dia',"; 
		$sql.= "hor_pensum = '$pensum',"; 
		$sql.= "hor_nivel = '$nivel',"; 
		$sql.= "hor_grado = '$grado',"; 
		$sql.= "hor_seccion = '$seccion',"; 
		$sql.= "hor_materia = '$materia',"; 
		$sql.= "hor_maestro = '$maestro',"; 
		$sql.= "hor_aula = '$aula'"; 
		
		$sql.= " WHERE hor_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_horario($codigo){
		
		$sql = "DELETE FROM hor_horario";
		$sql.= " WHERE hor_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function max_horario() {
		
        $sql = "SELECT max(hor_codigo) as max ";
		$sql.= " FROM hor_horario";
		$sql.= " WHERE 1 = 1 "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
///////////////////////---------- CURSOS LIBRES ---------/////////////////////
//---------- Tipo de Periodos de Cursos Libres---------//
    function get_tipo_periodo_cursos($cod,$curso,$min = '',$desc = ''){
		$desc = trim($desc);
		
        $sql= "SELECT * ";
		$sql.= " FROM hor_tipo_periodo_cursos, lms_curso";
		$sql.= " WHERE cur_codigo = tip_curso";
		$sql.= " AND cur_situacion = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND tip_codigo = $cod"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND tip_curso = $curso"; 
		}
		if(strlen($min)>0) { 
			  $sql.= " AND tip_minutos = $min"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND tip_descripcion like '%$desc%'"; 
		}
		$sql.= " ORDER BY tip_codigo ASC, tip_descripcion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_tipo_periodo_cursos($cod,$curso,$min = '',$desc = ''){
		$desc = trim($desc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM hor_tipo_periodo_cursos, lms_curso";
		$sql.= " WHERE cur_codigo = tip_curso";
		$sql.= " AND cur_situacion = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND tip_codigo = $cod"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND tip_curso = $curso"; 
		}
		if(strlen($min)>0) { 
			  $sql.= " AND tip_minutos = $min"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND tip_descripcion like '%$desc%'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_tipo_periodo_cursos($cod,$curso,$min,$desc){
		$desc = trim($desc);
		
		$sql = "INSERT INTO hor_tipo_periodo_cursos (tip_codigo,tip_curso,tip_minutos,tip_descripcion)";
		$sql.= " VALUES ($cod,'$curso','$min','$desc'); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_tipo_periodo_cursos($cod,$curso,$min,$desc){
		$desc = trim($desc);
		
		$sql = "UPDATE hor_tipo_periodo_cursos SET ";
		$sql.= "tip_minutos = '$min',"; 
		$sql.= "tip_descripcion = '$desc'"; 
		
		$sql.= " WHERE tip_codigo = $cod"; 	
		$sql.= " AND tip_curso = $curso;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function delete_tipo_periodo_cursos($cod,$curso){
		$sql = "DELETE FROM hor_tipo_periodo_cursos ";
		$sql.= " WHERE tip_codigo = $cod";
		$sql.= " AND tip_curso = $curso;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function max_tipo_periodo_cursos($curso) {
		
        $sql = "SELECT max(tip_codigo) as max ";
		$sql.= " FROM hor_tipo_periodo_cursos";
		$sql.= " WHERE tip_curso = $curso"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
//---------- Periodos de Cursos Libres ---------//
    function get_periodos_cursos($cod,$dia = '',$tipo = '',$curso = '',$hini = '',$hfin = '') {
		
		$sql= "SELECT * ";
		$sql.= " FROM hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso";
		$sql.= " WHERE cur_codigo = tip_curso";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		if(strlen($cod)>0) { 
			  $sql.= " AND per_codigo = $cod"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND per_dia = $dia"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND per_tipo = $tipo"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND per_curso = $curso"; 
		}
		if(strlen($hini)>0) { 
			  $sql.= " AND per_hini = '$hini'"; 
		}
		if(strlen($hfin)>0) { 
			  $sql.= " AND per_hfin = '$hfin'"; 
		}
		$sql.= " ORDER BY per_dia ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_periodos_cursos($cod,$dia = '',$tipo = '',$curso = '',$hini = '',$hfin = '') {
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso";
		$sql.= " WHERE cur_codigo = tip_curso";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		if(strlen($cod)>0) { 
			  $sql.= " AND per_codigo = $cod"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND per_dia = $dia"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND per_tipo = $tipo"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND per_curso = $curso"; 
		}
		if(strlen($hini)>0) { 
			  $sql.= " AND per_hini = '$hini'"; 
		}
		if(strlen($hfin)>0) { 
			  $sql.= " AND per_hfin = '$hfin'"; 
		}
		$sql.= " ORDER BY per_dia ASC, per_hini ASC, per_hfin ASC";
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_periodos_cursos($cod,$dia,$tipo,$curso,$hini,$hfin){
		
		$sql = "INSERT INTO hor_periodos_cursos";
		$sql.= " VALUES ($cod,$dia,$tipo,$curso,'$hini','$hfin'); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_periodos_cursos($cod,$dia,$tipo,$curso,$hini,$hfin){
		
		$sql = "UPDATE hor_periodos_cursos SET ";
		$sql.= "per_tipo = '$tipo',"; 
		$sql.= "per_curso = '$curso',"; 
		$sql.= "per_hini = '$hini',"; 
		$sql.= "per_hfin = '$hfin'"; 
		
		$sql.= " WHERE per_codigo = $cod "; 	
		$sql.= " AND per_dia = $dia; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function delete_periodos_cursos($cod,$dia){
		
		$sql = "DELETE FROM hor_periodos_cursos"; 
				
		$sql.= " WHERE per_codigo = $cod"; 	
		$sql.= " AND per_dia = $dia; "; 	
		
		return $sql;
	}
	
	
	function max_periodos_cursos($dia) {
		
        $sql = "SELECT max(per_codigo) as max ";
		$sql.= " FROM hor_periodos_cursos";
		$sql.= " WHERE per_dia = $dia; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

	
//---------- Horario de Cursos Libres ---------//
    function get_horario_cursos($codigo = '',$periodo = '',$dia = '',$hini = '',$hfin = '',$tipo = '',$curso = '',$maestro = '',$aula = '') {
		
        $sql= "SELECT *, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo ";
		$sql.= " FROM hor_tipo_periodo_cursos, hor_periodos_cursos, hor_horario_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE cur_codigo = tip_curso";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		if(strlen($codigo)>0) { 
			  $sql.= " AND hor_codigo = $codigo"; 
		}
		if(strlen($periodo)>0) { 
			  $sql.= " AND hor_periodo = $periodo"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($hini)>0) { 
			  $sql.= " AND per_hini = '$hini'"; 
		}
		if(strlen($hfin)>0) { 
			  $sql.= " AND per_hfin = '$hfin'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND per_tipo = $tipo"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND hor_maestro = $maestro"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY hor_dia ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_horario_cursos($codigo = '',$periodo = '',$dia = '',$hini = '',$hfin = '',$tipo = '',$curso = '',$maestro = '',$aula = '') {
		$barc = trim($barc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM hor_tipo_periodo_cursos, hor_periodos_cursos, hor_horario_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE cur_codigo = tip_curso";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		if(strlen($codigo)>0) { 
			  $sql.= " AND hor_codigo = $codigo"; 
		}
		if(strlen($periodo)>0) { 
			  $sql.= " AND hor_periodo = $periodo"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($hini)>0) { 
			  $sql.= " AND per_hini = '$hini'"; 
		}
		if(strlen($hfin)>0) { 
			  $sql.= " AND per_hfin = '$hfin'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND per_tipo = $tipo"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND hor_maestro = $maestro"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_horario_cursos($codigo,$periodo,$dia,$curso,$maestro,$aula,$cupo){
		//--
		$sql = "INSERT INTO hor_horario_cursos ";
		$sql.= " VALUES ($codigo,$periodo,$dia,$curso,$maestro,$aula,$cupo); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_horario_cursos($codigo,$periodo,$dia,$curso,$maestro,$aula,$cupo){
		
		$sql = "UPDATE hor_horario_cursos SET ";
		$sql.= "hor_periodo = '$periodo',"; 
		$sql.= "hor_dia = '$dia',"; 
		$sql.= "hor_curso = '$curso',"; 
		$sql.= "hor_maestro = '$maestro',"; 
		$sql.= "hor_aula = '$aula',"; 
		$sql.= "hor_cupo_max = '$cupo'"; 
		
		$sql.= " WHERE hor_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_horario_cursos($codigo){
		
		$sql = "DELETE FROM hor_horario_cursos";
		$sql.= " WHERE hor_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function max_horario_cursos() {
		
        $sql = "SELECT max(hor_codigo) as max ";
		$sql.= " FROM hor_horario_cursos";
		$sql.= " WHERE 1 = 1 "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
