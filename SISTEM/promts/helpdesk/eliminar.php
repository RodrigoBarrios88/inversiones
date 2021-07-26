<?php
	include_once('../../html_fns.php');
	
	///--- $_POST ---///
	$ClsInc = new ClsIncidente();
	$codigo = $_REQUEST["codigo"];
	$result = $ClsInc->get_incidente($codigo);
	if(is_array($result)){
		foreach($result as $row){
			//desc
			$modulo = utf8_decode($row["mod_descripcion"]);
			//desc
			$plataforma = utf8_decode($row["pla_descripcion"]);
			//tipo
			$tipo = utf8_decode($row["tip_descripcion"]);
			//desc
			$desc = utf8_decode($row["inc_descripcion"]);
			$desc = nl2br($desc);
			//fecha
			$freg = cambia_fechaHora($row["inc_fecha_registro"]);
			//persona
			$persona = utf8_decode($row["inc_persona"]);
			//prioridad
			$prior = trim($row["inc_prioridad"]);
			switch($prior){
				case 'N': $prioridad = "Normal"; break;
				case 'B': $prioridad = "Baja"; break;
				case 'A': $prioridad = "Alta"; break;
				case 'U': $prioridad = "Urgente"; break;
			}
			//situacion
			$sit = trim($row["inc_situacion"]);
			switch($sit){
				case 0: $status = '<span class = "text-danger">- Cancelado -</span>'; break;
				case 1: $status = '<span class = "text-muted">Reportado</span>'; break;
				case 2: $status = '<span class = "text-info">Recibido y en trámite</span>'; break;
				case 3: $status = '<span class = "text-info">En evaluación y solución</span>'; break;
				case 4: $status = '<span class = "text-success">Solucionado</span>'; break;
			}
		}	
	}	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
</head>
<body>	
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-times text-danger"></i> Cancelar Incidente
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<h5 class="alert alert-danger text-center">
					<i class="fa fa-warning fa-2x"></i> <br>
					&iquest;Est&aacute; seguro de cancelar este # de Incidente? <br>
					No se le dar&aacute;a continuidad a este reporte con esta nueva situaci&oacute;n....
				</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Caso #: </label>
				<label class = "form-control"><?php echo Agrega_Ceros($codigo); ?></label>	
			</div>
			<div class="col-xs-5">
				<label>Fecha del Reporte: </label> 
				<label class = "form-control"><?php echo $freg; ?></label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Descripci&oacute;n del Problema:</label> <br>
				<p class="text-justify">
					<?php echo $desc; ?>
				</p>
			</div>	
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Justificaci&oacute;n:</label> <br>
				<textarea class = "form-control" name = "obs" id = "obs" rows="5" onkeyup = "textoLargo(this);" ></textarea>
			</div>	
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" onclick = "cerrar();"><span class="fa fa-times"></span> Cerrar</button>
				<button type="button" class="btn btn-danger" onclick = "Eliminar_Incidente(<?php echo $codigo; ?>);"><span class="fa fa-trash"></span> Eliminar</button> &nbsp;
			</div>
		</div>
	</div>
	<br>
</div>
</body>
</html>
