<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_inventario.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// ARTICULOS Y PROVEEDORES //////////////////////////////////
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
			$respuesta->script("document.getElementById('art').focus();");
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>Este Proveedor no existe, desea agregarlo?</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "NewProveedor(\''.$nit.'\');" ><span class="fa fa-check"></span> Si</button> ';
			$msj.= '<button type="button" class="btn btn-danger" onclick = "cerrar()" ><span class="fa fa-times"></span> No</button> ';
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
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("prov","value",$id);
			$respuesta->assign("nit","value",$nit);
			$respuesta->assign("nom","value",$nom);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
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


function Show_Articulo($cod,$barc,$suc){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();
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
					$cant = $row["art_cant_suc"];
					$respuesta->assign("cantlimit","value",$cant);
					$mon = $row["art_moneda"];
					$respuesta->assign("mon","value",$mon);
					//--
					$prev = $row["art_precio"];
					$prev = ($prev == "")?0:$prev; //valida que no regrese vacio
					$prev = number_format($prev, 2);
					$respuesta->assign("prev","value",$prev);
					//--
					$prec = $row["art_precio_costo"];
					$prec = ($prec == "")?0:$prec; //valida que no regrese vacio
					$prec = number_format($prec, 2);
					$respuesta->assign("prec","value",$prec);
					//--
					$prem = $row["art_precio_manufactura"];
					$prem = ($prem == "")?0:$prem; //valida que no regrese vacio
					$prem = number_format($prem, 2);
					$respuesta->assign("prem","value",$prem);
					//--
					$pnit = $row["prov_nit"];
					$respuesta->assign("nit","value",$pnit);
					$pnom = $row["prov_nombre"];
					$respuesta->assign("nom","value",$pnom);
					$pcod = $row["prov_id"];
					$respuesta->assign("prov","value",$pcod);
				}
				$respuesta->script("document.getElementById('cant').focus();");
				$respuesta->script("$('.select2').select2();");
		}else{
			$respuesta->script("abrir();");
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
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


function Grabar_Articulo($gru,$barc,$nom,$desc,$marca,$umed,$chkb,$prev,$mon){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();
   //pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		$barc = trim($barc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
		$barc = utf8_decode($barc);
	//--------
	if($gru != "" && $nom != "" && $desc != "" && $marca != "" && $umed != "" && $prev != "" && $mon != ""){
		$cod = $ClsArt->max_articulo($gru);
		$cod++;
		//Query
		if($chkb == 1){
			$X1 = Agrega_Ceros($cod);
			$X2 = Agrega_Ceros($gru);
			$barc = $X1."A".$X2;
		}
		$sql = $ClsArt->insert_articulo($cod,$gru,$barc,$nom,$desc,$marca,$prev,$mon,$umed,1);
		//$respuesta->alert("$sql");
		$rs = $ClsArt->exec_sql($sql);
		if($rs == 1){
			$msj = '<h5>Articulo guardados Satisfactoriamente!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar();cerrarPromt();Lote_carga(2)" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}
		
		
function Buscar_Articulo($gru,$nom,$desc,$marca,$suc,$x){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();
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
	//$respuesta->alert("$suc");
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

function Listar_Lotes($grup,$art,$fila){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
		//respuesta->alert("$grup,$art,$fila");
  		$contenido = tabla_lista_lotes($grup,$art,$fila);
		$respuesta->assign("divArt$fila","innerHTML",$contenido);
		$respuesta->script("cerrar();");
   		
   return $respuesta;
}


function Buscar_Venta($vent,$ser,$facc){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsVent = new ClsVenta();
	//$respuesta->alert("$vent,$ser,$facc");
	//valida si la venta tiene factura o no...
	if($vent != ""){
		$result = $ClsFac->get_factura('','',$vent);
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
			}
			$contenido = tabla_busca_venta_descarga($vent);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
		
   return $respuesta;
}


function Buscar_Compra($comp,$doc){
   $respuesta = new xajaxResponse();
   $ClsComp = new ClsCompra();
	
	$result = $ClsComp->get_compra($comp,'','','',$doc);
		if(is_array($result)){
			foreach ($result as $row) {
				$comp = trim($row["com_codigo"]);
				$respuesta->assign("compC","value",$comp);
				$compCod = Agrega_Ceros($comp);
				$respuesta->assign("comp","value",$compCod);
				//$respuesta->alert("$compCod");
				$doc = trim($row["com_doc"]);
				$respuesta->assign("doc","value",$doc);
			}
			$contenido = tabla_busca_compra_carga($comp);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
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

//////////////////---- INVENTARIO -----/////////////////////////////////////////////

function Grid_Fila_Carga($filas,$barc,$artc,$artn,$cant,$proc,$pronom,$pronit,$prem,$prec,$prev){
   $respuesta = new xajaxResponse();
   $contenido = tabla_filas_carga($filas,$barc,$artc,$artn,$cant,$proc,$pronom,$pronit,$prem,$prec,$prev);
   $respuesta->assign("result","innerHTML",$contenido);  
   $respuesta->script("document.getElementById('art').focus();");
   $respuesta->script("cerrar()");
   return $respuesta;
}



function Grabar_Carga($filas,$fec,$suc,$clase,$doc,$artcod,$artnom,$cant,$procod,$pronom,$pronit,$prem,$prec,$prev){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro");
   $ClsInv = new ClsInventarioSuministro();
   $ClsArt = new ClsSuministro();
   //pasa a mayusculas
		$doc = trim($doc);
	//--------
	//decodificaciones de tildes y Ñ's
		$doc = utf8_decode($doc);
	//--------
   //convierte strig plano en array
		$artcod = explode("|", $artcod);
		$artnom = explode("|", $artnom);
		$cant = explode("|", $cant);
		$proc = explode("|", $proc);
		$pronom = explode("|", $pronom);
		$pronit = explode("|", $pronit);
		$procod = explode("|", $procod);
		$prem = explode("|", $prem);
		$prec = explode("|", $prec);
		$prev = explode("|", $prev);
		$sql = "";
	//------------
	if($filas > 0 && $fec != "" && $suc != "" && $clase != "" && $doc != ""){
		//-- Datos de Inventario ($tipo = 1 // Ingreso a inventario)
		$invc = $ClsInv->max_inventario(1);
		$invc++;
		$sql.= $ClsInv->insert_inventario($invc,1,$clase,$doc,$suc,$fec,1);
		// Inicia el Ciclo de filas	
		for($i = 1; $i <= $filas; $i++){
			/// Articulo --
			$chunk = explode("A", $artcod[$i]);
			$art = $chunk[0]; // articulo
			$grup = $chunk[1]; // grupo
			//valida que los espacios sean numericos
				$art = (is_numeric($art))?$art:0;
				$grup = (is_numeric($grup))?$grup:0;
				//Codigo de Lote
				$lotc = $ClsArt->max_lote($grup,$art);
				$lotc++;
				//Query
				$sql.= $ClsArt->insert_lote($lotc,$grup,$art,$procod[$i],$suc,$prec[$i],$prev[$i],$prem[$i],$cant[$i]);
				$sql.= $ClsInv->insert_det_inventario($i,$invc,1,$grup,$art,$lotc,$cant[$i]);
		}
		$rs = $ClsInv->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$msj = '<h5>Carga Exitosa...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}else{
	
	}
	
   return $respuesta;
}



function Grabar_Carga_Compra($filas,$fec,$suc,$clase,$doc,$artcod,$artnom,$cant,$procod,$pronom,$pronit,$prem,$prec,$prev){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro");
   $ClsInv = new ClsInventarioSuministro();
   $ClsArt = new ClsSuministro();
   $ClsComp = new ClsCompra();
	//--
		$comp = trim($doc);
		$doc = Agrega_Ceros($doc);
	//--------
	//convierte strig plano en array
		$artcod = explode("|", $artcod);
		$artnom = explode("|", $artnom);
		$cant = explode("|", $cant);
		$proc = explode("|", $proc);
		$pronom = explode("|", $pronom);
		$pronit = explode("|", $pronit);
		$procod = explode("|", $procod);
		$prem = explode("|", $prem);
		$prec = explode("|", $prec);
		$prev = explode("|", $prev);
		$sql = "";
	//------------
	if($filas > 0 && $suc != "" && $clase != "" && $doc != ""){
		//-- Datos de Inventario ($tipo = 1 // Ingreso a inventario)
		$invc = $ClsInv->max_inventario(1);
		$invc++;
		$sql.= $ClsInv->insert_inventario($invc,1,$clase,$doc,$suc,$fec,1);
		// Inicia el Ciclo de filas	
		for($i = 1; $i <= $filas; $i++){
			/// Articulo --
			$chunk = explode("A", $artcod[$i]);
			$art = $chunk[0]; // articulo
			$grup = $chunk[1]; // grupo
			//valida que los espacios sean numericos
				$art = (is_numeric($art))?$art:0;
				$grup = (is_numeric($grup))?$grup:0;
				//Codigo de Lote
				$lotc = $ClsArt->max_lote($grup,$art);
				$lotc++;
				//Query
				$sql.= $ClsArt->insert_lote($lotc,$grup,$art,$procod[$i],$suc,$prec[$i],$prev[$i],$prem[$i],$cant[$i]);
				$sql.= $ClsInv->insert_det_inventario($i,$invc,1,$grup,$art,$lotc,$cant[$i]);
				$sql.= $ClsComp->cargar_det_compra($comp,1,$art,$grup);
		}
		$rs = $ClsInv->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$msj = '<h5>Carga Exitosa...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}else{
	
	}
	
   return $respuesta;
}


function Grid_Fila_Descarga($filas,$barc,$artc,$artn,$cant){
   $respuesta = new xajaxResponse();
   $contenido = tabla_filas_descarga($filas,$barc,$artc,$artn,$cant);
   $respuesta->assign("result","innerHTML",$contenido);  
   $respuesta->script("document.getElementById('art').focus();");
   $respuesta->script("cerrar()");
   return $respuesta;
}

function Grabar_Descarga($filas,$fec,$suc,$clase,$doc,$artcod,$artnom,$cant){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsInv = new ClsInventarioSuministro();
   $ClsArt = new ClsSuministro();
   //pasa a mayusculas
		$doc = trim($doc);
	//--------
	//decodificaciones de tildes y Ñ's
		$doc = utf8_decode($doc);
	//--------
   //convierte strig plano en array
		$artcod = explode("|", $artcod);
		$artnom = explode("|", $artnom);
		$cant = explode("|", $cant);
		$sql = "";
	//------------
	$j = 1; //cuenta el numero de detalles en el inventario
	if($filas > 0 && $fec != "" && $suc != "" && $clase != "" && $doc != ""){
		//-- Datos de Inventario ($tipo = 2 // Egreso a inventario)
		$invc = $ClsInv->max_inventario(2);
		$invc++; 
		$sql.= $ClsInv->insert_inventario($invc,2,$clase,$doc,$suc,$fec,1);
		// Inicia el Ciclo de filas	
		for($i = 1; $i <= $filas; $i++){
			/// Articulo --
				$chunk = explode("A", $artcod[$i]);
				$art = $chunk[0]; // articulo
				$grup = $chunk[1]; // grupo
			//valida que los espacios sean numericos
				$art = (is_numeric($art))?$art:0;
				$grup = (is_numeric($grup))?$grup:0;
			//Query
			$result = $ClsArt->descargar_lote($grup,$art,$suc);
			foreach($result as $row){
				$hay = $row["lot_cantidad"];
			}
			$necesita = $cant[$i];
			//$respuesta->alert("Necesita: $necesita");
			$hay = 0;
			$toma = 0;
			$falta = 0;
			$deja = 0;
			foreach($result as $row){
				$hay = $row["lot_cantidad"];
				$lote = $row["lot_codigo"];
				//$respuesta->alert("en el lote $lote :");
				if($hay >= $necesita){
					//$respuesta->alert("hay mas que los que se necesita");
					$toma = $necesita;
					//$respuesta->alert("toma $toma");
					$sobra = $hay - $necesita;
					//$respuesta->alert("sobran $sobra");
					$sql.= $ClsArt->cantidad_lote($lote,$grup,$art,$toma,"-");
					$sql.= $ClsInv->insert_det_inventario($j,$invc,2,$grup,$art,$lote,$toma);
					$j++;//aumenta el numero de detalle en el inventario
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
					$sql.= $ClsInv->insert_det_inventario($j,$invc,2,$grup,$art,$lote,$toma);
					$j++;//aumenta el numero de detalle en el inventario
				}
			}
		}
		$rs = $ClsInv->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$msj = '<h5>Descarga Exitosa...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}

function Grabar_Descarga_Venta($filas,$fec,$suc,$clase,$vent,$artcod,$artnom,$cant){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
	$ClsInv = new ClsInventarioSuministro();
   $ClsArt = new ClsSuministro();
   $ClsVen = new ClsVenta();
   //pasa a mayusculas
		$vent = trim($vent);
	//--------
	//decodificaciones de tildes y Ñ's
		$vent = utf8_decode($vent);
	//--------
   //convierte strig plano en array
		$artcod = explode("|", $artcod);
		$artnom = explode("|", $artnom);
		$cant = explode("|", $cant);
		$sql = "";
	//------------
	$doc = trim($vent);
	$doc = Agrega_Ceros($doc);
	
	
	
	$j = 1; //cuenta el numero de detalles en el inventario
	if($filas > 0 && $suc != "" && $clase != "" && $vent != ""){
		//-- Datos de Inventario ($tipo = 2 // Egreso de inventario)
		$invc = $ClsInv->max_inventario(2);
		$invc++; 
		$sql.= $ClsInv->insert_inventario($invc,2,$clase,$doc,$suc,$fec,1);
		// Inicia el Ciclo de filas	
		for($i = 1; $i <= $filas; $i++){
			/// Articulo --
				$chunk = explode("A", $artcod[$i]);
				$art = $chunk[0]; // articulo
				$grup = $chunk[1]; // grupo
			//valida que los espacios sean numericos
				$art = (is_numeric($art))?$art:0;
				$grup = (is_numeric($grup))?$grup:0;
			//Query
			//$respuesta->alert("$grup,$art,$suc");
			$necesita = $cant[$i];
			//$respuesta->alert("Necesita: $necesita");
			$hay = 0;
			$toma = 0;
			$falta = 0;
			$deja = 0;
			$result = $ClsArt->descargar_lote($grup,$art,$suc);
			if(is_array($result)){
				foreach($result as $row){
					$hay = $row["lot_cantidad"];
					$lote = $row["lot_codigo"];
					//$respuesta->alert("en el lote $lote :");
					if($hay >= $necesita){
						//$respuesta->alert("hay mas que los que se necesita");
						$toma = $necesita;
						//$respuesta->alert("toma $toma");
						$sobra = $hay - $necesita;
						//$respuesta->alert("sobran $sobra");
						$sql.= $ClsArt->cantidad_lote($lote,$grup,$art,$toma,"-");
						$sql.= $ClsInv->insert_det_inventario($j,$invc,2,$grup,$art,$lote,$toma);
						$sql.= $ClsVen->descargar_det_venta($vent,1,$art,$grup);
						$j++;//aumenta el numero de detalle en el inventario
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
						$sql.= $ClsInv->insert_det_inventario($j,$invc,2,$grup,$art,$lote,$toma);
						$sql.= $ClsVen->descargar_det_venta($vent,1,$art,$grup);
						$j++;//aumenta el numero de detalle en el inventario
					}
				}
			}else{
				$msj = '<h5>No hay lotes en existencia para este articulo...</h5><br><br>';
				$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
				return $respuesta; //rompe la funcion y sale del procedimiento
			}
			
		}
		//$rs = $ClsInv->exec_sql($sql);
		//$respuesta->alert("$sql");
		$rs = 1;
		if($rs == 1){
			$msj = '<h5>Descarga Exitosa...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload();" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<h5>Error de Conexion...</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}

function Buscar_Historial($tipo,$clase,$doc,$suc,$fini,$ffin,$sit){
   $respuesta = new xajaxResponse();
   $ClsInv = new ClsInventarioSuministro();
	//pasa a mayusculas
		$doc = trim($doc);
	//--------
	//decodificaciones de tildes y Ñ's
		$doc = utf8_decode($doc);
	//--------
	//$respuesta->alert("$tipo,$clase,$doc,$suc,$fini,$ffin,$sit");
    $cont = $ClsInv->count_inventario($cod,$tipo,$clase,$doc,$suc,'',$fini,$ffin,$sit);
		if($cont>0){
			$contenido = tabla_historiales_inventario($cod,$tipo,$clase,$doc,$suc,$fini,$ffin,$sit);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	return $respuesta;
}

function Selecciona_Inv($inv,$tipo,$fila){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$inv,$tipo,$fila");
	$contenido = tabla_detalle_historiales('',$inv,$tipo);
	$respuesta->assign("divInv$fila","innerHTML",$contenido);
	$respuesta->script("cerrar()");
	return $respuesta;
}

function Cerrar_Detalle($fila){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro..");
	$respuesta->assign("divInv$fila","innerHTML","");
	$respuesta->script("cerrar()");
	return $respuesta;
}


function Cambiar_Situacion($cod,$tipo,$sit){
   $respuesta = new xajaxResponse();
   $ClsInv = new ClsInventarioSuministro();
   
	$sql = $ClsInv->cambia_sit_inventario($cod,$tipo,$sit);
	$sql.= $ClsInv->devuelve_producto_inventario($cod,$tipo,$sit);
	$rs = $ClsInv->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$msj = '<h5>Transaccion Modificada...</h5><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "window.location.reload()" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}else{
		$msj = '<h5>Error de Conexion...</h5><br><br>';
		$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	return $respuesta;
}

/////////////// KARDEX //////////////////////

function Buscar_Articulo_Kardex($suc,$barc,$art,$grup,$nom,$desc,$marca,$cumed,$umed){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();
	//pasa a mayusculas
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		$barc = trim($barc);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$desc = utf8_decode($desc);
		$marca = utf8_decode($marca);
		$barc = utf8_decode($barc);
	//--------
	//$respuesta->alert("$suc,$barc,$art,$grup,$nom,$desc,$marca,$cumed,$umed");
    if($suc != "" || $barc != "" || $art != "" || $grup != "" || $nom != "" || $desc != "" || $marca != "" || $cumed != "" || $umed != ""){
		$cont = $ClsArt->count_articulo($art,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,1,$suc);
		if($cont>0){
			if($cont == 1){
				$result = $ClsArt->get_articulo($art,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit,$suc);
				foreach($result as $row){
					$art = $row["art_codigo"];
					$grup = $row["gru_codigo"];
				}
				$lado1 = tabla_tarjeta_frente($art,$grup,$suc);
				$lado2 = tabla_tarjeta_atras($art,$grup,$suc);
				$respuesta->assign("front","innerHTML",$lado1);
				$respuesta->assign("back","innerHTML",$lado2);
				$respuesta->script("document.getElementById('tarjeta').style.display = 'block'");
				$respuesta->script("document.getElementById('KPrinter').style.display = 'block'");
			}else{
				$respuesta->script("document.getElementById('tarjeta').style.display = 'none'");
				$respuesta->script("document.getElementById('KPrinter').style.display = 'none'");
			}
			$contenido = tabla_articulos_kardex($suc,$barc,$art,$grup,$nom,$desc,$marca,$cumed,$umed,1);
			$respuesta->assign("result","innerHTML",$contenido);
			//$respuesta->script("document.getElementById('busc').style.diplay = 'block';");
			$respuesta->script("cerrar()");
		}else{
			$msj = '<h5>No se registran datos con estos criterios de busqueda!!!</h5><br><br>';
			$msj.= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("result","innerHTML","");
		}
	}
   		
   return $respuesta;
}

function Seleccionar_Kardex($art,$grup,$suc){
   $respuesta = new xajaxResponse();
   $ClsArt = new ClsSuministro();
	//$respuesta->alert("$cod,$gru,$nom,$desc,$marca,$sit");
    	$lado1 = tabla_tarjeta_frente($art,$grup,$suc);
		$lado2 = tabla_tarjeta_atras($art,$grup,$suc);
		$contenido = tabla_articulos_kardex($suc,"",$art,$grup,"","","","","",1);
		$respuesta->assign("front","innerHTML",$lado1);
		$respuesta->assign("back","innerHTML",$lado2);
		$respuesta->assign("result","innerHTML",$contenido);
		$respuesta->script("document.getElementById('tarjeta').style.display = 'block'");
		$respuesta->script("document.getElementById('KPrinter').style.display = 'block'");
		$respuesta->script("cerrar()");
			
   return $respuesta;
}

function Combo_Grupo_Articulo($gru,$id,$sid,$acc){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$gru,$id,$sid,$acc");
	$contenido = suministro_html($gru,$id,$acc);
	$respuesta->assign($sid,"innerHTML",$contenido);
	
	
	return $respuesta;
}

//////////////////---- EMPRESA-EMPRESA -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Buscar_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Grabar_Proveedor");
$xajax->register(XAJAX_FUNCTION, "Show_Articulo");
$xajax->register(XAJAX_FUNCTION, "Grabar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Listar_Lotes");
$xajax->register(XAJAX_FUNCTION, "UnidadMedida");
$xajax->register(XAJAX_FUNCTION, "Buscar_Venta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Compra");
//////////////////---- INVENTARIO -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Carga");
$xajax->register(XAJAX_FUNCTION, "Grabar_Carga");
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Carga_Compra");
$xajax->register(XAJAX_FUNCTION, "Grabar_Carga_Compra");
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Descarga");
$xajax->register(XAJAX_FUNCTION, "Grabar_Descarga");
$xajax->register(XAJAX_FUNCTION, "Grabar_Descarga_Venta");
$xajax->register(XAJAX_FUNCTION, "Buscar_Historial");
$xajax->register(XAJAX_FUNCTION, "Selecciona_Inv");
$xajax->register(XAJAX_FUNCTION, "Cerrar_Detalle");
$xajax->register(XAJAX_FUNCTION, "Cambiar_Situacion");
/////////////// KARDEX /////////////
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo_Kardex");
$xajax->register(XAJAX_FUNCTION, "Seleccionar_Kardex");
$xajax->register(XAJAX_FUNCTION, "Combo_Grupo_Articulo");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  