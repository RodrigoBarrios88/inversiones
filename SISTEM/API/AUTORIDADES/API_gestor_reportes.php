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
		case "alumnos":
			$tipo_usuario = $_REQUEST["tipo"];
			$tipo_codigo = $_REQUEST["codigo"];
			$nombre = $_REQUEST["alu_nombre"];
			API_alumnos($tipo_usuario,$tipo_codigo,$nombre);
			break;
		/////////////////////////////////////////////////////
		case "lista_panial":
			$alumno = $_REQUEST["alumno"];
			API_lista_panial($alumno);
			break;
		case "new_panial":
			$data = $_REQUEST["data"];
			API_new_panial($data);
			break;
		case "update_panial":
			$data = $_REQUEST["data"];
			API_update_panial($data);
			break;
		case "delete_panial":
			$codigo = $_REQUEST["codigo"];
			API_delete_panial($codigo);
			break;
        //////////////////////////////////////////////////
		case "lista_golpe":
			$alumno = $_REQUEST["alumno"];
			API_lista_golpe($alumno);
			break;
		case "new_golpe":
			$data = $_REQUEST["data"];
			API_new_golpe($data);
			break;
		case "update_golpe":
			$data = $_REQUEST["data"];
			API_update_golpe($data);
			break;
		case "delete_golpe":
			$codigo = $_REQUEST["codigo"];
			API_delete_golpe($codigo);
			break;
        //////////////////////////////////////////////////
		case "lista_enfermedad":
			$alumno = $_REQUEST["alumno"];
			API_lista_enfermedad($alumno);
			break;
		case "new_enfermedad":
			$data = $_REQUEST["data"];
			API_new_enfermedad($data);
			break;
		case "update_enfermedad":
			$data = $_REQUEST["data"];
			API_update_enfermedad($data);
			break;
		case "delete_enfermedad":
			$codigo = $_REQUEST["codigo"];
			API_delete_enfermedad($codigo);
			break;
		//////////////////////////////////////////////////
		case "lista_conducta":
			$alumno = $_REQUEST["alumno"];
			API_lista_conducta($alumno);
			break;
		case "new_conducta":
			$data = $_REQUEST["data"];
			API_new_conducta($data);
			break;
		case "update_conducta":
			$data = $_REQUEST["data"];
			API_update_conducta($data);
			break;
		case "delete_conducta":
			$codigo = $_REQUEST["codigo"];
			API_delete_conducta($codigo);
			break;
		//////////////////////////////////////////////////
		case "push":
			$push_tipo = $_REQUEST["tipo"];
			$item_id = $_REQUEST["codigo"];
			API_envia_push($push_tipo,$item_id);
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
					$genero = trim($row["alu_genero"]);
					//--
					$grado_desc = trim($row["gra_descripcion"]);
					$seccion_desc = trim($row["sec_descripcion"]);
					$grado_completo = $grado_desc." ".$seccion_desc;
					//--
					$arr_data[$i]['cui'] = $cui;
					$arr_data[$i]['nombre'] = $nombres;
					$arr_data[$i]['genero'] = $genero;
					$arr_data[$i]['seccion_descripcion'] = $grado_completo;
					$arr_data[$i]['pensum'] = $pensum;
					$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
					$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
					$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
					//--
					$foto = $row["alu_foto"];
					if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
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
					$genero = trim($row["alu_genero"]);
					//--
					$grado_desc = trim($row["gra_descripcion"]);
					$seccion_desc = trim($row["sec_descripcion"]);
					$grado_completo = $grado_desc." ".$seccion_desc;
					//--
					$arr_data[$i]['cui'] = $cui;
					$arr_data[$i]['nombre'] = $nombres;
					$arr_data[$i]['genero'] = $genero;
					$arr_data[$i]['seccion_descripcion'] = $grado_completo;
					$arr_data[$i]['pensum'] = $pensum;
					$arr_data[$i]['nivel'] = trim($row["niv_codigo"]);
					$arr_data[$i]['grado'] = trim($row["gra_codigo"]);
					$arr_data[$i]['seccion'] = trim($row["sec_codigo"]);
					//--
					$foto = $row["alu_foto"];
					if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
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

///////////////////////////////////////// REPORTE DE PAÑAL ///////////////////////////////////////////

