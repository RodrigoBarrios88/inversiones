<?php 
//incluímos las clases
require ('xajax_core/xajax.inc.php');
include_once('html_fns.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
//$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');
 
function Cambia_Empresa($cod,$nom){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
	$_SESSION["empresa"] = $nom;
	$_SESSION["empCodigo"] = $cod;
   $respuesta->redirect("menu.php", 0);
   return $respuesta;
}

function Selecciona_Caja($cod){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
	$_SESSION["cajapv"] = $cod;
	$respuesta->redirect("menu.php", 0);
   return $respuesta;
}

///////////// Punto de Venta - Empresa /////////
function SucPuntVnt($suc,$nom){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
	$contenido = punto_venta_html($suc,$nom);
	//$respuesta->alert("$contenido");
	$respuesta->assign("s$nom","innerHTML",$contenido);
	
	return $respuesta;
}

///////////// CONFIGURACION INICIAL //////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Cambia_Empresa");
$xajax->register(XAJAX_FUNCTION, "Selecciona_Caja");
///////////////////---- Punto de Venta - Empresa---- ////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "SucPuntVnt");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  