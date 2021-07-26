<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_sueldos.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');


///////////// Grupos //////////////////////
function Lista_Grupo_Tipo_Nomina($maestro,$area){
   $respuesta = new xajaxResponse();
   $ClsAsi = new ClsAsignacion();
   //$respuesta->alert("$maestro,$area");
   if($maestro != ""){
      $result = $ClsAsi->get_maestro_grupo("",$maestro,1);
      if(is_array($result)){
		 $grupos = "";
		 foreach($result as $row){
			$grupos.= $row["gru_codigo"].",";
		 }
		 $grupos = substr($grupos, 0, strlen($grupos) - 1);
      }
      //$respuesta->alert("$grupos");
      /// Setea listas de puntos
      $contenido = grupos_no_maestro_lista_multiple("xasignar",$area,$grupos);
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      
      $contenido = grupos_maestro_lista_multiple("asignados",$maestro);
      $respuesta->assign("divasignados","innerHTML",$contenido);
      
      $respuesta->script("cerrar();");
   }else{
      $respuesta->script("cerrar();");
   }
   return $respuesta;
}


function Lista_Limpia(){
   $respuesta = new xajaxResponse();
	//$respuesta->alert("entro");
      $contenido = lista_multiple_vacia("xasignar"," Listado de Grupos, Materias y Secciones no asignadas");
      $respuesta->assign("divxasignar","innerHTML",$contenido);
      
      $contenido = lista_multiple_vacia("asignados"," Listado Grupos, Materias y Secciones asignadas");
      $respuesta->assign("divasignados","innerHTML",$contenido);
      
      $respuesta->script("cerrar();");
   return $respuesta;
}



