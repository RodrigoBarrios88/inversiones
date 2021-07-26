<?php
require_once ("ClsConex.php");

class ClsInformacion extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  INFORMACION //////////////////////////////////////
  
    function get_informacion($codigo,$target = '',$tipo = '',$imagen = '',$fecha = '',$fini = '',$ffin = '') {
		$nom = trim($nom);
		$target = trim($target);
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_informacion";
		$sql.= " WHERE inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
		
		if(strlen($codigo)>0) { 
			$sql.= " AND inf_codigo IN($codigo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = $tipo"; 
		}
		if($imagen=='TRUE' || $imagen=='true') { 
			$sql.= " AND inf_imagen <> ''"; 
		}
        if (strlen($fecha)>0) {
            $fecha = $this->regresa_fecha($fecha);
            $sql.= " AND inf_fecha_inicio BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
        }
        if (strlen($fini)>0 && strlen($ffin)>0) {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND inf_fecha_inicio BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
        }
		$sql.= " ORDER BY inf_fecha_inicio ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
    
    
    function get_informacion_push_user($codigo,$target = '',$tipo = '',$imagen = '',$fecha = '',$fini = '',$ffin = '') {
		$nom = trim($nom);
		$target = trim($target);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
	    $sql = "SELECT user_id, device_id, device_token, device_type, certificate_type, status, created_at, updated_at,";
        $sql.= "inf_codigo, inf_nombre, inf_descripcion, inf_fecha_inicio, inf_fecha_fin, inf_fecha_registro, inf_target, inf_tipo_target, inf_imagen, inf_link, inf_situacion ";
        $sql.= " FROM app_informacion, push_user";
		$sql.= " WHERE inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
		
		if(strlen($codigo)>0) { 
			$sql.= " AND inf_codigo = $codigo"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = $tipo"; 
		}
		if($imagen=='TRUE' || $imagen=='true') { 
			$sql.= " AND inf_imagen <> ''"; 
		}
        if (strlen($fecha)>0) {
            $fecha = $this->regresa_fecha($fecha);
            $sql.= " AND inf_fecha_inicio BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
        }
        if (strlen($fini)>0 && strlen($ffin)>0) {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND inf_fecha_inicio BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
        }
		
		$sql.= " GROUP BY device_id";
		$sql.= " ORDER BY inf_fecha_inicio ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_informacion($codigo,$target = '',$tipo = '',$imagen = '',$fecha = '',$fini = '',$ffin = '') {
		$nom = trim($nom);
		$target = trim($target);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_informacion";
		$sql.= " WHERE inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
		
		if(strlen($codigo)>0) { 
			$sql.= " AND inf_codigo = $codigo"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = $tipo"; 
		}
		if($imagen=='TRUE' || $imagen=='true') { 
			$sql.= " AND inf_imagen <> ''"; 
		}
		if ($fecha != "" && $fecha != "") {
            $fecha = $this->regresa_fecha($fecha);
            $sql.= " AND inf_fecha_inicio BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
        }
        if (strlen($fini)>0 && strlen($ffin)>0) {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND inf_fecha_inicio BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
        }
        
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
    
    
    function get_codigos_informacion_todos(){
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT inf_codigo as codigo";
		$sql.= " FROM app_informacion";
		$sql.= " WHERE inf_situacion = 1";
		$sql.= " AND inf_tipo_target = 0";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
        $sql.= " ORDER BY inf_fecha_inicio DESC";
        //echo $sql."<br>";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			$codigos = '';
			foreach($result as $row){
				$codigos.= $row['codigo'].',';
			}
			$codigos = substr($codigos, 0, -1);
		}else{
			$codigos = '';
		}
		//echo $codigos.'<br>';
		return $codigos;
    }
	
	
	function insert_informacion($codigo,$nom,$desc,$fini,$ffin,$target,$tipo,$imagen,$link){
		$nom = trim($nom);
		$desc = trim($desc);
		$target = trim($target);
		$fsist = date("Y-m-d H:i:s");
		$fini = $this->regresa_fechaHora($fini);
		$ffin = $this->regresa_fechaHora($ffin);
		
		$sql = "INSERT INTO app_informacion";
		$sql.= " VALUES ($codigo,'$nom','$desc','$fini','$ffin','$fsist','$target',$tipo,'$imagen','$link',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_informacion($codigo,$nom,$desc,$fini,$ffin,$link){
		$nom = trim($nom);
		$desc = trim($desc);
		$target = trim($target);
		$fsist = date("Y-m-d H:i:s");
		$fini = $this->regresa_fechaHora($fini);
		$ffin = $this->regresa_fechaHora($ffin);
		
		$sql = "UPDATE app_informacion SET ";
		$sql.= "inf_nombre = '$nom',"; 
		$sql.= "inf_descripcion = '$desc',"; 		
		$sql.= "inf_fecha_inicio = '$fini',"; 
		$sql.= "inf_fecha_fin = '$ffin',"; 		
		$sql.= "inf_fecha_registro = '$fsist',"; 		
		$sql.= "inf_link = '$link'";
		
		$sql.= " WHERE inf_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
    
    
    function modifica_imagen($codigo,$imagen){
		$imagen = trim($imagen);
		
		$sql = "UPDATE app_informacion SET ";
		$sql.= "inf_imagen = '$imagen'";
		$sql.= " WHERE inf_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
    
    
	
	function modifica_target_informacion($codigo,$target,$tipo){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_informacion SET ";
		$sql.= "inf_target = '$target',"; 
		$sql.= "inf_tipo_target = '$tipo',"; 		
		$sql.= "inf_fecha_registro = '$fsist'"; 		
		
		$sql.= " WHERE inf_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_informacion($codigo,$sit){
		
		$sql = "UPDATE app_informacion SET ";
		$sql.= "inf_situacion = $sit"; 
				
		$sql.= " WHERE inf_codigo = $codigo; "; 	
		
		return $sql;
	}
    
    function delete_informacion($codigo){
		$sql = "DELETE FROM app_informacion ";
		$sql.= " WHERE inf_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	
	function max_informacion(){
	    $sql = "SELECT max(inf_codigo) as max ";
		$sql.= " FROM app_informacion";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
/////////////////////////////  DETALLE DE INFORMACION DE GRUPOS //////////////////////////////////////

	function get_det_informacion_grupos($informacion,$grupo,$target = '',$tipo = '') {
		$target = trim($target);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
	    $sql= "SELECT inf_codigo, inf_nombre, inf_descripcion, inf_fecha_inicio, inf_fecha_fin, inf_fecha_registro, inf_target, inf_tipo_target, inf_imagen, inf_link, inf_situacion, gru_codigo, are_nombre, gru_nombre ";
		$sql.= " FROM app_informacion, app_det_informacion_grupos, app_grupo, app_segmento, app_area";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		$sql.= " AND gru_codigo = det_grupo";
		$sql.= " AND inf_codigo = det_informacion ";
		$sql.= " AND inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
		
		if(strlen($informacion)>0) { 
			$sql.= " AND det_informacion = $informacion"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND det_grupo IN($grupo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = '$tipo'"; 
		}
		
        $sql.= " GROUP BY inf_codigo";
		$sql.= " ORDER BY inf_fecha_inicio ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
    
    
    function get_informacion_grupos_users($informacion,$grupo,$fini = ''){
		
	    $sql = "SELECT user_id, device_id, device_token, device_type, certificate_type, status, created_at, updated_at,";
        $sql.= "inf_codigo, inf_nombre, inf_descripcion, inf_fecha_inicio, inf_fecha_fin, inf_fecha_registro, inf_target, inf_tipo_target, inf_imagen, inf_link, inf_situacion,";
        $sql.= "gru_codigo, gru_nombre ";
		$sql.= " FROM app_informacion, app_det_informacion_grupos, app_grupo,  app_grupo_alumno, app_padre_alumno, push_user";
		$sql.= " WHERE ag_grupo = gru_codigo";
		$sql.= " AND ag_alumno = pa_alumno";
		$sql.= " AND pa_padre = user_id";
        $sql.= " AND gru_codigo = det_grupo";
		$sql.= " AND inf_codigo = det_informacion ";
		$sql.= " AND inf_situacion = 1";
		if(strlen($informacion)>0) { 
			$sql.= " AND det_informacion = $informacion"; 
		}
		if(strlen($grupo)>0) {
			$sql.= " AND ag_grupo IN($grupo)";
		}
        if (strlen($fini)>0) {
            $fini = $this->regresa_fecha($fini);
            $sql.= " AND inf_fecha_inicio BETWEEN '$fini 00:00:00' AND '$fini 23:59:59'";
        }
		$sql.= " GROUP BY device_id";
		$sql.= " ORDER BY inf_fecha_inicio ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
    
    
	
	function get_lista_detalle_informacion_grupos($informacion,$grupo,$target = '',$tipo = '') {
		$target = trim($target);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_informacion, app_det_informacion_grupos, app_grupo, app_segmento, app_area";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		$sql.= " AND gru_codigo = det_grupo";
		$sql.= " AND inf_codigo = det_informacion ";
		$sql.= " AND inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
		
		if(strlen($informacion)>0) { 
			$sql.= " AND det_informacion = $informacion"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND det_grupo IN($grupo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = '$tipo'"; 
		}
		
		$sql.= " ORDER BY inf_fecha_inicio ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    function get_codigos_grupos($grupos){
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql= "SELECT inf_codigo as codigo";
		$sql.= " FROM app_det_informacion_grupos, app_informacion";
		$sql.= " WHERE inf_codigo = det_informacion";
		$sql.= " AND inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
        
		if(strlen($grupos)>0) { 
			  $sql.= " AND det_grupo = '$grupos'"; 
		}
		$sql.= " ORDER BY inf_fecha_inicio DESC, inf_codigo ASC";
		
        //echo $sql."<br>";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			$codigos = '';
			foreach($result as $row){
				$codigos.= $row['codigo'].',';
			}
			$codigos = substr($codigos, 0, -1);
		}else{
			$codigos = '';
		}
		//echo $codigos.'<br>';
		return $codigos;

	}
    
    
    function get_codigos_informacion_grupos($alumno){
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql= "SELECT inf_codigo as codigo";
		$sql.= " FROM app_grupo_alumno, app_det_informacion_grupos, app_informacion";
		$sql.= " WHERE inf_codigo = det_informacion";
		$sql.= " AND ag_grupo = det_grupo";
        $sql.= " AND inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
        
		if(strlen($alumno)>0) { 
			  $sql.= " AND ag_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY inf_fecha_inicio DESC, inf_codigo ASC";
		
        //echo $sql."<br>";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			$codigos = '';
			foreach($result as $row){
				$codigos.= $row['codigo'].',';
			}
			$codigos = substr($codigos, 0, -1);
		}else{
			$codigos = '';
		}
		//echo $codigos.'<br>';
		return $codigos;

	}
    
	
	function insert_det_informacion_grupos($informacion,$grupo){
		
		$sql = "INSERT INTO app_det_informacion_grupos";
		$sql.= " VALUES ($informacion,$grupo); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_det_informacion_grupos($informacion){
		
		$sql = "DELETE FROM app_det_informacion_grupos  ";
		$sql.= " WHERE det_informacion = $informacion; "; 	
		//echo $sql;
		return $sql;
	}
	
	
/////////////////////////////  DETALLE DE INFORMACION DE SECCIONES //////////////////////////////////////
	
	function get_det_informacion_secciones($informacion,$pensum,$nivel,$grado,$seccion,$target = '',$tipo = '') {
		$target = trim($target);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
	    $sql= "SELECT inf_codigo, inf_nombre, inf_descripcion, inf_fecha_inicio, inf_fecha_fin, inf_fecha_registro, inf_target, inf_tipo_target, inf_imagen, inf_link, inf_situacion, niv_pensum, niv_codigo, gra_codigo, sec_codigo, niv_descripcion, gra_descripcion, sec_descripcion ";                   
		$sql.= " FROM app_informacion, app_det_informacion_secciones, academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = det_pensum";
		$sql.= " AND sec_nivel = det_nivel";
		$sql.= " AND sec_grado = det_grado";
		$sql.= " AND sec_codigo = det_seccion";
		$sql.= " AND inf_codigo = det_informacion";
		$sql.= " AND inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
		
		if(strlen($informacion)>0) { 
			$sql.= " AND det_informacion = $informacion"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND det_pensum IN($pensum)"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND det_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND det_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND det_seccion IN($seccion)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = '$tipo'"; 
		}
		
        $sql.= " GROUP BY inf_codigo";
		$sql.= " ORDER BY inf_fecha_inicio ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
    
    
    function get_informacion_secciones_users($informacion,$pensum,$nivel,$grado,$seccion,$fini = ''){
		
	    $sql = "SELECT user_id, device_id, device_token, device_type, certificate_type, status, created_at, updated_at,";
        $sql.= "inf_codigo, inf_nombre, inf_descripcion, inf_fecha_inicio, inf_fecha_fin, inf_fecha_registro, inf_target, inf_tipo_target, inf_imagen, inf_link, inf_situacion,";
        $sql.= "det_pensum, det_nivel, det_grado, det_seccion, sec_pensum, sec_nivel, sec_grado, sec_codigo, seca_pensum, seca_nivel, seca_grado, seca_seccion, seca_alumno, sec_descripcion ";
		$sql.= " FROM app_informacion, app_det_informacion_secciones, academ_secciones, academ_seccion_alumno, app_padre_alumno, push_user";
		$sql.= " WHERE seca_seccion = sec_codigo";
		$sql.= " AND seca_alumno = pa_alumno";
		$sql.= " AND pa_padre = user_id";
        $sql.= " AND seca_pensum = det_pensum";
		$sql.= " AND seca_nivel = det_nivel";
		$sql.= " AND seca_grado = det_grado";
		$sql.= " AND seca_seccion = det_seccion";
		$sql.= " AND seca_pensum = sec_pensum";
		$sql.= " AND seca_nivel = sec_nivel";
		$sql.= " AND seca_grado = sec_grado";
		$sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND inf_codigo = det_informacion ";
		$sql.= " AND inf_situacion = 1";
		if(strlen($informacion)>0) { 
			$sql.= " AND det_informacion = $informacion"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND seca_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND seca_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND seca_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND seca_seccion IN($seccion)"; 
		}
        if (strlen($fini)>0) {
            $fini = $this->regresa_fecha($fini);
            $sql.= " AND inf_fecha_inicio BETWEEN '$fini 00:00:00' AND '$fini 23:59:59'";
        }
		$sql.= " GROUP BY device_id";
		$sql.= " ORDER BY inf_fecha_inicio ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
    
	
	function get_lista_detalle_informacion_secciones($informacion,$pensum,$nivel,$grado,$seccion,$target = '',$tipo = '') {
		$target = trim($target);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_informacion, app_det_informacion_secciones, academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = det_pensum";
		$sql.= " AND sec_nivel = det_nivel";
		$sql.= " AND sec_grado = det_grado";
		$sql.= " AND sec_codigo = det_seccion";
		$sql.= " AND inf_codigo = det_informacion";
		$sql.= " AND inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
		
		if(strlen($informacion)>0) { 
			$sql.= " AND det_informacion = $informacion"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND det_pensum IN($pensum)"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND det_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND det_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND det_seccion IN($seccion)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND inf_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND inf_tipo_target = '$tipo'"; 
		}
		
		$sql.= " ORDER BY inf_fecha_inicio ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    
    function get_codigos_secciones($pensum,$nivel = '',$grado = '',$seccion = ''){
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT inf_codigo as codigo";
		$sql.= " FROM app_det_informacion_secciones, app_informacion";
		$sql.= " WHERE inf_codigo = det_informacion";
		$sql.= " AND inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
        if(strlen($pensum)>0) { 
			$sql.= " AND det_pensum = $pensum"; 
		}
        if(strlen($nivel)>0) { 
			$sql.= " AND det_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND det_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND det_seccion IN($seccion)";
		}	
		$sql.= " ORDER BY inf_fecha_inicio ASC, inf_codigo ASC";
		
		//echo $sql.'<br>';
		$result = $this->exec_query($sql);
		if(is_array($result)){
			$codigos = '';
			foreach($result as $row){
				$codigos.= $row['codigo'].',';
			}
			$codigos = substr($codigos, 0, -1);
		}else{
			$codigos = '';
		}
		//echo $codigos.'<br>';
		return $codigos;

	}
    
    
    function get_codigos_informacion_secciones($pensum,$alumno){
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT inf_codigo as codigo";
		$sql.= " FROM academ_seccion_alumno, app_det_informacion_secciones, app_informacion";
		$sql.= " WHERE inf_codigo = det_informacion";
		$sql.= " AND seca_pensum = det_pensum";
		$sql.= " AND seca_nivel = det_nivel";
		$sql.= " AND seca_grado = det_grado";
		$sql.= " AND seca_seccion = det_seccion";
        $sql.= " AND inf_situacion = 1";
		$sql.= " AND YEAR(inf_fecha_inicio) BETWEEN $anio1 AND $anio2";
        
		if(strlen($alumno)>0) { 
			  $sql.= " AND seca_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND seca_pensum = $pensum"; 
		}
		$sql.= " ORDER BY inf_fecha_inicio ASC, inf_codigo ASC";
		
		//echo $sql.'<br>';
		$result = $this->exec_query($sql);
		if(is_array($result)){
			$codigos = '';
			foreach($result as $row){
				$codigos.= $row['codigo'].',';
			}
			$codigos = substr($codigos, 0, -1);
		}else{
			$codigos = '';
		}
		//echo $codigos.'<br>';
		return $codigos;

	}
	
	
	function insert_det_informacion_secciones($informacion,$pensum,$nivel,$grado,$seccion){
		
		$sql = "INSERT INTO app_det_informacion_secciones";
		$sql.= " VALUES ($informacion,$pensum,$nivel,$grado,$seccion); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_det_informacion_secciones($informacion){
		
		$sql = "DELETE FROM app_det_informacion_secciones  ";
		$sql.= " WHERE det_informacion = $informacion; "; 	
		//echo $sql;
		return $sql;
	}


}

?>