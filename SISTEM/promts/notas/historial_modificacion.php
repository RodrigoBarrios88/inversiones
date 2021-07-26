<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$alumno = $_REQUEST["cui"];
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$materia = $_REQUEST["materia"];
	$unidad = $_REQUEST["unidad"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-list"></i> Historial de Cambios o Modificaciones</div>
			<div class="panel-body">
				<div class="row">
					<?php echo tabla_lista_cambios($alumno,$pensum,$nivel,$grado,$materia,$unidad); ?>
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

function tabla_lista_cambios($alumno,$pensum,$nivel,$grado,$materia,$unidad){
	$ClsNot = new ClsNotas();
	$result = $ClsNot->get_modificacion_nota($codigo,$alumno,$pensum,$nivel,$grado,$materia,$unidad);
	
	if(is_array($result)){
		$salida.= '<div class="panel-body">';
		$salida.= '<div class="dataTable_wrapper">';
		$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
		$salida.= '<thead>';
		$salida.= '<tr>';
		$salida.= '<th class = "text-center" width = "10px">No.</th>';
		$salida.= '<th class = "text-center" width = "110px">Fecha/Hora</td>';
		$salida.= '<th class = "text-center" width = "110px">Usuario que modific&oacute;</td>';
		$salida.= '<th class = "text-center" width = "30px">Actividades Anteriores</td>';
		$salida.= '<th class = "text-center" width = "30px">Nota Anteriores</td>';
		$salida.= '<th class = "text-center" width = "30px">Total Anteriores</td>';
		$salida.= '<th class = "text-center" width = "200px">Justificaci&oacute;n</td>';
		$salida.= '</tr>';
		$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >'.$i.'.</td>';
			//Fecha
			$fechor = cambia_fechaHora($row["mod_fechor"]);
			$salida.= '<td class = "text-center">'.$fechor.'</td>';
			//Usuario
			$usuario = utf8_decode($row["mod_usuario_nombre"]);
			$salida.= '<td class = "text-left">'.$usuario.'</td>';
			//Zona
			$zona = trim($row["mod_zona_anterior"]);
			$salida.= '<td class = "text-center">'.$zona.'</td>';
			//Zona
			$nota = trim($row["mod_nota_anterior"]);
			$salida.= '<td class = "text-center">'.$nota.'</td>';
			//Zona
			$total = trim($row["mod_total_anterior"]);
			$salida.= '<td class = "text-center">'.$total.'</td>';
			//direccion
			$justitificacion = utf8_decode($row["mod_justificacion"]);
			$salida.= '<td class = "text-left">'.$justitificacion.'</td>';
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