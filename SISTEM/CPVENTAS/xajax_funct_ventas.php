<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_ventas.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Punto de Venta - Empresa /////////
function SucPuntVnt($suc,$nom){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
	$contenido = punto_venta_html($suc,$nom,"Submit();");
	//$respuesta->alert("$contenido");
	$respuesta->assign("$nom","innerHTML",$contenido);
	
	return $respuesta;
}


function Producto_Servicio($tipo){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$suc,$nom");
   if($tipo == "S"){
		$contenido = Grupo_Serv_html();
   }else if($tipo == "P"){
		$contenido = Grupo_Art_html();
   }else{
      $contenido = '<select name="gru" id="gru" class = "combo">';
		$contenido.= '<option value="">Seleccione</option>';
		$contenido.='</select>';
   } 
	//$respuesta->alert("$contenido");
	$respuesta->assign("spangru","innerHTML",$contenido);
	
	return $respuesta;
}


///////////// Factura /////////
function Next_Factura($suc,$pv,$ser){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$suc,$nom");
	$ClsFac = new ClsFactura();
	
	if($suc != '' && $pv != '' && $ser != ''){	
		$facNum = $ClsFac->max_factura_base($suc,$pv,$ser);
		if($facNum>0){
			$respuesta->assign("facc","value",$facNum);
		}
	}	
	
	return $respuesta;
}


