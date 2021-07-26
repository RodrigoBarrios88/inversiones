<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_tarea.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- TAREAS -----/////////////////////////////////////////////
function Grabar_Tarea($pensum,$nivel,$grado,$seccion,$materia,$tema,$maestro,$nom,$desc,$tipo,$ponderacion,$tipocalifica,$fecha,$hora,$link){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	$ClsAcad = new ClsAcademico();
	$ClsPush = new ClsPushup();
   //$respuesta->alert("$pensum,$nivel,$grado,$seccion,$materia,$maestro,$nom,$desc,$fecha,$link");
	$nom = trim($nom);
	$desc = trim($desc);
	$desc = str_replace(";",".",$desc);
	//decodificacion
   $nom = utf8_encode($nom);
	$desc = utf8_encode($desc);
	//--
	$nom = utf8_decode($nom);
	$desc = utf8_decode($desc);
	
   if($tema != "" && $nom != "" && $desc != "" && $tipo != "" && $ponderacion != "" && $tipocalifica != ""){
      $array_notificaciones = array();
		$fechor = "$fecha $hora"; // une la fecha y la hora
		$codigo = $ClsTar->max_tarea();
		$codigo++;
		$sql = $ClsTar->insert_tarea($codigo,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$tema,$nom,$desc,$tipo,$ponderacion,$tipocalifica,$fechor,$link);
      $i = 0;
      $result = $ClsPush->get_nivel_grado_seccion_users($pensum,$nivel,$grado,$seccion);
      if(is_array($result)) {
         $UsuarioRepetido = ''; // valida que no repita el insert del postit, solo el de la notificación
         $deviceRepetido = ''; // valida que no repita el insert de la push
         foreach ($result as $row){
            $user_id = $row["user_id"];
            $alumno = trim($row["pa_alumno"]);
            if($UsuarioRepetido != $alumno){
               $sql.= $ClsTar->insert_det_tarea($codigo,$alumno,0,"",1);
               $UsuarioRepetido = $alumno;
               $i++;
               //$respuesta->alert($i);
            }
            $device_id = $row["device_id"];
            if($deviceRepetido != $device_id && $device_id != ""){
               $message = $desc;
               $push_tipo = 2;
               $sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$codigo,$alumno);
               //--
               $pendientes = intval($ClsPush->count_pendientes_leer($user_id));
               $array_notificaciones[$i]["user_id"] = $row["user_id"];
               $array_notificaciones[$i]["device_type"] = $row["device_type"];
               $array_notificaciones[$i]["device_token"] = $row["device_token"];
               $array_notificaciones[$i]["certificate_type"] = $row["certificate_type"];
               $array_notificaciones[$i]["push_tipo"] = $push_tipo;
               $array_notificaciones[$i]["item_id"] = $codigo;
               $array_notificaciones[$i]["message"] = $message;
               $array_notificaciones[$i]["pendientes"] = $pendientes;
               $i++;
               $deviceRepetido = $device_id;
            }
         }
      }
       
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			///// Ejecuta notificaciones push
			if(is_array($array_notificaciones)) {
            $title = 'Nueva Tarea';
            $cert_path = '../../CONFIG/push/ck_prod.pem';
				foreach ($array_notificaciones as $row){
					$user_id = $row["user_id"];
					$device_type = $row["device_type"];
					$device_token = $row["device_token"];
					$certificate_type = $row["certificate_type"];
					$target = $row["target"];
               $item_id = $row["type_id"];
					//cuenta las notificaciones pendientes
					$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
               //--
					$data = array(
					   'landing_page'=> 'tareas',
					   'codigo' => $item_id
					);
					//envia la push
					if($device_type == 'android') {
						SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
        			}else if($device_type == 'ios') {
        				SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
            	}	
				}
			}
			////
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}	
	}
   return $respuesta;
}


