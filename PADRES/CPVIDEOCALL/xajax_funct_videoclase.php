<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_videoclase.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// LISTA /////////
function Target_Grupos($target,$tipo){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$target,$tipo");
	if($target == "SELECT"){
		if($tipo == 1){
			$contenido = tabla_grados_secciones();
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}else if($tipo == 2){
			$contenido = grupos_lista_multiple("grupos");
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}else{
			$contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
			$respuesta->assign("divgrupos","innerHTML",$contenido);
		}
   }else{
	  $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
	  $respuesta->assign("divgrupos","innerHTML",$contenido);
   }
   return $respuesta;
}


//////////////////---- INFORMACION -----/////////////////////////////////////////////

function Grabar_Videoclase($nombre,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$plataforma,$link,$arrgrupo,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsVid = new ClsVideoclase();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$nombre,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$plataforma,$link,$arrgrupo,$filas");
   //$nombre = utf8_encode($nombre);
	//$descripcion = utf8_encode($descripcion);
	//--
   //$nombre = utf8_decode($nombre);
	//$descripcion = utf8_decode($descripcion);
	
   if($nombre != "" && $descripcion != ""){
		$videoclase = $ClsVid->max_videoclase();
		$videoclase++; /// Maximo codigo
		$desde = "$fecdesde $hordesde";
		$hasta = "$fechasta $horhasta";
      $sql = $ClsVid->insert_videoclase($videoclase,$nombre,$descripcion,$desde,$hasta,$target,$tipo,$plataforma,$link,'','',''); /// Inserta a tabla Videoclasees
		
		if($target == "SELECT"){
			if($tipo == 1){
				$pensum = $_SESSION["pensum"];
				for($i = 0; $i< $filas; $i++){
					$bloque = explode(".",$arrgrupo[$i]);
				   $nivel = $bloque[1];
				   $grado = $bloque[2];
				   $seccion = $bloque[3];
				   $sql.= $ClsVid->insert_det_videoclase_secciones($videoclase,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
					//--
					$arrnivel.= $nivel.",";
					$arrgrado.= $grado.",";
					$arrsecc.= $seccion.",";
				}
			}else if($tipo == 2){	
				for($i = 0; $i< $filas; $i++){
				   $grupo = $arrgrupo[$i];
					$sql.= $ClsVid->insert_det_videoclase_grupos($videoclase,$grupo); /// Inserta detalle
					//--
					$strgrupo.= $grupo.",";
				}
			}
		}
      
		$rs = $ClsVid->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
         if($plataforma == "ASMS Videoclass"){
            $cui = $_SESSION['tipo_codigo'];
            $organizador = $_SESSION["nombre"];
            $desde = regresa_fechaHora($desde);
            $desde = strtotime("$desde");
            $hasta = regresa_fechaHora($hasta);
            $hasta = strtotime("$hasta");
            //----
            $arr_schedule = kaltura_add_schedule($nombre,$descripcion);
            $arr_event = kaltura_add_event($videoclase, $organizador, $nombre, $cui, $desde, $hasta);
            $schedule = $arr_schedule["data"]["id"];
            $event = $arr_event["data"]["id"];
            $partnerId = $arr_schedule["data"]["partnerId"];
            //$respuesta->alert("$event, $schedule");
            $arr_resource = kaltura_resource_event($event, $schedule);
            
            if($arr_schedule["status"] == 1 && $arr_event["status"] == 1 && $arr_resource["status"] == 1){
               $sql = $ClsVid->modifica_schedule_videoclase($videoclase,$schedule,$event,$partnerId); /// update datos de kaltura
               $rs = $ClsVid->exec_sql($sql);
               if($rs == 1){
                  $respuesta->script('swal("Excelente!", "Nueva Videoclase calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
               }else{
                  $sql = $ClsVid->delete_videoclase($videoclase); /// delete
                  $rs = $ClsVid->exec_sql($sql);
                  $respuesta->script('swal("Error", "Error en la actualizaci\u00F3n de parametros Kaltura", "error").then((value)=>{ cerrar(); });');
                  $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                  $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
               }   
            }else{
               $sql = $ClsVid->delete_videoclase($videoclase); /// delete
               $rs = $ClsVid->exec_sql($sql);
               $respuesta->script('swal("Error", "Error en la transacci\u00F3n con el API de videollamadas", "error").then((value)=>{ cerrar(); });');
               $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
               $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
            }
         }else{
            $respuesta->script('swal("Excelente!", "Nueva Videoclase calendarizada con exito!", "success").then((value)=>{ window.location.reload(); });');
         }
		}else{
			$respuesta->script('swal("Error", "Error en la creaci\u00F3n del evento en BD...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
		}	
			
	}
   return $respuesta;
}



function Modificar_Videoclase($codigo,$nombre,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$plataforma,$link,$event,$schedule,$partnerId,$arrgrupo,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsVid = new ClsVideoclase();
	//$respuesta->alert("$nombre,$descripcion,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$plataforma,$link,$arrgrupo,$filas");
   $nombre = utf8_encode($nombre);
	$descripcion = utf8_encode($descripcion);
	//--
   $nombre = utf8_decode($nombre);
	$descripcion = utf8_decode($descripcion);
	
   if($nombre != "" && $descripcion != ""){
		$desde = "$fecdesde $hordesde";
		$hasta = "$fechasta $horhasta";
		$sql = $ClsVid->modifica_videoclase($codigo,$nombre,$descripcion,$desde,$hasta,$plataforma,$link); /// Inserta a tabla Videoclasees
      $sql.= $ClsVid->delete_det_videoclase_grupos($codigo); //elimina detalles
      $sql.= $ClsVid->delete_det_videoclase_secciones($codigo); //elimina detalles
      $sql.= $ClsVid->modifica_target_videoclase($codigo,$target,$tipo); /// Actualiza Videoclasees
      
      if($target == "SELECT"){
			if($tipo == 1){
				$pensum = $_SESSION["pensum"];
				for($i = 0; $i< $filas; $i++){
					$bloque = explode(".",$arrgrupo[$i]);
				   $nivel = $bloque[1];
				   $grado = $bloque[2];
				   $seccion = $bloque[3];
				   $sql.= $ClsVid->insert_det_videoclase_secciones($codigo,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
					//--
					$arrnivel.= $nivel.",";
					$arrgrado.= $grado.",";
					$arrsecc.= $seccion.",";
				}
			}else if($tipo == 2){	
				for($i = 0; $i< $filas; $i++){
				   $grupo = $arrgrupo[$i];
					$sql.= $ClsVid->insert_det_videoclase_grupos($codigo,$grupo); /// Inserta detalle
					//--
					$strgrupo.= $grupo.",";
				}
			}
		}
      
      $rs = $ClsVid->exec_sql($sql);
		//$respuesta->alert($sql);
		 if($rs == 1){
         if($plataforma == "ASMS Videoclass"){
            ///--- eliminacion anteriro ---///
            kaltura_delete_schedule($schedule);
            kaltura_delete_event($event);
            ///--- nueva programacion ---///
            $cui = $_SESSION['tipo_codigo'];
            $organizador = $_SESSION["nombre"];
            $desde = regresa_fechaHora($desde);
            $desde = strtotime("$desde");
            $hasta = regresa_fechaHora($hasta);
            $hasta = strtotime("$hasta");
            //----
            $arr_schedule = kaltura_add_schedule($nombre,$descripcion);
            $arr_event = kaltura_add_event($codigo, $organizador, $nombre, $cui, $desde, $hasta);
            $schedule = $arr_schedule["data"]["id"];
            $event = $arr_event["data"]["id"];
            $partnerId = $arr_schedule["data"]["partnerId"];
            //$respuesta->alert("$event, $schedule");
            $arr_resource = kaltura_resource_event($event, $schedule);
            if($arr_schedule["status"] == 1 && $arr_event["status"] == 1 && $arr_resource["status"] == 1){
               $sql = $ClsVid->modifica_schedule_videoclase($codigo,$schedule,$event,$partnerId); /// update datos de kaltura
               //$respuesta->alert($sql);
               $rs = $ClsVid->exec_sql($sql);
               if($rs == 1){
                  $respuesta->script('swal("Excelente!", "Calendarizaci\u00F3n de Videoclase actualizada con exito!", "success").then((value)=>{ window.location.reload(); });');
               }else{
                  $sql = $ClsVid->delete_videoclase($codigo); /// delete
                  $rs = $ClsVid->exec_sql($sql);
                  $respuesta->script('swal("Error", "Error en la actualizaci\u00F3n de parametros Kaltura", "error").then((value)=>{ cerrar(); });');
                  $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
                  $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
               }   
            }else{
               $sql = $ClsVid->delete_videoclase($videoclase); /// delete
               $rs = $ClsVid->exec_sql($sql);
               $respuesta->script('swal("Error", "Error en la transacci\u00F3n con el API de videollamadas", "error").then((value)=>{ cerrar(); });');
               $respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
               $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
            }
         }else{
            $respuesta->script('swal("Excelente!", "Calendarizaci\u00F3n de Videoclase actualizada con exito!", "success").then((value)=>{ window.location.reload(); });');
         }
		}else{
			$respuesta->script('swal("Error", "Error en la creaci\u00F3n del evento en BD...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary hidden';");
		}	
			
	}
   return $respuesta;
}



function Buscar_Videoclase($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsVid = new ClsVideoclase();
	
	//$respuesta->alert("$codigo");
   $result = $ClsVid->get_videoclase($codigo);
   if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["vid_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $nombre = utf8_decode($row["vid_nombre"]);
         $respuesta->assign("nombre","value",$nombre);
         $descripcion = utf8_decode($row["vid_descripcion"]);
         $respuesta->assign("descripcion","value",$descripcion);
         $desde = $row["vid_fecha_inicio"];
         $desde = cambia_fechaHora($desde);
         $fecini = substr($desde,0,10);
         $horini = substr($desde,11,18);
         $respuesta->assign("fecini","value",$fecini);
         $respuesta->assign("horini","value",$horini);
         $hasta = $row["vid_fecha_fin"];
         $hasta = cambia_fechaHora($hasta);
         $fecfin = substr($hasta,0,10);
         $horfin = substr($hasta,11,18);
         $respuesta->assign("fecfin","value",$fecfin);
         $respuesta->assign("horfin","value",$horfin);
         $plataforma = $row["vid_plataforma"];
         $respuesta->assign("plataforma","value",$plataforma);
         $link = $row["vid_link"];
         $respuesta->assign("link","value",$link);
         //--
         $evento = $row["vid_event"];
         $respuesta->assign("evento","value",$evento);
         $schedule = $row["vid_schedule"];
         $respuesta->assign("schedule","value",$schedule);
         $partnerid = $row["vid_partnerId"];
         $respuesta->assign("partnerId","value",$partnerid);
         //--
         $target = $row["vid_target"];
         $respuesta->assign("target","value",$target);
         $tipo_target = $row["vid_tipo_target"];
         $respuesta->assign("tipotarget","value",$tipo_target);
         //////
         if($target == "SELECT"){
            if($tipo_target == 1){
               $contenido = tabla_grados_secciones();
               $respuesta->assign("divgrupos","innerHTML",$contenido);
            }else if($tipo_target == 2){
               $contenido = grupos_lista_multiple("grupos");
               $respuesta->assign("divgrupos","innerHTML",$contenido);
            }else{
               $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
               $respuesta->assign("divgrupos","innerHTML",$contenido);
            }
            $respuesta->script('document.getElementById("tipotarget").removeAttribute("disabled");');
         }else{
            $respuesta->script('document.getElementById("tipotarget").setAttribute("disabled","disabled");');
            $contenido = lista_multiple_vacia("Grupos"," Listado de Grupos");
            $respuesta->assign("divgrupos","innerHTML",$contenido);
         }
         
         if($plataforma != "ASMS Videoclass"){
            $respuesta->script('document.getElementById("link").removeAttribute("disabled");');
         }else{
            $respuesta->script('document.getElementById("link").setAttribute("disabled","disabled");');
         }
      }
      //--
		$contenido = tabla_videoclase($codigo,'','');
		$respuesta->assign("result","innerHTML",$contenido);
		//abilita y desabilita botones
      $respuesta->script("document.getElementById('btn-modificar').className = 'btn btn-primary';");
		$respuesta->script("document.getElementById('btn-grabar').className = 'btn btn-primary hidden';");
      $respuesta->script('document.getElementById("nombre").focus();');
      $respuesta->script("cerrar();");
	}
   return $respuesta;
}



function Situacion_Videoclase($codigo){
   $respuesta = new xajaxResponse();
   $ClsVid = new ClsVideoclase();

   //$respuesta->alert("$cod");
   if($codigo != ""){
      $ClsVid = new ClsVideoclase();
      $result = $ClsVid->get_videoclase($codigo);
      if(is_array($result)){
         foreach($result as $row){
            $plataforma = trim($row["vid_plataforma"]);
            $eventId = $row["vid_link"];
            $schedule = $row["vid_schedule"];
            $partnerid = $row["vid_partnerId"];
         }
      }
      if($plataforma == "ASMS Videoclass"){
         ///--- eliminacion anteriro ---///
         kaltura_delete_schedule($schedule);
         kaltura_delete_event($event);
      }   
      $sql = $ClsVid->cambia_sit_videoclase($codigo,0);
      $rs = $ClsVid->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Ok", "Videoclase eliminada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
	}

	return $respuesta;
}


//////////////////---- RECORDATORIO -----/////////////////////////////////////////////

function Recordatorio($codigo){
   $respuesta = new xajaxResponse();
   $ClsVid = new ClsVideoclase();
	$ClsPush = new ClsPushup();
	 
   if($codigo != ""){
		$result = $ClsVid->get_videoclase($codigo);
		//$respuesta->alert("$result");
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["vid_codigo"];
				$titulo = trim($row["vid_nombre"]);
				//--
				$desde = $row["vid_fecha_inicio"];
            $desde = cambia_fechaHora($desde);
            $fecini = substr($desde,0,10);
            $horini = substr($desde,11,18);
            //--
            $hasta = $row["vid_fecha_fin"];
            $hasta = cambia_fechaHora($hasta);
            $fecfin = substr($hasta,0,10);
            $horfin = substr($hasta,11,18);
            //
				$target = trim($row["vid_target"]);
				$tipo_target = trim($row["vid_tipo_target"]);
			}
		}
		
		if($target == "SELECT"){
			if($tipo_target == 1){
				$pensum = $_SESSION["pensum"];
				$result = $ClsVid->get_det_videoclase_secciones($codigo,'','','','');
				if(is_array($result)){
					foreach($result as $row){
						$pensum = $row["niv_pensum"];
						$nivel = $row["niv_codigo"];
						$grado = $row["gra_codigo"];
						$seccion = $row["sec_codigo"];
                  $arrnivel.= ($nivel == 0)?"":$nivel.",";
                  $arrgrado.= ($grado == 0)?"":$grado.",";
                  $arrseccion.= ($seccion == 0)?"":$seccion.",";
               }
				}
				$arrnivel = substr($arrnivel,0,-1);
				$arrgrado = substr($arrgrado,0,-1);
				$arrseccion = substr($arrseccion,0,-1);
				$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,$arrnivel,$arrgrado,$arrseccion);
			}else if($tipo_target == 2){	
				$result = $ClsVid->get_det_videoclase_grupos($codigo,'');
				if(is_array($result)){
					foreach($result as $row){
						$grupo = $row["det_grupo"];
						$arrgrupo.= $grupo.",";
					}
				}
				$arrgrupo = substr($arrgrupo,0,-1);
				$result_push = $ClsPush->get_grupos_users($arrgrupo);
			}
		}else{
			$pensum = $_SESSION["pensum"];
			$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,'','','');
		}
		
      //$respuesta->alert("$result_push");
		/// registra la notificacion //
		if(is_array($result_push)) {
			$title = 'Recordatorio';
			$message = "Recordatorio: $titulo ($fecini $horini)";
         $message = depurador_texto($message);
			$push_tipo = 3;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			foreach ($result_push as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			}
		}
		
		$rs = $ClsVid->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			///// Ejecuta notificaciones push
			if(is_array($result_push)) {
				foreach ($result_push as $row){
					$user_id = $row["user_id"];
					$device_type = $row["device_type"];
					$device_token = $row["device_token"];
					$certificate_type = $row["certificate_type"];
					//cuenta las notificaciones pendientes
					$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
               //--
               $data = array(
                  'landing_page'=> 'calendar',
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




//////////////////---- COMBOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Target_Grupos");
//////////////////---- ALUMNOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Videoclase");
$xajax->register(XAJAX_FUNCTION, "Modificar_Videoclase");
$xajax->register(XAJAX_FUNCTION, "Buscar_Videoclase");
$xajax->register(XAJAX_FUNCTION, "Situacion_Videoclase");
//////////////////---- RECORDATORIO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Recordatorio");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  