<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_conducta.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- REPORTE DE CONDUCTA -----/////////////////////////////////////////////
function Grabar_Conducta($pensum,$nivel,$grado,$seccion,$alumno,$calificacion,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConducta();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$pensum,$nivel,$grado,$seccion,$alumno,$pipi,$popo,$tipo,$obs");
   $obs = utf8_encode($obs);
	//--
	$obs = utf8_decode($obs);
	//--
   if($alumno != "" && $calificacion != ""){
		$codigo = $ClsCon->max_conducta();
		$codigo++;
		$sql = $ClsCon->insert_conducta($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$calificacion,$obs);
		switch($calificacion){
         case 1: $texto = "Muy Bien"; break;
         case 2: $texto = "Bien"; break;
         case 3: $texto = "Regular"; break;
         case 4: $texto = "Debo Mejorar"; break;
      }
      /// registra la notificacion //
		$result = $ClsPush->get_alumno_users($alumno);
		if(is_array($result)) {
			$title = "Reporte de Conducta";
			$message = "Hoy me porte:\r\n$texto.\r\nObservaciones: $obs.";
			$push_tipo = 10;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
         //--
			foreach ($result as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id,$alumno);
			}
		}
		 
		$rs = $ClsCon->exec_sql($sql);
		//$respuesta->alert($sql);
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
					   'landing_page'=> 'reporteconducta2',
					   'codigo' => $item_id
					);
					//envia la push
					if($device_type == 'android') {
						SendAndroidPush($device_token, $title, $message, $pendientes, $push_desc, $item_id, '', $data);
        			}else if($device_type == 'ios') {
        				SendAndroidPush($device_token, $title, $message, $pendientes, $push_tipo, $item_id, '', $data); // iOS
            	}	
				}
			}
			////
			$respuesta->script('swal("Excelente!", "Resgistro actualizado satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}	
			
	}
   return $respuesta;
}


function Modificar_Conducta($codigo,$alumno,$calificacion,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConducta();
   //$respuesta->alert("$codigo,$alumno,$pipi,$popo,$tipo,$obs");
	$obs = utf8_encode($obs);
	//--
	$obs = utf8_decode($obs);
	
   if($alumno != "" && $calificacion != ""){
		$sql = $ClsCon->modifica_conducta($codigo,$alumno,$calificacion,$obs);
		$rs = $ClsCon->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Resgistro actualizado satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		}	
			
	}
   return $respuesta;
}


function Buscar_Conducta($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConducta();
   //$respuesta->alert("$codigo");
	$result = $ClsCon->get_conducta($codigo);
	if(is_array($result)){
			foreach($result as $row){
					$codigo = $row["con_codigo"];
					$respuesta->assign("codigo","value",$codigo);
					$pensum = $row["con_pensum"];
					$respuesta->assign("pensum","value",$pensum);
					$nivel = $row["con_nivel"];
					$respuesta->assign("nivel","value",$nivel);
					$grado = $row["con_grado"];
					$respuesta->assign("grado","value",$grado);
					$seccion = $row["con_seccion"];
					$respuesta->assign("grado","value",$seccion);
					$alumno = trim($row["con_alumno"]);
					$respuesta->assign("alumno","value",$alumno);
					$pipi = trim($row["con_cant_pipi"]);
					$respuesta->assign("pipi","value",$pipi);
					$obs = utf8_decode($row["con_observaciones"]);
					$respuesta->assign("obs","value",$obs);
			}	
		}
			//abilita y desabilita botones
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
			
			$respuesta->script('document.getElementById("alumno").focus();');
			$respuesta->script("cerrar();");
    return $respuesta;
}



function Eliminar_Conducta($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConducta();
   if($codigo != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = $ClsCon->delete_conducta($codigo);
		$rs = $ClsCon->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Resgistro eliminado satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- ESTRUCTURA -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Pensum_Nivel");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Grado_Materia_Seccion");
//////////////////---- POSTITs -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Conducta");
$xajax->register(XAJAX_FUNCTION, "Modificar_Conducta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Conducta");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Conducta");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  