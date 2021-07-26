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

include_once('../../../CONFIG/push/push_android.php');
include_once('../../../CONFIG/push/push_ios.php');
///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "albumes":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_album($tipo_usuario,$tipo_codigo);
			break;
		case "detalle":
			$codigo = $_REQUEST["codigo"];
			API_detalle($codigo);
			break;
		/////////////////////////////////////////////////////
		case "alumnos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			$nombre = $_REQUEST["alu_nombre"];
			API_alumnos($tipo_usuario,$tipo_codigo,$nombre);
			break;
		case "lista_albumes":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_album($tipo_usuario,$tipo_codigo);
			break;
		case "new_album":
			$data = $_REQUEST["data"];
			API_new_album($data);
			break;
		case "update_texto":
			$codigo = $_REQUEST["codigo"];
			$texto = $_REQUEST["texto"];
			API_update_texto($codigo,$texto);
			break;
		case "update_alumnos":
			$data = $_REQUEST["data"];
			API_update_alumnos($data);
			break;
		case "delete_album":
			$codigo = $_REQUEST["codigo"];
			API_delete_album($codigo);
			break;
		case "delete_photo":
			$codigo = $_REQUEST["album"];
			$imagen = $_REQUEST["image"];
			API_delete_photo($codigo,$imagen);
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


