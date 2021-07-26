<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once('html_fns_materias.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- HIJOS -----/////////////////////////////////////////////

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  