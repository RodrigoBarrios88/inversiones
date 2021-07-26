<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_presupuesto.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Presupuestos /////////

function Asignar_Monto($cod,$reglon,$partida,$empresa,$anio,$mes,$alto,$bajo,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPre = new ClsPresupuesto();
   //$respuesta->alert("$reglon,$partida,$empresa,$anio,$mes,$alto,$bajo,$fila");
	$alto = ($alto == "")?0:$alto;
	$bajo = ($bajo == "")?0:$bajo;
   
   if($reglon != "" && $partida != "" && $empresa != "" && $anio != "" && $mes != ""){
		if($alto != "" || $bajo != ""){
			$result_nota_alumno = $ClsPre->get_presupuesto($cod,$reglon,$partida,'','',$empresa,$anio,$mes);  ////// este array se coloca en la columna de combos
			if(is_array($result_nota_alumno)){
				$sql.= $ClsPre->modifica_presupuesto_alto($cod,$alto);
				$sql.= $ClsPre->modifica_presupuesto_bajo($cod,$bajo);
			}else{
				$cod = $ClsPre->max_presupuesto();
				$cod++;
				$sql = $ClsPre->insert_presupuesto($cod,$reglon,$partida,$empresa,$anio,$mes,$alto,$bajo);		
			}
		}else{
			$sql = $ClsPre->delete_presupuesto($cod);
		}	
		 
		$rs = $ClsPre->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->assign("codigo$fila","value",$cod);
		}else{
			$respuesta->script("abrir();");
			$msj = '<h5>Error en la asignaci&oacute;n de este presupuesto...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->script("document.getElementById('alto$fila').className = 'form-control alert-danger';");
			$respuesta->script("document.getElementById('bajo$fila').className = 'form-control alert-danger';");
		}	
			
	}
   return $respuesta;
}



///////////////////---- ///////////// Clase /////////---- ////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Asignar_Monto");



//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  