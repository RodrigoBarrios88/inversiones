<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
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
			<div class="panel-heading"><label><i class="fa fa-warning text-warning"></i> Regresar Contrato para correcciones</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-11 col-xs-11 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
						<input type = "hidden" name = "contrato" id = "contrato" value = "<?php echo $contrato; ?>" />
						<input type = "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
						<input type = "hidden" name = "codigo" id = "codigo" value = "" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label>Comentarios: </label><span class = "text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<textarea class="form-control" id = "coment" name="coment" onkeypress="textoLargo(this)" rows="5" ></textarea>
					</div>
				</div>
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-primary" id = "gra" onclick = "RegresarContrato();"><span class="fa fa-check"></span> Aceptar</button>
					 </div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-12">
						<?php echo tabla_comentarios($alumno,$contrato); ?>
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
			$salida.= '<th class = "text-center" width = "20px"><span class="fa fa-cogs"></span></th>';
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
			$salida.= '<td class = "text-center" >';
			$usuario = $row["comen_usuario_registro"];
			if($usuario == $_SESSION["codigo"]){
			$codigo = $row["comen_codigo"];
			$contrato = $row["comen_contrato"];
			$alumno = $row["comen_alumno"];
			//$salida.= '<button type="button" class="btn btn-default btn-xs" onclick = "xajax_Seleccionar_Comentario(\''.$codigo.'\',\''.$contrato.'\',\''.$alumno.'\');" title = "Editar Comentario" ><span class="fa fa-edit"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs"  onclick = "Deshabilita_Comentario(\''.$codigo.'\',\''.$contrato.'\',\''.$alumno.'\');" title = "Eliminar Comentario" ><span class="fa fa-trash"></span></button>';
			}else{
			//$salida.= '<button type="button" class="btn btn-default btn-xs" title = "Editar Comentario" disabled ><span class="fa fa-edit"></span></button> ';
			$salida.= '<button type="button" class="btn btn-danger btn-xs"  title = "Eliminar Comentario" disabled ><span class="fa fa-trash"></span></button>';
			}
			$salida.= '</td>';
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