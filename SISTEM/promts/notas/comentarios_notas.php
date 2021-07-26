<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$alumno = $_REQUEST["cui"];
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$materia = $_REQUEST["materia"];
	$unidad = $_REQUEST["unidad"];
	
	$ClsNot = new ClsNotas();
	$result = $ClsNot->get_comentario_alumno($alumno,$pensum,$nivel,$grado,$materia,$unidad);
	if(is_array($result)){
		foreach($result as $row){
			$comentario = utf8_decode($row["comen_comentario"]);
			$usuario = utf8_decode($row["comen_usuario_nombre"]);
			$fechor = cambia_fechaHora($row["comen_fechor"]);
		}
	}
	
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    </head>
<body>	
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-paste"></i> Observaci&oacute;n para la Tarjeta de Calificaciones
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-default btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h5>
					Esta observaci&oacute;n ser&aacute; &uacute;nicamente impresa en esta tarjeta, de este alumno...<br>
				</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Observaciones y/o Comentarios:  <small class = "text-danger">*</small></label>
				<textarea class="form-control" id = "observaciones" name = "observaciones" onkeyup="textoLargo(this);" rows="5" ><?php echo $comentario; ?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-right">
				<small>&Uacute;ltimo comentario: <?php echo $fechor; ?></small><br>
				<small>Por: <?php echo $usuario; ?></small>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"> <i class="fa fa-times"></i> Cancelar </button>
				<button type="button" class="btn btn-primary" id = "limp" onclick = "GrabarComentario('<?php echo $alumno; ?>',<?php echo $pensum; ?>,<?php echo $nivel; ?>,<?php echo $grado; ?>,<?php echo $materia; ?>,<?php echo $unidad; ?>);"> <i class="fa fa-save"></i> Grabar </button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>
