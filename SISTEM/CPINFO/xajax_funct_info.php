<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_info.php");

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

function Grabar_Informacion($nombre,$desc,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$archivo,$link,$arrgrupo,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsInf = new ClsInformacion();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$nombre,$desc,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$archivo,$link,$arrgrupo,$filas");
   $nombre = utf8_encode($nombre);
	$desc = utf8_encode($desc);
	//--
   $nombre = utf8_decode($nombre);
	$desc = utf8_decode($desc);
	
   if($nombre != "" && $desc != ""){
		$informacion = $ClsInf->max_informacion();
		$informacion++; /// Maximo codigo
		$desde = "$fecdesde $hordesde";
		$hasta = "$fechasta $horhasta";
      if($archivo != ""){
         $archivo = str_shuffle($informacion.uniqid()).".jpg";
      }
		$sql = $ClsInf->insert_informacion($informacion,$nombre,$desc,$desde,$hasta,$target,$tipo,$archivo,$link); /// Inserta a tabla Actividades
		
		if($target == "SELECT"){
			if($tipo == 1){
				$pensum = $_SESSION["pensum"];
				for($i = 0; $i< $filas; $i++){
					$bloque = explode(".",$arrgrupo[$i]);
				   $nivel = $bloque[1];
				   $grado = $bloque[2];
				   $seccion = $bloque[3];
				   $sql.= $ClsInf->insert_det_informacion_secciones($informacion,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
					//--
					$arrnivel.= $nivel.",";
					$arrgrado.= $grado.",";
					$arrsecc.= $seccion.",";
				}
			}else if($tipo == 2){	
				for($i = 0; $i< $filas; $i++){
				   $grupo = $arrgrupo[$i];
					$sql.= $ClsInf->insert_det_informacion_grupos($informacion,$grupo); /// Inserta detalle
					//--
					$strgrupo.= $grupo.",";
				}
			}
		}else{
			///
         
		}
		
		$rs = $ClsInf->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
         ////
			if($archivo != ""){
				$respuesta->assign("codigo","value",$informacion);
            $respuesta->assign("docname","value",$archivo);
				$respuesta->script("Submit();");
			}else{
				$respuesta->script('swal("Excelente!", "Nuevo evento calendarizado con exito!", "success").then((value)=>{ window.location.reload(); });');
			}
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}	
			
	}
   return $respuesta;
}



function Modificar_Informacion($codigo,$nombre,$desc,$fecdesde,$hordesde,$fechasta,$horhasta,$archivo,$link){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsInf = new ClsInformacion();
	//$respuesta->alert("$nombre,$desc,$fecdesde,$hordesde,$fechasta,$horhasta,$target,$tipo,$archivo,$link,$arrgrupo,$filas");
   $nombre = utf8_encode($nombre);
	$desc = utf8_encode($desc);
	//--
   $nombre = utf8_decode($nombre);
	$desc = utf8_decode($desc);
	
   if($nombre != "" && $desc != ""){
		$desde = "$fecdesde $hordesde";
		$hasta = "$fechasta $horhasta";
		$sql = $ClsInf->modifica_informacion($codigo,$nombre,$desc,$desde,$hasta,$link); /// Inserta a tabla Actividades
      if($archivo != ""){
         $archivo = str_shuffle($codigo.uniqid()).".jpg";
         $sql.= $ClsInf->modifica_imagen($codigo,$archivo);
      }
		$rs = $ClsInf->exec_sql($sql);
		//$respuesta->alert($sql);
		 if($rs == 1){
			if($archivo != ""){
				$respuesta->assign("codigo","value",$codigo);
            $respuesta->assign("docname","value",$archivo);
				$respuesta->script("Submit();");
			}else{
				$respuesta->script('swal("Excelente!", "Calendarizaci\u00F3n de evento actualizada con exito!", "success").then((value)=>{ window.location.reload(); });');
			}
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}	
			
	}
   return $respuesta;
}



