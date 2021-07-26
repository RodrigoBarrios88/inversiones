<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_mineduc.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Codigo_Mineduc($alumno,$codigo_mineduc,$fila){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsAlu = new ClsAlumno();
    //$respuesta->alert("$cui,$codigo_mineduc,$fila");
   
    if($alumno != ""){
		$sql = $ClsAlu->modifica_codigo_mineduc($alumno,$codigo_mineduc);
		$rs = $ClsAlu->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->assign("spancheck$fila","innerHTML",'');
			$respuesta->script("document.getElementById('spancheck$fila').className = '';");
			$respuesta->script("document.getElementById('spancheck$fila').title = '';");
        }else{
			$respuesta->assign("spancheck$fila","innerHTML",'<span class="fa fa-times-circle-o"></span>');
		 	$respuesta->script("document.getElementById('spancheck$fila').className = 'btn btn-danger btn-xs';");
		 	$respuesta->script("document.getElementById('spancheck$fila').title = 'Error en la asignación. Intente de nuevo';");
		}	
			
	}
    
    return $respuesta;
}


//////////////////---- ASIGNACION DE NOTAS A ALUMNOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Codigo_Mineduc");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  