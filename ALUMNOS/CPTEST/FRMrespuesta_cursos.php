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
	}else{
		
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

    <!-- Sweet Alert -->
	<script src="../js/plugins/sweetalert/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/plugins/sweetalert/sweetalert.css">

    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

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
						<a href="javascript:void(0);" onclick = "window.close();"><i class="fa fa-times"></i> Cerrar</a>
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
						<br>
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
								if($tipo == 1){ /// ponderacion de 1-5
									$salida.='<div class="form-group">';
									for($x = 1; $x <= 5; $x++){ 
										$salida.='<label class="radio-inline">';
											if($x == $ponderacion){ // recorre las 5 posiciones validando cual es la ponderada almacenada, asi pinta el icono
												$salida.='<i class = "fa fa-circle fa-2x text-info"></i> <label>'.$x.'</label>';
											}else{
												$salida.='<i class = "fa fa-circle-o fa-2x text-info"></i> <label>'.$x.'</label>';
											}
										$salida.='</label>';
									}	
									$salida.='</div>';
								}else if($tipo == 2){
									$salida.='<div class="form-group">';
										if($ponderacion == 5){ // recorre las 5 posiciones validando cual es la ponderada almacenada, asi pinta el icono
											$salida.='<label class="radio-inline">';
												$salida.='<i class = "fa fa-circle fa-2x text-info"></i> <label>Verdadero</label>';
											$salida.='</label>';
											$salida.='<label class="radio-inline">';
												$salida.='<i class = "fa fa-circle-o fa-2x text-info"></i> <label>Falso</label>';
											$salida.='</label>';
										}else if($ponderacion == 1){ 
											$salida.='<label class="radio-inline">';
												$salida.='<i class = "fa fa-circle-o fa-2x text-info"></i> <label>Verdadero</label>';
											$salida.='</label>';
											$salida.='<label class="radio-inline">';
												$salida.='<i class = "fa fa-circle fa-2x text-info"></i> <label>Falso</label>';
											$salida.='</label>';
										}else{
											$salida.='<label class="radio-inline">';
												$salida.='<i class = "fa fa-circle-o fa-2x text-info"></i> <label>Verdadero</label>';
											$salida.='</label>';
											$salida.='<label class="radio-inline">';
												$salida.='<i class = "fa fa-circle-o fa-2x text-info"></i> <label>Falso</label>';
											$salida.='</label>';
										}
										
									$salida.='</div>';
								}else if($tipo == 3){
									$salida.='<div class="form-group">';
										$salida.='<label class = "form-control">'.$respuesta.'</label>';
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
							<h3><?php echo $situacion_desc; ?></h3>
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
    <script type="text/javascript" src="../js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../js/modules/lms/examencurso.js"></script>
    <script type="text/javascript" src="../js/modules/util.js"></script>
	
</body>
</html>
