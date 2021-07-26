<?php
require_once ("ClsConex.php");

class ClsEncuesta extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  ENCUESTA  //////////////////////////////////////
  
    function get_encuesta($codigo,$target = '',$tipo_target = '',$destinatarios = '',$sit = '',$visualizacion = '') {
		$titulo = trim($titulo);
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_encuesta";
		$sql.= " WHERE enc_situacion != 0";
		if(strlen($visualizacion)>0) { 
			$sql.= " AND enc_codigo IN(SELECT enc_codigo FROM app_encuesta WHERE enc_fecha_limite > '$fecha')";
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND enc_codigo IN($codigo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND enc_target = '$target'"; 
		}
		if(strlen($tipo_target)>0) { 
			$sql.= " AND enc_tipo_target = $tipo_target"; 
		}
		if(strlen($destinatarios)>0) { 
			$sql.= " AND enc_destinatarios = $destinatarios"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND enc_situacion = $sit"; 
		}
		$sql.= " ORDER BY enc_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br>";
		return $result;
	}
	
	function count_encuesta($cod,$target = '',$tipo_target = '',$destinatarios = '',$sit = '',$visualizacion = '') {
		$titulo = trim($titulo);
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_encuesta";
		$sql.= " WHERE enc_situacion != 0";
		if(strlen($visualizacion)>0) { 
			$sql.= " AND enc_codigo IN(SELECT enc_codigo FROM app_encuesta WHERE enc_fecha_limite > '$fecha')";
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND enc_codigo IN($codigo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND enc_target = '$target'"; 
		}
		if(strlen($tipo_target)>0) { 
			$sql.= " AND enc_tipo_target = $tipo_target"; 
		}
		if(strlen($destinatarios)>0) { 
			$sql.= " AND enc_destinatarios = $destinatarios"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND enc_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
    
    function get_codigos_encuestas_todos(){
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT enc_codigo as codigo";
		$sql.= " FROM app_encuesta";
		$sql.= " WHERE enc_situacion = 1";
		$sql.= " AND enc_tipo_target = 0";
		$sql.= " AND YEAR(enc_fecha_limite) BETWEEN $anio1 AND $anio2";
        $sql.= " ORDER BY enc_fecha_registro DESC";
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
	
	
	function insert_encuesta($cod,$target,$tipo_target,$destinatarios,$titulo,$desc,$feclimit){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$target = trim($target);
		$fsist = date("Y-m-d H:i:s");
		$feclimit = $this->regresa_fechaHora($feclimit);
		
		$sql = "INSERT INTO app_encuesta";
		$sql.= " VALUES ($cod,'$target',$tipo_target,$destinatarios,'$titulo','$desc','$feclimit','$fsist',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_encuesta($cod,$titulo,$desc,$feclimit,$destinatarios){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$target = trim($target);
		$fsist = date("Y-m-d H:i:s");
		$feclimit = $this->regresa_fecha($feclimit);
		
		$sql = "UPDATE app_encuesta SET ";
		$sql.= "enc_titulo = '$titulo',"; 
		$sql.= "enc_descripcion = '$desc',"; 		
		$sql.= "enc_destinatarios = '$destinatarios',"; 		
		$sql.= "enc_fecha_limite = '$feclimit',"; 
		$sql.= "enc_fecha_registro = '$fsist'"; 		
		
		$sql.= " WHERE enc_codigo = $cod; "; 	
		//echo $sql;
		return $sql;
	}
	
	function modifica_target_encuesta($cod,$target,$tipo_target){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_encuesta SET ";
		$sql.= "enc_target = '$target',"; 
		$sql.= "enc_tipo_target = '$tipo_target',"; 
		$sql.= "enc_fecha_registro = '$fsist'"; 		
		
		$sql.= " WHERE enc_codigo = $cod; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_encuesta($cod,$sit){
		
		$sql = "UPDATE app_encuesta SET ";
		$sql.= "enc_situacion = $sit"; 
				
		$sql.= " WHERE enc_codigo = $cod; "; 	
		
		return $sql;
	}
    
    function delete_postit($codigo){
		$sql = "DELETE FROM app_encuesta ";
		$sql.= " WHERE enc_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	function max_encuesta(){
	    $sql = "SELECT max(enc_codigo) as max ";
		$sql.= " FROM app_encuesta";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
/////////////////////////////  DETALLE DE INFORMACION DE GRUPOS //////////////////////////////////////

	function get_encuesta_grupos($encuesta,$grupo,$target = '',$destinatarios = '',$sit = '',$visualizacion = '') {
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT DISTINCT(enc_codigo), enc_titulo, enc_descripcion, enc_fecha_limite, enc_fecha_registro, enc_target, enc_destinatarios, enc_situacion, tar_grupo, gru_nombre ";
		$sql.= " FROM app_encuesta, app_encuesta_target_grupos, app_grupo, app_segmento, app_area";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		$sql.= " AND gru_codigo = tar_grupo";
		$sql.= " AND enc_codigo = tar_encuesta ";
		if(strlen($visualizacion)>0) { 
			$sql.= " AND enc_codigo IN(SELECT enc_codigo FROM app_encuesta WHERE enc_fecha_limite > '$fecha')";
		}
		if(strlen($encuesta)>0) { 
			$sql.= " AND tar_encuesta = $encuesta"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND tar_grupo IN($grupo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND enc_target = '$target'"; 
		}
		if(strlen($destinatarios)>0) { 
			$sql.= " AND enc_destinatarios = '$destinatarios'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND enc_situacion = $sit"; 
		}
		$sql.= " ORDER BY enc_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

	function get_encuesta_target_grupos($encuesta,$grupo,$target = '',$destinatarios = '',$sit = '',$visualizacion = '') {
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT DISTINCT(enc_codigo), enc_titulo, enc_descripcion, enc_fecha_limite, enc_fecha_registro, enc_target, enc_destinatarios, enc_situacion, tar_grupo, gru_nombre ";
		$sql.= " FROM app_encuesta, app_encuesta_target_grupos, app_grupo, app_segmento, app_area";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		$sql.= " AND gru_codigo = tar_grupo";
		$sql.= " AND enc_codigo = tar_encuesta ";
		if(strlen($visualizacion)>0) { 
			$sql.= " AND enc_codigo IN(SELECT enc_codigo FROM app_encuesta WHERE enc_fecha_limite > '$fecha')";
		}
		if(strlen($encuesta)>0) { 
			$sql.= " AND tar_encuesta = $encuesta"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND tar_grupo IN($grupo)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND enc_target = '$target'"; 
		}
		if(strlen($destinatarios)>0) { 
			$sql.= " AND enc_destinatarios = '$destinatarios'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND enc_situacion = $sit"; 
		}
		$sql.= " ORDER BY enc_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    function get_codigos_encuestas_grupos($alumno){
		
        $sql= "SELECT enc_codigo as codigo";
		$sql.= " FROM app_grupo_alumno, app_encuesta_target_grupos, app_encuesta";
		$sql.= " WHERE enc_codigo = tar_encuesta";
		$sql.= " AND ag_grupo = tar_grupo";
        $sql.= " AND enc_situacion = 1"; 
		if(strlen($alumno)>0) { 
			  $sql.= " AND ag_alumno = '$alumno'"; 
		}
		$sql.= " ORDER BY enc_fecha_registro DESC, enc_codigo DESC";
		
		//echo $sql;
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
	
	function insert_encuesta_target_grupos($encuesta,$grupo){
		
		$sql = "INSERT INTO app_encuesta_target_grupos";
		$sql.= " VALUES ($encuesta,$grupo); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_encuesta_target_grupos($encuesta){
		
		$sql = "DELETE FROM app_encuesta_target_grupos  ";
		$sql.= " WHERE tar_encuesta = $encuesta; "; 	
		//echo $sql;
		return $sql;
	}
	
	
/////////////////////////////  DETALLE DE INFORMACION DE SECCIONES //////////////////////////////////////

	function get_encuesta_grados($encuesta,$pensum,$nivel,$grado,$target = '',$destinatarios = '',$sit = '',$visualizacion = '') {
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT *";
		$sql.= " FROM app_encuesta, app_encuesta_target_grados, academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = tar_pensum";
		$sql.= " AND gra_nivel = tar_nivel";
		$sql.= " AND gra_codigo = tar_grado";
		$sql.= " AND enc_codigo = tar_encuesta";
		
		if(strlen($visualizacion)>0) { 
			$sql.= " AND enc_codigo IN(SELECT enc_codigo FROM app_encuesta WHERE enc_fecha_limite > '$fecha')";
		}
		if(strlen($encuesta)>0) { 
			$sql.= " AND tar_encuesta = $encuesta"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND tar_pensum IN($pensum)"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND tar_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND tar_grado IN($grado)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND enc_target = '$target'"; 
		}
		if(strlen($destinatarios)>0) { 
			$sql.= " AND enc_destinatarios = '$destinatarios'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND enc_situacion = $sit"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND enc_situacion = $sit"; 
		}
		
		$sql.= " ORDER BY enc_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_encuesta_target_grados($encuesta,$pensum,$nivel,$grado,$target = '',$destinatarios = '',$sit = '',$visualizacion = '') {
		$target = trim($target);
		$fecha = date("Y-m-d H:i:s");
		
	    $sql= "SELECT DISTINCT(enc_codigo), enc_titulo, enc_descripcion, enc_fecha_limite, enc_fecha_registro, enc_target, enc_destinatarios, enc_situacion, tar_pensum, tar_nivel, tar_grado, gra_descripcion";
		$sql.= " FROM app_encuesta, app_encuesta_target_grados, academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = tar_pensum";
		$sql.= " AND gra_nivel = tar_nivel";
		$sql.= " AND gra_codigo = tar_grado";
		$sql.= " AND enc_codigo = tar_encuesta";
		
		if(strlen($visualizacion)>0) { 
			$sql.= " AND enc_codigo IN(SELECT enc_codigo FROM app_encuesta WHERE enc_fecha_limite > '$fecha')";
		}
		if(strlen($encuesta)>0) { 
			$sql.= " AND tar_encuesta = $encuesta"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND tar_pensum IN($pensum)"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND tar_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND tar_grado IN($grado)"; 
		}
		if(strlen($target)>0) { 
			$sql.= " AND enc_target = '$target'"; 
		}
		if(strlen($destinatarios)>0) { 
			$sql.= " AND enc_destinatarios = '$destinatarios'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND enc_situacion = $sit"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND enc_situacion = $sit"; 
		}
		
		$sql.= " ORDER BY enc_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
    function get_codigos_encuestas_grados($pensum,$alumno){
		$tipo = trim($tipo);
		
        $sql= "SELECT enc_codigo as codigo";
		$sql.= " FROM academ_grado_alumno, app_encuesta_target_grados, app_encuesta";
		$sql.= " WHERE enc_codigo = tar_encuesta";
		$sql.= " AND graa_pensum = tar_pensum";
		$sql.= " AND graa_nivel = tar_nivel";
		$sql.= " AND graa_grado = tar_grado";
        $sql.= " AND enc_situacion = 1"; 
		if(strlen($alumno)>0) { 
			  $sql.= " AND graa_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND graa_pensum = $pensum"; 
		}
		$sql.= " ORDER BY enc_fecha_registro DESC, enc_codigo DESC";
		
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
	
	
	function insert_encuesta_target_grados($encuesta,$pensum,$nivel,$grado){
		
		$sql = "INSERT INTO app_encuesta_target_grados";
		$sql.= " VALUES ($encuesta,$pensum,$nivel,$grado); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_encuesta_target_grados($encuesta){
		
		$sql = "DELETE FROM app_encuesta_target_grados  ";
		$sql.= " WHERE tar_encuesta = $encuesta; "; 	
		//echo $sql;
		return $sql;
	}
	
/////////////////////////////  PREGUNTAS  //////////////////////////////////////
  
    function get_pregunta($codigo,$encuesta,$tipo = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_encuesta, app_preguntas";
		$sql.= " WHERE enc_codigo = pre_encuesta";
		if(strlen($codigo)>0) { 
			$sql.= " AND pre_codigo = $codigo"; 
		}
		if(strlen($encuesta)>0) { 
			$sql.= " AND pre_encuesta = '$encuesta'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND pre_tipo = $tipo"; 
		}
		$sql.= " ORDER BY enc_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_pregunta($codigo,$encuesta,$tipo = '') {
		$sql= "SELECT COUNT(*) as total";
        $sql.= " FROM app_encuesta, app_preguntas";
		$sql.= " WHERE enc_codigo = pre_encuesta";
		if(strlen($codigo)>0) { 
			$sql.= " AND pre_codigo = $codigo"; 
		}
		if(strlen($encuesta)>0) { 
			$sql.= " AND pre_encuesta = '$encuesta'"; 
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
	
	
	function insert_pregunta($codigo,$encuesta,$desc,$tipo){
        $desc = trim($desc);
		
		$sql = "INSERT INTO app_preguntas";
		$sql.= " VALUES ($codigo,$encuesta,'$desc',$tipo);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_pregunta($codigo,$encuesta,$desc,$tipo){
		$desc = trim($desc);
		
		$sql = "UPDATE app_preguntas SET ";
		$sql.= "pre_descripcion = '$desc',"; 
		$sql.= "pre_tipo = '$tipo'"; 		
		
		$sql.= " WHERE pre_codigo = $codigo";
        $sql.= " AND pre_encuesta = $encuesta; "; 
		//echo $sql;
		return $sql;
	}
	
	
	function delete_pregunta($codigo,$encuesta){
		
		$sql = "DELETE FROM app_preguntas  ";
		$sql.= " WHERE pre_codigo = $codigo";
        $sql.= " AND pre_encuesta = $encuesta; "; 
		
		return $sql;
	}
	
	function max_pregunta($encuesta){
	    $sql = "SELECT max(pre_codigo) as max ";
		$sql.= " FROM app_preguntas";
        $sql.= " WHERE pre_encuesta = $encuesta ";
        
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////////////////////////////  RESPUESTA  //////////////////////////////////////
	
	function insert_respuesta($encuesta,$pregunta,$persona,$tipo,$ponderacion,$respuesta){
        $respuesta = trim($respuesta);
		
		$sql = "INSERT INTO app_respuestas";
		$sql.= " VALUES ('$encuesta','$pregunta','$persona','$tipo','$ponderacion','$respuesta')";
		$sql.= " ON DUPLICATE KEY UPDATE resp_ponderacion = '$ponderacion', resp_respuesta = '$respuesta'; ";
		//echo $sql;
		return $sql;
	}
	
	function get_respuesta_directa($encuesta,$pregunta,$persona) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_respuestas";
		$sql.= " WHERE resp_encuesta = '$encuesta'"; 
		$sql.= " AND resp_pregunta = '$pregunta'"; 
		$sql.= " AND resp_persona = '$persona'"; 
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_pregunta_respuesta($encuesta,$pregunta,$persona,$tipo = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_encuesta, app_preguntas, app_respuestas";
		$sql.= " WHERE enc_codigo = pre_encuesta";
		$sql.= " AND resp_encuesta = pre_encuesta";
		$sql.= " AND resp_pregunta = pre_codigo";
		if(strlen($encuesta)>0) { 
			$sql.= " AND pre_encuesta = '$encuesta'"; 
		}
		if(strlen($pregunta)>0) { 
			$sql.= " AND pre_codigo = '$pregunta'"; 
		}
		if(strlen($persona)>0) { 
			$sql.= " AND resp_persona = '$persona'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND resp_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY enc_codigo, pre_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}

}

?>
