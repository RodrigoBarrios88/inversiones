<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$examen = $_REQUEST["examen"];
	$alumno = $_REQUEST["alumno"];
	$fila = $_REQUEST["fila"];
	
	$ClsExa = new ClsExamen();
	$result = $ClsExa->get_det_examen_curso($examen,$alumno);
	if(is_array($result)){
		foreach($result as $row){
			$titulo = utf8_decode($row["exa_titulo"]);
			$desc = utf8_decode($row["exa_descripcion"]);
			$desc = nl2br($desc);
			$nota = $row["dexa_nota"];
			$obs = utf8_decode($row["dexa_observaciones"]);
			$obs = nl2br($obs);
			$nota = ($nota == 0)?"":$nota;
			$situacion = trim($row["dexa_situacion"]);
			//--
			$tipocalifica = trim($row["exa_tipo_calificacion"]);
			switch($tipocalifica){
				case "Z": $tipocalifica = " Actividades"; break;
				case "E": $tipocalifica = " Evaluaciones"; break;
			}
		}
		if($situacion == 1){
			$situacion_desc ='<span class = "text-muted"><i class="fa fa-clock-o"></i> Sin Resolver</span> &nbsp; ';
		}else if($situacion == 2){
			$situacion_desc ='<span class = "text-info"><i class="fa fa-check"></i> Resuelto</span> &nbsp; ';
		}else if($situacion == 3){
			$situacion_desc ='<span class = "text-success"><i class="fa fa-check-circle-o"></i> Calificado</span> &nbsp; ';
		}
	}
	
	$result = $ClsExa->get_pregunta_curso('',$examen);
	$maximo = 0;
	if(is_array($result)){
		foreach ($result as $row){
			$maximo+= trim($row["pre_puntos"]);
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
		<i class="fa fa-edit"></i> Modificar Evaluaciones del Alumno <?php echo $alu_nombre." ".$alu_apellido; ?>
		<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" onclick="cerrarModal();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>T&iacute;tulo: </label>
				<span class="form-info"><?php echo $titulo; ?></span>
			</div>
			<div class="col-xs-5">
				<label>Nota: </label>
				<input type = "text" class = "form-control" name = "nota" id = "nota"  value = "<?php echo $nota; ?>" onkeyup="decimales(this)" onblur = "ValidaMaximoPunteo(this.value);" />
				<input type = "hidden" name = "examen" id = "examen" value = "<?php echo $examen; ?>" />
				<input type = "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
				<input type = "hidden" name = "maximo" id = "maximo" value = "<?php echo $maximo; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1"> 
				<label>Ponderaci&oacute;n M&aacute;xima: </label>
				<span class="form-info"><?php echo $maximo; ?> Punto(s). / <?php echo $tipocalifica; ?></span>
			</div>
			<div class="col-xs-5">
				<label>Situaci&oacute;n: </label>
				<span class="form-control"><?php echo $situacion_desc; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-justify">
				<label>Descripci&oacute;n: </label> <br>
				<span class="text-info"><?php echo $desc; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Observaciones:  <small class = "text-muted">(Opcional)</small></label>
				<textarea class="form-control" id = "obs" name = "obs" rows="5" onkeyup="textoLargo(this)" ><?php echo $obs; ?></textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 text-center">
				<button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"> <span class="fa fa-times"></span> Cancelar </button>
				<button type="button" class="btn btn-primary" id = "limp" onclick = "GrabarCalificacion(<?php echo $fila; ?>);"> <span class="fa fa-check"></span> Aceptar </button>
			</div>
		</div>
	</div>
</div>
</body>
</html>