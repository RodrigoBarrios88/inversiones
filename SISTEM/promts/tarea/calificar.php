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
	$result = $ClsTar->get_det_tarea($tarea,$alumno);
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
				case 'E': $tipocal = " Evaluaciones"; break;
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
			<div class="col-xs-5 text-left">
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
			<div class="col-xs-5 text-left">
				<label>Tipo/Calificaci&oacute;n: </label>
				<span class="form-info"><?php echo $tipocal; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Descripci&oacute;n: </label> <br>
				<p class="text-primary"><?php echo $desc; ?></p>
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
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<?php echo tabla_archivos_respuesta($tarea,$alumno); ?>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php

function tabla_archivos_respuesta($tarea,$alumno){
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_respuesta_tarea_archivo('',$tarea,$alumno,'');
	
	if(is_array($result)){
		$Thoras = 0;
		
		$i = 1;	
		foreach($result as $row){
			//nombre
			$nombre = utf8_decode($row["arch_nombre"]);
			//descripcion
			$desc = utf8_decode($row["arch_descripcion"]);
			//archivos
			$extension = trim($row["arch_extencion"]);
			switch($extension){
				case "doc": $icono = '<i class = "fa fa-file-word-o fa-2x text-info"></i>'; break;
				case "docx": $icono = '<i class = "fa fa-file-word-o fa-2x text-info"></i>'; break;
				case "ppt": $icono = '<i class = "fa fa-file-powerpoint-o fa-2x text-danger"></i>'; break;
				case "pptx": $icono = '<i class = "fa fa-file-powerpoint-o fa-2x text-danger"></i>'; break;
				case "xls": $icono = '<i class = "fa fa-file-excel-o fa-2x text-success"></i>'; break;
				case "xlsx": $icono = '<i class = "fa fa-file-excel-o fa-2x text-success"></i>'; break;
				case "jpg": $icono = '<i class = "fa fa-file-picture-o fa-2x text-muted"></i>'; break;
				case "jpeg": $icono = '<i class = "fa fa-file-picture-o fa-2x text-muted"></i>'; break;
				case "png": $icono = '<i class = "fa fa-file-picture-o fa-2x text-muted"></i>'; break;
				case "pdf": $icono = '<i class = "fa fa-file-pdf-o fa-2x text-warning"></i>'; break;
			}
			//archivo
			$archivo = trim($row["arch_codigo"])."_".trim($row["arch_tarea"])."_".trim($row["arch_alumno"]).".".trim($row["arch_extencion"]);
			;
			//--
		}
			$salida.= '</table>';
			$archivo = trim($row["arch_codigo"])."_".trim($row["arch_tarea"])."_".trim($row["arch_alumno"]).".".trim($row["arch_extencion"]);
            $salida.= '<iframe src="../../../../CONFIG/DATALMSALUMNOS/TAREAS/MATERIAS/'.$archivo.'" width="100%" height="345"></iframe>';

	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-warning"></i> No se registran archivos adjuntos en esta tarea...';
		$salida.= '</h5>';
	}
	
	return $salida;
}


?>