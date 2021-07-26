<?php 
//incluímos las clases
require ("../../xajax_core/xajax.inc.php");
include_once("html_fns_reportes.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Producto_Servicio($tipo){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
      if($tipo == "S"){
	$contenido = Grupo_Serv_html();
      }else if($tipo == "P"){
	$contenido = Grupo_Art_html();
      }else{
        $contenido = '<select name="gru" id="gru" class = "combo">';
	$contenido.= '<option value="">Seleccione</option>';
	$contenido.='</select>';
      } 
      //$respuesta->alert("$contenido");
      $respuesta->assign("spangru","innerHTML",$contenido);
	
	return $respuesta;
}


//////////////////---- VENTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Producto_Servicio");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  