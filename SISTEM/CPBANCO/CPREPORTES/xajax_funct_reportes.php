<?php 
//incluímos las clases
require ("../../xajax_core/xajax.inc.php");
include_once("html_fns_reportes.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Combo_Cuenta_Banco($ban,$cue,$scue,$onclick){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$onclick");
	$contenido = cuenta_banco_html($ban,$cue,$onclick);
	$respuesta->assign($scue,"innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- Punto de Venta -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Cuenta_Banco");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  