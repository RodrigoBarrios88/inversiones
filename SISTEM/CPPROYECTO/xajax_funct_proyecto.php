<?php 
//incluímos las clases
require ("../xajax_core/xajax.inc.php");
include_once("html_fns_proyecto.php");

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
date_default_timezone_set('America/Guatemala');

///////////// Punto de Proyecto - Empresa /////////
function SucPuntVnt($suc,$nom){
   $respuesta = new xajaxResponse();
    //$respuesta->alert("$suc,$nom");
	$contenido = punto_venta_html($suc,$nom);
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

///////////// ARTICULOS Y CLIENTES //////////////////////////////////
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
		}
		//inicia la busqueda
		$cont = $ClsArt->count_articulo($art,$gru,'','','','','',$barc,1,$suc);
		if($cont>0){
			$result = $ClsArt->get_articulo($art,$gru,'','','','','',$barc,1,$suc);
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
				$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}
		
	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
		$respuesta->script("cerrar();");
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
			$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
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
			$art = (is_numeric($ser))?$ser:0;
			$gru = (is_numeric($gru))?$gru:0;
		}
		//inicia la busqueda
		$cont = $ClsSer->count_servicio($ser,$gru,'','',$barc,1);
		if($cont>0){
			$result = $ClsSer->get_servicio($ser,$gru,'','',$barc,1);
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
					$cant = 100;
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
				$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("art","value","");
			$respuesta->assign("artn","value","");
		}
		
	}else{
		$respuesta->assign("art","value","");
		$respuesta->assign("artn","value","");
		$respuesta->script("cerrar();");
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
			$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
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
				$nom = trim($row["cli_nombre"]);
				$respuesta->assign("nom","value",$nom);
				$nit = trim($row["cli_nit"]);
				$respuesta->assign("nit","value",$nit);
			}
			$respuesta->script("document.getElementById('vcod').focus();");
			$respuesta->script("cerrar();");
		}else{
			$msj = '<span>Este Cliente no existe, desea agregarlo?</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Si" onclick="NewCliente(\''.$nit.'\');cerrar();" /> ';
			$msj.= '<input type = "button" class = "boton" value = "No" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("nit","value","");
			$respuesta->assign("nom","value","");
			$respuesta->assign("prov","value","");
		}
	}else{
		$respuesta->assign("nit","value","");
		$respuesta->assign("nom","value","");
		$respuesta->assign("cli","value","");
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
	//decodificaciones de tildes y Ñ's
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
			$msj = '<span>Registros guardados Satisfactoriamente!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();cerrarPromt();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("cli","value",$id);
			$respuesta->assign("nit","value",$nit);
			$respuesta->assign("nom","value",$nom);
		}else{
			$msj = '<span>Error de Conexion...</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   
   return $respuesta;
}


