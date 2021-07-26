<?php 
include_once('../../html_fns.php');

function tabla_catalogo_servicios($grup){
	$ClsSer = new ClsServicio();
	$result = $ClsSer->get_servicio($cod,$grup,$nom,$desc,$barc,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "20px" class = "text-center">No.</th>';
			$salida.= '<th width = "100px" class = "text-center">GRUPO</th>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</th>';
			$salida.= '<th width = "100px" class = "text-center">PRECIO/COSTO</th>';
			$salida.= '<th width = "100px" class = "text-center">PRECIO/VENTA</th>';
			$salida.= '<th width = "50px" class = "text-center">MARGEN</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-center">'.$grun.'</td>';
			//nombre
			$nom = utf8_decode($row["ser_nombre"]);
			$salida.= '<td>'.$nom.'</td>';
			//precio
            $mon = $row["mon_simbolo"];
			$prec = number_format($row["ser_precio_costo"],2,'.','');
			$salida.= '<td class = "text-center">'.$mon.'. '.$prec.'</td>';
			//precio
            $mon = $row["mon_simbolo"];
			$prev = number_format($row["ser_precio_venta"],2,'.','');
			$salida.= '<td class = "text-center">'.$mon.'. '.$prev.'</td>';
			//margen
            $mon = $row["mon_simbolo"];
			$margen = ($prev - $prec);
			$class = ($margen > 0)?"success":"danger";
			$margen = number_format($margen,2,'.','');
			$salida.= '<td class = "text-center"><label class = "text-'.$class.'">'.$mon.'. '.$margen.'</label></td>';
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


function tabla_servicios_barcode($gru,$cant){
	$ClsSer = new ClsServicio();
	$result = $ClsSer->get_servicio($cod,$gru,$nom,$desc,$barc,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "60px" class = "text-center"><span class="fa fa-cogs"></span></th>';
			$salida.= '<th width = "100px" class = "text-center">GRUPO</th>';
			$salida.= '<th width = "150px" class = "text-center">NOMBRE</th>';
			$salida.= '<th width = "100px" class = "text-center">PRECIO/COSTO</th>';
			$salida.= '<th width = "100px" class = "text-center">PRECIO/VENTA</th>';
			$salida.= '<th width = "50px" class = "text-center">MARGEN</th>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$ser = $row["ser_codigo"];
			$gru = $row["gru_codigo"];
			$salida.= '<td class = "text-center" >';
			$salida.= '<a type="button" class="btn btn-default" target = "_blank" href = "REPbarcode.php?gru='.$gru.'&ser='.$ser.'&cant='.$cant.'" title = "Seleccionar Servicio para Imprimir C&oacute;digos" ><span class="fa fa-barcode"></span></a>  &nbsp;';
			$salida.= '</td>';
			//grupo
			$grun = utf8_decode($row["gru_nombre"]);
			$salida.= '<td class = "text-center">'.$grun.'</td>';
			//nombre
			$nom = utf8_decode($row["ser_nombre"]);
			$salida.= '<td>'.$nom.'</td>';
			//precio
            $mon = $row["mon_simbolo"];
			$prec = number_format($row["ser_precio_costo"],2,'.','');
			$salida.= '<td class = "text-center">'.$mon.'. '.$prec.'</td>';
			//precio
            $mon = $row["mon_simbolo"];
			$prev = number_format($row["ser_precio_venta"],2,'.','');
			$salida.= '<td class = "text-center">'.$mon.'. '.$prev.'</td>';
			//margen
            $mon = $row["mon_simbolo"];
			$margen = ($prev - $prec);
			$class = ($margen > 0)?"success":"danger";
			$margen = number_format($margen,2,'.','');
			$salida.= '<td class = "text-center"><label class = "text-'.$class.'">'.$mon.'. '.$margen.'</label></td>';
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

//echo tabla_tarjeta_frente(1,1,1);
//echo tabla_busca_compra_carga(2);

?>
