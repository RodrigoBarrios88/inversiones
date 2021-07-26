<?php 
//incluímos las clases
require ("../../xajax_core/xajax.inc.php");
include_once("html_fns_reportes.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Departamentos - Empresas /////////
function EmpDepartamento($emp,$nom){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$emp");
	$contenido = Org_Departamento_html($emp,$nom);
	$respuesta->assign("sdep","innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- Punto de Venta -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, EmpDepartamento);

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  