function Buscar_Cliente($nit,$nom){
   //$respuesta = new xajaxResponse('ISO-8859-1');
   $respuesta = new xajaxResponse();
   $ClsCli = new ClsCliente();
   //pasa a mayusculas
		$nom = trim($nom);
		$nit = trim($nit);
   //--		
   //decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$nit = utf8_decode($nit);
	//--------
	//$respuesta->alert("$nit,$nom");
    if($nom != "" || $nit != ""){
		$cont = $ClsCli->count_cliente('',$nit,$nom);
		if($cont>0){
			$contenido = tabla_lista_clientes($nit,$nom);
			$respuesta->assign("resultProv","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
   		
   return $respuesta;
}


function Show_Vendedor($cod){
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPersonal();
	//$respuesta->alert("$cod");
	if($cod != ""){
		$cont = $ClsPer->count_personal($cod,$nom,$ape,"","","","","","","","",$suc);
		//$respuesta->alert("$cont");
		if($cont>0){
			$result = $ClsPer->get_personal($cod,$nom,$ape,"","","","","","","","",$suc);
			foreach($result as $row){
				$cod = $row["per_id"];
				$respuesta->assign("vcod","value",$cod);
				$nom = trim($row["per_nombres"])." ".trim($row["per_apellidos"]);
				$respuesta->assign("vnom","value",$nom);
			}
			$respuesta->script("document.getElementById('suc').focus();");
			$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("vcod","value","");
			$respuesta->assign("vnom","value","");
		}
	}else{
		$respuesta->assign("vcod","value","");
		$respuesta->assign("vnom","value","");
		$respuesta->script("cerrar();");
	}
	
	return $respuesta;
}

function Buscar_Vendedor($cod,$suc,$nom,$ape){
   $respuesta = new xajaxResponse();
   $ClsPer = new ClsPersonal();
	//pasa a mayusculas
		$nom = trim($nom);
		$ape = trim($ape);
	//--------
	//decodificaciones de tildes y Ñ's
		$nom = utf8_decode($nom);
		$ape = utf8_decode($ape);
	//--------
	//$respuesta->alert("$suc,$cod,$nom,$ape");
    if($cod != "" || $nom != "" || $ape != "" || $suc != ""){
		$cont = $ClsPer->count_personal($cod,$nom,$ape,"","","","","","","","",$suc);
		if($cont>0){
			$contenido = tabla_lista_personal($suc,$cod,$nom,$ape);
			$respuesta->assign("resultPer","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
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

function Grid_Fila_Proyecto_Pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$tcambiodia){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$tcambiodia");
   $contenido = tabla_filas_proyecto_pago($filas,$tpago,$monto,$moneda,$tcambio,$opera,$boucher,$observ,$tcambiodia);
   $respuesta->assign("divPagos","innerHTML",$contenido);  
   $respuesta->script("cerrar();");
   return $respuesta;
}

function Reset_Pago(){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro..");
	$contenido = tabla_inicio_proyecto_pago(1);
	$respuesta->assign("divPagos","innerHTML",$contenido);  
	for($i = 1; $i <= 6; $i ++){
		$respuesta->assign("spanpago$i","innerHTML","0");  
	}
	return $respuesta;
}

function Grid_Fila_Proyecto($filas,$moneda,$cant,$tip,$barc,$artc,$desc,$prev,$mon,$mons,$monc,$tfdsc,$fdsc,$tdsc,$dsc,$IVA){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("$filas,$moneda,$cant,$tip,$barc[1],$artc,$desc,$prev,$mon,$mons,$monc,$tfdsc,$fdsc,$tdsc[1],$dsc[1]");
   if($filas >= 1){ 
   $contenido = tabla_filas_proyecto($filas,$moneda,$cant,$tip,$barc,$artc,$desc,$prev,$mon,$mons,$monc,$tfdsc,$fdsc,$tdsc,$dsc,$IVA);
   }else{
   $contenido = tabla_inicio_proyecto(1);   
   }
   $respuesta->script("MonedaTipoCambio('Tmon','total','spantotal')");//ejecuta la funcion para tipo de cambio
   $respuesta->assign("result","innerHTML",$contenido);  
   $respuesta->script("document.getElementById('tip').focus();");
   $respuesta->script("cerrar();");
   return $respuesta;
}


function Grabar_Proyecto($filas,$cli,$pv,$suc,$fec,$vend,$subt,$desc,$total,$moneda,$montext,$arrcant,$arrtip,$arrartc,$arrdesc,$arrprev,$arrmon,$arrmonc,$arrstot,$arrdsc,$arrtot){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $ClsPro = new ClsProyecto();
      
    //convierte strig plano en array de proyecto
		$cant = explode("|", $arrcant);
		$tipo = explode("|", $arrtip);
		$artc = explode("|", $arrartc);
		$det = explode("|", $arrdesc);
		$prev = explode("|", $arrprev);
		$mon = explode("|", $arrmon);
		$monc = explode("|", $arrmonc);
		$stot = explode("|", $arrstot);
		$dsc = explode("|", $arrdsc);
		$tot = explode("|", $arrtot);
	//convierte strig plano en array de proyecto
		$pagt = explode("|", $arrpagt);
		$montop = explode("|", $arrmontop);
		$doc = explode("|", $arrdoc);
		$opera = explode("|", $arropera);
		$obs = explode("|", $arrobs);
	// Manipulacion del texto de moneda para tipo de cambio	
	$monchunk = explode("/",$montext); 
		$tcamb = trim($monchunk[2]); // Tipo de Cambio
		$tcamb = str_replace("(","",$tcamb); //le quita el primer parentesis que rodea el tipo de cambio
		$tcamb = str_replace(" x 1)","",$tcamb); //le quita el 2do. parentesis y el x 1
		
		$sql = "";
	//------------
	
	$vend = ($vend != "")?$vend:0; //-- valida si no hay vendedor
	if($filas > 0 && $cli != "" && $suc != "" && $pv != "" && $moneda != ""){
		//-- Datos de Proyecto ($tipo = 'P' PRODUCTO $tipo = 'S' SERVICIO)
		$pro = $ClsPro->max_proyecto();
		$pro++;
		//Valida la situacion de pago de la factura
		$saldo = trim($total) - trim($pagtotal);
		if($saldo <= 0){
			$sit = 2;
		}else{ $sit = 1; }
		$sql.= $ClsPro->insert_proyecto($pro,$cli,$pv,$suc,$fec,$vend,$subt,$desc,$total,$moneda,$tcamb,$sit);
		// Inicia el Ciclo de filas	
		for($i = 1; $i <= $filas; $i++){
			//Query
			$chunk = explode("A", $artc[$i]);
			$art = $chunk[0]; // articulo
			$art = ($art != "")?$art:0; //-- valida si es servicio devuelve 0
			$grup = $chunk[1]; // grupo
			$grup = ($grup != "")?$grup:0; //-- valida si es servicio devuelve 0
			$sql.= $ClsPro->insert_det_proyecto($i,$pro,$tipo[$i],$det[$i],$art,$grup,$cant[$i],$prev[$i],$mon[$i],$monc[$i],$stot[$i],$dsc[$i],$tot[$i],0);
		}
		
		$rs = $ClsPro->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$msj = '<span>Presupuesto Registrado Exitosamente...</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="window.location=\'FRMproyecto.php\'" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<span>Error de Conexion...</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Grabar_Descarga($filas,$suc,$clase,$doc,$artcod,$artnom,$cant){
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   $ClsInv = new ClsInventario();
   $ClsArt = new ClsArticulo();
   $ClsPro = new ClsProyecto();
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
	if($filas > 0 && $suc != "" && $clase != "" && $doc != ""){
		$pro = trim($doc);
		$doc = Agrega_Ceros($doc);
		//-- Datos de Inventario ($tipo = 2 // Egreso a inventario)
		$invc = $ClsInv->max_inventario(2);
		$invc++; 
		$sql.= $ClsInv->insert_inventario($invc,2,$clase,$doc,$suc,1);
		// Inicia el Ciclo de filas	
		//$respuesta->alert("$filas,$suc,$clase,$doc");
		$jx = 0; //-- valida si hay articulos para descargar o solo hay servicios
		for($i = 1; $i <= $filas; $i++){
			/// Articulo --
				$chunk = explode("A", $artcod[$i]);
				$art = $chunk[0]; // articulo
				$art = ($art != "")?$art:0; //-- valida si es servicio devuelve 0
				$grup = $chunk[1]; // grupo
				$grup = ($grup != "")?$grup:0; //-- valida si es servicio devuelve 0
			//valida que los espacios sean numericos
				$art = (is_numeric($art))?$art:0;
				$grup = (is_numeric($grup))?$grup:0;
			//Query
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
					//$respuesta->alert("en el lote $lote : vuelta $i");
					if($hay >= $necesita){
						//$respuesta->alert("hay mas que los que se necesita");
						$toma = $necesita;
						//$respuesta->alert("toma $toma");
						$sobra = $hay - $necesita;
						//$respuesta->alert("sobran $sobra");
						$sql.= $ClsArt->cantidad_lote($lote,$grup,$art,$toma,"-");
						$sql.= $ClsInv->insert_det_inventario($j,$invc,2,$grup,$art,$lote,$toma);
						$sql.= $ClsVen->descargar_det_proyecto($pro,1,$art,$grup);
						$j++;//aumenta el numero de detalle en el inventario
						$jx++; //-- valida q si hay articulos para descargar o solo hay servicios
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
						$sql.= $ClsVen->descargar_det_proyecto($pro,1,$art,$grup);
						$j++;//aumenta el numero de detalle en el inventario
						$jx++; //-- valida q si hay articulos para descargar o solo hay servicios
					}
				}
			}
		}
		//$respuesta->alert("$jx");
		if($jx > 0){
			$rs = $ClsInv->exec_sql($sql);
			//$respuesta->alert("$sql");
			if($rs == 1){
				$msj = '<span>Descarga Exitosa...</span><br><br>';
				$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="window.location=\'FRMproyecto.php\'" />';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}else{
				$msj = '<span>Error de Conexion...</span><br><br>';
				$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
				$respuesta->assign("lblparrafo","innerHTML",$msj);
			}
		}else{
			$msj = '<span>No hay articulos de inventario para descargar en esta presupuesto...</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="window.location=\'FRMproyecto.php\'" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
	}
	
   return $respuesta;
}


function Grabar_Pago($pro,$suc,$pv,$pagfilas,$arrpagt,$arrmontop,$arrmon,$arrtcambio,$arrdoc,$arropera,$arrobs){
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
      $ClsPag = new ClsPago();
	$ClsVntCred = new ClsVntCredito();
	$ClsPV = new ClsPuntoVenta();
	
    //convierte strig plano en array de proyecto
		$pagt = explode("|", $arrpagt);
		$montop = explode("|", $arrmontop);
		$moneda = explode("|", $arrmon);
		$tcamb = explode("|", $arrtcambio);
		$doc = explode("|", $arrdoc);
		$opera = explode("|", $arropera);
		$obs = explode("|", $arrobs);
	// Manipulacion del texto de moneda para tipo de cambio	
		
      $sql = "";
      $pag = $ClsPag->max_pago_proyecto();
		$pag++;
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
			   $sql.= $ClsPag->insert_pago_proyecto($pag,$pro,$pagt[$j],$montop[$j],$moneda[$j],$tcamb[$j],$Xopera,$Xdoc,$Xobs);
			   $pag++;
			//--- acredita fondos a donde corresponde
			if($pagt[$j] == 1){
				$mpv = $ClsPV->max_mov_pv($pv,$suc);
				$mpv++;
				//Query
				$sql.= $ClsPV->insert_mov_pv($mpv,$pv,$suc,"I",$montop[$j],$moneda[$j],$tcamb[$j],"V","PAGO DE PRESUPUESTO","PROY-$mpv");
			}else if($pagt[$j] == 2 || $pagt[$j] == 3 || $pagt[$j] == 4){ /// registra los cheques o bouchers por cobrar en banco
				$PCCRED++;
				//Query
				$sql.= $ClsVntCred->insert_cobro_creditos_proyecto($PCCRED,$pro,$montop[$j],$moneda[$j],$tcamb[$j],$pagt[$j],$Xopera,$Xdoc,$Xobs);
			}
		}
		$rs = $ClsPag->exec_sql($sql);
		//$respuesta->alert("$sql");
		if($rs == 1){
			$msj = '<span>Pago Registrado Exitosamente...</span><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="window.location=\'FRMpago.php\'" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}else{
			$msj = '<span>Error de Conexion...</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
		}
		
   return $respuesta;
}


function Buscar_Proyecto($pro,$nit){
   $respuesta = new xajaxResponse();
   $ClsPro = new ClsProyecto();
   $ClsCli = new ClsCliente();
   
   $nit = utf8_decode($nit);
   //--------
   //$respuesta->alert("$nit");
   if($nit != ""){
      $result = $ClsCli->get_cliente('',$nit);
      if(is_array($result)){
	 foreach($result as $row){
	   $cli = $row["cli_codigo"]; 
	 } 
      }else{
	 $cli = 0;  
      }
   }
   	//$respuesta->alert("$pro");
	//valida si la proyecto tiene factura o no...
	 $result = $ClsPro->get_proyecto($pro,$cli);
	       if(is_array($result)){
			foreach ($result as $row) {
				$pro = trim($row["pro_codigo"]);
				$respuesta->assign("proC","value",$pro);
				$pro = Agrega_Ceros($pro);
				$respuesta->assign("pro","value",$pro);
				$total = trim($row["pro_total"]);
				$monid = trim($row["mon_id"]);
				$montext = trim($row["mon_desc"]);
				$tcambio = trim($row["mon_cambio"]);
				$monsimbolo = trim($row["mon_simbolo"]);
			}
			$contenido = tabla_pagos($pro,$total,$monid,$montext,$tcambio,$monsimbolo);
			//$respuesta->alert("$pro,$total,$montext,$tcambio,$monsimbolo");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("document.getElementById('pagobox').style.display = 'block';");
			$respuesta->script("document.getElementById('sucbox').style.display = 'block';");
			$respuesta->script("cerrar();");
	       }else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
	       }
		
   return $respuesta;
}




function Buscar_Historial($suc,$pv,$fini,$ffin,$sit){
   $respuesta = new xajaxResponse();
   $ClsPro = new ClsProyecto();
	
	//$respuesta->alert("$ser,$facc");
		$result = $ClsPro->get_proyecto($pro,'',$pv,$suc,'','',$fini,$ffin,$sit);
		//$respuesta->alert("$result");
		if(is_array($result)){
			//$respuesta->alert("$pro");
			$contenido = tabla_historial_proyecto($pro,$suc,$pv,$fini,$ffin,$sit,"H");
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("result","innerHTML","");
		}
		
   return $respuesta;
}


function Buscar_Anulacion($suc,$pv,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsFac = new ClsFactura();
   $ClsPro = new ClsProyecto();
	//--------
      	$result = $ClsPro->get_proyecto('','',$pv,$suc,'','',$fini,$ffin);
		if(is_array($result)){
			//$respuesta->alert("$vent");
			$contenido = tabla_anulacion_proyecto($pro,$suc,$pv,$ser,$facc,$fini,$ffin);
			$respuesta->assign("result","innerHTML",$contenido);
			$respuesta->script("cerrar();");
		}else{
			$msj = '<span>No se registran datos con estos criterios de busqueda!!!</span><br><br>';
			$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
			$respuesta->assign("lblparrafo","innerHTML",$msj);
			$respuesta->assign("result","innerHTML","");
		}
		
   return $respuesta;
}



function Buscar_Deudas($suc,$tipo,$fini,$ffin){
   $respuesta = new xajaxResponse();
      ///------	
	if($tipo == 0){
		$contenido .= tabla_cuentas_x_cobrar($pro,$suc,'',$fini,$ffin);
	}else if($tipo == 4){
		$contenido = tabla_cuentas_x_cobrar($pro,$suc,4,$fini,$ffin);
	}else if($tipo == 2){
		$contenido = tabla_cuentas_x_cobrar($pro,$suc,'',$fini,$ffin);
	}
	$respuesta->assign("result","innerHTML",$contenido);
	$respuesta->script("cerrar();");

   return $respuesta;
}


function Selecciona_Proyecto($pro,$fila){
   $respuesta = new xajaxResponse();
      //$respuesta->alert("$inv,$tipo,$fila");
	$contenido = tabla_detalle_proyecto($pro);
	$respuesta->assign("divVent$fila","innerHTML",$contenido);
	$respuesta->script("cerrar();");
	return $respuesta;
}


function Ejecutar_Cheque_Tarjeta($cue,$ban,$suc,$caja,$tipo,$monto,$doc,$filas,$arrccue,$arrpro){
   $respuesta = new xajaxResponse();
   $ClsVntCred = new ClsVntCredito();
   $ClsBan = new ClsBanco();
   $ClsCaj = new ClsCaja();
   //convierte strig plano en array de proyecto
      $ccue = explode("|", $arrccue);
      $pro = explode("|", $arrpro);
      if($tipo == 1){
      	$cod = $ClsBan->max_mov_cuenta($cue,$ban);
        $cod++;
        $sql = $ClsBan->insert_mov_cuenta($cod,$cue,$ban,"I",$monto,"DP","DEPOSITO POR EJECUCION DE CUENTAS POR COBRAR",$doc);
        $sql.= $ClsBan->saldo_cuenta_banco($cue,$ban,$monto,"-");
      }else if($tipo == 2){
      	$cod = $ClsCaj->max_mov_caja($caja,$suc);
        $cod++;
        $sql.= $ClsCaj->insert_mov_caja($cod,$caja,$suc,"I",$monto,"DP","DEPOSITO POR EJECUCION DE CUENTAS POR COBRAR",$doc);
        $sql.= $ClsCaj->saldo_caja($caja,$suc,$monto,"-");
      }
      for($i = 1; $i <= $filas; $i++){
	$sql.= $ClsVntCred->ejecuta_cobro_creditos_proyecto($ccue[$i],$pro[$i],2);
      }
	$rs = $ClsVntCred->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$msj = '<span>Cobro(s) Ejecutado(s) Exitosamente...</span><br>';
		$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="window.location=\'FRMcuentaxcob.php\'" />';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}else{
		$msj = '<span>Error de Conexion...</span><br><br>';
		$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	return $respuesta;
}



function Cambiar_Situacion($pro,$fini,$ffin){
   $respuesta = new xajaxResponse();
   $ClsPro = new ClsProyecto();
   
   	$sql = $ClsPro->cambia_sit_proyecto($pro,0);
	$sql.= $ClsPro->devuelve_producto_proyecto($pro);
	$rs = $ClsPro->exec_sql($sql);
	//$respuesta->alert("$sql");
	if($rs == 1){
		$msj = '<span>Proyecto Anulado...</span><br>';
		$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
		$contenido = tabla_anulacion_proyecto('','','','','',$fini,$ffin);
		$respuesta->assign("result","innerHTML",$contenido);
	}else{
		$msj = '<span>Error de Conexion...</span><br><br>';
		$msj.= '<input type = "button" class = "boton" value = "Aceptar" onclick="cerrar();" />';
		$respuesta->assign("lblparrafo","innerHTML",$msj);
	}
	return $respuesta;
}


function Cerrar_Detalle($fila){
   $respuesta = new xajaxResponse();
   //$respuesta->alert("entro..");
	$respuesta->assign("divVent$fila","innerHTML","");
	$respuesta->script("cerrar();");
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

///////////////////---- Punto de Proyecto - Empresa---- ////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "SucPuntVnt");
//////////////////---- ARTICULOS-CLIENTES-VENDEDOR -----////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Show_Articulo");
$xajax->register(XAJAX_FUNCTION, "Buscar_Articulo");
$xajax->register(XAJAX_FUNCTION, "Show_Servicio");
$xajax->register(XAJAX_FUNCTION, "Buscar_Servicio");
$xajax->register(XAJAX_FUNCTION, "Show_Cliente");
$xajax->register(XAJAX_FUNCTION, "Grabar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Buscar_Cliente");
$xajax->register(XAJAX_FUNCTION, "Show_Vendedor");
$xajax->register(XAJAX_FUNCTION, "Buscar_Vendedor");
$xajax->register(XAJAX_FUNCTION, "UnidadMedida");
//////////////////---- VENTAS -----/////////////////////////////////////////////
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Proyecto_Pago");
$xajax->register(XAJAX_FUNCTION, "Reset_Pago");
$xajax->register(XAJAX_FUNCTION, "Grid_Fila_Proyecto");
$xajax->register(XAJAX_FUNCTION, "Grabar_Proyecto");
$xajax->register(XAJAX_FUNCTION, "Grabar_Pago");
$xajax->register(XAJAX_FUNCTION, "Grabar_Descarga");
$xajax->register(XAJAX_FUNCTION, "Buscar_Proyecto");
$xajax->register(XAJAX_FUNCTION, "Buscar_Historial");
$xajax->register(XAJAX_FUNCTION, "Buscar_Anulacion");
$xajax->register(XAJAX_FUNCTION, "Buscar_Deudas");
$xajax->register(XAJAX_FUNCTION, "Selecciona_Proyecto");
$xajax->register(XAJAX_FUNCTION, "Ejecutar_Cheque_Tarjeta");
$xajax->register(XAJAX_FUNCTION, "Cerrar_Detalle");
$xajax->register(XAJAX_FUNCTION, "Cambiar_Situacion");
////////// Bancos, Cuentas y Cajas ////////////////
$xajax->register(XAJAX_FUNCTION, "Combo_Cuenta_Banco");
$xajax->register(XAJAX_FUNCTION, "Combo_Caja_Empresa");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequest();

?>  