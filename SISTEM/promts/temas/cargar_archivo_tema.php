<?php
	include_once('../../html_fns.php');
	$usuario = $_SESSION["codigo"];
	//$_POST
	$tema = $_REQUEST["tema"];
	$fila = $_REQUEST["fila"];
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<form action="EXEcarga_archivo_tema.php" name = "f2" name = "f2" method="post" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-cloud-upload"></i> Cargar Archivo </div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Nombre:</label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<input type = "text" class = "form-control" name = "Filenom" id = "Filenom" onkeyup="texto(this);" />
					</div>
					<div class="col-xs-5" id = "PromtNota"></div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label>Descripci&oacute;n:</label></div>
					</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<textarea class = "form-control" name = "Filedesc" id = "Filedesc" rows="5" onkeyup="textoLargo(this);" ></textarea>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<button type="button" class="btn btn-outline btn-primary btn-block" onclick = "FileJs();">
							<i class="fa fa-cloud-upload"></i> Seleccionar Archivo
							<i class="fa fa-file-picture-o text-muted"></i> <i class="fa fa-file-word-o text-info"></i> <i class="fa fa-file-powerpoint-o text-danger"></i> <i class="fa fa-file-excel-o text-success"></i> <i class="fa fa-file-pdf-o text-warning"></i> 
						</button>
						<input type = "file" id = "archivo" name = "archivo" class = "hidden" onchange="GrabarArchivos();">
						<input type = "hidden" id = "Filecodigo" name = "Filecodigo" value = "" />
						<input type = "hidden" id = "Filetema" name = "Filetema" value = "<?php echo $tema; ?>" />
						<input type = "hidden" id = "Fileextension" name = "Fileextension" />
						<input type = "hidden" id = "fila" name = "fila" value = "<?php echo $fila; ?>" />
					</div>	
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12 text-center">
					    <button type="button" class="btn btn-default" onclick = "cerrarModal();"><i class="fa fa-times"></i> Cancelar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>	
		</form>
	</body>
</html>