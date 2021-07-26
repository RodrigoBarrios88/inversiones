<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_contabilidad.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Partida - Reglon /////////
function Combo_Partida($tipo){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
	$contenido = partida_html($tipo,'',"par",'');
	//$respuesta->alert("$contenido");
	$respuesta->assign("spar","innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- PARTIDAS -----/////////////////////////////////////////////
function Grabar_Partida($id,$desc,$tipo,$clase){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
	 //pasa a mayusculas
		$desc = trim($desc);
		$tipo = trim($tipo);
		$clase = trim($clase);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		$tipo = utf8_encode($tipo);
		//--
		$desc = utf8_decode($desc);
		$tipo = utf8_decode($tipo);
	//--------
   if($desc != "" && $tipo != "" && $clase != ""){
		if($id == ""){ // nueva
			$id = $ClsPar->max_partida();
			$id++; /// Maximo codigo de Empresa
		}
		//$respuesta->alert("$id");
		$sql = $ClsPar->insert_partida($id,$tipo,$clase,$desc); /// Inserta Partida
		//$respuesta->alert("$sql");
		$rs = $ClsPar->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}

function Buscar_Partida($cod){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
   //$respuesta->alert("$cod");
	$cont = $ClsPar->count_partida($cod);
	if($cont>0){
		if($cont==1){
			$result = $ClsPar->get_partida($cod);
			foreach($result as $row){
				$cod = $row["par_codigo"];
				$respuesta->assign("cod","value",$cod);
				$desc = utf8_decode($row["par_descripcion"]);
				$respuesta->assign("nom","value",$desc);
				$tipo = utf8_decode($row["par_tipo"]);
				$respuesta->assign("tipo","value",$tipo);
				$clase = $row["par_clase"];
				//--
				$sit = $row["par_situacion"];
				$respuesta->assign("sit","value",$sit);
			}
		}
		//abilita y desabilita botones
		$combo = clase_partida_html($tipo,'','clase','');
		$respuesta->assign("sclase","innerHTML",$combo);
		$respuesta->assign("clase","value",$clase);
		//--
		$contenido = tabla_partidas($cod,'','','','');
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar()");
	}	
   return $respuesta;
}

function Situacion_Partida($cod,$sit){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();

    //$respuesta->alert("$cod,$sit");
    if($cod != ""){
		if($sit == 0){
			$activo = $ClsPar->comprueba_sit_partida($cod);
			if(!$activo){
				$sql = $ClsPar->cambia_sit_partida($cod,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsPar->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				}	
			}else{
				$respuesta->script('swal("Atenci\u00F3n", "Esta Partida tiene Reglones en situaci\u00F3n activa, desactivelos primero antes de esta acci\u00F3nn...", "warning").then((value)=>{ cerrar(); });');
			}
		}else if($sit == 1){
			$sql = $ClsPar->cambia_sit_partida($cod,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPar->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Partida Activada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}

	return $respuesta;
}


//////////////////---- CLASIFICACION -----/////////////////////////////////////////////
function Grabar_Clase($id,$desc,$tipo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
	 //pasa a mayusculas
		$desc = trim($desc);
		$tipo = trim($tipo);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		$tipo = utf8_encode($tipo);
		//--
		$desc = utf8_decode($desc);
		$tipo = utf8_decode($tipo);
	//--------
   if($desc != "" && $tipo != ""){
		if($id == ""){ // nueva
			$id = $ClsPar->max_clase();
			$id++; /// Maximo codigo de Empresa
		}
		//$respuesta->alert("$id");
		$sql = $ClsPar->insert_clase($id,$tipo,$desc); /// Inserta Clase
		//$respuesta->alert("$sql");
		$rs = $ClsPar->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}

function Buscar_Clase($cod){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
   //$respuesta->alert("$cod");
	$cont = $ClsPar->count_clase($cod);
	if($cont>0){
		if($cont==1){
			$result = $ClsPar->get_clase($cod);
			foreach($result as $row){
				$cod = $row["cla_codigo"];
				$respuesta->assign("cod","value",$cod);
				$desc = utf8_decode($row["cla_descripcion"]);
				$respuesta->assign("nom","value",$desc);
				$tipo = trim($row["cla_tipo"]);
				$respuesta->assign("tipo","value",$tipo);
				//--
				$sit = $row["cla_situacion"];
				$respuesta->assign("sit","value",$sit);
			}
		}
		//--
		$contenido = tabla_clases($cod,'','','','');
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar()");
	}	
   return $respuesta;
}

function Situacion_Clase($cod,$sit){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();

    //$respuesta->alert("$cod,$sit");
    if($cod != ""){
		if($sit == 0){
			$sql = $ClsPar->cambia_sit_clase($cod,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPar->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}else if($sit == 1){
			$sql = $ClsPar->cambia_sit_clase($cod,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPar->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Clase Activada Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}

	return $respuesta;
}


//////////////////---- REGLONES -----/////////////////////////////////////////////
function Grabar_Reglon($id,$par,$dct,$dlg){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
	 //pasa a mayusculas
		$dct = trim($dct);
		$dlg = trim($dlg);
	//--------
	//decodificaciones de tildes y Ñ's
		$dct = utf8_encode($dct);
		$dlg = utf8_encode($dlg);
		//--
		$dct = utf8_decode($dct);
		$dlg = utf8_decode($dlg);
	//--------
   
   if($par != "" && $dct != "" && $dlg != ""){
		if($id == ""){ // nueva
			$id = $ClsPar->max_reglon($par);
			$id++; /// Maximo codigo de Empresa
		}
		//$respuesta->alert("$id");
		$sql = $ClsPar->insert_reglon($id,$par,$dct,$dlg); /// Inserta reglon
		//$respuesta->alert("$sql");
		$rs = $ClsPar->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}


function Buscar_Reglon($cod,$par){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
   //$respuesta->alert("$cod,$par");
		$cont = $ClsPar->count_reglon($cod,$par);
		if($cont>0){
			if($cont==1){
				$result = $ClsPar->get_reglon($cod,$par);
				foreach($result as $row){
					$cod = $row["reg_codigo"];
					$respuesta->assign("cod","value",$cod);
					$dct = $row["reg_desc_ct"];
					$respuesta->assign("dct","value",$dct);
					$dlg = $row["reg_desc_lg"];
					$respuesta->assign("dlg","value",$dlg);
					$tipo = $row["par_tipo"];
					$respuesta->assign("tipo","value",$tipo);
					$par = $row["par_codigo"];
					$sit = $row["reg_situacion"];
					$respuesta->assign("sit","value",$sit);
				}
				$contenido = partida_html($tipo,'',"par",'Submit();');
				$respuesta->assign("spar","innerHTML",$contenido);
				$respuesta->assign("par","value",$par);
			}
			//abilita y desabilita botones
			$contenido = tabla_reglones($cod,$par,'','','');
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
	   }	
   return $respuesta;
}

function Situacion_Reglon($cod,$par,$sit){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();

    //$respuesta->alert("$cod,$par,$sit");
    if($cod != ""){
		if($sit == 0){
			$sql = $ClsPar->cambia_sit_reglon($cod,$par,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPar->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros desactivado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}else if($sit == 1){
			$sql = $ClsPar->cambia_sit_reglon($cod,$par,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPar->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Reglon Activado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}

	return $respuesta;
}


//////////////////---- SUBREGLONES -----/////////////////////////////////////////////
function Grabar_Subreglon($id,$partida,$reglon,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
	 //pasa a mayusculas
		$reglon = trim($reglon);
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$reglon = utf8_encode($reglon);
		$desc = utf8_encode($desc);
		//--
		$reglon = utf8_decode($reglon);
		$desc = utf8_decode($desc);
	//--------
   
   if($partida != "" && $reglon != "" && $desc != ""){
		if($id == ""){ // nueva
			$id = $ClsPar->max_subreglon($partida,$reglon);
			$id++; /// Maximo codigo de Empresa
		}
		//$respuesta->alert("$id");
		$sql = $ClsPar->insert_subreglon($id,$partida,$reglon,$desc); /// Inserta subreglon
		//$respuesta->alert("$sql");
		$rs = $ClsPar->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
   }
   
   return $respuesta;
}


function Buscar_Subreglon($cod,$partida,$reglon){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();
   //$respuesta->alert("$cod,$partida,$reglon");
		$cont = $ClsPar->count_subreglon($cod,$partida,$reglon);
		if($cont>0){
			if($cont==1){
				$result = $ClsPar->get_subreglon($cod,$partida,$reglon);
				foreach($result as $row){
					$cod = $row["sub_codigo"];
					$respuesta->assign("cod","value",$cod);
					$reglon = $row["sub_reglon"];
					$respuesta->assign("reglon","value",$reglon);
					$desc = $row["sub_descripcion"];
					$respuesta->assign("desc","value",$desc);
					$tipo = $row["par_tipo"];
					$respuesta->assign("tipo","value",$tipo);
					$partida = $row["sub_partida"];
               $reglon = $row["sub_reglon"];
					$sit = $row["sub_situacion"];
					$respuesta->assign("sit","value",$sit);
				}
				$contenido = partida_html($tipo,'',"par",'Submit();');
				$respuesta->assign("spar","innerHTML",$contenido);
				$respuesta->assign("par","value",$partida);
            //--
            $contenido = reglon_html($partida,"reglon",'Submit();');
				$respuesta->assign("sreg","innerHTML",$contenido);
				$respuesta->assign("reglon","value",$reglon);
			}
			//abilita y desabilita botones
			$contenido = tabla_subreglones($cod,$partida,$reglon,'','');
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
	   }	
   return $respuesta;
}


function Situacion_Subreglon($cod,$partida,$reglon,$sit){
   $respuesta = new xajaxResponse();
   $ClsPar = new ClsPartida();

   //$respuesta->alert("$cod,$par,$sit");
   if($cod != ""){
		if($sit == 0){
			$sql = $ClsPar->cambia_sit_subreglon($cod,$partida,$reglon,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPar->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros desactivado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}else if($sit == 1){
			$sql = $ClsPar->cambia_sit_subreglon($cod,$partida,$reglon,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPar->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Subreglon Activado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}

	return $respuesta;
}

///////////////////---- ///////////// Partida - Reglon /////////////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Partida");
//////////////////---- PARTIDAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Partida");
$xajax->register(XAJAX_FUNCTION, "Buscar_Partida");
$xajax->register(XAJAX_FUNCTION, "Situacion_Partida");
//////////////////---- CLASIFICACION -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Clase");
$xajax->register(XAJAX_FUNCTION, "Buscar_Clase");
$xajax->register(XAJAX_FUNCTION, "Situacion_Clase");
//////////////////---- REGLONES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Reglon");
$xajax->register(XAJAX_FUNCTION, "Buscar_Reglon");
$xajax->register(XAJAX_FUNCTION, "Situacion_Reglon");
//////////////////---- SUBREGLONES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Subreglon");
$xajax->register(XAJAX_FUNCTION, "Buscar_Subreglon");
$xajax->register(XAJAX_FUNCTION, "Situacion_Subreglon");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  