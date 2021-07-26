<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_asistencia.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


function Grabar_Reserva($horario,$fecha,$alumno,$asistencia){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAsist = new ClsAsistencia();
   //$respuesta->alert("$horario,$fecha,$alumno,$asistencia");
	
   if($horario != "" && $fecha != "" && $alumno != ""){
		$sql = $ClsAsist->insert_reserva_asistencia($horario,$fecha,$alumno,$asistencia);
		$rs = $ClsAsist->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$jscript.= "swal({";
			$jscript.= "title: 'Excelente!',";
			$jscript.= "text: 'Eleccion registrada satisfactoriamente',";
			$jscript.= "type: 'success'";
			$jscript.= "}, function(){ ";
			$jscript.= "window.location.reload();";
			$jscript.= "});";
			$respuesta->script("$jscript");
		}else{
			$jscript.= "swal({";
			$jscript.= "title: 'Oops!',";
			$jscript.= "text: 'Error de en la ejecucion...',";
			$jscript.= "type: 'error'";
			$jscript.= "});";
			$respuesta->script("$jscript");
		}	
			
	}
   return $respuesta;
}


function Eliminar_Reserva($horario,$fecha,$alumno){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsAsistencia();
   if($horario != "" && $fecha != "" && $alumno != ""){
	   $sql = delete_reserva_asistencia($horario,$fecha,$alumno);
		//$rs = $ClsTar->exec_sql($sql);
		$respuesta->alert("$sql");
		if($rs == 1){
			$jscript.= "swal({";
			$jscript.= "title: 'Ok!',";
			$jscript.= "text: 'Reserva eliminada satisfactoriamente',";
			$jscript.= "type: 'success'";
			$jscript.= "}, function(){ ";
			$jscript.= "window.location.reload();";
			$jscript.= "});";
			$respuesta->script("$jscript");
		}else{
			$jscript.= "swal({";
			$jscript.= "title: 'Oops!',";
			$jscript.= "text: 'Error de en la ejecucion...',";
			$jscript.= "type: 'error'";
			$jscript.= "});";
			$respuesta->script("$jscript");
		}
		//$respuesta->Script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- PARCIALES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Reserva");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Reserva");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  