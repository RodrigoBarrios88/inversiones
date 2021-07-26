<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_encuesta.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- RESPUESTAS -----/////////////////////////////////////////////

function Grabar_Respuesta($encuesta,$pregunta,$persona,$tipo,$ponderacion,$texto){
   $respuesta = new xajaxResponse();
   $ClsEnc = new ClsEncuesta();

	if($encuesta != "" && $pregunta != "" && $persona != "" && $tipo != "" && $ponderacion != ""){
			$sql = $ClsEnc->insert_respuesta($encuesta,$pregunta,$persona,$tipo,$ponderacion,$texto);
			$rs = $ClsEnc->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				
			}else{
				$respuesta->Script("abrir();");
				$msj = '<h5>Error de Conexion...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
	}

	return $respuesta;
}

//////////////////---- RESPUESTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Respuesta");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  