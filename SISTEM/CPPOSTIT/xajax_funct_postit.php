<?php 
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_postit.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- VARIOS -----/////////////////////////////////////////////
function Pensum_Nivel($pensum,$idniv,$idsniv,$accniv){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$idniv,$idsniv,$accniv");
    $contenido = nivel_html($pensum,$idniv,$accniv);
    $respuesta->assign($idsniv,"innerHTML",$contenido);
	
	return $respuesta;
}

function Nivel_Grado($pensum,$nivel,$idgra,$idsgra,$accgra){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$idgra,$idsgra,$accgra");
    $contenido = grado_html($pensum,$nivel,$idgra,$accgra);
    $respuesta->assign($idsgra,"innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- PARCIALES -----/////////////////////////////////////////////
function Grabar_Postit($pensum,$nivel,$grado,$seccion,$maestro,$titulo,$desc,$target,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPost = new ClsPostit();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$pensum,$nivel,$grado,$seccion,$maestro,$titulo,$desc,$target,$filas");
   $titulo = utf8_encode($titulo);
	$desc = utf8_encode($desc);
	//--
   $titulo = utf8_decode($titulo);
	$desc = utf8_decode($desc);
	
   if($titulo != "" && $desc != ""){
      $sql = "";
		$bandera_codigo = false; //validar� que se cree o no un nuevo codigo
      $codigo = $ClsPost->max_postit();
      $codigo++;
      if($filas > 0){ ////// Si hay alumnos tageados...
         $array_notificaciones = array();
         $alumnos = "";
         for($i = 0; $i < $filas; $i ++){
            $alumnos.= $target[$i].","; /// alinea y separa con comas para la busqueda de padres...
         }
         $alumnos = substr($alumnos,0,-1);
         $i = 0;
         $result = $ClsPush->get_alumnos_users($alumnos);
         if(is_array($result)) {
            $UsuarioRepetido = ''; // valida que no repita el insert del postit, solo el de la notificaci�n
            $deviceRepetido = ''; // valida que no repita el insert de la push
            foreach ($result as $row){
               $user_id = $row["user_id"];
               $alumno = $row["pa_alumno"];
               if($UsuarioRepetido != $alumno){
                  $sql.= $ClsPost->insert_postit($codigo,$pensum,$nivel,$grado,$seccion,$maestro,$alumno,$titulo,$desc);
                  $UsuarioRepetido = $alumno;
                  $bandera_codigo = true;
               }else{
                  $codigo--;
               }
               $device_id = $row["device_id"];
               if($deviceRepetido != $device_id && $device_id != ""){
                  $message = $desc;
                  $push_tipo = 1;
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
               $codigo++;
				}
         } 
      }else{ ////// si es general
         $array_notificaciones = array();
         $nivel_consulta = ($nivel == 0)?'':$nivel; //limpia el 0 para la consulta, proteje el 0 para insertar el registro
         $grado_consulta = ($grado == 0)?'':$grado; //limpia el 0 para la consulta, proteje el 0 para insertar el registro
         $seccion_consulta = ($seccion == 0)?'':$seccion; //limpia el 0 para la consulta, proteje el 0 para insertar el registro
         $i = 0;
         $result = $ClsPush->get_nivel_grado_seccion_users($pensum,$nivel_consulta,$grado_consulta,$seccion_consulta);
         if(is_array($result)) {
            $UsuarioRepetido = ''; // valida que no repita el insert del postit, solo el de la notificaci�n
            $deviceRepetido = ''; // valida que no repita el insert de la push
            foreach ($result as $row){
               $user_id = $row["user_id"];
               $alumno = $row["pa_alumno"];
               if($UsuarioRepetido != $alumno){
                  $sql.= $ClsPost->insert_postit($codigo,$pensum,$nivel,$grado,$seccion,$maestro,$alumno,$titulo,$desc);
                  $UsuarioRepetido = $alumno;
                  $bandera_codigo = true;
               }else{
                  $codigo--;
               }
               $device_id = $row["device_id"];
              if($deviceRepetido != $device_id && $device_id != ""){
                  $message = $desc;
                  $push_tipo = 1;
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
               $codigo++;
				}
         }
         $codigo--; //resta una vuelta al codigo, para que haga match con el item_id de la notificaci�n
      }
      
      //$respuesta->alert($sql);
		$rs = $ClsPost->exec_sql($sql);
		if($rs == 1){
			///// Ejecuta notificaciones push
         $title = 'Nueva Nota Postit';
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			if(is_array($array_notificaciones)) {
				foreach ($array_notificaciones as $row){
					$user_id = $row["user_id"];
					$device_type = $row["device_type"];
					$device_token = $row["device_token"];
					$certificate_type = $row["certificate_type"];
               $message = $row["message"];
					$pendientes = $row["pendientes"];
					$push_tipo = $row["push_tipo"];
					$item_id = $row["item_id"];
               //--
					$data = array(
					   'landing_page'=> 'postitdetalle',
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


function Modificar_Postit($codigo,$titulo,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPost = new ClsPostit();
   //$respuesta->alert("$codigo,$titulo,$desc,$fecha,$link");
	$titulo = utf8_encode($titulo);
	$desc = utf8_encode($desc);
	//--
   $titulo = utf8_decode($titulo);
	$desc = utf8_decode($desc);
	
   if($titulo != "" && $desc != ""){
		$sql = $ClsPost->modifica_postit_datos($codigo,$titulo,$desc);
      $rs = $ClsPost->exec_sql($sql);
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


function Buscar_Postit($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPost = new ClsPostit();
   //$respuesta->alert("$codigo");
	$result = $ClsPost->get_postit($codigo);
	if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["post_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $pensum = $row["post_pensum"];
         $respuesta->assign("pensum","value",$pensum);
         $nivel = $row["post_nivel"];
         $respuesta->assign("nivel","value",$nivel);
         $grado = $row["post_grado"];
         $respuesta->assign("grado","value",$grado);
         $seccion = $row["post_seccion"];
         $respuesta->assign("grado","value",$seccion);
         $materia = $row["post_materia"];
         $respuesta->assign("materia","value",$materia);
         $codigo = $row["post_codigo"];
         $respuesta->assign("cod","value",$codigo);
         $desc = utf8_decode($row["post_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $titulo = utf8_decode($row["post_titulo"]);
         $respuesta->assign("titulo","value",$titulo);
         $target = utf8_decode($row["post_target"]);
         $tipo_target = ($target != "")?1:0;
         $respuesta->assign("target","value",$target);
         $respuesta->assign("tipo","value",$tipo_target);
         //--
         $target_nombre = trim(utf8_decode($row["post_target_nombre"]));
         $respuesta->assign("nombre","value",$target_nombre);
		}
      //abilita y desabilita botones
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      //--
      $respuesta->script("document.getElementById('divalumnos').className = 'col-xs-5 hidden';");
      $respuesta->script("document.getElementById('divalumnos2').className = 'col-xs-5';");
      $respuesta->script("document.getElementById('tipo').setAttribute('disabled','disabled');");
	}
   
   $respuesta->script('document.getElementById("tipo").focus();');
   $respuesta->script("cerrar();");
    return $respuesta;
}



function Eliminar_Postit($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPost = new ClsPostit();
   if($codigo != ""){
	   //$respuesta->alert("$cod,$sit");
		$sql = $ClsPost->delete_postit($codigo);
		$rs = $ClsPost->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Ok!", "Registros eliminado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}



//////////////////---- RECORDATORIO -----/////////////////////////////////////////////

function Recordatorio($codigo){
   $respuesta = new xajaxResponse();
   $ClsPost = new ClsPostit();
	$ClsPush = new ClsPushup();
	 
   if($codigo != ""){
		$result = $ClsPost->get_postit($codigo);
		//$respuesta->alert("$result");
		if(is_array($result)){
			foreach($result as $row){
            $codigo = $row["post_codigo"];
            $titulo = trim($row["post_titulo"]);
            $desc = trim($row["post_descripcion"]);
            //--
            $target = trim($row["post_target"]);
            $tipo_target = ($target != "")?1:2;
            //--
            $pensum = $row["post_pensum"];
            $nivel = $row["post_nivel"];
            $grado = $row["post_grado"];
            $seccion = $row["post_seccion"];
			}
		}
		
      if($tipo_target == 1){
         $result_push = $ClsPush->get_alumno_users($target);
      }else if($tipo_target == 2){
         $nivel = ($nivel == 0)?"":$nivel;
         $grado = ($grado == 0)?"":$grado;
         $seccion = ($seccion == 0)?"":$seccion;
         $result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,$nivel,$grado,$seccion);
      }
		
      /// registra la notificacion //
		if(is_array($result_push)) {
			$title = 'Recordatorio';
			$message = "Recordatorio: $titulo. $desc";
         $message = depurador_texto($message);
			$push_tipo = 1;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
         //--
			foreach ($result_push as $row){
				$user_id = $row["user_id"];
				$sql= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			}
		}else{
         $respuesta->script('swal("No hay usuarios por notificar", "No hay usuarios con el app instalada, registrados para notificar...", "info").then((value)=>{ window.location.reload(); });');
         return $respuesta;
      }
		
		$rs = $ClsPost->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			///// Ejecuta notificaciones push
			if(is_array($result_push)) {
				foreach ($result_push as $row){
					$user_id = $row["user_id"];
					$device_type = $row["device_type"];
					$device_token = $row["device_token"];
					$certificate_type = $row["certificate_type"];
               $target = $row["target"];
					//cuenta las notificaciones pendientes
					$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
               //--
               $data = array(
                  'landing_page'=> 'postitdetalle',
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
			$respuesta->script('swal("Ok", "Recordatorio notificado con exito!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ window.location.reload(); });');
		}
	}

	return $respuesta;
}

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- ESTRUCTURA -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Pensum_Nivel");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
//////////////////---- POSTITs -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Postit");
$xajax->register(XAJAX_FUNCTION, "Modificar_Postit");
$xajax->register(XAJAX_FUNCTION, "Buscar_Postit");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Postit");
//////////////////---- RECORDATORIO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Recordatorio");
//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>  