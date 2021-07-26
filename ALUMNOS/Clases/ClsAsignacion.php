<?php
require_once ("ClsConex.php");

class ClsAsignacion extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
	
	function __construct(){
		$this->anio = date("Y");
        if($_SESSION["pensum"] == "") {
            require_once("ClsPensum.php");
            $ClsPen = new ClsPensum();
            $this->pensum = $ClsPen->get_pensum_activo();
        }else{
            $this->pensum = $_SESSION["pensum"];
        }
	}	
   
//////////////////// Alumno - Padres //////////////////////////
	function asignacion_alumno_padre($padre,$alumno){
		///--
		$fec = date("Y-m-d H:i:s");
		$sql = "INSERT INTO app_padre_alumno";
		$sql.= " VALUES ('$padre','$alumno','$fec');";
		//echo $sql;
		return $sql;
	}

	function desasignacion_alumno_padre($padre,$alumno){
	    $sql = "DELETE FROM app_padre_alumno";
		$sql.= " WHERE pa_padre = '$padre'";
		$sql.= " AND pa_alumno = '$alumno';";  	
		//echo $sql;
		return $sql;
	}
	
	function desasignacion_alumno_general($alumno){
	    $sql = "DELETE FROM app_padre_alumno";
		$sql.= " WHERE pa_alumno = '$alumno';";  	
		//echo $sql;
		return $sql;
	}
	
	function get_alumno_padre($padre,$alumno) {
		$pensum = $this->pensum;
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno WHERE graa_pensum = gra_pensum AND graa_nivel = gra_nivel AND graa_grado = gra_codigo AND graa_alumno = alu_cui AND graa_pensum = $pensum ORDER BY graa_grado LIMIT 0 , 1) as alu_grado,";
		$sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno WHERE seca_pensum = sec_pensum AND seca_nivel = sec_nivel AND seca_grado = sec_grado AND seca_seccion = sec_codigo AND seca_alumno = alu_cui AND seca_pensum = $pensum ORDER BY seca_seccion LIMIT 0 , 1) as alu_seccion, ";      
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto";
		$sql.= " FROM app_padre_alumno,app_padres,app_alumnos";
		$sql.= " WHERE pa_padre = pad_cui";
		$sql.= " AND pa_alumno = alu_cui";
		$sql.= " AND alu_situacion = 1";
		if(strlen($padre)>0) { 
			  $sql.= " AND pa_padre = '$padre'";
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND pa_alumno = '$alumno'";
		}
		$sql.= " ORDER BY alu_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_hermanos($alumno, $padres) {
		$pensum = $this->pensum;
		
	    $sql.= "SELECT alu_cui,alu_tipo_cui,alu_codigo_interno,alu_codigo_mineduc,alu_nombre,alu_apellido,alu_fecha_nacimiento,";
		$sql.= "alu_nacionalidad,alu_religion,alu_idioma,alu_genero,alu_tipo_sangre,alu_alergico_a,alu_emergencia,alu_emergencia_telefono,";
		$sql.= "alu_nit, alu_cliente_nombre, alu_cliente_direccion,alu_mail,alu_recoge,alu_redes_sociales,alu_fec_registro,alu_situacion,";
		$sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno WHERE graa_pensum = gra_pensum AND graa_nivel = gra_nivel AND graa_grado = gra_codigo AND graa_alumno = alu_cui AND graa_pensum = $pensum ORDER BY graa_grado LIMIT 0 , 1) as alu_grado,";
		$sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno WHERE seca_pensum = sec_pensum AND seca_nivel = sec_nivel AND seca_grado = sec_grado AND seca_seccion = sec_codigo AND seca_alumno = alu_cui AND seca_pensum = $pensum ORDER BY seca_seccion LIMIT 0 , 1) as alu_seccion, ";      
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto";
		$sql.= " FROM app_padre_alumno,app_padres,app_alumnos";
		$sql.= " WHERE pa_padre = pad_cui";
		$sql.= " AND pa_alumno = alu_cui";
		$sql.= " AND alu_situacion = 1";
		$sql.= " AND pa_padre IN($padres)";
		$sql.= " AND pa_alumno != '$alumno'";
		$sql.= " GROUP BY alu_cui";
		$sql.= " ORDER BY alu_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function get_familia($padre, $alumnos) {
		$pensum = $this->pensum;
		
	    $sql.= "SELECT pad_cui,pad_tipo_dpi,pad_nombre,pad_apellido,pad_fec_nac,pad_parentesco,pad_estado_civil,pad_nacionalidad,pad_telefono,pad_celular,pad_mail";
		$sql.= " FROM app_padre_alumno,app_padres,app_alumnos";
		$sql.= " WHERE pa_padre = pad_cui";
		$sql.= " AND pa_alumno = alu_cui";
		$sql.= " AND alu_situacion = 1";
		$sql.= " AND pa_alumno IN($alumnos)";
		$sql.= " AND pa_padre != '$padre'";
		$sql.= " GROUP BY pad_cui";
		$sql.= " ORDER BY pad_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	

