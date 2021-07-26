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
		case "usuarios_secciones":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_secciones($tipo_usuario,$tipo_codigo);
			break;
		case "padres":
			$nivel = $_REQUEST["nivel"];
			$grado = $_REQUEST["grado"];
			$seccion = $_REQUEST["seccion"];
			API_lista_padres($nivel,$grado,$seccion);
			break;
		case "usuarios":
			$cui = $_REQUEST["cui"];
			API_lista_usuarios_CM($cui);
			break;
		case "lista_dialogos":
			$usuario = $_REQUEST["usuario"];
			API_listar_dialogos($usuario);
			break;
		case "nuevo_dialogo":
			$tipo_emisor = $_REQUEST["sender_type"];
			$emisor = $_REQUEST["sender"];
			$tipo_receptor = $_REQUEST["receiver_type"];
			$receptor = $_REQUEST["receiver"];
			$mensaje = $_REQUEST["message"];
			API_nuevo_dialogo($tipo_emisor,$emisor,$tipo_receptor,$receptor,$mensaje);
			break;
		case "depurador_dialogo":
			$dialogo = $_REQUEST["dialogo"];
			API_depurar_dialogo($dialogo);
			break;
		case "ocultar_dialogo":
			$dialogo = $_REQUEST["dialogo"];
			API_ocultar_dialogo($dialogo);
			break;
		case "lista_mensajes":
			$dialogo = $_REQUEST["dialogo"];
			$usuario = $_REQUEST["usuario"];
			API_listar_mensajes($dialogo,$usuario);
			break;
		case "enviar":
			$dialogo = $_REQUEST["dialogo"];
			$tipo_emisor = $_REQUEST["sender_type"];
			$emisor = $_REQUEST["sender"];
			$mensaje = $_REQUEST["message"];
			API_enviar_mensaje($dialogo,$tipo_emisor,$emisor,$mensaje);
			break;
		case "depurador_mensaje":
			$codigo = $_REQUEST["codigo"];
			$dialogo = $_REQUEST["dialogo"];
			API_depurar_mensaje($codigo,$dialogo);
			break;
		case "recepccion":
			$codigo = $_REQUEST["codigo"];
			$dialogo = $_REQUEST["dialogo"];
			API_recepcion_mensaje($codigo,$dialogo);
			break;
		case "visualizar":
			$dialogo = $_REQUEST["dialogo"];
			$usuario = $_REQUEST["usuario"];
			API_visualizar_mensaje($dialogo,$usuario);
			break;
		case "ocultar_mensaje":
			$codigo = $_REQUEST["codigo"];
			$dialogo = $_REQUEST["dialogo"];
			API_ocultar_mensaje($codigo,$dialogo);
			break;
		//////////////////////////////////////////////////
		case "push":
			$push_tipo = $_REQUEST["tipo"];
			$item_id = $_REQUEST["codigo"];
			$emisor = $_REQUEST["emisor"];
			$mensaje_id = $_REQUEST["mensaje_id"];
			API_envia_push($push_tipo,$item_id,$emisor,$mensaje_id);
			break;
		//////////////////////////////////////////////////
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