function API_album($tipo_usuario,$tipo_codigo){
	$ClsPho = new ClsPhoto();
	$ClsAsi = new ClsAsignacion();
	
	if($tipo_usuario == 3){ //// PADRE DE ALUMNO
		$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
		////////// CREA UN ARRAY CON TODOS LOS DATOS DE SUS HIJOS
		if (is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$cui = $row["alu_cui"];
				$arrcui.= $cui.",";
			}
			$arrcui = substr($arrcui,0,-1);
			////--------------------------------
			$codigos = "";
			$result = $ClsPho->get_photos_hijos('','',$arrcui,'','',1);
			if(is_array($result)){
				foreach($result as $row){
					$codigos.= trim($row["pho_codigo"]).",";
				}
				$codigos = substr($codigos, 0, -1); 
			}
		}
		if($codigos != ""){
			$result = $ClsPho->get_album_unique($codigos,'','','',1);
			if (is_array($result)) {
				$i = 0;	
				foreach ($result as $row){
					$arr_data[$i]['codigo'] = intval($row["pho_codigo"]);
					$arr_data[$i]['fecha'] = cambia_fechaHora($row["pho_fecha_registro"]);
					//$arr_data[$i]['imagen_portada'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/PHOTO/".trim($row["pho_portada"]);
					$arr_data[$i]['texto'] = trim($row["pho_descripcion"]);
					$arr_data[$i]['cantidad_fotos'] = intval($row["pho_cantidad"]);
					//--
					$j = 0;
					$arr_photos = array();
					$album = trim($row["pho_codigo"]);
					$result_photos = $ClsPho->get_imagenes($album,'','','',1);
					if(is_array($result_photos)) {
						foreach($result_photos as $row_photo){
							$arr_photos[$j]['foto'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/PHOTO/".trim($row_photo["ipho_imagen"]);
							$j++;
						}
						$arr_data[$i]['imagenes'] = $arr_photos;
					}else{
						$arr_data[$i]['imagenes'] = array();
					}
					//--
					$k = 0;
					$arr_alumnos = array();
					$album = trim($row["pho_codigo"]);
					$result_alumnos = $ClsPho->get_photos_alumno($album,$arrcui);
					if(is_array($result_alumnos)) {
						foreach($result_alumnos as $row_alumnos){
							$arr_alumnos[$k]['cui'] =  trim($row_alumnos["alu_cui"]);
							$arr_alumnos[$k]['alumno'] =  trim($row_alumnos["alu_nombre"])." ".trim($row_alumnos["alu_apellido"]);
							$k++;
						}
						$arr_data[$i]['alumnos'] = $arr_alumnos;
					}else{
						$arr_data[$i]['alumnos'] = array();
					}
					//
					if(file_exists('../../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
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
				"status" => "vacio",
				"message" => "No se registran datos...");
				echo json_encode($arr_data);
		}
	}elseif ($tipo_usuario == 10){//FOTOS ALUMNOS
			////--------------------------------
			$codigos = "";
			$result = $ClsPho->get_photos_hijos('','',$tipo_codigo,'','',1);
			if(is_array($result)){
				foreach($result as $row){
					$codigos.= trim($row["pho_codigo"]).",";
				}
				$codigos = substr($codigos, 0, -1); 
			}
		
		if($codigos != ""){
			$result = $ClsPho->get_album_unique($codigos,'','','',1);
			if (is_array($result)) {
				$i = 0;	
				foreach ($result as $row){
					$arr_data[$i]['codigo'] = intval($row["pho_codigo"]);
					$arr_data[$i]['fecha'] = cambia_fechaHora($row["pho_fecha_registro"]);
					//$arr_data[$i]['imagen_portada'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/PHOTO/".trim($row["pho_portada"]);
					$arr_data[$i]['texto'] = trim($row["pho_descripcion"]);
					$arr_data[$i]['cantidad_fotos'] = intval($row["pho_cantidad"]);
					//--
					$j = 0;
					$arr_photos = array();
					$album = trim($row["pho_codigo"]);
					$result_photos = $ClsPho->get_imagenes($album,'','','',1);
					if(is_array($result_photos)) {
						foreach($result_photos as $row_photo){
							$arr_photos[$j]['foto'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/PHOTO/".trim($row_photo["ipho_imagen"]);
							$j++;
						}
						$arr_data[$i]['imagenes'] = $arr_photos;
					}else{
						$arr_data[$i]['imagenes'] = array();
					}
					//--
					$k = 0;
					$arr_alumnos = array();
					$album = trim($row["pho_codigo"]);
					$result_alumnos = $ClsPho->get_photos_alumno($album,$arrcui);
					if(is_array($result_alumnos)) {
						foreach($result_alumnos as $row_alumnos){
							$arr_alumnos[$k]['cui'] =  trim($row_alumnos["alu_cui"]);
							$arr_alumnos[$k]['alumno'] =  trim($row_alumnos["alu_nombre"])." ".trim($row_alumnos["alu_apellido"]);
							$k++;
						}
						$arr_data[$i]['alumnos'] = $arr_alumnos;
					}else{
						$arr_data[$i]['alumnos'] = array();
					}
					//
					if(file_exists('../../../CONFIG/images/logo.png')){ /// valida que tenga foto registrada
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


function API_detalle($codigo){
	$ClsPho = new ClsPhoto();
	
	if($codigo != ""){
		$i = 0;	
		$result = $ClsPho->get_photo($codigo);
		if (is_array($result)) {
			foreach($result as $row){
				$arr_data[$i]['codigo'] = intval($row["pho_codigo"]);
				$arr_data[$i]['fecha'] = cambia_fechaHora($row["pho_fecha_registro"]);
				$arr_data[$i]['texto'] = trim($row["pho_descripcion"]);
				//////////////////////////////////////// FOTOS ///////////////////////////////////////////
				$j = 0;
				$arr_photos = array();
				$result_photos = $ClsPho->get_imagenes($codigo,'','','',1);
				if(is_array($result_photos)) {
					foreach($result_photos as $row_photo){
						$arr_photos[$j]['foto'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/PHOTO/".trim($row_photo["ipho_imagen"]);
						$j++;
					}
					$arr_data[$i]['imagenes'] = $arr_photos;
				}else{
					$arr_data[$i]['imagenes'] = array();
				}
				//////////////////////////////////////// ALUMNOS ///////////////////////////////////////////
				$k = 0;
				$arr_alumnos = array();
				$album = trim($row["pho_codigo"]);
				$result_alumnos = $ClsPho->get_photos_alumno($codigo,$arrcui);
				if(is_array($result_alumnos)) {
					foreach($result_alumnos as $row_alumnos){
						$arr_alumnos[$k]['cui'] =  trim($row_alumnos["alu_cui"]);
						$arr_alumnos[$k]['alumno'] =  trim($row_alumnos["alu_nombre"])." ".trim($row_alumnos["alu_apellido"]);
						$k++;
					}
					$arr_data[$i]['alumnos'] = $arr_alumnos;
				}else{
					$arr_data[$i]['alumnos'] = array();
				}
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "vacio",
				"message" => "no hay registros...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function API_alumnos($tipo_usuario,$tipo_codigo,$nombre){
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "2"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcad->get_maestro_alumnos($pensum,'','','',$tipo_codigo,$nombre);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					//codigo
					$cui = $row["alu_cui"];
					//alumno
					$nombre = trim($row["alu_nombre"]);
					$apellido = trim($row["alu_apellido"]);
					$nombres = $apellido.", ".$nombre;
					//--
					$grado_desc = trim($row["gra_descripcion"]);
					$seccion_desc = trim($row["sec_descripcion"]);
					$grado_completo = $grado_desc." ".$seccion_desc;
					//--
					$arr_data[$i]['cui'] = $cui;
					$arr_data[$i]['nombre'] = $nombres;
					$arr_data[$i]['seccion'] = $grado_completo;
					//--
					$foto = $row["alu_foto"];
					if(file_exists('../../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
					}
					//--
					$i++;
				}
				//print_r($arr_data);
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "vacio",
					"message" => "No se registran datos...");
					echo json_encode($arr_data);
			}		
		}else if($tipo_usuario === "1"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcad->get_otros_usuarios_alumnos($pensum,'','',$tipo_codigo,$nombre);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					//codigo
					$cui = $row["alu_cui"];
					//alumno
					$nombre = trim($row["alu_nombre"]);
					$apellido = trim($row["alu_apellido"]);
					$nombres = $apellido.", ".$nombre;
					//--
					$grado_desc = trim($row["gra_descripcion"]);
					$seccion_desc = trim($row["sec_descripcion"]);
					$grado_completo = $grado_desc." ".$seccion_desc;
					//--
					$arr_data[$i]['cui'] = $cui;
					$arr_data[$i]['nombre'] = $nombres;
					$arr_data[$i]['seccion'] = $grado_completo;
					//--
					$foto = $row["alu_foto"];
					if(file_exists('../../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
					}
					//--
					$i++;
				}
				//print_r($arr_data);
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


function API_lista_album($tipo_usuario,$tipo_codigo){
	$ClsPho = new ClsPhoto();
	$ClsAsi = new ClsAsignacion();
	$ClsAcad = new ClsAcademico();
	
	if($tipo_usuario == 1 || $tipo_usuario == 2){ 
		if($tipo_usuario == 2){ //// MAESTRO
			$maestro = $tipo_codigo;
			$result_secciones = $ClsAcad->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
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
			}
			$result = $ClsPho->get_album_accesos('',$pensum,$info_nivel, $info_grado,'','',1);
			if(is_array($result)){
				foreach($result as $row){
					$codigos.= trim($row["pho_codigo"]).",";
				}
				$codigos = substr($codigos, 0, -1); 
			}
		}else if($tipo_usuario == 1){ //// DIRECTORA
			$result = $ClsAcad->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
			if(is_array($result)){
				foreach($result as $row){
					$info_pensum.= $row["gra_pensum"].",";
					$info_nivel.= $row["gra_nivel"].",";
					$info_grado.= $row["gra_codigo"].",";
				}
				$info_pensum = substr($info_pensum,0,-1);
				$info_nivel = substr($info_nivel,0,-1);
				$info_grado = substr($info_grado,0,-1);
			}
			$result = $ClsPho->get_album_accesos('',$pensum,$info_nivel, $info_grado,'','',1);
			if(is_array($result)){
				foreach($result as $row){
					$codigos.= trim($row["pho_codigo"]).",";
				}
				$codigos = substr($codigos, 0, -1); 
			}
		}
	
		if($codigos != ""){
			$result = $ClsPho->get_album_unique($codigos,'','','',1);
			if (is_array($result)) {
				$i = 0;	
				foreach ($result as $row){
					$arr_data[$i]['codigo'] = intval($row["pho_codigo"]);
					$arr_data[$i]['fecha'] = cambia_fechaHora($row["pho_fecha_registro"]);
					$arr_data[$i]['texto'] = trim($row["pho_descripcion"]);
					$arr_data[$i]['cantidad_fotos'] = intval($row["pho_cantidad"]);
					//--
					$j = 0;
					$arr_photos = array();
					$album = trim($row["pho_codigo"]);
					$result_photos = $ClsPho->get_imagenes($album,'','','',1);
					if(is_array($result_photos)) {
						foreach($result_photos as $row_photo){
							$arr_photos[$j]['foto'] =  "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/PHOTO/".trim($row_photo["ipho_imagen"]);
							$j++;
						}
						$arr_data[$i]['imagenes'] = $arr_photos;
					}else{
						$arr_data[$i]['imagenes'] = array();
					}
					//--
					$k = 0;
					$arr_alumnos = array();
					$album = trim($row["pho_codigo"]);
					$result_alumnos = $ClsPho->get_photos_alumno($album);
					if(is_array($result_alumnos)) {
						foreach($result_alumnos as $row_alumnos){
							$arr_alumnos[$k]['cui'] =  trim($row_alumnos["alu_cui"]);
							$arr_alumnos[$k]['alumno'] =  trim($row_alumnos["alu_nombre"])." ".trim($row_alumnos["alu_apellido"]);
							$k++;
						}
						$arr_data[$i]['alumnos'] = $arr_alumnos;
					}else{
						$arr_data[$i]['alumnos'] = array();
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


function API_new_album($data){
	$ClsPho = new ClsPhoto();
	$ClsPush = new ClsPushup();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$maestro = trim($data[0]["maestro"]);
		$desc = trim($data[0]["descripcion"]);
		//--
		$desc = trim($desc);
		// valida si viene alumno, alumnos o vacio
		$alumnos = trim($data[0]["alumno"]);
		$arralumnos = array();
		$arralumnos = explode(",", $alumnos);
		$cantidad = count($arralumnos);
		//--------
		if($maestro !=""){
			$codigo = $ClsPho->max_photo();
			$codigo++;
			$sql = $ClsPho->insert_photo($codigo,$maestro,$desc);
			if(is_array($arralumnos)){ // si vienen varios
				for($i = 0; $i < $cantidad; $i ++){
					$alumno = $arralumnos[$i];
					$sql.= $ClsPho->insert_tag($codigo,$alumno);
				}
				$result = $ClsPush->get_alumnos_users($alumnos);
			}else if($todos == true){ // si viene vacio
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No hay alumnos seleccionados, por favor seleccione al menos a un alumno...");
					echo json_encode($arr_data);
				return;
    		}
    		
			/// registra la notificacion //
			if(is_array($result)) {
				$title = 'Nuevo Photo Album';
				$message = "Nueo Photo Album: $desc";
				$push_tipo = 11;
				$item_id = $codigo;
				$cert_path = '../../../CONFIG/push/ck_prod.pem';
				//--
				$UsuarioRepetido = ''; // valida que no repita el insert de la push
				foreach ($result as $row){
					$user_id = $row["user_id"];
					$device_id = $row["device_id"];
					if($UsuarioRepetido != $user_id && $device_id != ""){
						$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
						$UsuarioRepetido = $user_id;
					}
    			}
			}
		    
			//echo $sql;
			$rs = $ClsPho->exec_sql($sql);
			if($rs == 1){
			    //devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "Nuevo album creado satisfactoriamente....",
					"album" => "$codigo");
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
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Formato no valido...");
			echo json_encode($arr_data);
	}
}



function API_update_texto($codigo,$texto){
	$ClsPho = new ClsPhoto();
	if($codigo != ""){
		$texto = trim($texto);
		$sql = $ClsPho->modifica_photo($codigo,$texto);
		$rs = $ClsPho->exec_sql($sql);
		//echo $sql;
		if($rs == 1){
			$arr_data = array(
			"status" => "success",
			"message" => "Descripción actualizada satisfactoriamente....");
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


function API_update_alumnos($data){
	$ClsPho = new ClsPhoto();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$codigo = trim($data[0]["codigo"]);
		// valida si viene alumno, alumnos o vacio
		$alumnos = trim($data[0]["alumno"]);
		$arralumnos = array();
		$arralumnos = explode(",", $alumnos);
		$cantidad = count($arralumnos);
		//--------
		if($codigo !=""){
			$sql = $ClsPho->delete_tags($codigo);
			
			if(is_array($arralumnos)){ // si vienen varios
				for($i = 0; $i < $cantidad; $i ++){
					$alumno = $arralumnos[$i];
					$sql.= $ClsPho->insert_tag($codigo,$alumno);
				}
				$result = $ClsPush->get_alumno_users($alumnos);
			}else if($todos == true){ // si viene vacio
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No hay alumnos seleccionados, por favor seleccione al menos a un alumno...");
					echo json_encode($arr_data);
				return;
    		}
			
			//echo $sql;
			$rs = $ClsPho->exec_sql($sql);
			if($rs == 1){
			    //devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "Nuevo album actualizado satisfactoriamente....");
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
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Formato no valido...");
			echo json_encode($arr_data);
	}
}


function API_delete_album($codigo){
	$ClsPho = new ClsPhoto();
	if($codigo != ""){
		$sql = $ClsPho->cambia_sit_photo($codigo,0);
		$rs = $ClsPho->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Album eliminado satisfactoriamente....");
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


function API_delete_photo($codigo,$imagen){
	$ClsPho = new ClsPhoto();
	if($codigo != "" && $imagen != ""){
		$sql = $ClsPho->delete_imagen($codigo,$imagen);
		$rs = $ClsPho->exec_sql($sql);
		if($rs == 1){
			unlink("../../../CONFIG/Fotos/PHOTO/$imagen");
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Album eliminado satisfactoriamente....");
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