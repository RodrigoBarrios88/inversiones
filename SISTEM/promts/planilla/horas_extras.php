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
			<div class="panel-heading"><label><i class="fa fa-clock-o"></i> Horas Extras</label></div>
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
						<?php echo tabla_horas_extras($nomina,$personal); ?>
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

function tabla_horas_extras($nomina,$personal){
	$ClsPlaAsi = new ClsPlanillaAsignaciones();
	$result = $ClsPlaAsi->get_horas_extras($nomina,$personal,'');
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "150px">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "25px">CANTIDAD DE HORAS</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		$total = 0;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//descripcion
			$desc = utf8_decode($row["conf_descripcion"]);
			$salida.= '<td class = "text-left">'.$desc.'</td>';
			//cantidad
			$cant = utf8_decode($row["hor_cantidad"]);
			$total+= $cant;
			$salida.= '<td class = "text-center">'.$cant.'</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			//--
			$salida.= '<tr>';
			$salida.= '<th class = "text-right" colspan = "2">TOTAL &nbsp;</th>';
			$salida.= '<th class = "text-center">'.$total.'</th>';
			$salida.= '</tr>';
			$i--;
			$salida.= '</table>';
			$salida.= '</div>';
			$salida.= '</div>';
	}
	
	return $salida;
}

?>
