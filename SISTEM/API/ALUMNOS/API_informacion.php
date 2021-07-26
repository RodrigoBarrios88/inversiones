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
		case "baner":
			$alumnos = $_REQUEST["alumnos"];
			API_baner($alumnos);
			break;
		case "informacion":
			$alumnos = $_REQUEST["alumnos"];
			API_informacion($alumnos);
			break;
		case "detalle_informacion":
			$codigo = $_REQUEST["codigo"];
			API_detalle_informacion($codigo);
			break;
		case "multimedia":
			$tipo = $_REQUEST["tipo"]; // no obligatorio
			$categoria = $_REQUEST["categoria"]; // no obligatorio
			$ordenado_por = $_REQUEST["orden"]; // no obligatorio
			$page = $_REQUEST["page"]; //opcional
			API_multimedia($tipo, $categoria, $ordenado_por,$page);
			break;
		case "detalle_multimedia":
			$codigo = $_REQUEST["codigo"];
			API_detalle_multimedia($codigo);
			break;
		case "suma_vista":
			$codigo = $_REQUEST["codigo"];
			API_suma_vista_multimedia($codigo);
			break;
		case "pinboard":
			$alumnos = $_REQUEST["alumnos"];
			$page = $_REQUEST["page"]; //opcional
			API_pinboard($alumnos,$page);
			break;
		case "detalle_pinboard":
			$codigo = $_REQUEST["codigo"];
			API_detalle_pinboard($codigo);
			break;
		case "circulares":
			$alumnos = $_REQUEST["alumnos"];
			$persona = $_REQUEST["pdi_usuario"];
			$page = $_REQUEST["page"]; //opcional
			API_circulares($alumnos,$persona,$page);
			break;
		case "circular":
			$codigo = $_REQUEST["codigo"];
			$persona = $_REQUEST["pdi_usuario"];
			API_circular($codigo,$persona);
			break;
		case "circular_autorizacion":
			$codigo = $_REQUEST["codigo"];
			$persona = $_REQUEST["pdi_usuario"];
			$autorizacion = $_REQUEST["autorizacion"];
			API_circular_autorizacion($codigo,$persona,$autorizacion);
			break;
		case "alumno":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_alumno($tipo_usuario,$tipo_codigo);
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


