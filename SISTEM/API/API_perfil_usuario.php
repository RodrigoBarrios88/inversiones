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
		case "get_usuario":
			$codigo = $_REQUEST["codigo"];
			API_get_usuario($codigo);
			break;
		case "get_maestro":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_get_maestro($tipo_usuario,$tipo_codigo);
			break;
		case "get_autoridad":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_get_autoridad($tipo_usuario,$tipo_codigo);
			break;
		case "update_maestro":
			$data = $_REQUEST['data'];
			API_update_maestro($data);
			break;
		case "update_autoridad":
			$data = $_REQUEST['data'];
			API_update_autoridad($data);
			break;
		case "update_password":
			$data = $_REQUEST['data'];
			API_update_password($data);
			break;
		case "update_pregunta_clave":
			$data = $_REQUEST['data'];
			API_update_pregunta($data);
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

function API_get_usuario($codigo){
	$ClsUsu = new ClsUsuario();
	if($codigo != ""){
		$result = $ClsUsu->get_usuario($codigo);
		if (is_array($result)) {
			foreach ($result as $row){
				$codigo = $row['usu_id'];
				$usu = $row['usu_usuario'];
				$preg = $row["usu_pregunta"];
				$resp = $row["usu_respuesta"];
				$resp = $ClsUsu->decrypt($resp,$usu);
				$nombre = trim($row['usu_nombre']);
				$nombre_pantalla = trim($row['usu_nombre_pantalla']);
				$mail = $row['usu_mail'];
				$tel = $row['usu_telefono'];
				$tipo = $row['usu_tipo'];
				$tipo_codigo = $row['usu_tipo_codigo'];
				//--
				$foto = $row['usu_foto'];
			}
			
			/// USUARIO
			$arr_data['codigo'] = $codigo;
			$arr_data['usu'] = $usu;
			$arr_data['nombre'] = $nombre;
			$arr_data['usu_nombre_pantalla'] = $nombre_pantalla;
			$arr_data['mail'] = $mail;
			$arr_data['telefono'] = $tel;
			$arr_data['tipo_usuario'] = $tipo;
			$arr_data['tipo_codigo'] = $tipo_codigo;
			$arr_data['pregunta_recuperacion_pass'] = $preg;
			$arr_data['respuesta_recuperacion_pass'] = $resp;
			if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
				$arr_data['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
			}else{
				$arr_data['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
			}
			
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "El Codigo del usuario es incorrecto...");
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


function API_get_maestro($tipo_usuario,$cui){
	$ClsMae = new ClsMaestro();
	$ClsUsu = new ClsUsuario();
	
	if($cui != ""){
		if($tipo_usuario === "2"){
			$result = $ClsMae->get_maestro($cui,'','',1);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['cui'] = $row["mae_cui"];
					$arr_data[$i]['nombre'] = $row["mae_nombre"];
					$arr_data[$i]['apellido'] = $row["mae_apellido"];
					$arr_data[$i]['titulo'] = trim($row["mae_titulo"]);
					$arr_data[$i]['mail'] = $row["mae_mail"];
					$arr_data[$i]['telefono'] = trim($row["mae_telefono"]);
					$id = $row["mae_usu_id"];
					$foto = $ClsUsu->last_foto_usuario($id);
					if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
					}
					$i++;
				}
				
				echo json_encode($arr_data);
				
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No existen informacion de este maestro...");
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
			"message" => "El CUI de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_get_autoridad($tipo_usuario,$cui){
	$ClsOtro = new ClsOtrosUsu();
	$ClsUsu = new ClsUsuario();
	
	if($cui != ""){
		if($tipo_usuario === "1"){
			$result = $ClsOtro->get_otros_usuarios($cui,'','',1);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['cui'] = $row["otro_cui"];
					$arr_data[$i]['nombre'] = $row["otro_nombre"];
					$arr_data[$i]['apellido'] = $row["otro_apellido"];
					$arr_data[$i]['titulo'] = trim($row["otro_titulo"]);
					$arr_data[$i]['mail'] = $row["otro_mail"];
					$arr_data[$i]['telefono'] = trim($row["otro_telefono"]);
					$id = $row["otro_usu_id"];
					//--
					$foto = $ClsUsu->last_foto_usuario($id);
					if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
					}
					$i++;
				}
				
				echo json_encode($arr_data);
				
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "No existen informacion de esta autoridad...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Este usuario no pertenece al grupo de autoridades...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El CUI de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_update_maestro($data){
	$ClsUsu = new ClsUsuario();
    $ClsMae = new ClsMaestro();
	//echo $data;
	$data = json_decode(stripslashes($data), true);
	
	
	//echo json_encode($data, true);
	if(is_array($data)){
		$codigo = $data[0]["codigo"];
		$tipo_usuario = $data[0]["tipo_usuario"];
		//echo "entro";
		if($tipo_usuario == 2){
			$cui = trim($data[0]["cui"]);
			//pasa a mayusculas
				$nom = trim($data[0]["nombre"]);
				$ape = trim($data[0]["apellido"]);
				$nombre_pantalla = trim($data[0]["nombre_pantalla"]);
				$titulo = trim($data[0]["titulo"]);
			//--------
			//decodificaciones de tildes y Ñ's
				$nom = utf8_encode($nom);
				$ape = utf8_encode($ape);
				$nombre_pantalla = utf8_encode($nombre_pantalla);
				$titulo = utf8_encode($titulo);
				//--
				$nom = trim($nom);
				$ape = trim($ape);
				$nombre_pantalla = trim($nombre_pantalla);
				$titulo = trim($titulo);
			//--------
			//pasa a minusculas
				$mail = strtolower($data[0]["mail"]);
			//--------
			//desgloza datos
				$tel = trim($data[0]["telefono"]);
			//--------
			if($cui !="" && $nom !="" && $ape != "" && $nombre_pantalla != "" && $tel != "" && $mail != ""){
				$sql = $ClsMae->modifica_maestro_perfil($cui,$nom,$ape,$titulo,$tel,$mail);
				$sql.= $ClsUsu->modifica_perfil($codigo,$nombre_pantalla,$mail,$tel);
				//echo $sql;
				$rs = $ClsMae->exec_sql($sql);
				if($rs == 1){
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "success",
						"message" => "Datos actualizados satisfactoriamente....");
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
				"message" => "Este usuario no pertenece al grupo de maestros...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Datos Vacios....");
			//echo json_encode($arr_data);
	}
	
}



function API_update_autoridad($data){
	$ClsUsu = new ClsUsuario();
    $ClsOtro =  new ClsOtrosUsu();
	 
	$data = json_decode(stripslashes($data), true);
	
	//echo $data;
	//echo json_encode($data, true);
		
	if(is_array($data)){
		$codigo = $data[0]["codigo"];
		$tipo_usuario = $data[0]["tipo_usuario"];
		if($tipo_usuario == 1){
			$cui = trim($data[0]["cui"]);
			//pasa a mayusculas
				$nom = trim($data[0]["nombre"]);
				$ape = trim($data[0]["apellido"]);
				$nombre_pantalla = trim($data[0]["nombre_pantalla"]);
				$dir = trim($data[0]["direccion"]);
				$titulo = trim($data[0]["titulo"]);
			//--------
			//decodificaciones de tildes y Ñ's
				$nom = utf8_encode($nom);
				$ape = utf8_encode($ape);
				$nombre_pantalla = utf8_encode($nombre_pantalla);
				$dir = utf8_encode($dir);
				$titulo = utf8_encode($titulo);
				//--
				$nom = trim($nom);
				$ape = trim($ape);
				$nombre_pantalla = trim($nombre_pantalla);
				$dir = trim($dir);
				$titulo = trim($titulo);
			//--------
			//pasa a minusculas
				$mail = strtolower($data[0]["mail"]);
			//--------
			//desgloza datos
				$tel = trim($data[0]["telefono"]);
			//--------
			if($cui !="" && $nom !="" && $ape != "" && $nombre_pantalla != "" && $tel != "" && $mail != ""){
				$sql = $ClsOtro->modifica_otros_usuarios_perfil($cui,$nom,$ape,$titulo,$tel,$mail);
				$sql.= $ClsUsu->modifica_perfil($codigo,$nombre_pantalla,$mail,$tel);
				//echo $sql;
				$rs = $ClsOtro->exec_sql($sql);
				if($rs == 1){
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "success",
						"message" => "Datos actualizados satisfactoriamente....");
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
				"message" => "Este usuario no pertenece al grupo de autoridades...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Datos Vacios....");
			//echo json_encode($arr_data);
	}
	
}


function API_update_password($data){
	$ClsUsu = new ClsUsuario();
    
	$data = json_decode(stripslashes($data), true);
    
	$codigo = $data[0]["codigo"];
	if($codigo != ""){
		//pasa a mayusculas
			$usu = trim($data[0]["usuario"]);
			$pass = trim($data[0]["pass"]);
		//--------
			if($usu !="" && $pass !=""){
				$sql = $ClsUsu->modifica_pass_perfil($codigo,$usu,$pass);
				$rs = $ClsUsu->exec_sql($sql);
				if($rs == 1){
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "success",
						"message" => "Contraseña actualizada Satisfactoriamente....");
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
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}




function API_update_pregunta($data){
	$ClsUsu = new ClsUsuario();
    
	$data = json_decode(stripslashes($data), true);
    
	$codigo = $data[0]["codigo"];
	if($codigo != ""){
		//pasa a mayusculas
			$usu = trim($data[0]["usuario"]);
			$preg = trim($data[0]["pregunta"]);
			$resp = trim($data[0]["respuesta"]);
		//--------
			if($usu !="" && $preg !="" && $resp !=""){
				$sql = $ClsUsu->cambia_pregunta($codigo,$usu,$preg,$resp);
				$rs = $ClsUsu->exec_sql($sql);
				if($rs == 1){
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "success",
						"message" => "Pregunta Secreta actualizada Satisfactoriamente....");
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
			"message" => "El codigo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}

