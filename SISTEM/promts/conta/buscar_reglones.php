<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	//_$POST
	$tipo = $_REQUEST["tipo"];
	$partida = $_REQUEST["par"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label><i class="fa fa-folder-open"></i> Reglones y Sub-Reglones Contables</label></div>
			<div class="panel-body">
				<div class="row">
					<?php echo tabla_subreglones($tipo,$partida); ?>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-times"></span> Cerrar</button>
					</div>
				</div>
				<br>
			</div>
		</div>
		<!-- Page-Level Demo Scripts - Tables - Use for reference -->
		<script>
			$(document).ready(function() {
				$('#dataTables-promt').DataTable({
					responsive: true
				});
			});
		</script>	
	</body>
</html>

<?php

function tabla_subreglones($tipo,$partida){
	$ClsPar = new ClsPartida();
	$result = $ClsPar->get_subreglon($cod,$partida,$reglon,$tipo,$desc,$sit);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-promt">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cog"></span></th>';
			$salida.= '<th class = "text-center" width = "170px">CLASE</td>';
			$salida.= '<th class = "text-center" width = "150px">PARTIDA</td>';
			$salida.= '<th class = "text-center" width = "150px">REGL&Oacute;N</td>';
			$salida.= '<th class = "text-center" width = "150px">SUB-REGL&Oacute;N</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;
		foreach($result as $row){
			$salida.= '<tr>';
			//--
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//codigo
			$partida = $row["par_codigo"];
			$reglon = $row["reg_codigo"];
			$subreglon = $row["sub_codigo"];
			$salida.= '<td class = "text-center">';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "SeleccionaSubreglon('.$partida.','.$reglon.','.$subreglon.');" title = "Seleccionar Sub-Reglon" ><i class="fa fa-check"></i></button> ';
			$salida.= '</td>';
			//clases
			$clase = utf8_decode($row["cla_descripcion"]);
			$salida.= '<td class = "text-center">'.$clase.'</td>';
			//paritda
			$part = utf8_decode($row["par_descripcion"]);
			$salida.= '<td align = "left">'.$part.'</td>';
			//reglon
			$reg = utf8_decode($row["reg_desc_lg"]);
			$salida.= '<td align = "left">'.$reg.'</td>';
			//subreglon
			$sub = utf8_decode($row["sub_descripcion"]);
			$salida.= '<td align = "left">'.$sub.'</td>';
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

?>