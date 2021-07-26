<?php
	include_once('html_fns_golpe.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
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
	
	//__
	$ClsPush = new ClsPushup();
	$sql = $ClsPush->update_push_status($tipo_codigo);
	$rs = $ClsPush->exec_sql($sql);
	//--	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAsi = new ClsAsignacion();
	
	$arr_cui = "";
	$info_pensum = "";
	$info_nivel = "";
	$info_grado = "";
	$info_seccion = "";
	//--
	$info_grupo = "";
	//--
	if($tipo_usuario == 3){ //// PADRE DE ALUMNO
		$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
		////////// CREA UN ARRAY CON TODOS LOS DATOS DE SUS HIJOS
		if (is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$arr_cui.= $row["alu_cui"].",";
			}
			$arr_cui = substr($arr_cui,0,-1);
			
		}
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$result = $ClsPen->get_grado($pensum,'','',1);
		if(is_array($result)){
			foreach($result as $row){
				$info_pensum.= $row["gra_pensum"].",";
				$info_nivel.= $row["gra_nivel"].",";
				$info_grado.= $row["gra_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
		}
	}else{
		$valida = "";
	}
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
    <link href="../assets.3.5.20/css/animate.css" rel="stylesheet">
    <link href="../assets.3.5.20/css/reports.css" rel="stylesheet">
	
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/index.css" type="text/css" media="screen" />
	
    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
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
			<li>
                <a href="../CPHIJOS/FRMhijos.php">
                    <i class="icon-users"></i>
                     <span>Hijos</span>
                </a>
            </li>
			<?php if($_SESSION["MOD_notas"] == 1){ ?>
			<li>
                <a href="../CPNOTAS/FRMhijos.php">
                    <i class="fa fa-paste"></i>
                    <span>Notas</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1){ ?>
			<li>
                <a href="../CPMATERIAS/FRMhijos.php">
                    <i class="fa fa-flask"></i>
                    <span>Materias</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_pagos"] == 1){ ?>
			<li>
                <a href="../CPPAGOS/FRMhijos.php">
                    <i class="fas fa-money-bill-alt"></i>
                    <span>Pagos</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_encuestas"] == 1){ ?> 
			<li class="active">
                <a href="../CPENCUESTAS/FRMencuestas.php">
					<i class="fas fa-clipboard-check"></i>
                    <span>Encuestas</span>
                </a>
            </li>
			<?php } ?>
			<li>
                <a href="../CPGRUPOS/FRMhijos.php">
                    <i class="fas fa-users"></i>
                    <span>Grupos</span>
                </a>
            </li>
			<br><br><br>
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
				<a href="../CPVIDEOCALL/FRMhijos.php">
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
				<a href="../CPTAREAS/FRMtareas.php">
					<div class="data">
						<span class="number"><i class="icon-paste"></i></span>
						Tareas
					</div>
				</a>
            </div>
			<?php } ?>
			<?php if($_SESSION["MOD_pinboard"] == 1){ ?>
                <div class="<?php echo $cols_divs; ?>">
					<a href="../CPPOSTIT/FRMpinboard.php">
						<div class="data">
							<span class="number"><i class="icon-pushpin"></i></span>
							Pinboard
						</div>
					</a>
                </div>
				<?php } ?>
				
        </div>
    </div>
        <!-- end upper main stats -->
			<div class="row">
				<div class="col-lg-10 col-md-offset-1">
					<br>
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<span class="fa fa-medkit" aria-hidden="true"></span>
							Tablero de Notificaciones (Reporte de Golpe)
						</div>
						<div class="panel-body">
						<?php
							if($pensum != ""){
								$ClsGol = new ClsGolpe();
								$result = $ClsGol->get_golpe('',$pensum,$info_nivel,$info_grado,$info_seccion,$arr_cui,'','');
								if(is_array($result)){
						?>
							<ul class="notes">
								<?php
									foreach($result as $row){
										$codigo = trim(utf8_decode($row["gol_codigo"]));
										//grado
										$grado = utf8_decode($row["gol_grado_desc"]);
										$seccion = utf8_decode($row["gol_seccion_desc"]);
										//target
										$alumno = utf8_decode($row["alu_nombre"])." ".utf8_decode($row["alu_apellido"]);
										//lugar
										$lugar = trim(utf8_decode($row["gol_lugar"]));
										//hora
										$hora = trim(utf8_decode($row["gol_hora"]));
										//Consistencia
										$desc = trim(utf8_decode($row["gol_descripcion"]));
										//desc
										$medida = trim(utf8_decode($row["gol_medida"]));
										//fecha
										$fecha = $row["gol_fecha_registro"];
										$fecha = cambia_fechaHora($fecha);
								?>
								<li>
									<div>
										<small><?php echo $fecha; ?></small>
										<h5 class="text-danger"><i class="fa fa-plus"></i> Reporte de Golpe</h5>
										<p>Estimados Se&ntilde;ores:<br>
											Nos dirigimos a ustedes para informarles con mucha pena que su hijo(a) <strong><?php echo $alumno; ?></strong> se lastim&oacute;,
											a continuaci&oacute;n los detalles:
										</p>
										<p>
											Lugar: <strong><?php echo $lugar; ?></strong>.<br>
											Hora: <strong><?php echo $hora; ?></strong>.<br>
											Parte del Cuerpo lastimada y Descripci&oacute;n del Golpe: <strong><?php echo $desc; ?></strong>.<br>
											Medida tomada de inmediato y medicamento autorizado: <strong><?php echo $medida; ?></strong>.<br>
											Dosis: <strong><?php echo $dosis; ?></strong>.
										</p>
										<label><?php echo "$grado $seccion"; ?></label>
										<!--a href="FRMdetalle.php?codigo=<?php //echo $codigo; ?>"><i class="fas fa-search-plus"></i></a-->
									</div>
								</li>
								<?php
									}
								?>
							</ul>
						<?php
								}
							}else{
								echo '<h5 class = "alert alert-info text-center"><i class = "fa fa-ban"> No hay notas por el momento...</i></h5>';
							}
						?>
						</div>
					</div>
					<!-- /.panel-default -->
				</div>
			</div>
    </div>


	<!-- scripts -->
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>
    <!-- knob -->
    <script src="../assets.3.5.20/js/jquery.knob.js"></script>
    <!-- flot charts -->
    <script src="../assets.3.5.20/js/jquery.flot.js"></script>
    <script src="../assets.3.5.20/js/jquery.flot.stack.js"></script>
    <script src="../assets.3.5.20/js/jquery.flot.resize.js"></script>
    <script src="../assets.3.5.20/js/theme.js"></script>
   
	
</body>
</html>