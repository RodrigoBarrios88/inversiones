<?php
	include_once('xajax_funct_videoclase.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//////////////////////////- MODULOS HABILITADOS
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_modulos();
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["mod_codigo"];
			$nombre = $row["mod_nombre"];
			$modclave = $row["mod_clave"];
			$situacion = $row["mod_situacion"];
			if($situacion == 1){
				$_SESSION["MOD_$modclave"] = 1;
			}else{
				$_SESSION["MOD_$modclave"] = "";
			}
		}
	}
	//////////////////////////- MODULOS HABILITADOS


	//$_POST
	$cui = $tipo_codigo;
	$ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$nombres = ucwords(strtolower($nom." ".$ape));
			$tipo_codigo = trim($row["alu_cui"]);
			//
			$foto = trim($row["alu_foto"]);
        }
	}

	if(file_exists ('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
		$foto = 'ALUMNOS/'.$foto.'.jpg';
	}else{
		$foto = 'nofoto.png';
	}

	$ClsPen = new ClsPensum();
	$ClsAcadem = new ClsAcademico();
	$ClsVid = new ClsVideoclase();
	$codigosVideo = '';
	$alumno = $tipo_codigo;
	$codigo = $ClsVid->get_codigos_videoclase_todos();
    $codigo.= $ClsVid->get_codigos_videoclase_secciones($pensum,$alumno);
	$codigosVideo.= ($codigo != "")?$codigo.',':'';
	$pensum = $ClsPen->get_pensum_activo();

	$result_secciones = $ClsAcadem->get_seccion_alumno($pensum,'','','',$alumno,'','',1);
	if(is_array($result_secciones)){
		foreach($result_secciones as $row){
			$nivel = $row["sec_nivel"];
			$grado = $row["sec_grado"];
			$seccion = $row["sec_codigo"];
			$codigo = $ClsVid->get_codigos_secciones($pensum,$nivel,$grado,$seccion);
			$codigosVideo.= ($codigo != "")?$codigo.',':'';
		}
	}
	$codigosVideo = substr($codigosVideo, 0, -1);
	///////////////////////////// MODULOS //////////////////////////////
	$modulos = 0;
	if($_SESSION["MOD_videocall"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_videos"] == 1 || $_SESSION["MOD_photos"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_tareas"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_pinboard"] == 1){
		$modulos++;
	}
	switch($modulos){
		case 1: $cols_divs = "col-md-12 col-sm-12 stat"; break;
		case 2: $cols_divs = "col-md-6 col-sm-12 stat"; break;
		case 3: $cols_divs = "col-md-4 col-sm-12 stat"; break;
		case 4: $cols_divs = "col-md-3 col-sm-12 stat"; break;
	}

if($id != "" && $nombre != ""){
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    <link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- bootstrap -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../assets.3.5.20/css/util.css" rel="stylesheet">
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="../assets.3.5.20/css/lib/jquery.dataTables.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />

	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />

	<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"-->

    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/index.css" type="text/css" media="screen" />

	<!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <!-- Custom Fonts -->
	<link href="../assets.3.5.20/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    	<style>
		.blink {
			animation: blink-animation 0.8s steps(5, start) infinite;
			-webkit-animation: blink-animation 0.8s steps(5, start) infinite;
			color: #2dcc42;
		}
		@keyframes blink-animation {
			to {
				visibility: hidden;
			}
		}
		@-webkit-keyframes blink-animation {
			to {
				visibility: hidden;
			}
		}
	</style>

</head>
<body>
     <!-- navbar -->
    <header class="navbar navbar-inverse" role="banner">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" id="menu-toggler">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
        	<a class="navbar-brand2" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
			<button type="button"  class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>
        <ul class="nav navbar-nav pull-right collapse" id="second-menu" >
			<ul class="nav navbar-nav" style="font-size: 14px;">						
				<li><a href="../CPSOLICITUD_MINEDUC/FRMmineduc.php"> <span class="fa fa-book"></span> Educaci&oacute;n Virtual a Distancia</a></li>
			</ul>
			<?php if($_SESSION["MOD_panial"] == 1 || $_SESSION["MOD_golpe"] == 1 || $_SESSION["MOD_enfermedad"] == 1 || $_SESSION["MOD_conducta"] == 1){ // permisos del colegio ?>
			<li class="notification-dropdown hidden-phone">
                <a href="#" class="trigger">
                    <i class="fa fa-bell"></i>
					<?php
					if($pendientes > 0){
						echo '<span class="count" style="background: #FF8000;">'.$pendientes.'</span>';	
					}
					?>
                </a>
                <div class="pop-dialog">
                    <div class="body">
                        <a href="#" class="close-icon"><i class="fa fa-times"></i></a>
                        <div class="notifications">
                            <h3><i class="fa fa-paste"></i> Notificaciones Especiales </h3>
							<?php if($_SESSION["MOD_pinboard"] == 1){ // permisos del colegio ?>
                            <a href="../CPPOSTIT/FRMpinboard.php" class="item">
								<i class="fas fa-thumbtack"></i>
                                <strong>*. </strong> 
								<small>Pinboard</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_panial"] == 1){ // permisos del colegio ?>
                            <a href="../CPPANIAL/FRMreportes.php" class="item">
								<i class="fas fa-layer-group"></i>
                                <strong>*. </strong> 
								<small>Reporte de Pa&ntilde;al</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_golpe"] == 1){ // permisos del colegio ?>
                            <a href="../CPGOLPE/FRMreportes.php" class="item">
								<i class="fa fa-medkit"></i></span> 
                                <strong>*. </strong> 
								<small>Reporte de Golpe</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_enfermedad"] == 1){ // permisos del colegio ?>
                            <a href="../CPENFERMEDAD/FRMreportes.php" class="item">
								<i class="fa fa-stethoscope"></i></span> 
                                <strong>*. </strong> 
								<small>Reporte de Enfermedad</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_conducta"] == 1){ // permisos del colegio ?>
                            <a href="../CPCONDUCTA/FRMreportes.php" class="item">
								<i class="fas fa-smile"></i>
                                <strong>*. </strong> 
								<small>Reporte de Conducta (Diario)</small>
                            </a>
							<?php } ?>
							<div class="footer">
                                <a href="javascript:void(0);" class="logout"><i class="fa fa-check-square-o"></i> Marcar como le&iacute;das</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
			<?php } ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Perfil
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="../CPPERFIL/FRMperfil.php"> <i class="icon-user"></i> Informaci&oacute;n Personal</a></li>
                	<li><a href="../CPPERFIL/FRMfamilia.php"> <i class="fas fa-users"></i> Ver Familia</a></li>
                	<li><a href="../CPPERFIL/FRMseguridad.php"> <i class="fas fa-shield-alt"></i> Seguridad y Bloqueo de Dispositivos</a></li>
                </ul>
            </li>
             <li class="settings">
                <a href="../CPPERFIL/FRMperfil.php" role="button">
                    <i class="icon-cog"></i>
                </a>
            </li>
            <li class="settings">
                <a href="../logout.php" role="button">
                    <i class="icon-exit"></i>
                </a>
            </li>
        </ul>
    </header>
    <!-- end navbar -->

    <!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <li>
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
				<a href="../menu.php">
                    <i class="icon-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
			<?php if($_SESSION["MOD_calendario"] == 1){ // permisos del colegio ?>
			<li>
                <a href="../CPCALENDARIO/FRMcalendario.php">
                    <i class="fas fa-calendar"></i>
                    <span>Calendario</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_asistencia"] == 1){ // permisos del colegio ?>
			<li>
                <a href="../CPASISTENCIA/FRMinicio.php">
                    <i class="fas fa-check-square"></i>
                    <span>Asistencia</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_notas"] == 1){ ?>
			<li>
                <a href="../CPNOTAS/FRMinicio.php">
                    <i class="fa fa-paste"></i>
                    <span>Notas</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1 || $_SESSION["MOD_academico3"] == 1){ ?>
			<li>
                <a href="../CPMATERIAS/FRMmaterias.php">
                    <i class="fa fa-flask"></i>
                    <span>Materias</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1 || $_SESSION["MOD_academico3"] == 1){ ?>
			<li>
                <a href="../CPCURSOS/FRMcursos.php">
                    <i class="fa fa-book"></i>
                    <span>Cursos Libres</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_encuestas"] == 1){ ?> 
			<li>
                <a href="../CPENCUESTAS/FRMencuestas.php">
					<i class="fas fa-clipboard-check"></i>
                    <span>Encuestas</span>
                </a>
            </li>
			<?php } ?>
			<li>
                <a href="../CPGRUPOS/FRMgrupos.php">
                    <i class="fas fa-users"></i>
                    <span>Grupos</span>
                </a>
            </li>
			<br><br>
			<li>
                <a href="../logout.php">
                    <i class="icon-exit"></i>
                     <span>Salir</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- end sidebar -->

	<!-- main container -->
    <div class="content">

        <!-- upper main stats -->
        <div id="main-stats">
			<div class="row stats-row">
				<?php if($_SESSION["MOD_videocall"] == 1){ ?>
				<div class="<?php echo $cols_divs; ?> ">
					<a href="../CPVIDEOCALL/FRMvideoclases.php">
						<div class="data">
							<span class="number"><i class="fa fa-video"></i></span>
							VideoClases
						</div>
					</a>
				</div>
				<?php } ?>
				<?php if($_SESSION["MOD_videos"] == 1 || $_SESSION["MOD_photos"] == 1){ ?>
				<div class="<?php echo $cols_divs; ?>">
					<a href="../CPMULTIMEDIA/FRMvisualizar.php">
						<div class="data">
							<span class="number"><i class="fas fa-photo-video"></i></span>
							Multimedia
						</div>
					</a>
				</div>
				<?php } ?>
				<?php if($_SESSION["MOD_tareas"] == 1){ ?>
				<div class="<?php echo $cols_divs; ?>">
					<a href="../CPTAREAS/FRMinicio.php">
						<div class="data">
							<span class="number"><i class="icon-paste"></i></span>
							Tareas
						</div>
					</a>
				</div>
				<?php } ?>
    			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1 || $_SESSION["MOD_academico3"] == 1){ ?>
                <div class="<?php echo $cols_divs; ?>">
    				<a href="../CPTEST/FRMinicio.php">
    					<div class="data">
    						<span class="number"><i class="icon-spell-check"></i></span>
    						Evaluaciones
    					</div>
    				</a>
                </div>
    			<?php } ?>

			</div>
		</div>
        <!-- end upper main stats -->
		<div class="panel" style ="margin: 5px">
			<div class="panel panel-default">
				<div class="panel-heading"> 
					<h5><i class="fas fa-video"></i> VideoClases de <?php echo $nombres; ?></label></h5>
				</div>
				<div class="panel-body">
					<div class = "row">
						<div class="col-md-4 col-md-offset-4 text-center">
							<a href="javascript:void(0);" class="thumbnail">
								<img src="../../CONFIG/Fotos/<?php echo $foto; ?>" alt="foto" width="150px" />
							</a>
						</div>
					</div>
					<br>
					<div class = "row">
						
					<?php
						$fechaRepetida = '';
						$result = $ClsVid->get_videoclase($codigosVideo,$target,$tipo,$plataforma,$fecha);
						if(is_array($result)){
							foreach($result as $row){
							////////////////// AGRUPA OBJETO POR FECHAS ///////////////////////
							$codigo = trim($row["vid_codigo"]);
							$nombre = trim(utf8_decode($row["vid_nombre"]));
							$descripcion = trim(utf8_decode($row["vid_descripcion"]));
							$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
							//fecha inicia
							$fini = trim($row["vid_fecha_inicio"]);
							$fecha_1 = strtotime($fini);
							$fini = cambia_fechaHora($fini);
							//fecha finaliza
							$ffin = trim($row["vid_fecha_fin"]);
							$fecha_2 = strtotime($ffin);
							$ffin = cambia_fechaHora($ffin);
							////--------------
							if(($fecha_actual > $fecha_1) && ($fecha_actual < $fecha_2)){
								$clase_panel = 'primary';
								$bilnk = '<strong>En Curso</strong>';
							}else{
								$clase_panel = 'mutted';
								$bilnk = '';
							}
							////--------------
							$plataforma = trim($row["vid_plataforma"]);
							$link = trim($row["vid_link"]);
							if($plataforma == "ASMS Videoclass"){
								$enlace = "FRMviewer.php?hashkey=$hashkey&codigo=$codigo";
							}else{
								$enlace = $link;
							}	
							$target = $row["vid_target"];
							$tipo_target = $row["vid_tipo_target"];
							if($target == "SELECT"){
								if($tipo_target == 1){
									$para = "Grados y secciones";
								}else if($tipo_target == 2){
									$para = "Grupos Extracurriculares";
								}
							}else{
								$para = "Todos";
							}
						?>
						<?php if(($fecha_actual >= $fecha_1) && ($fecha_actual < $fecha_2)){ ?>
							<div class="col-lg-4 col-xs-12">
								<a href="<?php echo $enlace ?>" target="_blank">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-video-camera fa-5x blink"></i>
												</div>
												<div class="col-xs-9 text-right">
													<h6><?php echo $nombre ?></h6>
													<span>Plataforma: <?php echo $plataforma ?></span><br>
													<small>Participan: <?php echo $para ?></small>
												</div>
											</div>
										</div>
										<a href="<?php echo $enlace ?>" target="_blank" >
											<div class="panel-footer">
												<span class="pull-left text-info"><?php echo $fini ?></span>
												<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
								</a>
							</div>
						<?php }else if($fecha_actual < $fecha_1){ ?>
							<div class="col-lg-4 col-xs-12">
								<span title = "No tiene acceso a&uacute;n">
									<div class="panel panel-default">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-video-camera fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<h6><?php echo $nombre ?></h6>
													<span>Plataforma: <?php echo $plataforma ?></span><br>
													<small>Participan: <?php echo $para ?></small>
												</div>
											</div>
										</div>
										<span>
											<div class="panel-footer">
												<span class="pull-left text-muted"><?php echo $fini ?></span>
												<span class="pull-right"><i class="fa fa-arrow-circle-right text-muted"></i></span>
												<div class="clearfix"></div>
											</div>
										</span>
									</div>
								</span>
							</div>
						<?php
								} 
							}
						}
						?>
					</div>
				</div>
			</div>
			<!-- /.panel-default -->
		</div>
    </div>

	<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="28px" /> &nbsp;  <?php echo $_SESSION["nombre_colegio"]; ?></h4>
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
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>
    <!-- knob -->
    <script src="../assets.3.5.20/js/jquery.knob.js"></script>
    <script src="../assets.3.5.20/js/theme.js"></script>
	<script src="../assets.3.5.20/js/jquery.dataTables.js"></script>

	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/notas/notas.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>

	<script>
		$('#myTabs a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		  });
	</script>
	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
