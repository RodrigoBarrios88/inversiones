<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	
	$ClsAcadem = new ClsAcademico();
	//_POST
	$cui = $_REQUEST["cui"];
	//---
	$pensum = $_SESSION["pensum"];
	$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = trim($row["niv_codigo"]);
			$grado = trim($row["gra_codigo"]);
		}
	}
	
	$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$seccion = trim($row["sec_codigo"]);
		}
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-info" >
			<div class="panel-heading">
				<i class="fa fa-comments"></i>
				<label>Nuevo Comentario Psicopedag&oacute;gico</label>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label> </div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label>Ingrese el Comentario:</label> <span class = "text-danger">*</span></div>
				</div>
				<div class="row">
					<div class="col-xs-10  col-xs-offset-1">
						<textarea class="form-control" name = "coment" id = "coment" onkeyup = "textoLargo(this)" rows="6" ></textarea>
						<input type = "hidden" name = "cui" id = "cui" value = "<?php echo $cui; ?>" />
						<input type = "hidden" name = "pensum" id = "pensum" value = "<?php echo $pensum; ?>" />
						<input type = "hidden" name = "nivel" id = "nivel" value = "<?php echo $nivel; ?>" />
						<input type = "hidden" name = "grado" id = "grado" value = "<?php echo $grado; ?>" />
						<input type = "hidden" name = "seccion" id = "seccion" value = "<?php echo $seccion; ?>" />
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" onclick = "cerrarModal();"><span class="fa fa-times"></span> Cancelar</button>
						<button type="button" class="btn btn-primary" onclick = "GrabarComentario();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
					</div>
				</div>
				<br>
			</div>
		</div>
	</body>
</html>