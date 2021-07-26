<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	
	$cod = $_REQUEST["cod"];

?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Anulaci&oacute;n de Compa o Gasto</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1 text-justify">
						<h4 class = "text-danger text-center">
							Esta seguro de Anular la Compra &oacute; Gasto # <?php echo Agrega_Ceros($cod); ?>?
						</h4>
						<h5 class = "text-danger text-center">
							Revertira las transacciones adjuntas a esta....
						</h5>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label>Justificaci&oacute;n: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-10 col-xs-offset-1">
						<textarea id="just1" name="just1" class = "form-control"></textarea>
						<input type = "hidden" name = "comp1" id = "comp1" value = "<?php echo $cod; ?>" />
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