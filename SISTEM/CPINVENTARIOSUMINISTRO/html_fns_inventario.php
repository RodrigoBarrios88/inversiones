<?php 
include_once('../html_fns.php');

function tabla_inicio_carga($filas){
			$salida = '<br>';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px">No.</td>';
			$salida.= '<th class = "text-center" width = "100px">Codigo Art.</td>';
			$salida.= '<th class = "text-center" width = "250px">Articulo</td>';
			$salida.= '<th class = "text-center" width = "65px">Cantidad</td>';
			$salida.= '<th class = "text-center" width = "250px">Proveedor</td>';
			$salida.= '<th class = "text-center" width = "30px" colspan = "2"></td>';
			$salida.= '</tr>';
	$i = 1;	
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//Lote
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" name = "barc'.$i.'" id = "barc'.$i.'" />';
			$salida.= '</td>';
			//Articulo
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" name = "artc'.$i.'" id = "artc'.$i.'" />';
			$salida.= '<input type = "hidden" name = "artn'.$i.'" id = "artn'.$i.'" />';
			$salida.= '</td>';
			//Cantidad
			$salida.= '<td class = "text-center"><span id = "spancant'.$i.'"></span>';
			$salida.= '<input type = "hidden" name = "cant'.$i.'" id = "cant'.$i.'" />';
			$salida.= '<input type = "hidden" name = "prem'.$i.'" id = "prem'.$i.'" />';
			$salida.= '<input type = "hidden" name = "prec'.$i.'" id = "prec'.$i.'" />';
			$salida.= '<input type = "hidden" name = "prev'.$i.'" id = "prev'.$i.'" />';
			$salida.= '</td>';
			//Proveedor
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" name = "proc'.$i.'" id = "proc'.$i.'" />';
			$salida.= '<input type = "hidden" name = "pronom'.$i.'" id = "pronom'.$i.'" />';
			$salida.= '<input type = "hidden" name = "pronit'.$i.'" id = "pronit'.$i.'" />';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default"  title = "Ver Informaci&oacute;n" ><span class="fa fa-search"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger"  title = "Quitar Fila" ><span class="fa fa-times"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
	}		
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "7"> 0 Registro(s).';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "0"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}


function tabla_filas_carga($filas,$barc,$artc,$artn,$cant,$proc,$pronom,$pronit,$prem,$prec,$prev){
	
	//convierte strig plano en array
		$barc = explode("|", $barc);
		$artc = explode("|", $artc);
		$artn = explode("|", $artn);
		$cant = explode("|", $cant);
		$proc = explode("|", $proc);
		$pronom = explode("|", $pronom);
		$pronit = explode("|", $pronit);
		$prem = explode("|", $prem);
		$prec = explode("|", $prec);
		$prev = explode("|", $prev);
			$salida = '<br>';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px">No.</td>';
			$salida.= '<th class = "text-center" width = "100px">Codigo Art.</td>';
			$salida.= '<th class = "text-center" width = "250px">Articulo</td>';
			$salida.= '<th class = "text-center" width = "65px">Cantidad</td>';
			$salida.= '<th class = "text-center" width = "250px">Proveedor</td>';
			$salida.= '<th class = "text-center" width = "30px" colspan = "2"></td>';
			$salida.= '</tr>';
	
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//Codigo Int.
			$barcdesc = ($barc[$i] != "")?$barc[$i]:"N/A";
			$salida.= '<td class = "text-center">'.$barcdesc;
			$salida.= '<input type = "hidden" name = "barc'.$i.'" id = "barc'.$i.'" value = "'.$barc[$i].'" />';
			$salida.= '</td>';
			//Articulo
			$salida.= '<td class = "text-center">'.utf8_decode($artn[$i]);
			$salida.= '<input type = "hidden" name = "artc'.$i.'" id = "artc'.$i.'" value = "'.$artc[$i].'" />';
			$salida.= '<input type = "hidden" name = "artn'.$i.'" id = "artn'.$i.'" value = "'.$artn[$i].'" />';
			$salida.= '</td>';
			//Cantidad
			$salida.= '<td class = "text-center"><span id = "spancant'.$i.'">'.$cant[$i].'</span>';
			$salida.= '<input type = "hidden" name = "cant'.$i.'" id = "cant'.$i.'" value = "'.$cant[$i].'" />';
			$salida.= '<input type = "hidden" name = "prem'.$i.'" id = "prem'.$i.'" value = "'.$prem[$i].'" />';
			$salida.= '<input type = "hidden" name = "prec'.$i.'" id = "prec'.$i.'" value = "'.$prec[$i].'" />';
			$salida.= '<input type = "hidden" name = "prev'.$i.'" id = "prev'.$i.'" value = "'.$prev[$i].'" />';
			$salida.= '</td>';
			//Proveedor
			$salida.= '<td class = "text-center">'.utf8_decode($pronom[$i]);
			$salida.= '<input type = "hidden" name = "proc'.$i.'" id = "proc'.$i.'" value = "'.$proc[$i].'" />';
			$salida.= '<input type = "hidden" name = "pronom'.$i.'" id = "pronom'.$i.'" value = "'.$pronom[$i].'" />';
			$salida.= '<input type = "hidden" name = "pronit'.$i.'" id = "pronit'.$i.'" value = "'.$pronit[$i].'" />';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" onclick = "Show_Fila_Carga('.$i.')"  title = "Ver Datos" ><span class="fa fa-search"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "QuitarFilaCarga('.$i.')"  title = "Quitar Fila" ><span class="fa fa-times"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
	}		
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "7"> '.$filas.' Registro(s).';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$filas.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}


