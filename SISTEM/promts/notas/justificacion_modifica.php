<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$alumno = $_REQUEST["alumno"];
	$nombre = utf8_decode($_REQUEST["nombre"]);
	$zona = $_REQUEST["zona"];
	$nota = $_REQUEST["nota"];
	$total = $_REQUEST["total"];
	
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
		<i class="fa fa-pencil"></i> Justificaci&oacute;n de Modificaci&oacute;n de Nota
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-default btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h5 class="text-danger">
					Para poder modificar la nota del Alumno(a) debera justificar la acci&oacute;n, estipulado quien autoriza y el motivo del la modificaci&oacute;n.<br>
					Tome en cuenta que esta acci&oacute;n quedar&aacute; registrada en la bit&aacute;cora del sistema.
				</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Alumno:  <small class = "text-danger">*</small></label>
				<input type = "text" class = "form-control" value = "<?php echo $nombre; ?>" disabled />
				<input type = "hidden" name = "alumnoX" id = "alumnoX"  value = "<?php echo $alumno; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Actividades: </label>
				<input type = "text" class = "form-control" name = "zonaX" id = "zonaX"  value = "<?php echo $zona; ?>" onkeyup="decimales(this)" />
				<input type = "hidden" name = "zonaOLD" id = "zonaOLD"  value = "<?php echo $zona; ?>" />
			</div>
			<div class="col-xs-5 text-left">
				<label>Nota de Evaluaciones: </label>
				<input type = "text" class = "form-control" name = "notaX" id = "notaX"  value = "<?php echo $nota; ?>" onkeyup="decimales(this)" />
				<input type = "hidden" name = "notaOLD" id = "notaOLD"  value = "<?php echo $nota; ?>" />
				<input type = "hidden" name = "totalOLD" id = "totalOLD"  value = "<?php echo $total; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Justificaci&oacute;n:  <small class = "text-danger">*</small></label>
				<textarea class="form-control" id = "justificacion" name = "justificacion" onkeyup="textoLargo(this);" rows="5" ></textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"> <i class="fa fa-times"></i> Cancelar </button>
				<button type="button" class="btn btn-danger" id = "limp" onclick = "Modificar_Nota(<?php echo $fila; ?>);"> <i class="fa fa-save"></i> Modificar Nota </button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>