function API_lista_panial($alumno){
	$ClsPan = new ClsPanial();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($alumno != ""){
		$i = 0;
		$result = $ClsPan->get_panial('',$pensum,'','','',$alumno);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["pan_codigo"];
				$grado = trim($row["pan_grado_desc"]);
				$seccion = trim($row["pan_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["pan_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Pañal';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$pipi = trim($row["pan_cant_pipi"]);
				$popo = trim($row["pan_cant_popo"]);
				$tipo = trim($row["pan_tipo"]);
				$obs = trim($row["pan_observaciones"]);
				$obs = ($obs == "")?"Ninguna":$obs;
$cuerpo = "
Deseamos informar que el día de hoy cambiamos el pañal de su hijo(a): $alumno.\r\n
Veces con pipi: $pipi.
Veces con popo: $popo.
Consistencia: $tipo.
Observaciones: $obs.
";
				//--
				$arr_data[$i]['pipi'] = $pipi;
				$arr_data[$i]['popo'] = $popo;
				$arr_data[$i]['consistencia'] = $tipo;
				$arr_data[$i]['observaciones'] = $obs;
				
				$arr_data[$i]['descripcion'] = $cuerpo;
				$fecha = $row["pan_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
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
	
}



function API_new_panial($data){
	$ClsPan = new ClsPanial();
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$ClsPush = new ClsPushup();
	$ClsAlu = new ClsAlumno();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$pensum = $ClsPen->get_pensum_activo();
		$nivel = trim($data[0]["nivel"]);
		$grado = trim($data[0]["grado"]);
		$seccion = trim($data[0]["seccion"]);
		$usuario = trim($data[0]["usuario"]);
		$alumno = trim($data[0]["alumno"]);
		$pipi = trim($data[0]["pipi"]);
		$popo = trim($data[0]["popo"]);
		$tipo = trim($data[0]["consistencia"]);
		$obs = trim($data[0]["obs"]);
		$obs = ($obs == "")?"Ninguna":$obs;
		///-
		$result_alumno = $ClsAlu->get_alumno($alumno);
		if(is_array($result_alumno)){
			foreach($result_alumno as $row_alumno){
				$alumno_nombre = trim($row_alumno["alu_nombre"])." ".trim($row_alumno["alu_apellido"]);
			}
		}
$cuerpo = "
Deseamos informar que el día de hoy cambiamos el pañal de su hijo(a): $alumno_nombre.\r\n
Veces con pipi: $pipi.
Veces con popo: $popo.
Consistencia: $tipo.
Observaciones: $obs.
";
		//--
		$cuerpo = trim($cuerpo);
		//--------
		if($alumno !="" && $usuario !=""){
			$codigo = $ClsPan->max_panial();
			$codigo++;
			$sql = $ClsPan->insert_panial($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$pipi,$popo,$tipo,$obs,$usuario);
			$result = $ClsPush->get_alumnos_users($alumno);
    		
			/// registra la notificacion //
			if(is_array($result)) {
				$title = 'Nuevo Reporte de Pañal';
				$message = $cuerpo;
				$push_tipo = 7;
				$item_id = $codigo;
				$cert_path = '../../CONFIG/push/ck_prod.pem';
				//--
				$UsuarioRepetido = ''; // valida que no repita el insert de la push
				foreach ($result as $row){
					$user_id = $row["user_id"];
					$device_id = $row["device_id"];
					if($UsuarioRepetido != $user_id && $device_id != ""){
						$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id,$alumno);
						$UsuarioRepetido = $user_id;
					}
    			}
			}
		    
			$rs = $ClsPan->exec_sql($sql);
			if($rs == 1){
			    ///// Ejecuta notificaciones push
    			$url = "https://" . $_SERVER['HTTP_HOST'] . "/SISTEM/API/API_reportes.php?request=detalle_panial&codigo=" . $codigo;
    			//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"codigo" => $codigo,
				"message" => "Reporte  #$codigo creado satisfactoriamente...",
				"review" => "$url");
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


function API_update_panial($data){
	$ClsPan = new ClsPanial();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$codigo = trim($data[0]["codigo"]);
		$alumno = trim($data[0]["alumno"]);
		$pipi = trim($data[0]["pipi"]);
		$popo = trim($data[0]["popo"]);
		$tipo = trim($data[0]["consistencia"]);
		$obs = trim($data[0]["obs"]);
		$obs = ($obs == "")?"Ninguna":$obs;
		//--------
		if($codigo !="" && $alumno !=""){
			$sql = $ClsPan->modifica_panial($codigo,$alumno,$pipi,$popo,$tipo,$obs);
			$rs = $ClsPan->exec_sql($sql);
			//echo $sql;
			if($rs == 1){
				$url = "https://" . $_SERVER['HTTP_HOST'] . "/SISTEM/API/API_reportes.php?request=detalle_panial&codigo=" . $codigo;
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"message" => "Reporte actualizado satisfactoriamente....",
				"review" => "$url");
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


function API_delete_panial($codigo){
	$ClsPan = new ClsPanial();
	$ClsPush = new ClsPushup();
	if($codigo != ""){
		$sql = $ClsPan->delete_panial($codigo);
		$sql.= $ClsPush->delete_push_especifica(7,$codigo);
		$rs = $ClsPan->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Reporte eliminado satisfactoriamente....");
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


///////////////////////////////////////// REPORTE DE GOLPE ///////////////////////////////////////////


function API_lista_golpe($alumno){
	$ClsGol = new ClsGolpe();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($alumno != ""){
		$i = 0;
		$result = $ClsGol->get_golpe('',$pensum,'','','',$alumno);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["gol_codigo"];
				$grado = trim($row["gol_grado_desc"]);
				$seccion = trim($row["gol_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["gol_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);;
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Golpe';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$lugar = trim($row["gol_lugar"]);
				$hora = trim($row["gol_hora"]);
				$desc = trim($row["gol_descripcion"]);
				$accion = trim($row["gol_medida"]);
				$dosis = trim($row["gol_dosis"]);
$cuerpo = "
Estimados Señores:
Nos dirigimos a ustedes para informarles con mucha pena que su hijo(a) $alumno se lastimó, a continuación los detalles:
Lugar: $lugar.
Hora: $hora.
Parte del Cuerpo lastimada y Descripción del Golpe: $desc.
Acción y medicamento: $accion.
Dosis: $dosis.
";
                 //--		
				$arr_data[$i]['lugar'] = trim($row["gol_lugar"]);
				$arr_data[$i]['hora'] = trim($row["gol_hora"]);
				$arr_data[$i]['descripcion'] = trim($row["gol_descripcion"]);
				$arr_data[$i]['accion'] = trim($row["gol_medida"]);
				$arr_data[$i]['dosis'] = trim($row["gol_dosis"]);
				//
				$arr_data[$i]['cuerpo'] = $cuerpo;
				$fecha = $row["gol_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
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
	
}


function API_new_golpe($data){
	$ClsGol = new ClsGolpe();
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$ClsPush = new ClsPushup();
	$ClsAlu = new ClsAlumno();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$pensum = $ClsPen->get_pensum_activo();
		$nivel = trim($data[0]["nivel"]);
		$grado = trim($data[0]["grado"]);
		$seccion = trim($data[0]["seccion"]);
		$usuario = trim($data[0]["usuario"]);
		$alumno = trim($data[0]["alumno"]);
		$lugar = trim($data[0]["lugar"]);
		$hora = trim($data[0]["hora"]);
		$desc = trim($data[0]["descripcion"]);
		$medida = trim($data[0]["medida"]);
		$dosis = trim($data[0]["dosis"]);
		///-
		$result_alumno = $ClsAlu->get_alumno($alumno);
		if(is_array($result_alumno)){
			foreach($result_alumno as $row_alumno){
				$alumno_nombre = trim($row_alumno["alu_nombre"])." ".trim($row_alumno["alu_apellido"]);
			}
		}
$cuerpo = "
Estimados Señores:
Nos dirigimos a ustedes para informarles con mucha pena que su hijo(a) $alumno_nombre se lastimó, a continuación los detalles:
Lugar: $lugar.
Hora: $hora.
Parte del Cuerpo lastimada y Descripción del Golpe: $desc.
Acción y medicamento: $accion.
Dosis: $dosis.
";
		//--
		$cuerpo = trim($cuerpo);
		//--------
		if($alumno !="" && $usuario !=""){
			$codigo = $ClsGol->max_golpe();
			$codigo++;
			$sql = $ClsGol->insert_golpe($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$lugar,$hora,$desc,$medida,$dosis,$usuario);
			$result = $ClsPush->get_alumnos_users($alumno);
    		
			/// registra la notificacion //
			if(is_array($result)) {
				$title = 'Reporte de Golpe';
				$message = $cuerpo;
				$push_tipo = 8;
				$item_id = $codigo;
				$cert_path = '../../CONFIG/push/ck_prod.pem';
				//--
				$UsuarioRepetido = ''; // valida que no repita el insert de la push
				foreach ($result as $row){
					$user_id = $row["user_id"];
					$device_id = $row["device_id"];
					if($UsuarioRepetido != $user_id && $device_id != ""){
						$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id,$alumno);
						$UsuarioRepetido = $user_id;
					}
    			}
			}
		    
			$rs = $ClsGol->exec_sql($sql);
			if($rs == 1){
			    $url = "https://" . $_SERVER['HTTP_HOST'] . "/SISTEM/API/API_reportes.php?request=detalle_golpe&codigo=" . $codigo;
    			//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"codigo" => $codigo,
				"message" => "Reporte  #$codigo creado satisfactoriamente...",
				"review" => "$url");
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


function API_update_golpe($data){
	$ClsGol = new ClsGolpe();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$codigo = trim($data[0]["codigo"]);
		$alumno = trim($data[0]["alumno"]);
		$lugar = trim($data[0]["lugar"]);
		$hora = trim($data[0]["hora"]);
		$desc = trim($data[0]["descripcion"]);
		$medida = trim($data[0]["medida"]);
		$dosis = trim($data[0]["dosis"]);
		//--------
		if($codigo !="" && $alumno !=""){
			$sql = $ClsGol->modifica_golpe($codigo,$alumno,$lugar,$hora,$desc,$medida,$dosis);
			$rs = $ClsGol->exec_sql($sql);
			//echo $sql;
			if($rs == 1){
				$url = "https://" . $_SERVER['HTTP_HOST'] . "/SISTEM/API/API_reportes.php?request=detalle_golpe&codigo=" . $codigo;
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"message" => "Reporte actualizado satisfactoriamente....",
				"review" => "$url");
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


function API_delete_golpe($codigo){
	$ClsGol = new ClsGolpe();
	$ClsPush = new ClsPushup();
	if($codigo != ""){
		$sql = $ClsGol->delete_golpe($codigo);
		$sql.= $ClsPush->delete_push_especifica(8,$codigo);
		$rs = $ClsGol->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Reporte eliminado satisfactoriamente....");
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


///////////////////////////////////////// REPORTE DE ENFERMEDAD ///////////////////////////////////////////

function API_lista_enfermedad($alumno){
	$ClsEnf = new ClsEnfermedad();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($alumno != ""){
		$i = 0;
		$result = $ClsEnf->get_enfermedad('',$pensum,'','','',$alumno);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["enf_codigo"];
				$grado = trim($row["enf_grado_desc"]);
				$seccion = trim($row["enf_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["enf_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);;
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Enfermedad';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$sintomas = trim($row["enf_sintomas"]);
				$hora = trim($row["enf_hora"]);
				$aviso = trim($row["enf_aviso"]);
				$accion = trim($row["enf_medida"]);
				$dosis = trim($row["enf_dosis"]);
$cuerpo = "
Estimados Señores:
Nos dirigimos a ustedes para informarles con mucha pena que su hijo(a) $alumno se sintió mal, a continuación los detalles:
Sintomas: $sintomas.
Hora: $hora.
¿Se aviso a los padres? ¿A quien?: $aviso.
Medida y medicamento: $accion.
Dosis: $dosis.
";
				//--		
				$arr_data[$i]['sintomas'] = trim($row["enf_sintomas"]);
				$arr_data[$i]['hora'] = trim($row["enf_hora"]);
				$arr_data[$i]['se_aviso_a'] = trim($row["enf_aviso"]);
				$arr_data[$i]['accion'] = trim($row["enf_medida"]);
				$arr_data[$i]['dosis'] = trim($row["enf_dosis"]);
				//
				$arr_data[$i]['cuerpo'] = $cuerpo;
				$fecha = $row["enf_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
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
	
}


function API_new_enfermedad($data){
	$ClsEnf = new ClsEnfermedad();
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$ClsPush = new ClsPushup();
	$ClsAlu = new ClsAlumno();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$pensum = $ClsPen->get_pensum_activo();
		$nivel = trim($data[0]["nivel"]);
		$grado = trim($data[0]["grado"]);
		$seccion = trim($data[0]["seccion"]);
		$usuario = trim($data[0]["usuario"]);
		$alumno = trim($data[0]["alumno"]);
		$sintomas = trim($data[0]["sintomas"]);
		$hora = trim($data[0]["hora"]);
		$aviso = trim($data[0]["aviso"]);
		$medida = trim($data[0]["medida"]);
		$dosis = trim($data[0]["dosis"]);
		///-
		$result_alumno = $ClsAlu->get_alumno($alumno);
		if(is_array($result_alumno)){
			foreach($result_alumno as $row_alumno){
				$alumno_nombre = trim($row_alumno["alu_nombre"])." ".trim($row_alumno["alu_apellido"]);
			}
		}
$cuerpo = "
Estimados Señores:
Nos dirigimos a ustedes para informarles con mucha pena que su hijo(a) $alumno_nombre se sintió mal, a continuación los detalles:
Sintomas: $sintomas.
Hora: $hora.
¿Se aviso a los padres? ¿A quien?: $aviso.
Medida y medicamento: $accion.
Dosis: $dosis.
";
		//--
		$cuerpo = trim($cuerpo);
		//--------
		if($alumno !="" && $usuario !=""){
			$codigo = $ClsEnf->max_enfermedad();
			$codigo++;
			$sql = $ClsEnf->insert_enfermedad($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$sintomas,$hora,$aviso,$medida,$dosis,$usuario);
			$result = $ClsPush->get_alumnos_users($alumno);
    		
			/// registra la notificacion //
			if(is_array($result)) {
				$title = 'Reporte de Enfermedad';
				$message = $cuerpo;
				$push_tipo = 9;
				$item_id = $codigo;
				$cert_path = '../../CONFIG/push/ck_prod.pem';
				//--
				$UsuarioRepetido = ''; // valida que no repita el insert de la push
				foreach ($result as $row){
					$user_id = $row["user_id"];
					$device_id = $row["device_id"];
					if($UsuarioRepetido != $user_id && $device_id != ""){
						$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id,$alumno);
						$UsuarioRepetido = $user_id;
					}
    			}
			}
		    
			$rs = $ClsEnf->exec_sql($sql);
			if($rs == 1){
			    $url = "https://" . $_SERVER['HTTP_HOST'] . "/SISTEM/API/API_reportes.php?request=detalle_enfermedad&codigo=" . $codigo;
    			//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"codigo" => $codigo,
				"message" => "Reporte  #$codigo creado satisfactoriamente...",
				"review" => "$url");
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


function API_update_enfermedad($data){
	$ClsEnf = new ClsEnfermedad();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$codigo = trim($data[0]["codigo"]);
		$alumno = trim($data[0]["alumno"]);
		$sintomas = trim($data[0]["sintomas"]);
		$hora = trim($data[0]["hora"]);
		$aviso = trim($data[0]["aviso"]);
		$medida = trim($data[0]["medida"]);
		$dosis = trim($data[0]["dosis"]);
		//--------
		if($codigo !="" && $alumno !=""){
			$sql = $ClsEnf->modifica_enfermedad($codigo,$alumno,$sintomas,$hora,$aviso,$medida,$dosis);
			$rs = $ClsEnf->exec_sql($sql);
			//echo $sql;
			if($rs == 1){
				$url = "https://" . $_SERVER['HTTP_HOST'] . "/SISTEM/API/API_reportes.php?request=detalle_enfermedad&codigo=" . $codigo;
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"message" => "Reporte actualizado satisfactoriamente....",
				"review" => "$url");
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


function API_delete_enfermedad($codigo){
	$ClsEnf = new ClsEnfermedad();
	$ClsPush = new ClsPushup();
	if($codigo != ""){
		$sql = $ClsEnf->delete_enfermedad($codigo);
		$sql.= $ClsPush->delete_push_especifica(9,$codigo);
		$rs = $ClsEnf->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Reporte eliminado satisfactoriamente....");
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


///////////////////////////////////////// REPORTE DE CONDUCTA ///////////////////////////////////////////

function API_lista_conducta($alumno){
	$ClsCon = new ClsConducta();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();
	
	if($alumno != ""){
		$i = 0;
		$result = $ClsCon->get_conducta('',$pensum,'','','',$alumno);
		if(is_array($result)){
			foreach ($result as $row){
				$arr_data[$i]['codigo'] = $row["con_codigo"];
				$grado = trim($row["con_grado_desc"]);
				$seccion = trim($row["con_seccion_desc"]);
				$arr_data[$i]['seccion'] =  $grado.' '.$seccion;
				$arr_data[$i]['cui'] = trim($row["con_alumno"]);
				$arr_data[$i]['alumno'] = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);;
				$arr_data[$i]['genero'] = trim($row["alu_genero"]);
				$arr_data[$i]['titulo'] = 'Reporte de Conducta';
				//--
				$alumno = trim($row["alu_nombre"])." ".trim($row["alu_apellido"]);
				$calificacion = trim($row["con_calificacion"]);
				switch($calificacion){
					 case 1: $cond_text = "Muy Bien"; break;
					 case 2: $cond_text = "Bien"; break;
					 case 3: $cond_text = "Regular"; break;
					 case 4: $cond_text = "Debo Mejorar"; break;
				}
				$obs = trim($row["con_observaciones"]);
				//--
$cuerpo = "
Hola mamí y papí, yo $alumno
Hoy me porté:
$cond_text

Observaciones: 
$obs.
";
				//--		
				$arr_data[$i]['calificacion'] = trim($row["con_calificacion"]);
				$arr_data[$i]['calificacion_descripcion'] = $cond_text;
				$arr_data[$i]['observaciones'] = trim($row["con_observaciones"]);
				//
				$arr_data[$i]['cuerpo'] = $cuerpo;
				$fecha = $row["con_fecha_registro"];
				$arr_data[$i]['fecha'] = cambia_fechaHora($fecha);
				//--
				$foto = $row["alu_foto"];
				if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/".$foto.".jpg";
				}else{
					$arr_data[$i]['url_foto'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/Fotos/ALUMNOS/nofoto.png";
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
	
}


function API_new_conducta($data){
	$ClsCon = new ClsConducta();
	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$ClsPush = new ClsPushup();
	$ClsAlu = new ClsAlumno();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$pensum = $ClsPen->get_pensum_activo();
		$nivel = trim($data[0]["nivel"]);
		$grado = trim($data[0]["grado"]);
		$seccion = trim($data[0]["seccion"]);
		$usuario = trim($data[0]["usuario"]);
		$alumno = trim($data[0]["alumno"]);
		$calificacion = trim($data[0]["calificacion"]);
		$obs = trim($data[0]["obs"]);
		$obs = ($obs == "")?"Ninguna":$obs;
		///-
		switch($calificacion){
			case 1: $cond_text = "Muy Bien"; break;
			case 2: $cond_text = "Bien"; break;
			case 3: $cond_text = "Regular"; break;
			case 4: $cond_text = "Debo Mejorar"; break;
		}
      	///-
		$result_alumno = $ClsAlu->get_alumno($alumno);
		if(is_array($result_alumno)){
			foreach($result_alumno as $row_alumno){
				$alumno_nombre = trim($row_alumno["alu_nombre"])." ".trim($row_alumno["alu_apellido"]);
			}
		}
$cuerpo = "
Hola mamí y papí, yo $alumno_nombre
Hoy me porté:
$cond_text

Observaciones: 
$obs.
";
		//--
		$cuerpo = trim($cuerpo);
		//--------
		if($alumno !="" && $usuario !=""){
			$codigo = $ClsCon->max_conducta();
			$codigo++;
			$sql = $ClsCon->insert_conducta($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$calificacion,$obs,$usuario);
			$result = $ClsPush->get_alumnos_users($alumno);
    		
			/// registra la notificacion //
			if(is_array($result)) {
				$title = 'Reporte de Conducta';
				$message = $cuerpo;
				$push_tipo = 10;
				$item_id = $codigo;
				$cert_path = '../../CONFIG/push/ck_prod.pem';
				//--
				$UsuarioRepetido = ''; // valida que no repita el insert de la push
				foreach ($result as $row){
					$user_id = $row["user_id"];
					$device_id = $row["device_id"];
					if($UsuarioRepetido != $user_id && $device_id != ""){
						$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id,$alumno);
						$UsuarioRepetido = $user_id;
					}
    			}
			}
		    
			$rs = $ClsCon->exec_sql($sql);
			if($rs == 1){
			    $url = "https://" . $_SERVER['HTTP_HOST'] . "/SISTEM/API/API_reportes.php?request=detalle_conducta&codigo=" . $codigo;
    			//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"codigo" => $codigo,
				"message" => "Reporte #$codigo creado satisfactoriamente...",
				"review" => "$url");
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


function API_update_conducta($data){
	$ClsCon = new ClsConducta();
	
	$data = str_replace("\\n"," ",$data);
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$codigo = trim($data[0]["codigo"]);
		$alumno = trim($data[0]["alumno"]);
		$calificacion = trim($data[0]["calificacion"]);
		$obs = trim($data[0]["obs"]);
		$obs = ($obs == "")?"Ninguna":$obs;
		//--------
		if($codigo !="" && $alumno !=""){
			$sql = $ClsCon->modifica_conducta($codigo,$alumno,$calificacion,$obs);
			$rs = $ClsCon->exec_sql($sql);
			//echo $sql;
			if($rs == 1){
				$url = "https://" . $_SERVER['HTTP_HOST'] . "/SISTEM/API/API_reportes.php?request=detalle_conducta&codigo=" . $codigo;
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
				"status" => "success",
				"message" => "Reporte actualizado satisfactoriamente....",
				"review" => "$url");
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


function API_delete_conducta($codigo){
	$ClsCon = new ClsConducta();
	$ClsPush = new ClsPushup();
	if($codigo != ""){
		$sql = $ClsCon->delete_conducta($codigo);
		$sql.= $ClsPush->delete_push_especifica(10,$codigo);
		$rs = $ClsCon->exec_sql($sql);
		if($rs == 1){
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "success",
				"message" => "Reporte eliminado satisfactoriamente....");
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



///////////////////////////////////////// NOTIFICACIONES ///////////////////////////////////////////


function API_envia_push($push_tipo,$item_id){
	$ClsPush = new ClsPushup();
	if($push_tipo !="" && $item_id !=""){
		switch($push_tipo){
			case 1:
				$title = "Nuevo Postit";
				$landing_page = "postitdetalle";
				break;
			case 2:
				$title = "Nueva Tarea";
				$landing_page = "tareas";
				break;
			case 3:
				$title = "Nueva Actividad";
				$landing_page = "calendar";
				break;
			case 4:
				$title = "Nueva Encuesta";
				$landing_page = "encuesta2";
				break;
			case 5:
				$title = "Nuevo Video Multimedia";
				$landing_page = "videos";
				break;
			case 6:
				$title = "Nueva Circular";
				$landing_page = "formulariocircular";
				break;
			case 7:
				$title = "Nuevo Reporte de Pañal";
				$landing_page = "reportepanial2";
				break;
			case 8:
				$title = "Nuevo Reporte de Golpe";
				$landing_page = "reportegolpe2";
				break;
			case 9:
				$title = "Nuevo Reporte de Enfermedad";
				$landing_page = "reporteenfermedad2";
				break;
			case 10:
				$title = "Nuevo Reporte de Conducta";
				$landing_page = "reporteconducta2";
				break;
			case 11:
				$title = "Nuevo Photo Album";
				$landing_page = "photo1";
				break;
			case 12:
				$title = "Mensaje del Chat";
				$landing_page = "chatmensajes";
				break;
			case 100:
				$title = "Notificación General";
				$landing_page = "general";
				break;
		}
		
		///// Ejecuta notificaciones push
		$result = $ClsPush->get_push_notification_user('',$push_tipo,'',$item_id);
		if(is_array($result)) {
			foreach ($result as $row){
				$user_id = $row["user_id"];
				$device_type = $row["device_type"];
				$device_token = $row["device_token"];
				$certificate_type = $row["certificate_type"];
				$item_id = $row["type_id"];
				//---
				$message = trim($row["message"]);
				//cuenta las notificaciones pendientes
				$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
				//--
				$data = array(
					'landing_page'=> $landing_page,
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