//////////////////---- Otros Maestros -----/////////////////////////////////////////////
function Grabar_Tipo_Nomina($desc,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   //pasa a mayusculas
		$desc = trim($desc);
		$obs = trim($obs);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		$obs = utf8_encode($obs);
		//--
		$desc = utf8_decode($desc);
		$obs = utf8_decode($obs);
	//-------- 
    if($desc !="" && $obs != ""){
		//$respuesta->alert("$id");
		$cod = $ClsPla->max_tipo_nomina();
		$cod++;
		$sql = $ClsPla->insert_tipo_nomina($cod,$desc,$obs); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Tipo_Nomina($cod){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   //$respuesta->alert("$cod");
   $result = $ClsPla->get_tipo_nomina($cod);
   if(is_array($result)){
      foreach($result as $row){
         $cod = $row["tip_codigo"];
         $respuesta->assign("cod","value",$cod);
         $obs = utf8_decode($row["tip_observaciones"]);
         $respuesta->assign("obs","value",$obs);
         $desc = utf8_decode($row["tip_descripcion"]);
         $respuesta->assign("desc","value",$desc);
      }
      //abilita y desabilita botones
      $contenido = tabla_tipo_nomina($cod,'','');
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Modificar_Tipo_Nomina($cod,$desc,$obs){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   //pasa a mayusculas
		$desc = trim($desc);
		$obs = trim($obs);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		$obs = utf8_encode($obs);
		//--
		$desc = utf8_decode($desc);
		$obs = utf8_decode($obs);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cod != ""){
		if($desc !="" && $obs != ""){
			$sql = $ClsPla->modifica_tipo_nomina($cod,$desc,$obs);
			//$respuesta->alert("$sql");
			$rs = $ClsPla->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			   $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			}	
		}
	}else{
      $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Tipo_Nomina($cod,$sit){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   
   //$respuesta->alert("$cod,$sit");
   if($cod != ""){
      $sql = $ClsPla->cambia_sit_tipo_nomina($cod,$sit);
      //$respuesta->alert("$sql");
      $rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Ok", "Tipo de Nomina inhabilitado Satisfactoriamente...", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }	
   }

	return $respuesta;
}

/////////////////////// NOMINA ///////////////////////////

function Grabar_Nomina($tipo,$clase,$titulo,$desde,$hasta,$periodo,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   //pasa a mayusculas
		$clase = trim($clase);
		$titulo = trim($titulo);
		$obs = trim($obs);
	//--------
	//decodificaciones de tildes y Ñ's
		$clase = utf8_encode($clase);
		$titulo = utf8_encode($titulo);
		$obs = utf8_encode($obs);
		//--
		$clase = utf8_decode($clase);
		$titulo = utf8_decode($titulo);
		$obs = utf8_decode($obs);
	//-------- 
   if($tipo !="" && $clase != "" && $titulo != "" && $desde != "" && $hasta != "" && $periodo != "" && $obs != ""){
		//$respuesta->alert("$id");
		$cod = $ClsPla->max_nomina();
		$cod++;
		$sql = $ClsPla->insert_nomina($cod,$tipo,$clase,$titulo,$desde,$hasta,$periodo,$obs); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMstatusnomina.php"; });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Nomina($cod){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   //$respuesta->alert("$cod");
	$result = $ClsPla->get_nomina($cod,'','');
	if(is_array($result)){
      foreach($result as $row){
         $cod = $row["nom_codigo"];
         $respuesta->assign("cod","value",$cod);
         $titulo = utf8_decode($row["nom_titulo"]);
         $respuesta->assign("titulo","value",$titulo);
         $tipo = utf8_decode($row["nom_tipo"]);
         $respuesta->assign("tipo","value",$tipo);
         $clase = utf8_decode($row["nom_clase"]);
         $respuesta->assign("clase","value",$clase);
         $periodo = utf8_decode($row["nom_tipo_periodo"]);
         $respuesta->assign("periodo","value",$periodo);
         $obs = utf8_decode($row["nom_observaciones"]);
         $respuesta->assign("obs","value",$obs);
         //--
         $desde =  $row["nom_desde"];
         $desde = cambia_fecha($desde);
         $respuesta->assign("desde","value",$desde);
         $hasta = $row["nom_hasta"];
         $hasta = cambia_fecha($hasta);
         $respuesta->assign("hasta","value",$hasta);
      }
      //abilita y desabilita botones
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
	}	
   return $respuesta;
}


function Modificar_Nomina($cod,$tipo,$clase,$titulo,$desde,$hasta,$periodo,$obs){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   //pasa a mayusculas
		$clase = trim($clase);
		$titulo = trim($titulo);
		$obs = trim($obs);
	//--------
	//decodificaciones de tildes y Ñ's
		$clase = utf8_encode($clase);
		$titulo = utf8_encode($titulo);
		$obs = utf8_encode($obs);
		//--
		$clase = utf8_decode($clase);
		$titulo = utf8_decode($titulo);
		$obs = utf8_decode($obs);
	//-------- 
   if($tipo !="" && $clase != "" && $titulo != "" && $desde != "" && $hasta != "" && $periodo != "" && $obs != ""){
		//$respuesta->alert("$id");
		$sql = $ClsPla->modifica_nomina($cod,$tipo,$clase,$titulo,$desde,$hasta,$periodo,$obs); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Situacion_Nomina($cod,$sit){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
	    //$respuesta->alert("$cod,$sit");
	    if($cod != ""){
			$sql = $ClsPla->cambia_sit_nomina($cod,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsPla->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Cambio de Situaci\u00F3n realizado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
	    }

	return $respuesta;
}


////////////////////////// ASIGNACION DE PERSONAL Y TIPOS DE NOMINA ////////

function Graba_Personal_Tipo_Nomina($tipo,$personal,$filas){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   if($tipo != "" && $filas > 0){
		$sql = "";
		for($i = 0; $i < $filas; $i++){
			//////// ASIGNA AL PERSONAL EN UN LISTADO DE PLANILLA //////
			$sql.= $ClsPla->asignacion_personal_tipo_nomina($personal[$i],$tipo);
      }
		//$respuesta->alert("$sql");
      $rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Personal asignado satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
      }else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   }   
   
   return $respuesta;
}


function Quitar_Personal_Tipo_Nomina($tipo,$personal,$filas){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanilla();
   if($tipo != "" && $filas > 0){
      $sql = "";
      for($i = 0; $i < $filas; $i++){
		//////// REVISA SI TIENE ASIGNADAS SECCIONES EN ESAS MATERIAS //////
			$sql.= $ClsPla->desasignacion_personal_tipo_nomina($personal[$i],$tipo);
      }
      //$respuesta->alert("$sql");
      $rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
			$respuesta->script('swal("Excelente!", "Personal des-asignado satisfactoriamente", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   }   
   
   return $respuesta;
}


//////////////////---- CONFIGURACION DE BONOS REGULARES -----/////////////////////////////////////////////
function Grabar_Configuracion_Horas($persona,$cant_regulares,$monto_regulares,$cant_extras,$monto_extras,$moneda){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //pasa a mayusculas
		$cant_extras = ($cant_extras == "")?0:$cant_extras;
	//--------
	if($persona !="" && $cant_regulares !="" && $monto_regulares != "" && $monto_extras != "" && $moneda != ""){
		$sql = $ClsPla->insert_configuracion_horas($persona,$cant_regulares,$monto_regulares,$cant_extras,$monto_extras,$moneda); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}

////////////////////////// CONFIGURACION DE BONOS REGULARES ////////

function Grabar_Bono_Regular($dpi,$monto,$moneda,$tcambio,$desc){
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
    if($dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$cod = $ClsPla->max_base_bonificaciones($dpi);
		$cod++;
		$sql = $ClsPla->insert_base_bonificaciones($cod,$dpi,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Bono_Regular($codigo,$cui){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //$respuesta->alert("$cod");
   $result = $ClsPla->get_base_bonificaciones($codigo,$cui,1);
   if(is_array($result)){
      foreach($result as $row){
         $cod = $row["bas_codigo"];
         $respuesta->assign("cod","value",$cod);
         $monto = utf8_decode($row["bas_monto"]);
         $respuesta->assign("monto","value",$monto);
         $mon = utf8_decode($row["bas_moneda"]);
         $respuesta->assign("mon","value",$mon);
         $tcambio = utf8_decode($row["bas_tipo_cambio"]);
         $respuesta->assign("tcambio","value",$tcambio);
         $desc = utf8_decode($row["bas_descripcion"]);
         $respuesta->assign("desc","value",$desc);
      }
      //abilita y desabilita botones
      $contenido = tabla_tipo_nomina($cod,'','');
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
   }	
   return $respuesta;
}


function Modificar_Bono_Regular($cod,$dpi,$monto,$moneda,$tcambio,$desc){
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
   if($cod !="" && $dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$sql = $ClsPla->update_base_bonificaciones($cod,$dpi,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
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


function Situacion_Bono_Regular($cod,$cui){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();

   //$respuesta->alert("$cod,$sit");
   if($cod != "" && $cui != ""){
      $sql = $ClsPla->cambia_sit_base_bonificaciones($cod,$cui);
      //$respuesta->alert("$sql");
      $rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Ok", "Bonificaci\u00F3n inhabilitado Satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }	
   }

	return $respuesta;
}


////////////////////////// CONFIGURACION DE DESCUENTOS REGULARES ////////

function Grabar_Descuento_Regular($dpi,$monto,$moneda,$tcambio,$desc){
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
    if($dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$cod = $ClsPla->max_base_descuentos($dpi);
		$cod++;
		$sql = $ClsPla->insert_base_descuentos($cod,$dpi,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
		}
	}
   
   return $respuesta;
}


function Buscar_Descuento_Regular($codigo,$cui){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();
   //$respuesta->alert("$cod");
		$result = $ClsPla->get_base_descuentos($codigo,$cui,1);
		if(is_array($result)){
      foreach($result as $row){
         $cod = $row["bas_codigo"];
         $respuesta->assign("cod","value",$cod);
         $monto = utf8_decode($row["bas_monto"]);
         $respuesta->assign("monto","value",$monto);
         $mon = utf8_decode($row["bas_moneda"]);
         $respuesta->assign("mon","value",$mon);
         $tcambio = utf8_decode($row["bas_tipo_cambio"]);
         $respuesta->assign("tcambio","value",$tcambio);
         $desc = utf8_decode($row["bas_descripcion"]);
         $respuesta->assign("desc","value",$desc);
      }
      //abilita y desabilita botones
      $contenido = tabla_tipo_nomina($cod,'','');
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("cerrar();");
	}	
   return $respuesta;
}


function Modificar_Descuento_Regular($cod,$dpi,$monto,$moneda,$tcambio,$desc){
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
   if($cod !="" && $dpi !="" && $desc !="" && $monto != "" && $moneda != "" && $tcambio != ""){
		//$respuesta->alert("$id");
		$sql = $ClsPla->update_base_descuentos($cod,$dpi,$monto,$moneda,$tcambio,$desc); /// Inserta
		//$respuesta->alert("$sql");
		$rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Registros actulizados satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
         $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
         $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      }	
	}else{
      $msj = '<h5>Error de Traslaci\u00F3n..., refresque la pagina e intente de nuevo</h5><br><br>';
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Descuento_Regular($cod,$cui){
   $respuesta = new xajaxResponse();
   $ClsPla = new ClsPlanillaAsignaciones();

   //$respuesta->alert("$cod,$sit");
   if($cod != "" && $cui != ""){
      $sql = $ClsPla->cambia_sit_base_descuentos($cod,$cui);
      //$respuesta->alert("$sql");
      $rs = $ClsPla->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Ok", "Descuento inhabilitado satisfactoriamente!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
      }	
   }

	return $respuesta;
}

//////////////////---- Horas Laboradas -----/////////////////////////////////////////////
function Graba_Horas_Laboradas($nomina,$personal,$cant_regulares,$monto_regulares,$cant_extras,$monto_extras,$moneda,$tcambio){
   $respuesta = new xajaxResponse();
   $ClsPlaAsi = new ClsPlanillaAsignaciones();
   if($nomina != "" && $personal != "" && $moneda != ""){
		$sql.= $ClsPlaAsi->insert_horas_laboradas($nomina,$personal,$cant_regulares,$monto_regulares,$cant_extras,$monto_extras,$moneda,$tcambio);
      //$respuesta->alert("$sql");
      $rs = $ClsPlaAsi->exec_sql($sql);
      if($rs == 1){
         $respuesta->script('swal("Excelente!", "Horas registradas satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
      }else{
         $respuesta->assign("spancheck$fila","innerHTML","");
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   }   
   
   return $respuesta;
}


function Quitar_Horas_Laboradas($nomina,$personal){
   $respuesta = new xajaxResponse();
   $ClsPlaAsi = new ClsPlanillaAsignaciones();
   if($nomina != "" && $personal != ""){
		$sql = $ClsPlaAsi->delete_horas_laboradas($nomina,$personal);
      //$respuesta->alert("$sql");
      $rs = $ClsPlaAsi->exec_sql($sql);
      if($rs == 1){
			$respuesta->script("window.location.reload();");
      }else{
			$respuesta->script('swal("Error", "Error de transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   }   
   
   return $respuesta;
}



//////////////////---- TIPO DE NOMINAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Tipo_Nomina");
$xajax->register(XAJAX_FUNCTION, "Buscar_Tipo_Nomina");
$xajax->register(XAJAX_FUNCTION, "Modificar_Tipo_Nomina");
$xajax->register(XAJAX_FUNCTION, "Situacion_Tipo_Nomina");
//////////////////---- TIPO DE NOMINAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Nomina");
$xajax->register(XAJAX_FUNCTION, "Buscar_Nomina");
$xajax->register(XAJAX_FUNCTION, "Modificar_Nomina");
$xajax->register(XAJAX_FUNCTION, "Situacion_Nomina");
////////////////////////// ASIGNACION DE TIPO DE NOMINAS Y PERSONAL ////////
$xajax->register(XAJAX_FUNCTION, "Graba_Personal_Tipo_Nomina");
$xajax->register(XAJAX_FUNCTION, "Quitar_Personal_Tipo_Nomina");
//////////////////---- CONFIGURACION DE BONOS REGULARES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Configuracion_Horas");
//////////////////---- CONFIGURACION DE BONOS REGULARES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Bono_Regular");
$xajax->register(XAJAX_FUNCTION, "Buscar_Bono_Regular");
$xajax->register(XAJAX_FUNCTION, "Modificar_Bono_Regular");
$xajax->register(XAJAX_FUNCTION, "Situacion_Bono_Regular");
//////////////////---- CONFIGURACION DE DESCUENTOS REGULARES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Descuento_Regular");
$xajax->register(XAJAX_FUNCTION, "Buscar_Descuento_Regular");
$xajax->register(XAJAX_FUNCTION, "Modificar_Descuento_Regular");
$xajax->register(XAJAX_FUNCTION, "Situacion_Descuento_Regular");
//////////////////---- HORAS LABORADAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Graba_Horas_Laboradas");
$xajax->register(XAJAX_FUNCTION, "Quitar_Horas_Laboradas");
$xajax->register(XAJAX_FUNCTION, "Graba_Horas_Extras");
$xajax->register(XAJAX_FUNCTION, "Quitar_Horas_Extras");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  