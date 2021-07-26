<?php 
//incluímos las clases
require ("../../xajax_core/xajax.inc.php");
include_once("html_fns_asignaciones.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


//////////////////---- BONIFICACIONES REGULAR -----/////////////////////////////////////////////
function Grabar_Bonificacion_Regular($nomina,$personal,$monto,$moneda,$tcambio,$desc){
   $respuesta = new xajaxResponse();
   $ClsPlaAsi = new ClsPlanillaAsignaciones();
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	if($nomina != "" && $personal != "" && $monto != "" && $moneda != "" && $tcambio != "" && $desc != ""){
		$cod = $ClsPlaAsi->max_bonificaciones_generales($nomina,$personal);
		$cod++;
		$sql.= $ClsPlaAsi->insert_bonificaciones_generales($nomina,$personal,$cod,$monto,$moneda,$tcambio,$desc);
      //$respuesta->alert("$sql");
      $rs = $ClsPlaAsi->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Bonificaci&oacute;n Asignadas Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}


function Quitar_Bonificacion_Regular($nomina,$personal,$codigo){
   $respuesta = new xajaxResponse();
   $ClsPlaAsi = new ClsPlanillaAsignaciones();
   if($nomina != "" && $personal != "" && $codigo != ""){
		$sql = $ClsPlaAsi->delete_bonificaciones_generales($nomina,$personal,$codigo);
      //$respuesta->alert("$sql");
      $rs = $ClsPlaAsi->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Bonificaci&oacute;n des-asignada del listado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   }   
   
   return $respuesta;
}


////////////////////////// BONOS EMERGENTES ////////////////////////

function Grabar_Bono_Emergente($nomina,$dpi,$monto,$moneda,$tcambio,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//-------- 
    if($nomina !="" && $dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$cod = $ClsPla->max_bonificaciones_emeregentes($nomina,$dpi);
		$cod++;
		$sql = $ClsPla->insert_bonificaciones_emeregentes($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Bono_Emergente($nomina,$cui,$codigo){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //$respuesta->alert("$cod");
   $result = $ClsPla->get_bonificaciones_emeregentes($nomina,$cui,$codigo);
   if(is_array($result)){
      if($cont==1){
         $result = $ClsPla->get_bonificaciones_emeregentes($nomina,$cui,$codigo);
         foreach($result as $row){
            $cod = $row["bon_codigo"];
            $respuesta->assign("cod","value",$cod);
            $monto = utf8_decode($row["bon_monto"]);
            $respuesta->assign("monto","value",$monto);
            $mon = utf8_decode($row["bon_moneda"]);
            $respuesta->assign("mon","value",$mon);
            $tcambio = utf8_decode($row["bon_tipo_cambio"]);
            $respuesta->assign("tcambio","value",$tcambio);
            $desc = utf8_decode($row["bon_descripcion"]);
            $respuesta->assign("desc","value",$desc);
         }
      }
      //abilita y desabilita botones
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Modificar_Bono_Emergente($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//-------- 
   if($nomina !="" && $cod !="" && $dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$sql = $ClsPla->update_bonificaciones_emeregentes($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
         $respuesta->assign("lblparrafo","innerHTML",$msj);
         $respuesta->script("document.getElementById('mod').disabled = false;");
         $respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      }	
	}else{
      $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      $msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
      $respuesta->assign("lblparrafo","innerHTML",$msj);
      $respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Bono_Emergente($nomina,$dpi,$cod){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();

	    //$respuesta->alert("$cod,$sit");
	    if($nomina != "" && $cod != "" && $dpi != ""){
			$sql = $ClsPla->delete_bonificaciones_emeregentes($nomina,$dpi,$cod);
			//$respuesta->alert("$sql");
			$rs = $ClsPla->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Bonificaci&oacute;n inhabilitado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
	    }

	return $respuesta;
}


////////////////////////// COMISIONES ////////////////////////

function Grabar_Comision($nomina,$dpi,$monto,$moneda,$tcambio,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//-------- 
    if($nomina !="" && $dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$cod = $ClsPla->max_comisiones($nomina,$dpi);
		$cod++;
		$sql = $ClsPla->insert_comisiones($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Comision($nomina,$cui,$codigo){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //$respuesta->alert("$cod");
	$result = $ClsPla->get_comisiones($nomina,$cui,$codigo);
	if(is_array($result)){
      foreach($result as $row){
         $cod = $row["com_codigo"];
         $respuesta->assign("cod","value",$cod);
         $monto = utf8_decode($row["com_monto"]);
         $respuesta->assign("monto","value",$monto);
         $mon = utf8_decode($row["com_moneda"]);
         $respuesta->assign("mon","value",$mon);
         $tcambio = utf8_decode($row["com_tipo_cambio"]);
         $respuesta->assign("tcambio","value",$tcambio);
         $desc = utf8_decode($row["com_descripcion"]);
         $respuesta->assign("desc","value",$desc);
      }
      //abilita y desabilita botones
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
	}	
   return $respuesta;
}


function Modificar_Comision($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//-------- 
   if($nomina !="" && $cod !="" && $dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$sql = $ClsPla->update_comisiones($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      }	
	}else{
      $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Comision($nomina,$dpi,$cod){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();

	    //$respuesta->alert("$cod,$sit");
	    if($nomina != "" && $cod != "" && $dpi != ""){
			$sql = $ClsPla->delete_comisiones($nomina,$dpi,$cod);
			//$respuesta->alert("$sql");
			$rs = $ClsPla->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Comisi&oacute;n inhabilitado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
	    }

	return $respuesta;
}



//////////////////---- DESCUENTOS REGULAR -----/////////////////////////////////////////////
function Grabar_Descuento_Regular($nomina,$personal,$monto,$moneda,$tcambio,$desc){
   $respuesta = new xajaxResponse();
   $ClsPlaAsi = new ClsPlanillaAsignaciones();
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	if($nomina != "" && $personal != "" && $monto != "" && $moneda != "" && $tcambio != "" && $desc != ""){
		$cod = $ClsPlaAsi->max_descuentos($nomina,$personal);
		$cod++;
		$sql.= $ClsPlaAsi->insert_descuentos($nomina,$personal,$cod,$monto,$moneda,$tcambio,$desc);
      //$respuesta->alert("$sql");
      $rs = $ClsPlaAsi->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Descuento asignado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}

////////////////////////// BONOS EMERGENTES ////////////////////////

function Grabar_Descuento_Emergente($nomina,$dpi,$monto,$moneda,$tcambio,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//-------- 
    if($nomina !="" && $dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$cod = $ClsPla->max_descuentos($nomina,$dpi);
		$cod++;
		$sql = $ClsPla->insert_descuentos($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Descuento_Emergente($nomina,$cui,$codigo){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //$respuesta->alert("$codigo");
   $result = $ClsPla->get_descuentos($nomina,$cui,$codigo);
   if(is_array($result)){
      foreach($result as $row){
         $cod = $row["des_codigo"];
         $respuesta->assign("cod","value",$cod);
         $monto = utf8_decode($row["des_monto"]);
         $respuesta->assign("monto","value",$monto);
         $mon = utf8_decode($row["des_moneda"]);
         $respuesta->assign("mon","value",$mon);
         $tcambio = utf8_decode($row["des_tipo_cambio"]);
         $respuesta->assign("tcambio","value",$tcambio);
         $desc = utf8_decode($row["des_descripcion"]);
         $respuesta->assign("desc","value",$desc);
      }
      //abilita y desabilita botones
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Modificar_Descuento_Emergente($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//-------- 
   if($nomina !="" && $cod !="" && $dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$sql = $ClsPla->update_descuentos($nomina,$dpi,$cod,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      }	
	}else{
      $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Descuento_Emergente($nomina,$dpi,$cod){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();

	    //$respuesta->alert("$cod,$sit");
	    if($nomina != "" && $cod != "" && $dpi != ""){
			$sql = $ClsPla->delete_descuentos($nomina,$dpi,$cod);
			//$respuesta->alert("$sql");
			$rs = $ClsPla->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Descuentos inhabilitado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
	    }

	return $respuesta;
}

//////////////////---- BONIFICACIONES REGULARES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Bonificacion_Regular");
$xajax->register(XAJAX_FUNCTION, "Quitar_Bonificacion_Regular");
//////////////////---- BONOS EMERGENTES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Bono_Emergente");
$xajax->register(XAJAX_FUNCTION, "Buscar_Bono_Emergente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Bono_Emergente");
$xajax->register(XAJAX_FUNCTION, "Situacion_Bono_Emergente");
//////////////////---- COMISIONES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Comision");
$xajax->register(XAJAX_FUNCTION, "Buscar_Comision");
$xajax->register(XAJAX_FUNCTION, "Modificar_Comision");
$xajax->register(XAJAX_FUNCTION, "Situacion_Comision");
//////////////////---- DESCUENTOS REGULARES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Descuento_Regular");
//////////////////---- DESCUENTOS EMERGENTES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Descuento_Emergente");
$xajax->register(XAJAX_FUNCTION, "Buscar_Descuento_Emergente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Descuento_Emergente");
$xajax->register(XAJAX_FUNCTION, "Situacion_Descuento_Emergente");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  