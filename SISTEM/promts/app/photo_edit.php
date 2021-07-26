<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$codigo = $_REQUEST['codigo'];
	
	$ClsPho = new ClsPhoto();
	$result = $ClsPho->get_photo($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$descripcion = trim(utf8_decode($row["pho_descripcion"]));
		}	
	}	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
<body>	
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-pencil"></i>
		Editar la descripci&oacute;n del Album
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Descripci&oacute;n: <small class="text-muted">(Opcional)</small></label>
				<textarea class="form-control" id = "desc" name = "desc" rows="5" onkeyup="textoLargo(this)"><?php echo $descripcion; ?></textarea>
				<input type = "hidden" id="codigo" name = "codigo" value="<?php echo $codigo; ?>" />
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" onclick = "cerrarModal();"><i class="fa fa-times"></i> Cerrar</button>
				<button type="button" class="btn btn-primary" onclick = "Modificar();"><i class="fa fa-save"></i> Grabar</button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>