///////////// ARTICULOS Y CLIENTES //////////////////////////////////
function Show_Barcode($barc,$suc){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsArticulo();
	$ClsSer = new ClsServicio();
	
	//pasa a mayusculas
	$barc = trim($barc);
   //--------
   //$respuesta->alert("$cod,$barc,$suc");
   if($barc != ""){
		$indicador = substr($barc,0,1);
		if($indicador == "A"){
			$chunk = explode("A", $barc);
			$art = $chunk[1]; // articulo
			$gru = $chunk[2]; // grupo
			//valida que los espacios sean numericos
			$art = (is_numeric($art))?$art:0;
			$gru = (is_numeric($gru))?$gru:0;
			//--
			$respuesta->script("TipoVenta('P');");
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
				$respuesta->script("cerrar();");
			}else{
				$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
				$respuesta->assign("art","value","");
				$respuesta->assign("artn","value","");
			}
		}else if($indicador == "S"){
			$chunk = explode("S", $barc);
			$ser = $chunk[1]; // articulo
			$gru = $chunk[2]; // grupo
			//valida que los espacios sean numericos
			$ser = (is_numeric($ser))?$ser:0;
			$gru = (is_numeric($gru))?$gru:0;
			//--
			$respuesta->script("TipoVenta('S');");
			$respuesta->assign("tip","value","S");
			//--
			$result = $ClsSer->get_servicio($ser,$gru,'','','',1);
			if(is_array($result)){
				foreach($result as $row){
					$ser = $row["ser_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$ser = Agrega_Ceros($ser);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $ser."A".$gru;
					$respuesta->assign("Sart","value",$cod); //Selecciona el Combo
					$respuesta->assign("art","value",$cod); //guarada el codigo
					$nom = trim($row["ser_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["ser_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Sbarc","value",$barc);
					$cant = 10000;
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["ser_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["ser_precio_venta"];
					$prev = round($prev, 2);
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$respuesta->assign("prev","value",$prev);
					$prec = $row["ser_precio_costo"];
					$prec = round($prec, 2);
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$respuesta->assign("prec","value",$prec);
					$prem = $row["ser_precio_costo"];
					$prem = round($prem, 2);
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("cerrar();");
			}else{
				$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
				$respuesta->assign("art","value","");
				$respuesta->assign("artn","value","");
			}				
			
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
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
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("cerrar()");
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}
		
	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
		$respuesta->script("cerrar()");
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
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}



function Show_Servicio($cod,$barc){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();
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
			$ser = $chunk[0]; // articulo
			$gru = $chunk[1]; // grupo
			//valida que los espacios sean numericos
			$ser = (is_numeric($ser))?$ser:0;
			$gru = (is_numeric($gru))?$gru:0;
			$result = $ClsSer->get_servicio($ser,$gru,'','','',1);
		}else{
			$result = $ClsSer->get_servicio('','','','',$barc,1);
		}
		//inicia la busqueda
		if(is_array($result)){
				foreach($result as $row){
					$ser = $row["ser_codigo"];
					$gru = $row["gru_codigo"];
					//agrega ceros
					$ser = Agrega_Ceros($ser);
					$gru = Agrega_Ceros($gru);
					//arma el codigo
					$cod = $ser."A".$gru;
					$respuesta->assign("art","value",$cod);
					$nom = trim($row["ser_nombre"]);
					$respuesta->assign("artn","value",$nom);
					$barc = $row["ser_barcode"];
					$barc = ($barc != "")?$barc:"N/A";
					$respuesta->assign("barc","value",$barc);
					$respuesta->assign("Sbarc","value",$barc);
					$cant = 10000;
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["ser_moneda"];
					$respuesta->assign("mon","value",$mon);
					$prev = $row["ser_precio_venta"];
					$prev = round($prev, 2);
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$respuesta->assign("prev","value",$prev);
					$prec = $row["ser_precio_costo"];
					$prec = round($prec, 2);
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$respuesta->assign("prec","value",$prec);
					$prem = $row["ser_precio_costo"];
					$prem = round($prem, 2);
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$respuesta->assign("prem","value",$prem);
				}
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("document.getElementById('mon').setAttribute('disabled','disabled');");
				$respuesta->script("cerrar()");
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}
		
	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
		$respuesta->script("cerrar()");
	}
	
	return $respuesta;
}


function Buscar_Servicio($gru,$nom,$desc){
   $respuesta = new xajaxResponse();
   $ClsSer = new ClsServicio();
	//pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
	//--------
	//$respuesta->alert("$gru,$nom,$desc,$barc,$x");
    if($gru != "" || $nom != "" || $desc != ""){
		$cont = $ClsSer->count_servicio('',$gru,$nom,$desc,'',1);
		//$respuesta->alert("$cont");
		if($cont>0){
			$contenido = tabla_lista_servicios($gru,$nom,$desc);
			$respuesta->assign("resultArt","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
		}
	}
   		
   return $respuesta;
}


function Show_Cliente($nit){
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //$respuesta->alert("$nit");
	if($nit != ""){
		$cont = $ClsCli->count_cliente('',$nit,'');
		if($cont>0){
			$result = $ClsCli->get_cliente('',$nit,'');
			foreach($result as $row){
				$cod = $row["cli_id"];
				$respuesta->assign("cli","value",$cod);
				$nom = utf8_decode($row["cli_nombre"]);
				$respuesta->assign("nom","value",$nom);
				$nit = utf8_decode($row["cli_nit"]);
				$respuesta->assign("nit","value",$nit);
			}
			$respuesta->script("document.getElementById('vcod').focus();");
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>Este Cliente no existe, desea agregarlo?</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-default" onclick = "cerrar();" ><span class="fa fa-times"></span> No</button> ';
			$msj.= '<button type="button" class="btn btn-primary" onclick="NewCliente(\''.$nit.'\');" ><span class="fa fa-check"></span> Si</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("nit","value","");
			$respuesta->assign("nom","value","");
			$respuesta->assign("prov","value","");
		}
	}else{
		$respuesta->assign("nit","value","");
		$respuesta->assign("nom","value","");
		$respuesta->assign("cli","value","");
		$respuesta->script("cerrar()");
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
	//decodificaciones de tildes y Ñ's
		$nom = utf8_encode($nom);
		$direc = utf8_encode($direc);
		//--
		$nom = utf8_decode($nom);
		$direc = utf8_decode($direc);
	//--------
	//pasa a minusculas
		$mail = strtolower($mail);
	//--------
    if($nit != "" && $nom != "" && $direc != ""){
		$id = $ClsCli->max_cliente();
		$id++; /// Maximo codigo de Cliente
		//$respuesta->alert("$id");
		$sql = $ClsCli->insert_cliente($id,$nit,$nom,$direc,$tel1,$tel2,$mail); /// Inserta Cliente
		//$respuesta->alert("$sql");
		$rs = $ClsCli->exec_sql($sql);
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Registros guardados Satisfactoriamente!!!", "success").then((value)=>{ cerrar(); });');
			$respuesta->assign("cli","value",$id);
			$respuesta->assign("nit","value",$nit);
			$respuesta->assign("nom","value",$nom);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
   
   return $respuesta;
}


function Show_Alumno($cui){
   $respuesta = new xajaxResponse();
   $ClsAlu = new ClsAlumno();
	//$respuesta->alert("$cod");
	if($cui != ""){
		$cont = $ClsAlu->count_alumno($cui,$nom,$ape,1);
		//$respuesta->alert("$cont");
		if($cont>0){
			$result = $ClsAlu->get_alumno($cui,$nom,$ape,1);
			foreach($result as $row){
				$cui = $row["alu_cui"];
				$respuesta->assign("vcod","value",$cui);
				$nom = utf8_decode(trim($row["alu_nombre"]))." ".utf8_decode(trim($row["alu_apellido"]));
				$respuesta->assign("vnom","value",$nom);
				//$respuesta->alert("$nom");
			}
			$respuesta->script("cerrar()");
			$respuesta->script("document.getElementById('suc').focus();");
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
			$respuesta->assign("vcod","value","");
			$respuesta->assign("vnom","value","");
		}
	}else{
		$respuesta->assign("vcod","value","");
		$respuesta->assign("vnom","value","");
		$respuesta->script("cerrar()");
	}
	
	return $respuesta;
}

///////////// Unidad de Medida /////////
function UnidadMedida($clase){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$clase");
	$contenido = umedida_html($clase,'umed');
	$respuesta->assign("sumed","innerHTML",$contenido);
	
	return $respuesta;
}

//////////////////---- VENTAS -----/////////////////////////////////////////////

function Grid_Fila_Venta_Pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$tcambiodia){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$tcambiodia");
   $contenido = tabla_filas_venta_pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$tcambiodia);
   $respuesta->assign("divPagos","innerHTML",$contenido);  
   $respuesta->script("cerrar()");
   return $respuesta;
}

function Reset_Pago(){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro..");
	$contenido = tabla_inicio_venta_pago(1);
	$respuesta->assign("divPagos","innerHTML",$contenido);  
	for($i = 1; $i <= 6; $i ++){
		$respuesta->assign("spanpago$i","innerHTML","0");  
	}
	return $respuesta;
}



function Grid_Fila_Venta($pv,$suc,$tipo,$detalle,$artcodigo,$cant,$precio,$moneda,$tcamb,$tipo_descuento,$descuento){
   $respuesta = new xajaxResponse();
	$ClsVent = new ClsVenta();
	//$respuesta->alert("$pv,$suc,$tipo,$detalle,$artcodigo,$cant,$precio,$moneda,$tcamb,$tipo_descuento,$descuento");
	
	if($pv != "" && $suc != "" && $tipo != "" && $cant != "" && $precio != "" && $moneda != "" && $tcamb != ""){
		//pasa a mayusculas
		$detalle = trim($detalle);
		//--------
		$chunk = explode("A", $artcodigo);
		$art = $chunk[0]; // articulo
		$art = ($art != "")?$art:0; //-- valida si es servicio devuelve 0
		$grupo = $chunk[1]; // grupo
		$grupo = ($grupo != "")?$grupo:0; //-- valida si es servicio devuelve 0
		//calculos
		$subtotal = ($cant * $precio);
		$subtotal = ($cant * $precio);
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
			$codigo = $ClsVent->max_detalle_temporal($pv,$suc);
			$codigo++;
			$sql = $ClsVent->insert_detalle_temporal($codigo,$pv,$suc,$tipo,$detalle,$art,$grupo,$cant,$precio,$moneda,$tcamb,$subtotal,$monto_descuento,$total);
			$rs = $ClsVent->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$respuesta->script("cerrar();Submit();Limpiar_Campos_Venta();document.getElementById('barc').focus();");
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}
		}else{
			$respuesta->script('swal("Ups!", "El monto de descuento individual no debe de ser mayor que el precio del articulo.", "warning").then((value)=>{ cerrar(); });');
		}
	}else{
		$respuesta->script('swal("Ups!", "Algunos parametros est&aacute;n vacios...", "warning").then((value)=>{ cerrar(); });');
	}
	
   return $respuesta;
}


function Quita_Fila_Venta($codigo,$pv,$suc){
   $respuesta = new xajaxResponse();
   $ClsVent = new ClsVenta();
	$sql = $ClsVent->delete_item_detalle_temporal($codigo,$pv,$suc);
	$rs = $ClsVent->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script("window.location.reload();");
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	return $respuesta;
}


function Limpiar_Fila_Venta($pv,$suc){
   $respuesta = new xajaxResponse();
   $ClsVent = new ClsVenta();
	//$respuesta->alert("$pv,$suc");
	$sql = $ClsVent->delete_detalle_temporal($pv,$suc);
	$rs = $ClsVent->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script("window.location.reload();");
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	return $respuesta;
}


function Grabar_Venta($filas,$fac,$ser,$facc,$cli,$pv,$suc,$fec,$vend,$subt,$desc,$total,$moneda,$montext,$pagfilas,$arrpagt,$arrmontop,$arrdoc,$arropera,$arrobs,$pagtotal){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsVent = new ClsVenta();
   $ClsPag = new ClsPago();
	$ClsCred = new ClsCredito();
	$ClsVntCred = new ClsVntCredito();
	$ClsFac = new ClsFactura();
	$ClsPV = new ClsPuntoVenta();
	$ClsBan = new ClsBanco();
	$ClsMon = new ClsMoneda();
	
	//$respuesta->alert("$filas,$fac,$ser,$facc,$cli,$pv,$suc,$fec,$vend,$subt,$desc,$total,$moneda,$montext,$pagfilas,$arrpagt,$arrmontop,$arrdoc,$arropera,$arrobs,$pagtotal");
	   
   //convierte strig plano en array de venta
		$pagt = explode("|", $arrpagt);
		$montop = explode("|", $arrmontop);
		$doc = explode("|", $arrdoc);
		$opera = explode("|", $arropera);
		$obs = explode("|", $arrobs);
	// Manipulacion del texto de moneda para tipo de cambio	
		$monchunk = explode("/",$montext); 
		$tcamb = $ClsMon->get_tipo_cambio($moneda); // Tipo de Cambio
		
		$sql = "";
	//------------
	$vend = ($vend != "")?$vend:0; //-- valida si no hay vendedor
	if($filas > 0 && $pagfilas > 0 && $cli != "" && $suc != "" && $pv != "" && $moneda != ""){
		//-- Datos de Venta ($tipo = 'P' PRODUCTO $tipo = 'S' SERVICIO)
		$vent = $ClsVent->max_venta();
		$vent++;
		//Valida la situacion de pago de la factura
		$saldo = trim($total) - trim($pagtotal);
		if($saldo <= 0){
			$sit = 2;
		}else{
			$sit = 1;
		}
		$sql.= $ClsVent->insert_venta($vent,$fac,$cli,$pv,$suc,$fec,$vend,$subt,$desc,$total,$moneda,$tcamb,$sit);
		$P = 0; // contador de filas con productos para descargar a inventario
		$P+= $ClsVent->count_detalle_temporal($pv,$suc,'','P');
		// detalle de venta (traslado de tablas temporales)	
		$sql.= $ClsVent->insert_detalle_desde_temporal($vent,$pv,$suc);
		$sql.= $ClsVent->delete_detalle_temporal($pv,$suc);
		//--
		$pag = $ClsPag->max_pago_venta();
		$pag++;
		$cred = $ClsCred->max_credito_venta();
		$cred++;
		$PCCRED = 0; ///contador de pagos por cobrar a bancos o tarjetas
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
			if($pagt[$j] == 5){
				$sql.= $ClsCred->insert_credito_venta($cred,$vent,$pagt[$j],$montop[$j],$moneda,$tcamb,$Xopera,$Xdoc,$Xobs);
				$cred++;
			}else{
				$sql.= $ClsPag->insert_pago_venta($pag,$vent,$pagt[$j],$montop[$j],$moneda,$tcamb,$Xopera,$Xdoc,$Xobs);
				$pag++;
			}
			//--- acredita fondos a donde corresponde
			if($pagt[$j] == 1){
				$mpv = $ClsPV->max_mov_pv($pv,$suc);
				$mpv++;
				//Query
				$sql.= $ClsPV->insert_mov_pv($mpv,$pv,$suc,"I",$montop[$j],$moneda,$tcamb,"V","VENTA EN EFECITVO","VENT-$vent",$fec);
			}else if($pagt[$j] == 6){
				///OJO EL CODIGO DEL BANCO SE TRANSPORTA EN LA VARIABLE OPERADOR Y EL CODIGO DE LA CUENTA EN LA VARIABLE DOCUMENTO
				$banco = $Xopera;
				$cuenta = $Xdoc;
				$mbn = $ClsBan->max_mov_cuenta($cuenta,$banco);
				$mbn++;
				$XtipoMov = "DP";
				//Query
				$sql.= $ClsBan->insert_mov_cuenta($mbn,$cuenta,$banco,"I",$montop[$j],"DP","VENTA PAGO CON DEPOSITO",'',$fec);
				$sql.= $ClsBan->saldo_cuenta_banco($cuenta,$banco,$montop[$j],"+");
			}else if($pagt[$j] == 2 || $pagt[$j] == 3 || $pagt[$j] == 4){ /// registra los cheques o bouchers por cobrar en banco
				$PCCRED++;
				//Query
				$sql.= $ClsVntCred->insert_cobro_creditos($PCCRED,$vent,$montop[$j],$moneda,$tcamb,$pagt[$j],$Xopera,$Xdoc,$Xobs,$fec);
				//$respuesta->alert("$mbn,$vent,$montop[$j],$moneda,$tcamb,$pagt[$j],$Xopera,$Xdoc,$Xobs");
			}
		}
		//---- FACTURA ---
		if($fac == 1){ // si se genera factura
			$existe = $ClsFac->comprueba_factura($facc,$ser);
			if($existe){ ///valida que el numero de factura no exista
				$respuesta->assign("ser","className","form-warning");
				$respuesta->assign("facc","className","form-warning");
				$respuesta->script('swal("Alto!", "Este n\u00FAmero de factura ya existe registrado en el sistema...", "warning").then((value)=>{ cerrar(); });');
				return $respuesta;
			}else{	
				$sql.= $ClsFac->insert_factura($facc,$ser,$fec);
				$sql.= $ClsFac->insert_factura_venta($facc,$ser,$vent);
				$sql.= $ClsFac->modifica_fac_base($pv,$suc,$ser,$facc);
			}
		}
		$rs = $ClsVent->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			if($P > 0){ ///cantidad de productos a descargar
				$usucod = $_SESSION["codigo"];
				$hashkey1 = $ClsFac->encrypt($ser, $usucod);
				$hashkey2 = $ClsFac->encrypt($facc, $usucod);
				//--
				$msj = '<h5>Venta  # '.$vent.' Registrada... ¿Descargar Automaticamente Articulo(s)?...</h5><br><br>';
				if($fac == 1){ // si se genera factura
				$msj.= '<a class="btn btn-default" target="_blank" href = "CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" onclick = "window.location.reload();" ><span class="fa fa-check"></span> No Ahora</a> ';
				}else{
				$msj.= '<a class="btn btn-default" href = "#" onclick = "window.location.reload();" ><span class="fa fa-check"></span> No Ahora</a> ';
				}
				$msj.= '<button type="button" class="btn btn-primary" onclick = "DescargaJS('.$vent.','.$P.');" ><span class="fa fa-check"></span> Aceptar</button> ';
				
			}else{
				$usucod = $_SESSION["codigo"];
				$hashkey1 = $ClsFac->encrypt($ser, $usucod);
				$hashkey2 = $ClsFac->encrypt($facc, $usucod);
				//--
				$msj = '<h5>Venta  # '.$vent.' Registrada Exitosamente...</h5><br><br>';
				if($fac == 1){ // si se genera factura
				$msj.= '<a class="btn btn-success" target="_blank" href = "CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</a> ';
				}else{
				$msj.= '<a class="btn btn-success" href = "#" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</a> ';
				}
			}
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
	
   return $respuesta;
}


function Grabar_Descarga($suc,$clase,$venta){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsInv = new ClsInventario();
   $ClsArt = new ClsArticulo();
   $ClsVen = new ClsVenta();
   
	if($suc != "" && $clase != "" && $venta != ""){
		$result = $ClsVen->get_venta($venta);
		if(is_array($result)){
			foreach($result as $row){
				$fecventa = $row["ven_fecha"];
				$fecventa = cambia_fecha($fecventa);
				$serventa = $row["ven_ser_codigo"];
				$faccventa = $row["ven_fac_numero"];
			}
		}	
		
		$doc = Agrega_Ceros($venta);
		
		$result = $ClsVen->get_det_venta_producto("",$venta,"P",0);
		if(is_array($result)){
			//-- Datos de Inventario ($tipo = 2 // Egreso a inventario)
			$invc = $ClsInv->max_inventario(2);
			$invc++; 
			$sql.= $ClsInv->insert_inventario($invc,2,$clase,$doc,$suc,$fecventa,1);
			$jx = 0; // valida las vueltas con producto
			// Inicia el Ciclo de filas	
			foreach ($result as $row){
				/// Articulo --
				$art = $row["art_codigo"];
				$grup = $row["art_grupo"];
				//valida que los espacios sean numericos
				$art = (is_numeric($art))?$art:0;
				$grup = (is_numeric($grup))?$grup:0;
				//Query
				$cant = $row["dven_cantidad"];
				$necesita = $cant;
				//$respuesta->alert("Necesita: $necesita");
				$hay = 0;
				$toma = 0;
				$falta = 0;
				$deja = 0;
				$result_lotes = $ClsArt->descargar_lote($grup,$art,$suc);
				if(is_array($result_lotes)){
					$j = 1;
					foreach($result_lotes as $row_lote){
						$hay = $row_lote["lot_cantidad"];
						$lote = $row_lote["lot_codigo"];
						//$respuesta->alert("en el lote $lote : vuelta $i");
						if($hay >= $necesita){
							//$respuesta->alert("hay mas que los que se necesita");
							$toma = $necesita;
							//$respuesta->alert("toma $toma");
							$sobra = $hay - $necesita;
							//$respuesta->alert("sobran $sobra");
							$sql.= $ClsArt->cantidad_lote($lote,$grup,$art,$toma,"-");
							$sql.= $ClsInv->insert_det_inventario($jx,$invc,2,$grup,$art,$lote,$toma);
							$sql.= $ClsVen->descargar_det_venta($venta,1,$art,$grup);
							$j++;//aumenta el numero de detalle en el inventario
							$jx++;
							break;
						}else if($hay < $necesita){
							//$respuesta->alert("hay menos que los que se necesita");
							$toma = $hay;
							//$respuesta->alert("toma $toma");
							$falta = $necesita - $hay;
							//$respuesta->alert("faltan $falta");
							$necesita = $falta;
							//$respuesta->alert("ahora necesita $necesita");
							$sql.= $ClsArt->cantidad_lote($lote,$grup,$art,$toma,"-");
							$sql.= $ClsInv->insert_det_inventario($jx,$invc,2,$grup,$art,$lote,$toma);
							$sql.= $ClsVen->descargar_det_venta($venta,1,$art,$grup);
							$j++;//aumenta el numero de detalle en el inventario
							$jx++;
						}
					}
				}
			}
			//$respuesta->alert("$sql");
			if($jx > 0){
				$rs = $ClsInv->exec_sql($sql);
				//$respuesta->alert("$sql");
				if($rs == 1){
					$msj = '<h5>Descarga Exitosa...</h5><br><br>';
					if($serventa != "" && $faccventa != ""){
						$usucod = $_SESSION["codigo"];
						$hashkey1 = $ClsInv->encrypt($serventa, $usucod);
						$hashkey2 = $ClsInv->encrypt($faccventa, $usucod);
						$msj.= '<a class="btn btn-success" target="_blank" href = "CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</a> ';
					}else{
						$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
					}
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}else{
					$msj = '<h5>Ocurrio un problema durante la descarga, porfavor ingrese este registro desde la forma gr&aacute;fica de Bodega-> Descarga de Inventario por Venta...</h5><br><br>';
					if($serventa != "" && $faccventa != ""){
						$usucod = $_SESSION["codigo"];
						$hashkey1 = $ClsInv->encrypt($serventa, $usucod);
						$hashkey2 = $ClsInv->encrypt($faccventa, $usucod);
						$msj.= '<a class="btn btn-success" target="_blank" href = "CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</a> ';
					}else{
						$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
					}
					$respuesta->assign("lblparrafo","innerHTML",$msj);
				}
			}else{
				$msj = '<h5>No hay articulos de inventario para descargar en esta venta...</h5><br><br>';
				if($serventa != "" && $faccventa != ""){
					$usucod = $_SESSION["codigo"];
					$hashkey1 = $ClsInv->encrypt($serventa, $usucod);
					$hashkey2 = $ClsInv->encrypt($faccventa, $usucod);
					$msj.= '<a class="btn btn-success" target="_blank" href = "CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</a> ';
				}else{
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
				}
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else{
			$msj = '<h5>No hay articulos de inventario pendientes de descargar en esta venta...</h5><br><br>';
			if($serventa != "" && $faccventa != ""){
				$usucod = $_SESSION["codigo"];
				$hashkey1 = $ClsInv->encrypt($serventa, $usucod);
				$hashkey2 = $ClsInv->encrypt($faccventa, $usucod);
				$msj.= '<a class="btn btn-success" target="_blank" href = "CPREPORTES/REPfactura.php?hashkey1='.$hashkey1.'&hashkey2='.$hashkey2.'" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</a> ';
			}else{
					$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			}
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}	
	}
	
   return $respuesta;
}


function Grabar_Pago($vent,$suc,$pv,$pagfilas,$arrpagt,$arrmontop,$arrmon,$arrtcambio,$arrdoc,$arropera,$arrobs){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
		$ClsPag = new ClsPago();
		$ClsCred = new ClsCredito();
		$ClsVntCred = new ClsVntCredito();
		$ClsPV = new ClsPuntoVenta();
		$ClsBan = new ClsBanco();
	
    //convierte strig plano en array de venta
		$pagt = explode("|", $arrpagt);
		$montop = explode("|", $arrmontop);
		$moneda = explode("|", $arrmon);
		$tcamb = explode("|", $arrtcambio);
		$doc = explode("|", $arrdoc);
		$opera = explode("|", $arropera);
		$obs = explode("|", $arrobs);
	// Manipulacion del texto de moneda para tipo de cambio	
		
	$sql = "";
   $pag = $ClsPag->max_pago_venta();
	$pag++;
	$PCCRED = 0; ///contador de pagos por cobrar a bancos o tarjetas
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
				//--
				$Xopera = utf8_decode($Xopera);
				$Xdoc = utf8_decode($Xdoc);
				$Xobs = utf8_decode($Xobs);
			//--------
			if($pagt[$j] == 5){
				$sql.= $ClsCred->insert_credito_venta($pag,$vent,$pagt[$j],$montop[$j],$moneda[$j],$tcamb[$j],$Xopera,$Xdoc,$Xobs);
			}else{
				$sql.= $ClsPag->insert_pago_venta($pag,$vent,$pagt[$j],$montop[$j],$moneda[$j],$tcamb[$j],$Xopera,$Xdoc,$Xobs);
				$pag++;
			}
			//--- acredita fondos a donde corresponde
			if($pagt[$j] == 1){
				$mpv = $ClsPV->max_mov_pv($pv,$suc);
				$mpv++;
				//Query
				$fecha = date("d/m/Y");
				$sql.= $ClsPV->insert_mov_pv($mpv,$pv,$suc,"I",$montop[$j],$moneda[$j],$tcamb[$j],"V","Pago de Crédito","CRED-$mpv",$fecha);
			}else if($pagt[$j] == 6){
				///OJO EL CODIGO DEL BANCO SE TRANSPORTA EN LA VARIABLE OPERADOR Y EL CODIGO DE LA CUENTA EN LA VARIABLE DOCUMENTO
				$banco = $Xopera;
				$cuenta = $Xdoc;
				$mbn = $ClsBan->max_mov_cuenta($cuenta,$banco);
				$mbn++;
				$XtipoMov = "DP";
				//Query
				$fecha = date("d/m/Y");
				$sql.= $ClsBan->insert_mov_cuenta($mbn,$cuenta,$banco,"I",$montop[$j],"DP","Venta, Pago con Deposito",'',$fecha);
				$sql.= $ClsBan->saldo_cuenta_banco($cuenta,$banco,$montop[$j],"+");
			}else if($pagt[$j] == 2 || $pagt[$j] == 3 || $pagt[$j] == 4){ /// registra los cheques o bouchers por cobrar en banco
				$PCCRED++;
				//Query
            $fecha = date("d/m/Y");
				$sql.= $ClsVntCred->insert_cobro_creditos($PCCRED,$vent,$montop[$j],$moneda[$j],$tcamb[$j],$pagt[$j],$Xopera,$Xdoc,$Xobs,$fecha);
			}
		}
		$rs = $ClsPag->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Pago Registrado Exitosamente...", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
		
   return $respuesta;
}


function Buscar_Venta($vent,$ser,$facc){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
   $ClsCred = new ClsCredito();
	//$respuesta->alert("$vent,$ser,$facc");
	//valida si la venta tiene factura o no...
	if($vent != ""){
		$result = $ClsVent->get_venta($vent);
	}else{
		$result = $ClsFac->get_factura($facc,$ser,$vent);
	}
    	if(is_array($result)){
			foreach ($result as $row) {
				$vent = trim($row["ven_codigo"]);
				$respuesta->assign("ventC","value",$vent);
				$vent = Agrega_Ceros($vent);
				$respuesta->assign("vent","value",$vent);
				$ser = trim($row["fac_serie"]);
				$respuesta->assign("ser","value",$ser);
				$facc = trim($row["fac_numero"]);
				$respuesta->assign("facc","value",$facc);
				$factotal = trim($row["ven_total"]);
				$monid = trim($row["mon_id"]);
				$montext = trim($row["mon_desc"]);
				$tcambio = trim($row["mon_cambio"]);
				$monsimbolo = trim($row["mon_simbolo"]);
			}
			$credtotal = $ClsCred->total_credito_venta($vent,$tcambio); //pregunta por los creditos que tiene esa venta 
			$contenido = tabla_creditos($vent,$montext,$tcambio,$monsimbolo);
			$contenido.= tabla_pagos($vent,$factotal,$credtotal,$monid,$montext,$tcambio,$monsimbolo);
			//$respuesta->alert("$vent,$factotal,$montext,$tcambio,$monsimbolo");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('pagobox').style.display = 'block';");
			$respuesta->script("document.getElementById('sucbox').style.display = 'block';");
			$respuesta->script("cerrar()");
		}else{
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
		}
		
   return $respuesta;
}




function Buscar_Historial($suc,$pv,$ser,$facc,$fini,$ffin,$cfac,$sit){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
	//valida si la venta tiene factura o no...
	$fac = ($cfac == 2)?0:$cfac;
	//$respuesta->alert("$ser,$facc");
	if($ser != "" && $facc != ""){
		$result = $ClsFac->get_factura($facc,$ser);
		if(is_array($result)){
			foreach ($result as $row) {
				$vent = trim($row["ven_codigo"]);
			}
		}
	}
	$result = $ClsVent->get_venta($vent,'',$pv,$suc,'','',$fini,$ffin,$cfac,$sit);
	if(is_array($result)){
		//$respuesta->alert("$vent");
		$contenido = tabla_historial_venta($vent,$suc,$pv,$ser,$facc,$fini,$ffin,$cfac,$sit,"H");
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar()");
	}else{
		$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
		$respuesta->assign("result","innerHTML","");
	}
		
   return $respuesta;
}


function Buscar_Anulacion($suc,$pv,$ser,$facc,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
	//valida si la venta tiene factura o no...
	$fac = ($cfac == 2)?0:$cfac;
	//$respuesta->alert("$ser,$facc");
	if($ser != "" && $facc != ""){
		$result = $ClsFac->get_factura($facc,$ser);
		if(is_array($result)){
			foreach ($result as $row) {
				$vent = trim($row["ven_codigo"]);
			}
		}
	}
	$result = $ClsVent->get_venta($vent,'',$pv,$suc,'','',$fini,$ffin);
	if(is_array($result)){
		//$respuesta->alert("$vent");
		$contenido = tabla_anulacion_venta($vent,$suc,$pv,$ser,$facc,$fini,$ffin);
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("cerrar()");
	}else{
		$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
		$respuesta->assign("result","innerHTML","");
	}
		
   return $respuesta;
}


function Buscar_Deudas($suc,$tipo,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
	///------	
	if($tipo == 0){
		$contenido .= tabla_cuentas_x_cobrar($vent,$suc,'',$fini,$ffin);
		$contenido .= tabla_creditos_x_cobrar($vent,$suc,$fini,$ffin);
	}else if($tipo == 5){
		$contenido = tabla_creditos_x_cobrar($vent,$suc,$fini,$ffin);
	}else if($tipo == 4){
		$contenido = tabla_cuentas_x_cobrar($vent,$suc,4,$fini,$ffin);
	}else if($tipo == 2){
		$contenido = tabla_cuentas_x_cobrar($vent,$suc,'',$fini,$ffin);
	}
	$respuesta->assign("result","innerHTML",$contenido);
	$respuesta->script("cerrar()");

   return $respuesta;
}


function Selecciona_Venta($vent,$fila){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$inv,$tipo,$fila");
	$contenido = tabla_detalle_venta($vent);
	$respuesta->assign("result","innerHTML",$contenido);
	$respuesta->script("cerrar()");
	return $respuesta;
}



function Modificar_Credito($cod,$opera,$doc,$obs){
   $respuesta = new xajaxResponse();
   $ClsCred = new ClsCredito();
	//pasa a mayusculas
		$opera = trim($opera);
		$doc = trim($doc);
		$obs = trim($obs);
	//--------
	//decodificaciones de tildes y Ñ's
		$opera = utf8_encode($opera);
		$doc = utf8_encode($doc);
		$obs = utf8_encode($obs);
	//--
		$opera = utf8_decode($opera);
		$doc = utf8_decode($doc);
		$obs = utf8_decode($obs);
	//--------
	//$respuesta->alert("$cod,$opera,$doc,$obs");
	if($cod != "" && $opera != "" && $doc != ""){
		$sql = $ClsCred->update_credito_venta($cod,$opera,$doc,$obs);
		$rs = $ClsCred->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$respuesta->script('swal("Excelente!", "Cr\u00E9dito Modificado Exitosamente...", "success").then((value)=>{ window.location.reload(); });');
		}else{
			$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
		}
	}
	return $respuesta;
}


function Ejecutar_Credito($cod,$vent){
   $respuesta = new xajaxResponse();
   $ClsCred = new ClsCredito();
	$sql = $ClsCred->cambia_sit_credito_venta($cod,$vent,2);
	$rs = $ClsCred->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script('swal("Excelente!", "Cr\u00E9dito Ejecutado Exitosamente...", "success").then((value)=>{ window.location.reload(); });');
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	return $respuesta;
}


function Ejecutar_Cheque_Tarjeta($cue,$ban,$suc,$caja,$tipo,$monto,$doc,$filas,$arrccue,$arrvent){
   $respuesta = new xajaxResponse();
   $ClsVntCred = new ClsVntCredito();
   $ClsBan = new ClsBanco();
   $ClsCaj = new ClsCaja();
   //convierte strig plano en array de venta
      $ccue = explode("|", $arrccue);
      $vent = explode("|", $arrvent);
      if($tipo == 1){
      	$cod = $ClsBan->max_mov_cuenta($cue,$ban);
			$cod++;
			$fecha = date("d/m/Y");
			$sql = $ClsBan->insert_mov_cuenta($cod,$cue,$ban,"I",$monto,"DP","Deposito por ejecucion de cuentas por cobrar",$doc,$fecha);
			$sql.= $ClsBan->saldo_cuenta_banco($cue,$ban,$monto,"+");
      }else if($tipo == 2){
			$cod = $ClsCaj->max_mov_caja($caja,$suc);
			$cod++;
			$fecha = date("d/m/Y");
			$sql.= $ClsCaj->insert_mov_caja($cod,$caja,$suc,"I",$monto,"DP","Deposito por ejecucion de cuentas por cobrar",$doc,$fecha);
			$sql.= $ClsCaj->saldo_caja($caja,$suc,$monto,"+");
      }
      for($i = 1; $i <= $filas; $i++){
			$sql.= $ClsVntCred->ejecuta_cobro_creditos($ccue[$i],$vent[$i],2);
      }
	$rs = $ClsVntCred->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script('swal("Excelente!", "Cobro(s) Ejecutado(s) Exitosamente...", "success").then((value)=>{ window.location.reload(); });');
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	return $respuesta;
}



function Cambiar_Situacion($vent,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsVen = new ClsVenta();
	$ClsPag = new ClsPago();
	$ClsPVenta = new ClsPuntoVenta();
	$ClsCred = new ClsCredito();
	$ClsVntCred = new ClsVntCredito();
	
	
	$sql = $ClsVen->cambia_sit_venta($vent,0);
	$sql.= $ClsVen->devuelve_producto_venta($vent);
	$sql.= $ClsPag->cambia_sit_pago_venta($vent);
	$sql.= $ClsVntCred->delete_cobro_creditos($vent);
	$sql.= $ClsCred->delete_credito_venta($vent);
	
	$result = $ClsVen->get_venta($vent);
	if(is_array($result)){
		foreach($result as $row){
			$pv = $row["ven_pventa"];
			$suc = $row["ven_sucursal"];
		}
	}
   
	$result = $ClsPag->get_pago_venta('',$vent);
	if(is_array($result)){
		foreach($result as $row){
			$tipo = $row["pag_tipo_pago"];
			$monto = $row["pag_monto"];
			$moneda = $row["pag_moneda"];
			$tcamb = $row["pag_tcambio"];
			$fecha = date("d/m/Y");
			if($tipo == 1){
				$mpv = $ClsPVenta->max_mov_pv($pv,$suc);
				$mpv++;
				$sql.= $ClsPVenta->insert_mov_pv($mpv,$pv,$suc,"E",$monto,$moneda,$tcamb,"RT","ANULACION DE FACTURA","S/N",$fecha);
			}
		}
	}
	
	$rs = $ClsVen->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$respuesta->script('swal("Venta Anulada...", "", "").then((value)=>{ window.location.reload(); });');
	}else{
		$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
	}
	return $respuesta;
}


function Cerrar_Detalle($fila){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro..");
	$respuesta->assign("divVent$fila","innerHTML","");
	$respuesta->script("cerrar()");
	return $respuesta;
}


//////////////////---- Factura -----/////////////////

function Buscar_Factura($suc,$pv,$ser,$facc,$fini,$ffin,$tipo){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
	//valida si la venta tiene factura o no...
	//$respuesta->alert("$ser,$facc");
	 if($ser != "" && $facc != ""){
		$result = $ClsFac->get_factura($facc,$ser);
		if(is_array($result)){
			foreach ($result as $row) {
				$vent = trim($row["ven_codigo"]);
			}
		}
	 }
	 //$respuesta->alert("$vent");
		$result = $ClsVent->get_venta($vent,'',$pv,$suc,'','',$fini,$ffin,$cfac,$sit);
		if(is_array($result)){
			//$respuesta->alert("$vent");
			$contenido = tabla_reimpresion($vent,$suc,$pv,$fini,$ffin,$tipo);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			//$respuesta->alert("no entro");
			$respuesta->script('swal("", "No se registran datos con estos criterios de busqueda!!!", "error").then((value)=>{ cerrar(); });');
			$respuesta->assign("result","innerHTML","");
		}
		
   return $respuesta;
}


function Seleccionar_Factura($vent){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
	//valida si la venta tiene factura o no...
	//$respuesta->alert("$vent");
	 if($vent){
		$result = $ClsVent->get_venta($vent);
		if(is_array($result)){
			foreach ($result as $row) {
				$vent = trim($row["ven_codigo"]);
				$respuesta->assign("vent","value",$vent);
				$factura = trim($row["ven_factura"]);
				$respuesta->assign("facven","value",$factura);
			}
		}
	 }
	 if($factura == 1){
		$result = $ClsFac->get_factura('','',$vent);
		if(is_array($result)){
			foreach ($result as $row) {
				$serie = trim($row["ser_codigo"]);
				$respuesta->assign("ser","value",$serie);
				$respuesta->assign("ser3","value",$serie);
				$facnum = trim($row["fac_numero"]);
				$respuesta->assign("facc","value",$facnum);
				$respuesta->assign("facc3","value",$facnum);
			}
		}
	    $respuesta->script("document.getElementById('mod').className = 'btn btn-primary';");	
	 }else{
	    $respuesta->script("document.getElementById('gra').className = 'btn btn-primary';");	
	 }
      $suc = $_SESSION["empresa"];
      $respuesta->assign("suc","value",$suc);
      $pv = $_SESSION["cajapv"];
      $respuesta->assign("pv","value",$pv);
      //--
      $contenido = tabla_reimpresion($vent,'','','','','');
      $respuesta->assign("result","innerHTML",$contenido);
      //--
      $respuesta->script("document.getElementById('busc').className = 'btn btn-primary hidden';");
      
      
   return $respuesta;
}


function Grabar_Nueva_Factura($vent,$seract,$facact,$suc,$pv){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
   $fec = date("d/m/Y");
   //$respuesta->alert("$vent,$seract,$facact,$suc,$pv");
   $result = $ClsFac->get_factura($facact,$seract);
      if(!is_array($result)){
			//---- FACTURA ---
			$sql.= $ClsFac->pone_factura($vent);
			$sql.= $ClsFac->insert_factura($facact,$seract,$fec);
			$sql.= $ClsFac->insert_factura_venta($facact,$seract,$vent);
			$sql.= $ClsFac->modifica_fac_base($pv,$suc,$seract,$facact);
			$rs = $ClsFac->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				  $respuesta->script("ReprintOriginal($vent);");
				  $respuesta->redirect("FRMprintoriginal.php",2);
			}else{
				  $respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}
      }else{
			$respuesta->script('swal("Error", "Esta Serie y Numero ya fueron impresas en otra factura... Utilize un nuevo numero", "error").then((value)=>{ cerrar(); });');
      }
   return $respuesta;
}


