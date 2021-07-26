<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION['sucursal'];
	$sucCodigo = $_SESSION['sucCodigo'];
	$nivel = $_SESSION["nivel"];
	//--
	$contrato = $_REQUEST["contrato"];
	$alumno = $_REQUEST["alumno"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label><i class="fa fa-warning text-warning"></i> Comentarios de Contrato para Correcciones</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<?php echo tabla_comentarios($alumno,$contrato); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-success" onclick = "cerrarModal();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
			</div>		
		</div>	
	</body>
</html>
<?php

function tabla_comentarios($alumno,$contrato){
	$ClsIns = new ClsInscripcion();
	$result =  $ClsIns->get_comentario('',$alumno,$contrato,1);
	
	if(is_array($result)){
			$salida.= '<div class="panel-body">';
            $salida.= '<div class="dataTable_wrapper">';
			$salida.= '<table class="table table-striped table-bordered table-hover" id="dataTables-psico">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th class = "text-center" width = "10px">No.</th>';
			$salida.= '<th class = "text-center" width = "70px">FECHA/REGISTRO</td>';
			$salida.= '<th class = "text-center" width = "200px">COMENTARIO</td>';
			$salida.= '<th class = "text-center" width = "70px">REGISTR&Oacute;</td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i=1;
		foreach($result as $row){
			$salida.= '<tr>';
			$salida.= '<td class = "text-center">'.$i.'.</td>';
			//fecha
			$fechor = $row["comen_fechor_registro"];
			$fechor = cambia_fechaHora($fechor);
			$salida.= '<td class = "text-center">'.$fechor.'</td>';
			//comentario
			$coment = utf8_decode($row["comen_comentario"]);
			$coment = nl2br($coment);
			$salida.= '<td class = "text-justify">'.$coment.'</td>';
			//usuario
			$usuario_nom = utf8_decode($row["usu_nombre_registro"]);
			$salida.= '<td class = "text-justify">'.$usuario_nom.'</td>';
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