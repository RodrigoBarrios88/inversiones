<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_bancos.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Unidad de Medida /////////
function UnidadMedida($clase){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$clase");
	$contenido = umedida_html($clase,'umed');
	$respuesta->assign("sumed","innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- BANCOS -----/////////////////////////////////////////////
function Grabar_Banco($dct,$dlg,$pai){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
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
	if($dct != "" && $dlg != "" && $pai != ""){
		$cod = $ClsBan->max_banco();
		$cod++;
		$sql = $ClsBan->insert_banco($cod,$dct,$dlg,$pai);
		//$respuesta->alert("$sql");
		$rs = $ClsBan->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Buscar_Banco($cod){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();

   //$respuesta->alert("$cod");
	$cont = $ClsBan->count_banco($cod,$dct,$dlg,$pai,$sit);
	if($cont>0){
		if($cont==1){
				$result = $ClsBan->get_banco($cod,$dct,$dlg,$pai,$sit);
				foreach($result as $row){
					$cod = $row["ban_codigo"];
					$respuesta->assign("cod","value",$cod);
					$dct = utf8_decode($row["ban_desc_ct"]);
					$respuesta->assign("dct","value",$dct);
					$dlg = utf8_decode($row["ban_desc_lg"]);
					$respuesta->assign("dlg","value",$dlg);
					$pai = $row["ban_pais"];
					$respuesta->assign("pai","value",$pai);
					$sit = $row["ban_situacion"];
					$respuesta->assign("sit","value",$sit);
				}
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('gra').className = 'btn btn-primary hidden';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
		}
		//abilita y desabilita botones
		$contenido = tabla_bancos($cod,$dct,$dlg,$pai,$sit);
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar();");
	}	
   return $respuesta;
}

function Modificar_Banco($cod,$dct,$dlg,$pai){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();

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
	//$respuesta->alert("$cod,$dct,$dlg,$pai");
    if($cod != ""){
		if($dct != "" && $dlg != "" && $pai != ""){
			$sql = $ClsBan->modifica_banco($cod,$dct,$dlg,$pai);
			//$respuesta->alert("$sql");
			$rs = $ClsBan->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script("cerrar();");
		$respuesta->script("swal('Error', 'Error en la transacci\u00F3n, refresque la pagina e intente de nuevo', 'error');");
		$respuesta->script("document.getElementById('mod').disabled = true;");
	}
   		
   return $respuesta;
}


function Situacion_Banco($ban,$sit){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();

    //$respuesta->alert("$ban,$sit");
    if($ban != ""){
		if($sit == 0){
			$activo = $ClsBan->comprueba_sit_banco($ban);
			if(!$activo){
				$sql = $ClsBan->cambia_sit_banco($ban,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsBan->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Excelente!", "Banco desactivado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				}	
			}else{
				$respuesta->script('swal("", "Este Banco tiene Cuentas en situaci\u00F3n activa, desactivelas primero antes de esta acci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}
		}else if($sit == 1){
			$sql = $ClsBan->cambia_sit_banco($ban,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsBan->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Banco activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			}	
		}
	}

	return $respuesta;
}


//////////////////---- CUENTAS DE BANCO -----/////////////////////////////////////////////
function Grabar_Cuenta($ban,$suc,$num,$nom,$tip,$mon,$fpag,$tasa,$plazo,$fini,$monto){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
    //pasa a mayusculas
		$num = trim($num);
		$nom = trim($nom);
		$fpag = trim($fpag);
	//--------
	//decodificaciones de tildes y Ñ's
		$num = utf8_encode($num);
		$nom = utf8_encode($nom);
		$fpag = utf8_encode($fpag);
		//--
		$num = utf8_decode($num);
		$nom = utf8_decode($nom);
		$fpag = utf8_decode($fpag);
	//--------
	//quita guiones
		$num = str_replace("-","",$num);
	//--------
	//$respuesta->alert("$ban,$num,$tip,$mon,$fpag,$tasa,$plazo,$fini,$monto");
	if($ban != "" && $suc != "" && $num != "" && $nom != "" && $tip != "" && $mon != "" && $fpag != "" && $tasa != "" && $plazo != "" && $fini != "" && $monto != ""){
		$cod = $ClsBan->max_cuenta_banco($ban);
		$cod++;
		//Query
		$sql = $ClsBan->insert_cuenta_banco($cod,$ban,$suc,$num,$nom,$tip,$monto,$mon,$tasa,$plazo,$fpag,$fini);
		$sql.= $ClsBan->insert_mov_cuenta(1,$cod,$ban,"I",$monto,"DP","APERTURA DE CUENTA","",$fini);
		//$respuesta->alert("$sql");
		$rs = $ClsBan->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Buscar_Cuenta($cod,$ban){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();

	$cont = $ClsBan->count_cuenta_banco($cod,$ban);
	 //$respuesta->alert("$cont");
		if($cont>0){
			if($cont==1){
				$result = $ClsBan->get_cuenta_banco($cod,$ban);
				foreach($result as $row){
					$cod = $row["cueb_codigo"];
					$respuesta->assign("cod","value",$cod);
					$ban = $row["ban_codigo"];
					$respuesta->assign("ban","value",$ban);
					$suc = $row["cueb_sucursal"];
					$respuesta->assign("suc","value",$suc);
					$num = $row["cueb_ncuenta"];
					$respuesta->assign("num","value",$num);
					$nom = utf8_decode($row["cueb_nombre"]);
					$respuesta->assign("nom","value",$nom);
					$tipo = $row["cueb_tipo_cuenta"];
					$respuesta->assign("tip","value",$tipo);
					$mon = $row["cueb_moneda"];
					$respuesta->assign("mon","value",$mon);
					$fpag = $row["cueb_forma_pago"];
					$respuesta->assign("fpag","value",$fpag);
					$tasa = $row["cueb_tasa"];
					$respuesta->assign("tasa","value",$tasa);
					$dias = $row["cueb_plazo"];
					$respuesta->assign("dias","value",$dias);
					$fini = $row["cueb_fini"];
					$fini = $ClsBan->cambia_fecha($fini);
					$respuesta->assign("fini","value",$fini);
				}
				$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
				$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			}
			//abilita y desabilita botones
			$contenido = tabla_cuenta_banco($cod,$ban,"","","","","","MOD");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
	   	}
   return $respuesta;
}


function Buscar_Cuenta_Saldo($ban,$num,$tipo,$mon){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
	 //pasa a mayusculas
		$num = trim($num);
		$nom = trim($nom);
		$fpag = trim($fpag);
	//--------
	//decodificaciones de tildes y Ñ's
		$num = utf8_encode($num);
		$nom = utf8_encode($nom);
		$fpag = utf8_encode($fpag);
		//--
		$num = utf8_decode($num);
		$nom = utf8_decode($nom);
		$fpag = utf8_decode($fpag);
	//--------
	//quita guiones
		$num = str_replace("-","",$num);
	//--------
	//$respuesta->alert("$ban,$num,$tipo,$mon");
    if($ban != "" || $num != ""|| $tipo != ""|| $mon != ""){
		$cont = $ClsBan->count_cuenta_banco("",$ban,$num,$tipo,$mon,"",1);;
		//$respuesta->alert("$cont,$mon");
		if($cont>0){
			$contenido = tabla_cuenta_banco($cod,$ban,$num,$tip,$mon,"",1,"VIS");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Modificar_Cuenta($cod,$ban,$suc,$num,$nom,$tip,$mon,$fpag,$tasa,$plazo,$fini){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
   $ClsBan = new ClsBanco();
	 //pasa a mayusculas
		$num = trim($num);
		$nom = trim($nom);
		$fpag = trim($fpag);
	//--------
	//decodificaciones de tildes y Ñ's
		$num = utf8_encode($num);
		$nom = utf8_encode($nom);
		$fpag = utf8_encode($fpag);
		//--
		$num = utf8_decode($num);
		$nom = utf8_decode($nom);
		$fpag = utf8_decode($fpag);
	//--------
	//quita guiones
		$num = str_replace("-","",$num);
	//--------
	//$respuesta->alert("$cod,$ban,$num,$tip,$mon,$fpag,$tasa,$plazo,$fini");
	if($cod != "" && $ban != "" && $suc != "" && $num != "" && $nom != "" && $tip != "" && $mon != "" && $fpag != "" && $tasa != "" && $plazo != "" && $fini != ""){
		//Query
		$sql = $ClsBan->modifica_cuenta_banco($cod,$ban,$suc,$num,$nom,$tip,$mon,$tasa,$plazo,$fpag,$fini);
		$rs = $ClsBan->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Situacion_Cuenta_Banco($cod,$ban,$sit){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();

    //$respuesta->alert("$cod,$ban,$sit");
    if($cod != "" && $ban != ""){
		if($sit == 0){
			$activo = $ClsBan->comprueba_sit_cuenta_banco($cod,$ban);
			if(!$activo){
				$sql = $ClsBan->cambia_sit_cuenta_banco($cod,$ban,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsBan->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Excelente!", "Cuenta desactivada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				}	
			}else{
				$respuesta->script('swal("", "Esta Cuenta de Banco tiene saldo mayor a 0, nivele a 0 el saldo antes de esta acci\u00F3n...", "info").then((value)=>{ cerrar(); });');
			}
		}else if($sit == 1){
			$sql = $ClsBan->cambia_sit_cuenta_banco($cod,$ban,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsBan->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Registros re-activada satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}

	return $respuesta;
}


function Combo_Cuenta_Banco($ban,$cue,$scue,$acc){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$ban,$cue,$scue,$acc");
	$contenido = cuenta_banco_html($ban,$cue,$acc);
	$respuesta->assign($scue,"innerHTML",$contenido);
	
	return $respuesta;
}



//////////////////---- Movimientos de Cuenta -----/////////////////////////////////////////////
function Grabar_Movimiento_Cuenta($ban,$cue,$mov,$monto,$doc,$tipo,$mot,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
    //pasa a mayusculas
		$mot = trim($mot);
	//--------
	//decodificaciones de tildes y Ñ's
		$mot = utf8_encode($mot);
		//--
		$mot = utf8_decode($mot);
	//--------
	//$respuesta->alert("$ban,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
	if($ban != "" && $cue != "" && $mov != "" && $monto != "" && $doc != "" && $tipo != "" && $fecha != ""){
		$cod = $ClsBan->max_mov_cuenta($cue,$ban);
		$cod++;
		//Query
		$signo = ($mov == "I")?"+":"-";
		$sql.= $ClsBan->insert_mov_cuenta($cod,$cue,$ban,$mov,$monto,$tipo,$mot,$doc,$fecha);
		$sql.= $ClsBan->saldo_cuenta_banco($cue,$ban,$monto,$signo);
		//$respuesta->alert("$sql");
		$rs = $ClsBan->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}

function Buscar_Cuenta_Movimiento($cue,$ban,$tipo,$mon,$acc){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
	//$respuesta->alert("$ban,$num,$tipo,$mon");
    if($ban != "" || $cue != ""|| $tipo != ""|| $mon != ""){
		$cont = $ClsBan->count_cuenta_banco($cue,$ban,"",$tipo,$mon,"",1);;
		//$respuesta->alert("$cont,$mon");
		if($cont>0){
			$contenido = tabla_cuenta_banco($cue,$ban,"",$tip,$mon,"",1,$acc);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Buscar_Cuenta_Conciliacion($ban,$cue,$tipo,$mon,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
	//$respuesta->alert("$ban,$num,$tipo,$mon");
    if($ban != "" || $cue != ""|| $tipo != ""|| $mon != ""){
		$cont = $ClsBan->count_cuenta_banco($cue,$ban,"",$tipo,$mon,"",1);;
		//$respuesta->alert("$cont,$mon");
		if($cont>0){
			if($cont==1){
				$contenido = tabla_movimientos($cue,$ban,$fini,$ffin);
				$respuesta->assign("divdispay","innerHTML",$contenido);
			}else{
				$respuesta->assign("divdispay","innerHTML","");
			}
			$contenido = tabla_cuenta_movimiento($cue,$ban,$num,$tip,$mon,$fini,$ffin);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "info").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Seleccionar_Cuenta($cue,$ban,$fini,$ffin){
   $respuesta = new xajaxResponse();
   	$contenido = tabla_cuenta_movimiento($cod,$ban,$num,$tip,$mon,$fini,$ffin);;
		$respuesta->assign("result","innerHTML",$contenido);
		$contenido = tabla_movimientos($cue,$ban,$fini,$ffin);
		$respuesta->assign("divdispay","innerHTML",$contenido);
		$respuesta->script("cerrar();");
 		
   return $respuesta;
}

/////////////////------ Cheque -----////////////////////////////////////////
function Last_Cheque($cue,$ban){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
    //$respuesta->alert("$onclick");
	$num = $ClsBan->last_numero_cheque($cue,$ban);
	$num++;
	$num = Agrega_Ceros($num);
	$respuesta->assign("num","value",$num);
	
	
	return $respuesta;
}


function Grabar_Cheque($cue,$ban,$num,$monto,$quien,$concept){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
    //pasa a mayusculas
		$concept = trim($concept);
		$quien = trim($quien);
	//--------
	//decodificaciones de tildes y Ñ's
		$concept = utf8_encode($concept);
		$quien = utf8_encode($quien);
		//--
		$concept = utf8_decode($concept);
		$quien = utf8_decode($quien);
	//--------
	$num = Agrega_Ceros($num);
	//$respuesta->alert("$ban,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
	if($ban != "" && $cue != "" && $num != "" && $monto != "" && $quien != "" && $concept != ""){
		$cod = $ClsBan->max_cheque($cue,$ban);
		$cod++;
		//Query
		$sql.= $ClsBan->insert_cheque($cod,$cue,$ban,$num,$monto,$quien,$concept);
		//$respuesta->alert("$sql");
		$rs = $ClsBan->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBan->encrypt($cod, $usu);
			$hashkey2 = $ClsBan->encrypt($cue, $usu);
			$hashkey3 = $ClsBan->encrypt($ban, $usu);
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); window.open("CPREPORTES/REPcheque.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'", "_blank"); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}

function Modificar_Cheque($cod,$cue,$ban,$num,$monto,$quien,$concept){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
    //pasa a mayusculas
		$concept = trim($concept);
		$quien = trim($quien);
	//--------
	//decodificaciones de tildes y Ñ's
		$concept = utf8_encode($concept);
		$quien = utf8_encode($quien);
		//--
		$concept = utf8_decode($concept);
		$quien = utf8_decode($quien);
	//--------
	$num = Agrega_Ceros($num);
	//$respuesta->alert("$ban,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
	if($cod != "" && $ban != "" && $cue != "" && $num != "" && $monto != "" && $quien != "" && $concept != ""){
		//Query
		$sql.= $ClsBan->modifica_cheque($cod,$cue,$ban,$num,$monto,$quien,$concept);
		//$respuesta->alert("$sql");
		$rs = $ClsBan->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBan->encrypt($cod, $usu);
			$hashkey2 = $ClsBan->encrypt($cue, $usu);
			$hashkey3 = $ClsBan->encrypt($ban, $usu);
			$respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); window.open("CPREPORTES/REPcheque.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'&hashkey3='.$hashkey3.'", "_blank"); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Buscar_Cheque($cod,$cue,$ban){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
	//$respuesta->alert("$cod,$cue,$ban");
	$cont = $ClsBan->count_cheque($cod,$cue,$ban);
	if($cont>0){
		if($cont==1){
			$result = $ClsBan->get_cheque($cod,$cue,$ban);
			foreach($result as $row){
				$cod = $row["che_codigo"];
				$respuesta->assign("cod","value",$cod);
				$cue = $row["cueb_codigo"];
				$ban = $row["ban_codigo"];
				$respuesta->assign("ban","value",$ban);
				$num = $row["che_ncheque"];
				$respuesta->assign("num","value",$num);
				$quien = utf8_decode($row["che_quien"]);
				$respuesta->assign("quien","value",$quien);
				$monto = $row["che_monto"];
				$respuesta->assign("monto","value",$monto);
				$moneda = $row["mon_desc"];
				$respuesta->assign("moneda","value",$moneda);
				$concept = utf8_decode($row["che_concepto"]);
				$respuesta->assign("concept","value",$concept);
				//--
				$sit = $row["che_situacion"];
			}
			//$respuesta->alert("$cue,$ban");
			$contenido = cuenta_banco_html($ban,"cue","");
			$respuesta->assign("scue","innerHTML",$contenido);
			$respuesta->assign("cue","value",$cue);
			$respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");
			$respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
			//--
			if($sit == 1){
				$respuesta->script("document.getElementById('ban').removeAttribute('disabled');");
				$respuesta->script("document.getElementById('cue').removeAttribute('disabled');");
				$respuesta->script("document.getElementById('num').removeAttribute('disabled');");
				$respuesta->script("document.getElementById('monto').removeAttribute('disabled');");
			}else if($sit == 2){
				$respuesta->script("document.getElementById('ban').setAttribute('disabled', 'disabled');");
				$respuesta->script("document.getElementById('cue').setAttribute('disabled', 'disabled');");
				$respuesta->script("document.getElementById('num').setAttribute('disabled', 'disabled');");
				$respuesta->script("document.getElementById('monto').setAttribute('disabled', 'disabled');");
			}
		}
		//abilita y desabilita botones
		$contenido = tabla_cheques($cod,$cue,$ban,"","","","","","MOD");
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar();");
	}
   return $respuesta;
}


function Situacion_Cheque($cod,$cue,$ban,$sit){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();

   //$respuesta->alert("$ban,$sit");
   if($cod != "" && $cue != "" && $ban != ""){
		if($sit == 0){
			$activo = $ClsBan->comprueba_sit_cheque($cod,$cue,$ban);
			if(!$activo){
				$sql = $ClsBan->cambia_sit_cheque($cod,$cue,$ban,$sit);
				//$respuesta->alert("$sql");
				$rs = $ClsBan->exec_sql($sql);
				if($rs == 1){
					$respuesta->script('swal("Excelente!", "Cheque anulado Satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
				}else{
					$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
				}	
			}else{
				$respuesta->script('swal("", "Este Cheque ya fue pagado, no puede realizar esta acci\u00F3n...", "info").then((value)=>{ cerrar(); });');
			}
		}else if($sit == 1){
			$sql = $ClsBan->cambia_sit_cheque($cod,$cue,$ban,$sit);
			//$respuesta->alert("$sql");
			$rs = $ClsBan->exec_sql($sql);
			if($rs == 1){
				$respuesta->script('swal("Excelente!", "Cheque re-activado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}

	return $respuesta;
}


function Ejecutar_Monto_Cheque($che,$ban,$cue,$monto,$doc,$mot){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
    //pasa a mayusculas
		$mot = trim($mot);
	//--------
	//decodificaciones de tildes y Ñ's
		$mot = utf8_encode($mot);
		//--
		$mot = utf8_decode($mot);
	//--------
	//$respuesta->alert("$che,$ban,$cue,$monto,$doc,$mot");
	if($ban != "" && $cue != "" && $monto != "" && $doc != ""){
		$cod = $ClsBan->max_mov_cuenta($cue,$ban);
		$cod++;
		//Query
		$sql.= $ClsBan->insert_mov_cuenta($cod,$cue,$ban,"E",$monto,"CH",$mot,$doc,date("d/m/Y"));
		$sql.= $ClsBan->saldo_cuenta_banco($cue,$ban,$monto,"-");
		$sql.= $ClsBan->cambia_sit_cheque($che,$cue,$ban,2);
		//$respuesta->alert("$sql");
		$rs = $ClsBan->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Cheque ejecutado satisfactoriamente!!!", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}



//////////////////---- Grupo de Articulos -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Banco");
$xajax->register(XAJAX_FUNCTION, "Buscar_Banco");
$xajax->register(XAJAX_FUNCTION, "Modificar_Banco");
$xajax->register(XAJAX_FUNCTION, "Situacion_Banco");
//////////////////---- CUENTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Cuenta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Cuenta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Cuenta_Saldo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Cuenta_Movimiento");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cuenta");
$xajax->register(XAJAX_FUNCTION, "Situacion_Cuenta_Banco");
$xajax->register(XAJAX_FUNCTION, "Combo_Cuenta_Banco");
//////////////////---- Movimiento de Cuentas -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Movimiento_Cuenta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Cuenta_Conciliacion");
$xajax->register(XAJAX_FUNCTION, "Seleccionar_Cuenta");
/////////////////------ Cheque -----////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Last_Cheque");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cheque");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cheque");
$xajax->register(XAJAX_FUNCTION, "Buscar_Cheque");
$xajax->register(XAJAX_FUNCTION, "Situacion_Cheque");
$xajax->register(XAJAX_FUNCTION, "Ejecutar_Monto_Cheque");

//El objeto xajax tiene que procesar cualquier petici\u00F3n
$xajax->processRequest();

?>  