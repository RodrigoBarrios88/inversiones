<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$alumno = $_REQUEST["alumno"];
	$fila = $_REQUEST["fila"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label><i class="fa fa-check"></i> Ingrese el No. de boleta f&iacute;isica girada.</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
						<input type = "hidden" name = "fila" id = "fila" value = "<?php echo $fila; ?>" />
						<input type = "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label># Boleta: </label><span class = "text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<input type = "text" class="form-control text-center" id = "documento" name="documento" onkeypress="enteros(this)" maxlength="6" />
					</div>
				</div>
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-times"></span> Cancelar</button>
						<button type="button" class="btn btn-info" id = "busc" onclick = "Solicitar_Boleta();"><span class="fa fa-check"></span> Aceptar</button>
					 </div>
				</div>
				<br><br><br>
			</div>		
		</div>	
	</body>
</html>