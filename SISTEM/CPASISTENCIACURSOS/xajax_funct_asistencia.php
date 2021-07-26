<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_asistencia.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


function Grabar_Asistencia($horario,$fecha,$arrpresentes,$cantpresentes,$arrausentes,$cantausentes){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAsist = new ClsAsistencia();
   //$respuesta->alert("$cod,$materia,$nom,$desc,$fecha,$link");
	
   if($horario != "" && $fecha != ""){
		$sql = "";
		for($i = 0; $i < $cantpresentes; $i++){
			$alumno = $arrpresentes[$i];
			$sql.= $ClsAsist->insert_asistencia_cursos($horario,$fecha,$alumno,1);
		}	
		for($i = 0; $i < $cantausentes; $i++){
			$alumno = $arrausentes[$i];
			$sql.= $ClsAsist->insert_asistencia_cursos($horario,$fecha,$alumno,0);
		}	
		  
		$rs = $ClsAsist->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$msj = '<h5>Asistencia Registrada Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}	
			
	}
   return $respuesta;
}


function Modificar_Asistencia($horario,$fecha,$arrpresentes,$cantpresentes,$arrausentes,$cantausentes){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAsist = new ClsAsistencia();
   //$respuesta->alert("$cod,$materia,$nom,$desc,$fecha,$link");
	
   if($horario != "" && $fecha != ""){
		$sql = "";
		for($i = 0; $i < $cantpresentes; $i++){
			$alumno = $arrpresentes[$i];
			$sql.= $ClsAsist->modifica_asistencia_cursos($horario,$fecha,$alumno,1);
		}	
		for($i = 0; $i < $cantausentes; $i++){
			$alumno = $arrausentes[$i];
			$sql.= $ClsAsist->modifica_asistencia_cursos($horario,$fecha,$alumno,0);
		}	
		  
		$rs = $ClsAsist->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$msj = '<h5>Asistencia Modificada Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}	
			
	}
   return $respuesta;
}


function Eliminar_Asistencia($horario,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsTar = new ClsAsistencia();
   if($horario != "" && $fecha != ""){
	    //$respuesta->alert("$cod,$sit");
		$sql = delete_asistencia_cursos($horario,$fecha);
		//$rs = $ClsTar->exec_sql($sql);
		$respuesta->alert("$sql");
		if($rs == 1){
			$msj = '<h5>Asistencia Eliminada Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		 
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