function Buscar_Informacion($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsInf = new ClsInformacion();
	
	//$respuesta->alert("$codigo");
   $result = $ClsInf->get_informacion($codigo);
   if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["inf_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $nombre = utf8_decode($row["inf_nombre"]);
         $respuesta->assign("nom","value",$nombre);
         $desc = utf8_decode($row["inf_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $desde = $row["inf_fecha_inicio"];
         $desde = cambia_fechaHora($desde);
         $fecini = substr($desde,0,10);
         $horini = substr($desde,11,18);
         $respuesta->assign("fecini","value",$fecini);
         $respuesta->assign("horini","value",$horini);
         $hasta = $row["inf_fecha_fin"];
         $hasta = cambia_fechaHora($hasta);
         $fecfin = substr($hasta,0,10);
         $horfin = substr($hasta,11,18);
         $respuesta->assign("fecfin","value",$fecfin);
         $respuesta->assign("horfin","value",$horfin);
         $link = $row["inf_link"];
         $respuesta->assign("link","value",$link);
         //--
         $imagen = $row["inf_imagen"];
         $respuesta->assign("imagenold","value",$imagen);
         if($imagen != ""){
            $oldimg = '<label>Imagen:</label> <span>'.$imagen.'</span><br>';
            $oldimg.= '<img src="../../CONFIG/Actividades/'.$imagen.'"  class="img-thumbnail" width = "100%" >';
            $respuesta->assign("oldimg","innerHTML",$oldimg);
         }else{
            $oldimg = '<label>Imagen:</label> <span>(No hay imagen cargada)</span><br>';
            $oldimg.= '<img src="../../CONFIG/images/noimage.png"  class="img-thumbnail" width = "100%" >';
            $respuesta->assign("oldimg","innerHTML",$oldimg);
         }
      }
      //--
      $respuesta->script('document.getElementById("nom").focus();');
      $respuesta->script("cerrar();");
	}
   return $respuesta;
}



function Situacion_Informacion($codigo){
   $respuesta = new xajaxResponse();
   $ClsInf = new ClsInformacion();

   //$respuesta->alert("$cod");
   if($codigo != ""){
      $sql = $ClsInf->cambia_sit_informacion($codigo,0);
      $rs = $ClsInf->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Ok", "Actividad eliminada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
	}

	return $respuesta;
}


//////////////////---- RECORDATORIO -----/////////////////////////////////////////////

function Recordatorio($codigo){
   $respuesta = new xajaxResponse();
   $ClsInfo = new ClsInformacion();
	$ClsPush = new ClsPushup();
	 
   if($codigo != ""){
		$result = $ClsInfo->get_informacion($codigo);
		//$respuesta->alert("$result");
		if(is_array($result)){
			foreach($result as $row){
				$codigo = $row["inf_codigo"];
				$titulo = trim($row["inf_nombre"]);
				//--
				$desde = $row["inf_fecha_inicio"];
            $desde = cambia_fechaHora($desde);
            $fecini = substr($desde,0,10);
            $horini = substr($desde,11,18);
            //--
            $hasta = $row["inf_fecha_fin"];
            $hasta = cambia_fechaHora($hasta);
            $fecfin = substr($hasta,0,10);
            $horfin = substr($hasta,11,18);
            //
				$target = trim($row["inf_target"]);
				$tipo_target = trim($row["inf_tipo_target"]);
			}
		}
		
		if($target == "SELECT"){
			if($tipo_target == 1){
				$pensum = $_SESSION["pensum"];
				$result = $ClsInfo->get_det_informacion_secciones($codigo,'','','','');
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
				$result = $ClsInfo->get_det_informacion_grupos($codigo,'');
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
		
		$rs = $ClsInfo->exec_sql($sql);
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
$xajax->register(XAJAX_FUNCTION, "Grabar_Informacion");
$xajax->register(XAJAX_FUNCTION, "Modificar_Informacion");
$xajax->register(XAJAX_FUNCTION, "Buscar_Informacion");
$xajax->register(XAJAX_FUNCTION, "Situacion_Informacion");
//////////////////---- RECORDATORIO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Recordatorio");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  