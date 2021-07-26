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
		case "login":
			$usu = $_REQUEST["usu"];
			$pass = $_REQUEST["pass"];
			API_login($usu,$pass);
			break;
		case "autorizacion_seguridad":
			$user_id = $_REQUEST["user_id"];
			$device_id = $_REQUEST["device_id"];
			API_bloqueo($user_id,$device_id);
			break;
		case "hijos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_hijos($tipo_usuario,$tipo_codigo);
			break;
		case "maestro_secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_secciones_maestro($tipo_usuario,$tipo_codigo);
			break;
		case "maestro_materias":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			API_lista_materias_maestro($tipo_usuario,$tipo_codigo,$nivel, $grado);
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

function API_login($usu,$pass){
	$ClsUsu = new ClsUsuario();
	$ClsReg = new ClsRegla();
	$ClsPerm = new ClsPermiso();
	$ClsPen = new ClsPensum();
	if($usu != "" && $pass != ""){
		$result = $ClsUsu->get_login($usu,$pass);
		if (is_array($result)) {
			foreach ($result as $row){
				$codigo = $row['usu_id'];
				$nombre = trim($row['usu_nombre']);
				$nombre_pantalla = utf8_decode($row['usu_nombre_pantalla']);
				$empresa = trim($row['suc_nombre']);
				$empCodigo = trim($row['suc_id']);
				$tipo = $row['usu_tipo'];
				$tipo_codigo = $row['usu_tipo_codigo'];
				//--
				$chat_user_id = $row['usu_chat_id'];
				//--
				$foto = $row['usu_foto'];
			}
			
			/// USUARIO
			$arr_data['codigo'] = $codigo;
			$arr_data['usu'] = $usu;
			$arr_data['pass'] = $pass;
			$arr_data['nombre'] = $nombre;
			$arr_data['usu_nombre_pantalla'] = $nombre_pantalla;
			//--
			$chat = ($tipo == 1 || $tipo == 3)?1:0;
			$arr_data['chat'] = $chat; ///
			$arr_data['chat_user_id'] = $chat_user_id;
			if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
				$arr_data['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
			}else{
				$arr_data['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
			}
			
			/// PENSUM ////
			$pensum = $ClsPen->get_pensum_activo();
			
			///// ASMS /////
			$arr_data['pensum'] = $pensum;
			$arr_data['tipo_usuario'] = $tipo;
			$arr_data['tipo_codigo'] = $tipo_codigo;
			if($tipo == 1){
				$arr_data['tipo_descripcion'] = "USIARIO ADMINISTRATIVO";
			}else if($tipo == 2){
				$arr_data['tipo_descripcion'] = "MAESTRO";
			}else if($tipo == 3){
				$arr_data['tipo_descripcion'] = "PADRE";
			}else if($tipo == 4){
				$arr_data['tipo_descripcion'] = "MONITOR DE BUS";
			}
			
			$payload = array(
					"status" => true,
					"data" => $arr_data,
					"message" => "");
						
			echo json_encode($payload);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => false,
				"message" => "El usuario o el password son incorrectos...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => false,
			"message" => "Uno de los campos esta vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_bloqueo($user_id,$device_id){
	$ClsPush = new ClsPushup();
	if($user_id != "" && $device_id != ""){
		$result = $ClsPush->get_push_user($user_id,'','',$device_id);
		if(is_array($result)) {
			foreach ($result as $row){
				$status = $row['status'];
			}
			if($status != 0){
				$arr_data['autorizacion'] = true;
			}else{
				$arr_data['autorizacion'] = false;
			}
			echo json_encode($arr_data);
		}else{
			$arr_data['autorizacion'] = true;
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


function API_lista_hijos($tipo_usuario,$tipo_codigo){
	$ClsAsi = new ClsAsignacion();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "3"){
			$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
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



function API_lista_secciones_maestro($tipo_usuario,$tipo_codigo){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "2"){
			$result = $ClsAcadem->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['pensum'] = $row["niv_pensum"];
					$arr_data[$i]['nivel'] = $row["niv_codigo"];
					$arr_data[$i]['gra_codigo'] = $row["gra_codigo"];
					$arr_data[$i]['sec_codigo'] = $row["sec_codigo"];
					$arr_data[$i]['gra_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['sec_descripcion'] = trim($row["sec_descripcion"]);
					$i++;
				}
				
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No existen secciones con estos parametros, en las que impartan clases este maestro...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de maestros...");
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


function API_lista_materias_maestro($tipo_usuario,$tipo_codigo,$nivel = "", $grado = ""){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "1"){
			$result = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['pensum'] = $row["niv_pensum"];
					$arr_data[$i]['nivel'] = $row["niv_codigo"];
					$arr_data[$i]['niv_descripcion'] = trim($row["niv_descripcion"]);
					$arr_data[$i]['grado'] = $row["gra_codigo"];
					$arr_data[$i]['gra_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['mat_codigo'] = $row["mat_codigo"];
					$arr_data[$i]['mat_descripcion'] = trim($row["mat_descripcion"]);
					$i++;
				}
				
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No materias con estos parametros, que imparta este maestro...");
					echo json_encode($arr_data);
			}
			return;
		}if($tipo_usuario === "2"){
			$result = $ClsAcadem->get_materia_maestro($pensum,$nivel,$grado,'',$tipo_codigo,'','',1);;
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['pensum'] = $row["niv_pensum"];
					$arr_data[$i]['nivel'] = $row["niv_codigo"];
					$arr_data[$i]['niv_descripcion'] = trim($row["niv_descripcion"]);
					$arr_data[$i]['grado'] = $row["gra_codigo"];
					$arr_data[$i]['gra_descripcion'] = trim($row["gra_descripcion"]);
					$arr_data[$i]['mat_codigo'] = $row["mat_codigo"];
					$arr_data[$i]['mat_descripcion'] = trim($row["mat_descripcion"]);
					$i++;
				}
				
				echo json_encode($arr_data);
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No materias con estos parametros, que imparta este maestro...");
					echo json_encode($arr_data);
			}
			return;
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de maestros...");
				echo json_encode($arr_data);
			return;
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
		return;
	}
	
}

