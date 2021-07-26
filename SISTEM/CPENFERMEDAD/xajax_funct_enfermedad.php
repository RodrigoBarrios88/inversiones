<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_enfermedad.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- REPORTE DE ENFERMEDAD -----/////////////////////////////////////////////
function Grabar_Enfermedad($pensum,$nivel,$grado,$seccion,$alumno,$sintomas,$hora,$aviso,$medida,$dosis,$texto){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsEnf = new ClsEnfermedad();
	$ClsPush = new ClsPushup();
	//$respuesta->alert("$pensum,$nivel,$grado,$seccion,$alumno,$sintomas,$hora,$aviso,$medida");
   $sintomas = utf8_encode($sintomas);
	$aviso = utf8_encode($aviso);
	$medida = utf8_encode($medida);
	$dosis = utf8_encode($dosis);
	$texto = utf8_encode($texto);
	//--
	$sintomas = utf8_decode($sintomas);
	$aviso = utf8_decode($aviso);
	$medida = utf8_decode($medida);
	$dosis = utf8_decode($dosis);
	$texto = utf8_decode($texto);
	//--
   if($sintomas != "" && $hora != "" && $aviso != ""){
		$codigo = $ClsEnf->max_enfermedad();
		$codigo++;
		$sql = $ClsEnf->insert_enfermedad($codigo,$pensum,$nivel,$grado,$seccion,$alumno,$sintomas,$hora,$aviso,$medida,$dosis);
		
		/// registra la notificacion //
		$result = $ClsPush->get_alumno_users($alumno);
		if(is_array($result)) {
			$title = 'Reporte de Enfermedad';
			$message = $texto;
			$push_tipo = 9;
			$item_id = $codigo;
			$cert_path = '../../CONFIG/push/ck_prod.pem';
			//--
			foreach ($result as $row){
				$user_id = $row["user_id"];
				$sql.= $ClsPush->insert_push_notification($user_id,$message,$push_tipo,$item_id,$alumno);
			}
		}
		 
		$rs = $ClsEnf->exec_sql($sql);
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
					   'landing_page'=> 'reporteenfermedad2',
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


function Modificar_Enfermedad($codigo,$alumno,$sintomas,$hora,$aviso,$medida,$dosis){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsEnf = new ClsEnfermedad();
   //$respuesta->alert("$codigo,$alumno,$sintomas,$hora,$aviso,$medida");
	$sintomas = utf8_encode($sintomas);
	$aviso = utf8_encode($aviso);
	$medida = utf8_encode($medida);
	$dosis = utf8_encode($dosis);
	//--
	$sintomas = utf8_decode($sintomas);
	$aviso = utf8_decode($aviso);
	$medida = utf8_decode($medida);
	$dosis = utf8_decode($dosis);
	
   if($sintomas != "" && $hora != "" && $aviso != ""){
		$sql = $ClsEnf->modifica_enfermedad($codigo,$alumno,$sintomas,$hora,$aviso,$medida,$dosis);
		$rs = $ClsEnf->exec_sql($sql);
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


function Buscar_Enfermedad($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsEnf = new ClsEnfermedad();
   //$respuesta->alert("$codigo");
	$result = $ClsEnf->get_enfermedad($codigo);
	if(is_array($result)){
			foreach($result as $row){
					$codigo = $row["enf_codigo"];
					$respuesta->assign("codigo","value",$codigo);
					$pensum = $row["enf_pensum"];
					$respuesta->assign("pensum","value",$pensum);
					$nivel = $row["enf_nivel"];
					$respuesta->assign("nivel","value",$nivel);
					$grado = $row["enf_grado"];
					$respuesta->assign("grado","value",$grado);
					$seccion = $row["enf_seccion"];
					$respuesta->assign("grado","value",$seccion);
					$alumno = trim($row["enf_alumno"]);
					$respuesta->assign("alumno","value",$alumno);
					$sintomas = trim($row["enf_sintomas"]);
					$respuesta->assign("sintomas","value",$sintomas);
					$hora = trim($row["enf_hora"]);
					$respuesta->assign("hora","value",$hora);
					$aviso = utf8_decode($row["enf_aviso"]);
					$respuesta->assign("aviso","value",$aviso);
					$medida = utf8_decode($row["enf_medida"]);
					$respuesta->assign("medida","value",$medida);
					$dosis = utf8_decode($row["enf_dosis"]);
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



function Eliminar_Enfermedad($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsEnf = new ClsEnfermedad();
   if($codigo != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = $ClsEnf->delete_enfermedad($codigo);
		$rs = $ClsEnf->exec_sql($sql);
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

//////////////////---- ENFERMEDAD -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Enfermedad");
$xajax->register(XAJAX_FUNCTION, "Modificar_Enfermedad");
$xajax->register(XAJAX_FUNCTION, "Buscar_Enfermedad");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Enfermedad");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  