/////////////////// Descarga /////////////////////

function tabla_inicio_descarga($filas){
			$salida = '<br>';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" height = "30px">No.</td>';
			$salida.= '<th class = "text-center" width = "150px">Codigo Int.</td>';
			$salida.= '<th class = "text-center" width = "250px">Articulo</td>';
			$salida.= '<th class = "text-center" width = "65px">Cantidad</td>';
			$salida.= '<th class = "text-center" width = "30px" colspan = "2"></td>';
			$salida.= '</tr>';
	$i = 1;	
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//Codigo Int.
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" name = "barc'.$i.'" id = "barc'.$i.'" />';
			$salida.= '<input type = "hidden" name = "cumed'.$i.'" id = "cumed'.$i.'" />';
			$salida.= '<input type = "hidden" name = "umed'.$i.'" id = "umed'.$i.'" />';
			$salida.= '</td>';
			//Articulo
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" name = "artc'.$i.'" id = "artc'.$i.'" />';
			$salida.= '<input type = "hidden" name = "artn'.$i.'" id = "artn'.$i.'" />';
			$salida.= '</td>';
			//Cantidad
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" name = "cant'.$i.'" id = "cant'.$i.'" />';
			$salida.= '<input type = "hidden" name = "prem'.$i.'" id = "prem'.$i.'" />';
			$salida.= '<input type = "hidden" name = "prec'.$i.'" id = "prec'.$i.'" />';
			$salida.= '<input type = "hidden" name = "prev'.$i.'" id = "prev'.$i.'" />';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default"  title = "Ver Informaci&oacute;n" ><span class="fa fa-search"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger"  title = "Quitar Fila" ><span class="fa fa-times"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
	}		
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "6"> 0 Registro(s).';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "0"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}


