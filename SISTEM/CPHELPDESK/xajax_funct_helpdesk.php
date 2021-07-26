<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_helpdesk.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- HELP DESK -----/////////////////////////////////////////////
function Grabar_Incidente($modulo,$plataforma,$tipo,$persona,$desc,$prioridad){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsInc = new ClsIncidente();
   //pasa a mayusculas
		$persona = trim($persona);
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$persona = utf8_encode($persona);
		$desc = utf8_encode($desc);
		//--
		$persona = utf8_decode($persona);
		$desc = utf8_decode($desc);
	//--------
	if($modulo != "" && $plataforma != "" && $tipo != "" && $prioridad != "" && $desc != ""){
		$codigo = $ClsInc->max_incidente();
		$codigo++;
		$sql = $ClsInc->insert_incidente($codigo,$modulo,$plataforma,$tipo,$persona,$desc,$prioridad,'');
		//$respuesta->alert("$sql");
		$rs = $ClsInc->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Reporte registrado satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMtablero.php" });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Buscar_Incidente($cod){
   $respuesta = new xajaxResponse();
   $ClsInc = new ClsIncidente();

   //$respuesta->alert("$cod");
	$cont = $ClsInc->count_incidente($cod,$dct,$desc,$pai,$sit);
	if($cont>0){
		if($cont==1){
				$result = $ClsInc->get_incidente($cod,$dct,$desc,$pai,$sit);
				foreach($result as $row){
					$cod = $row["inc_codigo"];
					$respuesta->assign("cod","value",$cod);
					$dct = utf8_decode($row["inc_desc_ct"]);
					$respuesta->assign("dct","value",$dct);
					$desc = utf8_decode($row["inc_desc_lg"]);
					$respuesta->assign("dlg","value",$desc);
					$pai = $row["inc_pais"];
					$respuesta->assign("pai","value",$pai);
					$sit = $row["inc_situacion"];
					$respuesta->assign("sit","value",$sit);
				}
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
		}
		//abilita y desabilita botones
		$contenido = tabla_incidentes();
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar();");
	}	
   return $respuesta;
}

function Modificar_Incidente($codigo,$modulo,$plataforma,$tipo,$persona,$desc,$prioridad){
   $respuesta = new xajaxResponse();
   $ClsInc = new ClsIncidente();
   //pasa a mayusculas
		$persona = trim($persona);
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$persona = utf8_encode($persona);
		$desc = utf8_encode($desc);
		//--
		$persona = utf8_decode($persona);
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$cod,$dct,$desc,$pai");
    if($codigo != ""){
		if($modulo != "" && $plataforma != "" && $tipo != "" && $prioridad != "" && $desc != ""){
			$sql = $ClsInc->modifica_incidente($codigo,$modulo,$plataforma,$tipo,$persona,$desc,$prioridad,'');
			//$respuesta->alert("$sql");
			$rs = $ClsInc->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMtablero.php" });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n, refresque la p\u00E1gina e intente de nuevo", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}


function Situacion_Incidente($codigo,$obs,$sit){
   $respuesta = new xajaxResponse();
   $ClsInc = new ClsIncidente();

    //$respuesta->alert("$codigo,$sit");
    if($codigo != ""){
		if($sit == 0){
         $sql = $ClsInc->modifica_observaciones($codigo,$obs);
			$sql.= $ClsInc->cambia_sit_incidente($codigo,$sit);
         //$respuesta->alert("$sql");
         $rs = $ClsInc->exec_sql($sql);
         if($rs == 1){
            $respuesta->script('swal("Excelente!", "Incidente cancelado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         }	
		}else{
			$sql = $ClsInc->modifica_observaciones($codigo,$obs);
			$sql.= $ClsInc->cambia_sit_incidente($codigo,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsInc->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Cambio de situaci\u00F3 exitoso!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}

	return $respuesta;
}


//////////////////---------/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Incidente");
$xajax->register(XAJAX_FUNCTION, "Buscar_Incidente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Incidente");
$xajax->register(XAJAX_FUNCTION, "Situacion_Incidente");

//El objeto xajax tiene que procesar cualquier petici\u00F3n
$xajax->processRequest();

?>  