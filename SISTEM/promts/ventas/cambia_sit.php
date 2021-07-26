<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	
	$cod = $_REQUEST["cod"];
	$fini = $_REQUEST["fini"];
	$ffin = $_REQUEST["ffin"]; 

?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Anulaci&oacute;n de Factura</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1 text-justify">
						<h5 class = "text-danger">
							Esta seguro de Anular la Venta # <?php echo Agrega_Ceros($cod); ?>?<br>
							Revertira las transacciones adjuntas a esta....
						</h5>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label>Justificaci&oacute;n: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-10 col-xs-offset-1">
						<textarea id="just1" name="just1" class = "form-control"></textarea>
						<input type = "hidden" name = "vent1" id = "vent1" value = "<?php echo $cod; ?>" />
						<input type = "hidden" name = "fini1" id = "fini1" value = "<?php echo $fini; ?>" />
						<input type = "hidden" name = "ffin1" id = "ffin1" value = "<?php echo $ffin; ?>" />
					</div>
				</div>	
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-info" id = "busc" onclick = "CambiarSituacion();"><span class="fa fa-check"></span> Aceptar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>	
	</body>
</html>
