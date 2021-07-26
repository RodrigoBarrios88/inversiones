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
	$result = $ClsExa->get_det_examen($examen,$alumno);
	if(is_array($result)){
		foreach($result as $row){
			$titulo = utf8_decode($row["exa_titulo"]);
			$desc = utf8_decode($row["exa_descripcion"]);
			$nota = $row["dexa_nota"];
			$obs = utf8_decode($row["dexa_observaciones"]);
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
	
	$result = $ClsExa->get_pregunta('',$examen);
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
		<i class="fa fa-paste"></i> Observaciones del Evaluaciones, al Alumno <?php echo $alu_nombre." ".$alu_apellido; ?>
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
				<span class="form-control"><?php echo $titulo; ?></span>
			</div>
			<div class="col-xs-5">
				<label>Nota: </label>
				<label class="form-control"><?php echo $nota; ?>/<?php echo $maximo; ?> punto(s)</label>
				<input type = "hidden" name = "examen" id = "examen" value = "<?php echo $examen; ?>" />
				<input type = "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1"> 
				<label>Ponderaci&oacute;n M&aacute;xima: </label>
				<span class="form-control"><?php echo $maximo; ?> Punto(s). / <?php echo $tipocalifica; ?></span>
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
			<div class="col-xs-10 col-xs-offset-1 text-justify">
				<label>Observaciones: </label> <br>
				<span class="text-info"><?php echo $obs; ?></span>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-4 col-xs-offset-4 text-center">
				<button type="button" class="btn btn-success btn-block" id = "limp" onclick = "cerrarModal();"> <span class="fa fa-check"></span> Aceptar </button>
			</div>
		</div>
	</div>
</div>
</body>
</html>
