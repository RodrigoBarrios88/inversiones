<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_photo.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- ALBUM -----/////////////////////////////////////////////
function Grabar_Photo($maestro,$desc,$target,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPho = new ClsPhoto();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$pensum,$nivel,$grado,$seccion,$maestro,$titulo,$desc,$target,$filas");
   $desc = utf8_encode($desc);
	//--
   $desc = utf8_decode($desc);
	
   if($maestro != ""){
      $codigo = $ClsPho->max_photo();
		$codigo++;
      $sql = $ClsPho->insert_photo($codigo,$maestro,$desc);
      if($filas > 0){ ////// Si hay alumnos tageados...
         $alumnos = "";
         for($i = 0; $i < $filas; $i ++){
            $alumno = $target[$i];
            $alumnos.= $target[$i].","; /// alinea y separa con comas para la busqueda de padres...
            $sql.= $ClsPho->insert_tag($codigo,$alumno);
         }
         $alumnos = substr($alumnos,0,-1);
         $result = $ClsPush->get_alumnos_users($alumnos);
      }
		
		/// registra la notificacion //
		if(is_array($result)) {
			$title = 'Nuevo Photo Album';
			$message = "Nueo Photo Album: $desc";
			$push_tipo = 11;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			$data = array(
            'landing_page'=> 'page',
            'codigo' => $item_id
         );
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
		
      //$respuesta->alert($sql);
		$rs = $ClsPho->exec_sql($sql);
		if($rs == 1){
			///// Ejecuta notificaciones push
			if(is_array($result)) {
				foreach ($result as $row){
					$user_id = $row["user_id"];
					$device_type = $row["device_type"];
					$device_token = $row["device_token"];
					$certificate_type = $row["certificate_type"];
					//cuenta las notificaciones pendientes
					$pendientes = intval($ClsPush->count_pendientes_leer($user_id));
               //--
               $data = array(
                  'landing_page'=> 'photo1',
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
			$respuesta->assign("codigo","value",$codigo);
         $respuesta->script("Submit();");
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Modificar_Photo($codigo,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPho = new ClsPhoto();
   //$respuesta->alert("$codigo,$desc");
	$desc = utf8_encode($desc);
	//--
   $desc = utf8_decode($desc);
	
   if($codigo != ""){
		$sql = $ClsPho->modifica_photo($codigo,$desc);
      //$respuesta->alert($sql);
      $rs = $ClsPho->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}	
			
	}
   return $respuesta;
}


function Modifca_Target($codigo,$target,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPho = new ClsPhoto();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$codigo,$target,$filas");
   
   if($codigo != ""){
      $sql = $ClsPho->delete_tags($codigo);
      if($filas > 0){ ////// Si hay alumnos tageados...
         $alumnos = "";
         for($i = 0; $i < $filas; $i ++){
            $alumno = $target[$i];
            $alumnos.= $target[$i].","; /// alinea y separa con comas para la busqueda de padres...
            $sql.= $ClsPho->insert_tag($codigo,$alumno);
         }
      }
		
		//$respuesta->alert($sql);
		$rs = $ClsPho->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Buscar_Photo($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPho = new ClsPhoto();
   //$respuesta->alert("$codigo");
	$result = $ClsPho->get_photo($codigo);
	if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["pho_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $maestro = utf8_decode($row["pho_maestro"]);
         $respuesta->assign("maestro","value",$maestro);
         $desc = utf8_decode($row["pho_descripcion"]);
         $respuesta->assign("desc","value",$desc);
     }
   }
   
   $respuesta->script('document.getElementById("tipo").focus();');
   $respuesta->script("cerrar();");
   return $respuesta;
}



function Eliminar_Photo($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPho = new ClsPhoto();
   if($codigo != ""){
	   //$respuesta->alert("$cod,$sit");
		$sql = $ClsPho->cambia_sit_photo($codigo,0);
		$rs = $ClsPho->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Ok!", "Registros eliminado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}



function Eliminar_Imagen($codigo,$imagen){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPho = new ClsPhoto();
   
   if($codigo != "" && $imagen != ""){
	   $sql = $ClsPho->delete_imagen($codigo,$imagen);
		$rs = $ClsPho->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
         unlink("../../CONFIG/Fotos/PHOTO/$imagen");
			$respuesta->script('swal("Ok!", "Registros eliminado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}



//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- POSTITs -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Photo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Photo");
$xajax->register(XAJAX_FUNCTION, "Modifca_Target");
$xajax->register(XAJAX_FUNCTION, "Buscar_Photo");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Photo");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Imagen");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  