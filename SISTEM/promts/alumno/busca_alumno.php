<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel-body">
			<div class="row">
				<?php echo tabla_lista_alumnos($cui,$nom,$ape); ?>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 text-center">
					<button type="button" class="btn btn-danger" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
				</div>
			</div>
			<br>
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

function tabla_lista_alumnos($cui,$nom,$ape){
	$ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno($cui,$nom,$ape,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-example2">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "100px" height = "30px"></th>';
			$salida.= '<th class = "text-center" width = "100px">CUI</td>';
			$salida.= '<th class = "text-center" width = "200px">NOMBRE</td>';
			$salida.= '<th class = "text-center" width = "200px">DIRECCI&Oacute;N</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			//codigo
			$salida.= '<td class = "text-center" >';
			$salida.= '<button type="button" class="btn btn-success btn-xs" onclick = "SeleccionarAlumno('.$i.')" title = "Seleccionar Alumno" ><span class="fa fa-check"></span></button>  &nbsp;';
			$salida.= '</td>';
			//Nit
			$cui = $row["alu_cui"];
			$cli = $row["alu_cliente_factura"];
			$nit = $row["alu_nit"];
			$clinom = $row["alu_cliente_nombre "];
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Acui'.$i.'" value = "'.$cui.'" />';
			$salida.= '<input type = "hidden" id = "Acli'.$i.'" value = "'.$cli.'" />';
			$salida.= '<input type = "hidden" id = "Anit'.$i.'" value = "'.$nit.'" />';
			$salida.= '<input type = "hidden" id = "Aclinom'.$i.'" value = "'.$clinom.'" />';
			$salida.= $cui.'</td>';
			//nombre
			$nom = utf8_decode($row["alu_nombre"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Anom'.$i.'" value = "'.$nom.'" />';
			$salida.= $nom.'</td>';
			//direccion
			$ape = utf8_decode($row["alu_apellido"]);
			$salida.= '<td class = "text-center">';
			$salida.= '<input type = "hidden" id = "Aape'.$i.'" value = "'.$ape.'" />';
			$salida.= $ape.'</td>';
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