<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_golpe.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- REPORTE DE GOLPE -----/////////////////////////////////////////////
function Grabar_Golpe($pensum,$nivel,$grado,$seccion,$alumno,$lugar,$hora,$desc,$medida,$dosis,$texto){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsGol = new ClsGolpe();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$pensum,$nivel,$grado,$seccion,$alumno,$lugar,$hora,$desc,$medida");
   $lugar = utf8_encode($lugar);
	$desc = utf8_encode($desc);
	$medida = utf8_encode($medida);
	$dosis = utf8_encode($dosis);
	$texto = utf8_encode($texto);
	//--
	$lugar = utf8_decode($lugar);
	$desc = utf8_decode($desc);
	$medida = utf8_decode($medida);
	$dosis = utf8_decode($dosis);
	$texto = utf8_decode($texto);
	//--
   if($lugar != "" && $hora != "" && $desc != ""){
		$codigo = $ClsGol->max_golpe();
		$codigo++;
		$sql = $ClsGol->insert_golpe($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$lugar,$hora,$desc,$medida,$dosis);
		
		/// registra la notificacion //
		$result = $ClsPush->get_alumno_users($alumno);
		if(is_array($result)) {
			$title = 'Reporte de Golpe';
			$message = $texto;
			$push_tipo = 8;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			foreach ($result as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id,$alumno);
			}
		}
		 
		$rs = $ClsGol->exec_sql($sql);
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
                  'landing_page'=> 'reportegolpe2',
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


function Modificar_Golpe($codigo,$alumno,$lugar,$hora,$desc,$medida,$dosis){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsGol = new ClsGolpe();
   //$respuesta->alert("$codigo,$alumno,$lugar,$hora,$desc,$medida");
	$lugar = utf8_encode($lugar);
	$desc = utf8_encode($desc);
	$medida = utf8_encode($medida);
	$dosis = utf8_encode($dosis);
	//--
	$lugar = utf8_decode($lugar);
	$desc = utf8_decode($desc);
	$medida = utf8_decode($medida);
	$dosis = utf8_decode($dosis);
	
   if($lugar != "" && $hora != "" && $desc != ""){
		$sql = $ClsGol->modifica_golpe($codigo,$alumno,$lugar,$hora,$desc,$medida,$dosis);
		$rs = $ClsGol->exec_sql($sql);
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


function Buscar_Golpe($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsGol = new ClsGolpe();
   //$respuesta->alert("$codigo");
	$result = $ClsGol->get_golpe($codigo);
	if(is_array($result)){
			foreach($result as $row){
					$codigo = $row["gol_codigo"];
					$respuesta->assign("codigo","value",$codigo);
					$pensum = $row["gol_pensum"];
					$respuesta->assign("pensum","value",$pensum);
					$nivel = $row["gol_nivel"];
					$respuesta->assign("nivel","value",$nivel);
					$grado = $row["gol_grado"];
					$respuesta->assign("grado","value",$grado);
					$seccion = $row["gol_seccion"];
					$respuesta->assign("grado","value",$seccion);
					$alumno = trim($row["gol_alumno"]);
					$respuesta->assign("alumno","value",$alumno);
					$lugar = trim($row["gol_lugar"]);
					$respuesta->assign("lugar","value",$lugar);
					$hora = trim($row["gol_hora"]);
					$respuesta->assign("hora","value",$hora);
					$desc = utf8_decode($row["gol_descripcion"]);
					$respuesta->assign("desc","value",$desc);
					$medida = utf8_decode($row["gol_medida"]);
					$respuesta->assign("medida","value",$medida);
					$dosis = utf8_decode($row["gol_dosis"]);
					$respuesta->assign("dosis","value",$dosis);
			}	
		}
			//abilita y desabilita botones
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
			
			$respuesta->script('document.getElementById("alumno").focus();');
			$respuesta->script("cerrar();");
    return $respuesta;
}



function Eliminar_Golpe($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsGol = new ClsGolpe();
   if($codigo != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = $ClsGol->delete_golpe($codigo);
		$rs = $ClsGol->exec_sql($sql);
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
$xajax->register(XAJAX_FUNCTION, "Grabar_Golpe");
$xajax->register(XAJAX_FUNCTION, "Modificar_Golpe");
$xajax->register(XAJAX_FUNCTION, "Buscar_Golpe");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Golpe");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  