<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_push.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- Notificacion -----/////////////////////////////////////////////
function Grabar_Push($user_id,$device_id,$device_token,$device_type,$certificate_type,$status,$created_at,$updated_at){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPush = new ClsPushup();

		$sql = $ClsPush->insert_push_user($user_id,$device_id,$device_token,$device_type,$certificate_type,$status,$created_at,$updated_at);
		$rs = $ClsPush->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script("cerrar();");
			$respuesta->script('swal("Excelente!", "Registro Guardado Satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("cerrar();");
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		}	
			
   return $respuesta;
}


function Buscar_Push($user_id,$device_id){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPush = new ClsPushup();
   //$respuesta->alert("$codigo");
	$result = $ClsPush->get_push_user($user_id,'','',$device_id);
	if(is_array($result)){
			foreach($result as $row){
					$user_id = $row["user_id"];
					$respuesta->assign("user_id","value",$user_id);
					$device_id = $row["device_id"];
					$respuesta->assign("device_id","value",$device_id);
					$device_token = $row["device_token"];
					$respuesta->assign("device_token","value",$device_token);
					$device_type = $row["device_type"];
					$respuesta->assign("device_type","value",$device_type);
					$certificate_type = $row["certificate_type"];
					$respuesta->assign("certificate_type","value",$certificate_type);
					$status = $row["status"];
					$respuesta->assign("status","value",$status);
					$created_at = $row["created_at"];
					$respuesta->assign("created_at","value",$created_at);
					$updated_at = utf8_decode($row["updated_at"]);
					$respuesta->assign("updated_at","value",$updated_at);
			}	
		}
			
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar();");
    return $respuesta;
}



function Eliminar_Push($user_id,$device_id){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPush = new ClsPushup();
   if($user_id != ""){
	   //$respuesta->alert("$cod,$sit");
		$sql = $ClsPush->delete_push_user($user_id,$device_id);
		$rs = $ClsPush->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script("cerrar();");
			$respuesta->script('swal("Excelente!", "Usuario Eliminado Satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("cerrar();");
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}



//asociamos las funciones creada anteriormente al objeto xajax
/////////////////---- Notificaciones -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Push");
$xajax->register(XAJAX_FUNCTION, "Buscar_Push");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Push");
//$xajax->register(XAJAX_FUNCTION, "Asignacion_Seccion");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  