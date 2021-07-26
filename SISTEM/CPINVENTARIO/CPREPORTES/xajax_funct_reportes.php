<?php 
//incluímos las clases
require ("../../xajax_core/xajax.inc.php");
include_once("html_fns_reportes.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// KARDEX //////////////////////////////////

function Combo_Grupo_Articulo($gru,$id){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$clase");
	$contenido = Articulo_html($gru,$id);
	$respuesta->assign("sart","innerHTML",$contenido);
	
	
	return $respuesta;
}

/////////////// KARDEX /////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Grupo_Articulo");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  