function tabla_filas_descarga($filas,$barc,$artc,$artn,$cant){ 	
	//convierte strig plano en array
		$artc = explode("|", $artc);
		$artn = explode("|", $artn);
		$cant = explode("|", $cant);
		$barc = explode("|", $barc);
			$salida = '<br>';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" height = "30px">No.</td>';
			$salida.= '<th class = "text-center" width = "150px">Codigo Int.</td>';
			$salida.= '<th class = "text-center" width = "250px">Articulo</td>';
			$salida.= '<th class = "text-center" width = "65px">Cantidad</td>';
			$salida.= '<th class = "text-center" width = "30px" colspan = "2"></td>';
			$salida.= '</tr>';
			
	if($filas>0){
		for($i = 1; $i <= $filas; $i ++){
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//Lote
				$chunk = explode("A", $artc[$i]);
				$art = $chunk[1]; // articulo
				$gru = $chunk[2]; // grupo
				//valida que los espacios sean numericos
				$art = (is_numeric($art))?$art:0;
				$gru = (is_numeric($gru))?$gru:0;
				//agrega ceros
				$art = Agrega_Ceros($art);
				$gru = Agrega_Ceros($gru);
			//arma el codigo
			$artdesc = $art."A".$gru;
			$salida.= '<td class = "text-center">'.$barc[$i];
			$salida.= '<input type = "hidden" name = "barc'.$i.'" id = "barc'.$i.'" value = "'.$barc[$i].'" />';
			$salida.= '</td>';
			//Articulo
			$salida.= '<td class = "text-center">'.utf8_decode($artn[$i]);
			$salida.= '<input type = "hidden" name = "artc'.$i.'" id = "artc'.$i.'" value = "'.$artc[$i].'" />';
			$salida.= '<input type = "hidden" name = "artn'.$i.'" id = "artn'.$i.'" value = "'.$artn[$i].'" />';
			$salida.= '</td>';
			//Cantidad
			$salida.= '<td class = "text-center"><span id = "spancant'.$i.'">'.$cant[$i].'</span>'; //le agrega span para poder actualizar el valor de cantidad al sumarle mas articulos del mismo lote
			$salida.= '<input type = "hidden" name = "cant'.$i.'" id = "cant'.$i.'" value = "'.$cant[$i].'" />';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" onclick = "Show_Fila_Descarga('.$i.')"  title = "Ver Datos" ><span class="fa fa-search"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "QuitarFilaDescarga('.$i.')"  title = "Quitar Fila" ><span class="fa fa-times"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '</tr>';
		}
	}		
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "6"> '.$filas.' Registro(s).';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$filas.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}

function tabla_busca_venta_descarga($vent){ 	
	$ClsVen = new ClsVenta();
			$salida = '<br>';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" height = "30px">No.</td>';
			$salida.= '<th class = "text-center" width = "150px">Codigo Int.</td>';
			$salida.= '<th class = "text-center" width = "250px">Articulo</td>';
			$salida.= '<th class = "text-center" width = "65px">Cantidad</td>';
			$salida.= '<th class = "text-center" width = "30px" colspan = "2"></td>';
			$salida.= '</tr>';
			
	$result = $ClsVen->get_det_venta_producto("",$vent,"P",0);
	if(is_array($result)){
		$i = 1;
		foreach ($result as $row){
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			$art = $row["art_codigo"];
			$gru = $row["art_grupo"];
			//agrega ceros
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			//arma el codigo
			$artdesc = $art."A".$gru;
			$barc = $row["art_barcode"];
			$barc = ($barc != "")?$barc:"N/A";
			$salida.= '<td class = "text-center">'.$barc;
			$salida.= '<input type = "hidden" name = "barc'.$i.'" id = "barc'.$i.'" value = "'.$barc.'" />';
			$salida.= '</td>';
			//Articulo
			$artn = $row["art_nombre"];
			$salida.= '<td class = "text-center">'.$artn;
			$salida.= '<input type = "hidden" name = "artc'.$i.'" id = "artc'.$i.'" value = "'.$artdesc.'" />';
			$salida.= '<input type = "hidden" name = "artn'.$i.'" id = "artn'.$i.'" value = "'.$artn.'" />';
			$salida.= '</td>';
			//Cantidad
			$cant = $row["dven_cantidad"];
			$salida.= '<td class = "text-center"><span id = "spancant'.$i.'">'.$cant.'</span>'; //le agrega span para poder actualizar el valor de cantidad al sumarle mas articulos del mismo lote
			$salida.= '<input type = "hidden" name = "cant'.$i.'" id = "cant'.$i.'" value = "'.$cant.'" />';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" onclick = "Show_Fila_Descarga('.$i.')"  title = "Ver Datos" ><span class="fa fa-search"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "QuitarFilaDescarga('.$i.')"  title = "Quitar Fila" ><span class="fa fa-times"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
	}else{
		//----
		$salida.= '<tr>';
		$salida.= '<td class = "text-center" colspan = "6"><strong>No hay harticulos pendientes de descargar a Inventario</strong></tr>';
		//----
	}	
			$i--;
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "6"> '.$i.' Registro(s).';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}


function tabla_busca_compra_carga($comp){
	$ClsComp = new ClsCompra();
			$salida = '<br>';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "30px" height = "30px">No.</td>';
			$salida.= '<th class = "text-center" width = "150px">Codigo Int.</td>';
			$salida.= '<th class = "text-center" width = "250px">Articulo</td>';
			$salida.= '<th class = "text-center" width = "65px">Cantidad</td>';
			$salida.= '<th class = "text-center" width = "150px">Proveedor</td>';
			$salida.= '<th class = "text-center" width = "30px" colspan = "2"></td>';
			$salida.= '</tr>';
	$result = $ClsComp->get_det_compra_suministro("",$comp,"U",0);
	if(is_array($result)){
		$i = 1;	
		foreach($result as $row){
			//No.
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//Codigo Int.
			$barc = $row["art_barcode"];
			$barc = ($barc != "")?$barc:"N/A";
			$salida.= '<td class = "text-center">'.$barc;
			$salida.= '<input type = "hidden" name = "barc'.$i.'" id = "barc'.$i.'" value = "'.$barc.'" />';
			$salida.= '</td>';
			//Articulo
			$art = $row["art_codigo"];
			$gru = $row["art_grupo"];
			$artn = utf8_decode($row["art_nombre"]);
			//agrega ceros
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			$artdesc = $art."A".$gru;
			$salida.= '<td class = "text-center">'.$artn;
			$salida.= '<input type = "hidden" name = "artc'.$i.'" id = "artc'.$i.'" value = "'.$artdesc.'" />';
			$salida.= '<input type = "hidden" name = "artn'.$i.'" id = "artn'.$i.'" value = "'.$artn.'" />';
			$salida.= '</td>';
			//Cantidad
			$cant = trim($row["dcom_cantidad"]);
			$prec = trim($row["dcom_precio"]);
			$prev = trim($row["art_precio"]);
			$margen = trim($row["art_margen"]);
			$prem = ($prec + $margen); //precio + margen
			$salida.= '<td class = "text-center"><span id = "spancant'.$i.'">'.$cant.'</span>';
			$salida.= '<input type = "hidden" name = "cant'.$i.'" id = "cant'.$i.'" value = "'.$cant.'" />';
			$salida.= '<input type = "hidden" name = "prem'.$i.'" id = "prem'.$i.'" value = "'.$prem.'" />';
			$salida.= '<input type = "hidden" name = "prec'.$i.'" id = "prec'.$i.'" value = "'.$prec.'" />';
			$salida.= '<input type = "hidden" name = "prev'.$i.'" id = "prev'.$i.'" value = "'.$prev.'" />';
			$salida.= '</td>';
			//Proveedor
			$proc = $row["prov_id"];
			$pronom = utf8_decode($row["prov_nombre"]);
			$pronit = $row["prov_nit"];
			$salida.= '<td class = "text-center">'.$pronom;
			$salida.= '<input type = "hidden" name = "proc'.$i.'" id = "proc'.$i.'" value = "'.$proc.'" />';
			$salida.= '<input type = "hidden" name = "pronom'.$i.'" id = "pronom'.$i.'" value = "'.$pronom.'" />';
			$salida.= '<input type = "hidden" name = "pronit'.$i.'" id = "pronit'.$i.'" value = "'.$pronit.'" />';
			$salida.= '</td>';
			//---
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-default" onclick = "Show_Fila_Carga('.$i.');" title = "Ver Informaci&oacute;n" ><span class="fa fa-search"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "QuitarFilaCarga('.$i.');" title = "Quitar Fila" ><span class="fa fa-times"></span></button> &nbsp;';
			$salida.= '</td>';
			$salida.= '</tr>';
			$i++;
		}
	}else{
		//----
		$salida.= '<tr>';
		$salida.= '<td class = "text-center" colspan = "6"><strong>No hay harticulos pendientes de cargar a Inventario</strong></tr>';
		//----
	}			
			$i--;
			//----
			$salida.= '<tr>';
			$salida.= '<td class = "text-right" colspan = "7"> '.$i.' Registro(s).';
			$salida.= '<input type = "hidden" name = "filas" id = "filas" value = "'.$i.'"/></td>';
			$salida.= '</tr>';
			//----
			$salida.= '</table>';
			$salida.= '</form>';
			$salida.= '<br>';
	
	return $salida;
}


/////////////////////////// Historiales ///////////////////


function tabla_historiales_inventario($cod,$tipo,$clase,$doc,$suc,$fini,$ffin,$sit){
	$ClsInv = new ClsInventarioSuministro();
	$cont = $ClsInv->count_inventario($cod,$tipo,$clase,$doc,$suc,'',$fini,$ffin,$sit);
	
	if($cont>0){
		$result = $ClsInv->get_inventario($cod,$tipo,$clase,$doc,$suc,'',$fini,$ffin,$sit);
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<th class = "text-center" width = "25px"><span class="fa fa-cogs"></th>';
			$salida.= '<th class = "text-center" width = "25px"><span class="fa fa-cogs"></th>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "90px"># TRANSACCI&Oacute;N</th>';
			$salida.= '<th class = "text-center" width = "80px">TIPO</th>';
			$salida.= '<th class = "text-center" width = "150px">MOTIVO</th>';
			$salida.= '<th class = "text-center" width = "150px">No. DOC.</th>';
			$salida.= '<th class = "text-center" width = "110px">FECHA/HORA</th>';
			$salida.= '<th class = "text-center" width = "110px">EMPRESA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$sit = $row["inv_situacion"];
			$cod = $row["inv_codigo"];
			$tip = $row["inv_tipo"];
			if($sit == 1){
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-danger" onclick = "ConfirmAnular('.$cod.','.$tip.',0)"   title = "Anular Transacci&oacute;n" ><span class="fa fa-trash-o"></span></button> &nbsp;';
			$salida.= '</td>';
			}else if($sit == 0){
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default"  title = "Analuada" ><span class="fa fa-minus" disabled></span></button> &nbsp;';
			$salida.= '</td>';
			}
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-default" onclick = "Ver_Detalle_Inventario('.$cod.','.$tip.')"  title = "Ver Detalle de Historial" ><span class="fa fa-search"></span></button> &nbsp;';
			$salida.= '</td>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = Agrega_Ceros($cod);
			$dato = Agrega_Ceros($tip);
			$codigo = $cod."-".$dato;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//Tipo
			switch($tip){
				case 1: $tipo = "INGRESO"; break;
				case 2: $tipo = "EGRESO"; break;
			}
			$salida.= '<td class = "text-center">'.$tipo.'</td>';
			//Clase
			$clase = $row["inv_clase"];
			$clase = descripcion_clase($clase);
			$salida.= '<td class = "text-center">'.$clase.'</td>';
			//Documento
			$doc = utf8_decode($row["inv_documento"]);
			$salida.= '<td class = "text-center">'.$doc.'</td>';
			//Fecha / Hora
			$fec = $row["inv_fechor"];
			$fec = cambia_fechaHora($fec);
			$salida.= '<td class = "text-center">'.$fec.'</td>';
			//Empresa
			$suc = utf8_decode($row["suc_nombre"]);
			$salida.= '<td class = "text-center">'.$suc.'</td>';
			//--
			$salida.= '</tr>';
			//--
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

function tabla_detalle_historiales($cod,$inv,$tipo){
	$ClsInv = new ClsInventarioSuministro();
	$result = $ClsInv->get_det_inventario($cod,$inv,$tipo);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
			$salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<td class = "text-center" width = "30px" ><b>No.</b></td>';
			$salida.= '<td class = "text-center" width = "100px" ><b># TRANS.</b></td>';
			$salida.= '<td class = "text-center" width = "120px" ><b>No. LOTE</b></td>';
			$salida.= '<td class = "text-center" width = "150px" ><b>PROVEEDOR</b></td>';
			$salida.= '<td class = "text-center" width = "250px" ><b>ARTICULO</b></td>';
			$salida.= '<td class = "text-center" width = "60px" ><b>CANTIDAD</b></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Codigo
			$cod = $row["det_codigo"];
			$inv = $row["det_inventario"];
			$tip = $row["det_tipo"];
			$cod = Agrega_Ceros($cod);
			$inv = Agrega_Ceros($inv);
			$tip = Agrega_Ceros($tip);
			$codigo = $cod."-".$inv."-".$tip;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//Lote
			$lot = $row["lot_codigo"];
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$lot = Agrega_Ceros($lot);
			$art = Agrega_Ceros($art);
			$gru = Agrega_Ceros($gru);
			$codigo = $lot."A".$art."A".$gru;
			$salida.= '<td class = "text-center">'.$codigo.'</td>';
			//Proveedor
			$prov = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">'.$prov.'</td>';
			//Articulo
			$art = utf8_decode($row["art_nombre"]);
			$salida.= '<td class = "text-center">'.$art.'</td>';
			//Cantidad
			$cant = $row["det_cantidad"];
			$salida.= '<td class = "text-center">'.$cant.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}


//echo tabla_detalle_historiales(1,168,2);

///////////////////// KARDEX /////////////////////

function tabla_articulos_kardex($suc,$barc,$cod,$grup,$nom,$desc,$marca,$cumed,$umed,$sit){
	$ClsArt = new ClsSuministro();
	$result = $ClsArt->get_articulo($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit,$suc);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "100px"><span class="fa fa-cogs"></th>';
			$salida.= '<th class = "text-center" width = "100px">GRUPO</th>';
			$salida.= '<th class = "text-center" width = "100px">CODIGO INT.</th>';
			$salida.= '<th class = "text-center" width = "150px">MARCA</th>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-primary" onclick = "Ver_Kardex_A('.$suc.','.$gru.','.$art.')"  title = "Ver kardex lado 1" ><span class="fa fa-list-alt"></span></button> &nbsp;';
			$salida.= '<button type="button" class="btn btn-success" onclick = "Ver_Kardex_B('.$suc.','.$gru.','.$art.')"  title = "Ver kardex lado 2" ><span class="fa fa-list-alt"></span></button> &nbsp;';
			$salida.= '</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-center">'.$grun.'</td>';
			//Codigo Int.
			$barc = $row["art_barcode"];
			$barc = ($barc != "")?$barc:"N/A";
			$salida.= '<td class = "text-center" >'.$barc.'</td>';
			//marca
			$marc = utf8_decode($row["art_marca"]);
			$salida.= '<td class = "text-center">'.$marc.'</td>';
			//nombre
			$nom = utf8_decode($row["art_nombre"]);
			$salida.= '<td class = "text-center">'.$nom.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

function descripcion_clase($clase){
	switch($clase){
		case 'C': $clase = "COMPRA"; break;
		case 'P': $clase = "PRODUCCI&Oacute;N"; break;
		case 'D': $clase = "DONACI&Oacute;N"; break;
		case 'V': $clase = "VENTA"; break;
		case 'D2': $clase = "DESCARGA (DESECHADO)"; break;
		case 'C2': $clase = "A CONSIGNACI&Oacute;N"; break;
		case 'C3': $clase = "DEVOLUCI&Oacute;N CONSIG."; break;
		case 'B': $clase = "BONIFICACI&Oacute;N"; break;
		case 'IF': $clase = "CUADRE DE INVENTARIO FISICO"; break;
		case 'CI': $clase = "CARGA INICIAL DE INVENTARIO"; break;
	}
	return $clase;
}

//echo tabla_tarjeta_frente(1,1,1);
//echo tabla_busca_compra_carga(6);

?>
