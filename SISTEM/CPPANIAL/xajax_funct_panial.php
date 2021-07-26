<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_panial.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- REPORTE DE PAÑAL -----/////////////////////////////////////////////
function Grabar_Panial($pensum,$nivel,$grado,$seccion,$alumno,$pipi,$popo,$tipo,$obs,$texto){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPan = new ClsPanial();
	$ClsPush = new ClsPushup();
   $ClsAlu = new ClsAlumno();
	//$respuesta->alert("$pensum,$nivel,$grado,$seccion,$alumno,$pipi,$popo,$tipo,$obs");
   $tipo = utf8_encode($tipo);
	$obs = utf8_encode($obs);
	$texto = utf8_encode($texto);
	//--
	$tipo = utf8_decode($tipo);
	$obs = utf8_decode($obs);
	$texto = utf8_decode($texto);
	//--
   if($pipi != "" && $popo != "" && $tipo != ""){
		$codigo = $ClsPan->max_panial();
		$codigo++;
		$sql = $ClsPan->insert_panial($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$pipi,$popo,$tipo,$obs);

//-----------
$result_alumno = $ClsAlu->get_alumno($alumno);
if(is_array($result_alumno)){
   foreach($result_alumno as $row_alumno){
      $alumno_nombre = trim($row_alumno["alu_nombre"])." ".trim($row_alumno["alu_apellido"]);
   }
}	
//-----------         
$cuerpo = "
Deseamos informar que el día de hoy cambiamos el pañal de su hijo(a): $alumno_nombre.\r\n
Veces con pipi: $pipi.
Veces con popo: $popo.
Consistencia: $tipo.
Observaciones: $obs.
";
$message = "
Deseamos informar que el dia de hoy cambiamos el panal de su hijo(a): $alumno_nombre.\r\n
Veces con pipi: $pipi.
Veces con popo: $popo.
Consistencia: $tipo.
Observaciones: $obs.
";
$cuerpo = trim($cuerpo);
$message = trim($message);
//--------
      
		/// registra la notificacion //
		$result = $ClsPush->get_alumno_users($alumno);
		if(is_array($result)) {
			$title = $texto;
			$push_tipo = 7;
         $item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			foreach ($result as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$cuerpo,$push_tipo,$item_id,$alumno);
			}
		}
		 
		$rs = $ClsPan->exec_sql($sql);
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
               //liempia cadena
               $message = depurador_texto($message);
					//--
					$data = array(
					   'landing_page'=> 'reportepanial2',
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


function Modificar_Panial($codigo,$alumno,$pipi,$popo,$tipo,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPan = new ClsPanial();
   //$respuesta->alert("$codigo,$alumno,$pipi,$popo,$tipo,$obs");
	$tipo = utf8_encode($tipo);
	$obs = utf8_encode($obs);
	//--
	$tipo = utf8_decode($tipo);
	$obs = utf8_decode($obs);
	
   if($pipi != "" && $popo != "" && $tipo != ""){
		$sql = $ClsPan->modifica_panial($codigo,$alumno,$pipi,$popo,$tipo,$obs);
		$rs = $ClsPan->exec_sql($sql);
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


function Buscar_Panial($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPan = new ClsPanial();
   //$respuesta->alert("$codigo");
	$result = $ClsPan->get_panial($codigo);
	if(is_array($result)){
			foreach($result as $row){
					$codigo = $row["pan_codigo"];
					$respuesta->assign("codigo","value",$codigo);
					$pensum = $row["pan_pensum"];
					$respuesta->assign("pensum","value",$pensum);
					$nivel = $row["pan_nivel"];
					$respuesta->assign("nivel","value",$nivel);
					$grado = $row["pan_grado"];
					$respuesta->assign("grado","value",$grado);
					$seccion = $row["pan_seccion"];
					$respuesta->assign("grado","value",$seccion);
					$alumno = trim($row["pan_alumno"]);
					$respuesta->assign("alumno","value",$alumno);
					$pipi = trim($row["pan_cant_pipi"]);
					$respuesta->assign("pipi","value",$pipi);
					$popo = trim($row["pan_cant_popo"]);
					$respuesta->assign("popo","value",$popo);
					$tipo = utf8_decode($row["pan_tipo"]);
					$respuesta->assign("tipo","value",$tipo);
					$obs = utf8_decode($row["pan_observaciones"]);
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



function Eliminar_Panial($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPan = new ClsPanial();
   if($codigo != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = $ClsPan->delete_panial($codigo);
		$rs = $ClsPan->exec_sql($sql);
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
$xajax->register(XAJAX_FUNCTION, "Grabar_Panial");
$xajax->register(XAJAX_FUNCTION, "Modificar_Panial");
$xajax->register(XAJAX_FUNCTION, "Buscar_Panial");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Panial");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  