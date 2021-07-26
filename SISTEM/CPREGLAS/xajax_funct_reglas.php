<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_reglas.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

//////////////////---- DEPMUN -----/////////////////////////////////////////////
function depmun($dep,$idmun,$idsmun){
   $respuesta = new xajaxResponse();
  // $respuesta->alert("$dep,$idmun,$idsmun");
	$contenido = municipio_html($dep,$idmun);
	$respuesta->assign($idsmun,"innerHTML",$contenido);
	
	return $respuesta;
}

////////////////////////// Configuracion de Credenciales //////////////////////
function Modificar_Credenciales($nombre,$rotulo,$rotulo_sub,$nombre_reporte,$direccion1,$direccion2,$departamento,$municipio,$telefono,$correo,$website,$nivel,$ciclo,$modalidad,$jornada,$sector,$area){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsReg = new ClsRegla();
  	//$respuesta->alert("$nombre,$rotulo,$nombre_reporte,$direccion1,$direccion2,$departamento,$municipio,$telefono,$correo,$website,$nivel,$ciclo,$modalidad,$jornada,$sector,$area");
   $sql = $ClsReg->update_credenciales($nombre,$rotulo,$rotulo_sub,$nombre_reporte,$direccion1,$direccion2,$departamento,$municipio,$telefono,$correo,$website,$nivel,$ciclo,$modalidad,$jornada,$sector,$area);
   $rs = $ClsReg->exec_sql($sql);
   //$respuesta->alert("$sql");
   if($rs == 1){
      /// SETEA VARIABLES DE SESION
      $_SESSION["nombre_colegio"] = $nombre;
      $_SESSION["rotulos_colegio"] = $rotulo;
      $_SESSION["colegio_nombre_reporte"] = $nombre_reporte;
      $_SESSION["colegio_direccion"] = $direccion1." ".$direccion2;
      $_SESSION["colegio_departamento"] = $departamento;
      $_SESSION["colegio_municipio"] = $municipio;
      $_SESSION["mineduc_nivel"] = $nivel;
      $_SESSION["mineduc_cliclo"] = $ciclo;
      $_SESSION["mineduc_modalidad"] = $modalidad;
      $_SESSION["mineduc_jornada"] = $jornada;
      $_SESSION["mineduc_sector"] = $sector;
      $_SESSION["mineduc_area"] = $area;
      //
      $respuesta->script('swal("Excelente!", "Configuraci\u00F3n actualizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
   }else{
      $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
   }	

   return $respuesta;
}

////////////////////////// Configuraci\u00F3n del Sistema //////////////////////
function Modificar_Reglas($mail,$pais,$dep,$mun,$regimen,$iva,$mon,$fac,$serie,$margen,$minimo,$desc,$carg,$igssemp,$igsspat,$irtra,$intecap){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsReg = new ClsRegla();
   if($mail != ""){
		//$respuesta->alert("$mail,$pais,$dep,$mun,$regimen,$iva,$mon,$fac,$serie,$margen,$desc,$carg,$igssemp,$igsspat,$irtra,$intecap");
		$sql = $ClsReg->update_reglas($mail,$mon,$pais,$dep,$mun,$regimen,$iva,0,$fac,$serie,$margen,$minimo,$desc,$carg,$igssemp,$igsspat,$irtra,$intecap);
		$rs = $ClsReg->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			/// SETEA VARIABLES DE SESION
			$_SESSION['mailadmin'] = $mail;
			$_SESSION['moneda'] = $mon;
			$_SESSION['pais'] = $pais;
			$_SESSION['departamento'] = $dep;
			$_SESSION['municipio'] = $mun;
			$_SESSION['regimen'] = $regimen;
			$_SESSION['iva'] = $iva;
			$_SESSION['isr'] = 0;
			$_SESSION['facturar'] = $fac;
			$_SESSION['seriexdefecto'] = $serie;
			$_SESSION['margenutil'] = $margen;
			$_SESSION['minimoproducto'] = $minimo;
			$_SESSION['descargarinv'] = $desc;
			$_SESSION['cargarinv'] = $carg;
			$_SESSION['igss_empleado'] = $igssemp;
			$_SESSION['igss_patrono'] = $igsspat;
			$_SESSION['irtra'] = $irtra;
			$_SESSION['intecap'] = $intecap;
			//
			$respuesta->script('swal("Excelente!", "Configuraci\u00F3n actualizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	
   return $respuesta;
}


function Modificar_Regla_Seguridad($cont){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
    if($cont != ""){
		///- Setea dias para el cambio de fecha///
		$archivo = fopen("../recursos/seguridad.txt", "w");
		$texto = "--Intentos permitidos para cambio de Contreseña: $cont";
		fwrite($archivo, $texto);
		///------Mensaje
		$respuesta->script('swal("Excelente!", "Configuraci\u00F3n actualizada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	
   return $respuesta;
}


///////////////////////// MONEDA ///////////////////////////////////////////
function Grabar_Moneda($desc,$simbolo,$pais,$cambio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMon = new ClsMoneda();
	//----
		$desc = trim($desc);
		$simbolo = trim($simbolo);
		$pais = trim($pais);
	//----
		$desc = utf8_encode($desc);
		$simbolo = utf8_encode($simbolo);
		$pais = utf8_encode($pais);
		//--
		$desc = utf8_decode($desc);
		$simbolo = utf8_decode($simbolo);
		$pais = utf8_decode($pais);
	//____
    if($desc != "" && $simbolo != "" && $pais != "" && $cambio != ""){
		$cod = $ClsMon->max_moneda();
		$cod++;
		$sql = $ClsMon->insert_moneda($cod,$desc,$simbolo,$pais,$cambio);
		$sql.= $ClsMon->insert_his_cambio($cod,$cambio);
		$rs = $ClsMon->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Nueva moneda agregada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}



function Buscar_Moneda($cod){
   $respuesta = new xajaxResponse();
   $ClsMon = new ClsMoneda();
   //$respuesta->alert("$cod");
	$result = $ClsMon->get_moneda($cod);
	if(is_array($result)){
		foreach($result as $row){
			$cod = $row["mon_id"];
			$respuesta->assign("cod1","value",$cod);
			$desc = utf8_decode($row["mon_desc"]);
			$respuesta->assign("desc1","value",$desc);
			$simbolo = utf8_decode($row["mon_simbolo"]);
			$respuesta->assign("simb1","value",$simbolo);
			$pais = utf8_decode($row["mon_pais"]);
			$respuesta->assign("pais1","value",$pais);
			$cambio = utf8_decode($row["mon_cambio"]);
			$respuesta->assign("cambio1","value",$cambio);
		}
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
		//---
		$respuesta->script("document.getElementById('cambio1').setAttribute('disabled','disabled');");
	}	
   return $respuesta;
}



function Modificar_Moneda($cod,$desc,$simbolo,$pais,$cambio){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMon = new ClsMoneda();
	//----
		$desc = trim($desc);
		$simbolo = trim($simbolo);
		$pais = trim($pais);
	//----
		$desc = utf8_encode($desc);
		$simbolo = utf8_encode($simbolo);
		$pais = utf8_encode($pais);
		//--
		$desc = utf8_decode($desc);
		$simbolo = utf8_decode($simbolo);
		$pais = utf8_decode($pais);
	//____
   if($cod != "" && $desc != "" && $simbolo != "" && $pais != "" && $cambio != ""){
		$sql = $ClsMon->update_moneda($cod,$desc,$simbolo,$pais);
		$rs = $ClsMon->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Datos de la moneda modificados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}


function Cambia_Sit_Moneda($mon,$pagina){
  //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMon = new ClsMoneda();
   if($mon != ""){
		$sql = $ClsMon->cambia_sit_moneda($mon,0);
		$rs = $ClsMon->exec_sql($sql);
		//$respuesta->alert($sql);
      if($rs == 1){
         $respuesta->script('swal("Ok", "Moneda fuera de la lista....", "success").then((value)=>{ window.location.href="'.$pagina.'"; });');
      }else{
         $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
      }	
	}
	
   return $respuesta;
}

function Selecciona_Moneda_Tcambio($cod){
   $respuesta = new xajaxResponse();
   $ClsMon = new ClsMoneda();
    
	//$respuesta->alert("$cod");
	$result = $ClsMon->get_moneda($cod);
	if(is_array($result)){
		foreach($result as $row){
			$camb = $row["mon_cambio"];
			$respuesta->assign("tcamb","value",$camb);
		}
		//abilita y desabilita botones
		$respuesta->script("cerrar()");
	}	
	
   return $respuesta;
}


function Actualiza_Tipo_Cambio($mon,$camb){
  //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsMon = new ClsMoneda();
    if($mon != "" && $camb != ""){
		$sql = $ClsMon->update_cambio_moneda($mon,$camb);
		$sql.= $ClsMon->insert_his_cambio($mon,$camb);
		$rs = $ClsMon->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Tasa de cambio actualizada...", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}


///////////////////////// SERIE ///////////////////////////////////////////
function Grabar_Serie($num,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
	//----
		$desc = trim($desc);
	//----
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//____
    if($desc != "" && $num != ""){
		$cod = $ClsFac->max_serie();
		$cod++;
		$sql = $ClsFac->insert_serie($cod,$num,$desc);
		$rs = $ClsFac->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Nueva Serie de Factura agregada satisfactoriamente!!!.", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}


function Buscar_Serie($cod){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   //$respuesta->alert("$cod");
	$result = $ClsFac->get_serie($cod);
	if(is_array($result)){
		foreach($result as $row){
			$cod = $row["ser_codigo"];
			$respuesta->assign("cod1","value",$cod);
			$num = utf8_decode($row["ser_numero"]);
			$respuesta->assign("num1","value",$num);
			$desc = utf8_decode($row["ser_descripcion"]);
			$respuesta->assign("desc1","value",$desc);
		}
		$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
		$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
	}	
   return $respuesta;
}


function Modificar_Serie($cod,$num,$desc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
	//----
		$desc = trim($desc);
	//----
		$desc = utf8_encode($desc);
		//--
		$desc = utf8_decode($desc);
	//____
    if($cod != "" && $desc != "" && $num != ""){
		$sql = $ClsFac->modifica_serie($cod,$num,$desc);
		$rs = $ClsFac->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Nueva Serie de Factura modificada satisfactoriamente!!!.", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}


function Modulos($arrmodulos,$arrsituacion,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsReg = new ClsRegla();
	if($filas > 0){
      $sql = "";
      for($i = 1; $i <= $filas; $i++){
         $codigo = $arrmodulos[$i];
         $situacion = $arrsituacion[$i];
         $sql.= $ClsReg->update_situacion_modulos($codigo,$situacion);
      }
		$rs = $ClsReg->exec_sql($sql);
		//$respuesta->alert($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "M\u00F3dulos actualizados satisfactoriamente!!!.", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}	
	}
	
   return $respuesta;
}

//////////////////---- VARIOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "depmun");

///////////// CONFIGURACION INICIAL //////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Modificar_Credenciales");
$xajax->register(XAJAX_FUNCTION, "Modificar_Reglas");
$xajax->register(XAJAX_FUNCTION, "Modificar_Regla_Seguridad");
///////////// MONEDA //////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Moneda");
$xajax->register(XAJAX_FUNCTION, "Buscar_Moneda");
$xajax->register(XAJAX_FUNCTION, "Modificar_Moneda");
$xajax->register(XAJAX_FUNCTION, "Cambia_Sit_Moneda");
$xajax->register(XAJAX_FUNCTION, "Selecciona_Moneda_Tcambio");
$xajax->register(XAJAX_FUNCTION, "Actualiza_Tipo_Cambio");
///////////// SERIE //////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Serie");
$xajax->register(XAJAX_FUNCTION, "Buscar_Serie");
$xajax->register(XAJAX_FUNCTION, "Modificar_Serie");
//////////////////---- MODULOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Modulos");

//El objeto xajax tiene que procesar cualquier petici\u00F3n
$xajax->processRequest();

?>  