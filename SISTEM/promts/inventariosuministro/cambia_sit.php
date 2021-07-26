<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	
	$cod = $_REQUEST["cod"];
	$tipo = $_REQUEST["tipo"];
	$sit = $_REQUEST["sit"];

?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Anulaci&oacute;n de Movimiento a Inventario</h5>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<h5 class = "text-danger">
							Esta seguro de Anular el Movimiento # <?php echo Agrega_Ceros($cod); ?>?<br>
							Revertira las transacciones adjuntas a esta....
						</h5>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label>Justificaci&oacute;n: </label></div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<textarea id="just1" name="just1" class = "form-control" onkeyup = "texto(this);"></textarea>
						<input type = "hidden" name = "cod1" id = "cod1" value = "<?php echo $cod; ?>" />
						<input type = "hidden" name = "tipo1" id = "tipo1" value = "<?php echo $tipo; ?>" />
						<input type = "hidden" name = "sit1" id = "sit1" value = "<?php echo $sit; ?>" />
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-danger" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-primary" onclick = "CambiarSituacion();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<br>
			</div>
		</div>
	</body>
</html>
