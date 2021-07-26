<?php
	include_once('html_fns_rrhh.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$filas = $_REQUEST["filas"];
	
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
	<br>
	<table class="table table-striped table-bordered">
		<tr>
			<th class="text-center">No.</th>
			<th class="text-center">Nombres</th>
			<th class="text-center">Apellidos</th>
			<th class="text-center">Nacionalidad</th>
			<th class="text-center">Religi&oacute;n</th>
			<th class="text-center">Fecha de Nacimiento</th>
		</tr>
<?php
	if($filas > 0){	
		for($i = 1; $i <= $filas; $i++){
?>
		<tr>
			<th class="text-center"><?php echo $i; ?>.</th>
			<td>
			<input type="text" class="form-control" id="nomhermano<?php echo $i; ?>" name="nomhermano<?php echo $i; ?>" onkeyup = "texto(this);">
			</td>
			<td>
			<input type="text" class="form-control" id="apehermano<?php echo $i; ?>" name="apehermano<?php echo $i; ?>" onkeyup = "texto(this);">
			</td>
			<td>
			<?php echo Paises_html("paishermano$i",""); ?>
			</td>
			<td>
			<input type="text" class="form-control" id="religionhermano<?php echo $i; ?>" name="religionhermano<?php echo $i; ?>" onkeyup = "texto(this);">
			</td>
			<td>
			<div class="input-group date" id="groupfecnachijo<?php echo $i; ?>">
				<input type="text" class="form-control" id = "fecnachermano<?php echo $i; ?>" name="fecnachermano<?php echo $i; ?>" />
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
			</td>
		</tr>
<?php
		}
	}else{
?>
		<tr>
			<th class="text-center">1.</th>
			<td>
			<input type="text" class="form-control" id="nomhermano1" name="nomhermano1" onkeyup = "texto(this);" disabled />
			</td>
			<td>
			<input type="text" class="form-control" id="apehermano1" name="apehermano1" onkeyup = "texto(this);" disabled />
			</td>
			<td>
			<select id="paishermano1" name="paishermano1" class="form-control" disabled>
			<option value = "">Seleccione</option>
			</select>
			</td>
			<td>
			<input type="text" class="form-control" id="religionhermano1" name="religionhermano1" onkeyup = "texto(this);" disabled />
			</td>
			<td>
			<div class="input-group date">
			<input type="date" class="form-control" id="fecnachermano1" name="fecnachermano1" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
			<span class="input-group-addon" style="cursor:not-allowed"><span class="glyphicon glyphicon-calendar"></span></span>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<script>
<?php
if($filas > 0){	
	for($i = 1; $i <= $filas; $i++){
?>
		$(function () {
            $('#fecnachermano<?php echo $i; ?>').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
<?php
	}
}
?>
	</script>
</body>
</html>

