<?php 
//incluímos las clases
require ("../../xajax_core/xajax.inc.php");
include_once("html_fns_reportes.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- VARIOS -----/////////////////////////////////////////////
function Pensum_Nivel($pensum,$idniv,$idsniv,$accniv){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$idniv,$idsniv,$accniv");
    $contenido = nivel_html($pensum,$idniv,$accniv);
    $respuesta->assign($idsniv,"innerHTML",$contenido);
	
	return $respuesta;
}

function Nivel_Grado($pensum,$nivel,$idgra,$idsgra,$accgra){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$idgra,$idsgra,$accgra");
    $contenido = grado_html($pensum,$nivel,$idgra,$accgra);
    $respuesta->assign($idsgra,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grado_Materia($pensum,$nivel,$grado,$idmat,$idsmat,$accmat){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$idmat,$idsmat,$accmat");
    $contenido = materia_html($pensum,$nivel,$grado,$idmat,$accmat);
    $respuesta->assign($idsmat,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grado_Seccion($pensum,$nivel,$grado,$tipo,$idsec,$idssec,$accsec){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$idsec,$idssec,$accsec");
    $contenido = seccion_html($pensum,$nivel,$grado,$tipo,$idsec,$accsec);
    $respuesta->assign($idssec,"innerHTML",$contenido);
	
	return $respuesta;
}


function Materia_Parcial($pensum,$nivel,$grado,$materia,$idpar,$idspar,$accpar){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$materia,$idpar,$idspar,$accpar");
    $contenido = parcial_html($pensum,$nivel,$grado,$materia,$idpar,$accpar);
    $respuesta->assign($idspar,"innerHTML",$contenido);
	
	return $respuesta;
}

function Grado_Nomina_Lista($pensum,$nivel,$grado,$tipo,$sit,$idnom,$idsnom){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$sit,$idnom,$idsnom");
    $contenido = nomina_lista_html($pensum,$nivel,$grado,$tipo,$sit,$idnom,"");
    $respuesta->assign($idsnom,"innerHTML",$contenido);
	
	return $respuesta;
}


function Grado_Nomina_Recuperacion_Lista($pensum,$nivel,$grado,$recuperacion,$sit,$idnom,$idsnom){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$pensum,$nivel,$grado,$tipo,$idnom,$idsnom");
    $contenido = nomina_lista_recuperacion_html($pensum,$nivel,$grado,$recuperacion,$sit,$idnom,"");
    $respuesta->assign($idsnom,"innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------
//////////////////////------------------------------------------------------------------------------

//asociamos las funciones creada anteriormente al objeto xajax
//////////////////---- VARIOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Pensum_Nivel");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
$xajax->register(XAJAX_FUNCTION, "Grado_Materia");
$xajax->register(XAJAX_FUNCTION, "Grado_Seccion");
$xajax->register(XAJAX_FUNCTION, "Materia_Parcial");
$xajax->register(XAJAX_FUNCTION, "Grado_Nomina_Lista");
$xajax->register(XAJAX_FUNCTION, "Grado_Nomina_Recuperacion_Lista");

//$xajax->register(XAJAX_FUNCTION, "Asignacion_Seccion");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  