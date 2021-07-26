<?php
	include_once('xajax_funct_examen.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	//$_POST
	$ClsExa = new ClsExamen();
	$hashkey = $_REQUEST["hashkey"];
	$examen = $ClsExa->decrypt($hashkey, $id);
	
	$result = $ClsExa->get_det_examen_curso($examen,$tipo_codigo);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["exa_codigo"];
			$titulo = utf8_decode($row["exa_titulo"]);
			$descripcion = utf8_decode($row["exa_descripcion"]);
			//--
			$fini = trim($row["exa_fecha_inicio"]);
			$fini = cambia_fechaHora($fini);
			$ffin = trim($row["exa_fecha_limite"]);
			$ffin = cambia_fechaHora($ffin);
			//--
			$feclimit = trim($row["exa_fecha_limite"]);
			//--
			$situacion = trim($row["dexa_situacion"]);
		}
		if($situacion == 1){
			$situacion_desc ='<small class = "text-muted"><i class="fa fa-clock-o"></i> Sin Resolver</small> &nbsp; ';
		}else if($situacion == 2){
			$situacion_desc ='<small class = "text-info"><i class="fa fa-check"></i> Resuelto</small> &nbsp; ';
		}else if($situacion == 3){
			$situacion_desc ='<small class = "text-success"><i class="fa fa-check-circle-o"></i> Calificado</small> &nbsp; ';
		}
	}else{
		
	}
	
	$flimit = strtotime($feclimit);
	$fecahora = strtotime(date("Y-m-d H:i:s",time()));
	if(($fecahora < $flimit)){
		$disabled = "";
		$title = '<h6 class = "alert alert-info text-center" ><i class = "fa fa-clock-o"></i> Exitos! el tiempo esta corriendo...</h6>';
	}else{
		$disabled = "disabled";
		$title = '<h6 class = "alert alert-danger text-center" ><i class = "fa fa-ban"></i> Ooops! el tiempo ha terminado...</h6>';
	}	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<?php
	   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
	   $xajax->printJavascript("..");
	?>	
	<!-- Bootstrap Core CSS -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
    <link href="../assets.3.5.20/css/util.css" rel="stylesheet">
    
    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../assets.3.5.20/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!--fontawesome-->
	<script src="https://kit.fontawesome.com/907a027ade.js" crossorigin="anonymous"></script>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="icon-spell-check"></i> Evaluaciones</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Page Content -->
    <div class="container">
		<br><br><br><br>
        <div class="row">

			<div class="col-md-3">
                <p class="lead"><i class="icon-spell-check"></i> Ex&aacute;menes o Evaluaciones</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/IFRMencuestas.php" class="list-group-item"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPTAREAS/FRMinicio.php" class="list-group-item"><i class="fa fa-paste"></i> Tareas</a>
                    <a href="../CPTEST/FRMinicio.php" class="list-group-item active"><i class="icon-spell-check"></i> Evaluaciones</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-xs-9">
                <div class="thumbnail">
                    <div class="caption-full">
						<div class="row">
							<div class="col-xs-12">
								<?php echo $title; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-3"><?php echo $situacion_desc; ?></div>
						</div>
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-10">
								<h4><a href="javascript:void(0);"><?php echo $titulo; ?></a></h4>
								<input type= "hidden" name = "examen" id = "examen" value = "<?php echo $examen; ?>" />
								<input type= "hidden" name = "alumno" id = "alumno" value = "<?php echo $tipo_codigo; ?>" />
								<input type= "hidden" name = "feclimit" id = "feclimit" value = "<?php echo $feclimit; ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-10">
								<p class="text-justify"><?php echo $descripcion; ?></p>
							</div>
						</div>
                        <hr>
					<?php
						$result = $ClsExa->get_pregunta_curso('',$examen);
						if(is_array($result)){
							$i = 1;	
							foreach ($result as $row){
								$codigo = $row["pre_codigo"];
								$pregunta = utf8_decode($row["pre_descripcion"]);
								$tipo = trim($row["pre_tipo"]);
								$puntos = trim($row["pre_puntos"]);
								$result_respuesta = $ClsExa->get_respuesta_directa_curso($examen,$codigo,$tipo_codigo);
								if(is_array($result_respuesta)){
									foreach ($result_respuesta as $row_respuesta){
										$ponderacion = trim($row_respuesta["resp_ponderacion"]);
										$respuesta = utf8_decode($row_respuesta["resp_respuesta"]);
									}	
								}else{
									$ponderacion = "";
									$respuesta = "";
								}
								$salida="";
								if($tipo == 1){
									switch($ponderacion){
										case 1: $elemento = 'A'; break;
										case 2: $elemento = 'B'; break;
										case 3: $elemento = 'C'; break;
										case 4: $elemento = 'D'; break;
										case 5: $elemento = 'E'; break;
										default: $elemento = ''; break;
									}
									$salida.='<div class="form-group">';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioA'.$i.'" value="1" onclick = "Responder(\''.$codigo.'\',1,this.value,\'\');" '.$disabled.' /> <label for="radioA'.$i.'" > 1</label>';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioB'.$i.'" value="2" onclick = "Responder(\''.$codigo.'\',1,this.value,\'\');" '.$disabled.' /> <label for="radioB'.$i.'" > 2</label>';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioC'.$i.'" value="3" onclick = "Responder(\''.$codigo.'\',1,this.value,\'\');" '.$disabled.' /> <label for="radioC'.$i.'" > 3</label>';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioD'.$i.'" value="4" onclick = "Responder(\''.$codigo.'\',1,this.value,\'\');" '.$disabled.' /> <label for="radioD'.$i.'" > 4</label>';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioE'.$i.'" value="5" onclick = "Responder(\''.$codigo.'\',1,this.value,\'\');" '.$disabled.' /> <label for="radioE'.$i.'" > 5</label>';
										$salida.='</label>';
									$salida.='</div>';
									$salida.='<script>';
									if($elemento != ''){
										$salida.='document.getElementById("radio'.$elemento.''.$i.'").checked = true;';
									}
									$salida.='</script>';
								}else if($tipo == 2){
									switch($ponderacion){
										case 5: $elemento = 'V'; break;
										case 1: $elemento = 'F'; break;
										default: $elemento = ''; break;
									}
									$salida.='<div class="form-group">';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioV'.$i.'" value="5" onclick = "Responder(\''.$codigo.'\',2,this.value,\'\');" '.$disabled.' />  <label for="radioV'.$i.'" > Verdadero</label>';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioF'.$i.'" value="1" onclick = "Responder(\''.$codigo.'\',2,this.value,\'\');" '.$disabled.' />  <label for="radioF'.$i.'" > Falso</label>';
										$salida.='</label>';
									$salida.='</div>';
									$salida.='<script>';
									if($elemento != ''){
										$salida.='document.getElementById("radio'.$elemento.''.$i.'").checked = true;';
									}
									$salida.='</script>';
								}else if($tipo == 3){
									$salida.='<div class="form-group">';
										$salida.='<textarea class = "form-control" name = "respuesta'.$i.'" id = "respuesta'.$i.'"  rows="5" onkeyup="textoLargo(this);" onblur = "Responder(\''.$codigo.'\',3,\'0\',this.value);" '.$disabled.' >'.$respuesta.'</textarea>';
									$salida.='</div>';
								}
								
					?>
						<div class="row">
							<div class="col-xs-1 text-right"><label><?php echo $i; ?>.</label></div>
							<div class="col-xs-10">
								<p class="text-justify"><?php echo $pregunta; ?> &nbsp; <label>(<?php echo $puntos; ?> Puntos)</label></p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-10"><?php echo $salida; ?></div>
						</div>
						<br>
					<?php
								$i++;
							}
						}else{
							
						}
					?>
						<div class="row">
							<div class="col-xs-12">
								
							</div>
						</div>
                    </div>
					<hr>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-paste"></i> Archivos de Resoluci&oacute;n del Ex&aacute;men</div>
								<div class="panel-body">
									<br>
									<div class="row">
										<div class="col-md-9">
											<label class="text-muted"><i class="fa fa-copy"></i> Documentos de Respuesta</label>
										</div>
										<div class="col-md-3">
											<button type="button" class="btn btn-primary btn-block" <?php echo $disabled; ?> onclick = "NewFile(<?php echo $codigo; ?>,<?php echo $tipo_codigo; ?>,1);" title="Cargar Archivos de Respuesta o Resoluci&oacute;n"><i class="fas fa-file-upload"></i> <i class="fas fa-file-image"></i> Cargar</button>
										</div>
										<!--div class="col-md-3">
											<a class="btn btn-default btn-block" href = "IFRMarchivos_tarea_cursos.php?tarea=<?php echo $codigo; ?>&alumno=<?php echo $tipo_codigo; ?>" target = "_blank" title="Ver Documentos Cargados" ><i class="fa fa-search"></i> <i class="fas fa-file-pdf"></i> Ver</a>
										</div-->
									</div>
									<br>
									<div class="row">
									<?php
										$result = $ClsExa->get_resolucion_examen_archivo_curso('',$codigo,$tipo_codigo,'');
										$cantidad = 0;
										$salida = "";
										if(is_array($result)){
											foreach($result as $row){
												$codigo = trim($row["arch_codigo"]);
												$examen = trim($row["arch_examen"]);
												$alumno = trim($row["arch_alumno"]);
												$extension = trim($row["arch_extencion"]);
												$archivo = trim($row["arch_codigo"])."_".trim($row["arch_examen"])."_".trim($row["arch_alumno"]).".".trim($row["arch_extencion"]);
												$archivo_nombre = utf8_decode($row["arch_nombre"]);
												$desc = utf8_decode($row["arch_descripcion"]);
												$cantidad++;
												
												$salida.='<small class="col-md-8">';
													$salida.=$cantidad.'. '.$archivo_nombre.' &nbsp; <span title = "'.$desc.'"><a href="javascript:void(0);"><i class="fa fa-search"></i> <i class="fa fa-comments"></i><a></span>';
												$salida.='</small>';
												$salida.='<small class="col-md-2">.'.$extension.'</small>';
												$salida.='<div class="col-md-1">';
													$salida.='<a href="EXEdownload_archivo_examen_curso.php?archivo='.$archivo.'" class="btn btn-default btn-xs" title = "Descargar Archivo"><i class="fas fa-file-download fa-2x"></i></a>';
												$salida.='</div>';
												$salida.='<div class="col-md-1">';
													$salida.='<button type = "button" onclick = "Eliminar_Archivo('.$codigo.','.$examen.',\''.$alumno.'\',\''.$archivo.'\');" '.$disabled.' class="btn btn-danger btn-xs" title = "Eliminar Archivo"><i class="fa fa-trash"></i></button>';
												$salida.='</div>';
											}
											echo $salida;
										}
									?>
									</div>
									<div class="row">
										<div class="col-md-11 text-right">
											<small class="text-muted text-rigth"><?php echo $cantidad; ?> Archivo(s).</small>
										</div>
									</div>
								</div>	
							</div>
						</div>
					</div>
					<hr>
                    <div class="ratings">
                        <p class="text-info"> Revise el contenido de la clave para evitar errores en la calificaci&oacute;n</p>
                        <p class="pull-right"> Visualizado el <?php echo date("d/m/Y"); ?> a las <?php echo date("H:i"); ?></p>
                        <p>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </p>
                    </div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-success" id = "btnfin" onclick="FinalizarExamen();" <?php echo $disabled; ?> ><i class="fa fa-check"></i> Listo !</button> &nbsp; 
							<?php echo $situacion_desc; ?>
						</div>
					</div>
					<br>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
    <div class="container">
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; ID 2017.</p>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.container -->
	
	<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="60px" /></h4>
			</div>
			<div class="modal-body text-center" id= "lblparrafo">
				<img src="../../CONFIG/images/img-loader.gif"/><br>
				<label align ="center">Transaccion en Proceso...</label>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
				</div>
			</div>
			<div class="modal-body" id= "Pcontainer">
				
			</div>
	    </div>
	  </div>
	</div>
    <!-- Modal -->

   <!-- scripts -->
    <script src="../js/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui-1.10.2.custom.min.js"></script>
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.5.20/js/modules/loading.js"></script>
	<script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
    <script type="text/javascript" src="../js/modules/lms/examencurso.js"></script>
	
</body>
</html>
