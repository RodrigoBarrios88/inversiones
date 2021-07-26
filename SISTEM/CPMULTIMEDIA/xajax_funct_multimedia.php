<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_multimedia.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');



//////////////////---- MULTIMEDIA -----/////////////////////////////////////////////
function Grabar_Multimedia($titulo,$link,$tipo,$categoria){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMulti = new ClsMultimedia();
   $ClsPush = new ClsPushup();
   //$respuesta->alert("$titulo,$link,$tipo,$categoria");
   $titulo = utf8_encode($titulo);
   //--
   $titulo = utf8_decode($titulo);
   //--
   $link = str_replace(" ","",trim($link)); ///limpia espacios
   $link = str_replace("https://www.youtube.com/watch?v=","",$link); ///remplaza la version browser por la versión embeded
   $link = str_replace("https://youtu.be/","",$link); ///remplaza la version browser por la versión embeded
   if($titulo != "" && $link != ""){
      $codigo = $ClsMulti->max_multimedia();
      $codigo++;
      $sql = $ClsMulti->insert_multimedia($codigo,$titulo,$link,$tipo,$categoria);
      //notificaciones
      $pensum = $_SESSION["pensum"];
		$result_push = $ClsPush->get_nivel_grado_seccion_users($pensum,'','','');
      if(is_array($result_push)) {
			$title = 'Nuevo Video';
			$message = "Nuevo video multimedia: $titulo";
			$push_tipo = 5;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			foreach ($result_push as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id);
			}
		}
      $rs = $ClsMulti->exec_sql($sql);
      //$respuesta->alert($sql);
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
					   'landing_page'=> 'videos',
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
			$respuesta->script('swal("Excelente!", "Video publicado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}	
			
	}
   return $respuesta;
}


function Modificar_Multimedia($codigo,$titulo,$link,$tipo,$categoria){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMulti = new ClsMultimedia();
   //$respuesta->alert("$cod,$tipo,$titulo,$link,$fecha,$link");
   $titulo = utf8_encode($titulo);
   //--
   $titulo = utf8_decode($titulo);
   $link = str_replace(" ","",trim($link)); ///limpia espacios
   $link = str_replace("https://www.youtube.com/watch?v=","",$link); ///remplaza la version browser por la versión embeded
   $link = str_replace("https://youtu.be/","",$link); ///remplaza la version browser por la versión embeded
   
   if($codigo != "" && $titulo != "" && $link != "" && $tipo != ""){	
      $sql = $ClsMulti->modifica_multimedia($codigo,$titulo,$link,$tipo,$categoria);
      $rs = $ClsMulti->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
        $respuesta->script('swal("Excelente!", "Video publicado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}	
			
	}
   return $respuesta;
}


function Buscar_Multimedia($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMulti = new ClsMultimedia();
   //$respuesta->alert("$codigo");
	$result = $ClsMulti->get_multimedia($codigo);
	if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["multi_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $titulo = utf8_decode($row["multi_titulo"]);
         $respuesta->assign("titulo","value",$titulo);
         $link = $row["multi_link"];
         $respuesta->assign("link","value","https://www.youtube.com/watch?v=$link");
         $tipo = $row["multi_tipo"];
         $respuesta->assign("tipo","value",$tipo);
         $categoria = $row["multi_categoria"];
         $respuesta->assign("categoria","value",$categoria);
      }
		//abilita y desabilita botones
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
	}		
	$respuesta->script("cerrar();");
    return $respuesta;
}



function Eliminar_Multimedia($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMulti = new ClsMultimedia();
   if($codigo != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = $ClsMulti->cambia_sit_multimedia($codigo,0);
		$rs = $ClsMulti->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Ok", "Contenido Multimedia eliminado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


function Contador_Multimedia($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMulti = new ClsMultimedia();
   if($codigo != ""){
	    //$respuesta->alert("$cod,$sit");
		//$sql = $ClsMulti->contador_multimedia($codigo);
		//$rs = $ClsMulti->exec_sql($sql);
		$respuesta->alert("$sql");
		if($rs == 1){
			return $respuesta;
		}else{
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
		}
	}  		
   return $respuesta;
}


//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- PARCIALES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Multimedia");
$xajax->register(XAJAX_FUNCTION, "Modificar_Multimedia");
$xajax->register(XAJAX_FUNCTION, "Buscar_Multimedia");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Multimedia");
$xajax->register(XAJAX_FUNCTION, "Contador_Multimedia");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  