<?php 
include_once('../../html_fns.php');

function tabla_articulos_barcode($gru,$suc,$cant){
	$ClsArt = new ClsArticulo();
	$result = $ClsArt->get_articulo($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,1,$suc);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "60px" class = "text-center"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th width = "120px" class = "text-center">GRUPO</th>';
			$salida.= '<th width = "150px" class = "text-center">MARCA</th>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</th>';
			$salida.= '<th width = "200px" class = "text-center">DESCRIPCI&Oacute;N</th>';
			$salida.= '<th width = "70px" class = "text-center">PRECIO</th>';
			$salida.= '<th width = "30px" class = "text-center">EXISTENCIA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 0;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$art = $row["art_codigo"];
			$gru = $row["gru_codigo"];
			$sit = $row["art_situacion"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default" target = "_blank" href = "REPbarcode.php?gru='.$gru.'&art='.$art.'&cant='.$cant.'" title = "Seleccionar Articulo para Imprimir C&oacute;digos" ><span class="fa fa-barcode"></span></a>  &nbsp;';
			$salida.= '</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td>'.$grun.'</td>';
			//marca
			$marca = utf8_decode($row["art_marca"]);
			$salida.= '<td>'.$marca.'</td>';
			//nombre
			$nom = utf8_decode($row["art_nombre"]);
			$salida.= '<td>'.$nom.'</td>';
			//desc
			$desc = utf8_decode($row["art_desc"]);
			$salida.= '<td>'.$desc.'</td>';
			//precio
            $mon = $row["mon_simbolo"];
			$prec = number_format($row["art_precio"],2,'.','');
			$salida.= '<td class = "text-center">'.$mon.'. '.$prec.'</td>';
			//Existencia
			$exist = $row["art_cant_suc"];
			$salida.= '<td align = "center">'.$exist.'</td>';
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





function tabla_catalogo_articulos($gru,$suc){
	$ClsArt = new ClsArticulo();
	$result = $ClsArt->get_articulo($cod,$gru,$nom,$desc,$marca,$cumed,$umed,$barc,1,$suc);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</th>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</th>';
			$salida.= '<th width = "100px" class = "text-center">MARCA</th>';
			$salida.= '<th width = "100px" class = "text-center">PROVEEDOR</th>';
			$salida.= '<th width = "100px" class = "text-center">PRECIO/COMPRA</th>';
			$salida.= '<th width = "100px" class = "text-center">PRECIO/VENTA</th>';
			$salida.= '<th width = "50px" class = "text-center">MARGEN</th>';
			$salida.= '<th width = "30px" class = "text-center">EXISTENCIA</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//nombre
			$nom = utf8_decode($row["art_nombre"]);
			$salida.= '<td>'.$nom.'</td>';
			//marca
			$marca = utf8_decode($row["art_marca"]);
			$salida.= '<td>'.$marca.'</td>';
			//proveedor
			$proveedor = utf8_decode($row["prov_nombre"]);
			$salida.= '<td>'.$proveedor.'</td>';
			//precio
            $mon = $row["mon_simbolo"];
			$prec = number_format($row["art_precio_costo"],2,'.','');
			$salida.= '<td class = "text-center">'.$mon.'. '.$prec.'</td>';
			//precio
            $mon = $row["mon_simbolo"];
			$prev = number_format($row["art_precio"],2,'.','');
			$salida.= '<td class = "text-center">'.$mon.'. '.$prev.'</td>';
			//margen
            $mon = $row["mon_simbolo"];
			$margen = ($prev - $prec);
			$class = ($margen > 0)?"success":"danger";
			$margen = number_format($margen,2,'.','');
			$salida.= '<td class = "text-center"><label class = "text-'.$class.'">'.$mon.'. '.$margen.'</label></td>';
			//Existencia
			$cant = $row["art_cant_suc"];
			$salida.= '<td align = "center">'.$cant.'</td>';
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


function tabla_lista_proveedores($suc,$papel){
	$ClsProv = new ClsProveedor();
	$result = $ClsProv->get_proveedor('','',$nom,$contact);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "20px">No.</th>';
			$salida.= '<th class = "text-center" width = "100px">NIT</td>';
			$salida.= '<th class = "text-center" width = "200px">PROVEEDOR</td>';
			$salida.= '<th class = "text-center" width = "200px">CONTACTO</td>';
			$salida.= '<th class = "text-center" width = "30px"></th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Nit
			$cod = $row["prov_id"];
			$nit = $row["prov_nit"];
			$salida.= '<td class = "text-center">'.$nit.'</td>';
			//nombre
			$nom = utf8_decode($row["prov_nombre"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Ppnom'.$i.'" value = "'.$nom.'" />';
			$salida.= $nom.'</td>';
			//contacto
			$contacto = utf8_decode($row["prov_contacto"]);
			$salida.= '<td class = "text-center">'.$contacto.'</td>';
			//codigo
			$cod = $row["prov_id"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<a class="text-success" target = "_blank" href = "REPbarcodeProveedor.php?prov='.$cod.'&suc='.$suc.'&papel='.$papel.'" title = "Ver Articulos de Compra al Proveedor" ><span class="fa fa-file-text fa-2x"></span></a> ';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
