<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$nivel = $_SESSION["nivel"];
	//$_post
	$filaalumno = $_REQUEST["filaalumno"];
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel-body">
			<div class="row">
				<?php echo tabla_lista_clientes($nit,$nom); ?>
				<input type = "hidden" name ="filaalumno" id ="filaalumno" value="<?php echo $filaalumno; ?>" />
			</div>
			<br>
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					<button type="button" class="btn btn-danger" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
				</div>
			</div>
			<br>
		</div>
		<!-- Page-Level Los Olivos Scripts - Tables - Use for reference -->
		<script type="text/javascript">
			$(document).ready(function() {
				$('#dataTables-example2').dataTable({
					"sPaginationType": "full_numbers",
					responsive: true
				});
			});
		</script>
	</body>
</html>

<?php

function tabla_lista_clientes($nit,$nom){
	$ClsCli = new ClsCliente();
	$cont = $ClsCli->count_cliente('',$nit,$nom);
	
	if($cont>0){
		$result = $ClsCli->get_cliente('',$nit,$nom);
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
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Cpnom'.$i.'" value = "'.$nom.'" />';
			$salida.= $nom.'</td>';
			//direccion
			$dir = $row["cli_direccion"];
			$salida.= '<td class = "text-center">';
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