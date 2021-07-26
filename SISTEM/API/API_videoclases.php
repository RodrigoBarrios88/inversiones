<?php
ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);
//--
include_once('html_fns_api.php');
include_once('../../CONFIG/videoclases/kaltura.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "hijos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_hijos($tipo_usuario,$tipo_codigo);
			break;
		case "videoclases":
			$alumno = $_REQUEST["alumno"];
			API_videoclases($alumno);
			break;
		case "historial":
			$alumno = $_REQUEST["alumno"];
			API_historial($alumno);
			break;
		default:
			$arr_data = array(
			"status" => "error",
			"message" => "Parametros invalidos...");
			echo json_encode($arr_data);
			break;
	}
}else{
	//devuelve un mensaje de manejo de errores
	$arr_data = array(
		"status" => "error",
		"message" => "Delimite el tipo de consulta a realizar...");
		echo json_encode($arr_data);
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// FUNCIONES Y CONSULTAS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function API_lista_hijos($tipo_usuario,$tipo_codigo){
	$ClsAsi = new ClsAsignacion();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "3"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$cui = $row["alu_cui"];
					$arr_data[$i]['cui'] = $row["alu_cui"];
					$arr_data[$i]['tipo_cui'] = $row["alu_tipo_cui"];
					$arr_data[$i]['nombre'] = trim($row["alu_nombre"]);
					$arr_data[$i]['apellido'] = trim($row["alu_apellido"]);
					$arr_data[$i]['fecha_nacimiento'] = cambia_fecha($row["alu_fecha_nacimiento"]);
					$arr_data[$i]['edad'] = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
					$arr_data[$i]['genero'] = $row["alu_genero"];
					//--
					$foto = $row["alu_foto"];
					if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
					}
					///------------------
					$result_grado_alumno = $ClsAcad->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);  ////// este array se coloca en la columna de combos
					if(is_array($result_grado_alumno)){
						$j = 0;
						foreach($result_grado_alumno as $row_grado_alumno){
							$arr_grados[$j]['pensum'] = $row_grado_alumno["seca_pensum"];
							$arr_grados[$j]['nivel'] = $row_grado_alumno["seca_nivel"];
							$arr_grados[$j]['grado'] = $row_grado_alumno["seca_grado"];
							$arr_grados[$j]['seccion'] = $row_grado_alumno["seca_seccion"];
							$j++;
						}
						$arr_data[$i]['seccion'] = $arr_grados;
					}
					///------------------
					$result_grupo_alumno = $ClsAsi->get_alumno_grupo('',$cui,1);  ////// este array se coloca en la columna
					if(is_array($result_grupo_alumno)){
						$j = 0;
						foreach($result_grupo_alumno as $row_grupo_alumno){
							$arr_grupos[$j]['grupo'] = $row_grupo_alumno["gru_nombre"];
							//--
							$arr_grupos[$j]['area_codigo'] = $row_grupo_alumno["gru_area"];
							$arr_grupos[$j]['segmento_codigo'] = $row_grupo_alumno["gru_segmento"];
							$arr_grupos[$j]['grupo_codigo'] = $row_grupo_alumno["gru_codigo"];
							$j++;
						}
						$arr_data[$i]['grupos'] = $arr_grupos;
					}
					$i++;
				}
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No exsisten hijos enlazados a este papa...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de padres...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_videoclases($alumno){
	$ClsVid = new ClsVideoclase();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	$pensum = $ClsPen->get_pensum_activo();
	//--
	$result = $ClsAlu->get_alumno($alumno,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nombre_alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
			$nombres = ucwords(strtolower($nombre_alumno));
			$nombre_alumno = depurador_texto($nombre_alumno);
			$cui = trim($row["alu_cui"]);
		}	
	}
	
	$codigos = "";
	if($alumno != ""){
		//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
		$codigos1 = $ClsVid->get_codigos_videoclase_secciones($pensum,$alumno);
		//////////////////////////////////////// GRUPOS //////////////////////////////////////
		$codigos2 = $ClsVid->get_codigos_videoclase_grupos($alumno);
		//////////////////////////////////////// TODOS //////////////////////////////////////
		$codigos3 = $ClsVid->get_codigos_videoclase_todos();
		//////////////////////////////////////// --- ////////////////////////////////////////
		if($codigos1 != ""){
			$codigos.= $codigos1.",";
		}
		if($codigos2 != ""){
			$codigos.= $codigos2.",";
		}
		if($codigos3 != ""){
			$codigos.= $codigos3.",";
		}
	}
	$codigos = substr($codigos, 0, -1);
	if($codigos != ""){
		//////////////////////////////////////// ESPECIFICOS //////////////////////////////////////
		$i = 0;	
		$result = $ClsVid->get_videoclase($codigos);
		if (is_array($result)) {
			foreach ($result as $row){
				$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
				//fecha inicia
				$fini = trim($row["vid_fecha_inicio"]);
				$fecha_1 = strtotime($fini);
				$fini = cambia_fechaHora($fini);
				//fecha finaliza
				$ffin = trim($row["vid_fecha_fin"]);
				$fecha_2 = strtotime($ffin);
				$ffin = cambia_fechaHora($ffin);
				////--------------
				if(($fecha_actual <= $fecha_2)){
					if(($fecha_actual >= $fecha_1) && ($fecha_actual <= $fecha_2)){
						$status = 'encurso';
					}else{
						$status = 'pendiente';
					}
					$arr_data[$i]['codigo'] = $row["vid_codigo"];
					$arr_data[$i]['status'] = $status;
					////--------------
					$plataforma = trim($row["vid_plataforma"]);
					$link = trim($row["vid_link"]);
					if($plataforma == "ASMS Videoclass"){
						$partnerid = $row["vid_partnerId"];
						$eventId = $row["vid_event"];
						$result = kaltura_session($partnerid,$secret,$eventId, 3, $cui, $nombre_alumno, "(Padre)");
						if($result["status"] == 1){
							$token = $result["token"][0];
							$enlace = "https://$partnerid.kaf.kaltura.com/virtualEvent/launch?ks=$token";
						}
					}else{
						$enlace = $link;
					}
					$arr_data[$i]['plataforma'] = $plataforma;
					$arr_data[$i]['enlace'] = $enlace;
					
					$arr_data[$i]['titulo'] = trim($row["vid_nombre"]);
					$arr_data[$i]['descripcion'] = trim($row["vid_descripcion"]);
					$fini = trim($row["vid_fecha_inicio"]);
					$ffin = trim($row["vid_fecha_fin"]);
					//--				
					$fechaini = explode(" ",$fini);
					$fini = cambia_fecha($fechaini[0]);
					$arr_data[$i]['fecha_inicio'] = $fini;
					$arr_data[$i]['hora_inicio'] = substr($fechaini[1], 0, -3);
					//--
					$fechafin = explode(" ",$ffin);
					$fini = cambia_fecha($fechafin[0]);
					$arr_data[$i]['fecha_final'] = $fini;
					$arr_data[$i]['hora_final'] = substr($fechafin[1], 0, -3);
					//
					if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
					}else{
						$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
					}
					$i++;
				}	
			}
		}
		if($i <= 0){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
				echo json_encode($arr_data);
		}else{
			echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No se registran datos...");
			echo json_encode($arr_data);
	}
	
}



