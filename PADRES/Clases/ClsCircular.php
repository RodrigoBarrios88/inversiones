<?php
require_once ("ClsConex.php");

class ClsCircular extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  CIRCULARES  //////////////////////////////////////
  
    function get_circular($codigo,$target = '',$tipo = '',$documento = '',$autorizacion = '', $limit1 = '',$limit2 = '') {
		$titulo = trim($titulo);
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_circular";
		$sql.= " WHERE cir_situacion = 1";
		
		if(strlen($codigo)>0) { 
			$sql.= " AND cir_codigo IN($codigo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = $tipo"; 
		}
		if($documento=='TRUE' || $documento=='true') { 
			$sql.= " AND cir_documento <> ''"; 
		}
		if(strlen($autorizacion)>0) { 
			$sql.= " AND cir_autorizacion = '$autorizacion'"; 
		}
        if(strlen($limit1)>0 && strlen($limit2)>0) { 
			$limite = "LIMIT $limit1,$limit2"; 
		}
		$sql.= " ORDER BY cir_fecha_publicacion DESC $limite";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_circular($codigo,$target = '',$tipo = '',$documento = '',$autorizacion = '') {
		$titulo = trim($titulo);
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_circular";
		$sql.= " WHERE cir_situacion = 1";
		
		if(strlen($codigo)>0) { 
			$sql.= " AND cir_codigo IN($codigo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = $tipo"; 
		}
		if($documento=='TRUE' || $documento=='true') { 
			$sql.= " AND cir_documento <> ''"; 
		}
		if(strlen($autorizacion)>0) { 
			$sql.= " AND cir_autorizacion = '$autorizacion'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
    
    function get_codigos_circular_todos(){
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT cir_codigo as codigo";
		$sql.= " FROM app_circular";
		$sql.= " WHERE cir_situacion = 1";
		$sql.= " AND cir_tipo_target = 0";
		$sql.= " AND YEAR(cir_fecha_publicacion) BETWEEN $anio1 AND $anio2";
        $sql.= " ORDER BY cir_fecha_publicacion DESC";
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
    
	
	function insert_circular($codigo,$titulo,$desc,$target,$tipo,$documento,$autorizacion){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$target = trim($target);
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_circular";
		$sql.= " VALUES ($codigo,'$titulo','$desc','$fsist','$target',$tipo,'$documento','$autorizacion',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_circular($codigo,$titulo,$desc,$autorizacion){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$target = trim($target);
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_circular SET ";
		$sql.= "cir_titulo = '$titulo',"; 
		$sql.= "cir_descripcion = '$desc',"; 		
		$sql.= "cir_fecha_publicacion = '$fsist',"; 		
		$sql.= "cir_autorizacion = '$autorizacion'";
		
		$sql.= " WHERE cir_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
    
    function modifica_documento($codigo,$documento){
		$documento = trim($documento);
		$sql = "UPDATE app_circular SET ";
		$sql.= "cir_documento = '$documento'";
		$sql.= " WHERE cir_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function modifica_target_circular($codigo,$target,$tipo){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_circular SET ";
		$sql.= "cir_target = '$target',"; 
		$sql.= "cir_tipo_target = '$tipo',"; 		
		$sql.= "cir_fecha_publicacion = '$fsist'"; 		
		
		$sql.= " WHERE cir_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_circular($codigo,$sit){
		
		$sql = "UPDATE app_circular SET ";
		$sql.= "cir_situacion = $sit"; 
				
		$sql.= " WHERE cir_codigo = $codigo; "; 	
		
		return $sql;
	}
    
    function delete_circular($codigo){
		$sql = "DELETE FROM app_circular ";
		$sql.= " WHERE cir_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	function max_circular(){
	    $sql = "SELECT max(cir_codigo) as max ";
		$sql.= " FROM app_circular";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
/////////////////////////////  DETALLE DE INFORMACION DE GRUPOS //////////////////////////////////////

	function get_det_circular_grupos($circular,$grupo,$target = '',$tipo = '') {
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT DISTINCT(cir_codigo), cir_titulo, cir_descripcion, cir_fecha_publicacion, cir_target, cir_tipo_target, cir_documento, cir_autorizacion, cir_situacion, gru_codigo ";
		$sql.= " FROM app_circular, app_det_circular_grupos, app_grupo, app_segmento, app_area";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		$sql.= " AND gru_codigo = det_grupo";
		$sql.= " AND cir_codigo = det_circular ";
		$sql.= " AND cir_situacion = 1";
		//$sql.= " AND cir_codigo IN(SELECT cir_codigo FROM app_circular WHERE cir_fecha_publicacion > '$fecha' OR cir_fecha_publicacion > '$fecha')";
		
		if(strlen($circular)>0) { 
			$sql.= " AND det_circular = $circular"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND det_grupo IN($grupo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = '$tipo'"; 
		}
		
		$sql.= " ORDER BY cir_fecha_publicacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_lista_detalle_circular_grupos($circular,$grupo,$target = '',$tipo = '') {
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_circular, app_det_circular_grupos, app_grupo, app_segmento, app_area";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		$sql.= " AND gru_codigo = det_grupo";
		$sql.= " AND cir_codigo = det_circular ";
		$sql.= " AND cir_situacion = 1";
		//$sql.= " AND cir_codigo IN(SELECT cir_codigo FROM app_circular WHERE cir_fecha_publicacion > '$fecha' OR cir_fecha_publicacion > '$fecha')";
		
		if(strlen($circular)>0) { 
			$sql.= " AND det_circular = $circular"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND det_grupo IN($grupo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = '$tipo'"; 
		}
		
		$sql.= " ORDER BY cir_fecha_publicacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    function get_codigos_grupos($grupos){
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql= "SELECT cir_codigo as codigo";
		$sql.= " FROM app_det_circular_grupos, app_circular";
		$sql.= " WHERE cir_codigo = det_circular";
		$sql.= " AND cir_situacion = 1";
		$sql.= " AND YEAR(cir_fecha_publicacion) BETWEEN $anio1 AND $anio2";
        
		if(strlen($grupos)>0) { 
			  $sql.= " AND det_grupo IN($grupos)"; 
		}
		$sql.= " ORDER BY cir_fecha_publicacion DESC, cir_codigo ASC";
		
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
    
    function get_codigos_circular_grupos($alumno){
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql= "SELECT cir_codigo as codigo";
		$sql.= " FROM app_grupo_alumno, app_det_circular_grupos, app_circular";
		$sql.= " WHERE cir_codigo = det_circular";
		$sql.= " AND ag_grupo = det_grupo";
        $sql.= " AND cir_situacion = 1";
		$sql.= " AND YEAR(cir_fecha_publicacion) BETWEEN $anio1 AND $anio2";
        
		if(strlen($alumno)>0) { 
			  $sql.= " AND ag_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY cir_fecha_publicacion DESC, cir_codigo ASC";
		
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
	
	function insert_det_circular_grupos($circular,$grupo){
		
		$sql = "INSERT INTO app_det_circular_grupos";
		$sql.= " VALUES ($circular,$grupo); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_det_circular_grupos($circular){
		
		$sql = "DELETE FROM app_det_circular_grupos  ";
		$sql.= " WHERE det_circular = $circular; "; 	
		//echo $sql;
		return $sql;
	}
	
	
/////////////////////////////  DETALLE DE INFORMACION DE SECCIONES //////////////////////////////////////
	
	function get_det_circular_secciones($circular,$pensum,$nivel,$grado,$seccion,$target = '',$tipo = '') {
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT DISTINCT(cir_codigo), cir_titulo, cir_descripcion, cir_fecha_publicacion, cir_target, cir_tipo_target, cir_documento, cir_autorizacion, cir_situacion, niv_pensum, niv_codigo, gra_codigo, sec_codigo ";
		$sql.= " FROM app_circular, app_det_circular_secciones, academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = det_pensum";
		$sql.= " AND sec_nivel = det_nivel";
		$sql.= " AND sec_grado = det_grado";
		$sql.= " AND sec_codigo = det_seccion";
		$sql.= " AND cir_codigo = det_circular";
		$sql.= " AND cir_situacion = 1";
		//$sql.= " AND cir_codigo IN(SELECT cir_codigo FROM app_circular WHERE cir_fecha_publicacion > '$fecha' OR cir_fecha_publicacion > '$fecha')";
		
		if(strlen($circular)>0) { 
			$sql.= " AND det_circular = $circular"; 
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
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = '$tipo'"; 
		}
		
		$sql.= " ORDER BY cir_fecha_publicacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_lista_detalle_circular_secciones($circular,$pensum,$nivel,$grado,$seccion,$target = '',$tipo = '') {
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_circular, app_det_circular_secciones, academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = det_pensum";
		$sql.= " AND sec_nivel = det_nivel";
		$sql.= " AND sec_grado = det_grado";
		$sql.= " AND sec_codigo = det_seccion";
		$sql.= " AND cir_codigo = det_circular";
		$sql.= " AND cir_situacion = 1";
		//$sql.= " AND cir_codigo IN(SELECT cir_codigo FROM app_circular WHERE cir_fecha_publicacion > '$fecha' OR cir_fecha_publicacion > '$fecha')";
		
		if(strlen($circular)>0) { 
			$sql.= " AND det_circular = $circular"; 
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
			$sql.= " AND cir_target = '$target'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cir_tipo_target = '$tipo'"; 
		}
		
		$sql.= " ORDER BY cir_fecha_publicacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    
    function get_codigos_secciones($pensum,$nivel = '',$grado = '',$seccion = ''){
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT cir_codigo as codigo";
		$sql.= " FROM app_det_circular_secciones, app_circular";
		$sql.= " WHERE cir_codigo = det_circular";
		$sql.= " AND cir_situacion = 1";
		$sql.= " AND YEAR(cir_fecha_publicacion) BETWEEN $anio1 AND $anio2";
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
		$sql.= " ORDER BY cir_fecha_publicacion ASC, cir_codigo ASC";
		
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
    
    
    function get_codigos_circular_secciones($pensum,$alumno){
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT cir_codigo as codigo";
		$sql.= " FROM academ_seccion_alumno, app_det_circular_secciones, app_circular";
		$sql.= " WHERE cir_codigo = det_circular";
		$sql.= " AND seca_pensum = det_pensum";
		$sql.= " AND seca_nivel = det_nivel";
		$sql.= " AND seca_grado = det_grado";
		$sql.= " AND seca_seccion = det_seccion";
        $sql.= " AND cir_situacion = 1";
		$sql.= " AND YEAR(cir_fecha_publicacion) BETWEEN $anio1 AND $anio2";
        
		if(strlen($alumno)>0) { 
			  $sql.= " AND seca_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND seca_pensum = $pensum"; 
		}
		$sql.= " ORDER BY cir_fecha_publicacion ASC, cir_codigo ASC";
		
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
	
	
	function insert_det_circular_secciones($circular,$pensum,$nivel,$grado,$seccion){
		
		$sql = "INSERT INTO app_det_circular_secciones";
		$sql.= " VALUES ($circular,$pensum,$nivel,$grado,$seccion); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_det_circular_secciones($circular){
		
		$sql = "DELETE FROM app_det_circular_secciones  ";
		$sql.= " WHERE det_circular = $circular; "; 	
		//echo $sql;
		return $sql;
	}

/////////////////////////////  AUTORIZACION //////////////////////////////////////
	
	function insert_autorizacion($circular,$persona,$autorizacion){
        $fsist = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_circular_autorizacion";
		$sql.= " VALUES ('$circular','$persona','$autorizacion','$fsist')";
		$sql.= " ON DUPLICATE KEY UPDATE aut_autoriza = '$autorizacion', aut_fecha_registro = '$fsist'; ";
		//echo $sql;
		return $sql;
	}
	
	function get_autorizacion_directa($circular,$persona) {
		
	    $sql= "SELECT aut_autoriza as autoriza, aut_fecha_registro as fecha ";
		$sql.= " FROM app_circular_autorizacion";
		$sql.= " WHERE aut_circular = '$circular'"; 
		$sql.= " AND aut_persona = '$persona'"; 
		
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$autoriza = $row["autoriza"];
				$fecha = $row["fecha"];
			}
		}else{
			$autoriza = null;
			$fecha = "";
		}
		//echo $sql;
		return array("autoriza" => $autoriza, "fecha" => $fecha);
	}
	
	function get_autorizacion_alumno($circular,$padres = '',$alumnos = '') {
		$pensum = $_SESSION["pensum"];
		
		$sql= "SELECT *, ";
		$sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno WHERE graa_pensum = gra_pensum AND graa_nivel = gra_nivel AND graa_grado = gra_codigo AND graa_alumno = alu_cui AND graa_pensum = $pensum ORDER BY graa_grado LIMIT 0 , 1) as alu_grado,";
		$sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno WHERE seca_pensum = sec_pensum AND seca_nivel = sec_nivel AND seca_grado = sec_grado AND seca_seccion = sec_codigo AND seca_alumno = alu_cui AND seca_pensum = $pensum ORDER BY seca_seccion LIMIT 0 , 1) as alu_seccion ";
		$sql.= " FROM app_padre_alumno,app_padres,app_alumnos,app_circular_autorizacion";
		$sql.= " WHERE pa_padre = pad_cui";
		$sql.= " AND pa_alumno = alu_cui";
		$sql.= " AND pa_padre = aut_persona";
		$sql.= " AND alu_situacion = 1";
		if(strlen($circular)>0) { 
			$sql.= " AND aut_circular = '$circular'"; 
		}
		if(strlen($padres)>0) { 
			  $sql.= " AND pa_padre IN('$padres')";
		}
		if(strlen($alumnos)>0) { 
			  $sql.= " AND pa_alumno IN('$alumnos')";
		}
		$sql.= " ORDER BY alu_cui ASC";
	    
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}


}

?>
