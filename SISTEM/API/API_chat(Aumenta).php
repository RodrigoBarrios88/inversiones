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

include_once('../../CONFIG/push/push_android.php');
include_once('../../CONFIG/push/push_ios.php');
///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "hijos_secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_hijos($tipo_usuario,$tipo_codigo);
			break;
		case "usuarios_secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_secciones($tipo_usuario,$tipo_codigo);
			break;
		case "padres":
			$usuario = $_REQUEST["usuario"];
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			API_lista_padres($usuario,$nivel,$grado,$seccion);
			break;
		case "usuarios":
			API_lista_usuarios_CM();
			break;
		case "get_user_chat_id":
			$id = $_REQUEST["id"];
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_get_user_chat_id($id,$tipo_usuario,$tipo_codigo);
			break;
		case "update_chat_user_id":
			$id = $_REQUEST["id"];
			$chat_user_id = $_REQUEST["chat_user_id"];
			API_update_user_chat_id($id,$chat_user_id);
			break;
		case "save_chat_dialog":
			$sender_id = $_REQUEST["sender_id"];
			$sender_chat_id = $_REQUEST["sender_chat_id"];
			$receiver_id = $_REQUEST["receiver_id"];
			$receiver_chat_id = $_REQUEST["receiver_chat_id"];
			$dialog_id = $_REQUEST["dialog_id"];
			API_save_chat_dialog($sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$dialog_id);
			break;
		case "get_chat_dialog":
			$user_id = $_REQUEST["user_id"];
			API_get_chat_dialog($user_id);
			break;
		case "get_chat_list":
			$user_id = $_REQUEST["user_id"];
			API_get_chat_list($user_id);
			break;
		case "send_message":
			$sender_id = $_REQUEST["sender_id"];
			$sender_chat_id = $_REQUEST["sender_chat_id"];
			$receiver_id = $_REQUEST["receiver_id"];
			$receiver_chat_id = $_REQUEST["receiver_chat_id"];
			$message = $_REQUEST["message"];
			API_send_message($sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$message);
			break;
		case "get_user_details_by_chat_ids":
			$user_id = $_REQUEST["user_id"];
			$chat_ids = $_REQUEST["chat_ids"];
			API_get_user_details_by_chat_ids($user_id,$chat_ids);
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
					///------------------
					$result_grado_alumno = $ClsAcad->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);  ////// este array se coloca en la columna de combos
					if(is_array($result_grado_alumno)){
						$j = 0;
						foreach($result_grado_alumno as $row_grado_alumno){
							$arr_grados[$j]['nivel'] = $row_grado_alumno["seca_nivel"];
							$arr_grados[$j]['grado'] = $row_grado_alumno["seca_grado"];
							$arr_grados[$j]['seccion'] = $row_grado_alumno["seca_seccion"];
							$j++;
						}
						$arr_data[$i]['seccion'] = $arr_grados;
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



function API_lista_secciones($tipo_usuario,$tipo_codigo){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "2"){
			$pensum = $ClsPen->get_pensum_activo();
			$result = $ClsAcadem->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
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
			$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
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
				"message" => "Este usuario no pertenece al grupo de maestros o autoridades...");
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


function API_lista_padres($usuario,$nivel,$grado,$seccion){
	$ClsPad = new ClsPadre();
	$ClsPen = new ClsPensum();
	$ClsChat = new ClsChat();
	$ClsUsu = new ClsUsuario();
	$pensum = $ClsPen->get_pensum_activo();
	$usuario_cui = $ClsUsu->get_tipo_codigo($usuario);
	$foto = $ClsUsu->last_foto_usuario($usuario);
	
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
		$result = $ClsPad->get_padre_secciones($pensum,$nivel,$grado,$seccion,'','');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$cui = $row["pad_cui"];
				$arr_data[$i]['cui'] = $row["pad_cui"];
				$arr_data[$i]['nombre'] = trim($row["pad_nombre"])." ".trim($row["pad_apellido"]);
				$arr_data[$i]['hijo'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['telefono'] = trim($row["pad_telefono"]);
				$arr_data[$i]['mail'] = trim($row["pad_mail"]);
				$arr_data[$i]['nickname'] = trim($row["pad_nombre_pantalla"]);
				$id = $row["pad_usu_id"];
				
				if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
				}
				$result_chat = $ClsChat->get_last_message($usuario_cui,$cui);
				if(is_array($result_chat)) {
					foreach($result_chat as $row_chat){
						$arr_data[$i]['active'] = 1;
						$arr_data[$i]['last_message_date'] = $row_chat["updated_at"];
						$arr_data[$i]['last_message'] = $row_chat["message"];
					}
				}else{
					$arr_data[$i]['active'] = 0;
					$arr_data[$i]['last_message_date'] = "";
					$arr_data[$i]['last_message'] = "";
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




function API_lista_maestros($usuario,$nivel,$grado,$seccion){
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsChat = new ClsChat();
	$ClsUsu = new ClsUsuario();
	$pensum = $ClsPen->get_pensum_activo();
	$usuario_cui = $ClsUsu->get_tipo_codigo($usuario);
	$foto = $ClsUsu->last_foto_usuario($usuario);
	
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
		$result = $ClsAcadem->get_seccion_maestro($pensum,$nivel,$grado,$seccion,'','','',1);
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$cui = $row["mae_cui"];
				$arr_data[$i]['cui'] = $row["mae_cui"];
				$arr_data[$i]['nombre'] = trim($row["mae_nombre"])." ".trim($row["mae_apellido"]);
				$arr_data[$i]['titulo'] = trim($row["mae_titulo"]);
				$arr_data[$i]['mail'] = trim($row["mae_mail"]);
				$arr_data[$i]['nickname'] = trim($row["mae_nombre_pantalla"]);
				$id = $row["mae_usu_id"];
				if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
				}
				$result_chat = $ClsChat->get_last_message($usuario_cui,$cui);
				if(is_array($result_chat)) {
					foreach($result_chat as $row_chat){
						$arr_data[$i]['active'] = 1;
						$arr_data[$i]['last_message_date'] = $row_chat["updated_at"];
						$arr_data[$i]['last_message'] = $row_chat["message"];
					}
				}else{
					$arr_data[$i]['active'] = 0;
					$arr_data[$i]['last_message_date'] = "";
					$arr_data[$i]['last_message'] = "";
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


function API_lista_usuarios_CM(){
	$ClsUsu = new ClsUsuario();
	$ClsChat = new ClsChat();
	
	$result = $ClsChat->get_cm('','',1);
	if (is_array($result)) {
		$i = 0;
		$j = 1;
		foreach ($result as $row){
			$cui = $row["cm_cui"];
			$arr_data[$i]['cui'] = $row["cm_cui"];
			$arr_data[$i]['nombre'] = trim($row["cm_nombre"]);
			$arr_data[$i]['mail'] = trim($row["cm_mail"]);
			$arr_data[$i]['nickname'] = trim($row["cm_titulo"]);
			$id = trim($row["cm_usu_id"]);
			//--
			if($id != ""){
				$foto = $ClsUsu->last_foto_usuario($id);
				if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
				}
			}else{
				$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
			}
			$result_chat = $ClsChat->get_last_message($usuario_cui,$cui);
			if(is_array($result_chat)) {
				foreach($result_chat as $row_chat){
					$arr_data[$i]['active'] = 1;
					$arr_data[$i]['last_message_date'] = $row_chat["updated_at"];
					$arr_data[$i]['last_message'] = $row_chat["message"];
				}
			}else{
				$arr_data[$i]['active'] = 0;
				$arr_data[$i]['last_message_date'] = "";
				$arr_data[$i]['last_message'] = "";
			}
			//--
			$i++;
			$j++;
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



function API_get_user_chat_id($id,$tipo_usuario,$tipo_codigo){
	$ClsUsu = new ClsUsuario();
	
	if($id != ""){
		$result = $ClsUsu->get_usuario($id);
	}else if($tipo_usuario != "" && $tipo_codigo != ""){
		$result = $ClsUsu->get_usuario_tipo_codigo($tipo_usuario,$tipo_codigo);
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Los parametros estan vacios o no cumplen con la integridad de la consulta.  Debe eviar el ID de Usuario o el tipo y CUI de usuario...");
			echo json_encode($arr_data);
		return; ///sale de la funcion y no ejecuta mas acciones
	}
	if (is_array($result)) {
		$i = 0;
		foreach($result as $row){
			$arr_data[$i]['codigo'] = $row["usu_id"];
			$arr_data[$i]['tipo_usuario'] = $row["usu_tipo"];
			$arr_data[$i]['tipo_codigo'] = $row["usu_tipo_codigo"];
			$arr_data[$i]['chat_user_id'] = $row["usu_chat_id"];
			$i++;
		}
		echo json_encode($arr_data);
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "empty",
			"message" => "No cuenta con ID de usuario para chat...");
			echo json_encode($arr_data);
	}
	
}



function API_update_user_chat_id($id,$chat_user_id){
	$ClsUsu = new ClsUsuario();
	
	if($id != "" && $chat_user_id != ""){
		$sql.= $ClsUsu->modifica_user_chat_id($id,$chat_user_id);
		$rs = $ClsUsu->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "ID de Usuario de Chat actualizado satisfactoriamente!");
				echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "error en la ejecucion de la sentencia en la BD");
				echo json_encode($arr_data);
		}	
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Uno de los parametros esta vacio...");
			echo json_encode($arr_data);
	}
	
}


function API_save_chat_dialog($sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$dialog_id){
	$ClsChat = new ClsChat();
	
	if($sender_id != ""){
		if($sender_chat_id != ""){
			if($receiver_id != ""){
				if($receiver_chat_id != ""){
					if($dialog_id != "") {
						$dialog_id = trim($dialog_id);
						$result = $ClsChat->check_dialog_id($dialog_id);
						if(is_array($result)){ /////// Comprueba si existe el $dialog_id (ya existe el dialogo)
							foreach($result as $row){
								$chat_id = $row['chat_id'];
								$sender_id = $row['sender_id'];
								$sender_chat_id = $row['sender_chat_id'];
								$receiver_id = $row['receiver_id'];
								$receiver_chat_id = $row['receiver_chat_id'];
							}
							$sql.= $ClsChat->update_chat_dialog($chat_id,$sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$dialog_id);
						}else{
							$result = $ClsChat->check_chat_dialog($sender_id,$receiver_id);
							if(is_array($result)){ /////// Comprueba si existe el $dialog_id (ya existe el dialogo)
								foreach($result as $row){
									$chat_id = $row['chat_id'];
									$sender_id = $row['sender_id'];
									$sender_chat_id = $row['sender_chat_id'];
									$receiver_id = $row['receiver_id'];
									$receiver_chat_id = $row['receiver_chat_id'];
								}
								$sql.= $ClsChat->update_chat_dialog($chat_id,$sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$dialog_id);
							}else{
								$chat_id = $ClsChat->max_chat_dialog();
								$chat_id++;
								$sql = $ClsChat->insert_chat_dialog($chat_id,$sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$dialog_id);
							}
						}
						//--
						//echo $sql;
						$rs = $ClsChat->exec_sql($sql);
						if($rs == 1){
							//devuelve un mensaje de manejo de errores
							$arr_data = array(
								"status" => "success",
								"message" => "nuevo dialogo creado exitosamente!");
								echo json_encode($arr_data);
						}else{
							//devuelve un mensaje de manejo de errores
							$arr_data = array(
								"status" => "fail",
								"message" => "error en la ejecucion de la sentencia en la BD");
								echo json_encode($arr_data);
						}	
					}else{
						//devuelve un mensaje de manejo de errores
						$arr_data = array(
							"status" => "error",
							"message" => "El codigo de dialogo esta vacio...");
							echo json_encode($arr_data);
					}
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "El codigo de chat del receptor esta vacio...");
						echo json_encode($arr_data);
				}
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "El codigo tipo de receptor esta vacio");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "El codigo de chat del emisor esta vacio...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo tipo de emisor esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_get_chat_dialog($user_id){
	$ClsChat = new ClsChat();
	
	if($user_id != ""){
		$result = $ClsChat->get_chat_dialog($user_id);
		if(is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$arr_data[$i]['chat_id'] = $row["chat_id"];
				$arr_data[$i]['sender_chat_id'] = $row["sender_chat_id"];
				$arr_data[$i]['receiver_chat_id'] = $row["receiver_chat_id"];
				$arr_data[$i]['sender_id'] = $row["sender_id"];
				$arr_data[$i]['receiver_id'] = $row["receiver_id"];
				$arr_data[$i]['dialog_id'] = $row["dialog_id"];
				$arr_data[$i]['created_at'] = $row["created_at"];
				$arr_data[$i]['updated_at'] = $row["updated_at"];
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "No exsisten dialogos activos...");
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


function API_get_chat_list($user_id){
	$ClsChat = new ClsChat();
	$ClsUsu = new ClsUsuario();
	
	if($user_id != ""){
		$result = $ClsChat->get_chat_list($user_id);
		if(is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$envio = $row["sender_cui"];
				$recibio = $row["receiver_cui"];
				if($recibio == $user_id){
					$arr_data[$i]['dialog_id'] = $row["dialog_id"];
					$arr_data[$i]['user_id'] = $row["sender_usu_id"];
					$arr_data[$i]['user_chat_id'] = $row["sender_tipo"];
					$arr_data[$i]['user_type'] = $row["sender_cui"];
					$arr_data[$i]['first_name'] = $row["sender_name"];
					$arr_data[$i]['last_name'] = $row["sender_nombre_pantalla"];
					//--
					$usuario = $row["sender_usu_id"];
					$foto = $ClsUsu->last_foto_usuario($usuario);
					if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['profile_pic'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['profile_pic'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
					}
					$arr_data[$i]['last_message'] = $row["last_message"];
				}else if($envio == $user_id){
					$arr_data[$i]['dialog_id'] = $row["dialog_id"];
					$arr_data[$i]['user_id'] = $row["receiver_usu_id"];
					$arr_data[$i]['user_chat_id'] = $row["receiver_tipo"];
					$arr_data[$i]['user_type'] = $row["receiver_cui"];
					$arr_data[$i]['first_name'] = $row["receiver_name"];
					$arr_data[$i]['last_name'] = $row["receiver_nombre_pantalla"];
					if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$row["receiver_usu_id"].'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['profile_pic'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$row["receiver_usu_id"].".jpg";
					}else{
						$arr_data[$i]['profile_pic'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
					}
					$arr_data[$i]['last_message'] = $row["last_message"];
				}else{
					$arr_data = array(
					"status" => "error",
					"message" => "no hace match con el remitente ni con el receptor...");
				}
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "No exsisten dialogos activos...");
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



function API_send_message($sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$message){
	$ClsChat = new ClsChat();
	$ClsPush = new ClsPushup();
	$ClsUsu = new ClsUsuario();
	
	if($sender_id != ""){
		if($sender_chat_id != ""){
			if($receiver_id != ""){
				if($receiver_chat_id != ""){
					if($message != "") {
						$result = $ClsUsu->get_usuario_tipo_codigo('',$sender_id);
						if(is_array($result)) {
							foreach ($result as $row){
								$nombre = $row["usu_nombre_pantalla"];
							}
						}else{
							$nombre = "Usuario";
						}
						//--
						$message_id = $ClsChat->max_message();
						$message_id++;
						$message = trim($message);
						$title = 'Chat';
						$push_tipo = 12;
						$item_id = $message_id;
						$cert_path = '../../CONFIG/push/ck_prod.pem';
						$data = array(
							'landing_page'=> 'page',
							'codigo' => $item_id
						);
						//--
						$sql = $ClsChat->insert_message($message_id,$sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$message);
						$texto = "Mensaje de $nombre (Chat): $message";
						$sql.= $ClsPush->insert_push_notification($receiver_id,$texto,$push_tipo,$item_id);
						//--
						$lFile = "debug.txt";
                        $logfh = fopen($lFile, 'a');
                        fwrite($logfh, $message."\n");
						//--
						//echo $sql;
						$rs = $ClsChat->exec_sql($sql);
						if($rs == 1){
							$result = $ClsPush->get_push_user($receiver_id);
							if(is_array($result)) {
								foreach ($result as $row){
									$user_id = $row["user_id"];
									$device_type = $row["device_type"];
									$device_token = $row["device_token"];
									$certificate_type = $row["certificate_type"];
									//cuenta las notificaciones pendientes
									$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
									//envia la push
									if($device_type == 'android') {
										SendAndroidPush($device_token, $title, "Chat", $pendientes, $push_tipo, $item_id, $sender_id, '', $data);
									}else if($device_type == 'ios') {
										SendPushiOS($device_token, $cert_path, $title, $message, $pendientes, $push_tipo, $item_id, $sender_id);
									}
								}	
							}	
							//devuelve un mensaje de manejo de errores
							$arr_data = array(
								"status" => "success",
								"message" => "nuevo mensaje enviado exitosamente!");
								echo json_encode($arr_data);
						}else{
							//devuelve un mensaje de manejo de errores
							$arr_data = array(
								"status" => "fail",
								"message" => "error en la ejecucion de la sentencia en la BD");
								echo json_encode($arr_data);
						}	
					}else{
						//devuelve un mensaje de manejo de errores
						$arr_data = array(
							"status" => "error",
							"message" => "El mensaje esta vacio...");
							echo json_encode($arr_data);
					}
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "El codigo de chat del receptor esta vacio...");
						echo json_encode($arr_data);
				}
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "El codigo tipo de receptor esta vacio");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "El codigo de chat del emisor esta vacio...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo tipo de emisor esta vacio");
			echo json_encode($arr_data);
	}
	
}




function API_get_user_details_by_chat_ids($user_id,$chat_ids){
	$ClsChat = new ClsChat();
	$ClsUsu = new ClsUsuario();
	
	if($user_id != "" && $chat_ids != ""){
		$result = $ClsChat->get_message_list($user_id,$chat_ids);
		if(is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$envio = $row["sender_usu_id"];
				$recibio = $row["receiver_usu_id"];
				if($recibio == $user_id){
					$arr_data[$i]['user_id'] = $row["sender_usu_id"];
					$arr_data[$i]['user_chat_id'] = $row["sender_tipo"];
					$arr_data[$i]['user_type'] = $row["sender_cui"];
					$arr_data[$i]['first_name'] = $row["sender_name"];
					$arr_data[$i]['last_name'] = $row["sender_nombre_pantalla"];
					$arr_data[$i]['last_message'] = $row["sender_last_message"];
					$id = $row["sender_usu_id"];
					$foto = $ClsUsu->last_foto_usuario($id);
					if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['profile_pic'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['profile_pic'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
					}
				}else if($envio == $user_id){
					$arr_data[$i]['user_id'] = $row["receiver_usu_id"];
					$arr_data[$i]['user_chat_id'] = $row["receiver_tipo"];
					$arr_data[$i]['user_type'] = $row["receiver_cui"];
					$arr_data[$i]['first_name'] = $row["receiver_name"];
					$arr_data[$i]['last_name'] = $row["receiver_nombre_pantalla"];
					$arr_data[$i]['last_message'] = $row["receiver_last_message"];
					$id = $row["receiver_usu_id"];
					$foto = $ClsUsu->last_foto_usuario($id);
					if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['profile_pic'] = "https://" . $foto . "/CONFIG/Fotos/USUARIOS/".$row["receiver_usu_id"].".jpg";
					}else{
						$arr_data[$i]['profile_pic'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
					}
				}else{
					$arr_data = array(
					"status" => "error",
					"message" => "no hace match con el remitente ni con el receptor...");
				}
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "No exsisten dialogos activos...");
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