function Modificar_Factura($vent,$seract,$facact,$serante,$facante,$suc,$pv){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsFac = new ClsFactura();
    $fec = date("d/m/Y");
    //$respuesta->alert("$vent,$seract,$facact,$serante,$facante,$suc,$pv");
      //---- FACTURA ---
   if(($facact == $facante) && ($seract == $serante)){
		$msj = '<h5>Va a Imprimir con el mismo N&uacute;mero?</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-default" onclick = "cerrar();" ><span class="fa fa-times"></span> Cancelar</button> ';
		$msj.= '<button type="button" class="btn btn-primary" onclick="ReprintOriginal('.$vent.');window.location=\'FRMprintoriginal.php\';" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
   }else{
      $result = $ClsFac->get_factura($facact,$seract);
      if(!is_array($result)){
			//---- FACTURA ---
			$sql.= $ClsFac->cambia_sit_factura($facante,$serante,0);
			$sql.= $ClsFac->insert_factura($facact,$seract,$fec);
			$sql.= $ClsFac->insert_factura_venta($facact,$seract,$vent);
			$sql.= $ClsFac->modifica_fac_base($pv,$suc,$seract,$facact);
			$rs = $ClsFac->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$respuesta->script("ReprintOriginal($vent)");
				$respuesta->redirect("FRMprintoriginal.php",2);
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}
      }else{
	    $respuesta->script('swal("Error", "Esta Serie y Numero ya fueron impresas en otra factura... Utilize un nuevo numero", "error").then((value)=>{ cerrar(); });');
      }
   }
	
   return $respuesta;
}



