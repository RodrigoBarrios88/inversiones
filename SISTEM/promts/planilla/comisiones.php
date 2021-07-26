<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$nomina = $_REQUEST["nomina"];
	$personal = $_REQUEST["personal"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label><i class="fa fa-money"></i>  Comisiones</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
						<input type = "hidden" name = "nomina1" id = "nomina1" value = "<?php echo $nomina; ?>" />
						<input type = "hidden" name = "prsonal1" id = "personal1" value = "<?php echo $personal; ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<?php echo tabla_comisiones($nomina,$personal); ?>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-success" onclick = "cerrarModal();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>	
	</body>
</html>
<?php

function tabla_comisiones($nomina,$personal){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_comisiones($nomina,$personal,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "25px">MONTO</td>';
			$salida.= '<th class = "text-center" width = "25px">TIPO DE CAMBIO</td>';
			$salida.= '<th class = "text-center" width = "25px">TOTAL</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		$Total = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["com_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//monto
			$moneda = utf8_decode($row["mon_simbolo"]);
			$monto = utf8_decode($row["com_monto"]);
			$salida.= '<td class = "text-center">'.$moneda.' '.$monto.'</td>';
			//tipo de cambio
			$tcambio = utf8_decode($row["com_tipo_cambio"]);
			$salida.= '<td class = "text-center">'.$tcambio.' x 1</td>';
			//total
			$total = $monto*$tcambio;
			$total = round($total,2);
			$Total+= $total;
			$salida.= '<td class = "text-center">Q. '.$total.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//--
			$Total = round($Total,2);
			$salida.= '<tr>';
			$salida.= '<th class = "text-right" colspan = "4">TOTAL &nbsp;</th>';
			$salida.= '<th class = "text-center">Q. '.$Total.'</th>';
			$salida.= '</tr>';
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
