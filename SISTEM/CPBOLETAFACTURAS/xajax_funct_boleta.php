<?php 
//inclu�mos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_boleta.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

function Combo_Cuenta_Banco($ban,$cue,$scue,$acc){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$ban,$cue,$scue,$acc");
	$contenido = cuenta_banco_html($ban,$cue,$acc);
	$respuesta->assign($scue,"innerHTML",$contenido);
	
	return $respuesta;
}


function Nivel_Grado($pensum,$nivel,$idgra,$idsgra){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$area,$grado");
	$contenido = grado_html($pensum,$nivel,$idgra,"");
	$respuesta->assign($idsgra,"innerHTML",$contenido);
	
	return $respuesta;
}


//////////////////---- FACTURAS Y RECIBOS -----/////////////////////////////////////////////

function Grabar_Factura_Carga_Electronica($numero,$serie,$suc,$pv,$arralumno,$arrcli,$carga,$arrcodpag,$arrboleta,$arrdesc,$arrmonto,$moneda,$tcambio,$arrfecha,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	$ClsFac = new ClsFactura();
    
	//$respuesta->alert("$cue,$ban,$arralumno,$arrboleta,$arrfecha,$arrmes,$arrefect,$arrcheprop,$arrotrosban,$arronline,$filas");
	if($numero != "" && $serie != "" && $suc != "" && $pv != "" && $carga != "" && $moneda != "" && $tcambio != ""){
		//Query
		for($i = 1; $i <= $filas; $i ++){
			$alumno = $arralumno[$i];
			$codpago = $arrcodpag[$i];
			$referencia = $arrboleta[$i];
			$fecha = $arrfecha[$i];
			$cli = $arrcli[$i];
			$monto = $arrmonto[$i];
         $desc = $arrdesc[$i];
			//--
			//$respuesta->alert("$alumno,$referencia,$cue,$ban,$trans,$efect,$chp,$otb,$online");
			$sql.= $ClsBol->insert_factura($numero,$serie,$suc,$alumno,$cli,$carga,$codpago,$referencia,$desc,$monto,$moneda,$tcambio,$fecha);
			if($codpago != ""){ // los numeros de boletas desconocidas ser�n vacias... esta validaci�n evita un error..
			$sql.= $ClsBol->update_facturado_pago($codpago,1); ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
			}
			$numero++;
		}
		$numero--; //quita la ultima vuelta para devolver el ultimo numero utilizado
		$sql.= $ClsFac->modifica_fac_base($pv,$suc,$serie,$numero);
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($carga, $usu);
			$respuesta->script('swal("Excelente", "Transacci\u00F3n Registrada Satisfactoriamente!!!", "success").then((value)=>{ openFacturas(\''.$hashkey.'\'); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Buscar_Alumno($cui){
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
   //$respuesta->alert("$cui");
	$result = $ClsAlu->get_alumno($cui);
	if(is_array($result)){
	   foreach($result as $row){
			$cui = $row["alu_cui"];
			$respuesta->assign("alumno","value",$cui);
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$nombre = "$nom $ape";
			$respuesta->assign("nombre","value",$nombre);
			$cli = $row["alu_cliente_factura"];
			$respuesta->assign("cli","value",$cli);
			$nit = $row["alu_nit"];
			$respuesta->assign("nit","value",$nit);
			$cliente = utf8_decode($row["alu_cliente_nombre "]);
			$respuesta->assign("cliente","value",$cliente);
		}
		$respuesta->script("cerrar();");
	}else{
		$respuesta->script('swal("Ohoo!", "Este N\u00FAmero CUI o Pasaporte no pertenece a ningun alumno....", "warning").then((value)=>{ cerrar(); });');
	}
   return $respuesta;
}


function Grabar_Factura_Individual($numero,$serie,$suc,$pv,$alumno,$cli,$codpago,$referencia,$desc,$monto,$moneda,$tcambio,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro(); 
	$ClsFac = new ClsFactura();
    
	//$respuesta->alert("$cue,$ban,$arralumno,$arrboleta,$arrfecha,$arrmes,$arrefect,$arrcheprop,$arrotrosban,$arronline,$filas");
	if($numero != "" && $serie != "" && $suc != "" && $pv != "" && $desc != "" && $moneda != "" && $tcambio != "" && $monto != "" && $fecha != ""){
		//Query
		$sql = $ClsBol->insert_factura($numero,$serie,$suc,$alumno,$cli,0,$codpago,$referencia,$desc,$monto,$moneda,$tcambio,$fecha);
		$sql.= $ClsBol->update_facturado_pago($codpago,1); ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
		$sql.= $ClsFac->modifica_fac_base($pv,$suc,$serie,$numero);
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBol->encrypt($numero, $usu);
			$hashkey2 = $ClsBol->encrypt($serie, $usu);
			$hashkey = $ClsBol->encrypt($alumno, $usu);

			$respuesta->script('swal("Excelente", "Transacci\u00F3n Registrada Satisfactoriamente!!!", "success").then((value)=>{ openFactura(\''.$hashkey1.'\',\''.$hashkey2.'\',\''.$hashkey.'\'); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta; 
}


function Modificar_Factura_Individual($numero,$serie,$suc,$pv,$alumno,$cli,$codpag,$referencia,$desc,$monto,$moneda,$tcambio,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	 
	//$respuesta->alert("$cue,$ban,$arralumno,$arrboleta,$arrfecha,$arrmes,$arrefect,$arrcheprop,$arrotrosban,$arronline,$filas");
	if($numero != "" && $serie != "" && $suc != "" && $pv != "" && $desc != "" && $moneda != "" && $tcambio != "" && $monto != "" && $fecha != ""){
		//Query
		$sql = $ClsBol->update_factura($numero,$serie,$suc,$alumno,$cli,$referencia,$desc,$monto,$moneda,$tcambio,$fecha);
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBol->encrypt($numero, $usu);
			$hashkey2 = $ClsBol->encrypt($serie, $usu);
			$hashkey = $ClsBol->encrypt($alumno, $usu);
			
			$respuesta->script('swal("Excelente", "Transacci\u00F3n Registrada Satisfactoriamente!!!", "success").then((value)=>{ openFactura(\''.$hashkey1.'\',\''.$hashkey2.'\',\''.$hashkey.'\'); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Anular_Factura($serie,$numero,$codpago){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   //$respuesta->alert("$ban,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
		//Query
		$sql = $ClsBol->cambia_sit_factura($numero,$serie,0);
		$sql.= $ClsBol->update_facturado_pago($codpago,0); ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Ok", "Factura Anulada Satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMlista_facturas.php"; });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   		
   return $respuesta;
}


//////////////////---- FACTURAS FACE -----//////////////////////////////

function Grabar_Facturas_FACE($arrcentro, $arrfecha, $arrtipo, $arroperacion, $arrserie, $arrnumero, $arrnit, $arrbienes, $arrservicios, $arriva, $arrtotal, $filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	$ClsFac = new ClsBoletaFace(); 

	if($filas > 0){
      $codigo = $ClsFac->max_factura();
      $codigo++;
		//Query
		for($i = 1; $i <= $filas; $i ++){
			$centro = $arrcentro[$i];
			$fecha = $arrfecha[$i];
			$tipo = $arrtipo[$i];
			$operacion = $arroperacion[$i];
			$serie = $arrserie[$i];
			$numero = $arrnumero[$i];
         $nit = $arrnit[$i];
			$bienes = $arrbienes[$i];
			$servicios = $arrservicios[$i];
			$iva = $arriva[$i];
			$total = $arrtotal[$i];
			//--
			//$respuesta->alert("$alumno,$referencia,$cue,$ban,$trans,$efect,$chp,$otb,$online");
			$sql.= $ClsFac->insert_factura($codigo, $centro, $fecha, $tipo, $operacion, $serie, $numero, $nit, $bienes, $servicios, $iva, $total);
			$codigo++;
		}
		//$respuesta->alert("$sql");
		$rs = $ClsFac->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente", "Transacciones registradas satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMlist_cargas.php" });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


//////////////////---- RECIBOS -----/////////////////////////////////////////////

function Grabar_Recibo_Carga_Electronica($numero,$serie,$suc,$pv,$arralumno,$arrcli,$carga,$arrcodpag,$arrboleta,$arrdesc,$arrmonto,$moneda,$tcambio,$arrfecha,$filas){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   $ClsRec = new ClsRecibo();
    
	//$respuesta->alert("$cue,$ban,$arralumno,$arrboleta,$arrfecha,$arrmes,$arrefect,$arrcheprop,$arrotrosban,$arronline,$filas");
	if($numero != "" && $serie != "" && $suc != "" && $pv != "" && $carga != "" && $moneda != "" && $tcambio != ""){
		//Query
		for($i = 1; $i <= $filas; $i ++){
			$alumno = $arralumno[$i];
			$codpago = $arrcodpag[$i];
			$referencia = $arrboleta[$i];
			$fecha = $arrfecha[$i];
			$cli = $arrcli[$i];
			$monto = $arrmonto[$i];
         $desc = $arrdesc[$i];
			//--
			//$respuesta->alert("$alumno,$referencia,$cue,$ban,$trans,$efect,$chp,$otb,$online");
			$sql.= $ClsBol->insert_recibo($numero,$serie,$suc,$alumno,$cli,$carga,$codpago,$referencia,$desc,$monto,$moneda,$tcambio,$fecha);
			if($codpago != ""){ // los numeros de boletas desconocidas ser�n vacias... esta validaci�n evita un error..
			$sql.= $ClsBol->update_facturado_pago($codpago,2); ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
			}
			$numero++;
      }
		$numero--; //quita la ultima vuelta para devolver el ultimo numero utilizado
		$sql.= $ClsRec->modifica_rec_base($pv,$suc,$serie,$numero);
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey = $ClsBol->encrypt($carga, $usu);
			$respuesta->script('swal("Excelente", "Transacci\u00F3n Registrada Satisfactoriamente!!!", "success").then((value)=>{ openRecibos(\''.$hashkey.'\'); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Grabar_Recibo_Individual($numero,$serie,$suc,$pv,$alumno,$cli,$codpago,$referencia,$desc,$monto,$moneda,$tcambio,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax  
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
	$ClsRec = new ClsRecibo();
    
	//$respuesta->alert("$cue,$ban,$arralumno,$arrboleta,$arrfecha,$arrmes,$arrefect,$arrcheprop,$arrotrosban,$arronline,$filas");
	if($numero != "" && $serie != "" && $suc != "" && $pv != "" && $desc != "" && $moneda != "" && $tcambio != "" && $monto != "" && $fecha != ""){
		$sql = $ClsBol->insert_recibo($numero,$serie,$suc,$alumno,$cli,0,$codpago,$referencia,$desc,$monto,$moneda,$tcambio,$fecha);
		$sql.= $ClsBol->update_facturado_pago($codpago,2); ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
		$sql.= $ClsRec->modifica_rec_base($pv,$suc,$serie,$numero);
		//$respuesta->alert("$alumno");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBol->encrypt($numero, $usu);
			$hashkey2 = $ClsBol->encrypt($serie, $usu);
			$hashkey = $ClsBol->encrypt($alumno, $usu);
			//$respuesta->alert("$alumno");
			$respuesta->script('swal("Excelente", "Transacci\u00F3n Registrada Satisfactoriamente!!!", "success").then((value)=>{ openRecibo(\''.$hashkey1.'\',\''.$hashkey2.'\',\''.$hashkey.'\'); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Modificar_Recibo_Individual($numero,$serie,$suc,$pv,$alumno,$cli,$codpago,$referencia,$desc,$monto,$moneda,$tcambio,$fecha){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
    
	//$respuesta->alert("$cue,$ban,$arralumno,$arrboleta,$arrfecha,$arrmes,$arrefect,$arrcheprop,$arrotrosban,$arronline,$filas");
	if($numero != "" && $serie != "" && $suc != "" && $pv != "" && $desc != "" && $moneda != "" && $tcambio != "" && $monto != "" && $fecha != ""){
		//Query
		$sql = $ClsBol->update_recibo($numero,$serie,$suc,$alumno,$cli,$referencia,$desc,$monto,$moneda,$tcambio,$fecha);
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$usu = $_SESSION["codigo"];
			$hashkey1 = $ClsBol->encrypt($numero, $usu);
			$hashkey2 = $ClsBol->encrypt($serie, $usu);
			$hashkey = $ClsBol->encrypt($alumno, $usu);
			$respuesta->script('swal("Excelente", "Transacci\u00F3n Registrada Satisfactoriamente!!!", "success").then((value)=>{ openRecibo(\''.$hashkey1.'\',\''.$hashkey2.'\',\''.$hashkey.'\'); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Anular_Recibo($serie,$numero,$codpago){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsBol = new ClsBoletaCobro();
   //$respuesta->alert("$ban,$num,$tipo,$mon,$fpag,$tasa,$plazo,$fini,$monto");
		//Query
		$sql = $ClsBol->cambia_sit_recibo($numero,$serie,0);
		$sql.= $ClsBol->update_facturado_pago($codpago,0); ///0->Pendiente de Factura o recibo, 1->Facturado, 2->Recibo
		//$respuesta->alert("$sql");
		$rs = $ClsBol->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Ok", "Recibo Anulada Satisfactoriamente!!!", "success").then((value)=>{ window.location.href="FRMlista_facturas.php"; });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
   		
   return $respuesta;
}


//////////////////---- CLIENTES -----/////////////////////////////////////////////
function Show_Cliente($nit,$fila){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //$respuesta->alert("$nit,$fila");
	if($nit != ""){
		$result = $ClsCli->get_cliente('',$nit,'');
		if(is_array($result)){
			foreach($result as $row){
				$cod = $row["cli_id"];
				$respuesta->assign("cli$fila","value",$nit);
				$nom = trim($row["cli_nombre"]);
				$respuesta->assign("cliente$fila","value",$nom);
				$nit = trim($row["cli_nit"]);
				$respuesta->assign("nit$fila","value",$nit);
			}
			$respuesta->script("cerrar();");
		}else{
			$respuesta->script("validaCliente('$nit','$fila');");
		}
	}else{
		$respuesta->assign("nit$fila","value","");
		$respuesta->assign("cliente$fila","value","");
		$respuesta->assign("cli$fila","value","");
		$respuesta->script("cerrar();");
	}
	
	return $respuesta;
}


function Grabar_Cliente($nit,$nom,$direc,$tel1,$tel2,$mail){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	 //$respuesta->alert("$nit,$nom,$direc,$tel1,$tel2,$mail,");
    if($nit != "" && $nom != "" && $direc != ""){
		$id = $ClsCli->max_cliente();
		$id++; /// Maximo codigo de Cliente
		//$respuesta->alert("$id");
		$sql = $ClsCli->insert_cliente($id,$nit,$nom,$direc,$tel1,$tel2,$mail); /// Inserta Cliente
		//$respuesta->alert("$sql");
		$rs = $ClsCli->exec_sql($sql);
		if($rs == 1){
			$respuesta->assign("cli","value",$id);
			$respuesta->assign("nit","value",$nit);
			$respuesta->assign("cliente","value",$nom);
         $respuesta->script('swal("Excelente!", "Registros guardados satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
		}
	}
   
   return $respuesta;
}

function Modificar_Cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail,$fila){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
	//--------
	//decodificaciones de tildes y �'s
		$nom = utf8_encode($nom);
		$direc = utf8_encode($direc);
		//--
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
	if($cod != ""){
		if($nit != "" && $nom != "" && $direc != ""){
			$sql = $ClsCli->modifica_cliente($cod,$nit,$nom,$direc,$tel1,$tel2,$mail);
			$rs = $ClsCli->exec_sql($sql);
			if($rs == 1){
				$respuesta->assign("cli$fila","value",$cod);
            $respuesta->assign("nit$fila","value",$nit);
            $respuesta->assign("cliente$fila","value",$nom);
            $respuesta->script('swal("Excelente!", "Registros actualizados satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n...", "error").then((value)=>{ cerrar(); });');
			}	
		}
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n, refresque la pagina e intente de nuevo...", "error").then((value)=>{ cerrar(); });');
	}
   		
   return $respuesta;
}


//////////////////---- Utilitarias -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Cuenta_Banco");
$xajax->register(XAJAX_FUNCTION, "Nivel_Grado");
//////////////////---- FACTURAS Y RECIBOS -----/////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Factura_Carga_Electronica");
$xajax->register(XAJAX_FUNCTION, "Buscar_Factura");
$xajax->register(XAJAX_FUNCTION, "Buscar_Alumno");
$xajax->register(XAJAX_FUNCTION, "Grabar_Factura_Individual");
$xajax->register(XAJAX_FUNCTION, "Modificar_Factura_Individual");
$xajax->register(XAJAX_FUNCTION, "Anular_Factura");
//////////////////---- FACE -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Facturas_FACE");
//////////////////---- RECIBOS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grabar_Recibo_Carga_Electronica");
$xajax->register(XAJAX_FUNCTION, "Buscar_Recibo");
$xajax->register(XAJAX_FUNCTION, "Grabar_Recibo_Individual");
$xajax->register(XAJAX_FUNCTION, "Modificar_Recibo_Individual");
$xajax->register(XAJAX_FUNCTION, "Anular_Recibo");
//////////////////---- CLIENTES -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Cliente");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Modificar_Cliente");

//El objeto xajax tiene que procesar cualquier petici�n
$xajax->processRequest();

?>  