function Grabar_Factura_Anteriores($filas,$ventas,$cliente,$seriesanula,$numerosanula,$fecha,$serie,$numero,$suc,$pv){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
	$ClsVent = new ClsVenta();
   //$respuesta->alert("$filas,$ventas,$seriesanula,$numerosanula,$fecha,$serie,$numero,$suc,$pv");
   
   if($ventas != "" && $cliente != "" && $serie != "" && $numero != ""){
		$result = $ClsFac->get_factura($numero,$serie);
      if(!is_array($result)){
			//---- FACTURA ---
			$sql.= $ClsFac->insert_factura($numero,$serie,$fecha);
			$sql.= $ClsFac->modifica_fac_base($pv,$suc,$serie,$numero);
			//---- VENTAS - FACTURA ---///	
			$arrventas = explode("|", $ventas);
			$arrseranul = explode("|", $seriesanula);
			$arrnumanul = explode("|", $numerosanula);
			for($i = 1; $i <= $filas; $i++){
				$vent = $arrventas[$i];
				$seranul = trim($arrseranul[$i]);
				$numanul = trim($arrnumanul[$i]);
				if($seranul != "" && $numanul != ""){
					$sql.= $ClsFac->cambia_sit_factura($numanul,$seranul,0);
				}
				$sql.= $ClsFac->insert_factura_venta($numero,$serie,$vent);
				$sql.= $ClsFac->pone_factura($vent);
				$sql.= $ClsVent->cambia_cliente_venta($vent,$cliente);
			}
			
			$rs = $ClsFac->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$usucod = $_SESSION["codigo"];
				$hashkey1 = $ClsFac->encrypt($serie, $usucod);
				$hashkey2 = $ClsFac->encrypt($numero, $usucod);
				$respuesta->script("window.open('CPREPORTES/REPfactura.php?hashkey1=$hashkey1&hashkey2=$hashkey2', '_blank');");
				$respuesta->redirect("FRMfacturarventas.php",0);
			}else{
				$respuesta->script('swal("Error", "Error en la transacci\u00F3n", "error").then((value)=>{ cerrar(); });');
			}
		}else{
			$respuesta->script('swal("Error", "Esta Serie y Numero ya fueron impresas en otra factura... Utilize un nuevo numero", "error").then((value)=>{ cerrar(); });');
      }
   }
	
   return $respuesta;
}


