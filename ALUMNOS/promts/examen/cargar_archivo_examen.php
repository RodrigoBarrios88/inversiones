<?php
	include_once('../../html_fns.php');
	$usuario = $_SESSION["codigo"];
	//$_POST
	$examen = $_REQUEST["examen"];
	$alumno = $_REQUEST["alumno"];
	$fila = $_REQUEST["fila"];
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<form action="EXEcarga_archivo_examen.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fas fa-cloud-upload-alt"></i> Cargar Archivo</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12 col-lg-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6"><label>Nombre:</label></div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<input type = "text" class = "form-control" name = "Filenom" id = "Filenom" onkeyup="texto(this);" />
					</div>
					<div class="col-lg-6" id = "PromtNota"></div>
				</div>
				<div class="row">
					<div class="col-lg-12"><label>Descripci&oacute;n:</label></div>
					</div>
				<div class="row">
					<div class="col-lg-12">
						<textarea class = "form-control" name = "Filedesc" id = "Filedesc" rows="5" onkeyup="textoLargo(this)" ></textarea>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-lg-12 text-center">
						<button type="button" class="btn btn-default btn-block" onclick = "FileJs();">
							<i class="fas fa-cloud-upload-alt"></i> Seleccionar Archivo
							<i class="fas fa-file-image text-muted"></i> <i class="fas fa-file-word text-info"></i> <i class="fas fa-file-powerpoint text-danger"></i> <i class="fas fa-file-excel text-success"></i> <i class="fas fa-file-pdf text-warning"></i> 
						</button>
						<input type = "file" id = "archivo" name = "archivo" class = "hidden" onchange="CargaArchivos();">
						<input type = "hidden" id = "Fileexamen" name = "Fileexamen" value = "<?php echo $examen; ?>" />
						<input type = "hidden" id = "Filealumno" name = "Filealumno" value = "<?php echo $alumno; ?>" />
						<input type = "hidden" id = "Fileextension" name = "Fileextension" />
						<input type = "hidden" id = "fila" name = "fila" value = "<?php echo $fila; ?>" />
					</div>	
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-12 text-center">
					    <button type="button" class="btn btn-default" onclick = "cerrarModal();"><i class="fa fa-times"></i> Cancelar</button>
					</div>
				</div>
				<br>
			</div>		
		</div>	
		</form>
	</body>
</html>

