<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-group"></i> Listado de Clientes</div>
			<div class="panel-body">
				<div class="row">
					<?php echo tabla_lista_clientes($nit,$nom); ?>
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
				$('#dataTables-example2').DataTable({
					responsive: true
				});
			});
		</script>	
	</body>
</html>

<?php

function tabla_lista_clientes($nit,$nom){
	$ClsCli = new ClsCliente();
	$result = $ClsCli->get_cliente('',$nit,$nom);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "100px" height = "30px"></th>';
		$salida.= '<th class = "text-center" width = "100px">NIT</td>';
		$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
		$salida.= '<th class = "text-center" width = "200px">DIRECCI&Oacute;N</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "SeleccionarCliente('.$i.')" title = "Seleccionar Cliente" ><span class="fa fa-check"></span></button>  &nbsp;';
			$salida.= '</td>';
			//Nit
			$cod = $row["cli_id"];
			$nit = $row["cli_nit"];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Cpnit'.$i.'" value = "'.$nit.'" />';
			$salida.= '<input type = "hidden" id = "Cpcod'.$i.'" value = "'.$cod.'" />';
			$salida.= $nit.'</td>';
			//nombre
			$nom = utf8_decode($row["cli_nombre"]);
			$salida.= '<td class = "text-left">';
			$salida.= '<input type = "hidden" id = "Cpnom'.$i.'" value = "'.$nom.'" />';
			$salida.= $nom.'</td>';
			//direccion
			$dir = utf8_decode($row["cli_direccion"]);
			$salida.= '<td class = "text-left">';
			$salida.= '<input type = "hidden" id = "Ppcontac'.$i.'" value = "'.$dir.'" />';
			$salida.= $dir.'</td>';
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