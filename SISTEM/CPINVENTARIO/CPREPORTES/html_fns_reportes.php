<?php 
include_once('../../html_fns.php');

function rep_tabla_grupo_articulos($cod,$nom,$sit){
	$ClsArt = new ClsArticulo();
	$cont = $ClsArt->count_grupo($cod,$nom,$sit);
	
	if($cont>0){
		$result = $ClsArt->get_grupo($cod,$nom,$sit);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px">No.</th>';
			$salida.= '<th width = "250px">NOMBRE</th>';
			$salida.= '<th width = "70px">SITUACIÓN</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$gru = $row["gru_codigo"];
			$sit = $row["gru_situacion"];
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//grupo
			$grun = $row["gru_nombre"];
			$salida.= '<td>'.$grun.'</td>';
			//situacion
			$sit = ($sit == 1)?"<b>ACTIVO</b>":"<b>INACTIVO</b>";
			$salida.= '<td align = "center" >'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "3" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function rep_tabla_articulos($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit){
	$ClsArt = new ClsArticulo();
	$cont = $ClsArt->count_articulo($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit);
	
	if($cont>0){
		$result = $ClsArt->get_articulo($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit,$_SESSION["empresa"]);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "30px">No.</th>';
			$salida.= '<th width = "120px">GRUPO</th>';
			$salida.= '<th width = "90px">COD. INT.</th>';
			$salida.= '<th width = "250px">NOMBRE</th>';
			$salida.= '<th width = "100px">MARCA</th>';
			$salida.= '<th width = "150px">DESCRIPCIÓN</th>';
			$salida.= '<th width = "90px">P. COSTO</th>';
			$salida.= '<th width = "90px">P. MARGEN</th>';
			$salida.= '<th width = "90px">P. VENTA</th>';
			$salida.= '<th width = "90px">EXISTENCIA</th>';
			$salida.= '<th width = "70px">SITUACIÓN</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$sit = $row["art_situacion"];
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//grupo
			$grun = $row["gru_nombre"];
			$salida.= '<td>'.$grun.'</td>';
			//barcode
			$barc = $row["art_barcode"];
			$barc = ($barc != "")?$barc:"N/A";
			$salida.= '<td align = "center" >'.$barc.'</td>';
			//nombre
			$nom = $row["art_nombre"];
			$salida.= '<td>'.$nom.'</td>';
			//marca
			$marca = $row["art_marca"];
			$salida.= '<td>'.$marca.'</td>';
			//desc
			$desc = $row["art_desc"];
			$salida.= '<td>'.$desc.'</td>';
			//Precio de Costo
			$mon = $row["mon_simbolo"];
			$prec = $row["art_precio_costo"];
			$prec = round($prec,2);
			$salida.= '<td align = "center">'.$mon.'. '.$prec.'</td>';
			//Precio de Margen
			$prem = $row["art_precio_manufactura"];
			$prem = round($prem);
			$salida.= '<td align = "center">'.$mon.'. '.$prem.'</td>';
			//Precio de Venta
			$prev = $row["art_precio"];
			$prev = round($prev);
			$salida.= '<td align = "center">'.$mon.'. '.$prev.'</td>';
			//Existencia
			$cant = $row["art_cant_suc"];
			$salida.= '<td align = "center">'.$cant.'</td>';
			//situacion
			$sit = ($sit == 1)?"<b>ACTIVO</b>":"<b>INACTIVO</b>";
			$salida.= '<td align = "center" >'.$sit.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "11" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function rep_tabla_clientes($nit,$nom){
	$ClsCli = new ClsCliente();
	$cont = $ClsCli->count_cliente($cod,$nit,$nom);
	
	if($cont>0){
		$result = $ClsCli->get_cliente($cod,$nit,$nom);
			$salida = '<div id = "reportes">';
			$salida.= '<br>';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px" >No.</th>';
			$salida.= '<th align = "center" width = "50px">CODIGO</th>';
			$salida.= '<th align = "center" width = "200px">NOMBRE DE LA EMPRESA</th>';
			$salida.= '<th align = "center" width = "260px">DIRECCIÓN</th>';
			$salida.= '<th align = "center" width = "70px">TELEFONO 1</th>';
			$salida.= '<th align = "center" width = "70px">TELEFONO 2</th>';
			$salida.= '<th align = "center" width = "150px">MAIL</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<th align = "center">'.$i.'</th>';
			//codigo
			$cod = $row["cli_id"];
			$salida.= '<td align = "center">'.Agrega_Ceros($cod).'</td>';
			//nombre
			$nom = $row["cli_nombre"];
			$salida.= '<td align = "left">'.$nom.'</td>';
			//direccion
			$dir = $row["cli_direccion"];
			$salida.= '<td align = "left">'.$dir.'</td>';
			//telefono 1
			$tel = $row["cli_tel1"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//telefono 2
			$tel = $row["cli_tel2"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//mail
			$mail = $row["cli_mail"];
			$salida.= '<td align = "center">'.$mail.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "7" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function rep_tabla_proveedores($nit,$nom,$contact,$sit){
	$ClsProv = new ClsProveedor();
	$cont = $ClsProv->count_proveedor($cod,'',$nit,$nom,$contact,$sit);
	
	if($cont>0){
		$result = $ClsProv->get_proveedor($cod,'',$nit,$nom,$contact,$sit);
			$salida = '<div id = "reportes">';
			$salida.= '<br>';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th align = "center" width = "30px" >No.</th>';
			$salida.= '<th align = "center" width = "50px">CODIGO</th>';
			$salida.= '<th align = "center" width = "200px">NOMBRE DE LA EMPRESA</th>';
			$salida.= '<th align = "center" width = "250px">DIRECCIÓN</th>';
			$salida.= '<th align = "center" width = "70px">TELEFONO 1</th>';
			$salida.= '<th align = "center" width = "70px">TELEFONO 2</th>';
			$salida.= '<th align = "center" width = "150px">MAIL</th>';
			$salida.= '<th align = "center" width = "120px">CONTACTO</th>';
			$salida.= '<th align = "center" width = "70px">TEL. CONTACTO</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<th align = "center">'.$i.'</th>';
			//codigo
			$cod = $row["prov_id"];
			$salida.= '<td align = "center">'.Agrega_Ceros($cod).'</td>';
			//nombre
			$nom = $row["prov_nombre"];
			$salida.= '<td align = "left">'.$nom.'</td>';
			//direccion
			$dir = $row["prov_direccion"];
			$salida.= '<td align = "left">'.$dir.'</td>';
			//telefono 1
			$tel = $row["prov_tel1"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//telefono 2
			$tel = $row["prov_tel2"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			//mail
			$mail = $row["prov_mail"];
			$salida.= '<td align = "center">'.$mail.'</td>';
			//contacto
			$contacto = $row["prov_contacto"];
			$salida.= '<td align = "left">'.$contacto.'</td>';
			//telefono contacto
			$tel = $row["prov_cont_tel"];
			$salida.= '<td align = "center">'.$tel.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "10" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}

/////////////////////////// Historiales ///////////////////

function rep_tabla_historiales_inventario($cod,$tipo,$clase,$doc,$suc,$fini,$ffin,$sit){
	$ClsInv = new ClsInventario();
	$cont = $ClsInv->count_inventario($cod,$tipo,$clase,$doc,$suc,'',$fini,$ffin,$sit);
	
	if($cont>0){
		$result = $ClsInv->get_det_inventario('',$cod,$tipo,'','','',$suc,$clase,$doc,$fini,$ffin,$sit);
			$salida = '<div id = "reportes">';
			$salida.= '<table>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px" align = "center">No.</th>';
			$salida.= '<th width = "70px" align = "center"># TRANSACCIÓN</th>';
			$salida.= '<th width = "120px" align = "center" >No. LOTE</th>';
			$salida.= '<th width = "200px" align = "center" >PROVEEDOR</th>';
			$salida.= '<th width = "250px" align = "center" >ARTICULO</th>';
			$salida.= '<th width = "50px" align = "center" >CANTIDAD</th>';
			$salida.= '<th width = "80px" align = "center" >TIPO</th>';
			$salida.= '<th width = "80px" align = "center" >MOTIVO</th>';
			$salida.= '<th width = "50px" align = "center" >No. DOC.</th>';
			$salida.= '<th width = "100px align = "center"" >FECHA/HORA</th>';
			$salida.= '</tr>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["inv_situacion"];
			$cod = $row["det_codigo"];
			$inv = $row["inv_codigo"];
			$tip = $row["inv_tipo"];
			//--
			$salida.= '<td align = "center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($cod);
			$inv = Agrega_Ceros($inv);
			$dato = Agrega_Ceros($tip);
			$codigo = $cod."-".$inv."-".$dato;
			$salida.= '<td align = "center">'.$codigo.'</td>';
			//Lote
			$lot = $row["lot_codigo"];
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$lot = Agrega_Ceros($lot);
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			$codigo = $lot."A".$art."A".$gru;
			$salida.= '<td class = "celdadash" align = "center">'.$codigo.'</td>';
			//Proveedor
			$prov = $row["prov_nombre"];
			$salida.= '<td class = "celdadash">'.$prov.'</td>';
			//Articulo
			$art = $row["art_nombre"];
			$salida.= '<td class = "celdadash">'.$art.'</td>';
			//Cantidad
			$cant = $row["det_cantidad"];
			$salida.= '<td class = "celdadash" align = "center">'.$cant.'</td>';
			//Tipo
			switch($tip){
				case 1: $tipo = "INGRESO"; break;
				case 2: $tipo = "EGRESO"; break;
			}
			$salida.= '<td>'.$tipo.'</td>';
			//Clase
			$clas = $row["inv_clase"];
			switch($clas){
				case 'C': $clas = "COMPRA"; break;
				case 'P': $clas = "PRODUCCIÓN"; break;
				case 'D': $clas = "DONACIÓN"; break;
				case 'V': $clas = "VENTA"; break;
				case 'D2': $clas = "DESCARGA (DESECHADO)"; break;
				case 'C2': $clas = "A CONSIGNACIÓN"; break;
				case 'C3': $clas = "REGRESO CONSIG."; break;
			}
			$salida.= '<td>'.$clas.'</td>';
			//Documento
			$doc = $row["inv_documento"];
			$salida.= '<td>'.$doc.'</td>';
			//Fecha / Hora
			$fec = $row["inv_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td>'.$fec.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
			$salida.= '<tr>';
			$salida.= '<th colspan = "11" align = "right"> '.$i.' Registro(s).</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}

///////////////////// KARDEX /////////////////////

function rep_tabla_tarjeta_a($art,$grup,$suc){
	$ClsInv = new ClsInventario();
	$result = $ClsInv->get_det_inventario_kardex($art,$grup,$suc);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table width = "900px">';
		$i = 1;
		$saldo = 0;	
		foreach($result as $row){
			if($i == 1){
				//Empresa
				$salida.= '<tr>';
				$sucn = $row["suc_nombre"];
				$salida.= '<th align = "center" colspan = "8"><b>EMPRESA:</b> '.$sucn.'</th>';
				$salida.= '</tr>';
				//grupo
				$salida.= '<tr>';
				$grun = $row["gru_nombre"];
				$gruc = $row["gru_codigo"];
				$gruc = Agrega_Ceros($gruc);
				$salida.= '<td class = "celdakardex" colspan = "2"><b>GRUPO:</b> '.$grun.'</td>';
				$artc = $row["art_codigo"];
				$artc = Agrega_Ceros($artc);
				$artn = $row["art_nombre"];
				$marc = $row["art_marca"];
				$barc = $row["art_barcode"];
				$barc = ($barc != "")?$barc:"N/A";
				$umed = $row["u_desc_lg"];
				$salida.= '<td class = "celdakardex" colspan = "2"><b>ARTICULO:</b> '.$artn.'</td>';
				$salida.= '<td class = "celdakardex" colspan = "4"><b>MARCA:</b> '.$marc.'</td>';
				$salida.= '</tr>';
				//--
				$salida.= '<tr>';
				$salida.= '<td class = "celdakardex" colspan = "2"><b>CODIGO:</b> '.$artc.'A'.$gruc.'</td>';
				$salida.= '<td class = "celdakardex" colspan = "2"><b>CODIGO INT.:</b> '.$barc.'</td>';
				$salida.= '<td class = "celdakardex" colspan = "4"><b>U. MEDIDA:</b> '.$umed.'</td>';
				$salida.= '</tr>';
				///---
				$salida.= '<tr>';
				$salida.= '<td class = "celdakardex" colspan = "8"><br></td>';
				$salida.= '</tr>';
				$salida.= '<tr>';
				$salida.= '<th class = "celdakardex" colspan = "8" align = "center"><b>MOVIMIENTO DE PRODUCTO</b></th>';
				$salida.= '</tr>';
				///---
				$salida.= '<tr>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>TRANSACCIÓN</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>LOTE</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>FECHA</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>DETALLE</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>ENTRÓ</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>SALIÓ</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>SALDO</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>USUARIO</b></td>';
				$salida.= '</tr>';
			}
			$salida.= '<tr>';
			//transaccion
			$inv = $row["inv_codigo"];
			$inv = Agrega_Ceros($inv);
			$dinv = $row["det_codigo"];
			$dinv = Agrega_Ceros($dinv);
			$trans = "$inv-$dinv";
			$salida.= '<td class = "celdakardex" align = "center" >'.$trans.'</td>';
			//transaccion
			$lc = $row["lot_codigo"];
			$lc = Agrega_Ceros($lc);
			$ac = $row["lot_articulo"];
			$ac = Agrega_Ceros($ac);
			$gc = $row["lot_grupo"];
			$gc = Agrega_Ceros($gc);
			$lote = $lc."A".$ac."A".$gc;
			$salida.= '<td class = "celdakardex" align = "center" >'.$lote.'</td>';
			//fecha
			$fec = $row["inv_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "celdakardex" align = "center" >'.$fec.'</td>';
			//detalle
			$clase = trim($row["inv_clase"]);
			$clase = descripcion_clase($clase);
			$doc = $row["inv_documento"];
			$detalle = "$clase REF. DOC: $doc";
			$salida.= '<td class = "celdakardex">'.$detalle.'</td>';
			//cantidades
			$tipo = $row["det_tipo"];
			$cant = $row["det_cantidad"];
			if($tipo == 1){
				$entra = $cant;
				$sale = "";
				$saldo += $entra;
			}else if($tipo == 2){
				$entra = "";
				$sale = $cant;
				$saldo -=  $sale;
			}
			$salida.= '<td class = "celdakardex" align = "center" >'.$entra.'</td>';
			$salida.= '<td class = "celdakardex" align = "center" >'.$sale.'</td>';
			$salida.= '<td class = "celdakardex" align = "center" >'.$saldo.'</td>';
			//usuario
			$usu = $row["inv_quien"];
			$usu = Agrega_Ceros($usu);
			$salida.= '<td class = "celdakardex" align = "center" >COD: '.$usu.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//SAlDO FINAL
			$salida.= '<tr>';
			$salida.= '<th class = "celdakardex" align = "center" colspan = "4"></th>';
			$salida.= '<th class = "celdakardex" align = "center" colspan = "2"><b>SALDO TOTAL:</b></th>';
			$salida.= '<th class = "celdakardex" align = "center" colspan = "2">'.$saldo.'</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function rep_tabla_tarjeta_b($art,$grup,$suc){
	$ClsArt = new ClsArticulo();
	$result = $ClsArt->get_lote('',$grup,$art,'',$suc);
	
	if(is_array($result)){
			$salida = '<div id = "reportes">';
			$salida.= '<table width = "900px">';
		$i = 1;
		$saldo = 0;	
		$prectot = 0;	
		foreach($result as $row){
			if($i == 1){
				//Empresa
				$salida.= '<tr>';
				$sucn = $row["suc_nombre"];
				$salida.= '<th align = "center" colspan = "9"><b>EMPRESA:</b> '.$sucn.'</th>';
				$salida.= '</tr>';
				//grupo
				$salida.= '<tr>';
				$grun = $row["gru_nombre"];
				$gruc = $row["gru_codigo"];
				$gruc = Agrega_Ceros($gruc);
				$salida.= '<td class = "celdakardex" colspan = "2"><b>GRUPO:</b> '.$grun.'</td>';
				$artc = $row["art_codigo"];
				$artc = Agrega_Ceros($artc);
				$artn = $row["art_nombre"];
				$marc = $row["art_marca"];
				$barc = $row["art_barcode"];
				$barc = ($barc != "")?$barc:"N/A";
				$umed = $row["u_desc_lg"];
				$salida.= '<td class = "celdakardex" colspan = "4"><b>ARTICULO:</b> '.$artn.'</td>';
				$salida.= '<td class = "celdakardex" colspan = "3"><b>MARCA:</b> '.$marc.'</td>';
				$salida.= '</tr>';
				//--
				$salida.= '<tr>';
				$salida.= '<td class = "celdakardex" colspan = "2"><b>CODIGO:</b> '.$artc.'A'.$gruc.'</td>';
				$salida.= '<td class = "celdakardex" colspan = "4"><b>CODIGO INT.:</b> '.$barc.'</td>';
				$salida.= '<td class = "celdakardex" colspan = "3"><b>U. DE MEDIDA:</b> '.$umed.'</td>';
				$salida.= '</tr>';
				///---
				$salida.= '<tr>';
				$salida.= '<td class = "celdakardex" colspan = "9"><br></td>';
				$salida.= '</tr>';
				$salida.= '<tr>';
				$salida.= '<th class = "celdakardex" colspan = "9" align = "center"><b>LOTES Y EXISTENCIAS</b></th>';
				$salida.= '</tr>';
				///---
				$salida.= '<tr>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>LOTE</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>FECHA INGRESO</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>EXISTENCIA</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>NIT</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>PROVEEDOR</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>PREC. MARGEN</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>PREC. COSTO</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>PREC. VENTA</b></td>';
				$salida.= '<td class = "celdakardex" align = "center" ><b>MONEDA</b></td>';
				$salida.= '</tr>';
			}
			$salida.= '<tr>';
			//lote
			$lc = $row["lot_codigo"];
			$lc = Agrega_Ceros($lc);
			$ac = $row["lot_articulo"];
			$ac = Agrega_Ceros($ac);
			$gc = $row["lot_grupo"];
			$gc = Agrega_Ceros($gc);
			$lote = $lc."A".$ac."A".$gc;
			$salida.= '<td class = "celdakardex" align = "center" >'.$lote.'</td>';
			//fecha
			$fec = $row["lot_fecha_in"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "celdakardex" align = "center" >'.$fec.'</td>';
			//Existencia
			$cant = trim($row["lot_cantidad"]);
			$salida.= '<td class = "celdakardex" align = "center" >'.$cant.'</td>';
			//NIT
			$Pnit = trim($row["prov_nit"]);
			$salida.= '<td class = "celdakardex">'.$Pnit.'</td>';
			//PROVEEDOR
			$Pnom = trim($row["prov_nombre"]);
			$salida.= '<td class = "celdakardex">'.$Pnom.'</td>';
			//precios
			$mons = $row["mon_simbolo"];
			$prem = $row["lot_precio_manufactura"];
			$prec = $row["lot_precio_costo"];
			$prev = $row["art_precio"];
			$prectot += $prec;
			$mon = $row["mon_desc"];
			$salida.= '<td class = "celdakardex" align = "center" >'.$mons.'. '.$prem.'</td>';
			$salida.= '<td class = "celdakardex" align = "center" >'.$mons.'. '.$prec.'</td>';
			$salida.= '<td class = "celdakardex" align = "center" >'.$mons.'. '.$prev.'</td>';
			$salida.= '<td class = "celdakardex" align = "center" >'.$mon.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//PRECIO de COSTO PROMEDIO
			$i--;
			$precprom = ($prectot/$i);
			$precprom = round($precprom, 2);
			$salida.= '<tr>';
			$salida.= '<th class = "celdakardex" align = "center" colspan = "2"></th>';
			$salida.= '<th class = "celdakardex" align = "center" colspan = "3"><b>PRECIO DE COSTO PROMEDIO:</b></th>';
			$salida.= '<th class = "celdakardex" align = "center" >'.$mons.'. '.$precprom.'</th>';
			$salida.= '<th class = "celdakardex" align = "center" colspan = "3" >'.$mon.'</th>';
			$salida.= '</tr>';
			$salida.= '</table>';
			$salida.= '</div>';
	}
	
	return $salida;
}


function descripcion_clase($clase){
	switch($clase){
		case "C": $det = "COMPRA"; break;
		case "P": $det = "PRODUCCIÓN"; break;
		case "D": $det = "DONACIÓN"; break;
		case "D2": $det = "DESCARGA POR RECHAZO"; break;
		case "C2": $det = "A CONSIGNACIÓN"; break;
		case "C3": $det = "REGRESO CONSIG."; break;
	}
	return $det;
}

//echo tabla_tarjeta_frente(1,1,1);
//echo tabla_busca_compra_carga(2);

?>
