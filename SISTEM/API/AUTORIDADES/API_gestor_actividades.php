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
//Push Notifications
include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "calendario":
			$maestro = $_REQUEST["maestro"];
			API_calendario($maestro);
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




function API_calendario($dpi_usuario){
	$ClsUsu = new ClsUsuario();
	$ClsAcad = new ClsAcademico();
	$ClsAsi = new ClsAsignacion();
	$ClsInfo = new ClsInformacion();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	//--
	$arralumnos = array();
	$arralumnos = explode(",", $alumnos);
	$cantidad = count($arralumnos);
	
	if($dpi_usuario != ""){
		$result = $ClsUsu->get_usuario_tipo_codigo('',$dpi_usuario);
		if(is_array($result)) {
			foreach ($result as $row){
				if($row["usu_tipo"] == 1 || $row["usu_tipo"] == 2){
					$tipo_usuario = $row["usu_tipo"];
				}
			}	
		}
		
		/////// TRAES POSTITS
		$codigos = '';
		if($tipo_usuario == 1){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcad->get_grado_otros_usuarios($pensum,'','',$cui_usuario);
			if(is_array($result)){
				$nivel = "";
				$grado = "";
				foreach($result as $row){
					$nivel = $row["gra_nivel"];
					$grado = $row["gra_codigo"];
					$Codes = $ClsInfo->get_codigos_secciones($pensum,$nivel,$grado,'');
					$codigos.= ($Codes != "")?$Codes.",":"";
				}
			}
			
			$result = $ClsAsi->get_usuario_grupo("",$cui_usuario,1);
			if(is_array($result)){
			   $grupos = "";
			   foreach($result as $row){
				  $grupos = $row["gru_codigo"];
				  $Codes = $ClsInfo->get_codigos_grupos($grupos);
				  $codigos.= ($Codes != "")?$Codes.",":"";
			   }
			}
			
			$codigos = substr($codigos, 0, -1);
		}else if($tipo_usuario == 2){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcad->get_seccion_maestro($pensum,'','','',$cui_usuario);
			if(is_array($result)){
				$nivel = "";
				$grado = "";
				$seccion = "";
				foreach($result as $row){
					$nivel = $row["sec_nivel"];
					$grado = $row["sec_grado"];
					$seccion = $row["sec_codigo"];
					$Codes = $ClsInfo->get_codigos_secciones($pensum,$nivel,$grado,$seccion);
					$codigos.= ($Codes != "")?$Codes.",":"";
				}
			}
			
			$result = $ClsAsi->get_maestro_grupo("",$cui_usuario,1);
			if(is_array($result)){
			   $grupos = "";
			   foreach($result as $row){
				  $grupos = $row["gru_codigo"];
				  $Codes = $ClsInfo->get_codigos_grupos($grupos);
				  $codigos.= ($Codes != "")?$Codes.",":"";
			   }
			}
			
			$codigos = substr($codigos, 0, -1);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece a este perfil...");
				echo json_encode($arr_data);
			return;
		}
		
		$i = 0;	
		$result = $ClsInfo->get_informacion($codigos);
		if (is_array($result)) {
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["inf_codigo"];
				$arr_data[$i]['imagen'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]);
				$url = trim($row["inf_link"]);
				$arr_data[$i]['link'] = $url;
				///------
				$arr_data[$i]['text'] = "<strong>".trim($row["inf_nombre"])."</strong><br>".trim($row["inf_descripcion"]);
				$fini = trim($row["inf_fecha_inicio"]);
				$ffin = trim($row["inf_fecha_fin"]);
				//--				
				$fechaini = explode(" ",$fini);
				$fini = trim($fechaini[0])."T".trim($fechaini[1]).".000Z";
				$arr_data[$i]['start'] = $fini;
				//--
				$fechafin = explode(" ",$ffin);
				$fini = trim($fechafin[0])."T".trim($fechafin[1]).".000Z";
				$arr_data[$i]['end'] = $fini;
				//--
				$arr_data[$i]['color'] = "#3777B7";
				//
				if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				}else{
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
				}
				///---
				$i++;
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
			return;
		}
		
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
}


	

