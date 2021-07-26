<?php
	include_once('xajax_funct_examen.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$ClsExa = new ClsExamen();
	$hashkey = $_REQUEST["hashkey"];
	$codigo = $ClsExa->decrypt($hashkey, $id);
	
	$result = $ClsExa->get_examen_curso($codigo);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$cod = $row["exa_codigo"];
			$curso_nombre = utf8_decode($row["cur_nombre"]);
			$tema_nombre = utf8_decode($row["exa_tema_nombre"]);
			$titulo = utf8_decode($row["exa_titulo"]);
			$tipo_respuesta = trim($row["exa_codigo"]);
			$tipo_respuesta = ($tipo_respuesta == "OL")?"RESPUESTA EN L&Iacute;NEA" : "POR OTROS MEDIOS";
			$descripcion = utf8_decode($row["exa_descripcion"]);
			$fini = trim($row["exa_fecha_inicio"]);
			$fini = cambia_fechaHora($fini);
			$ffin = trim($row["exa_fecha_limite"]);
			$ffin = cambia_fechaHora($ffin);
			//-
			$tipo = trim($row["exa_tipo"]);
			$tipocalifica = trim($row["exa_tipo_calificacion"]);
			switch($tipocalifica){
				case 'Z': $tipocal = "ZONA"; break;
				case 'E': $tipocal = "AL EX&Aacute;MEN"; break;
			}
		}
		$result = $ClsExa->get_det_examen_curso($codigo,$tipo_codigo);
		if(is_array($result)){
			foreach($result as $row){
				$nota = $row["dexa_nota"];
				$obs = utf8_decode($row["dexa_observaciones"]);
				$nota = ($nota == 0)?"":$nota;
				//--
				$sit = trim($row["dexa_situacion"]);
			}
			if($sit == 1){
				$sit_examen = '<h4 class = "text-muted"><i class="fa fa-clock-o"></i> Sin Resolver</h4> &nbsp; ';
			}else if($sit == 2){
				$sit_examen = '<h4 class = "text-info"><i class="fa fa-check"></i> Resuelto</h4> &nbsp; ';
			}else if($sit == 3){
				$sit_examen = '<h4 class = "text-success"><i class="fa fa-check-circle-o"></i> Calificado</h4> &nbsp; ';
			}
		}else{
			$sit_examen = '<h4 class = "text-muted"><i class="fa fa-clock-o"></i> Sin Resolver</h4> &nbsp; ';
		}
		
		$result = $ClsExa->get_pregunta_curso('',$codigo);
		$puntos = 0;
		if(is_array($result)){
			foreach($result as $row){
				$puntos+= trim($row["pre_puntos"]);
			}
		}
	}else{
		$puntos = 0;
		$nota = "<small>Pendiente</small>";
	}
	
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
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

            <div class="col-md-9">
				<div>
                    <img class="img-responsive" src="../images/logo_largo.png" alt="">
                    <div class="caption-full">
                        <h4><a href="javascript:void(0);"><?php echo $titulo; ?></a></h4>
						<label class="text-muted"><?php echo $curso_nombre.' - '.$tema_nombre; ?></label>
                        <div class="text-justify"><?php echo $descripcion; ?></div>
						<br>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<label class="text-muted"><i class="fa fa-copy"></i> Archivos Auxiliares o Gu&iacute;as</label>
							</div>
						</div>
						<br>
						<div class="row">
						<?php
							$result = $ClsExa->get_examen_archivo_curso('',$codigo,'');
							$cantidad = 0;
							$salida = "";
							if(is_array($result)){
								foreach($result as $row){
									$archcod = trim($row["arch_codigo"]);
									$examen = trim($row["arch_examen"]);
									$extension = trim($row["arch_extencion"]);
									$archivo = trim($row["arch_codigo"])."_".trim($row["arch_examen"]).".".trim($row["arch_extencion"]);
									$archivo_nombre = utf8_decode($row["arch_nombre"]);
									$desc = utf8_decode($row["arch_descripcion"]);
									$cantidad++;
									
									$salida.='<small class="col-md-8">';
										$salida.=$cantidad.'. '.$archivo_nombre.' &nbsp; <a href="javascript:void(0);" title = "'.$desc.'"><i class="fa fa-search"></i> <i class="fa fa-comments"></i><a>';
									$salida.='</small>';
									$salida.='<small class="col-md-2">.'.$extension.'</small>';
									$salida.='<small class="col-md-2">';
										$salida.='<a href="EXEdownload_archivo_examen_curso_maestro.php?archivo='.$archivo.'" class="btn btn-default btn-xs" title = "Descargar Archivo" ><i class="fas fa-file-download fa-2x"></i></a>';
									$salida.='</small>';
								}
								echo $salida;
							}
						?>
						</div>
						<div class="row">
							<div class="col-md-12 text-right">
								<small class="text-muted text-rigth"><?php echo $cantidad; ?> Archivo(s).</small>
							</div>
						</div>
						<br>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading"><i class="icon-info"></i> Informaci&oacute;n</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-xs-12">
												<h5>Fecha y Hora de Inicio: <label class = "text-info"><?php echo $fini; ?></label></h5>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12">
												<h5>Fecha y Hora L&iacute;mite (Finalizaci&oacute;n): <label class = "text-info"><?php echo $ffin; ?></label></h5>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-xs-9">
												<?php echo $sit_examen; ?>
											</div>
											<div class="col-xs-3 text-right">
												<a class="btn btn-default" href="FRMrespuesta_cursos.php?hashkey=<?php echo $hashkey; ?>" target="_blank" title = "Ver Respuesta"><i class="fa fa-eye"></i> ver respuesta</a>
											</div>	
										</div>
										<div class="row">
											<div class="col-xs-3">
												<label>Tipo de Respuesta: </label><br>
											</div>
											<div class="col-xs-9">
												<label class="text-info"><?php echo $tipo_respuesta ?></label>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-xs-3">
												<label>Valor del Ex&aacute;men: </label><br>
											</div>
											<div class="col-xs-9">
												<label class="text-info"><?php echo $puntos ?> Punto(s).</label>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-xs-3">
												<label>Tipo de Calificaci&oacute;n:</label><br>
											</div>
											<div class="col-xs-9">
												<label class="text-info"><?php echo $tipocal ?></label>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-xs-3">
												<label>Nota: </label><br>
											</div>
											<div class="col-xs-9">
												<label class="text-info"><?php echo $nota ?> Punto(s).</label>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-xs-3">
												<label>Observaciones: </label><br>
											</div>
											<div class="col-xs-9">
												<label class="text-justify text-info"><?php echo $obs ?></label>
											</div>
										</div>
										<br>
									</div>	
								</div>
							</div>
						</div>
						<hr>
					</div>
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