function Modificar_Tarea($cod,$tema,$maestro,$nom,$desc,$tipo,$ponderacion,$tipocalifica,$fecha,$hora,$link){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   //$respuesta->alert("$cod,$materia,$nom,$desc,$fecha,$link");
	$nom = trim($nom);
	$desc = trim($desc);
	$desc = str_replace(";",".",$desc);
	//decodificacion
   $nom = utf8_encode($nom);
	$desc = utf8_encode($desc);
	//--
	$nom = utf8_decode($nom);
	$desc = utf8_decode($desc);
   if($tema != "" && $nom != "" && $desc != "" && $tipo != "" && $ponderacion != "" && $tipocalifica != ""){
		$fechor = "$fecha $hora"; // Une la fecha y la hora
		$sql = $ClsTar->modifica_tarea_datos($cod,$tema,$maestro,$nom,$desc,$tipo,$ponderacion,$tipocalifica,$fechor,$link);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}	
			
	}
   return $respuesta;
}


function Buscar_Tarea($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   //$respuesta->alert("$codigo");
	$result = $ClsTar->get_tarea($codigo);
	if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["tar_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $tema = $row["tar_tema"];
         $respuesta->assign("tema","value",$tema);
         $nom = utf8_decode($row["tar_nombre"]);
         $respuesta->assign("nom","value",$nom);
         $desc = utf8_decode($row["tar_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $tipo = trim($row["tar_tipo"]);
         $respuesta->assign("tipo","value",$tipo);
         $pondera = trim($row["tar_ponderacion"]);
         $respuesta->assign("pondera","value",$pondera);
         $tipocalifica = trim($row["tar_tipo_calificacion"]);
         $respuesta->assign("tipocalifica","value",$tipocalifica);
         $fecha = $row["tar_fecha_entrega"];
         $fec = substr($fecha,0,10);
         $hor = substr($fecha,11,5);
         $fec = cambia_fecha($fec);
         $respuesta->assign("fec","value",$fec);
         $respuesta->assign("hor","value",$hor);
         $link = $row["tar_link"];
         $respuesta->assign("link","value",$link);
      }	
	}
   //abilita y desabilita botones
   $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
   $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
   
   //$contenido = tabla_tareas($cod,$pensum,$nivel,$grado,$seccion,$materia,$maestro,$desde,$fecha,$sit);
   $respuesta->assign("result","innerHTML",$contenido);
   $respuesta->script("cerrar();");
   return $respuesta;
}


function Reenviar_Tarea_Todos($pensum,$nivel,$grado,$seccion,$tarea){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	$ClsPush = new ClsPushup();
   //$respuesta->alert("$pensum,$nivel,$grado,$seccion,$tarea");
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $tarea != ""){
		$sql = "";
		$result = $ClsPush->get_nivel_grado_seccion_users($pensum,$nivel,$grado,$seccion);
      if(is_array($result)) {
         $UsuarioRepetido = ''; // valida que no repita el insert del postit, solo el de la notificación
         $deviceRepetido = ''; // valida que no repita el insert de la push
         foreach ($result as $row){
            $user_id = $row["user_id"];
            $alumno = trim($row["pa_alumno"]);
            if($UsuarioRepetido != $alumno){
               $sql.= $ClsTar->insert_det_tarea($tarea,$alumno,0,"",1);
               $UsuarioRepetido = $alumno;
               $i++;
               //$respuesta->alert($i);
            }
            $device_id = $row["device_id"];
            if($deviceRepetido != $device_id && $device_id != ""){
               $message = "Se ha reenviado una tarea a todo el grupo, ver:";
               $push_tipo = 2;
               $sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$tarea,$alumno);
               //--
               $pendientes = intval($ClsPush->count_pendientes_leer($user_id));
               $array_notificaciones[$i]["user_id"] = $row["user_id"];
               $array_notificaciones[$i]["device_type"] = $row["device_type"];
               $array_notificaciones[$i]["device_token"] = $row["device_token"];
               $array_notificaciones[$i]["certificate_type"] = $row["certificate_type"];
               $array_notificaciones[$i]["push_tipo"] = $push_tipo;
               $array_notificaciones[$i]["item_id"] = $codigo;
               $array_notificaciones[$i]["message"] = $message;
               $array_notificaciones[$i]["pendientes"] = $pendientes;
               $i++;
               $deviceRepetido = $device_id;
            }
         }
      }
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
         ///// Ejecuta notificaciones push
			if(is_array($array_notificaciones)) {
            $title = 'Tarea Re-enviada a todo el grupo';
            $cert_path = '../../CONFIG/push/ck_prod.pem';
				foreach ($array_notificaciones as $row){
					$user_id = $row["user_id"];
					$device_type = $row["device_type"];
					$device_token = $row["device_token"];
					$certificate_type = $row["certificate_type"];
					$target = $row["target"];
               $item_id = $row["type_id"];
					//cuenta las notificaciones pendientes
					$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
               //--
					$data = array(
					   'landing_page'=> 'tareas',
					   'codigo' => $item_id
					);
					//envia la push
					if($device_type == 'android') {
						SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // Android
        			}else if($device_type == 'ios') {
        				SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
            	}	
				}
			}
			////
			$respuesta->script('swal("Excelente!", "Tarea enviada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
   return $respuesta;
}


function Reenviar_Tarea_Alumno($tarea,$alumno){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   $ClsPush = new ClsPushup();
	//$respuesta->alert("$tarea,$alumno");
	if($alumno != "" && $tarea != ""){
		$sql = $ClsTar->insert_det_tarea($tarea,$alumno,0,"",1);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
         $respuesta->script('swal("Excelente!", "Tarea enviada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
   return $respuesta;
}



function Eliminar_Tarea($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   if($codigo != ""){
	   //// busca y elimina archivos
		$result = $ClsTar->get_tarea_curso_archivo("",$codigo);
		if(is_array($result)){
			foreach($result as $row){
				$archivo = trim($row["arch_codigo"])."_".trim($row["arch_tarea"]).".".trim($row["arch_extencion"]);
				unlink("../../CONFIG/DATALMS/TAREAS/MATERIAS/$archivo");
			}
		}	
		//elimina registros de la BD
		$sql = $ClsTar->delete_tarea($codigo);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Tarea Eliminada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}



function Calificar_Tarea($tarea,$alumno,$nota,$obs,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   if($tarea != "" && $alumno != ""){
	  // $respuesta->alert("tarea,$alumno,$nota,$obs,$fila");
		$sql = $ClsTar->modifica_det_tarea($tarea,$alumno,$nota,$obs);
		$sql.= $ClsTar->cambiar_sit_det_tarea($tarea,$alumno,2);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
		    	$respuesta->script('swal("Excelente!", "Tarea Calificada Satisfactoriamente!!!", "success").then((value)=>{ window.history.back() });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}

//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////
function Grabar_Archivo($tarea,$nombre,$desc,$extension){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   //-- mayusculas
	$nombre = trim($nombre);
	$desc = trim($desc);
	$extension = strtolower($extension);
	$desc = str_replace(";",".",$desc);
	//-- decodificacion
	$nombre = utf8_encode($nombre);
	$desc = utf8_encode($desc);
    //--
	$nombre = utf8_decode($nombre);
	$desc = utf8_decode($desc);
	//--
	if($tarea != "" && $nombre != "" && $extension != ""){
		$codigo = $ClsTar->max_tarea_archivo($tarea);
		$codigo++;
		$sql = $ClsTar->insert_tarea_archivo($codigo,$tarea,$nombre,$desc,$extension);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert("$sql");
      if($rs == 1){
			$respuesta->assign("Filecodigo","value",$codigo);
			$respuesta->script("CargaArchivos();");
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
	}	
	
   return $respuesta;
}


function Delete_Archivo($codigo,$tarea,$archivo){
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	
	if($codigo != "" && $tarea != ""){
     	$sql = $ClsTar->delete_tarea_archivo($codigo,$tarea);
		//$respuesta->alert("$archivo");
      $rs = $ClsTar->exec_sql($sql);
      if($rs == 1){
			unlink("../../CONFIG/DATALMS/TAREAS/MATERIAS/$archivo");
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- TAREAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Modificar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Buscar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Calificar_Tarea");
$xajax->register(XAJAX_FUNCTION, "Reenviar_Tarea_Todos");
$xajax->register(XAJAX_FUNCTION, "Reenviar_Tarea_Alumno");
//////////////////---- ARCHIVOS AUXILIARES O GIAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Archivo");
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  