function API_baner($alumnos){
	$ClsInfo = new ClsInformacion();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	//--
	$arralumnos = array();
	$arralumnos = explode(",", $alumnos);
	$cantidad = count($arralumnos);
	
	$codigos = "";
	for($i = 0; $i <= $cantidad; $i ++){
		$alumno = $arralumnos[$i];
		if($alumno != ""){
			//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
			$codigos1 = $ClsInfo->get_codigos_informacion_secciones($pensum,$alumno);
			//////////////////////////////////////// GRUPOS //////////////////////////////////////
			$codigos2 = $ClsInfo->get_codigos_informacion_grupos($alumno);
			//////////////////////////////////////// TODOS //////////////////////////////////////
			$codigos3 = $ClsInfo->get_codigos_informacion_todos();
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
		$hoy = date("Y-m-d H:i:s");
		$i = 0;	
		$result = $ClsInfo->get_informacion($codigos);
		if (is_array($result)) {
			foreach ($result as $row){
				$fecha = trim($row["inf_fecha_fin"]);
				$compara = comparaFechas($fecha, $hoy);
				if(trim($row["inf_imagen"]) != "" && $compara != 2){
					$arr_data[$i]['codigo'] = $row["inf_codigo"];
					$arr_data[$i]['imagen'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]);
					$url = trim($row["inf_link"]);
					$arr_data[$i]['link'] = $url;
					/*if (preg_match('#^(https?://|www\.)#i', $url) === 1){
						$arr_data[$i]['link'] = $url;
					} else {
						$arr_data[$i]['link'] = "";
					}*/
					$arr_data[$i]['ics'] = "https://" . $_SERVER['HTTP_HOST'] ."/SISTEM/API/API_ICScalendario.php?codigo=".trim($row["inf_codigo"]);
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


function API_informacion($alumnos){
	$ClsInfo = new ClsInformacion();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	//--
	$arralumnos = array();
	$arralumnos = explode(",", $alumnos);
	$cantidad = count($arralumnos);
	
	$codigos = "";
	for($i = 0; $i <= $cantidad; $i ++){
		$alumno = $arralumnos[$i];
		if($alumno != ""){
			//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
			$codigos1 = $ClsInfo->get_codigos_informacion_secciones($pensum,$alumno);
			//////////////////////////////////////// GRUPOS //////////////////////////////////////
			$codigos2 = $ClsInfo->get_codigos_informacion_grupos($alumno);
			//////////////////////////////////////// TODOS //////////////////////////////////////
			$codigos3 = $ClsInfo->get_codigos_informacion_todos();
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
		$result = $ClsInfo->get_informacion($codigos);
		if (is_array($result)) {
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["inf_codigo"];
				$arr_data[$i]['imagen'] = ($row["inf_imagen"] != "")?"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]):"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/baner_actividad.png";
				$url = trim($row["inf_link"]);
				$arr_data[$i]['link'] = $url;
				/*if (preg_match('#^(https?://|www\.)#i', $url) === 1){
					$arr_data[$i]['link'] = $url;
				} else {
					$arr_data[$i]['link'] = "";
				}*/
				$arr_data[$i]['ics'] = "https://" . $_SERVER['HTTP_HOST'] ."/SISTEM/API/API_ICScalendario.php?codigo=".trim($row["inf_codigo"]);
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

function API_detalle_informacion($codigo){
	$ClsInfo = new ClsInformacion();
	
	if($codigo != ""){
		$result = $ClsInfo->get_informacion($codigo,"","","");
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["inf_codigo"];
                $arr_data[$i]['imagen'] = ($row["inf_imagen"] != "")?"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Actividades/".trim($row["inf_imagen"]):"https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/baner_actividad.png";
				$url = trim($row["inf_link"]);
				$arr_data[$i]['link'] = $url;
				/*if (preg_match('#^(https?://|www\.)#i', $url) === 1){
					$arr_data[$i]['link'] = $url;
				} else {
					$arr_data[$i]['link'] = "";
				}*/
				$arr_data[$i]['ics'] = "https://" . $_SERVER['HTTP_HOST'] ."/SISTEM/API/API_ICScalendario.php?codigo=".trim($row["inf_codigo"]);
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
				//--
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


///////////--------------
function API_multimedia($tipo, $categoria, $ordenado_por,$page = ''){
	$ClsMulti = new ClsMultimedia();
	////////////////// PAGES //////////////////
	if($page != ""){
		$limit1 = 1;
		$limit2 = 1;
		if($page == 0){
			$limit1 = 0;
			$limit2 = 10;
		}else{
			$limit1 = $page * 10;
			$limit2 = 10;
		}
	}else{
		$limit1 = 0;
		$limit2 = 10;
	}
	$result = $ClsMulti->get_multimedia($codigo,$tipo, $categoria, $ordenado_por,$limit1,$limit2);
	if (is_array($result)) {
		$i = 0;	
		foreach ($result as $row){
			$arr_data[$i]['codigo'] = $row["multi_codigo"];
			$arr_data[$i]['video'] =  trim($row["multi_link"]);
			$arr_data[$i]['titulo'] = trim($row["multi_titulo"]);
			//--
			$tipo = trim($row["multi_tipo"]);
			switch($tipo){
				case 0: $tipo = "OTRO"; break;
				case 1: $tipo = "EDUCATIVO Y/O PEDAGÓGICO"; break;
				case 2: $tipo = "MOTIVACIONAL"; break;
				case 3: $tipo = "INTERESANTE"; break;
			}
			$arr_data[$i]['tipo'] = $tipo;
			$categoria = trim($row["multi_categoria"]);
			switch($categoria){
				case 0: $categoria = "OTROS"; break;
				case 1: $categoria = "PARA PADRES"; break;
				case 2: $categoria = "PARA ALUMNOS"; break;
				case 3: $categoria = "ACTIVIDADES INTERNAS"; break;
			}
			$arr_data[$i]['categoria'] = $categoria;
			//
			if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
				$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
			}else{
				$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
			}
			//--
			//--
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
}


function API_detalle_multimedia($codigo){
	$ClsMulti = new ClsMultimedia();

	if($codigo != ""){
		$result = $ClsMulti->get_multimedia($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["multi_codigo"];
                $arr_data[$i]['video'] =  trim($row["multi_link"]);
				$arr_data[$i]['titulo'] = trim($row["multi_titulo"]);
				//--
				$tipo = trim($row["multi_tipo"]);
				switch($tipo){
					case 0: $tipo = "OTRO"; break;
					case 1: $tipo = "EDUCATIVO Y/O PEDAGÓGICO"; break;
					case 2: $tipo = "MOTIVACIONAL"; break;
					case 3: $tipo = "INTERESANTE"; break;
				}
				$arr_data[$i]['tipo'] = $tipo;
				$categoria = trim($row["multi_tipo"]);
				switch($categoria){
					case 0: $categoria = "OTROS"; break;
					case 1: $categoria = "PARA PADRES"; break;
					case 2: $categoria = "PARA ALUMNOS"; break;
					case 3: $categoria = "ACTIVIDADES INTERNAS"; break;
				}
				$arr_data[$i]['categoria'] = $categoria;
				//
				if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				}else{
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
				}
				//--
				//--
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


function API_suma_vista_multimedia($codigo){
	$ClsMulti = new ClsMultimedia();

	if($codigo != ""){
		$sql = $ClsMulti->contador_multimedia($codigo);
		$rs = $ClsMulti->exec_sql($sql);
		if($rs == 1){
			$arr_data = array(
				"status" => "success",
				"message" => "vista sumada exitosamente....");
				echo json_encode($arr_data);
		}else{
			$arr_data = array(
				"status" => "error",
				"message" => "error de transacción... (error en la ejecución de la sumatoria de vistas)");
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




function API_pinboard($alumnos, $page = ''){
	$ClsPost = new ClsPostit();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	$arr_colores = array("color1", "color2", "color3", "color4", "color5", "color6", "color7", "color8", "color9", "color10");
	
	$arralumnos = array();
	$arralumnos = explode(",", $alumnos);
	$cantidad = count($arralumnos);
	
	//echo $alumnos;
	if ($alumnos != "") {
		$coloresAlumnos = array();
		for($i = 0; $i <= $cantidad; $i ++){
			$alumno = $arralumnos[$i];
			if($alumno != ""){
				$coloresAlumnos["$alumno"] = $arr_colores[$i];
			}
		}
		//echo $alumnos;
		///////////// Códigos con target especifico //////////
		$codigos = '';
		$codigos = $ClsPost->get_postit_codigos('',$pensum,'','','','','',$alumnos,'','',1);
		$codigos = ($codigos == '')?'0':$codigos;
		
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
		return;
	}
		
	if ($codigos != "") {
		////////////////// PAGES //////////////////
		if($page != ""){
			$limit1 = 1;
			$limit2 = 1;
			if($page == 0){
				$limit1 = 0;
				$limit2 = 10;
			}else{
				$limit1 = $page * 10;
				$limit2 = 10;
			}
		}else{
			$limit1 = 0;
			$limit2 = 10;
		}
		///////////////////////////////////////
		$x = 0;
		$i = 0;
		$vueltas_totales = 0;
		$result = $ClsPost->get_postit_limit($codigos,$limit1,$limit2);
		$fechaRepetida = '';
		$arr_data = array();
		//print_r($result)."<br><br>";
		if(is_array($result)){
			foreach ($result as $row){
				////////////////// AGRUPA OBJETO POR FECHAS ///////////////////////
				$fecha = trim($row["post_fecha_registro"]);
				$fecha = cambia_fechaHora($fecha);
				$fecha = substr($fecha,0,-9); //quita la hora
				$fecha = trim($fecha); //limpia cadenas
				$fecha = str_replace(" ","",$fecha);
				if($vueltas_totales == 0){ /// Iguala fechas en la primer vuelta de todos los ciclos
					$date_postit = array();
					$fechaRepetida = $fecha;
				}
				if($fechaRepetida != $fecha){
					$arr_data[$x]["date_postit"] = $date_postit;
					$date_postit = array();
					$fechaRepetida = $fecha;
					$i = ($i > 0)?0:$i;
					$x++;
				}else{
					//Aplicara si y solo si X = 0 //solo hay varios postits de un único día
					$arr_unico_dia = array();
					$arr_unico_dia[$x]["date_postit"] = $date_postit;
				}
				////////////////////////////////////////////////////////////////
				$date_postit[$i]['date_grupo'] = $fecha;
				$publicacion = trim($row["post_fecha_registro"]);
				$ahora = date("Y-m-d H:i:s");
				$dias = restaFechas($publicacion, $ahora);
				$star = ($dias == 0)?"⭐  ":""; //valida se el postiti es del dia de hoy
				$date_postit[$i]['codigo'] = $row["post_codigo"];
				$grado = trim($row["post_grado_desc"]);
				$seccion = trim($row["post_seccion_desc"]);
				$date_postit[$i]['seccion'] =  $grado.' '.$seccion;
				//$date_postit[$i]['materia'] = trim($row["post_materia_desc"]);
				$target_nombre = trim($row["post_target_nombre"]);
				$target = ($target_nombre != "")?$target_nombre:"Todos";
				$date_postit[$i]['target'] = $target;
				$date_postit[$i]['target_codigo'] = trim($row["post_target"]);
				$date_postit[$i]['maestro'] = trim($row["post_maestro_nombre"]);
				$date_postit[$i]['maestro_cui'] = trim($row["post_maestro"]);
				$date_postit[$i]['titulo'] = $star." ".trim($row["post_titulo"]);
				$date_postit[$i]['descripcion'] = trim($row["post_descripcion"]);
				$freg = $row["post_fecha_registro"];
				$date_postit[$i]['fecha'] = cambia_fechaHora($freg);
				//--
				$cui = trim($row["post_target"]);
				$date_postit[$i]['color'] = $coloresAlumnos["$cui"];
				//
				$i++;
				$vueltas_totales++;
			}
			if($vueltas_totales == 1){ // Si solo hay uno, agrega el postit al array
				//Aplicara si y solo si $vueltas_totales = 1 //solo hay un único postits sin importar el día
			    $arr_data[$x]["date_postit"] = $date_postit;
			}
			if($x == 0){ // Si solo hay un dia (sin importar la cantidad de postit)
				//Aplicara si y solo si X = 0 //solo hay varios postits de un único día
			    $arr_data = $arr_unico_dia;
			}
		    echo json_encode($arr_data);
		}else{
		    //devuelve un mensaje de manejo de errores
    		$arr_data = array(
    			"status" => "vacio",
    			"message" => "NO hay postit para este (estos) alumnos...");
    			echo json_encode($arr_data);
		}
	} else {
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "Estamos trabajando en este momento, pronto estará listo...");
			echo json_encode($arr_data);
	}
}


function API_detalle_pinboard($codigo){
	$ClsPost = new ClsPostit();
	if($codigo != ""){
		$result = $ClsPost->get_postit($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$publicacion = trim($row["post_fecha_registro"]);
				$ahora = date("Y-m-d H:i:s");
				$dias = restaFechas($publicacion, $ahora);
				$star = ($dias == 0)?"⭐  ":""; //valida se el postiti es del dia de hoy
				$arr_data[$i]['codigo'] = $row["post_codigo"];
				$grado = trim($row["post_grado_desc"]);
				$seccion = trim($row["post_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$target_nombre = trim($row["post_target_nombre"]);
				$target = ($target_nombre != "")?$target_nombre:"Todos";
				$arr_data[$i]['target'] = $target;
				$arr_data[$i]['target_codigo'] = trim($row["post_target"]);
				$arr_data[$i]['maestro'] = trim($row["post_maestro_nombre"]);
				$arr_data[$i]['maestro_cui'] = trim($row["post_maestro"]);
				$arr_data[$i]['titulo'] = $star." ".trim($row["post_titulo"]);
				$arr_data[$i]['descripcion'] = trim($row["post_descripcion"]);
				$freg = $row["post_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($freg);
				//
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


function API_circulares($alumnos,$persona,$page = ''){
	$ClsCir = new ClsCircular();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	//--
	$arralumnos = array();
	$arralumnos = explode(",", $alumnos);
	$cantidad = count($arralumnos);
	
	$codigos = "";
	for($i = 0; $i <= $cantidad; $i ++){
		$alumno = $arralumnos[$i];
		if($alumno != ""){
			//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
			$codigos1 = $ClsCir->get_codigos_circular_secciones($pensum,$alumno);
			//////////////////////////////////////// GRUPOS //////////////////////////////////////
			$codigos2 = $ClsCir->get_codigos_circular_grupos($alumno);
			//////////////////////////////////////// TODOS //////////////////////////////////////
			$codigos3 = $ClsCir->get_codigos_circular_todos();
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
		////////////////// PAGES //////////////////
		if($page != ""){
			$limit1 = 1;
			$limit2 = 1;
			if($page == 0){
				$limit1 = 0;
				$limit2 = 10;
			}else{
				$limit1 = $page * 10;
				$limit2 = 10;
			}
		}else{
			$limit1 = 0;
			$limit2 = 10;
		}
		////////////////////////////////////////////
		$i = 0;
		$result = $ClsCir->get_circular($codigos,'','','','', $limit1,$limit2);
		if (is_array($result)) {
			foreach ($result as $row){
				$codigo = $row["cir_codigo"];
				$arr_data[$i]['codigo'] = $codigo;
				$arr_data[$i]['imagen'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_circular.png";
				$arr_data[$i]['link'] = "https://" . $_SERVER['HTTP_HOST'] ."/CONFIG/Circulares/".trim($row["cir_documento"]);
				$arr_data[$i]['descarga'] = "https://" . $_SERVER['HTTP_HOST'] ."/SISTEM/API/API_download_circular.php?documento=".trim($row["cir_documento"]);
				$arr_data[$i]['titulo'] = trim($row["cir_titulo"]);
				$arr_data[$i]['descripcion'] = trim($row["cir_descripcion"])." (Ver documento adjunto)";
				$autoriza = trim($row["cir_autorizacion"]);
				$autoriza = ($autoriza == 1)?true:false;
				$arr_data[$i]['requiere_autorizacion'] = $autoriza;
				$fini = trim($row["cir_fecha_publicacion"]);
				//--				
				$fechaini = explode(" ",$fini);
				$fini = cambia_fecha($fechaini[0]);
				$arr_data[$i]['fecha_publicacion'] = $fini;
				$arr_data[$i]['hora_publicacion'] = substr($fechaini[1], 0, -3);
				//--
				$respuatoriza = array();
				$respuatoriza = $ClsCir->get_autorizacion_directa($codigo,$persona);
				$autoriza = $respuatoriza["autoriza"];
				$fecha_autoriza = $respuatoriza["fecha"];
				if($autoriza == null){
					$arr_data[$i]['status_autorizacion'] = null;
					$arr_data[$i]['texto_autorizacion'] = 'Esta Circular no requiere autorización...';
					$arr_data[$i]['texto_color'] = "light";
				}else if($autoriza == 1){
					$fecha_autoriza = cambia_fechaHora($fecha_autoriza);
					$fecha_autoriza = substr($fecha_autoriza, 0, -3);
					$arr_data[$i]['status_autorizacion'] = true;
					$arr_data[$i]['texto_autorizacion'] = 'Autorizada el '.$fecha_autoriza.'';
					$arr_data[$i]['texto_color'] = "success";
					$arr_data[$i]['requiere_autorizacion'] = true; //ya esta autorizada
				}else if($autoriza == 2){
					$fecha_autoriza = cambia_fechaHora($fecha_autoriza);
					$fecha_autoriza = substr($fecha_autoriza, 0, -3);
					$arr_data[$i]['status_autorizacion'] = false;
					$arr_data[$i]['texto_autorizacion'] = 'Denegada el '.$fecha_autoriza.'';
					$arr_data[$i]['texto_color'] = "danger";
					$arr_data[$i]['requiere_autorizacion'] = true; //ya esta autorizada
				}
				//--
				if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				}else{
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
				}
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
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No se registran datos...");
			echo json_encode($arr_data);
	}
	
}



function API_circular($codigo,$persona){
	$ClsInfo = new ClsInformacion();
	$ClsCir = new ClsCircular();
	
	if($codigo != "" && $persona != ""){
		$result = $ClsCir->get_circular($codigo);
		if(is_array($result)){
			$i = 0;	
			foreach ($result as $row){
				$codigo = $row["cir_codigo"];
				$arr_data[$i]['codigo'] = $codigo;
				$arr_data[$i]['imagen'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/baner_circular.png";
				$arr_data[$i]['link'] = "https://" . $_SERVER['HTTP_HOST'] ."/CONFIG/Circulares/".trim($row["cir_documento"]);
				$arr_data[$i]['descarga'] = "https://" . $_SERVER['HTTP_HOST'] ."/SISTEM/API/API_download_circular.php?documento=".trim($row["cir_documento"]);
				$arr_data[$i]['titulo'] = trim($row["cir_titulo"]);
				$arr_data[$i]['descripcion'] = trim($row["cir_descripcion"])." (Ver documento adjunto)";
				$autoriza = trim($row["cir_autorizacion"]);
				$autoriza = ($autoriza == 1)?true:false;
				$arr_data[$i]['requiere_autorizacion'] = $autoriza;
				$fini = trim($row["cir_fecha_publicacion"]);
				//--				
				$fechaini = explode(" ",$fini);
				$fini = cambia_fecha($fechaini[0]);
				$arr_data[$i]['fecha_publicacion'] = $fini;
				$arr_data[$i]['hora_publicacion'] = substr($fechaini[1], 0, -3);
				//--
				$respuatoriza = array();
				$respuatoriza = $ClsCir->get_autorizacion_directa($codigo,$persona);
				$autoriza = $respuatoriza["autoriza"];
				$fecha_autoriza = $respuatoriza["fecha"];
				if($autoriza == null){
					$arr_data[$i]['status_autorizacion'] = null;
					$arr_data[$i]['texto_autorizacion'] = 'Esta Circular no requiere autorización...';
					$arr_data[$i]['texto_color'] = "light";
				}else if($autoriza == 1){
					$fecha_autoriza = cambia_fechaHora($fecha_autoriza);
					$fecha_autoriza = substr($fecha_autoriza, 0, -3);
					$arr_data[$i]['status_autorizacion'] = true;
					$arr_data[$i]['texto_autorizacion'] = 'Autorizada el '.$fecha_autoriza.'';
					$arr_data[$i]['texto_color'] = "success";
					$arr_data[$i]['requiere_autorizacion'] = true; //ya esta autorizada
				}else if($autoriza == 2){
					$fecha_autoriza = cambia_fechaHora($fecha_autoriza);
					$fecha_autoriza = substr($fecha_autoriza, 0, -3);
					$arr_data[$i]['status_autorizacion'] = false;
					$arr_data[$i]['texto_autorizacion'] = 'Denegada el '.$fecha_autoriza.'';
					$arr_data[$i]['texto_color'] = "danger";
					$arr_data[$i]['requiere_autorizacion'] = true; // no esta autorizada, pero ya respondio
				}
				//--
				if(file_exists('../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/banersapp/logo_fondo.png";
				}else{
					$arr_data[$i]['url_logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/noimage.png";
				}
				//--
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


function API_circular_autorizacion($codigo,$persona,$autorizacion){
	$ClsInfo = new ClsInformacion();
	$ClsCir = new ClsCircular();
	
	if($codigo != "" && $persona != "" && $autorizacion != ""){
		$sql = $ClsCir->insert_autorizacion($codigo,$persona,$autorizacion);
		$rs = $ClsCir->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Respuesta enviada exitosamente!");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Error en la transacción....");
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

function API_lista_alumno($tipo_usuario,$tipo_codigo){
	$ClsAsi = new ClsAsignacion();
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "10"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAlu->get_alumno($tipo_codigo,"");
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

?>