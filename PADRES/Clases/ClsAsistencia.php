<?php
require_once ("ClsConex.php");

class ClsAsistencia extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */

//---------- ASISTENCIA ACADEMICA ---------//
//---------- Horarios y Asistencia ---------//
    function get_horario_asistencia_alumno($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '',$dia = '',$pensum = '',$nivel = '',$grado = '', $seccion = '',$materia = '',$aula = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM app_asistencia, hor_horario, hor_periodos, hor_tipo_periodo, academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_materia, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
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
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = $tipo_usuario";
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
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
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
	
	
	function count_horario_asistencia_alumno($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '',$dia = '',$pensum = '',$nivel = '',$grado = '', $seccion = '',$materia = '',$aula = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_asistencia, hor_horario, hor_periodos, hor_tipo_periodo, academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_materia, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
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
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = $tipo_usuario";
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
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
	
	
	function get_horario_asistencia_usuario($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '',$dia = '',$pensum = '',$nivel = '',$grado = '', $seccion = '',$materia = '',$aula = '') {
		
        $sql= "SELECT DISTINCT(asi_usuario), asi_tipo_usuario, pen_codigo, niv_descripcion, gra_descripcion, sec_descripcion, mae_cui, mae_nombre, mae_apellido, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo ";
		$sql.= " FROM app_asistencia, hor_horario, hor_periodos, hor_tipo_periodo, academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_materia, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
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
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = $tipo_usuario";
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
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
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function get_horario_asistencia_maestro($horario = '',$fecha = '',$alumno = '',$maestro = '',$dia = '',$pensum = '',$nivel = '',$grado = '', $seccion = '',$materia = '',$aula = '') {
		
        $sql= "SELECT DISTINCT(hor_codigo), asi_tipo_usuario, pen_codigo, niv_descripcion, gra_descripcion, sec_descripcion, mae_cui, mae_nombre, mae_apellido, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo, ";
		$sql.= "tip_minutos, per_hini, per_hfin, hor_dia, mat_codigo, mat_descripcion, aul_codigo, aul_descripcion, asi_horario";
		$sql.= " FROM app_asistencia, hor_horario, hor_periodos, hor_tipo_periodo, academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_materia, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
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
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND hor_maestro = $maestro"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
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
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_horario_asistencia_seccion($horario = '',$fecha = '',$pensum = '',$nivel = '',$grado = '', $seccion = '') {
		
        $sql= "SELECT DISTINCT(sec_codigo), asi_horario, asi_fecha, pen_codigo, niv_descripcion, gra_descripcion, sec_descripcion, mae_cui, mae_nombre, mae_apellido, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo, ";
		$sql.= "tip_minutos, per_hini, per_hfin, hor_dia, mat_codigo, mat_descripcion, aul_codigo, aul_descripcion";
		$sql.= " FROM app_asistencia, hor_horario, hor_periodos, hor_tipo_periodo, academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_materia, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
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
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
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
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_asistencia($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM app_asistencia, app_alumnos";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_alumno = alu_cui";
		if(strlen($horario)>0) { 
			  $sql.= " AND asi_horario = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = $tipo_usuario";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, asi_horario ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_asistencia($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_asistencia, app_alumnos";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_alumno = alu_cui";
		if(strlen($horario)>0) { 
			  $sql.= " AND asi_horario = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = $tipo_usuario";
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;

	}
	
		
	function insert_asistencia($horario,$fecha,$alumno,$asistencia){
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$tipo_usuario = $_SESSION['tipo_usuario'];
		$tipo_usuario = ($tipo_usuario != "")?$tipo_usuario:5;
		$usuario = $_SESSION['tipo_codigo'];
		$usuario = ($usuario != "")?$usuario:0;
		//--
		$sql = "INSERT INTO app_asistencia ";
		$sql.= " VALUES ($horario,'$fecha','$alumno','$fsis','$usuario',$tipo_usuario,$asistencia); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_asistencia($horario,$fecha,$alumno,$asistencia){
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$tipo_usuario = $_SESSION['tipo_usuario'];
		$tipo_usuario = ($tipo_usuario != "")?$tipo_usuario:5;
		$usuario = $_SESSION['tipo_codigo'];
		$usuario = ($usuario != "")?$usuario:0;
		//--
		$sql = "UPDATE app_asistencia SET ";
		$sql.= "asi_usuario = '$usuario',"; 
		$sql.= "asi_tipo_usuario = '$tipo_usuario',"; 
		$sql.= "asi_asistencia = '$asistencia',"; 
		$sql.= "asi_fecha_registro = '$fsis'"; 
		
		$sql.= " WHERE asi_horario = $horario "; 	
		$sql.= " AND asi_fecha = '$fecha'"; 	
		$sql.= " AND asi_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_asistencia($horario,$fecha){
		$fecha = $this->regresa_fecha($fecha);
		//--
		$sql = "DELETE FROM app_asistencia";
		$sql.= " WHERE asi_horario = $horario "; 	
		$sql.= " AND asi_fecha = '$fecha';"; 	
		
		//echo $sql;
		return $sql;
	}
	
	//////////////////////////// ASUENCIAS /////////////////////////////////////
	
	
	function get_ausencia_alumno($horario = '',$fecha = '',$alumno = '',$mes = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM app_asistencia, hor_horario, hor_periodos, hor_tipo_periodo, academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_materia, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_pensum = tip_pensum";
		$sql.= " AND per_nivel = tip_nivel";
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
		$sql.= " AND asi_asistencia = 0";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($mes)>0) {
			$anio = date("Y");
			$sql.= " AND YEAR(asi_fecha) = $anio";
			$sql.= " AND MONTH(asi_fecha) = $mes"; 
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
	
	
	function count_ausencia_alumno($horario = '',$fecha = '',$alumno = '',$mes = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_asistencia, app_alumnos";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_alumno = alu_cui";
		$sql.= " AND asi_asistencia = 0";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND asi_horario = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($mes)>0) {
			$anio = date("Y");
			$sql.= " AND YEAR(asi_fecha) = $anio";
			$sql.= " AND MONTH(asi_fecha) = $mes"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;

	}
	
//---------- ASISTENCIA CURSOS LIBRES ---------//
//---------- Horarios y Asistencia ---------//
    function get_horario_asistencia_alumno_cursos($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '',$dia = '',$curso = '',$aula = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM app_asistencia_cursos, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = '$tipo_usuario'";
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_horario_asistencia_alumno_cursos($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '',$dia = '',$curso = '',$aula = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_asistencia_cursos, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = '$tipo_usuario'";
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
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
	
	
	function get_horario_asistencia_usuario_cursos($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '',$dia = '',$curso = '',$aula = '') {
		
        $sql= "SELECT DISTINCT(asi_usuario), asi_tipo_usuario, cur_codigo, cur_nombre, mae_cui, mae_nombre, mae_apellido, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo ";
		$sql.= " FROM app_asistencia_cursos, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = '$tipo_usuario'";
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function get_horario_asistencia_maestro_cursos($horario = '',$fecha = '',$alumno = '',$maestro = '',$dia = '',$curso = '',$aula = '') {
		
        $sql= "SELECT DISTINCT(hor_codigo), asi_tipo_usuario, asi_horario, cur_codigo, cur_nombre, mae_cui, mae_nombre, mae_apellido, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo, ";
		$sql.= "tip_minutos, per_hini, per_hfin, hor_dia, aul_codigo, aul_descripcion";
		$sql.= " FROM app_asistencia_cursos, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND hor_maestro = '$maestro'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = '$tipo_usuario'";
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_horario_asistencia_curso($horario = '',$fecha = '',$curso = '') {
		
        $sql= "SELECT DISTINCT(cur_codigo), asi_horario, asi_fecha, cur_codigo, cur_nombre, mae_cui, mae_nombre, mae_apellido, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo, ";
		$sql.= "tip_minutos, per_hini, per_hfin, hor_dia, aul_codigo, aul_descripcion";
		$sql.= " FROM app_asistencia_cursos, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_asistencia_cursos($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM app_asistencia_cursos, app_alumnos";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_alumno = alu_cui";
		if(strlen($horario)>0) { 
			  $sql.= " AND asi_horario = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = $tipo_usuario";
		}
		
		$sql.= " ORDER BY asi_fecha ASC, asi_horario ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_asistencia_cursos($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_asistencia_cursos, app_alumnos";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_alumno = alu_cui";
		if(strlen($horario)>0) { 
			  $sql.= " AND asi_horario = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND asi_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND asi_tipo_usuario = $tipo_usuario";
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;

	}
	
		
	function insert_asistencia_cursos($horario,$fecha,$alumno,$asistencia){
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$tipo_usuario = $_SESSION['tipo_usuario'];
		$usuario = $_SESSION['tipo_codigo'];
		//--
		$sql = "INSERT INTO app_asistencia_cursos ";
		$sql.= " VALUES ($horario,'$fecha','$alumno','$fsis','$usuario',$tipo_usuario,$asistencia); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_asistencia_cursos($horario,$fecha,$alumno,$asistencia){
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$tipo_usuario = $_SESSION['tipo_usuario'];
		$usuario = $_SESSION['tipo_codigo'];
		//--
		$sql = "UPDATE app_asistencia_cursos SET ";
		$sql.= "asi_usuario = '$usuario',"; 
		$sql.= "asi_tipo_usuario = '$tipo_usuario',"; 
		$sql.= "asi_asistencia = '$asistencia',"; 
		$sql.= "asi_fecha_registro = '$fsis'"; 
		
		$sql.= " WHERE asi_horario = $horario "; 	
		$sql.= " AND asi_fecha = '$fecha'"; 	
		$sql.= " AND asi_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_asistencia_cursos($horario,$fecha){
		$fecha = $this->regresa_fecha($fecha);
		//--
		$sql = "DELETE FROM app_asistencia_cursos";
		$sql.= " WHERE asi_horario = $horario "; 	
		$sql.= " AND asi_fecha = '$fecha';"; 	
		
		//echo $sql;
		return $sql;
	}
	
	//////////////////////////// ASUENCIAS /////////////////////////////////////
	
	
	function get_ausencia_alumno_cursos($horario = '',$fecha = '',$alumno = '',$mes = '',$curso = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM app_asistencia_cursos, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		$sql.= " AND asi_asistencia = 0";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($mes)>0) {
			$anio = date("Y");
			$sql.= " AND YEAR(asi_fecha) = $anio";
			$sql.= " AND MONTH(asi_fecha) = $mes"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
		}
		
		$sql.= " ORDER BY asi_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_ausencia_alumno_cursos($horario = '',$fecha = '',$alumno = '',$mes = '',$curso = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_asistencia_cursos, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE asi_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		$sql.= " AND asi_asistencia = 0";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND asi_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND asi_alumno = '$alumno'"; 
		}
		if(strlen($mes)>0) {
			$anio = date("Y");
			$sql.= " AND YEAR(asi_fecha) = $anio";
			$sql.= " AND MONTH(asi_fecha) = $mes"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso IN($curso)"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;

	}

	
//---------- RESERVA DE ASISTENCIA CURSOS LIBRES ---------//
//---------- Reserva de Horarios y Asistencia ---------//
    function get_reserva_horario_asistencia_alumno($horario = '',$fecha = '',$alumno = '',$dia = '',$curso = '',$aula = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM app_asistencia_cursos_reserva, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_alumnos, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE reserva_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND reserva_alumno = alu_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND reserva_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND reserva_alumno = '$alumno'"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso = $curso"; 
		}
		if(strlen($aula)>0) { 
			  $sql.= " AND aul_codigo = $aula";
		}
		
		$sql.= " ORDER BY reserva_fecha ASC, per_hini ASC, per_hfin ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_reserva_horario_asistencia_alumno($horario = '',$fecha = '',$alumno = '',$dia = '',$curso = '',$aula = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_asistencia_cursos_reserva, hor_horario_cursos, hor_periodos_cursos, hor_tipo_periodo_cursos, lms_curso, app_maestros, lms_aula";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE reserva_horario = hor_codigo";
		$sql.= " AND tip_curso = cur_codigo";
		$sql.= " AND per_tipo = tip_codigo";
		$sql.= " AND per_curso = tip_curso";
		$sql.= " AND hor_periodo = per_codigo";
		$sql.= " AND hor_dia = per_dia";
		//--- relacion con maestro
		$sql.= " AND hor_maestro = mae_cui";
		//--- relacion con horario y aula
		$sql.= " AND hor_aula = aul_codigo";
		
		if(strlen($horario)>0) { 
			  $sql.= " AND hor_codigo = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND reserva_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND reserva_alumno = '$alumno'"; 
		}
		if(strlen($dia)>0) { 
			  $sql.= " AND hor_dia = $dia"; 
		}
		if(strlen($curso)>0) { 
			  $sql.= " AND hor_curso = $curso"; 
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
	

	function get_reserva_asistencia($horario = '',$fecha = '',$alumno = '',$asistencia = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM app_asistencia_cursos_reserva, app_alumnos";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE reserva_alumno = alu_cui";
		if(strlen($horario)>0) { 
			  $sql.= " AND reserva_horario = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND reserva_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND reserva_alumno = '$alumno'"; 
		}
		if(strlen($asistencia)>0) { 
			  $sql.= " AND reserva_asistencia = '$asistencia'"; 
		}
		
		$sql.= " ORDER BY reserva_fecha ASC, reserva_horario ASC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_reserva_asistencia($horario = '',$fecha = '',$alumno = '',$usuario = '',$tipo_usuario = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_asistencia_cursos_reserva, app_alumnos";
		//--- relacion entre tipo, periodos y horario
		$sql.= " WHERE reserva_alumno = alu_cui";
		if(strlen($horario)>0) { 
			  $sql.= " AND reserva_horario = $horario"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND reserva_fecha = '$fecha'"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND reserva_alumno = '$alumno'"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND reserva_usuario = '$usuario'"; 
		}
		if(strlen($tipo_usuario)>0) { 
			  $sql.= " AND reserva_tipo_usuario = $tipo_usuario";
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;

	}
	
		
	function insert_reserva_asistencia($horario,$fecha,$alumno,$asistencia){
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$tipo_usuario = $_SESSION['tipo_usuario'];
		$usuario = $_SESSION['tipo_codigo'];
		//--
		$sql = "INSERT INTO app_asistencia_cursos_reserva ";
		$sql.= " VALUES ($horario,'$fecha','$alumno','$fsis','$asistencia'); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_reserva_asistencia($horario,$fecha,$alumno,$asistencia){
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$tipo_usuario = $_SESSION['tipo_usuario'];
		$usuario = $_SESSION['tipo_codigo'];
		//--
		$sql = "UPDATE app_asistencia_cursos_reserva SET ";
		$sql.= "reserva_asistencia = '$asistencia',"; 
		$sql.= "reserva_fecha_registro = '$fsis'"; 
		
		$sql.= " WHERE reserva_horario = '$horario' "; 	
		$sql.= " AND reserva_fecha = '$fecha'"; 	
		$sql.= " AND reserva_alumno = '$alumno'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function delete_reserva_asistencia($horario,$fecha){
		$fecha = $this->regresa_fecha($fecha);
		//--
		$sql = "DELETE FROM app_asistencia_cursos_reserva";
		$sql.= " WHERE reserva_horario = '$horario' "; 	
		$sql.= " AND reserva_fecha = '$fecha'"; 	
		$sql.= " AND reserva_alumno = '$alumno'; "; 	
		
		//echo $sql;
		return $sql;
	}

	
}	
?>
