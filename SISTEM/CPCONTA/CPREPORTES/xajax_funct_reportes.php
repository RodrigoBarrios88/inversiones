<?php 
//incluímos las clases
require ("../../xajax_core/xajax.inc.php");
include_once("html_fns_reportes.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Partida - Reglon /////////
function Combo_Partida($tipo){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
	$contenido = Partida_html($tipo,"par");
	//$respuesta->alert("$contenido");
	$respuesta->assign("spar","innerHTML",$contenido);
	
	return $respuesta;
}

///////////////////---- ///////////// Partida - Reglon /////////////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Partida");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  