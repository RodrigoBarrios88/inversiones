<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_poliza.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- POLIZAS -----/////////////////////////////////////////////
function Grabar_Poliza($suc,$doc,$fecha,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConta();
	 //pasa a mayusculas
		$doc = trim($doc);
		$fecha = trim($fecha);
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$doc = utf8_encode($doc);
		$desc = utf8_encode($desc);
		//--
		$doc = utf8_decode($doc);
		$desc = utf8_decode($desc);
	//--------
   if($suc != "" && $doc != "" && $fecha != "" && $desc != ""){
		$cod = $ClsCon->max_poliza();
		$cod++; /// Maximo codigo de poliza
		//$respuesta->alert("$suc");
		$sql = $ClsCon->insert_poliza($cod,$doc,$suc,$desc,$fecha); /// Inserta Poliza
		//$respuesta->alert("$sql");
		$rs = $ClsCon->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsCon->encrypt($cod, $usu);
			$respuesta->script('swal("Excelente!", "Pliza guardada satisfactoriamente!, ahora el contenido...", "success").then((value)=>{ window.location.href = "FRMdetalle.php?hashkey='.$hashkey.'"; });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}

function Modificar_Poliza($cod,$suc,$doc,$fecha,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConta();
	 //pasa a mayusculas
		$doc = trim($doc);
		$fecha = trim($fecha);
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$doc = utf8_encode($doc);
		$desc = utf8_encode($desc);
		//--
		$doc = utf8_decode($doc);
		$desc = utf8_decode($desc);
	//--------
   if($cod != "" && $suc != "" && $doc != "" && $fecha != "" && $desc != ""){
		
		$sql = $ClsCon->update_poliza($cod,$doc,$suc,$desc,$fecha); /// Modifcar Poliza
		//$respuesta->alert("$sql");
		$rs = $ClsCon->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros modificados satisfactoriamente!!!", "success").then((value)=>{ window.location.href = "FRMpolizas.php"; });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}

function Buscar_Poliza($cod){
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConta();
   //$respuesta->alert("$cod");
	$cont = $ClsCon->count_poliza($cod);
	if($cont>0){
		if($cont==1){
			$result = $ClsCon->get_poliza($cod);
			foreach($result as $row){
				$cod = $row["pol_codigo"];
				$respuesta->assign("cod","value",$cod);
				$suc = trim($row["pol_sucursal"]);
				$respuesta->assign("suc","value",$suc);
				$doc = utf8_decode($row["pol_documento"]);
				$respuesta->assign("doc","value",$doc);
				$fecha = utf8_decode($row["pol_fecha_contable"]);
				$fecha = cambia_fecha($fecha);
				$respuesta->assign("fecha","value",$fecha);
				$desc = utf8_decode($row["pol_descripcion"]);
				$respuesta->assign("desc","value",$desc);
			}
		}
		//--
		$respuesta->script("cerrar()");
	}	
   return $respuesta;
}


function Situacion_Poliza($cod){
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConta();
    //$respuesta->alert("$cod");
   if($cod != ""){
		$sql = $ClsCon->cambia_sit_poliza($cod,0);
		//$respuesta->alert("$sql");
		$rs = $ClsCon->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}



//////////////////---- DETALLE -----/////////////////////////////////////////////
function Buscar_Subreglon($cod,$partida,$reglon){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
   //$respuesta->alert("$cod,$partida,$reglon");
		$cont = $ClsPar->count_subreglon($cod,$partida,$reglon);
		if($cont>0){
			if($cont==1){
				$result = $ClsPar->get_subreglon($cod,$partida,$reglon);
				foreach($result as $row){
					$subreglon = $row["sub_codigo"];
					$respuesta->assign("subreglon","value",$subreglon);
					$reglon = $row["reg_codigo"];
					$respuesta->assign("reglon","value",$reglon);
					$partida = $row["par_codigo"];
					$respuesta->assign("par","value",$partida);
					$clase = $row["par_clase"];
					$respuesta->assign("clase","value",$clase);
					//---
					$descsubreglon = $row["sub_descripcion"];
					$respuesta->assign("descsubreglon","value",$descsubreglon);
					$descreglon = $row["reg_desc_lg"];
					$respuesta->assign("descreglon","value",$descreglon);
				}
			}
			$respuesta->script("cerrar();");
	   }	
   return $respuesta;
}



function Grabar_Detalle_Poliza($poliza,$tipo,$clase,$partida,$reglon,$subreglon,$motivo,$mov,$monto,$moneda,$tcambio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConta();
	 //pasa a mayusculas
		$motivo = trim($motivo);
	//--------
	//decodificaciones de tildes y Ñ's
		$motivo = utf8_encode($motivo);
		//--
		$motivo = utf8_decode($motivo);
	//--------
   if($poliza != "" && $tipo != "" && $partida != "" && $reglon != "" && $subreglon != "" && $monto != ""){
		$cod = $ClsCon->max_det_poliza($poliza);
		$cod++; /// Maximo codigo de poliza
		//$respuesta->alert("$cod");
		$sql = $ClsCon->insert_det_poliza($cod,$poliza,$tipo,$clase,$partida,$reglon,$subreglon,$motivo,$mov,$monto,$moneda,$tcambio); /// Inserta Poliza
		//$respuesta->alert("$sql");
		$rs = $ClsCon->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}


function Delete_Poliza($cod,$poliza){
   $respuesta = new xajaxResponse();
   $ClsCon = new ClsConta();
    //$respuesta->alert("$cod,$sit");
    if($cod != ""){
		$sql = $ClsCon->delete_det_poliza($cod,$poliza);
		//$respuesta->alert("$sql");
		$rs = $ClsCon->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}

	return $respuesta;
}

//////////////////---- POLIZAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Poliza");
$xajax->register(XAJAX_FUNCTION, "Modificar_Poliza");
$xajax->register(XAJAX_FUNCTION, "Buscar_Poliza");
$xajax->register(XAJAX_FUNCTION, "Situacion_Poliza");
//////////////////---- DETALLE -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Subreglon");
$xajax->register(XAJAX_FUNCTION, "Grabar_Detalle_Poliza");
$xajax->register(XAJAX_FUNCTION, "Delete_Poliza");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  