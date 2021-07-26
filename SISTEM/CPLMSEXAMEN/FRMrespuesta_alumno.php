<?php
	include_once('xajax_funct_examen.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$ClsExa = new ClsExamen();
	$hashkey1 = $_REQUEST["hashkey1"];
	$examen = $ClsExa->decrypt($hashkey1, $id);
	$hashkey2 = $_REQUEST["hashkey2"];
	$alumno = $ClsExa->decrypt($hashkey2, $id);
	
	$result = $ClsExa->get_det_examen_curso($examen,$alumno);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["exa_codigo"];
			$titulo = utf8_decode($row["exa_titulo"]);
			$descripcion = utf8_decode($row["exa_descripcion"]);
			$descripcion = nl2br($descripcion);
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
			$situacion_desc ='<label class = "text-muted"><i class="fa fa-clock-o"></i> Sin Resolver</label> &nbsp; ';
		}else if($situacion == 2){
			$situacion_desc ='<label class = "text-info"><i class="fa fa-check"></i> Resuelto</label> &nbsp; ';
		}else if($situacion == 3){
			$situacion_desc ='<label class = "text-success"><i class="fa fa-check-circle-o"></i> Calificado</label> &nbsp; ';
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
	<link rel="shortcut icon" href="../img/icono.ico">
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		 ?>	
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/shop-item.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo $_SESSION["rotulos_colegio"]; ?>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-paste"></i> Evaluaciones</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

			<div class="col-xs-3">
                <p class="lead text-success"><i class="fa fa-paste"></i> Evaluaciones Resuelto</p>
                <div class="list-group">
					<a href="FRMcursoexamen.php?acc=gestor" class="list-group-item"><i class="fa fa-pencil"></i> Crear Evaluacion</a>
                    <a href="FRMcursoexamen.php?acc=calificar" class="list-group-item"><i class="fa fa-key"></i> Resolver (Clave)</a>
				    <a href="javascript:void(0);" class="list-group-item active"><i class="fa fa-paste"></i> Calificar Evaluacion</a>
                    <a href="FRMcursoexamen.php?acc=ver" class="list-group-item"><i class="fa fa-search"></i> Visualizar Evaluacion</a>
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
								<input type= "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
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
								$pregunta = nl2br($pregunta);
								$tipo = trim($row["pre_tipo"]);
								$puntos = trim($row["pre_puntos"]);
								$result_respuesta = $ClsExa->get_respuesta_directa_curso($examen,$codigo,$alumno);
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
										$salida.='<label class = "form-parrafo">'.$respuesta.'</label>';
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
						<div class="col-xs-10 col-xs-offset-1">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-paste"></i> Archivos de Resoluci&oacute;n del Evaluaciones</div>
								<div class="panel-body">
									<br>
									<div class="row">
										<div class="col-xs-9">
											<label class="text-muted"><i class="fa fa-copy"></i> Documentos de Respuesta</label>
										</div>
									</div>
									<br>
									<div class="row">
									<?php
										$result = $ClsExa->get_resolucion_examen_archivo_curso('',$codigo,$alumno,'');
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
												
												$salida.='<small class="col-xs-8">';
													$salida.=$cantidad.'. '.$archivo_nombre.' &nbsp; <span title = "'.$desc.'"><a href="javascript:void(0);"><i class="fa fa-search"></i> <i class="fa fa-comments"></i><a></span>';
												$salida.='</small>';
												$salida.='<small class="col-xs-2">.'.$extension.'</small>';
												$salida.='<div class="col-xs-1">';
													$salida.='<a href="EXEdownload_archivo_examen_curso.php?archivo='.$archivo.'" class="btn btn-default btn-xs" title = "Descargar Archivo"><i class="fa fa-download"></i></a>';
												$salida.='</div>';
											}
											echo $salida;
										}
									?>
									</div>
									<div class="row">
										<div class="col-xs-11 text-right">
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
	
	<!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/lms/examen.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
</body>
</html>