function API_lista_padres($nivel,$grado,$seccion){
	$ClsPad = new ClsPadre();
	$ClsPen = new ClsPensum();
	$ClsChat = new ClsChat();
	$pensum = $ClsPen->get_pensum_activo();
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
		$result = $ClsPad->get_padre_secciones($pensum,$nivel,$grado,$seccion,'','');
		if (is_array($result)) {
			$i = 0;	
			foreach ($result as $row){
				$cui = $row["pad_cui"];
				$arr_data[$i]['tipo'] = 3;
				$arr_data[$i]['cui'] = $row["pad_cui"];
				$arr_data[$i]['nombre'] = trim($row["pad_nombre"])." ".trim($row["pad_apellido"]);
				$arr_data[$i]['hijo'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['telefono'] = trim($row["pad_telefono"]);
				$arr_data[$i]['mail'] = trim($row["pad_mail"]);
				$arr_data[$i]['nickname'] = trim($row["pad_nombre_pantalla"]);
				$id = $row["pad_usu_id"];
				if(file_exists('../Fotos/USUARIOS/'.$id.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/USUARIOS/".$id.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/nofoto.png";
				}
				$result_chat = $ClsChat->get_dialogo(3,$cui);
				if(is_array($result_chat)) {
					foreach($result_chat as $row_chat){
						$arr_data[$i]['active'] = 1;
						$arr_data[$i]['last_message_date'] = $row_chat["diag_fechor_actualizacion"];
						$arr_data[$i]['last_message'] = $row_chat["ultimo_mensaje"];
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

function API_lista_usuarios_CM($cui){
	$ClsUsu = new ClsUsuario();
	$ClsChat = new ClsChat();
	//--
	$ClsPen = new ClsPensum();
	$ClsAsi = new ClsAsignacion();
	
	if($cui != ""){
		$usuarios = '';
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsAsi->get_alumno_padre($cui,"");
		if (is_array($result)) {
			foreach($result as $row){
				$alumno = $row["alu_cui"];
				//////////////////////////////////////// GRADOS ///////////////////////////
				$usuarios.= $ClsChat->get_codigos_usuarios_asignaciones($pensum,$alumno).",";
			}
			$usuarios = substr($usuarios, 0, -1);
		}else{
			$usuarios = 0;
		}
		
		$result = $ClsChat->get_cm('',$usuarios,'','',1);
		if (is_array($result)) {
			$i = 0;
			$j = 1;
			foreach ($result as $row){
				$cui = $row["cm_cui"];
				$arr_data[$i]['tipo'] = $row["usu_tipo"];
				$arr_data[$i]['cui'] = $row["cm_cui"];
				$arr_data[$i]['nombre'] = trim($row["cm_nombre"]);
				$arr_data[$i]['titulo'] = trim($row["cm_titulo"]);
				$arr_data[$i]['mail'] = trim($row["cm_mail"]);
				$hini = substr($row["cm_hora_ini"],0,-3);
				$hfin = substr($row["cm_hora_fin"],0,-3);
				$arr_data[$i]['hora_inicio'] = $hini;
				$arr_data[$i]['hora_final'] = $hfin;
				$arr_data[$i]['observaciones'] = trim($row["cm_observaciones"]);
				$status = (trim($row["cm_status"]) == 1)?true:false;
				//--
				$hini = strtotime( $hini );
				$hfin = strtotime( $hfin );
				$hora = strtotime( date("H:i") );
				$horaActivo = ($hora >= $hini && $hora <= $hfin)?true:false;
				$arr_data[$i]['status'] = $status;
				$arr_data[$i]['hora_activo'] = $horaActivo;
				//--
				$id = trim($row["usu_tipo_codigo"]);
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
				//$result_chat = $ClsChat->get_last_message($usuario_cui,$cui);
				if(is_array($result_chat)) {
					foreach($result_chat as $row_chat){
						$arr_data[$i]['last_message_date'] = $row_chat["updated_at"];
						$arr_data[$i]['last_message'] = $row_chat["message"];
					}
				}else{
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
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El CUI del usuario esta vacio...");
			echo json_encode($arr_data);
	}
}



function API_listar_dialogos($tipo_codigo){
	$ClsUsu = new ClsUsuario();
	$ClsChat = new ClsChat();
	
	if($tipo_codigo != ""){
		$hoy = date("Y-m-d");
		$result = $ClsChat->get_dialogo('',$tipo_codigo);
		if(is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$arr_data[$i]['dialogo'] = $row["diag_codigo"];
				$arr_data[$i]['nombre_otro_usuario'] = $row["otro_usuario"];
				$arr_data[$i]['ultimo_mensaje'] = $row["ultimo_mensaje"];
				$fecha = substr($row["diag_fechor_actualizacion"],0,10);
				$hora = substr($row["diag_fechor_actualizacion"],11,5);
				$compara = comparaFechas($fecha, $hoy);
				//echo "$compara = comparaFechas($fecha, $hoy); <br><br>";
				$arr_data[$i]['fecha_ultimo_mensaje'] = ($compara == 0)?$hora:cambia_fecha($fecha);
				//--
				$id = $row["otro_usuario_id"];
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
				//--
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
			"message" => "El codigo de tipo de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}



function API_nuevo_dialogo($tipo_emisor,$emisor,$tipo_receptor,$receptor,$mensaje){
	$ClsChat = new ClsChat();
	
	if($tipo_emisor != ""){
		if($emisor != ""){
			if($tipo_receptor != ""){
				if($receptor != ""){
					if($mensaje != "") {
						//--
						$mensaje = trim($mensaje);
						//--
						$dialogo = $ClsChat->max_dialogo();
						$dialogo++;
						$sql = $ClsChat->insert_dialogo($dialogo);
						$sql.= $ClsChat->insert_usuarios_dialogo($dialogo,$tipo_emisor,$emisor);
						$sql.= $ClsChat->insert_usuarios_dialogo($dialogo,$tipo_receptor,$receptor);
						$sql.= $ClsChat->insert_mensaje(1,$dialogo,$tipo_emisor,$emisor,$mensaje);
						//echo $sql;
						$rs = $ClsChat->exec_sql($sql);
						if($rs == 1){
							//devuelve un mensaje de manejo de errores
							$arr_data = array(
								"status" => "success",
								"dialogo" => $dialogo,
								"message" => "nuevo dialogo creado exitosamente!");
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
							"message" => "El mensaje esta vacio...");
							echo json_encode($arr_data);
					}
				}else{
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "error",
						"message" => "El codigo del usuario receptor esta vacio...");
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
				"message" => "El codigo del usuario emisor esta vacio...");
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


function API_depurar_dialogo($dialogo){
	$ClsChat = new ClsChat();
	
	if($dialogo != ""){
		$sql.= $ClsChat->delete_dialogo($dialogo);
		$sql.= $ClsChat->delete_usuarios_dialogo_todos($dialogo);
		$sql.= $ClsChat->delete_mensaje(1, $dialogo);
		$rs = $ClsChat->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Dialogo $dialogo eliminado ...");
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
			"message" => "El codigo de dialogo esta vacio");
			echo json_encode($arr_data);
	}
	
}



function API_ocultar_dialogo($dialogo){
	$ClsChat = new ClsChat();
	
	if($dialogo != ""){
		$sql.= $ClsChat->cambia_sit_dialogo($dialogo, 0);
		$rs = $ClsChat->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Dialogo eliminado (oculto)...");
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
			"message" => "El codigo de dialogo esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_listar_mensajes($dialogo,$usuario){
	$ClsChat = new ClsChat();
	
	if($dialogo != ""){
		$usuario = trim($usuario);
		$result = $ClsChat->get_mensajes($dialogo);
		if (is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$arr_data[$i]['codigo'] = $row["msj_codigo"];
				$arr_data[$i]['emisor'] = $row["msj_usuario_envia"];
				$arr_data[$i]['emisor_nombre'] = $row["usu_nombre_pantalla"];
				$emisor = trim($row["msj_usuario_envia"]);
				$arr_data[$i]['clase'] = ($emisor == $usuario)?"enviado":"recibido";
				$arr_data[$i]['mensaje'] = $row["msj_texto"];
				$freg = trim($row["msj_fechor_registro"]);
				$freg = date("d/m/y H:i", strtotime( $freg ) );
				$fupd = trim($row["msj_fechor_update"]);
				$fupd = date("d/m/y H:i", strtotime( $fupd ) );
				$arr_data[$i]['registrado'] = $freg;
				$arr_data[$i]['actualizado'] = $fupd;
				$arr_data[$i]['status'] = $row["msj_situacion"];
				$i++;
			}
			echo json_encode($arr_data);
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "empty",
				"message" => "No exsisten mensajes en este dialogo...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de dialogo esta vacio");
			echo json_encode($arr_data);
	}
	
}




function API_enviar_mensaje($dialogo,$tipo_emisor,$emisor,$mensaje){
	$ClsChat = new ClsChat();
	$ClsPush = new ClsPushup();
	$ClsUsu = new ClsUsuario();

	if($dialogo != ""){
		if($tipo_emisor != ""){
			if($emisor != ""){
				if($mensaje != "") {
					/// trae emisor //
					$result = $ClsUsu->get_usuario_tipo_codigo($tipo_emisor,$emisor);
					if(is_array($result)){
						foreach($result as $row){
							$nombre_emisor = trim($row["usu_nombre"]);
						}
					}
					/// trae receptores //
					$result = $ClsChat->get_usuarios_dialogo($dialogo);
					$receptores = '';
					if(is_array($result)){
						$i = 0;
						foreach($result as $row){
							$receptor = $row["dusu_usuario"];
							if($receptor != $emisor){
								$receptores = $receptor.',';
							}
						}
						$receptores = substr($receptores, 0, -1);
					}
					
					//--
					$mensaje = trim($mensaje);
					//--
					$codigo = $ClsChat->max_mensaje($dialogo);
					$codigo++;
					$sql = $ClsChat->insert_mensaje($codigo,$dialogo,$tipo_emisor,$emisor,$mensaje);
					$sql.= $ClsChat->update_dialogo($dialogo);
					
					$result = $ClsPush->get_users($receptores);
					/// registra la notificacion //
					if(is_array($result)) {
						$title = 'Chat: Mensaje de '.$nombre_emisor;
						$message = "$title, $mensaje";
						$push_tipo = 12;
						$item_id = $dialogo;
						$cert_path = '../../CONFIG/push/ck_prod.pem';
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
					
					$rs = $ClsChat->exec_sql($sql);
					if($rs == 1){
						//devuelve un mensaje de manejo de errores
						$arr_data = array(
							"status" => "success",
							"codigo" => $codigo,
							"dialogo" => intval($dialogo),
							"message" => "nuevo mensaje enviado exitosamente!");
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
						"message" => "El mensaje esta vacio...");
						echo json_encode($arr_data);
				}
			}else{
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "El codigo del usuario emisor esta vacio...");
					echo json_encode($arr_data);
			}
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "El codigo tipo de emisor esta vacio");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de dialogo esta vacio");
			echo json_encode($arr_data);
	}
	
}



function API_depurar_mensaje($codigo,$dialogo){
	$ClsChat = new ClsChat();

	if($dialogo != ""){
		if($codigo != ""){
			$sql = $ClsChat->delete_mensaje($codigo, $dialogo);
			$rs = $ClsChat->exec_sql($sql);
			if($rs == 1){
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "Mensaje Código: $codigo, Dialogo: $dialogo, eliminado exitosamente!");
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
				"message" => "El codigo tipo de mensaje esta vacio");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de dialogo esta vacio");
			echo json_encode($arr_data);
	}
	
}




function API_recepcion_mensaje($codigo,$dialogo){
	$ClsChat = new ClsChat();

	if($codigo != ""){
		if($dialogo != ""){
			$sql = $ClsChat->status_mensaje($codigo,$dialogo,2);
			$rs = $ClsChat->exec_sql($sql);
			if($rs == 1){
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "mensaje recibido...");
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
				"message" => "El codigo de dialogo esta vacio");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de mensaje esta vacio");
			echo json_encode($arr_data);
	}
	
}




function API_visualizar_mensaje($dialogo,$usuario){
	$ClsChat = new ClsChat();

	if($dialogo != ""){
		$sql = $ClsChat->visualizar_todos_mensajes($dialogo);
		$rs = $ClsChat->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "mensajes visualizados...");
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
			"message" => "El codigo de dialogo esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_ocultar_mensaje($codigo,$dialogo){
	$ClsChat = new ClsChat();

	if($codigo != ""){
		if($dialogo != ""){
			$sql = $ClsChat->status_mensaje($codigo,$dialogo,0);
			$rs = $ClsChat->exec_sql($sql);
			if($rs == 1){
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "mensaje eliminado (oculto)...");
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
				"message" => "El codigo de dialogo esta vacio");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El codigo de mensaje esta vacio");
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



///////////////////////////////////////// NOTIFICACIONES ///////////////////////////////////////////


function API_envia_push($push_tipo,$item_id,$emisor,$mensaje_id){
	$ClsChat = new ClsChat();
	$ClsPush = new ClsPushup();
	if($item_id !=""){
		///// Ejecuta notificaciones push
		$result = $ClsChat->get_push_notification_user($emisor,$push_tipo,$item_id,$mensaje_id);
		if(is_array($result)) {
			foreach ($result as $row){
				$user_id = $row["user_id"];
				$device_type = $row["device_type"];
				$device_token = $row["device_token"];
				$certificate_type = $row["certificate_type"];
				$target = $row["target"];
				//---
				$title = 'Mensaje del Chat:';
				$message = trim($row["msj_texto"]);
				//cuenta las notificaciones pendientes
				$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
				//--
				$data = array(
				   'landing_page'=> 'chatmensajes',
				   'codigo' => $item_id
				);
				//envia la push
				if($device_type == 'android') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
				}else if($device_type == 'ios') {
					SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
				}	
			}
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
			"status" => "success",
			"message" => "Notificaciones enviadas satisfactoriamente...");
			echo json_encode($arr_data);
		} else {
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
			"status" => "error",
			"message" => "Esta notificación no existe...");
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


?>