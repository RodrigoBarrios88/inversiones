<?php
require_once ("ClsConex.php");

class ClsVideoclase extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

///////////////////////////// VIDEOLLAMADAS //////////////////////////////////////

    function get_videoclase($codigo,$target = '',$tipo = '',$plataforma = '',$fecha = '',$fini = '',$ffin = '',$usuario = '') {
          $nombre = trim($nombre);
          $target = trim($target);
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql= "SELECT * ";
          $sql.= " FROM app_videoclase";
          $sql.= " WHERE vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($codigo)>0) {
               $sql.= " AND vid_codigo IN($codigo)";
          }
          if(strlen($target)>0) {
               $sql.= " AND vid_target = '$target'";
          }
          if(strlen($tipo)>0) {
               $sql.= " AND vid_tipo_target = $tipo";
          }
          if(strlen($plataforma)>0) {
               $sql.= " AND vid_plataforma = '$plataforma'";
          }
          if (strlen($fecha)>0) {
               $fecha = $this->regresa_fecha($fecha);
               $sql.= " AND vid_fecha_inicio BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
          }
          if (strlen($fini)>0 && strlen($ffin)>0) {
               $fini = $this->regresa_fecha($fini);
               $ffin = $this->regresa_fecha($ffin);
               $sql.= " AND vid_fecha_inicio BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
          }
          if(strlen($usuario)>0) {
               $sql.= " AND vid_usuario = $usuario";
          }
          $sql.= " GROUP BY vid_codprimario";
          $sql.= " ORDER BY vid_fecha_inicio ASC";

          $result = $this->exec_query($sql);
          //echo $sql."<br><br>";
          return $result;

	}


    function get_videoclase_push_user($codigo,$target = '',$tipo = '',$plataforma = '',$fecha = '',$fini = '',$ffin = '',$usuario = '') {
          $nombre = trim($nombre);
          $target = trim($target);
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql = "SELECT user_id, device_id, device_token, device_type, certificate_type, status, created_at, updated_at,";
          $sql.= "vid_codigo, vid_nombre, vid_descripcion, vid_fecha_inicio, vid_fecha_fin, vid_fecha_registro, vid_target, vid_tipo_target, vid_plataforma, vid_link, vid_usuario, vid_situacion ";
          $sql.= " FROM app_videoclase, push_user";
          $sql.= " WHERE vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($codigo)>0) {
               $sql.= " AND vid_codigo = $codigo";
          }
          if(strlen($target)>0) {
               $sql.= " AND vid_target = '$target'";
          }
          if(strlen($tipo)>0) {
               $sql.= " AND vid_tipo_target = $tipo";
          }
          if(strlen($plataforma)>0) {
               $sql.= " AND vid_plataforma = '$plataforma'";
          }
          if (strlen($fecha)>0) {
               $fecha = $this->regresa_fecha($fecha);
               $sql.= " AND vid_fecha_inicio BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
          }
          if (strlen($fini)>0 && strlen($ffin)>0) {
               $fini = $this->regresa_fecha($fini);
               $ffin = $this->regresa_fecha($ffin);
               $sql.= " AND vid_fecha_inicio BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
          }
          if(strlen($usuario)>0) {
               $sql.= " AND vid_usuario = $usuario";
          }
          $sql.= " GROUP BY device_id";
          $sql.= " ORDER BY vid_fecha_inicio ASC";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;

	}

	function count_videoclase($codigo,$target = '',$tipo = '',$plataforma = '',$fecha = '',$fini = '',$ffin = '') {
          $nombre = trim($nombre);
          $target = trim($target);
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql= "SELECT COUNT(*) as total";
          $sql.= " FROM app_videoclase";
          $sql.= " WHERE vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($codigo)>0) {
               $sql.= " AND vid_codigo = $codigo";
          }
          if(strlen($target)>0) {
               $sql.= " AND vid_target = '$target'";
          }
          if(strlen($tipo)>0) {
               $sql.= " AND vid_tipo_target = $tipo";
          }
          if(strlen($plataforma)>0) {
               $sql.= " AND vid_plataforma = '$plataforma'";
          }
          if(strlen($fecha)>0) {
               $fecha = $this->regresa_fecha($fecha);
               $sql.= " AND vid_fecha_inicio BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:59'";
          }
          if (strlen($fini)>0 && strlen($ffin)>0) {
               $fini = $this->regresa_fecha($fini);
               $ffin = $this->regresa_fecha($ffin);
               $sql.= " AND vid_fecha_inicio BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
          }

          //echo $sql;
          $result = $this->exec_query($sql);
          foreach($result as $row){
               $total = $row['total'];
          }
          return $total;
	}


    function get_codigos_videoclase_todos(){
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql = "SELECT vid_codigo as codigo";
          $sql.= " FROM app_videoclase";
          $sql.= " WHERE vid_situacion = 1";
          $sql.= " AND vid_tipo_target = 0";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";
          $sql.= " ORDER BY vid_fecha_inicio DESC";
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


	function insert_videoclase($codigo,$nombre,$descripcion,$fini,$ffin,$target,$tipo,$plataforma,$link,$schedule,$event,$partnerId,$usuario = ''){
          $nombre = trim($nombre);
          $descripcion = trim($descripcion);
          $target = trim($target);
          $fsist = date("Y-m-d H:i:s");
          $usuario = ($usuario == '')?$_SESSION["codigo"]:$usuario;
          $fini = $this->regresa_fechaHora($fini);
          $ffin = $this->regresa_fechaHora($ffin);

          $sql = "INSERT INTO app_videoclase";
          $sql.= " VALUES ($codigo,'$nombre','$descripcion','$fini','$ffin','$fsist','$fsist','$target',$tipo,'$plataforma','$link','$schedule','$event','$partnerId',$usuario,1);";
          //echo $sql;
          return $sql;
	}


	function modifica_videoclase($codigo,$nombre,$descripcion,$fini,$ffin,$plataforma,$link,$usuario = ''){
          $nombre = trim($nombre);
          $descripcion = trim($descripcion);
          $target = trim($target);
          $fsist = date("Y-m-d H:i:s");
          $usuario = ($usuario == '')?$_SESSION["codigo"]:$usuario;
          $fini = $this->regresa_fechaHora($fini);
          $ffin = $this->regresa_fechaHora($ffin);

          $sql = "UPDATE app_videoclase SET ";
          $sql.= "vid_nombre = '$nombre',";
          $sql.= "vid_descripcion = '$descripcion',";
          $sql.= "vid_fecha_inicio = '$fini',";
          $sql.= "vid_fecha_fin = '$ffin',";
          $sql.= "vid_fecha_update = '$fsist',";
          $sql.= "vid_plataforma = '$plataforma',";
          $sql.= "vid_link = '$link',";
          $sql.= "vid_usuario = '$usuario'";

          $sql.= " WHERE vid_codigo = $codigo; ";
          //echo $sql;
          return $sql;
	}

    function modifica_schedule_videoclase($codigo,$schedule,$event,$partnerId,$usuario = ''){
          $fsist = date("Y-m-d H:i:s");
          $usuario = ($usuario == '')?$_SESSION["codigo"]:$usuario;

          $sql = "UPDATE app_videoclase SET ";
          $sql.= "vid_schedule = '$schedule',";
          $sql.= "vid_event = '$event',";
          $sql.= "vid_partnerId = '$partnerId',";
          $sql.= "vid_fecha_update = '$fsist',";
          $sql.= "vid_usuario = '$usuario'";

          $sql.= " WHERE vid_codigo = $codigo; ";
          //echo $sql;
          return $sql;
	}

	function modifica_target_videoclase($codigo,$target,$tipo){
		$fsist = date("Y-m-d H:i:s");

		$sql = "UPDATE app_videoclase SET ";
		$sql.= "vid_target = '$target',";
		$sql.= "vid_tipo_target = '$tipo',";
		$sql.= "vid_fecha_registro = '$fsist'";

		$sql.= " WHERE vid_codigo = $codigo; ";
		//echo $sql;
		return $sql;
	}

	function cambia_sit_videoclase($codigo,$sit){

		$sql = "UPDATE app_videoclase SET ";
		$sql.= "vid_situacion = $sit";

		$sql.= " WHERE vid_codigo = $codigo; ";

		return $sql;
	}

    function delete_videoclase($codigo){
          $sql = "DELETE FROM app_videoclase_detalle_grupos ";
          $sql.= " WHERE det_videoclase = $codigo;";
          $sql = "DELETE FROM app_videoclase_detalle_secciones ";
          $sql.= " WHERE det_videoclase = $codigo;";

          $sql = "DELETE FROM app_videoclase ";
          $sql.= " WHERE vid_codigo = $codigo;";

          return $sql;
	}


	function max_videoclase(){
          $sql = "SELECT max(vid_codigo) as max ";
          $sql.= " FROM app_videoclase";
          $result = $this->exec_query($sql);
          foreach($result as $row){
               $max = $row["max"];
          }
          //echo $sql;
          return $max;
	}

/////////////////////////////  DETALLE DE INFORMACION DE GRUPOS //////////////////////////////////////

	function get_det_videoclase_grupos($videoclase,$grupo,$target = '',$tipo = '') {
          $target = trim($target);
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql= "SELECT vid_codigo, vid_nombre, vid_descripcion, vid_fecha_inicio, vid_fecha_fin, vid_fecha_registro, vid_target, vid_tipo_target, vid_plataforma, vid_link, vid_situacion, gru_codigo, are_nombre, gru_nombre ";
          $sql.= " FROM app_videoclase, app_videoclase_detalle_grupos, app_grupo, app_segmento, app_videoclase_usuarios";
          $sql.= " WHERE gru_segmento = seg_codigo";
          $sql.= " AND gru_area = seg_area";
          $sql.= " AND seg_area = are_codigo";
          $sql.= " AND gru_codigo = det_grupo";
          $sql.= " AND vid_codigo = det_videoclase ";
          $sql.= " AND vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($videoclase)>0) {
               $sql.= " AND det_videoclase = $videoclase";
          }
          if(strlen($grupo)>0) {
               $sql.= " AND det_grupo IN($grupo)";
          }
          if(strlen($target)>0) {
               $sql.= " AND vid_target = '$target'";
          }
          if(strlen($tipo)>0) {
               $sql.= " AND vid_tipo_target = '$tipo'";
          }

          //$sql.= " GROUP BY vid_codigo";
          $sql.= " ORDER BY vid_fecha_inicio ASC";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;
	}


    function get_videoclase_grupos_users($videoclase,$grupo,$fini = ''){

          $sql = "SELECT user_id, device_id, device_token, device_type, certificate_type, status, created_at, updated_at,";
          $sql.= "vid_codigo, vid_nombre, vid_descripcion, vid_fecha_inicio, vid_fecha_fin, vid_fecha_registro, vid_target, vid_tipo_target, vid_plataforma, vid_link, vid_situacion,";
          $sql.= "gru_codigo, gru_nombre ";
          $sql.= " FROM app_videoclase, app_videoclase_detalle_grupos, app_grupo,  app_grupo_alumno, app_padre_alumno, push_user";
          $sql.= " WHERE ag_grupo = gru_codigo";
          $sql.= " AND ag_alumno = pa_alumno";
          $sql.= " AND pa_padre = user_id";
          $sql.= " AND gru_codigo = det_grupo";
          $sql.= " AND vid_codigo = det_videoclase ";
          $sql.= " AND vid_situacion = 1";
          if(strlen($videoclase)>0) {
               $sql.= " AND det_videoclase = $videoclase";
          }
          if(strlen($grupo)>0) {
               $sql.= " AND ag_grupo IN($grupo)";
          }
          if (strlen($fini)>0) {
               $fini = $this->regresa_fecha($fini);
               $sql.= " AND vid_fecha_inicio BETWEEN '$fini 00:00:00' AND '$fini 23:59:59'";
          }
          $sql.= " GROUP BY device_id";
          $sql.= " ORDER BY vid_fecha_inicio ASC";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;
	}



	function get_lista_detalle_videoclase_grupos($videoclase,$grupo,$target = '',$tipo = '') {
          $target = trim($target);
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql= "SELECT * ";
          $sql.= " FROM app_videoclase, app_videoclase_detalle_grupos, app_grupo, app_segmento, app_videoclase_usuarios";
          $sql.= " WHERE gru_segmento = seg_codigo";
          $sql.= " AND gru_area = seg_area";
          $sql.= " AND seg_area = are_codigo";
          $sql.= " AND gru_codigo = det_grupo";
          $sql.= " AND vid_codigo = det_videoclase ";
          $sql.= " AND vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($videoclase)>0) {
               $sql.= " AND det_videoclase = $videoclase";
          }
          if(strlen($grupo)>0) {
               $sql.= " AND det_grupo IN($grupo)";
          }
          if(strlen($target)>0) {
               $sql.= " AND vid_target = '$target'";
          }
          if(strlen($tipo)>0) {
               $sql.= " AND vid_tipo_target = '$tipo'";
          }

          $sql.= " ORDER BY vid_fecha_inicio ASC";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;

	}

    function get_codigos_grupos($grupos){
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql= "SELECT vid_codigo as codigo";
          $sql.= " FROM app_videoclase_detalle_grupos, app_videoclase";
          $sql.= " WHERE vid_codigo = det_videoclase";
          $sql.= " AND vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($grupos)>0) {
               $sql.= " AND det_grupo = '$grupos'";
          }
          $sql.= " ORDER BY vid_fecha_inicio DESC, vid_codigo ASC";

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


    function get_codigos_videoclase_grupos($alumno){
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql= "SELECT vid_codigo as codigo";
          $sql.= " FROM app_grupo_alumno, app_videoclase_detalle_grupos, app_videoclase";
          $sql.= " WHERE vid_codigo = det_videoclase";
          $sql.= " AND ag_grupo = det_grupo";
          $sql.= " AND vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($alumno)>0) {
          $sql.= " AND ag_alumno = '$alumno'";
          }
          $sql.= " ORDER BY vid_fecha_inicio DESC, vid_codigo ASC";

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


	function insert_det_videoclase_grupos($videoclase,$grupo){

		$sql = "INSERT INTO app_videoclase_detalle_grupos";
		$sql.= " VALUES ($videoclase,$grupo); ";
		//echo $sql;
		return $sql;
	}

	function delete_det_videoclase_grupos($videoclase){

		$sql = "DELETE FROM app_videoclase_detalle_grupos  ";
		$sql.= " WHERE det_videoclase = $videoclase; ";
		//echo $sql;
		return $sql;
	}


