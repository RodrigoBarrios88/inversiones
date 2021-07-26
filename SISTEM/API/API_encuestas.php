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
		case "encuestas":
			$alumnos = $_REQUEST["alumnos"];
			API_encuestas($alumnos);
			break;
		case "encuesta":
			$codigo = $_REQUEST["codigo"];
			API_encuesta($codigo);
			break;
		case "preguntas":
			$encuesta = $_REQUEST["encuesta"];
			$persona = $_REQUEST["persona"];
			API_preguntas($encuesta,$persona);
			break;
		case "pregunta":
			$codigo = $_REQUEST["codigo"];
			$encuesta = $_REQUEST["encuesta"];
			$persona = $_REQUEST["persona"];
			API_pregunta($codigo,$encuesta,$persona);
			break;
		case "responder":
			$encuesta = $_REQUEST["encuesta"];
			$pregunta = $_REQUEST["pregunta"];
			$persona = $_REQUEST["persona"];
			$tipo = $_REQUEST["tipo"];
			$ponderacion = $_REQUEST["ponderacion"];
			$respuesta = $_REQUEST["respuesta"];
			API_responder_pregunta($encuesta,$pregunta,$persona,$tipo,$ponderacion,$respuesta);
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


function API_encuestas($alumnos){
	$ClsEnc = new ClsEncuesta();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	$arralumnos = array();
	$arralumnos = explode(",", $alumnos);
	$cantidad = count($arralumnos);
	
	$codigos = "";
	for($i = 0; $i <= $cantidad; $i ++){
		$alumno = $arralumnos[$i];
		if($alumno != ""){
			//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
			$codigos1 = $ClsEnc->get_codigos_encuestas_grados($pensum,$alumno);
			//////////////////////////////////////// GRUPOS //////////////////////////////////////
			$codigos2 = $ClsEnc->get_codigos_encuestas_grupos($alumno);
			//////////////////////////////////////// TODOS //////////////////////////////////////
			$codigos3 = $ClsEnc->get_codigos_encuestas_todos();
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
	}
	$codigos = substr($codigos, 0, -1);
	
	if($codigos != ""){
		//////////////////////////////////////// ESPECIFICOS //////////////////////////////////////
		$i = 0;
		$result = $ClsEnc->get_encuesta($codigos);
		if (is_array($result)) {
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["enc_codigo"];
                $arr_data[$i]['titulo'] = trim($row["enc_titulo"]);
				$arr_data[$i]['descripcion'] = trim($row["enc_descripcion"]);
				$feclimit = trim($row["enc_fecha_limite"]);
				$feclimit = cambia_fecha($feclimit);
				$arr_data[$i]['fecha_limite'];
				$i++;
			}
		}
		if($i <= 0){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
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



function API_encuesta($codigo){
	$ClsEnc = new ClsEncuesta();

	if($codigo != ""){
		$result = $ClsEnc->get_encuesta($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["enc_codigo"];
                $arr_data[$i]['titulo'] = trim($row["enc_titulo"]);
				$arr_data[$i]['descripcion'] = trim($row["enc_descripcion"]);
				$feclimit = trim($row["enc_fecha_limite"]);
				$feclimit = cambia_fecha($feclimit);
				$arr_data[$i]['fecha_limite'];
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}



function API_preguntas($encuesta,$persona){
	$ClsEnc = new ClsEncuesta();

	if($encuesta != ""){
		$result = $ClsEnc->get_pregunta('',$encuesta);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$codigo = $row["pre_codigo"];
				$arr_data[$i]['codigo'] = $row["pre_codigo"];
                $arr_data[$i]['descripcion'] = trim($row["pre_descripcion"]);
				$tipo = trim($row["pre_tipo"]);
				$tipo = intval($tipo);
				$arr_data[$i]['tipo'] = $tipo;
				$arr_data[$i]['cinco'] = ($tipo == 1)?true:false;
				$arr_data[$i]['vf'] = ($tipo == 2)?true:false;
				$arr_data[$i]['abierta'] = ($tipo == 3)?true:false;
				if($persona != ""){
					$result_respuesta = $ClsEnc->get_respuesta_directa($encuesta,$codigo,$persona);
					if(is_array($result_respuesta)){
						foreach ($result_respuesta as $row_respuesta){
							$arr_data[$i]['ponderacion'] = trim($row_respuesta["resp_ponderacion"]);
							$arr_data[$i]['respuesta'] = trim($row_respuesta["resp_respuesta"]);
						}	
					}else{
						$arr_data[$i]['ponderacion'] = '';
						$arr_data[$i]['respuesta'] = '';
					}
				}else{
					$arr_data[$i]['ponderacion'] = '';
					$arr_data[$i]['respuesta'] = '';
				}
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_pregunta($codigo,$encuesta,$persona){
	$ClsEnc = new ClsEncuesta();

	if($encuesta != "" && $codigo != ""){
		$result = $ClsEnc->get_pregunta($codigo,$encuesta);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["pre_codigo"];
                $arr_data[$i]['descripcion'] = trim($row["pre_descripcion"]);
				$tipo = trim($row["pre_tipo"]);
				$arr_data[$i]['tipo'] = trim($row["pre_tipo"]);
				if($persona != ""){
					$result_respuesta = $ClsEnc->get_respuesta_directa($encuesta,$codigo,$persona);
					if(is_array($result_respuesta)){
						foreach ($result_respuesta as $row_respuesta){
							$arr_data[$i]['ponderacion'] = trim($row_respuesta["resp_ponderacion"]);
							$arr_data[$i]['respuesta'] = trim($row_respuesta["resp_respuesta"]);
						}	
					}else{
						$arr_data[$i]['ponderacion'] = '';
					}
				}else{
					$arr_data[$i]['ponderacion'] = '';
				}
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}



function API_responder_pregunta($encuesta,$pregunta,$persona,$tipo='',$ponderacion,$respuesta=''){
	$ClsEnc = new ClsEncuesta();
	
	$tipo = ($tipo == "")?1:$tipo;
	$ponderacion = ($ponderacion == "")?0:$ponderacion;
	if($encuesta != "" && $pregunta != "" && $persona != "" && $tipo != "" && $ponderacion != ""){
		$sql = $ClsEnc->insert_respuesta($encuesta,$pregunta,$persona,$tipo,$ponderacion,$respuesta);
		$rs = $ClsEnc->exec_sql($sql);
		//echo $sql;
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Pregunta contestada correctamente!");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "No se ejecutó la sentencia correctamente...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}

