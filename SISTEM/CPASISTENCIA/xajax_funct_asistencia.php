<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_asistencia.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


function Grabar_Asistencia($horario,$fecha,$arrpresentes,$cantpresentes,$arrausentes,$cantausentes,$arrcomentario,$arrcomentarioaus){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAsist = new ClsAsistencia();
   //$respuesta->alert("$cod,$materia,$nom,$desc,$fecha,$link");
	
   if($horario != "" && $fecha != ""){
		$sql = "";
		for($i = 0; $i < $cantpresentes; $i++){
			$alumno = $arrpresentes[$i];
			$comentario = $arrcomentario[$i];
			$sql.= $ClsAsist->insert_asistencia($horario,$fecha,$alumno,1,$comentario);
		}	
		for($i = 0; $i < $cantausentes; $i++){
			$alumno = $arrausentes[$i];
			$comentario = $arrcomentarioaus[$i];
			$sql.= $ClsAsist->insert_asistencia($horario,$fecha,$alumno,0,$comentario);
		}	
		  
		$rs = $ClsAsist->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Asistencia registrada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Modificar_Asistencia($horario,$fecha,$arrpresentes,$cantpresentes,$arrausentes,$cantausentes,$arrcomentario,$arrcomentarioaus){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAsist = new ClsAsistencia();
   //$respuesta->alert("$cod,$materia,$nom,$desc,$fecha,$link");
	
   if($horario != "" && $fecha != ""){
		$sql = "";
		for($i = 0; $i < $cantpresentes; $i++){
			$alumno = $arrpresentes[$i];
			$comentario = $arrcomentario[$i];
			$sql.= $ClsAsist->modifica_asistencia($horario,$fecha,$alumno,1,$comentario);
		}	
		for($i = 0; $i < $cantausentes; $i++){
			$alumno = $arrausentes[$i];
			$comentario = $arrcomentarioaus[$i];
			$sql.= $ClsAsist->modifica_asistencia($horario,$fecha,$alumno,0,$comentario);
		}	
		  
		$rs = $ClsAsist->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Asistencia actualizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}	
			
	}
   return $respuesta;
}


function Eliminar_Asistencia($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsAsistencia();
   if($codigo != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = $ClsTar->delete_det_tarea_alumnos($codigo);
		$sql.= $ClsTar->delete_tarea($codigo);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Asistencia eliminada satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		 
		}
		//$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- PARCIALES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Asistencia");
$xajax->register(XAJAX_FUNCTION, "Modificar_Asistencia");
$xajax->register(XAJAX_FUNCTION, "Buscar_Asistencia");
$xajax->register(XAJAX_FUNCTION, "Eliminar_Asistencia");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  