function API_historial($alumno){
	$ClsVid = new ClsVideoclase();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	$pensum = $ClsPen->get_pensum_activo();
	//--
	$result = $ClsAlu->get_alumno($alumno,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nombre_alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
			$nombres = ucwords(strtolower($nombre_alumno));
			$nombre_alumno = depurador_texto($nombre_alumno);
			$cui = trim($row["alu_cui"]);
		}	
	}
	
	$codigos = "";
	if($alumno != ""){
		//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
		$codigos1 = $ClsVid->get_codigos_videoclase_secciones($pensum,$alumno);
		//////////////////////////////////////// GRUPOS //////////////////////////////////////
		$codigos2 = $ClsVid->get_codigos_videoclase_grupos($alumno);
		//////////////////////////////////////// TODOS //////////////////////////////////////
		$codigos3 = $ClsVid->get_codigos_videoclase_todos();
		//////////////////////////////////////// --- ////////////////////////////////////////
		if($codigos1 != ""){
			$codigos.= $codigos1.",";
		}
		if($codigos2 != ""){
			$codigos.= $codigos2.",";
		}
		if($codigos3 != ""){
			$codigos.= $codigos3.",";
		}
	}
	$codigos = substr($codigos, 0, -1);
	if($codigos != ""){
		//////////////////////////////////////// ESPECIFICOS //////////////////////////////////////
		$i = 0;	
		$result = $ClsVid->get_videoclase($codigos);
		if (is_array($result)) {
			foreach ($result as $row){
				$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
				//fecha inicia
				$fini = trim($row["vid_fecha_inicio"]);
				$fecha_1 = strtotime($fini);
				$fini = cambia_fechaHora($fini);
				//fecha finaliza
				$ffin = trim($row["vid_fecha_fin"]);
				$fecha_2 = strtotime($ffin);
				$ffin = cambia_fechaHora($ffin);
				////--------------
				if(($fecha_actual > $fecha_2)){
					$arr_data[$i]['codigo'] = $row["vid_codigo"];
					////--------------
					$plataforma = trim($row["vid_plataforma"]);
					$link = trim($row["vid_link"]);
					if($plataforma == "ASMS Videoclass"){
						$partnerid = $row["vid_partnerId"];
						$eventId = $row["vid_event"];
						//$result = kaltura_session($eventId, 3, $cui, $nombre_alumno, "(Padre)");
						if($result["status"] == 1){
							$token = $result["token"][0];
							$enlace = "https://$partnerid.kaf.kaltura.com/virtualEvent/launch?ks=$token";
						}else{
							$enlace = "https://$partnerid.kaf.kaltura.com/virtualEvent/launch?ks=[pendiente]";
						}
					}else{
						$enlace = $link;
					}
					$arr_data[$i]['plataforma'] = $plataforma;
					$arr_data[$i]['enlace'] = $enlace;
					
					$arr_data[$i]['titulo'] = trim($row["vid_nombre"]);
					$arr_data[$i]['descripcion'] = trim($row["vid_descripcion"]);
					//
					if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
					}else{
						$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
					}
					$i++;
				}	
			}
		}
		if($i <= 0){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos..."
			);
				echo json_encode($arr_data);
		}else{
			echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No se registran datos...");
			echo json_encode($arr_data);
	}
	
}


?>