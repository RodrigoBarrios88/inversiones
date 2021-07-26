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
		case "secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$dpi_usuario = $_REQUEST["dpi_usuario"];
			API_lista_secciones($tipo_usuario,$dpi_usuario);
			break;
		case "grupos":
			$tipo_usuario = $_REQUEST["tipo"];
			$dpi_usuario = $_REQUEST["dpi_usuario"];
			API_lista_grupos($tipo_usuario,$dpi_usuario);
			break;
		case "calendario":
			$maestro = $_REQUEST["maestro"];
			API_calendario($maestro);
			break;
		case "actividades":
			$tipo_usuario = $_REQUEST["tipo"];
			$dpi_usuario = $_REQUEST["dpi_usuario"];
			API_lista_actividades($tipo_usuario,$dpi_usuario);
			break;
		case "actividad":
			$codigo = $_REQUEST["codigo"];
			API_detalle_actividad($codigo);
			break;
		case "nueva":
			$titulo = $_REQUEST["titulo"];
			$descripcion = $_REQUEST["descripcion"];
			$fecdesde = $_REQUEST["fecha_desde"];
			$hordesde = $_REQUEST["hora_desde"];
			$fechasta = $_REQUEST["fecha_hasta"];
			$horhasta = $_REQUEST["hora_hasta"];
			$target = $_REQUEST["target"]; // TODOS o SELECTIVO
			$tipo = $_REQUEST["tipo"]; // Dirigido a Secciones (1) o a Grupos (2)
			$link = $_REQUEST["link"];
			$secciones = $_REQUEST["secciones"]; //JSON Array
			$grupos = $_REQUEST["grupos"]; //JSON Array
			API_new_actividad($titulo,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$link,$secciones,$grupos);
			break;
		case "update":
			$codigo = $_REQUEST["codigo"];
			$titulo = $_REQUEST["titulo"];
			$descripcion = $_REQUEST["descripcion"];
			$fecdesde = $_REQUEST["fecha_desde"];
			$hordesde = $_REQUEST["hora_desde"];
			$fechasta = $_REQUEST["fecha_hasta"];
			$horhasta = $_REQUEST["hora_hasta"];
			$target = $_REQUEST["target"]; // TODOS o SELECTIVO
			$tipo = $_REQUEST["tipo"]; // Dirigido a Secciones (1) o a Grupos (2)
			$link = $_REQUEST["link"];
			$secciones = $_REQUEST["secciones"]; //JSON Array
			$grupos = $_REQUEST["grupos"]; //JSON Array
			API_update_actividad($codigo,$titulo,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$link,$secciones,$grupos);
			break;
		case "delete":
			$codigo = $_REQUEST["codigo"];
			API_delete_actividad($codigo);
			break;
		case "recordatorio":
			$codigo = $_REQUEST["codigo"];
			API_recordatorio_actividad($codigo);
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

