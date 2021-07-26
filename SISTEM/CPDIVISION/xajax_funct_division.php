<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_division.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Combo Grupo Division /////////
function GrupoDivision($grupo,$id,$sdiv,$acc){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$grupo,$id,$sdiv,$acc");
	$contenido = division_html($grupo,$id,$acc);
	$respuesta->assign($sdiv,"innerHTML",$contenido);
	
	return $respuesta;
}


//////////////////---- BANCOS -----/////////////////////////////////////////////
function Grabar_Grupo($nombre){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsDiv = new ClsDivision();
   //pasa a mayusculas
		$nombre = trim($nombre);
	//--------
	//decodificaciones de tildes y Ñ's
		$nombre = utf8_encode($nombre);
		//--
		$nombre = utf8_decode($nombre);
	//--------
	if($nombre != ""){
		$codigo = $ClsDiv->max_grupo();
		$codigo++;
		$sql = $ClsDiv->insert_grupo($codigo,$nombre);
		$rs = $ClsDiv->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}else{
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		$respuesta->script("swal('Error', 'Error en la transacci\u00F3n, refresque la pagina e intente de nuevo', 'error').then((value)=>{ cerrar(); });");
	}
   return $respuesta;
}


function Buscar_Grupo($codigo){
   $respuesta = new xajaxResponse();
   $ClsDiv = new ClsDivision();

   //$respuesta->alert("$codigo");
	$result = $ClsDiv->get_grupo($codigo);
	if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["gru_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $nombre = utf8_decode($row["gru_nombre"]);
         $respuesta->assign("nombre","value",$nombre);
      }
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
		//abilita y desabilita botones
		$contenido = tabla_grupos($codigo,$nombre);
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar();");
	}	
   return $respuesta;
}

function Modificar_Grupo($codigo,$nombre){
   $respuesta = new xajaxResponse();
   $ClsDiv = new ClsDivision();

   //pasa a mayusculas
		$nombre = trim($nombre);
	//--------
	//decodificaciones de tildes y Ñ's
		$nombre = utf8_encode($nombre);
		//--
		$nombre = utf8_decode($nombre);
	//--------
	//$respuesta->alert("$codigo,$dct,$dlg,$pai");
   if($codigo != ""){
		if($nombre != ""){
			$sql = $ClsDiv->modifica_grupo($codigo,$nombre);
			//$respuesta->alert("$sql");
			$rs = $ClsDiv->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}else{
         $respuesta->script("swal('Error', 'Debe llenar los campos obligatorios...', 'error').then((value)=>{ cerrar(); });");
      }
	}else{
		$respuesta->script("document.getElementById('mod').disabled = true;");
		$respuesta->script("swal('Error', 'Error en la transacci\u00F3n, refresque la pagina e intente de nuevo', 'error').then((value)=>{ cerrar(); });");
	}
   		
   return $respuesta;
}


