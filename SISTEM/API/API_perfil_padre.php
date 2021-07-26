<?php
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos

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
		case "get_padre":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_get_padre($tipo_usuario,$tipo_codigo);
			break;
		case "get_hijos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			API_lista_hijos($tipo_usuario,$tipo_codigo);
			break;
		case "update_padre":
			$usuario = $_REQUEST['usuario'];
			$cui = $_REQUEST['cui'];
			$campo = $_REQUEST['campo'];
			$valor = $_REQUEST['valor'];
			API_update_padre($usuario,$cui,$campo,$valor);
			break;
		case "update_hijo":
			$usuario = $_REQUEST['usuario'];
			$cui = $_REQUEST['cui'];
			$campo = $_REQUEST['campo'];
			$valor = $_REQUEST['valor'];
			API_update_hijo($usuario,$cui,$campo,$valor);
			break;
		case "new_usuario_padre":
			$data = $_REQUEST['data'];
			API_new_usuario_padre($data);
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
				//-
				$foto = $row['usu_foto'];
			}
			
			/// USUARIO
			$arr_data['codigo'] = $codigo;
			$arr_data['cui'] = $tipo_codigo;
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


function API_lista_hijos($tipo_usuario,$tipo_codigo){
	$ClsAsi = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsSeg = new ClsSeguro();
	
	if($tipo_codigo != ""){
		if($tipo_usuario === "3"){
			/// PENSUM ////
			$pensum = $ClsPen->get_pensum_activo();
			/// ALUMNOS ////
			$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
			if (is_array($result)) {
				$i = 0;
				foreach($result as $row){
					$cui = $row["alu_cui"];
					$arr_data[$i]['cui'] = $row["alu_cui"];
					$arr_data[$i]['tipo_cui'] = $row["alu_tipo_cui"];
					$arr_data[$i]['codigo_interno'] = $row["alu_codigo_interno"];
					$arr_data[$i]['nombre'] = trim($row["alu_nombre"]);
					$arr_data[$i]['apellido'] = trim($row["alu_apellido"]);
					$arr_data[$i]['fecha_nacimiento'] = cambia_fecha($row["alu_fecha_nacimiento"]);
					$arr_data[$i]['edad'] = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
					$arr_data[$i]['genero'] = $row["alu_genero"];
					$arr_data[$i]['tipo_sangre'] = $row["alu_tipo_sangre"];
					$arr_data[$i]['alergico_a'] = $row["alu_alergico_a"];
					$arr_data[$i]['en_caso_emergencia'] = $row["alu_emergencia"];
					$arr_data[$i]['telefono_emergencia'] = $row["alu_emergencia_telefono"];
					$arr_data[$i]['cliente_nit'] = trim($row["alu_nit"]);
					$arr_data[$i]['cliente_nombre'] = trim($row["alu_cliente_nombre"]);
					$arr_data[$i]['cliente_direccion'] = trim($row["alu_cliente_direccion"]);
					//--
					$foto = $row["alu_foto"];
					if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
					}else{
						$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
					}
					$result_academ = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
					if(is_array($result_academ)){
						foreach($result_academ as $row_academ){
							$arr_data[$i]['nivel'] = trim($row_academ["niv_descripcion"]);
							$arr_data[$i]['grado'] = trim($row_academ["gra_descripcion"]);
						}
					}
					$result_academ = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
					if(is_array($result_academ)){
						foreach($result_academ as $row_academ){
							$arr_data[$i]['seccion'] = trim($row_academ["sec_descripcion"]);
						}
					}
					//////// SEGURO /////////
					$result_seguro = $ClsSeg->get_seguro($cui);
					if(is_array($result_seguro)){
						$j = 0;
						foreach($result_seguro as $row_seguro){
							$seguro = trim($row_seguro["seg_tiene_seguro"]);
							$arr_seguro[$j]['tiene_seguro'] = ($seguro == 1)?'SI':'NO';
							$arr_seguro[$j]['poliza'] = trim($row_seguro["seg_poliza"]);
							$arr_seguro[$j]['aseguradora'] = trim($row_seguro["seg_aseguradora"]);
							$arr_seguro[$j]['plan'] = trim($row_seguro["seg_plan"]);
							$arr_seguro[$j]['asegurado_principla'] = trim($row_seguro["seg_asegurado_principal"]);
							$arr_seguro[$j]['instrucciones'] = trim($row_seguro["seg_instrucciones"]);
							$arr_seguro[$j]['comentario'] = trim($row_seguro["seg_comentarios"]);
						}
						
					}else{
						$j = 0;
						$arr_seguro[$j]['tiene_seguro'] = "";
						$arr_seguro[$j]['poliza'] = "";
						$arr_seguro[$j]['aseguradora'] = "";
						$arr_seguro[$j]['plan'] = "";
						$arr_seguro[$j]['asegurado_principla'] = "";
						$arr_seguro[$j]['instrucciones'] = "";
						$arr_seguro[$j]['comentario'] = "";
					}
					$arr_data[$i]['seguro'] = $arr_seguro;
					//--
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


function API_get_padre($tipo_usuario,$cui){
	$ClsPad = new ClsPadre();
	$ClsUsu = new ClsUsuario();
	
	if($cui != ""){
		if($tipo_usuario == 3){
			$result = $ClsPad->get_padre($cui,'','',1);
			if(is_array($result)){
				$i = 0;
				foreach($result as $row){
					$arr_data[$i]['usuario'] = $row["pad_usu_id"];
					$arr_data[$i]['cui'] = $row["pad_cui"];
					$arr_data[$i]['tipo_dpi'] = $row["pad_tipo_dpi"];
					$arr_data[$i]['nombre'] = $row["pad_nombre"];
					$arr_data[$i]['apellido'] = $row["pad_apellido"];
					$arr_data[$i]['mail'] = $row["pad_mail"];
					$arr_data[$i]['telefono'] = trim($row["pad_telefono"]);
					$arr_data[$i]['celular'] = trim($row["pad_celular"]);
					$arr_data[$i]['direccion'] = trim($row["pad_direccion"]);
					$arr_data[$i]['fecha_nacimiento'] = cambia_fecha($row["pad_fec_nac"]);
					$parentesco = trim($row["pad_parentesco"]);
					switch($parentesco){
						case "P": $parentesco = "PADRE"; break;
						case "M": $parentesco = "MADRE"; break;
						case "A": $parentesco = "ABUELO(A)"; break;
						case "O": $parentesco = "TUTOR O ENCARGADO"; break;
						default: $parentesco = "TUTOR O ENCARGADO"; break;
					}
					$arr_data[$i]['parentesco'] = $parentesco;
					$ecivil = trim($row["pad_estado_civil"]);
					$ecivil = ($ecivil == "C")?"CASADO":"SOLTERO";
					$arr_data[$i]['estado_civil'] = $ecivil;
					$arr_data[$i]['nacionalidad'] = trim($row["pad_nacionalidad"]);
					$arr_data[$i]['lugar_trabajo'] = trim($row["pad_lugar_trabajo"]);
					$arr_data[$i]['telefono_trabajo'] = trim($row["pad_telefono_trabajo"]);
					$arr_data[$i]['profesion'] = trim($row["pad_profesion"]);
					//--
					$id = $row["pad_usu_id"];
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
					"message" => "No existen secciones con estos parametros, en las que impartan clases este maestro...");
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
			"message" => "El CUI de usuario esta vacio");
			echo json_encode($arr_data);
	}
	
}


function API_update_padre($usuario,$cui,$campo,$valor){
	$ClsUsu = new ClsUsuario();
    $ClsPad = new ClsPadre();

	if($cui !="" && $usuario !="" && $campo != "" && $valor != ""){
		switch($campo){
			case "tipo_dpi": $db_field = "pad_tipo_dpi";break;
			case "nombre": $db_field = "pad_nombre";break;
			case "apellido": $db_field = "pad_apellido";break;
			case "fecnac":
				$valor = substr($valor,0,10);
				$db_field = "pad_fec_nac";break;
			case "parentesco": $db_field = "pad_parentesco";break;
			case "ecivil": $db_field = "pad_estado_civil";break;
			case "nacionalidad": $db_field = "pad_nacionalidad";break;
			case "telefono": $db_field = "pad_telefono";break;
			case "celular": $db_field = "pad_celular";break;
			case "mail": $db_field = "pad_mail";break;
			case "direccion": $db_field = "pad_direccion";break;
			case "departamento": $db_field = "pad_departamento";break;
			case "municipio": $db_field = "pad_municipio";break;
			case "trabajo": $db_field = "pad_lugar_trabajo";break;
			case "teltrabajo": $db_field = "pad_telefono_trabajo";break;
			case "profesion": $db_field = "pad_profesion";break;
		}
		
		$sql = $ClsPad->modificar_campo($db_field,$valor,$cui);
		////// USUSARIO ///////
		if($campo == "nombre"){
			$usu_field = "usu_nombre_pantalla";
			$sql.= $ClsUsu->modificar_campo($usuario,$usu_field,$valor);
		}
		if($campo == "mail"){
			$usu_field = "usu_mail";
			$sql.= $ClsUsu->modificar_campo($usuario,$usu_field,$valor);
		}
		if($campo == "celular"){
			$usu_field = "usu_telefono";
			$sql.= $ClsUsu->modificar_campo($usuario,$usu_field,$valor);
		}
		//echo $sql."<br>";
		$rs = $ClsPad->exec_sql($sql);
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
}



function API_update_hijo($usuario,$cui,$campo,$valor){
	$ClsAlu = new ClsAlumno();
	$ClsSeg = new ClsSeguro();
    
	if($usuario !="" && $cui !="" && $campo != "" && $valor != ""){
		switch($campo){
			case "tipo_cui": $db_field = "alu_tipo_cui";break;
			case "nombre": $db_field = "alu_nombre";break;
			case "apellido": $db_field = "alu_apellido";break;
			case "fecnac":
				$valor = substr($valor,0,10);
				$db_field = "alu_fecha_nacimiento";break;
			case "nacionalidad": $db_field = "alu_nacionalidad";break;
			case "religion": $db_field = "alu_religion";break;
			case "idioma": $db_field = "alu_idioma";break;
			case "genero": $db_field = "alu_genero";break;
			case "sangre": $db_field = "alu_tipo_sangre";break;
			case "alergico": $db_field = "alu_alergico_a";break;
			case "emergencia": $db_field = "alu_emergencia";break;
			case "tel_emergencia": $db_field = "alu_emergencia_telefono";break;
			case "cliente": $db_field = "alu_cliente_factura";break;
			case "mail": $db_field = "alu_mail";break;
			case "recoge": $db_field = "alu_recoge";break;
			case "redes_sociales": $db_field = "alu_redes_sociales";break;
			case "cliente_nit": $db_field = "alu_nit";break;
			case "cliente_nombre": $db_field = "alu_cliente_nombre";break;
			case "cliente_direccion": $db_field = "alu_cliente_direccion";break;
			default: $db_field = "";
		}
		if($db_field != ""){
			$sql = $ClsAlu->modificar_campo($usuario,$db_field,$valor,$cui);
		}
		////// SEGURO ///////
		if($campo == "seguro"){
			if(trim($valor) == 'SI' || trim($valor) == 'Si' || trim($valor) == 'si' || trim($valor) == 'sI'){
				$valor = 1;
			}else if(trim($valor) == 'NO' || trim($valor) == 'No' || trim($valor) == 'no' || trim($valor) == 'nO'){
				$valor = 0;
			}else{
				$valor = 0;
			}
			$seg_field = "seg_tiene_seguro";
			$sql.= $ClsSeg->modificar_campo($usuario,$seg_field,$valor,$cui);
		}
		if($campo == "poliza"){
			$db_field = "seg_poliza";
			$sql.= $ClsSeg->modificar_campo($usuario,$db_field,$valor,$cui);
		}
		if($campo == "aseguradora"){
			$seg_field = "seg_aseguradora";
			$sql.= $ClsSeg->modificar_campo($usuario,$seg_field,$valor,$cui);
		}
		if($campo == "plan"){
			$seg_field = "seg_plan";
			$sql.= $ClsSeg->modificar_campo($usuario,$seg_field,$valor,$cui);
		}
		if($campo == "asegurado"){
			$seg_field = "seg_asegurado_principal";
			$sql.= $ClsSeg->modificar_campo($usuario,$seg_field,$valor,$cui);
		}
		if($campo == "instrucciones"){
			$seg_field = "seg_instrucciones";
			$sql.= $ClsSeg->modificar_campo($usuario,$seg_field,$valor,$cui);
		}
		if($campo == "comentarios"){
			$seg_field = "seg_comentarios";
			$sql.= $ClsSeg->modificar_campo($usuario,$seg_field,$valor,$cui);
		}
		$rs = $ClsAlu->exec_sql($sql);
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
			"message" => "Algunos datos estan vacios..");
			echo json_encode($arr_data);
	}
}




function API_new_usuario_padre($data){
	$ClsUsu = new ClsUsuario();
    $ClsPad = new ClsPadre();
	$ClsAsi = new ClsAsignacion();
	
	$data = json_decode(stripslashes($data), true);
    
	$tipo_codigo = $data[0]["cui"];
	$tipo_usuario = $data[0]["tipo_usuario"];
	if($tipo_codigo != ""){
		if($tipo_usuario === "3"){
			$cui = $data[0]["cui"];
			//pasa a mayusculas
				$nom = trim($data[0]["nombre"]);
				$ape = trim($data[0]["apellido"]);
				$parentesco = trim($data[0]["parentesco"]);
			//--------
			//decodificaciones de tildes y Ñ's
				$nom = utf8_encode($nom);
				$ape = utf8_encode($ape);
				//--
				$nom = trim($nom);
				$ape = trim($ape);
				$parentesco = trim($parentesco);
			//--------
			//pasa a minusculas
				$mail = strtolower($data[0]["mail"]);
			//--------
			//desgloza datos
				$tel = trim($data[0]["telefono"]);
			//--------
			if($cui !="" && $nom !="" && $ape != "" && $tel != "" && $mail != ""){
				//////// CREA PADRE Y ENLAZA A HIJO O HIJOS
				$sql = $ClsPad->insert_padre($cui,$nom,$ape,$parentesco,$tel,$mail,'',''); /// Inserta
				/// enlaza a hijos //
				$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
				if (is_array($result)) {
					foreach($result as $row){
						$cui_hijo = $row["alu_cui"];
						$sql.= $ClsAsi->asignacion_alumno_padre($cui,$cui_hijo); /// CUI padre y CUI Hijo
					}
				}
				////////// CREA USUARIO
				$pass = Generador_Contrasena();
				$pass = $ClsUsu->decrypt($pass,$mail);
				$id = $ClsUsu->max_usuario();
				$id++; /// Maximo codigo
				$sql.= $ClsUsu->insert_usuario($id,"$nom $ape","$nom $ape",$mail,$tel,3,$cui,$mail,$pass,1);
				$rs = $ClsPad->exec_sql($sql);
				if($rs == 1){
					$mail = mail_usuario($id,"$nom $ape",$mail);
					if($mail == 1){
						$span = '(Un correo ha sido enviado para activar su usuario...);';
						$flag = true;
					}else{
						$span = '(para activar el usuario por favor contacte al administrador....);';
						$flag = false;
					}
					//devuelve un mensaje de manejo de errores
					$arr_data = array(
						"status" => "success",
						"codigo_usuario" => "$id",
						"mailflag" => "$flag",
						"message" => "Usuario Creado Satisfactoriamente.... ".$span);
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
				"message" => "Este usuario no pertenece al grupo de padres...");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "El CUI de usuario esta vacio....");
			echo json_encode($arr_data);
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






////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

function mail_usuario($id,$nombre,$mail){
		
	// Instancia el API KEY de Mandrill
	$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
	//--
	// Create the email and send the message
	$to = array(
			array(
				'email' => $mail,
				'name' => $nombre,
				'type' => 'to'
			)
	);
	/////////////_________ Correo a admin
	$ClsUsu = new ClsUsuario();
	$hashkey = $ClsUsu->encrypt($id, "clave");
	$absolute_url = full_url( $_SERVER );
	$absolute_url = str_replace("SISTEM/API/API_perfil_padre.php","PADRES/",$absolute_url);
	//$absolute_url = str_replace("/CPOTROUSU/prueba.php","",$absolute_url);
	$subject = "Bienvenido a ASMS";
	$cuerpo = "Han generado un nuevo usuario para ti.\n\n"."Aqui estan los detalles:\n\nHaz clcik en el link para activar tu usuario\n\n ";
	$cuerpo.= $absolute_url.'/CPVALIDA/FRMactivate.php?hashkey='.$hashkey.' Click para Activar el Usuario';
	$cuerpo.= "\n\nQue pases un feliz dia!!!";
	try{
	
		$message = array(
			'subject' => $subject,
			'text' => $cuerpo,
			'from_email' => 'noreply@inversionesd.com',
			'to' => $to
		 );
		 
		 //print_r($message);
		 //echo "<br>";
		 $result = $mandrill->messages->send($message);
		 $validacion =  1;
	} catch(Mandrill_Error $e) { 
		//echo "<br>";
		//print_r($e);
		//devuelve un mensaje de manejo de errores
		$validacion =  0;
	}         
		
	return $validacion;
}

