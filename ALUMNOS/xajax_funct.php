<?php 
//incluímos las clases
require ('xajax_core/xajax.inc.php');
include_once('html_fns.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Autorizacion_Circular($circular,$autorizacion){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCir = new ClsCircular();
   //$respuesta->alert("$circular,$autorizacion");
	if($circular != ""){
		$persona = $_SESSION["tipo_codigo"];
		$sql = $ClsCir->insert_autorizacion($circular,$persona,$autorizacion);
		//$respuesta->alert("$sql");
		$rs = $ClsCir->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Autorizaci\u00F3n enviada!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("swal('Error', 'Error en la transacci\u00F3n...', 'error');");
		}
	}
   
   return $respuesta;
}

///////////////////---- Circulares ---- ////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Autorizacion_Circular");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  