//////////////////// Alumno - Maestro //////////////////////////
	function get_alumno_maestro($maestro,$alumno){
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM app_grupo,app_grupo_maestro,app_maestros,app_grupo_alumno,app_alumnos";
		$sql.= " WHERE mg_grupo = gru_codigo";
		$sql.= " AND mg_maestro = mae_cui";
		$sql.= " AND ag_grupo = gru_codigo";
		$sql.= " AND ag_alumno = alu_cui";
		$sql.= " AND mg_grupo = ag_grupo";
		if(strlen($maestro)>0) { 
			  $sql.= " AND mg_maestro = '$maestro'";
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND ag_alumno = '$alumno'";
		}
		$sql.= " ORDER BY mae_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

//////////////////// Alumno - Otros Usuarios //////////////////////////	 
	function get_alumno_otros_usuarios($usuario,$alumno){
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM app_grupo,app_grupo_otros,app_otros_usuarios,app_grupo_alumno,app_alumnos";
		$sql.= " WHERE og_grupo = gru_codigo";
		$sql.= " AND og_otros_usuarios = otro_cui";
		$sql.= " AND ag_grupo = gru_codigo";
		$sql.= " AND ag_alumno = alu_cui";
		$sql.= " AND og_grupo = ag_grupo";
		if(strlen($usuario)>0) { 
			  $sql.= " AND og_otros_usuarios = '$usuario'";
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND ag_alumno = '$alumno'";
		}
		$sql.= " ORDER BY otro_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	 } 
	

//////////////////// Alumno - Monitores de Buses //////////////////////////	 
	function get_alumno_monitores_buses($usuario,$alumno){
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM app_grupo,app_grupo_monitores_buses,app_monitores_buses,app_grupo_alumno,app_alumnos";
		$sql.= " WHERE omb_grupo = gru_codigo";
		$sql.= " AND omb_monitores_buses = mbus_cui";
		$sql.= " AND ag_grupo = gru_codigo";
		$sql.= " AND ag_alumno = alu_cui";
		$sql.= " AND omb_grupo = ag_grupo";
		if(strlen($usuario)>0) { 
			  $sql.= " AND omb_monitores_buses = '$usuario'";
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND ag_alumno = '$alumno'";
		}
		$sql.= " ORDER BY mbus_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	 } 
		
//////////////////// Alumno - Grupo //////////////////////////
	
	function get_alumno_grupo($grupo,$alumno,$situacion) {
		
		$sql= "SELECT *, ";
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = alu_cui) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(pad_nombre),' ',TRIM(pad_apellido)) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_padre,";
		$sql.= " (SELECT TRIM(pad_telefono) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_telefono,";
		$sql.= " (SELECT TRIM(pad_mail) FROM app_padres,app_padre_alumno WHERE pa_padre = pad_cui AND pa_alumno = alu_cui ORDER BY pad_cui ASC LIMIT 0 , 1) as alu_mail_padre";
		$sql.= " FROM app_area,app_segmento,app_grupo,app_grupo_alumno,app_alumnos";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		$sql.= " AND ag_grupo = gru_codigo";
		$sql.= " AND ag_alumno = alu_cui";		
		if(strlen($grupo)>0) { 
			$sql.= " AND ag_grupo = $grupo";
		}
		if(strlen($alumno)>0) { 
			$sql.= " AND ag_alumno = '$alumno'";
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND ag_situacion = $situacion";
		}
		$sql.= " ORDER BY alu_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_not_alumno_grupo($area,$grupo) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_grupo";
		$sql.= " WHERE 1 = 1";
		if(strlen($area)>0) { 
		    $sql.= " AND gru_area = $area";
		}
		if(strlen($grupo)>0) { 
		    $sql.= " AND gru_codigo NOT IN($grupo)";
		}
		$sql.= " ORDER BY gru_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

	function asignacion_alumno_grupo($grupo,$alumno){
		///--
		$fec = date("Y-m-d H:i:s");
		$sql = "INSERT INTO app_grupo_alumno";
		$sql.= " VALUES ('$grupo','$alumno','$fec',1);";
		//echo $sql;
		return $sql;
	}

	function desasignacion_alumno_grupo($grupo,$alumno){
	    $sql = "DELETE FROM app_grupo_alumno";
		$sql.= " WHERE ag_grupo = $grupo";
		$sql.= " AND ag_alumno = '$alumno';";  	
		//echo $sql;
		return $sql;
	}
	
	function anulacion_alumno_grupo($grupo,$alumno){
	    $sql = "UPDATE app_grupo_alumno SET ag_situacion = 0";
		$sql.= " WHERE ag_grupo = '$grupo';";
		//echo $sql;
		return $sql;
	}
	
//////////////////// Maestro - Grupo //////////////////////////
	  function get_maestro_grupo($grupo,$maestro,$situacion) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_grupo,app_grupo_maestro,app_maestros";
		$sql.= " WHERE mg_grupo = gru_codigo";
		$sql.= " AND mg_maestro = mae_cui";
		if(strlen($grupo)>0) { 
			  $sql.= " AND mg_grupo = $grupo";
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND mg_maestro = '$maestro'";
		}
		if(strlen($situacion)>0) { 
			  $sql.= " AND mg_situacion = $situacion";
		}
		$sql.= " ORDER BY mae_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	 }
	
	function get_not_maestro_grupo($area,$grupo) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_grupo";
		$sql.= " WHERE 1 = 1";
		if(strlen($area)>0) { 
		    $sql.= " AND gru_area = $area";
		}
		if(strlen($grupo)>0) { 
		    $sql.= " AND gru_codigo NOT IN($grupo)";
		}
		$sql.= " ORDER BY gru_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

	function asignacion_maestro_grupo($grupo,$maestro){
		///--
		$fec = date("Y-m-d H:i:s");
		$sql = "INSERT INTO app_grupo_maestro";
		$sql.= " VALUES ('$grupo','$maestro','$fec',1);";
		//echo $sql;
		return $sql;
	}

	function desasignacion_maestro_grupo($grupo,$maestro){
	    $sql = "DELETE FROM app_grupo_maestro";
		$sql.= " WHERE mg_grupo = $grupo";
		$sql.= " AND mg_maestro = '$maestro';";  	
		//echo $sql;
		return $sql;
	}
	
	function anulacion_maestro_grupo($grupo,$maestro){
	    $sql = "UPDATE app_grupo_maestro SET mg_situacion = 0";
		$sql.= " WHERE mg_grupo = $grupo;";
		//echo $sql;
		return $sql;
	}
	
	function desasignacion_completa_maestro_grupo($maestro){
	    $sql = "DELETE FROM app_grupo_maestro";
		$sql.= " WHERE mg_maestro = '$maestro';";  	
		//echo $sql;
		return $sql;
	}
	
//////////////////// Otros Usuarios - Grupo //////////////////////////

	  function get_usuario_grupo($grupo,$usuario,$situacion) {
		
		$sql= "SELECT * ";
		$sql.= " FROM app_grupo,app_grupo_otros,app_otros_usuarios";
		$sql.= " WHERE og_grupo = gru_codigo";
		$sql.= " AND og_otros_usuarios = otro_cui";
		if(strlen($grupo)>0) { 
			  $sql.= " AND og_grupo = $grupo";
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND og_otros_usuarios = '$usuario'";
		}
		if(strlen($situacion)>0) { 
			  $sql.= " AND og_situacion = $situacion";
		}
		$sql.= " ORDER BY otro_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	 }
	
	function get_not_usuario_grupo($area,$grupo) {
		
	        $sql= "SELECT * ";
		$sql.= " FROM app_grupo";
		$sql.= " WHERE 1 = 1";
		if(strlen($area)>0) { 
		    $sql.= " AND gru_area = $area";
		}
		if(strlen($grupo)>0) { 
		    $sql.= " AND gru_codigo NOT IN($grupo)";
		}
		$sql.= " ORDER BY gru_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	  
	function asignacion_otro_grupo($grupo,$otro){
		///--
		$fec = date("Y-m-d H:i:s");
		$sql = "INSERT INTO app_grupo_otros";
		$sql.= " VALUES ($grupo,$otro,'$fec',1);";
		//echo $sql;
		return $sql;
	}

	function desasignacion_otro_grupo($grupo,$otro){
	    $sql = "DELETE FROM app_grupo_otros";
		$sql.= " WHERE og_grupo = $grupo";
		$sql.= " AND og_otros_usuarios = '$otro';";  	
		//echo $sql;
		return $sql;
	}
	
	function anulacion_otro_grupo($grupo,$otro){
	    $sql = "UPDATE app_grupo_otros SET og_situacion = 0";
		$sql.= " WHERE og_grupo = $grupo;";
		//echo $sql;
		return $sql;
	}
	
	
	
//////////////////// Monitor de Bus - Grupo //////////////////////////

	  function get_monitor_bus_grupo($grupo,$monitor,$situacion) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_grupo,app_grupo_monitores_buses,app_monitores_buses";
		$sql.= " WHERE omb_grupo = gru_codigo";
		$sql.= " AND omb_monitores_buses = mbus_cui";
		if(strlen($grupo)>0) { 
			  $sql.= " AND omb_grupo = $grupo";
		}
		if(strlen($monitor)>0) { 
			  $sql.= " AND omb_monitores_buses = '$monitor'";
		}
		if(strlen($situacion)>0) { 
			  $sql.= " AND omb_situacion = $situacion";
		}
		$sql.= " ORDER BY mbus_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	 }
	
	function get_not_monitor_bus_grupo($area,$grupo) {
		
	        $sql= "SELECT * ";
		$sql.= " FROM app_grupo";
		$sql.= " WHERE 1 = 1";
		if(strlen($area)>0) { 
		    $sql.= " AND gru_area = $area";
		}
		if(strlen($grupo)>0) { 
		    $sql.= " AND gru_codigo NOT IN($grupo)";
		}
		$sql.= " ORDER BY gru_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	  
	function asignacion_monitor_bus_grupo($grupo,$monitor){
		///--
		$fec = date("Y-m-d H:i:s");
		$sql = "INSERT INTO app_grupo_monitores_buses";
		$sql.= " VALUES ($grupo,'$monitor','$fec',1);";
		//echo $sql;
		return $sql;
	}

	function desasignacion_monitor_bus_grupo($grupo,$monitor){
	        $sql = "DELETE FROM app_grupo_monitores_buses";
		$sql.= " WHERE omb_grupo = $grupo";
		$sql.= " AND omb_monitores_buses = '$monitor';";  	
		//echo $sql;
		return $sql;
	}
	
	function anulacion_monitor_bus_grupo($grupo,$monitor){
	    $sql = "UPDATE app_grupo_monitores_buses SET omb_situacion = 0";
		$sql.= " WHERE omb_grupo = $grupo;";
		//echo $sql;
		return $sql;
	}	
	
}	
?>
