<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$tarea = $_REQUEST["tarea"];
	$alumno = $_REQUEST["alumno"];
	$fila = $_REQUEST["fila"];
	
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_det_tarea_curso($tarea,$alumno);
	if(is_array($result)){
		foreach($result as $row){
			$nombre = utf8_decode($row["tar_nombre"]);
			$desc = utf8_decode($row["tar_descripcion"]);
			$desc = nl2br($desc);
			$nota = $row["dtar_nota"];
			$obs = utf8_decode($row["dtar_observaciones"]);
			$nota = ($nota == 0)?"":$nota;
			//ponderacion
			$pondera = trim($row["tar_ponderacion"]);
			$tipocalifica = trim($row["tar_tipo_calificacion"]);
			switch($tipocalifica){
				case 'Z': $tipocal = " Actividades"; break;
				case 'E': $tipocal = " AL Evaluaciones"; break;
			}
			$maximo = trim($row["tar_ponderacion"]);
		}
	}
	
	$ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno($alumno,"","",1);
	if(is_array($result)){
		foreach($result as $row){
			$alu_cui = $row["alu_cui"];
			$alu_nombre = utf8_decode($row["alu_nombre"]);
			$alu_apellido = utf8_decode($row["alu_apellido"]);
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
		<i class="fa fa-edit"></i> Calificar Tarea del Alumno <?php echo $alu_nombre." ".$alu_apellido; ?>
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Tarea: </label>
				<span class="form-info"><?php echo $nombre; ?></span>
			</div>
			<div class="col-xs-5">
				<label>Nota: </label>
				<input type = "text" class = "form-control" name = "nota" id = "nota"  value = "<?php echo $nota; ?>" onkeyup="decimales(this)" onblur = "ValidaMaximoPunteo(this.value);" />
				<input type = "hidden" name = "tarea" id = "tarea" value = "<?php echo $tarea; ?>" />
				<input type = "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
				<input type = "hidden" name = "maximo" id = "maximo" value = "<?php echo $maximo; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Ponderaci&oacute;n: </label>
				<span class="form-info"><?php echo $pondera; ?> Punto(s).</span>
			</div>
			<div class="col-xs-5">
				<label>Tipo/Calificaci&oacute;n: </label>
				<span class="form-info"><?php echo $tipocal; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Descripci&oacute;n: </label> <br>
				<span class="text-primary"><?php echo $desc; ?></span>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Observaciones:  <small class = "text-info">(Opcional)</small></label>
				<textarea class="form-control" id = "obs" name = "obs" onkeyup="texto(this)" rows="5" onkeyup="textoLargo(this)" ><?php echo $obs; ?></textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"> <span class="fa fa-times"></span> Cancelar </button>
				<button type="button" class="btn btn-primary" id = "limp" onclick = "GrabarCalificacion(<?php echo $fila; ?>);"> <span class="fa fa-check"></span> Aceptar </button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>
