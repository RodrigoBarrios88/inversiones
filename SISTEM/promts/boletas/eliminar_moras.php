<?php
	include_once('../../html_fns.php');
	//$_POST
	$grupo = $_REQUEST["grupo"];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    </head>
<body>	
<div class="panel panel-default">
	<div class="panel-heading">
		<strong class=" text-danger">
			<i class="fa fa-times"></i> Anulaci&oacute;n de Moras en Grupo
		</strong>
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h4> &iquest;Esta seguro de anular estas boletas de mora?</h4>
				<input type="hidden" id="grupo1" name="grupo1" value = "<?php echo $grupo; ?>" />
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Justificaci&oacute;n de la Anulaci&oacute;n:</label>
				<textarea class="form-control" id="justifica1" name="justifica1" onkeyup="texto(this);" ></textarea>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrar();"><span class="fa fa-times"></span> Cancelar</button>
				<button type="button" class="btn btn-danger" id = "mod" onclick = "EliminarMoras();"><span class="fa fa-trash-o"></span> Eliminar</button>
			</div>
		</div>
	</div>
</div>
</body>
</html>