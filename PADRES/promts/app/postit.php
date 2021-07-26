<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$codigo = $_REQUEST['codigo'];
	
	$ClsPost = new ClsPostit();
	$result = $ClsPost->get_postit($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$target = trim($row["post_target"]);
			$target_nombre = trim(utf8_decode($row["post_target_nombre"]));
			$target = ($target != "")?$target_nombre:"TODOS";
			$titulo = utf8_decode($row["post_titulo"]);
			$descripcion = utf8_decode($row["post_descripcion"]);
			$descripcion = nl2br($descripcion);
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
		<i class="fas fa-thumbtack"></i>
		Texto de la Nota
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-5 col-lg-offset-1">
				<label>Target:</label><br>
				<span class="text-info"><?php echo $target; ?></span>
			</div>
			<div class="col-lg-5" id="divalumnos">
				<label>T&iacute;tulo:</label><br>
				<span class="text-info"><?php echo $titulo; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1">
				<label>Descripci&oacute;n:</label>
				<p class="text-info text-justify"><?php echo $descripcion; ?></p>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-lg-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><i class="fa fa-times"></i> cerrar</button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>