function Situacion_Grupo($codigo,$situacion){
   $respuesta = new xajaxResponse();
   $ClsDiv = new ClsDivision();

    //$respuesta->alert("$grupo,$sit");
    if($codigo != ""){
		if($situacion == 0){
			$activo = $ClsDiv->comprueba_situacion_divisiones($codigo);
			if(!$activo){
				$sql = $ClsDiv->cambia_situacion_grupo($codigo,$situacion);
				//$respuesta->alert("$sql");
				$rs = $ClsDiv->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Excelente!", "Grupo desactivado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				}	
			}else{
				$respuesta->script('swal("", "Este Grupo tiene Divisiones en situaci\u00F3n activa, desactivelas primero antes de esta acci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}
		}else if($situacion == 1){
			$sql = $ClsDiv->cambia_situacion_grupo($codigo,$situacion);
			//$respuesta->alert("$sql");
			$rs = $ClsDiv->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Grupo activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}

	return $respuesta;
}


//////////////////---- CUENTAS DE BANCO -----/////////////////////////////////////////////
function Grabar_Division($grupo,$nombre,$empresa,$moneda){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsDiv = new ClsDivision();
    //pasa a mayusculas
		$nombre = trim($nombre);
		$empresa = trim($empresa);
		$moneda = trim($moneda);
	//--------
	//decodificaciones de tildes y Ñ's
		$nombre = utf8_encode($nombre);
		//--
		$nombre = utf8_decode($nombre);
	//--------
	//$respuesta->alert("$grupo,$nombre,$empresa,$moneda");
	if($grupo != "" && $nombre != "" && $empresa != "" && $moneda != ""){
		$codigo = $ClsDiv->max_division($grupo);
		$codigo++;
		$sql = $ClsDiv->insert_division($codigo,$grupo,$nombre,$empresa,$moneda);
		//$respuesta->alert("$sql");
		$rs = $ClsDiv->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}else{
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
		$respuesta->script("swal('Error', 'Error en la transacci\u00F3n, refresque la pagina e intente de nuevo', 'error').then((value)=>{ cerrar(); });");
	}
   return $respuesta;
}


function Buscar_Division($codigo,$grupo){
   $respuesta = new xajaxResponse();
   $ClsDiv = new ClsDivision();

	$result = $ClsDiv->get_division($codigo,$grupo);
	if(is_array($result)){
      foreach($result as $row){
         $codigo = $row["div_codigo"];
         $respuesta->assign("codigo","value",$codigo);
         $grupo = $row["div_grupo"];
         $respuesta->assign("grupo","value",$grupo);
         $empresa = trim($row["div_empresa"]);
         $respuesta->assign("empresa","value",$empresa);
         $nombre = utf8_decode($row["div_nombre"]);
         $respuesta->assign("nombre","value",$nombre);
         $moneda = trim($row["div_moneda"]);
         $respuesta->assign("moneda","value",$moneda);
      }
      $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
      $respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
      $respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
      $respuesta->script("document.getElementById('grupo').disabled = true;");
      //abilita y desabilita botones
      $contenido = tabla_division($codigo,$grupo,$nombre);
      $respuesta->assign("result","innerHTML",$contenido);
      $respuesta->script("cerrar();");
	}
   return $respuesta;
}



function Modificar_Division($codigo,$grupo,$nombre,$empresa,$moneda){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsDiv = new ClsDivision();
   $ClsDiv = new ClsDivision();
	//pasa a mayusculas
		$nombre = trim($nombre);
		$empresa = trim($empresa);
		$moneda = trim($moneda);
	//--------
	//decodificaciones de tildes y Ñ's
		$nombre = utf8_encode($nombre);
		//--
		$nombre = utf8_decode($nombre);
	//--------
	//$respuesta->alert("$codigo,$grupo,$nombre,$empresa,$moneda");
	if($codigo != "" && $grupo != "" && $nombre != "" && $empresa != "" && $moneda != ""){
		//Query
		$sql = $ClsDiv->modifica_division($codigo,$grupo,$nombre,$empresa,$moneda);
		$rs = $ClsDiv->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}else{
      $respuesta->script("document.getElementById('mod').disabled = true;");
		$respuesta->script("swal('Error', 'Error en la transacci\u00F3n, refresque la pagina e intente de nuevo', 'error').then((value)=>{ cerrar(); });");	
	}
   return $respuesta;
}


function Situacion_Division($codigo,$grupo,$situacion){
   $respuesta = new xajaxResponse();
   $ClsDiv = new ClsDivision();

    //$respuesta->alert("$codigo,$grupo,$situacion");
    if($codigo != "" && $grupo != ""){
		if($situacion == 0){
			$sql = $ClsDiv->cambia_situacion_division($codigo,$grupo,$situacion);
         //$respuesta->alert("$sql");
         $rs = $ClsDiv->exec_sql($sql);
         if($rs == 1){
            $respuesta->script('swal("Excelente!", "Division desactivada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
         }else{
            $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
         }	
		}else if($situacion == 1){
			$sql = $ClsDiv->cambia_situacion_division($codigo,$grupo,$situacion);
			//$respuesta->alert("$sql");
			$rs = $ClsDiv->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros re-activada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}

	return $respuesta;
}

//////////////////---- Utilitarias -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "GrupoDivision");
//////////////////---- Grupos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Grupo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Grupo");
$xajax->register(XAJAX_FUNCTION, "Modificar_Grupo");
$xajax->register(XAJAX_FUNCTION, "Situacion_Grupo");
//////////////////---- Divisiones -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Division");
$xajax->register(XAJAX_FUNCTION, "Buscar_Division");
$xajax->register(XAJAX_FUNCTION, "Modificar_Division");
$xajax->register(XAJAX_FUNCTION, "Situacion_Division");


//El objeto xajax tiene que procesar cualquier petici\u00F3n
$xajax->processRequest();

?>  