////////// Bancos, Cuentas y Cajas ////////////////

function Combo_Cuenta_Banco($ban,$cue,$scue,$onclick){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$onclick");
	$contenido = cuenta_banco_html($ban,$cue,$onclick);
	$respuesta->assign($scue,"innerHTML",$contenido);
	return $respuesta;
}

function Combo_Caja_Empresa($suc,$caj,$scaj,$onclick){
   $respuesta = new xajaxResponse();
	//$respuesta->alert("$scaj");
	$contenido = Caja_Empresa_html($suc,$caj,$onclick);
	$respuesta->assign($scaj,"innerHTML",$contenido);
	return $respuesta;
}

///////////////////---- Punto de Venta - Empresa---- ////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "SucPuntVnt");
$xajax->register(XAJAX_FUNCTION, "Next_Factura");
//////////////////---- ARTICULOS-CLIENTES-VENDEDOR -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Barcode");
$xajax->register(XAJAX_FUNCTION, "Show_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Show_Servicio");
$xajax->register(XAJAX_FUNCTION, "Buscar_Servicio");
$xajax->register(XAJAX_FUNCTION, "Show_Cliente");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Show_Alumno");
$xajax->register(XAJAX_FUNCTION, "UnidadMedida");
//////////////////---- VENTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Venta_Pago");
$xajax->register(XAJAX_FUNCTION, "Reset_Pago");
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Venta");
$xajax->register(XAJAX_FUNCTION, "Quita_Fila_Venta");
$xajax->register(XAJAX_FUNCTION, "Limpiar_Fila_Venta");
$xajax->register(XAJAX_FUNCTION, "Grabar_Venta");
$xajax->register(XAJAX_FUNCTION, "Grabar_Pago");
$xajax->register(XAJAX_FUNCTION, "Grabar_Descarga");
$xajax->register(XAJAX_FUNCTION, "Buscar_Venta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Historial");
$xajax->register(XAJAX_FUNCTION, "Buscar_Anulacion");
$xajax->register(XAJAX_FUNCTION, "Buscar_Deudas");
$xajax->register(XAJAX_FUNCTION, "Selecciona_Venta");
$xajax->register(XAJAX_FUNCTION, "Ejecutar_Credito");
$xajax->register(XAJAX_FUNCTION, "Modificar_Credito");
$xajax->register(XAJAX_FUNCTION, "Ejecutar_Cheque_Tarjeta");
$xajax->register(XAJAX_FUNCTION, "Cerrar_Detalle");
$xajax->register(XAJAX_FUNCTION, "Cambiar_Situacion");
//////////////////---- Factura -----/////////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Factura");
$xajax->register(XAJAX_FUNCTION, "Seleccionar_Factura");
$xajax->register(XAJAX_FUNCTION, "Grabar_Nueva_Factura");
$xajax->register(XAJAX_FUNCTION, "Modificar_Factura");
$xajax->register(XAJAX_FUNCTION, "Grabar_Factura_Anteriores");
////////// Bancos, Cuentas y Cajas ////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Cuenta_Banco");
$xajax->register(XAJAX_FUNCTION, "Combo_Caja_Empresa");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  