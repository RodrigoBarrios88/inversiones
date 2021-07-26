<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_periodo.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- PERIODO FISCAL -----/////////////////////////////////////////////
function Grabar_Periodo($desc,$anio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPeriodoFiscal();
   //$respuesta->alert("$desc,$anio");
   //--
   $desc = utf8_encode($desc);
   $desc = utf8_decode($desc);
   //--
   if($desc != "" && $anio != ""){
      $codigo = $ClsPer->max_periodo();
      $codigo++;
      $sql = $ClsPer->insert_periodo($codigo,$desc,$anio);
      $rs = $ClsPer->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
      }	
			
	}
   return $respuesta;
}


function Modificar_Periodo($codigo,$desc,$anio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPeriodoFiscal();
   //$respuesta->alert("$desc,$anio");
   //--
   $desc = utf8_encode($desc);
   $desc = utf8_decode($desc);
   //--
   if($desc != "" && $anio != ""){
      $sql = $ClsPer->modifica_periodo($codigo,$desc,$anio);
      $rs = $ClsPer->exec_sql($sql);
      //$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      }	
			
	}
   return $respuesta;
}


function Buscar_Periodo($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPeriodoFiscal();
   //$respuesta->alert("$codigo");
   $result = $ClsPer->get_periodo($codigo);
   if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["per_codigo"];
         $respuesta->assign("cod","value",$codigo);
         $desc = utf8_decode($row["per_descripcion"]);
         $respuesta->assign("desc","value",$desc);
         $anio = $row["per_anio"];
         $respuesta->assign("anio","value",$anio);
      }	
      //abilita y desabilita botones
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden'");
      
      $contenido = tabla_periodo($codigo,$anio,$sit);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Status_Periodo($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPeriodoFiscal();
   if($codigo != ""){
      //$respuesta->alert("$codigo,$sit");
      $sql = $ClsPer->cambia_periodo_activo($codigo);
      $rs = $ClsPer->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Periodo activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
      //$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}


function CambiaSit_Periodo($codigo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPeriodoFiscal();
   if($codigo != ""){
      //$respuesta->alert("$codigo,$sit");
      $sql = $ClsPer->cambia_sit_periodo($codigo,0);
      $rs = $ClsPer->exec_sql($sql);
      //$respuesta->alert("$sql");
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Periodo deshabilitado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }
      //$respuesta->script("cerrarMixPromt();");
	}
   		
   return $respuesta;
}

//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- PENSUM -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Periodo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Periodo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Periodo");
$xajax->register(XAJAX_FUNCTION, "Status_Periodo");
$xajax->register(XAJAX_FUNCTION, "CambiaSit_Periodo");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  