/////////////////////////////  DETALLE DE INFORMACION DE SECCIONES //////////////////////////////////////

	function get_det_videoclase_secciones($videoclase,$pensum,$nivel,$grado,$seccion,$target = '',$tipo = '') {
          $target = trim($target);
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql= "SELECT vid_codigo, vid_nombre, vid_descripcion, vid_fecha_inicio, vid_fecha_fin, vid_fecha_registro, vid_target, vid_tipo_target, vid_plataforma, vid_link, vid_situacion, niv_pensum, niv_codigo, gra_codigo, sec_codigo, niv_descripcion, gra_descripcion, sec_descripcion ";
          $sql.= " FROM app_videoclase, app_videoclase_detalle_secciones, academ_nivel, academ_grado, academ_secciones";
          $sql.= " WHERE niv_pensum = gra_pensum";
          $sql.= " AND niv_codigo = gra_nivel";
          $sql.= " AND sec_pensum = gra_pensum";
          $sql.= " AND sec_nivel = gra_nivel";
          $sql.= " AND sec_grado = gra_codigo";
          $sql.= " AND sec_pensum = det_pensum";
          $sql.= " AND sec_nivel = det_nivel";
          $sql.= " AND sec_grado = det_grado";
          $sql.= " AND sec_codigo = det_seccion";
          $sql.= " AND vid_codigo = det_videoclase";
          $sql.= " AND vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($videoclase)>0) {
               $sql.= " AND det_videoclase = $videoclase";
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
               $sql.= " AND vid_target = '$target'";
          }
          if(strlen($tipo)>0) {
               $sql.= " AND vid_tipo_target = '$tipo'";
          }

          //$sql.= " GROUP BY vid_codigo";
          $sql.= " ORDER BY vid_fecha_inicio ASC";

          $result = $this->exec_query($sql);
          //echo $sql."<br><br>";
          return $result;

	}


    function get_videoclase_secciones_users($videoclase,$pensum,$nivel,$grado,$seccion,$fini = ''){

          $sql = "SELECT user_id, device_id, device_token, device_type, certificate_type, status, created_at, updated_at,";
          $sql.= "vid_codigo, vid_nombre, vid_descripcion, vid_fecha_inicio, vid_fecha_fin, vid_fecha_registro, vid_target, vid_tipo_target, vid_plataforma, vid_link, vid_situacion,";
          $sql.= "det_pensum, det_nivel, det_grado, det_seccion, sec_pensum, sec_nivel, sec_grado, sec_codigo, seca_pensum, seca_nivel, seca_grado, seca_seccion, seca_alumno, sec_descripcion ";
          $sql.= " FROM app_videoclase, app_videoclase_detalle_secciones, academ_secciones, academ_seccion_alumno, app_padre_alumno, push_user";
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
          $sql.= " AND vid_codigo = det_videoclase ";
          $sql.= " AND vid_situacion = 1";
          if(strlen($videoclase)>0) {
               $sql.= " AND det_videoclase = $videoclase";
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
               $sql.= " AND vid_fecha_inicio BETWEEN '$fini 00:00:00' AND '$fini 23:59:59'";
          }
          $sql.= " GROUP BY device_id";
          $sql.= " ORDER BY vid_fecha_inicio ASC";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;
	}


	function get_lista_detalle_videoclase_secciones($videoclase,$pensum,$nivel,$grado,$seccion,$target = '',$tipo = '') {
          $target = trim($target);
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql= "SELECT * ";
          $sql.= " FROM app_videoclase, app_videoclase_detalle_secciones, academ_nivel, academ_grado, academ_secciones";
          $sql.= " WHERE niv_pensum = gra_pensum";
          $sql.= " AND niv_codigo = gra_nivel";
          $sql.= " AND sec_pensum = gra_pensum";
          $sql.= " AND sec_nivel = gra_nivel";
          $sql.= " AND sec_grado = gra_codigo";
          $sql.= " AND sec_pensum = det_pensum";
          $sql.= " AND sec_nivel = det_nivel";
          $sql.= " AND sec_grado = det_grado";
          $sql.= " AND sec_codigo = det_seccion";
          $sql.= " AND vid_codigo = det_videoclase";
          $sql.= " AND vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($videoclase)>0) {
               $sql.= " AND det_videoclase = $videoclase";
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
               $sql.= " AND vid_target = '$target'";
          }
          if(strlen($tipo)>0) {
               $sql.= " AND vid_tipo_target = '$tipo'";
          }

          $sql.= " ORDER BY vid_fecha_inicio ASC";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;

	}


    function get_codigos_secciones($pensum,$nivel = '',$grado = '',$seccion = ''){
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql = "SELECT vid_codigo as codigo";
          $sql.= " FROM app_videoclase_detalle_secciones, app_videoclase";
          $sql.= " WHERE vid_codigo = det_videoclase";
          $sql.= " AND vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";
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
          $sql.= " ORDER BY vid_fecha_inicio ASC, vid_codigo ASC";

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


    function get_codigos_videoclase_secciones($pensum,$alumno){
          $anio1 = date("Y");
          $anio2 = date("Y");
          $anio2++;

          $sql = "SELECT vid_codigo as codigo";
          $sql.= " FROM academ_seccion_alumno, app_videoclase_detalle_secciones, app_videoclase";
          $sql.= " WHERE vid_codigo = det_videoclase";
          $sql.= " AND seca_pensum = det_pensum";
          $sql.= " AND seca_nivel = det_nivel";
          $sql.= " AND seca_grado = det_grado";
          $sql.= " AND seca_seccion = det_seccion";
          $sql.= " AND vid_situacion = 1";
          $sql.= " AND YEAR(vid_fecha_inicio) BETWEEN $anio1 AND $anio2";

          if(strlen($alumno)>0) {
               $sql.= " AND seca_alumno = '$alumno'";
          }
          if(strlen($pensum)>0) {
               $sql.= " AND seca_pensum = $pensum";
          }
          $sql.= " ORDER BY vid_fecha_inicio ASC, vid_codigo ASC";

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


	function insert_det_videoclase_secciones($videoclase,$pensum,$nivel,$grado,$seccion){

          $sql = "INSERT INTO app_videoclase_detalle_secciones";
          $sql.= " VALUES ($videoclase,$pensum,$nivel,$grado,$seccion); ";
          //echo $sql;
          return $sql;
	}

	function delete_det_videoclase_secciones($videoclase){

          $sql = "DELETE FROM app_videoclase_detalle_secciones  ";
          $sql.= " WHERE det_videoclase = $videoclase; ";
          //echo $sql;
          return $sql;
	}


     /////////////// USUARIOS /////////////////////

     function get_usuario($usuario,$partener = '',$situacion = '') {
          $partener = trim($partener);

          $sql= "SELECT * ";
          $sql.= " FROM app_videoclase_usuarios";
          $sql.= " WHERE 1 = 1";
          if(strlen($usuario)>0) {
               $sql.= " AND vusu_usuario = $usuario";
          }
          if(strlen($partener)>0) {
               $sql.= " AND vusu_partner_id = '$partener'";
          }
          if(strlen($situacion)>0) {
               $sql.= " AND vusu_situacion = '$situacion'";
          }
          $sql.= " ORDER BY vusu_usuario ASC";

          $result = $this->exec_query($sql);
          //echo $sql;
          return $result;

     }

     function count_usuario($usuario,$partener = '',$situacion = '') {
          $partener = trim($partener);

          $sql= "SELECT COUNT(*) as total";
          $sql.= " FROM app_videoclase_usuarios";
          $sql.= " WHERE 1 = 1";
          if(strlen($usuario)>0) {
               $sql.= " AND vusu_usuario = $usuario";
          }
          if(strlen($partener)>0) {
               $sql.= " AND vusu_partner_id = '$partener'";
          }
          if(strlen($situacion)>0) {
               $sql.= " AND vusu_situacion = '$situacion'";
          }
          //echo $sql;
          $result = $this->exec_query($sql);
          foreach($result as $row){
               $total = $row['total'];
          }
          return $total;
     }

     function get_credentials($usuario){
          $sql= "SELECT vusu_partner_id, vusu_user_id, vusu_secret";
          $sql.= " FROM app_videoclase_usuarios";
          $sql.= " WHERE vusu_situacion = 1";
          $sql.= " AND vusu_usuario = $usuario";
          $result = $this->exec_query($sql);
          if(is_array($result)){
               $credenciales = array();
               foreach($result as $row){
                    $credenciales["partner"] = $row["vusu_partner_id"];
                    $credenciales["userid"] = $row["vusu_user_id"];
                    $credenciales["secret"] = $row["vusu_secret"];
               }
          }else{
               $credenciales = null;
          }
          //echo $sql;
          return $credenciales;
     }

     function insert_usuario($usuario,$partener,$userid,$secret){
          $partener = trim($partener);
          $userid = trim($userid);
          $secret = strtolower($secret);
          $freg = date("Y-m-d H:i:s");

          $sql = "INSERT INTO app_videoclase_usuarios";
          $sql.= " VALUES ($usuario,'$partener','$userid','$secret','$freg',1);";
          //echo $sql;
          return $sql;
     }

     function modifica_usuario($usuario,$partener,$userid,$secret){
          $partener = trim($partener);
          $userid = trim($userid);
          $secret = strtolower($secret);

          $sql = "UPDATE app_videoclase_usuarios SET ";
          $sql.= "vusu_partner_id = '$partener',";
          $sql.= "vusu_user_id = '$userid',";
          $sql.= "vusu_secret = '$secret'";

          $sql.= " WHERE vusu_usuario = $usuario";
          //echo $sql;
          return $sql;
     }

     function cambia_situacion_usuario($usuario,$sit){

          $sql = "UPDATE app_videoclase_usuarios SET ";
          $sql.= "vusu_situacion = $sit";

          $sql.= " WHERE vusu_usuario = $usuario";

          return $sql;
     }

     function max_usuario(){
          $sql = "SELECT max(vusu_usuario) as max ";
          $sql.= " FROM app_videoclase_usuarios";
          $result = $this->exec_query($sql);
          foreach($result as $row){
               $max = $row["max"];
          }
          //echo $sql;
          return $max;
     }

}

?>
