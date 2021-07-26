<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$boton = $_REQUEST["boton"];
	
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
		<i class="fa fa-paste"></i> Observaciones para las Tarjetas de Calificaciones
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-default btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<h4>&iquest;Desea agregar una observaci&oacute;n al bloque de tarjetas de calificaciones a imprimir?</h4><br>
				<h5>
					Esta observaci&oacute;n ser&aacute; repetida en cada tarjeta de cada alumno en este listado...<br>
					(m&aacute;ximo 250 caracteres)
				</h5>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Observaciones:  <small class = "text-muted">(Opcional)</small></label>
				<textarea class="form-control" id = "observaciones" name = "observaciones" onkeyup="texto(this);" rows="5" ></textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"> <span class="fa fa-times"></span> Cancelar </button>
				<button type="button" class="btn btn-primary" id = "limp" onclick = "Observaciones2('Masa','',<?php echo $boton; ?>);"> <span class="fa fa-check"></span> Aceptar </button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>
