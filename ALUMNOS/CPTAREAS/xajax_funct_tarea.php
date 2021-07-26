<?php 
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_tarea.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- TAREAS DE CURSOS -----/////////////////////////////////////////////

function Responder_Tarea_Materias($tarea,$alumno,$texto){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   if($tarea != "" && $alumno != ""){
	   //$respuesta->alert("tarea,$alumno,$nota,$obs,$fila");
		$sql = $ClsTar->insert_respuesta_tarea($tarea,$alumno,$texto);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Respuesta enviada con \u00E9xito, tarea resuelta!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ window.location.reload(); });');
		}
		//$respuesta->Script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


function Responder_Tarea_Cursos($tarea,$alumno,$texto){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
   if($tarea != "" && $alumno != ""){
	   //$respuesta->alert("tarea,$alumno,$nota,$obs,$fila");
		$sql = $ClsTar->insert_respuesta_tarea_curso($tarea,$alumno,$texto);
		$rs = $ClsTar->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Respuesta enviada con \u00E9xito, tarea resuelta!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ window.location.reload(); });');
		}
		//$respuesta->Script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


//---- ARCHIVOS AUXILIARES O GIAS -----//

function Delete_Archivo_Materias($codigo,$tarea,$alumno,$archivo){
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	
	if($codigo != "" && $tarea != ""){
     	$sql = $ClsTar->delete_respuesta_tarea_archivo($codigo,$tarea,$alumno);
		$rs = $ClsTar->exec_sql($sql);
      if($rs == 1){
			if(file_exists("../../CONFIG/DATALMSALUMNOS/TAREAS/MATERIAS/$archivo")){
            unlink("../../CONFIG/DATALMSALUMNOS/TAREAS/MATERIAS/$archivo");
         }
			$respuesta->script('swal("Excelente", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   } 
   
   return $respuesta;
}


function Delete_Archivo_Cursos($codigo,$tarea,$alumno,$archivo){ 
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsTarea();
	
	if($codigo != "" && $tarea != ""){
     	$sql = $ClsTar->delete_respuesta_tarea_curso_archivo($codigo,$tarea,$alumno);
		$rs = $ClsTar->exec_sql($sql);
      if($rs == 1){
			if(file_exists("../../CONFIG/DATALMSALUMNOS/TAREAS/CURSOS/$archivo")){
            unlink("../../CONFIG/DATALMSALUMNOS/TAREAS/CURSOS/$archivo");
         }
			$respuesta->script('swal("Excelente!", "Archivo Eliminado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }
   }   
   
   return $respuesta;
}


//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- TAREAS DE CURSOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Responder_Tarea_Materias");
$xajax->register(XAJAX_FUNCTION, "Responder_Tarea_Cursos");
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo_Materias");
$xajax->register(XAJAX_FUNCTION, "Delete_Archivo_Cursos");


//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>  