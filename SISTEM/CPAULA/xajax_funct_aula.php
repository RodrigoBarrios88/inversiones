<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_aula.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- SEDES -----/////////////////////////////////////////////
function depmun($dep,$idmun,$idsmun){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$dep,$idmun,$idsmun");
	$contenido = municipio_html($dep,$idmun); 
	$respuesta->assign($idsmun,"innerHTML",$contenido); 
	return $respuesta;
}


function Grabar_Sede($nom,$dir,$dep,$mun){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAul = new ClsAula();
    //pasa a mayusculas
		$nom = trim($nom);
      $dir = trim($dir);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
      $dir = utf8_encode($dir);
		//--
		$nom = utf8_decode($nom);
      $dir = utf8_decode($dir);
	//--------
	//$respuesta->alert("$dep,$nom");
	if($nom != "" && $dir != "" && $dep != "" && $mun != ""){
		$cod = $ClsAul->max_sede();
		$cod++;
		$sql = $ClsAul->insert_sede($cod,$nom,$dir,$dep,$mun);
		//$respuesta->alert("$sql");
		$rs = $ClsAul->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			$respuesta->script("document.getElementById('grab').className = 'btn btn-primary';");
		}
	}	

   return $respuesta;

}


function Buscar_Sede($cod){
   $respuesta = new xajaxResponse();
   $ClsAul = new ClsAula();
   $result = $ClsAul->get_sede($cod);
	if(is_array($result)){
		foreach($result as $row){
			$cod = $row["sed_codigo"];
			$respuesta->assign("cod","value",$cod);
			$nom = utf8_decode($row["sed_nombre"]);
			$respuesta->assign("nom","value",$nom);
			$dir = utf8_decode($row["sed_direccion"]);
			$respuesta->assign("dir","value",$dir);
			$dep = $row["sed_departamento"];
			$respuesta->assign("dep","value",$dep);
			$mun = $row["sed_municipio"];
		}
		$combomun = municipio_html($dep,'mun','');
		$respuesta->assign("divmun","innerHTML",$combomun);
		$respuesta->assign("mun","value",$mun);
		//abilita y desabilita botones
		$contenido = tabla_sedes($cod,"","","");
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
		$respuesta->script("cerrar();");
	}	

   return $respuesta;

}


function Modificar_Sede($cod,$nom,$dir,$dep,$mun){
   $respuesta = new xajaxResponse();
   $ClsAul = new ClsAula();

    //pasa a mayusculas
		$nom = trim($nom);
      $dir = trim($dir);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
      $dir = utf8_encode($dir);
		//--
		$nom = utf8_decode($nom);
		$dir = utf8_decode($dir);
	//--------
	//$respuesta->alert("$cod,$dia,$nom,$nom,$marca");
    if($cod != ""){
		if($nom != "" && $dir != "" && $dep != "" && $mun != ""){
			$sql = $ClsAul->modifica_sede($cod,$nom,$dir,$dep,$mun);
			//$respuesta->alert("$sql");
			$rs = $ClsAul->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		$respuesta->script("cerrar();");
	}
   		
   return $respuesta;
}


function Situacion_Sede($cod){
   $respuesta = new xajaxResponse();
   $ClsAul = new ClsAula();

    //$respuesta->alert("$diap,$dep");
    if($cod != ""){
		 $sql = $ClsAul->cambia_sit_sede($cod);
		 //$respuesta->alert("$sql");
		 $rs = $ClsAul->exec_sql($sql);
		 if($rs == 1){
			$respuesta->script('swal("Ok", "Sede desactivada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		 }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
    	 }
	}

	return $respuesta;
}


//////////////////---- AULAS O INSTALACIONES -----/////////////////////////////////////////////
function Grabar_Aula($sede,$tipo,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsAul = new ClsAula();
   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$tipo,$desc");
	if($desc != ""){
		$cod = $ClsAul->max_aula();
		$cod++;
		$sql = $ClsAul->insert_aula($cod,$sede,$tipo,$desc);
		//$respuesta->alert("$sql");
		$rs = $ClsAul->exec_sql($sql);

		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}	

   return $respuesta;

}


function Buscar_Aula($cod){
   $respuesta = new xajaxResponse();
   $ClsAul = new ClsAula();
   //$respuesta->alert("$cod");
	$cont = $ClsAul->count_aula($cod);
	//$respuesta->alert("$cont");
	if($cont>0){
		if($cont==1){
			$result = $ClsAul->get_aula($cod);
			foreach($result as $row){
				$cod = $row["aul_codigo"];
				$respuesta->assign("cod","value",$cod);
				$sede = $row["aul_sede"];
				$respuesta->assign("sede","value",$sede);
				$desc = utf8_decode($row["aul_descripcion"]);
				$respuesta->assign("desc","value",$desc);
				$tipo = $row["aul_tipo"];
				$respuesta->assign("tipo","value",$tipo);
			}
		}
		//abilita y desabilita botones
		$contenido = tabla_aulas($cod,$sede,$nom,$tipo);
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		$respuesta->script("document.getElementById('grab').className = 'btn btn-primary hidden';");
		$respuesta->script("cerrar();");
	}	

   return $respuesta;

}


function Modificar_Aula($cod,$sede,$tipo,$desc){
   $respuesta = new xajaxResponse();
   $ClsAul = new ClsAula();

   //pasa a mayusculas
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$cod,$dia,$desc,$desc,$marca");
    if($cod != ""){
		if($desc != ""){
			$sql = $ClsAul->modifica_aula($cod,$sede,$tipo,$desc);
			//$respuesta->alert("$sql");
			$rs = $ClsAul->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary hidden';");
	}
   		
   return $respuesta;
}


function Situacion_Aula($cod){
   $respuesta = new xajaxResponse();
   $ClsAul = new ClsAula();

    //$respuesta->alert("$diap,$tipo");
    if($cod != ""){
		 $sql = $ClsAul->cambia_sit_aula($cod);
		 //$respuesta->alert("$sql");
		 $rs = $ClsAul->exec_sql($sql);
		 if($rs == 1){
			$respuesta->script('swal("Ok", "Aula desactivada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		 }else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
    	 }
	}

	return $respuesta;
}

//////////////////---- SEDES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "depmun");
$xajax->register(XAJAX_FUNCTION, "Grabar_Sede");
$xajax->register(XAJAX_FUNCTION, "Buscar_Sede");
$xajax->register(XAJAX_FUNCTION, "Modificar_Sede");
$xajax->register(XAJAX_FUNCTION, "Situacion_Sede");
//////////////////---- AULAS O INSTALACIONES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Aula");
$xajax->register(XAJAX_FUNCTION, "Buscar_Aula");
$xajax->register(XAJAX_FUNCTION, "Modificar_Aula");
$xajax->register(XAJAX_FUNCTION, "Situacion_Aula");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  