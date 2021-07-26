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
			//observaciones
			$obs = utf8_decode($row["inc_observaciones"]);
			$obs = nl2br($obs);
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
				case 10: $status = '<span class = "text-danger">- Cancelado -</span>'; break;
				case 1: $status = '<span class = "text-muted">Reportado</span>'; break;
				case 2: $status = '<span class = "text-info">Recibido y en tr&aacute;mite</span>'; break;
				case 3: $status = '<span class = "text-info">En evaluaci&oacute;n y soluci&oacute;n</span>'; break;
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
		<i class="fa fa-info-circle"></i> Informaci&oacute;n del Incidente
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>M&oacute;dulo: </label>
				<label class = "form-info"><?php echo $modulo; ?></label>
			</div>
			<div class="col-xs-5">
				<label>Plataforma: </label> 
				<label class = "form-info"><?php echo $plataforma; ?></label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>T&iacute;po de Incidente: </label> 
				<label class = "form-info"><?php echo $tipo; ?></label>
			</div>
			<div class="col-xs-5">
				<label>Prioridad: </label> 
				<label class = "form-info"><?php echo $prioridad; ?></label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Persona que Reporta (Usuario Padre): </label> <span class = "text-muted">(No es obligatorio)</span>
				<label class = "form-control"><?php echo $persona; ?></label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Status: </label> <span class = "text-muted">(No es obligatorio)</span>
				<label class = "form-control"><?php echo $status; ?></label>	
			</div>
			<div class="col-xs-5">
				<label>Fecha del Reporte: </label> 
				<label class = "form-control"><?php echo $freg; ?></label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Descripci&oacute;n del Problema:</label> <br>
				<p class="text-justify"><?php echo $desc; ?></p>
			</div>	
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Observaciones:</label> <br>
				<?php if($_SESSION["tipo_usuario"] == 5){ ?>
				<textarea class = "form-control" name = "obs" id = "obs" rows="3" onkeyup = "textoLargo(this);" ><?php echo $obs; ?></textarea>
				<?php }else{ ?>
				<p class="text-justify"><?php echo $obs; ?></p>
				<?php } ?>
			</div>	
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 text-center">
				<?php if($sit != 10){ ?>
				<button type="button" class="btn btn-danger" onclick = "Eliminacion(<?php echo $codigo; ?>);"><span class="fa fa-trash"></span> Eliminar</button> &nbsp;
				<?php } ?>
				<?php if($_SESSION["tipo_usuario"] == 5){ ?>
					<?php if($sit > 1 && $sit != 10){ ?>
					<button type="button" class="btn btn-default" onclick = "Situacion(<?php echo $codigo; ?>,<?php echo $sit-1; ?>);"><span class="fa fa-rotate-left"></span> Situaci&oacute; Anterior</button> &nbsp;
					<?php } ?>
					<?php if($sit < 4){ ?>
					<button type="button" class="btn btn-primary" onclick = "Situacion(<?php echo $codigo; ?>,<?php echo $sit+1; ?>);"><span class="fa fa-rotate-right"></span> Siguente Situaci&oacute;n</button>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" onclick = "cerrar();"><span class="fa fa-times"></span> Cerrar</button>
			</div>
		</div>
	</div>
	<br>
</div>
</body>
</html>
