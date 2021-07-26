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
			$obs = nl2br($obs);
			$nota = ($nota == 0)?"":$nota;
			$tipo = trim($row["tar_tipo"]);
			//--
			$fechor = trim($row["tar_fecha_entrega"]);
			//ponderacion
			$pondera = trim($row["tar_ponderacion"]);
			$tipocalifica = trim($row["tar_tipo_calificacion"]);
			switch($tipocalifica){
				case 'Z': $tipocal = " Actividades"; break;
				case 'E': $tipocal = " AL Evaluaciones"; break;
			}
		}
	}
	
	
	$result = $ClsTar->get_respuesta_directa_curso($tarea,$alumno);
	if(is_array($result)){
		foreach($result as $row){
			$texto = utf8_decode($row["reso_texto"]);
			$texto = nl2br($texto);
			$fecha_respuesta = cambia_fechaHora($row["reso_fecha_registro"]);
		}
		$resuelto = '<label class = "text-success"><i class = "fa fa-check"></i> Respuesta Entregada</label>';
	}else{
		$fec_limite = strtotime($fechor);
		$fec_hoy = strtotime(date("d-m-Y H:i:00",time()));
		if($fec_hoy > $fec_limite){
			if($tipo == "OL"){
				$resuelto = '<label class="text-danger"><i class = "fa fa-ban"></i> La fecha de entrega ha vencido!</label>';
			}else{
				$resuelto = '<label class = "text-info"><i class = "fa fa-folder-open"></i> No necesita respuesta en l&iacute;nea</label>';
			}
		}else{
			if($tipo == "OL"){
				$resuelto = '<label class = "text-info"><i class = "fa fa-clock-o"></i> Respuesta Pendiente</label>';
			}else{
				$resuelto = '<label class = "text-info"><i class = "fa fa-folder-open"></i> No necesita respuesta en l&iacute;nea</label>';
			}
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
		<i class="fa fa-check-square"></i> Resoluci&oacute;n del Alumno <?php echo $alu_nombre." ".$alu_apellido; ?>
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
				<span class="form-control"><?php echo $nombre; ?></span>
			</div>
			<div class="col-xs-5">
				<label>Nota: </label>
				<span class="form-control"><?php echo $nota; ?> Punto(s).</span>
				<input type = "hidden" name = "tarea" id = "tarea" value = "<?php echo $tarea; ?>" />
				<input type = "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Ponderaci&oacute;n: </label>
				<span class="form-control"><?php echo $pondera; ?> Punto(s).</span>
			</div>
			<div class="col-xs-5">
				<label>Tipo/Calificaci&oacute;n: </label>
				<span class="form-control"><?php echo $tipocal; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Descripci&oacute;n: </label> <br>
				<span class="text-primary"><?php echo $desc; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
				<label>Situaci&oacute;n:  </label>
				<span class="form-control"><?php echo $resuelto; ?></span>
			</div>
			<div class="col-xs-5">
				<label>Fecha de Respuesta: </label>
				<span class="form-control"><?php echo $fecha_respuesta; ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<label>Respuesta:</label> <br>
				<span class="text-primary"><?php echo $texto; ?></span>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<?php echo tabla_archivos_respuesta($tarea,$alumno); ?>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<button type="button" class="btn btn-success btn-block" id = "limp" onclick = "cerrarModal();"> <span class="fa fa-check"></span> Aceptar </button>
			</div>
		</div>
		<br>
	</div>
</div>
</body>
</html>
<?php

function tabla_archivos_respuesta($tarea,$alumno){
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_respuesta_tarea_curso_archivo('',$tarea,$alumno,'');
	
	if(is_array($result)){
		$Thoras = 0;
			$salida.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
			$salida.= '<thead>';
			$salida.= '<tr>';
			$salida.= '<th width = "10px" class = "text-center">No.</td>';
			$salida.= '<th width = "100px" class = "text-center">NOMBRE</td>';
			$salida.= '<th width = "250px" class = "text-center">DESCRIPCI&Oacute;N</td>';
			$salida.= '<th width = "30px" class = "text-center"><span class="fa fa-cogs"></span></td>';
			$salida.= '</tr>';
			$salida.= '</thead>';
		$i = 1;	
		foreach($result as $row){
			$salida.= '<tr>';
			//No.
			$salida.= '<td class = "text-center">'.$i.'. </td>';
			//nombre
			$nombre = utf8_decode($row["arch_nombre"]);
			$salida.= '<td class = "text-left">'.$nombre.'</td>';
			//descripcion
			$desc = utf8_decode($row["arch_descripcion"]);
			$salida.= '<td class = "text-justify">'.$desc.'</td>';
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
			$salida.= '<td class = "text-center">';
			$salida.= '<a class="btn btn-default" href="EXEdownload_archivo_tarea_curso_alumnos.php?archivo='.$archivo.'" title = "Descargar" >'.$icono.'</a>';
			$salida.= '</td>';
			//--
			$salida.= '</tr>';
			$i++;
		}
			$salida.= '</table>';
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-warning"></i> No se registran archivos adjuntos en esta tarea...';
		$salida.= '</h5>';
	}
	
	return $salida;
}


?>