<?php 
include_once('../../html_fns.php');

function tabla_articulos_barcode($cod,$grup,$cant){
	$ClsArt = new ClsSuministro();
	$result = $ClsArt->get_articulo($cod,$grup,$nom,$desc,$marca,$cumed,$umed,$barc,$sit,$suc);
	
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
			$salida.= '<a type="button" class="btn btn-default" target = "_blank" href = "REPbarcode.php?gru='.$gru.'&art='.$art.'&cant='.$cant.'" title = "Seleccionar Art&iacute;culo para Imprimir C&oacute;digos" ><span class="fa fa-barcode"></span></a>  &nbsp;';
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
			$prec = $row["art_precio"];
			$salida.= '<td class = "text-center">'.$mon.'. '.$prec.'</td>';
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