function API_lista_secciones($tipo_usuario,$dpi_usuario){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($dpi_usuario != ""){
		if($tipo_usuario === "2"){
			$result = $ClsAcadem->get_seccion_maestro($pensum,'','','',$dpi_usuario,'','',1);
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
					$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
					$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
					$arr_data[$i]['grado_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['seccion_descripcion'] = trim($row["sec_descripcion"]);
					///------------------
					$i++;
				}
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No exsisten secciones enlazados a este maestro...");
					echo json_encode($arr_data);
			}
		}else if($tipo_usuario === "1"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$dpi_usuario);
			if(is_array($result)){
				$nivel = "";
				$grado = "";
				foreach($result as $row){
					$nivel.= $row["gra_nivel"].",";
					$grado.= $row["gra_codigo"].",";
				}
				$nivel = substr($nivel, 0, -1);
				$grado = substr($grado, 0, -1);
				$result = $ClsPen->get_seccion_IN($pensum,$nivel,$grado,'','',1);
				if (is_array($result)) {
					$i = 0;
					foreach($result as $row){
						$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
						$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
						$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
						$arr_data[$i]['grado_descripcion'] = trim($row["gra_descripcion"]);
						$arr_data[$i]['seccion_descripcion'] = trim($row["sec_descripcion"]);
						$i++;
					}
					echo json_encode($arr_data);
				}
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No exsisten secciones enlazados a esta autoridad...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario probablemente pertenece al grupo de padres...");
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



function API_lista_grupos($tipo_usuario,$dpi_usuario){
	$ClsAsi = new ClsAsignacion();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($dpi_usuario != ""){
		if($tipo_usuario === "2"){
			$result = $ClsAsi->get_maestro_grupo("",$dpi_usuario,1);
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['codigo'] = trim($row["gru_codigo"]);
					$arr_data[$i]['descripcion'] = trim($row["gru_nombre"]);
					///------------------
					$i++;
				}
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No exsisten grupos enlazados a este usuario...");
					echo json_encode($arr_data);
			}
		}else if($tipo_usuario === "1"){
			$result = $ClsAsi->get_usuario_grupo("",$dpi_usuario,1);
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['codigo'] = trim($row["gru_codigo"]);
					$arr_data[$i]['descripcion'] = trim($row["gru_nombre"]);
					///------------------
					$i++;
				}
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No exsisten grupos enlazados a este usuario...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario probablemente pertenece al grupo de padres...");
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



function API_lista_actividades($tipo_usuario,$dpi_usuario){
	$ClsInfo = new ClsInformacion();
	$ClsCal = new ClsCalendario();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($tipo_usuario == 2){ //// MAESTRO
		$maestro = $dpi_usuario;
		$result_secciones = $ClsAcad->get_seccion_maestro($pensum,'','','',$dpi_usuario,'','',1);
		if(is_array($result_secciones)){
			foreach($result_secciones as $row){
				$info_pensum.= $row["niv_pensum"].",";
				$info_nivel.= $row["niv_codigo"].",";
				$info_grado.= $row["gra_codigo"].",";
				$info_seccion.= $row["sec_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
			$info_seccion = substr($info_seccion,0,-1);
			//--
			$info_grupo = substr($info_grupo,0,-1);
			$valida = true;
		}
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result = $ClsAcad->get_grado_otros_usuarios($pensum,'','',$dpi_usuario);
		if(is_array($result)){
			foreach($result as $row){
				$info_pensum.= $row["gra_pensum"].",";
				$info_nivel.= $row["gra_nivel"].",";
				$info_grado.= $row["gra_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
			$valida = true;
		}
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$result = $ClsPen->get_grado($pensum,'','',1);
		if(is_array($result)){
			foreach($result as $row){
				$info_pensum.= $row["gra_pensum"].",";
				$info_nivel.= $row["gra_nivel"].",";
				$info_grado.= $row["gra_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
			$valida = true;
		}
	}else{
		$valida = false;
	}
	
	if($valida == true){
		$result = $ClsInfo->get_informacion('');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["inf_codigo"];
				$imagen = trim($row["inf_imagen"]);
				if(file_exists('../../CONFIG/Actividades/'.$imagen) && $imagen != ""){ /// valida que tenga foto registrada
					$arr_data[$i]['imagen'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]);
				}else{
					$arr_data[$i]['imagen'] =  "";
				}
				$url = trim($row["inf_link"]);
				$arr_data[$i]['link'] = $url;
				$arr_data[$i]['titulo'] = trim($row["inf_nombre"]);
				$arr_data[$i]['descripcion'] = trim($row["inf_descripcion"]);
				$fini = trim($row["inf_fecha_inicio"]);
				$ffin = trim($row["inf_fecha_fin"]);
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
			"message" => "No se registran secciones o grupos asignados...");
			echo json_encode($arr_data);
	}
}



function API_detalle_actividad($codigo){
	$ClsInfo = new ClsInformacion();
	
	if($codigo != ""){
		$result = $ClsInfo->get_informacion($codigo,"","","");
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["inf_codigo"];
				$imagen = trim($row["inf_imagen"]);
				if(file_exists('../../CONFIG/Actividades/'.$imagen) && $imagen != ""){ /// valida que tenga foto registrada
					$arr_data[$i]['imagen'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]);
				}else{
					$arr_data[$i]['imagen'] =  "";
				}
                $url = trim($row["inf_link"]);
				$arr_data[$i]['link'] = $url;
				$arr_data[$i]['titulo'] = trim($row["inf_nombre"]);
				$arr_data[$i]['descripcion'] = trim($row["inf_descripcion"]);
				$arr_data[$i]['target'] = trim($row["inf_target"]);
				$arr_data[$i]['tipo'] = trim($row["inf_tipo_target"]);
				$fini = trim($row["inf_fecha_inicio"]);
				$ffin = trim($row["inf_fecha_fin"]);
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
				//--
				$target = trim($row["inf_target"]);
				$tipo = trim($row["inf_tipo_target"]);
				$i++;
			}
			/////// Array de secciones
			$arr_secciones = array();
			$result = $ClsInfo->get_lista_detalle_informacion_secciones($codigo,'','','','');
			$j = 0;
			if(is_array($result)){
				foreach($result as $row){
					$arr_secciones[$j]["pensum"] = trim($row["niv_pensum"]);
					$arr_secciones[$j]["nivel"] = trim($row["niv_codigo"]);
					$arr_secciones[$j]["grado"] = trim($row["gra_codigo"]);
					$arr_secciones[$j]["seccion"] = trim($row["sec_codigo"]);
					$j++;
				}
			}
			$arr_data[$i]['secciones'] = $arr_secciones;
			
			/////// Array de grupos
			$arr_grupos = array();
			$result = $ClsInfo->get_lista_detalle_informacion_grupos($codigo,'');
			$j = 0;
			if(is_array($result)){
				foreach($result as $row){
					$arr_grupos[$j]["grupo"] = trim($row["gru_codigo"]);
					$j++;
				}
			}
			$arr_data[$i]['grupos'] = $arr_grupos;
			
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// GESTORES ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function API_new_actividad($titulo,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$link,$secciones,$grupos){
	$ClsInf = new ClsInformacion();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	// LIMPIA JSON
	$secciones = json_decode(stripslashes($secciones), true);
	$grupos = json_decode(stripslashes($grupos), true);
	//--
	$titulo = trim($titulo);
	$descripcion = trim($descripcion);
	//--------
	if($titulo != "" && $descripcion != ""){
		$sql = "";
		$codigo = $ClsInf->max_informacion();
		$codigo++; /// Maximo codigo
		$desde = "$fecdesde $hordesde";
		$hasta = "$fechasta $horhasta";
		$sql = $ClsInf->insert_informacion($codigo,$titulo,$descripcion,$desde,$hasta,$target,$tipo,"",$link); /// Inserta a tabla Maestra
		
		if($target == "SELECT"){
			if($tipo == 1){
				if(is_array($secciones)){
					foreach($secciones as $data){
						$nivel = trim($data["nivel"]);
						$grado = trim($data["grado"]);
						$seccion = trim($data["seccion"]);
						$sql.= $ClsInf->insert_det_informacion_secciones($codigo,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
					}
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "El array de secciones no tiene un formato válido...");
						echo json_encode($arr_data);
					return;
				}
			}else if($tipo == 2){
				if(is_array($grupos)){
					foreach($grupos as $data){
						$grupo = trim($data["grupo"]);
						$sql.= $ClsInf->insert_det_informacion_grupos($codigo,$grupo); /// Inserta detalle
					}
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "El array de grupos no tiene un formato válido...");
						echo json_encode($arr_data);
					return;
				}
			}
		}
		//echo "$sql <br><br>";
		$rs = $ClsInf->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"codigo" => $codigo,
				"message" => "Actividad creada satisfactoriamente....");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Algunos datos estan vacios");
			echo json_encode($arr_data);
	}
}


function API_update_actividad($codigo,$titulo,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$link,$secciones,$grupos){
	$ClsInf = new ClsInformacion();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	// LIMPIA JSON
	$secciones = json_decode(stripslashes($secciones), true);
	$grupos = json_decode(stripslashes($grupos), true);
	//--
	$titulo = trim($titulo);
	$descripcion = trim($descripcion);
	//--------
	if($titulo != "" && $descripcion != ""){
		$sql = "";
		$desde = "$fecdesde $hordesde";
		$hasta = "$fechasta $horhasta";
		$sql = $ClsInf->modifica_informacion($codigo,$titulo,$descripcion,$desde,$hasta,$link); /// Actualiza a tabla Actividades
		$sql.= $ClsInf->delete_det_informacion_grupos($codigo); //elimina detalles
		$sql.= $ClsInf->delete_det_informacion_secciones($codigo); //elimina detalles
		$sql.= $ClsInf->modifica_target_informacion($codigo,$target,$tipo); /// Actualiza Actividades
		
		if($target == "SELECT"){
			if($tipo == 1){
				if(is_array($secciones)){
					$i = 0;
					foreach($secciones as $data){
						$nivel = trim($data["nivel"]);
						$grado = trim($data["grado"]);
						$seccion = trim($data["seccion"]);
						$sql.= $ClsInf->insert_det_informacion_secciones($codigo,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
						$i++;
					}
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "El array de secciones no tiene un formato válido...");
						echo json_encode($arr_data);
					return;
				}
			}else if($tipo == 2){
				if(is_array($grupos)){
					$i = 0;
					foreach($grupos as $data){
						$grupo = trim($data["grupo"]);
						$sql.= $ClsInf->insert_det_informacion_grupos($codigo,$grupo); /// Inserta detalle
						$i++;
					}
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "El array de grupos no tiene un formato válido...");
						echo json_encode($arr_data);
					return;
				}
			}
		}
		//echo "$sql <br><br>";
		$rs = $ClsInf->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"codigo" => intval($codigo),
				"message" => "Actividad actualizada satisfactoriamente....");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Algunos datos estan vacios");
			echo json_encode($arr_data);
	}
	
}


function API_delete_actividad($codigo){
	$ClsInf = new ClsInformacion();
	if($codigo != ""){
		$sql = "";
		$sql.= $ClsInf->delete_det_informacion_grupos($codigo); //elimina detalles
		$sql.= $ClsInf->delete_det_informacion_secciones($codigo); //elimina detalles
		$sql.= $ClsInf->delete_informacion($codigo);
		$rs = $ClsInf->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Actividad eliminada satisfactoriamente....");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
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


function API_recordatorio_actividad($codigo){
	$ClsInfo = new ClsInformacion();
	$ClsPush = new ClsPushup();
	if($codigo != ""){
		$result = $ClsInfo->get_informacion($codigo);
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["inf_codigo"];
				$titulo = trim($row["inf_nombre"]);
				//--
				$desde = $row["inf_fecha_inicio"];
				$desde = cambia_fechaHora($desde);
				$fecini = substr($desde,0,10);
				$horini = substr($desde,11,18);
				//--
				$hasta = $row["inf_fecha_fin"];
				$hasta = cambia_fechaHora($hasta);
				$fecfin = substr($hasta,0,10);
				$horfin = substr($hasta,11,18);
				//
				$target = trim($row["inf_target"]);
				$tipo_target = trim($row["inf_tipo_target"]);
			}
		}
		if($target == "SELECT"){
			if($tipo_target == 1){
				$pensum = $_SESSION["pensum"];
				$result = $ClsInfo->get_det_informacion_secciones($codigo,'','','','');
				if(is_array($result)){
					foreach($result as $row){
						$pensum = $row["niv_pensum"];
						$nivel = $row["niv_codigo"];
						$grado = $row["gra_codigo"];
						$seccion = $row["sec_codigo"];
						$arrnivel.= ($nivel == 0)?"":$nivel.",";
						$arrgrado.= ($grado == 0)?"":$grado.",";
						$arrseccion.= ($seccion == 0)?"":$seccion.",";
					}
				}
				$arrnivel = substr($arrnivel,0,-1);
				$arrgrado = substr($arrgrado,0,-1);
				$arrseccion = substr($arrseccion,0,-1);
				$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,$arrnivel,$arrgrado,$arrseccion);
			}else if($tipo_target == 2){	
				$result = $ClsInfo->get_det_informacion_grupos($codigo,'');
				if(is_array($result)){
					foreach($result as $row){
						$grupo = $row["det_grupo"];
						$arrgrupo.= $grupo.",";
					}
				}
				$arrgrupo = substr($arrgrupo,0,-1);
				$result_push = $ClsPush->get_grupos_users($arrgrupo);
			}
		}else{
			$pensum = $_SESSION["pensum"];
			$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,'','','');
		}
		/// Inserta notificaciones
		if(is_array($result_push)) {
			$title = 'Recordatorio';
			$message = "Recordatorio: $titulo ($fecini $horini)";
			$message = depurador_texto($message);
			$push_tipo = 3;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			foreach ($result_push as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			}
		}
		
		$rs = $ClsInfo->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Recordatorio ejecutado satisfactoriamente....");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
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
