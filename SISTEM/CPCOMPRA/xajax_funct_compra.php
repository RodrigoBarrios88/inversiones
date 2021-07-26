<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_compra.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Partida - Reglon /////////
function Combo_Reglon($par,$idreg,$idsreg){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
	$contenido = Reglon_html($par,$idreg);
	//$respuesta->alert("$contenido");
	$respuesta->assign("$idsreg","innerHTML",$contenido);
	
	return $respuesta;
}



///////////// ARTICULOS Y PROVEEDORS //////////////////////////////////
function Show_Barcode($barc,$suc){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticulo();
	$ClsSum = new ClsSuministro();
	
	//pasa a mayusculas
		$barc = trim($barc);
   //--------
   //$respuesta->alert("$cod,$barc,$suc");
   if($barc != ""){
		$indicador = substr($barc,0,1);
		//$respuesta->alert("$indicador");
		if($indicador == "A"){
			$chunk = explode("A", $barc);
			$art = $chunk[1]; // articulo
			$gru = $chunk[2]; // grupo
			//valida que los espacios sean numericos
			$art = (is_numeric($art))?$art:0;
			$gru = (is_numeric($gru))?$gru:0;
			//--
			$respuesta->script("TipoCompra('P');");
			$respuesta->assign("tip","value","P");
			//--
			$result = $ClsArt->get_articulo($art,$gru,'','','','','','',1,$suc);
			if(is_array($result)){
				foreach($result as $row){
					$art = $row["art_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$art = Agrega_Ceros($art);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $art."A".$gru;
					//$respuesta->alert("$cod");
					$respuesta->assign("Aart","value",$cod); //Selecciona el Combo
					$respuesta->assign("art","value",$cod); //guarada el codigo
					$nom = trim($row["art_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["art_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Abarc","value",$barc);
					$cant = $row["art_cant_suc"];
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["art_precio"];
					$prev = round($prev, 2);
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$respuesta->assign("prev","value",$prev);
					$prec = $row["art_precio_costo"];
					$prec = round($prec, 2);
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$respuesta->assign("prec","value",$prec);
					$prem = $row["art_precio_manufactura"];
					$prem = round($prem, 2);
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("$('.select2').select2();");
				$respuesta->script("cerrar();");
			}else{
				$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->assign("art","value","");
				$respuesta->assign("artn","value","");
			}
		}else if($indicador == "U"){
			$chunk = explode("U", $barc);
			$art = $chunk[1]; // articulo
			$gru = $chunk[2]; // grupo
			//valida que los espacios sean numericos
			$art = (is_numeric($art))?$art:0;
			$gru = (is_numeric($gru))?$gru:0;
			//--
			$respuesta->script("TipoCompra('U');");
			$respuesta->assign("tip","value","U");
			//--
			$result = $ClsSum->get_articulo($art,$gru,'','','','','','',1,$suc);
			if(is_array($result)){
				foreach($result as $row){
					$art = $row["art_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$art = Agrega_Ceros($art);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $art."A".$gru;
					//$respuesta->alert("$cod");
					$respuesta->assign("Sart","value",$cod); //Selecciona el Combo
					$respuesta->assign("art","value",$cod); //guarada el codigo
					$nom = trim($row["art_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["art_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Sbarc","value",$barc);
					$cant = $row["art_cant_suc"];
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["art_precio"];
					$prev = round($prev, 2);
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$respuesta->assign("prev","value",$prev);
					$prec = $row["art_precio_costo"];
					$prec = round($prec, 2);
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$respuesta->assign("prec","value",$prec);
					$prem = $row["art_precio_manufactura"];
					$prem = round($prem, 2);
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("$('.select2').select2();");
				$respuesta->script("cerrar();");
			}else{
				$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				$respuesta->assign("art","value","");
				$respuesta->assign("artn","value","");
			}				
			
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}
		//inicia la busqueda
		
	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
		$respuesta->script("cerrar()");
	}
	
	return $respuesta;
}


function Show_Articulo($cod,$barc,$suc){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticulo();
   //pasa a mayusculas
		$cod = trim($cod);
		$barc = trim($barc);
   //decodificaciones de tildes y Ñ's
		$cod = utf8_decode($cod);
		$barc = utf8_decode($barc);
   //--------
   //$respuesta->alert("$cod,$barc,$suc");
    if($cod != "" || $barc != ""){
		if($cod != ""){
			$chunk = explode("A", $cod);
			$art = $chunk[0]; // articulo
			$gru = $chunk[1]; // grupo
			//valida que los espacios sean numericos
			$art = (is_numeric($art))?$art:0;
			$gru = (is_numeric($gru))?$gru:0;
			$result = $ClsArt->get_articulo($art,$gru,'','','','','','',1,$suc);
		}else{
			$result = $ClsArt->get_articulo('','','','','','','',$barc,1,$suc);
		}
		//inicia la busqueda
		if(is_array($result)){
				foreach($result as $row){
					$art = $row["art_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$art = Agrega_Ceros($art);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $art."A".$gru;
					$respuesta->assign("art","value",$cod);
					$nom = trim($row["art_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["art_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Abarc","value",$barc);
					$cant = $row["art_cant_suc"];
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					//--
					$prev = $row["art_precio"];
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$prev = number_format($prev, 2, '.', '');
					$respuesta->assign("prev","value",$prev);
					//--
					$prec = $row["art_precio_costo"];
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$prec = number_format($prec, 2, '.', '');
					$respuesta->assign("prec","value",$prec);
					//--
					$prem = $row["art_precio_manufactura"];
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$prem = number_format($prem, 2, '.', '');
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("document.getElementById('cant').focus();");
				
		}else{
			$respuesta->script("abrir()");
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}
		
	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
	}
	
	return $respuesta;
}


function Buscar_Articulo($gru,$nom,$desc,$marca,$suc,$x){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticulo();
	//pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
	//--------
	//$respuesta->alert("$gru,$nom,$desc,$marca,$suc,$x");
    if($gru != "" || $nom != "" || $desc != "" || $marca != ""){
		$cont = $ClsArt->count_articulo('',$gru,$nom,$desc,$marca,'','',$barc,1,$suc);
		if($cont>0){
			$contenido = tabla_lista_articulos($gru,$nom,$desc,$marca,'',$suc,$x);
			$respuesta->assign("resultArt","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}


function Show_Proveedor($nit){
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //$respuesta->alert("$nit");
	if($nit != ""){
		$cont = $ClsProv->count_proveedor('',$nit,'','',1);
		if($cont>0){
			$result = $ClsProv->get_proveedor('',$nit,'','',1);
			foreach($result as $row){
				$cod = $row["prov_id"];
				$respuesta->assign("prov","value",$cod);
				$nom = trim($row["prov_nombre"]);
				$respuesta->assign("nom","value",$nom);
				$nit = trim($row["prov_nit"]);
				$respuesta->assign("nit","value",$nit);
			}
			$respuesta->script("cerrar()");
			$respuesta->script("document.getElementById('art').focus();");
			
		}else{
			$msj = '<h5>Este Proveedor no existe, desea agregarlo?</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-default" onclick = "cerrar()" ><span class="fa fa-times"></span> No</button> ';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "NewProveedor(\''.$nit.'\');" ><span class="fa fa-check"></span> Si</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("nit","value","");
			$respuesta->assign("nom","value","");
			$respuesta->assign("prov","value","");
		}
	}else{
		$respuesta->assign("nit","value","");
		$respuesta->assign("nom","value","");
		$respuesta->assign("prov","value","");
		$respuesta->script("cerrar()");
	}
	
	return $respuesta;
}


function Grabar_Proveedor($nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //pasa a mayusculas
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
		$contact = utf8_decode($contact);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    if($nom != "" && $direc != "" && $tel1 != "" && $contact != ""){
		$id = $ClsProv->max_proveedor();
		$id++; /// Maximo codigo de Empresa
		//$respuesta->alert("$id");
		$sql = $ClsProv->insert_proveedor($id,$nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc); /// Inserta Empresa
		//$respuesta->alert("$sql");
		$rs = $ClsProv->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Registros guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("prov","value",$id);
			$respuesta->assign("nit","value",$nit);
			$respuesta->assign("nom","value",$nom);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   
   return $respuesta;
}


function Buscar_Proveedor($nom,$contact){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsProv = new ClsProveedor();
   //pasa a mayusculas
		$nom = trim($nom);
		$contact = trim($contact);
   //--		
   //decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$contact = utf8_decode($contact);
	//--------
	//$respuesta->alert("$nit,$nom,$contact");
    if($nom != "" || $contact != ""){
		$cont = $ClsProv->count_proveedor('','',$nom,$contact);
		if($cont>0){
			$contenido = tabla_lista_proveedores($nom,$contact);
			$respuesta->assign("resultProv","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}


function Listar_Lotes($grup,$art,$suc,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
		//$respuesta->alert("$grup,$art,$fila");
  		$contenido = tabla_lista_lotes($grup,$art,$suc,$fila);
		$respuesta->assign("divArt$fila","innerHTML",$contenido);
		$respuesta->script("cerrar();");
   		
   return $respuesta;
}


function Selecciona_Lote($filas,$lot,$art,$gru){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
		//$respuesta->alert("$contenido");
		$contenido = tabla_lotes_compra($filas,$lot,$art,$gru);
		$respuesta->assign("divLotes","innerHTML",$contenido);
		$respuesta->script("cerrar()");
   		
   return $respuesta;
}


///////////// Suministros y Articulos Propios //////////////////////////////////
function Show_Suministro($cod,$barc,$suc){
   $respuesta = new xajaxResponse();
   $ClsSum = new ClsSuministro();
   //pasa a mayusculas
		$cod = trim($cod);
		$barc = trim($barc);
   //decodificaciones de tildes y Ñ's
		$cod = utf8_decode($cod);
		$barc = utf8_decode($barc);
   //--------
   //$respuesta->alert("$cod,$barc,$suc");
   if($cod != "" || $barc != ""){
		if($cod != ""){
			$chunk = explode("A", $cod);
			$art = $chunk[0]; // articulo
			$gru = $chunk[1]; // grupo
			//valida que los espacios sean numericos
			$art = (is_numeric($art))?$art:0;
			$gru = (is_numeric($gru))?$gru:0;
			$result = $ClsSum->get_articulo($art,$gru,'','','','','','',1,$suc);
		}else{
			$result = $ClsSum->get_articulo('','','','','','','',$barc,1,$suc);
		}
		//inicia la busqueda
		if(is_array($result)){
				foreach($result as $row){
					$art = $row["art_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$art = Agrega_Ceros($art);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $art."A".$gru;
					$respuesta->assign("art","value",$cod);
					$nom = trim($row["art_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["art_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Sbarc","value",$barc);
					$cant = $row["art_cant_suc"];
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					//--
					$prev = $row["art_precio"];
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$prev = number_format($prev, 2, '.', '');
					$respuesta->assign("prev","value",$prev);
					//--
					$prec = $row["art_precio_costo"];
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$prec = number_format($prec, 2, '.', '');
					$respuesta->assign("prec","value",$prec);
					//--
					$prem = $row["art_precio_manufactura"];
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$prem = number_format($prem, 2, '.', '');
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("document.getElementById('cant').focus();");
				
		}else{
			$respuesta->script("abrir()");
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}
		
	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
	}
	
	return $respuesta;
}


function Buscar_Suministro($gru,$nom,$desc,$marca,$suc,$x){
   $respuesta = new xajaxResponse();
   $ClsSum = new ClsSuministro();
	//pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
	//--------
	//$respuesta->alert("$gru,$nom,$desc,$marca,$suc,$x");
    if($gru != "" || $nom != "" || $desc != "" || $marca != ""){
		$cont = $ClsSum->count_articulo('',$gru,$nom,$desc,$marca,'','',$barc,1,$suc);
		if($cont>0){
			$contenido = tabla_lista_suministos($gru,$nom,$desc,$marca,'',$suc,$x);
			$respuesta->assign("resultArt","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}


//////////////////---- COMPRAS -----/////////////////////////////////////////////

function Grid_Fila_Compra_Pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$empresa,$caja,$banco,$cuenta,$tcambiodia){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$empresa,$caja,$banco,$cuenta,$tcambiodia");
   $contenido = tabla_filas_compra_pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$empresa,$caja,$banco,$cuenta,$tcambiodia);
   $respuesta->assign("divPagos","innerHTML",$contenido);  
   $respuesta->script("cerrar()");
   return $respuesta;
}

function Reset_Pago(){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro..");
	$contenido = tabla_inicio_compra_pago(1);
	$respuesta->assign("divPagos","innerHTML",$contenido);  
	for($i = 1; $i <= 6; $i ++){
		$respuesta->assign("spanpago$i","innerHTML","0");  
	}
	return $respuesta;
}


function Grid_Fila_Compra($clase,$suc,$tipo,$reglon,$partida,$detalle,$artcodigo,$cantidad,$precio,$moneda,$tcambio,$tipo_descuento,$descuento){
   $respuesta = new xajaxResponse();
	$ClsComp = new ClsCompra();
   
	if($clase != "" && $suc != "" && $tipo != "" && $reglon != "" && $partida != "" && $cantidad != "" && $precio != "" && $moneda != "" && $tcambio != ""){
		//pasa a mayusculas
		$detalle = trim($detalle);
		//--------
		$chunk = explode("A", $artcodigo);
		$art = $chunk[0]; // articulo
		$art = ($art != "")?$art:0; //-- valida si es servicio devuelve 0
		$grupo = $chunk[1]; // grupo
		$grupo = ($grupo != "")?$grupo:0; //-- valida si es servicio devuelve 0
		//calculos
		$subtotal = ($cantidad * $precio);
		$subtotal = ($cantidad * $precio);
		//valida descuento
		if($tipo_descuento == "P"){
			$monto_descuento = ($subtotal*$descuento)/100;
			$total = $subtotal - $monto_descuento;
		}else if($tipo_descuento == "M"){
			$monto_descuento = $descuento;
			$total = $subtotal - $monto_descuento;
		}else{
			$monto_descuento = 0;
			$total = $subtotal;
		}
		if($monto_descuento <= $subtotal){
			$codigo = $ClsComp->max_detalle_temporal($clase,$suc);
			$codigo++;
			$sql = $ClsComp->insert_detalle_temporal($codigo,$clase,$suc,$tipo,$reglon,$partida,$detalle,$art,$grupo,$cantidad,$precio,$moneda,$tcambio,$subtotal,$monto_descuento,$total);
			$rs = $ClsComp->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$respuesta->script("cerrar();Submit();Limpiar_Campos_Compra();document.getElementById('barc').focus();");
			}else{
				$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else{
			$msj = '<h5>El monto de descuento individual no debe de ser menor que el precio del articulo.</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}else{
		$msj = '<h5>Algunos parametros est&aacute;n vacios...</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	
   return $respuesta;
}

function Quita_Fila_Compra($codigo,$clase,$suc){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	$sql = $ClsComp->delete_item_detalle_temporal($codigo,$clase,$suc);
	$rs = $ClsComp->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script("window.location.reload();");
	}else{
		$msj = '<h5>Error de transacci&oacute;n...</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	return $respuesta;
}



function Editar_Detalle_Temporal($codigo,$clase,$suc,$cantidad,$precio,$moneda,$tcambio,$tipo_descuento,$descuento){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	if($clase != "" && $suc != "" && $cantidad != "" && $precio != "" && $moneda != "" && $tcambio != ""){
		//calculos
		$subtotal = ($cantidad * $precio);
		$subtotal = ($cantidad * $precio);
		//valida descuento
		if($tipo_descuento == "P"){
			$monto_descuento = ($subtotal*$descuento)/100;
			$total = $subtotal - $monto_descuento;
		}else if($tipo_descuento == "M"){
			$monto_descuento = $descuento;
			$total = $subtotal - $monto_descuento;
		}else{
			$monto_descuento = 0;
			$total = $subtotal;
		}
		if($monto_descuento <= $subtotal){
			$sql = $ClsComp->update_item_detalle_temporal($codigo,$clase,$suc,$cantidad,$precio,$moneda,$tcambio,$subtotal,$monto_descuento,$total);
			$rs = $ClsComp->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$respuesta->script("cerrar();Submit();Limpiar_Campos_Compra();document.getElementById('barc').focus();");
			}else{
				$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else{
			$msj = '<h5>El monto de descuento individual no debe de ser menor que el precio del articulo.</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}else{
		$msj = '<h5>Algunos parametros est&aacute;n vacios...</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	
	return $respuesta;
}

function Limpiar_Fila_Compra($clase,$suc){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	//$respuesta->alert("$pv,$suc");
	$sql = $ClsComp->delete_detalle_temporal($clase,$suc);
	$rs = $ClsComp->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script("window.location.reload();");
	}else{
		$msj = '<h5>Error de transacci&oacute;n...</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	return $respuesta;
}



function Importar_Compra($compra,$tipo_pantalla,$suc){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	//$respuesta->alert("$compra,$tipo_pantalla");
		
	$result = $ClsComp->get_compra($compra);
    if(is_array($result)){
      foreach($result as $row){
         $factura_descuento = $row["com_descuento"];
         $Vmond = $row["mon_desc"];
         $Vmons = $row["mon_simbolo"];
         $Vmonc = $row["mon_cambio"];
			$tipo_compra = $row["com_tipo"];
      }
		//$respuesta->alert("$compra, $Vmond, $Vmons, $Vmonc, $factura_descuento, $tipo_compra");
		if($tipo_compra == $tipo_pantalla){
			$result = $ClsComp->get_det_compra('',$compra);
			if(is_array($result)){
				$sql = "";
				$i = 1;
				foreach($result as $row){
					$tipo = $row["dcom_tipo"];
					$reglon = $row["dcom_reglon"];
					$partida = $row["dcom_partida"];
					$descripcion = utf8_decode($row["dcom_detalle"]);
					$art = $row["dcom_articulo"];
					$grupo = $row["dcom_grupo"];
					$cantidad = $row["dcom_cantidad"];
					//Precio U.
					$precio = $row["dcom_precio"];
					$moneda = $row["dcom_moneda"];
					$tcambio = $row["dcom_tcambio"];
					//sub Total
					$subtotal = trim($row["dcom_subtotal"]);
					$descuento = trim($row["dcom_descuento"]);
					$total = trim($row["dcom_total"]);
					$sql.= $ClsComp->insert_detalle_temporal($i,$tipo_compra,$suc,$tipo,$reglon,$partida,$descripcion,$art,$grupo,$cantidad,$precio,$moneda,$tcambio,$subtotal,$descuento,$total);
					$i++;
				}
				$rs = $ClsComp->exec_sql($sql);
				//$respuesta->alert("$sql");
				if($rs == 1){
					$respuesta->script("cerrar();Submit();Limpiar_Campos_Compra();document.getElementById('barc').focus();");
				}else{
					$respuesta->script("cerrar();");
					$respuesta->script('swal("Ups!", "Error de Importaci\u00F3n, limpie el detalle de compra e intente de nuevo...", "warning");');
				}
			}else{
				$msj = '<h5>No se encontraron items a importar de esta compra o gasto...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}	
		}else{
			if($tipo_compra == "G"){
				$msj = '<h5>Este codigo pertenece a un Gasto y debe de ser registrado en dicha pantalla...</h5><br><br>';
			}else{
				$msj = '<h5>Este codigo pertenece a una Compra y debe de ser registrada en dicha pantalla...</h5><br><br>';
			}
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}		  	  
   }else{
		$msj = '<h5>No se registran detalles en esta compra o gasto con este C&oacute;digo!!!</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
   
   return $respuesta;
}




function Importar_Productos_Proveedor($proveedor,$empresa,$tipo_compra){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	
	//$respuesta->alert("$proveedor,$empresa,$tipo_compra,$Vmond,$Vmons,$Vmonc");
	$result = $ClsComp->get_productos_proveedor('',$tipo_compra,'',$proveedor,$empresa);
	if(is_array($result)){
		$sql = "";
		$i = 1;
		foreach($result as $row){
			$tipo = $row["dcom_tipo"];
			$reglon = $row["dcom_reglon"];
			$partida = $row["dcom_partida"];
			$descripcion = utf8_decode($row["dcom_detalle"]);
			$art = $row["dcom_articulo"];
			$grupo = $row["dcom_grupo"];
			$cantidad = $row["dcom_cantidad"];
			//Precio U.
			$precio = $row["dcom_precio"];
			$moneda = $row["dcom_moneda"];
			$tcambio = $row["dcom_tcambio"];
			//sub Total
			$subtotal = trim($row["dcom_subtotal"]);
			$descuento = trim($row["dcom_descuento"]);
			$total = trim($row["dcom_total"]);
			$sql.= $ClsComp->insert_detalle_temporal($i,$tipo_compra,$empresa,$tipo,$reglon,$partida,$descripcion,$art,$grupo,$cantidad,$precio,$moneda,$tcambio,$subtotal,$descuento,$total);
			$i++;
		}
		$rs = $ClsComp->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script("cerrar();Submit();Limpiar_Campos_Compra();document.getElementById('barc').focus();");
		}else{
			$respuesta->script("cerrar();");
			$respuesta->script('swal("Ups!", "Error de Importaci\u00F3n, limpie el detalle de compra e intente de nuevo...", "warning");');
		}
	}else{
		if($tipo_compra == "G"){
			$msj = '<h5>No se registran gastos registrados anteriormente con este proveedor, si ha realizado compras busquelos en la pantalla de "Compras"</h5><br><br>';
		}else{
			$msj = '<h5>No se registran articulos adquiridos anteriormente con este proveedor, si ha realizado gastos busquelos en la pantalla de "Gastos"</h5><br><br>';
		}
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
   
   return $respuesta;
}



function Grabar_Compra($filas,$prov,$class,$ref,$suc,$fec,$subt,$desc,$total,$moneda,$montext,$pagfilas,$arrpagt,$arrmontop,$arrdoc,$arropera,$arrobs,$arrsuc,$arrcaja,$arrban,$arrcue,$pagtotal,$lotTotal,$arrlot,$arrlotart,$arrlotgru){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
   $ClsPag = new ClsPago();
   $ClsArt = new ClsArticulo();
   $ClsCred = new ClsCredito();
	$ClsCaj = new ClsCaja();
	$ClsBan = new ClsBanco();
	$ClsInv = new ClsInventario();
	
   //convierte strig plano en array de compra
		$pagt = explode("|", $arrpagt);
		$montop = explode("|", $arrmontop);
		$doc = explode("|", $arrdoc);
		$opera = explode("|", $arropera);
		$obs = explode("|", $arrobs);
		$cajsuc = explode("|", $arrsuc);
		$caja = explode("|", $arrcaja);
		$banco = explode("|", $arrban);
		$cuenta = explode("|", $arrcue);
	// Manipulacion del texto de moneda para tipo de cambio	
	   $monchunk = explode("/",$montext); 
		$tcamb = trim($monchunk[2]); // Tipo de Cambio
		$tcamb = str_replace("(","",$tcamb); //le quita el primer parentesis que rodea el tipo de cambio
		$tcamb = str_replace(" x 1)","",$tcamb); //le quita el 2do. parentesis y el x 1
		
		$sql = "";
	//------------
	//$respuesta->alert("$filas,$prov,$class,$ref,$suc,$fec,$subt,$desc,$total,$moneda,$montext,$pagfilas,$arrpagt,$arrmontop,$arrdoc,$arropera,$arrobs,$arrsuc,$arrcaja,$arrban,$arrcue,$pagtotal,$lotTotal,$arrlot,$arrlotart,$arrlotgru");
	//$respuesta->alert("$comp,$prov,$class,$ref,$suc,$fec,$subt,$desc,$total,$moneda,$tcamb,$sit");
	if($filas > 0 && $prov != "" && $suc != "" && $ref != "" && $moneda != ""){
		//-- Datos de Venta ($tipo = 'P' PRODUCTO $tipo = 'S' SERVICIO)
		$comp = $ClsComp->max_compra();
		$comp++;
		//Valida la situacion de pago de la factura
		$saldo = trim($total) - trim($pagtotal);
		if($saldo <= 0){
			$sit = 2;
		}else{ $sit = 1; }
		$sql.= $ClsComp->insert_compra($comp,$prov,$class,$ref,$suc,$fec,$subt,$desc,$total,$moneda,$tcamb,$sit);
		$P = 0; // contador de filas con productos para descargar a inventario
		$P+= $ClsComp->count_detalle_temporal($class,$suc,'','P');
		$P+= $ClsComp->count_detalle_temporal($class,$suc,'','U');
		// detalle de venta (traslado de tablas temporales)	
		$sql.= $ClsComp->insert_detalle_desde_temporal($comp,$class,$suc);
		$sql.= $ClsComp->delete_detalle_temporal($class,$suc);
		//--
		$pag = $ClsPag->max_pago_compra();
		$pag++;
		$cred = $ClsCred->max_credito_compra();
		$cred++;
		for($j = 1; $j <= $pagfilas; $j++){
			//pasa a mayusculas
				$Xopera = trim($opera[$j]);
				$Xdoc = trim($doc[$j]);
				$Xobs = trim($obs[$j]);
			//--------
			//decodificaciones de tildes y Ñ's
				$Xopera = utf8_encode($Xopera);
				$Xdoc = utf8_encode($Xdoc);
				$Xobs = utf8_encode($Xobs);
			//--------
				$Xopera = utf8_decode($Xopera);
				$Xdoc = utf8_decode($Xdoc);
				$Xobs = utf8_decode($Xobs);
			//--------
			if($pagt[$j] == 5){
				$sql.= $ClsCred->insert_credito_compra($cred,$comp,$pagt[$j],$montop[$j],$moneda,$tcamb,$Xopera,$Xdoc,$Xobs);
				$cred++;
			}else{
				$sql.= $ClsPag->insert_pago_compra($pag,$comp,$pagt[$j],$montop[$j],$moneda,$tcamb,$Xopera,$Xdoc,$Xobs);
				$pag++;
			}
			//--- descuenta fondos de donde corresponde
			if($pagt[$j] == 1){
				$mcj = $ClsCaj->max_mov_caja($caja[$j],$cajsuc[$j]);
				$mcj++;
				//Query
				$sql.= $ClsCaj->insert_mov_caja($mcj,$caja[$j],$cajsuc[$j],"E",$montop[$j],"C","COMPRA O GASTO EN EFECITVO",$ref,$fec);
				$sql.= $ClsCaj->saldo_caja($caja[$j],$cajsuc[$j],$montop[$j],"-");
			}else if($pagt[$j] == 2){
				$mbn = $ClsBan->max_mov_cuenta($cuenta[$j],$banco[$j]);
				$mbn++;
				$XtipoMov = "TD";
				//Query
				$sql.= $ClsBan->insert_mov_cuenta($mbn,$cuenta[$j],$banco[$j],"E",$montop[$j],"TD","COMPRA O GASTO",$Xdoc,$fec);
				$sql.= $ClsBan->saldo_cuenta_banco($cuenta[$j],$banco[$j],$montop[$j],"-");
			}else if($pagt[$j] == 4){
				$codCheque = $ClsBan->max_cheque($cuenta[$j],$banco[$j]);
				$codCheque++;
				//Query
				$sql.= $ClsBan->insert_cheque($codCheque,$cuenta[$j],$banco[$j],$Xdoc,$montop[$j],$Xobs,"COMPRA O GASTO");
				/////////
			}
		}
		if($lotTotal > 0){
			for($k = 1; $k <= $lotTotal; $k++){
				$lot = explode("|", $arrlot);
				$lotart = explode("|", $arrlotart);
				$lotgru = explode("|", $arrlotgru);
				$costo = ($total/$lotTotal); //divide el precio de la factura entre la cantidad de lotes
				$lotcamb = $ClsInv->get_lote_tcambio($lotart[$k],$lotgru[$k]); // trae el tipo de cambio de la moneda registrada al articulo
				$precosto = Cambio_Moneda($tcamb,$lotcamb,$costo); //precio de costo a aumentar en el tipo de cambio de la moneda del articulo no al cambio de la factura
				$sql.= $ClsInv->insert_costo($lot[$k],$lotart[$k],$lotgru[$k],$comp,$costo,$moneda,$tcamb); // registra el costo al tipo de cambio de la factura
				$sql.= $ClsInv->update_precio_costo($lot[$k],$lotart[$k],$lotgru[$k],$precosto); //actualiza el precio de costo en el tipo de cambio de la moneda del articulo no al cambio de la factura
			}
		}
		$rs = $ClsComp->exec_sql($sql);
		//$respuesta->alert("$P");
		if($rs == 1){
			if($P > 0){ /// cantidad de productos a cargar de inventario
				$msj = '<h5>Compra Registrada # '.$comp.'... ¿Cargar Automaticamente Articulo(s)?...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-default" onclick = "window.location.reload()" ><span class="fa fa-times"></span> Ahora No</button> ';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "CargaJS('.$comp.','.$P.');" ><span class="fa fa-check"></span> Aceptar</button> ';
			}else{
				$msj = '<h5>Compra Registrada Exitosamente...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
			}
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Grabar_Carga($suc,$compra,$prov){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //productos inventariados
   $ClsInv = new ClsInventario();
   $ClsArt = new ClsArticulo();
   //suministros
   $ClsInvSum = new ClsInventarioSuministro();
   $ClsSum = new ClsSuministro();
   //--
   $ClsComp = new ClsCompra();
   //convierte strig plano en array
		$doc = Agrega_Ceros($compra);
		$sql = "";
	//------------
	//$respuesta->alert("$filas,$suc,$doc,$arrtipo,$artcod,$artnom,$cant,$prov,$prec,$prev,$prem,$mon");
	if($suc != "" && $compra != "" && $prov != ""){
		$result = $ClsComp->get_compra($compra);
		if(is_array($result)){
			foreach($result as $row){
				$fec = $row["com_fecha"];
				$fec = cambia_fecha($fec);
			}
			
			/////// PRODUCTOS ////////////
			$result_productos = $ClsComp->get_det_compra_producto("",$compra,"P",0);
			if(is_array($result_productos)){
				$invc = $ClsInv->max_inventario(1); //pide el ultimo codigo de inventario para productos inventariados
				$invc++; //aumenta
				$sql.= $ClsInv->insert_inventario($invc,1,"C",$doc,$suc,$fec,1); //inventario de productos
				$DC = 1;
				foreach($result_productos as $row){
				/// Articulo --
					$art = trim($row["art_codigo"]);
					$grupo = trim($row["art_grupo"]);
					$cant = trim($row["dcom_cantidad"]);
					$prec = trim($row["dcom_precio"]);
					$prev = trim($row["art_precio"]);
					$margen = trim($row["art_margen"]);
					$prem = ($prec + $margen); //precio + margen
					//valida que los espacios sean numericos
					$art = (is_numeric($art))?$art:0;
					$grupo = (is_numeric($grupo))?$grupo:0;
					//Codigo de Lote
					$lote = $ClsArt->max_lote($grupo,$art);
					$lote++;
					//Query
					$sql.= $ClsArt->insert_lote($lote,$grupo,$art,$prov,$suc,$prec,$prev,$prem,$cant);
					$sql.= $ClsInv->insert_det_inventario($DC,$invc,1,$grupo,$art,$lote,$cant);
					$sql.= $ClsComp->cargar_det_compra($doc,1,$art,$grupo);
					$DC++;
				}
				$DC--;
			}
			
			/////// SUMINISTROS ////////////
			$result_suministro = $ClsComp->get_det_compra_suministro("",$compra,"U",0);
			if(is_array($result_suministro)){
				$invs = $ClsInvSum->max_inventario(1); //pide el ultimo codigo de inventario para suministros inventariados
				$invs++; //aumenta
				$sql.= $ClsInvSum->insert_inventario($invs,1,"C",$doc,$suc,$fec,1); //inventario de suministros
				$DS = 1;
				foreach($result_suministro as $row){
				/// Articulo --
					$art = trim($row["art_codigo"]);
					$grupo = trim($row["art_grupo"]);
					$cant = trim($row["dcom_cantidad"]);
					$prec = trim($row["dcom_precio"]);
					$prev = trim($row["art_precio"]);
					$margen = trim($row["art_margen"]);
					$prem = ($prec + $margen); //precio + margen
					//valida que los espacios sean numericos
					$art = (is_numeric($art))?$art:0;
					$grupo = (is_numeric($grupo))?$grupo:0;
					//Codigo de Lote
					$lote = $ClsSum->max_lote($grupo,$art);
					$lote++;
					//Query
					$sql.= $ClsSum->insert_lote($lote,$grupo,$art,$prov,$suc,$prec,$prev,$prem,$cant);
					$sql.= $ClsInvSum->insert_det_inventario($DS,$invs,1,$grupo,$art,$lote,$cant);
					$sql.= $ClsComp->cargar_det_compra($doc,1,$art,$grupo);
					$DS++;
				}
				$DS--;
			}	
		
			$rs = $ClsInv->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$msj = '<h5>Carga Exitosa..! ¿Desea imprimir las etiquetas del C&oacute;digo de Barras?...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-default" onclick = "window.location.reload();" ><span class="fa fa-times"></span> Ahora No</button> ';
				$msj.= '<a class="btn btn-primary" target="_blank" href="CPREPORTES/REPbarcode.php?comp='.$doc.'" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</a> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else{
			$msj = '<h5>Ocurrio un problema durante la carga, porfavor ingrese este registro desde la forma gr&aacute;fica de Bodega-> Carga de Inventario por Compra...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Grabar_Pago($compra,$pagfilas,$arrpagt,$arrmontop,$arrmon,$arrtcamb,$arrdoc,$arropera,$arrobs,$arrsuc,$arrcaja,$arrban,$arrcue,$pagtotal,$facsaldo){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
   $ClsPag = new ClsPago();
	$ClsCaj = new ClsCaja();
	$ClsBan = new ClsBanco();
	
    //convierte strig plano en array de compra
		$pagt = explode("|", $arrpagt);
		$montop = explode("|", $arrmontop);
		$mon = explode("|", $arrmon);
		$tcamb = explode("|", $arrtcamb);
		$doc = explode("|", $arrdoc);
		$opera = explode("|", $arropera);
		$obs = explode("|", $arrobs);
		$cajsuc = explode("|", $arrsuc);
		$caja = explode("|", $arrcaja);
		$banco = explode("|", $arrban);
		$cuenta = explode("|", $arrcue);
		//--
		$fecha = date("d/m/Y");
	//Valida la situacion de pago de la factura
	$saldo = trim($facsaldo) - trim($pagtotal);
	if($saldo <= 0){
		$sql.= $ClsComp->cambia_sit_compra($compra,2);
	}
	//-------
	$pag = $ClsPag->max_pago_compra();
	$pag++;
	$Xcaja = 0;
	$Xsuc = 0;
		for($j = 1; $j <= $pagfilas; $j++){
			//pasa a mayusculas
				$Xopera = trim($opera[$j]);
				$Xdoc = trim($doc[$j]);
				$Xobs = trim($obs[$j]);
			//--------
			//decodificaciones de tildes y Ñ's
				$Xopera = utf8_decode($Xopera);
				$Xdoc = utf8_decode($Xdoc);
				$Xobs = utf8_decode($Xobs);
			//--------
			$sql.= $ClsPag->insert_pago_compra($pag,$compra,$pagt[$j],$montop[$j],$mon[$j],$tcamb[$j],$Xopera,$Xdoc,$Xobs);
			$pag++;
			//--- descuenta fondos de donde corresponde
			if($pagt[$j] == 1){
				if($Xcaja != $caja[$j] && $Xsuc != $cajsuc[$j]){ //valida que pida el codigo de movimiento solo una vez, el resto se va sumando
					$mcj = $ClsCaj->max_mov_caja($caja[$j],$cajsuc[$j]);
					$Xcaja = $caja[$j];
					$Xsuc = $cajsuc[$j]; 
				}
				$mcj++;
				//Query
				$fecha = date("d/m/Y");
				$sql.= $ClsCaj->insert_mov_caja($mcj,$caja[$j],$cajsuc[$j],"E",$montop[$j],"C","COMPRA O GASTO EN EFECITVO",$ref,$fecha);
				$sql.= $ClsCaj->saldo_caja($caja[$j],$cajsuc[$j],$montop[$j],"-");
			}else if($pagt[$j] == 2){
				$mbn = $ClsBan->max_mov_cuenta($cuenta[$j],$banco[$j]);
				$mbn++;
				$XtipoMov = "TD";
				//Query
				$fecha = date("d/m/Y");
				$sql.= $ClsBan->insert_mov_cuenta($mbn,$cuenta[$j],$banco[$j],"E",$montop[$j],"TD","COMPRA O GASTO",$Xdoc,$fecha);
				$sql.= $ClsBan->saldo_cuenta_banco($cuenta[$j],$banco[$j],$montop[$j],"-");
			}else if($pagt[$j] == 4){
				$codCheque = $ClsBan->max_cheque($cuenta[$j],$banco[$j]);
				$codCheque++;
				//Query
				$sql.= $ClsBan->insert_cheque($codCheque,$cuenta[$j],$banco[$j],$Xdoc,$montop[$j],$Xobs,"COMPRA O GASTO");
				/////////
			}
		}
		$rs = $ClsPag->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$msj = '<h5>Pago Registrado...</h5><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	
   return $respuesta;
}


function Buscar_Compra($cod,$doc){
   $respuesta = new xajaxResponse();
    $ClsCred = new ClsCredito();
	$ClsComp = new ClsCompra();
	//$respuesta->alert("$cod,$tipo,$prov,$suc,$doc,$fini,$ffin,$sit");
	$result = $ClsComp->get_compra($cod,"","","",$doc);
	 	if(is_array($result)){
			foreach ($result as $row) {
				$comp = trim($row["com_codigo"]);
				$respuesta->assign("cod","value",$comp);
				$comp = Agrega_Ceros($comp);
				$respuesta->assign("compC","value",$comp);
				$ref = trim($row["com_doc"]);
				$respuesta->assign("ref","value",$ref);
				$factotal = trim($row["com_total"]);
				$monid = trim($row["mon_id"]);
				$montext = trim($row["mon_desc"]);
				$tcambio = trim($row["mon_cambio"]);
				$monsimbolo = trim($row["mon_simbolo"]);
			}
			$credtotal = $ClsCred->total_credito_compra($comp,$tcambio); //pregunta por los creditos que tiene esa compra
			//$respuesta->alert("$credtotal");
			$contenido = tabla_creditos($comp,$montext,$tcambio,$monsimbolo);
			$contenido.= tabla_pagos($comp,$factotal,$credtotal,$monid,$montext,$tcambio,$monsimbolo);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('pagobox').style.display = 'block';");
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
		
   return $respuesta;
}


function Buscar_Historial($cod,$tipo,$prov,$suc,$doc,$fini,$ffin,$sit){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	//$respuesta->alert("$cod,$tipo,$prov,$suc,$doc,$fini,$ffin,$sit");
	$result = $ClsComp->get_compra($cod,$tipo,$prov,$suc,$doc,'',$fini,$ffin,$sit);
	 	if(is_array($result)){
			$contenido = tabla_historial_compra($cod,$tipo,$prov,$suc,$doc,$fini,$ffin,$sit,"H");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("result","innerHTML","");
		}
		
   return $respuesta;
}


function Buscar_Deudas($cod,$tipo,$suc,$doc,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	//$respuesta->alert("$cod,$tipo,$suc,$doc,$fini,$ffin");
	$cont = $ClsComp->count_compra($cod,$tipo,'',$suc,$doc,'',$fini,$ffin);
	 	if($cont > 0){
			$contenido = tabla_creditos_x_pagar($cod,$tipo,$suc,$doc,$fini,$ffin);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("result","innerHTML","");
		}
		
   return $respuesta;
}


function Selecciona_Compra($comp,$fila){
   $respuesta = new xajaxResponse();
    $contenido = tabla_detalle_compra($comp);
    $respuesta->assign("result","innerHTML",$contenido);
	$respuesta->script("cerrar()");
	return $respuesta;
}


function Ejecutar_Credito($cod,$comp){
   $respuesta = new xajaxResponse();
   $ClsCred = new ClsCredito();
	$sql = $ClsCred->cambia_sit_credito_compra($cod,$comp,2);
	$rs = $ClsCred->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$msj = '<h5>Crédito Ejecutado Exitosamente...</h5><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}else{
		$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	return $respuesta;
}



function Cerrar_Detalle($fila){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro..");
	$respuesta->assign("divComp$fila","innerHTML","");
	$respuesta->script("cerrar()");
	return $respuesta;
}


////////// Bancos, Cuentas y Cajas ////////////////

function Combo_Cuenta_Banco($ban,$cue,$scue,$onclick){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$ban,$cue,$scue,$onclick");
	$contenido = cuenta_banco_html($ban,$cue,$onclick);
	$respuesta->assign($scue,"innerHTML",$contenido);
	return $respuesta;
}

function Combo_Caja_Empresa($suc,$caj,$scaj,$onclick){
    $respuesta = new xajaxResponse();
	//$respuesta->alert("$scaj");
	$contenido = caja_sucursal_html($suc,$caj,$onclick);
	$respuesta->assign($scaj,"innerHTML",$contenido);
	return $respuesta;
}

function Last_Cheque($cue,$ban){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
    //$respuesta->alert("$onclick");
	$num = $ClsBan->last_numero_cheque($cue,$ban);
	$num++;
	$num = Agrega_Ceros($num);
	$respuesta->assign("bouch1","value",$num);
	
	return $respuesta;
}


function Valida_Cheque_Pagado($cue,$ban,$cheque){
   $respuesta = new xajaxResponse();
   $ClsBan = new ClsBanco();
    
	$result = $ClsBan->get_cheque('',$cue,$ban,$cheque);
	if(is_array($result)){
		foreach($result as $row){
			$quien = $row["che_quien"];
			$respuesta->assign("obs1","value",$quien);
			$monto = $row["che_monto"];
			$respuesta->assign("montp1","value",$monto);
		}
		$respuesta->assign("obs1","className","form-control");
		$respuesta->assign("montp1","className","form-control");
	}else{
		$respuesta->assign("obs1","value","");
		$respuesta->assign("montp1","value","");
		$respuesta->assign("obs1","className","form-warning");
		$respuesta->assign("montp1","className","form-warning");
		$respuesta->script('swal("Ups!", "Este numero de cheque no existe en el sistema...", "warning");');
	}
	
	return $respuesta;
}


function Buscar_Anulacion($cod,$tipo,$prov,$suc,$doc,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	//$respuesta->alert("$cod,$tipo,$prov,$suc,$doc,$fini,$ffin,$sit");
	$result = $ClsComp->get_compra($cod,$tipo,$prov,$suc,$doc,'',$fini,$ffin);
	 	if(is_array($result)){
			$contenido = tabla_anulacion_compra($cod,$tipo,$prov,$suc,$doc,$fini,$ffin);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("result","innerHTML","");
		}
		
   return $respuesta;
}

function Cambiar_Situacion($comp){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	$sql = $ClsComp->cambia_sit_compra($comp,0);
	$rs = $ClsComp->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script("window.location.reload();");
	}else{
		$respuesta->script("abrir();");
		$msj = '<h5>Error de Conexi&oacute;n...</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	return $respuesta;
}

///////////////////---- ///////////// Partida - Reglon /////////---- ////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Reglon");
$xajax->register(XAJAX_FUNCTION, "Contenido_Detalle_Compra");
//////////////////---- ARTICULOS-PROVEEDORS-VENDEDOR -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Barcode");
$xajax->register(XAJAX_FUNCTION, "Show_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Show_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Grabar_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Buscar_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Show_Vendedor");
$xajax->register(XAJAX_FUNCTION, "Buscar_Vendedor");
$xajax->register(XAJAX_FUNCTION, "UnidadMedida");
$xajax->register(XAJAX_FUNCTION, "Listar_Lotes");
$xajax->register(XAJAX_FUNCTION, "Selecciona_Lote");
//////////////////---- Suministros y Articulos Propios -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Suministro");
$xajax->register(XAJAX_FUNCTION, "Buscar_Suministro");
//////////////////---- COMPRAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Compra_Pago");
$xajax->register(XAJAX_FUNCTION, "Importar_Compra");
$xajax->register(XAJAX_FUNCTION, "Importar_Productos_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Reset_Pago");
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Compra");
$xajax->register(XAJAX_FUNCTION, "Quita_Fila_Compra");
$xajax->register(XAJAX_FUNCTION, "Editar_Detalle_Temporal");
$xajax->register(XAJAX_FUNCTION, "Limpiar_Fila_Compra");
$xajax->register(XAJAX_FUNCTION, "Grabar_Compra");
$xajax->register(XAJAX_FUNCTION, "Grabar_Pago");
$xajax->register(XAJAX_FUNCTION, "Grabar_Carga");
$xajax->register(XAJAX_FUNCTION, "Buscar_Compra");
$xajax->register(XAJAX_FUNCTION, "Buscar_Historial");
$xajax->register(XAJAX_FUNCTION, "Buscar_Deudas");
$xajax->register(XAJAX_FUNCTION, "Selecciona_Compra");
$xajax->register(XAJAX_FUNCTION, "Ejecutar_Credito");
$xajax->register(XAJAX_FUNCTION, "Cerrar_Detalle");
$xajax->register(XAJAX_FUNCTION, "Buscar_Anulacion");
$xajax->register(XAJAX_FUNCTION, "Cambiar_Situacion");
//////////----- Bancos, cuentas y cajas ----------////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Cuenta_Banco");
$xajax->register(XAJAX_FUNCTION, "Combo_Caja_Empresa");
$xajax->register(XAJAX_FUNCTION, "Last_Cheque");
$xajax->register(XAJAX_FUNCTION, "Valida_Cheque_Pagado");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  