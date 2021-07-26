<?php
include_once('html_fns_solicitud_mineduc.php');
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
if (is_array($result)) {
	foreach ($result as $row) {
		$codigo = $row["mod_codigo"];
		$nombre = $row["mod_nombre"];
		$modclave = $row["mod_clave"];
		$situacion = $row["mod_situacion"];
		if ($situacion == 1) {
			$_SESSION["MOD_$modclave"] = 1;
		} else {
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

///////////////////////////// MODULOS //////////////////////////////
$modulos = 0;
if ($_SESSION["MOD_videocall"] == 1) {
	$modulos++;
}
if ($_SESSION["MOD_videos"] == 1 || $_SESSION["MOD_photos"] == 1) {
	$modulos++;
}
if ($_SESSION["MOD_tareas"] == 1) {
	$modulos++;
}
if ($_SESSION["MOD_pinboard"] == 1) {
	$modulos++;
}
switch ($modulos) {
	case 1:
		$cols_divs = "col-md-12 col-sm-12 stat";
		break;
	case 2:
		$cols_divs = "col-md-6 col-sm-12 stat";
		break;
	case 3:
		$cols_divs = "col-md-4 col-sm-12 stat";
		break;
	case 4:
		$cols_divs = "col-md-3 col-sm-12 stat";
		break;
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
			<button type="button" class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>
		<ul class="nav navbar-nav pull-right collapse" id="second-menu">
			<?php if ($_SESSION["MOD_panial"] == 1 || $_SESSION["MOD_golpe"] == 1 || $_SESSION["MOD_enfermedad"] == 1 || $_SESSION["MOD_conducta"] == 1) { // permisos del colegio 
			?>
				<li class="notification-dropdown hidden-phone">
					<a href="#" class="trigger">
						<i class="fa fa-bell"></i>
						<?php
						if ($pendientes > 0) {
							echo '<span class="count" style="background: #FF8000;">' . $pendientes . '</span>';
						}
						?>
					</a>
					<div class="pop-dialog">
						<div class="body">
							<a href="#" class="close-icon"><i class="fa fa-times"></i></a>
							<div class="notifications">
								<h3><i class="fa fa-paste"></i> Notificaciones Especiales </h3>
								<?php if ($_SESSION["MOD_panial"] == 1) { // permisos del colegio 
								?>
									<a href="../CPPANIAL/FRMreportes.php" class="item">
										<i class="fas fa-layer-group"></i>
										<strong>*. </strong>
										<small>Reporte de Pa&ntilde;al</small>
									</a>
								<?php } ?>
								<?php if ($_SESSION["MOD_golpe"] == 1) { // permisos del colegio 
								?>
									<a href="../CPGOLPE/FRMreportes.php" class="item">
										<i class="fa fa-medkit"></i></span>
										<strong>*. </strong>
										<small>Reporte de Golpe</small>
									</a>
								<?php } ?>
								<?php if ($_SESSION["MOD_enfermedad"] == 1) { // permisos del colegio 
								?>
									<a href="../CPENFERMEDAD/FRMreportes.php" class="item">
										<i class="fa fa-stethoscope"></i></span>
										<strong>*. </strong>
										<small>Reporte de Enfermedad</small>
									</a>
								<?php } ?>
								<?php if ($_SESSION["MOD_conducta"] == 1) { // permisos del colegio 
								?>
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
			<?php if ($_SESSION["MOD_calendario"] == 1) { // permisos del colegio 
			?>
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
			<?php if ($_SESSION["MOD_notas"] == 1) { ?>
				<li>
					<a href="../CPNOTAS/FRMhijos.php">
						<i class="fa fa-paste"></i>
						<span>Notas</span>
					</a>
				</li>
			<?php } ?>
			<?php if ($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1) { ?>
				<li>
					<a href="../CPMATERIAS/FRMhijos.php">
						<i class="fa fa-flask"></i>
						<span>Materias</span>
					</a>
				</li>
			<?php } ?>
			<?php if ($_SESSION["MOD_pagos"] == 1) { ?>
				<li>
					<a href="../CPPAGOS/FRMhijos.php">
						<i class="fas fa-money-bill-alt"></i>
						<span>Pagos</span>
					</a>
				</li>
			<?php } ?>
			<?php if ($_SESSION["MOD_encuestas"] == 1) { ?>
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
				<?php if ($_SESSION["MOD_videocall"] == 1) { ?>
					<div class="<?php echo $cols_divs; ?> ">
						<a href="../CPVIDEOCALL/FRMhijos.php">
							<div class="data">
								<span class="number"><i class="fa fa-video"></i></span>
								VideoClases
							</div>
						</a>
					</div>
				<?php } ?>
				<?php if ($_SESSION["MOD_videos"] == 1 || $_SESSION["MOD_photos"] == 1) { ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="../CPMULTIMEDIA/FRMvisualizar.php">
							<div class="data">
								<span class="number"><i class="fas fa-photo-video"></i></span>
								Multimedia
							</div>
						</a>
					</div>
				<?php } ?>
				<?php if ($_SESSION["MOD_tareas"] == 1) { ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="../CPTAREAS/FRMtareas.php">
							<div class="data">
								<span class="number"><i class="icon-paste"></i></span>
								Tareas
							</div>
						</a>
					</div>
				<?php } ?>
				<?php if ($_SESSION["MOD_pinboard"] == 1) { ?>
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
		<div class="col-lg-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="fa fa-square-o" aria-hidden="true"></span>
					Educaci&oacute;n Virtual a Distancia
				</div>
				<div class="container">
					<?php
					$resultado = $ClsAsi->get_alumno_padre($tipo_codigo, "");
					////////// CREA UN ARRAY CON TODOS LOS DATOS DE SUS HIJOS
					$i = 1;
							$result = $ClsAcad->get_grado_alumno($pensum, '', '', $tipo_codigo, '', 1);
							if (is_array($result)) {
								foreach ($result as $row_grado) {
									$info_nivel = $row_grado["gra_nivel"];
									$info_grado = $row_grado["gra_codigo"];
									?>
									<div class="col-xs-12 ">
										<div class="row">
											<ul class="nav nav-list">
												<?php if ($info_nivel == 1) { ?>
													<li><i class="fa fas fa-folder text-primary"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close  text-primary"> PRE-PRIMARIA <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>
														<ul class="nav nav-list tree" style="display: none;" style="display: none;">
															<div class="col-xs-12 ">
																<?php if ($info_grado == 2) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header "> KINDER</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> DESTREZAS DE APRENDIZAJE</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Z_dDH6RPXv7lNwR1LHv9D8nxcRI8nCv3?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header  "><a href="https://drive.google.com/drive/folders/1ByyBbZesRzFALGxb1ZhkkChx3gMyVV1f?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header  "><a href="https://drive.google.com/drive/folders/1Sb-XmoRZ_qZ6w6JcVOynpZIQ2wz94GMe?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header  "><a href="https://drive.google.com/drive/folders/1g5K5zdBww9_ux0g00-PyI_tdl8ymLUB0?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header  "><a href="https://drive.google.com/drive/folders/1d9j4ATiuEaAb9Wq6U-P-ykIvKUnWi8P9?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header  "><a href="https://drive.google.com/drive/folders/1_7sY-2RFHgRRDZxJ1ohs-S3NBYY_useh?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header  "><a href="https://drive.google.com/drive/folders/1WX0hK6rqazQZPjFVU4s-SQ5gmA3_1hLw?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header  "><a href="https://drive.google.com/drive/folders/1ntaJNRipJXTuD5vEwgeq2vfKVtAeFE4x?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header  "><a href="https://drive.google.com/drive/folders/1tTN8npYWmkBL3xTrz_OnS_2Hi3WwGRZK?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1kDGfEqsBh9Cy7eAI-TBVWGlR36UwuAIw?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MEDIO SOCIAL Y NATURAL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18p2yld9GYWyRYZGb4nN28QPH9gr-lHqf?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18960qYPlIOAsPPSueltx2WP2VYFdLrx7?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1TAV8-iqnR87f7xcF5p8MVMdXxZxw3hma?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1e4jMTzAUup03xJ3zwJduXW89IdgnaK-i?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jxUNvKbDdF9asEyKyBYeSz7i8Cok1J7g?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1iJtl2s2mBEvKtbA2X28XeNbR6lK9pBfc?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1vxxwOP8WYWITTvd_fm4fHSMgXLLBbDcM?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CW10kq3yZFgCG506uwFoWddDRC1Ij8Yg?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1iJtl2s2mBEvKtbA2X28XeNbR6lK9pBfc?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wGFxGzeh8VwcsvhCY5N87Xw5hKYfxN98?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZnRsQ_FarF3DSZEW2FsZr3IAQdCxEZ56?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1lHj9GlWmRiJRt4fC2qIFjZjC4hpSXyIA?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1LeCJiAJeFau8wvcE2OSSCSkqUhy0jlMi?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1uogb5PjF-QMGrK7zeBX7T70ZtldwmG_S?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16uN48nAJ6HXGUcMQeBoZSlzr-esrLBFB?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/105fitCt-IxGEHOqPtpkt_fCpPNxa-z2H?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1lAqiWdSf7U2i6agPvHkjHEZqgj2I7QXp?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GGAwseCEVmfSK_-XUNPRe3-K4hzSaBk5?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1dvDzyje2Gtbe2DcaHy5Pe7Oa-C5TpUQA?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1dJGw0CgV0isrunVH0QeWUazJ8xvv7Iuw?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_grado == 3) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> PREPARATORIA</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> DESTREZAS DE APRENDIZAJE</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ncSTrrCna_yVulCLFQiuFbwNl0lmFVer?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13kpobtfn9_ihlOYQuw06FjqO_OuLI9UE?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1p8WZ59PIDhQgmFRccTl2NEs_F01Qmnc_?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1HfhRu2q4f-moCAsCdbf2JYABOEJPXBj-?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1T5xcwMqZTGvhhM66C3zbGo-CfGDyE0Tx?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VyHxiEtTed55eJF2YohpWM0-EvHZtFAT?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1eRzE0RD8mt9JO_TC2lPbU_H2auT1dSxB?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jMvhB885rLuUdS0DdHCnqL7XSLLlgqkh?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fTw6riO2BBfUy1FHsYvX1D4HeaHB1pTI?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1_MVDEd1OfDPhG_8AdbxHbIrxzPE09shn?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MEDIO SOCIAL Y NATURAL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1nj-_jlk8JayIFDDivkwP-pxV1v-O8BhZ?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jiDl5q-_9Ve5uqqqw68UUQ_xISaGxpDH?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZYGJFXSJHmQ9NdVWBA5xBEZ0JWoH0g_E?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1p15WJBOb68wTt8lnkh5PMG8OCpFDOzoX?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1mRXF834eu_7ULR6Z4YzHcYtdU095DGkx?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1H6gq8tpsf3_7IsayjTIeQGBplTCiCTIg?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1OIj7voIXkD-K8hg1wPGFguU5B2XEMJ_w?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13hZCFMvqfxAgrGQNsWsIYivAjk_234ys?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/14cUTsDHSjTgZJIEHRpoDgIYKQ5NJk0sU?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Yxn5vNIi0pzBrTQdjHRLFuMvt6nTElvc?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1w-W7BTGmZVO34XxRyNy9l7Rf3kmEHo1W?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1X5JwUolQsD9EO9pInEzwzP1V521vlez-?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YEgr4o5k9KqYdYvpcGUcoxVYBo_5SK78?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1tloi2N8HgQ8aQCPu54qDWsIf3kxLs-nj?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1oo0y6NC6K0H6XfgW1H5p0R3j4XWM0qtI?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOGIA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1D3xTyIjn1noY5OKhMExjAyndY7MB_EmR?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1bJh8uTm7CHW-ak_cq4g3dZzc79n7c7aV?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1HfECQOGMLwCzTuMIJ9KvzdAfS7nz03TT?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CVBocDVipOW7E_RRQRK0L4Ub_kIlNC9N?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11IAnU84vCSl1BqxicTCPh9iQenX4ZJHp?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BOCUaFlFXtwmn12QBw8IjwbOa3zrGnJN?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1PBk3gFJDtNmKKtFKzl5o3qlcTDVFDqDR?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wIwZMm817VfSSpscAWmb2Bg4IhGPfQCJ?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pyJ1SFLkoraHhI8H3LMvkXSnfi3fKpZx?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1q5WZbaaJa_esHm29qPc9zA94flNcHMDM?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
															</div>
														</ul>
													</li>
												<?php } ?>
												<?php if ($info_nivel == 2 || $info_nivel == 3 && $info_grado == 1) { ?>
													<li><i class="fa fas fa-folder text-primary"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close text-primary"> PRIMARIA <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>
														<ul class="nav nav-list tree" style="display: none;">
															<div class="col-xs-12 ">
																<?php if ($info_nivel == 2 && $info_grado == 1) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> PRIMERO PRIMARIA</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1o1OloLyGya7COby-sPHaG1J5nsUtWkW4?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cV3wX37ZJFxwbG7OiBwAyMJ_Uz_iO8uA?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jMNWcapx1YMNlo-aAZ-WJUDWgEy3txy1?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1HQdpOcMc6WxRxiHcSO6s5h7p0rYiVN43?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cs49T1hxWqDPJTov6mI3_XlvLET-cSJV?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1mCSEPTJLMzLeEIVFttks5AMOxPlhHICl?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1tUeiAVl88Pv7xOCVSbCtwTm3KAbOe494?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1hKfR_xM6B2dr7uPFZCGuhKRegp9SLA1H?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VLgZLijkrtfHi0IiPcuc7D7eslJpoJ8j?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Oxq5bkVvjPI269bhJzM8C5wcqNM1TB-O?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MEDIO SOCIAL Y NATURAL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZL1r926DIVLv9RnLkVKlmn_ZlYPsEnyR?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VKxS2ZtDt5IJLsfZLaKu1SjbMaigLQZq?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11z_HjJaCvu1pRoK5KUvy6iBecbkLwCc0?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BD0pHupyXNShus6hOx-WkWyfeqxcXjUz?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1tlXv5TKywGmzfeHuiR_3KUqUVrHZLbUY?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1-HGxHAPGOiC1XGWbLno1HnGhXwZPtpAc?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1zeq9QeqkK3JwWSfvX7fA95fquvwZb1Ri?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1HYuAxZHmO452OCEf9vAENrL95yMvGXnw?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ViE5zyGhgi3GPqYb3Wa8IzFnWIl5G0er?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1T1_IJJ1t_mReOnQLnNJ5R_2vOsC27mI3?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1emGdxIjkycIPvkP4UN3pABOltMb3LkuG?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1UC43a0c59JRw6A_1uxx9wPSMOHVv-xGX?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VO0rMaBXsrh0lz4Bnu1dvi9Bs1aG_7WX?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jGU9ovxL_As9Hh6ZCX9qZbrks3zvgb4F?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1MEws1GP2Eqmjm71IYrh_vjFhXtp0bmcD?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> FORMACI&Oacute;N CIUDADANA </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Vf6gOyLGCxFknlSIDnDKZjBKLnuc9ugW?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1xDs5xc_VgC2uds6VTtsoxAXdRh1ZUnD0?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1m6WQg7tk4CbdhepiUjmWkiIH8tXmiXPy?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1KKsJU0LKgfZvH6uJHOxE4Tho7MeMj8In?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BY6pkT9HL79Myw8gAlOiMMPGcQuBezXQ?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOG&Iacute;A</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1amBIobxeT4uUInvUYaW0bPZQRhN9f1HN?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fJRGsS9W2lrGhpRjJpe7PG965Lh3f0ir?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wAcRbF2wot1zoU7H6HFz0ZZ3tmfHjmBa?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sEdR2csn9C0d4GIdJSQbzfURk6m2KZAY?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1SmPUzb4uQyiN47_un9KzYs_jU0mQNZZd?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1DvyKsEz8nzqHPXt1T1sUxGAHBkSTmfv3?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1NzyKygjnkByabNmYrfT3uXc1aeGpu8y6?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1izG0SZ7LSGK0kGcuG-wJit4hcEUw_lzv?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Z_C0TXBUy47UZ3gzmVkKt3SXTyrZ3-E0?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wIv2zbRHnpgo3GR0dD4igC0K5L6leJkA?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VC-sod0Q07T12KJizhHE8At3zdxWCwNb?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13qXgK2hkxKCasBf8T01GT4NXuJUOLIMS?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1dRgjv0bjGByHiDMi8OzzF5nJRjO-4mzB?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11FSNj4KLhwa-WbRTqj5uaPCiK7XpBymW?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1U5RmsgeDGQOJuC4eOYwytcETC82dV50O?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_grado == 2) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> SEGUNDO PRIMARIA</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1y-7PWvLwCTl_8Go0kPIT8ZXpMqzq3zRj?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1srlC0swmTdV5ODW61Ldz4XFSDKKIriS1?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jk9UyijhlW4fbH71wkeos7NppGO9q7FG?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1kNHQbejA8z9O9oQSzoXRGPXgYdbPiGBA?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1-qrGfji49J-qaQzxjGNT-6jMS8W1W-dX?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZtAqdG3nmX6ml6aFClTt2N2JTV4oIW-9?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1-UppkaxbMfFhlV82I0_QlUzDhoYLhJZT?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GLcUWUpeBhAGj9scfSBC_dhp5FsQAJk4?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RMH1DQQddMB75B4OEI6N9YRJi8UWbRP4?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1DvVC770xeSSah76tYY3pRCZ5jVtTxOfX?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MEDIO SOCIAL Y NATURAL</label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1d_xcT6dKOtLedO-Wo5TfA45kyZ1rw0rx?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1JU5FvEMxw7CRJhTOuHtM1dfiBOQGzT2E?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1d8VP8Ed7nHfLjb_eTkNaFgDb7ukNMlCT?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Qh1BMnMC7lK5xZidIW5pUEFstL_HhX9O?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Vx8MZohQvEves48H63L4XVtuiMo0EOre?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YwNEq82T_LFH6FRavlIu_26EtSjT1qMp?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1S_giL6SKUh0buF1XsgkBYHUzEaPHJPX9?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1UfQpxBtc7f-6Gge-rywQQaW0f2StB8-m?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Kub6IYlEM6mxW9BQHwhyGXGTdrg4a_JD?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1OZWb9Rjbs0w5NyNwNWc1kGGK6CCKFTOA?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1DLNy72uCBFHh0EwGIU8Ejwx2HRq-qd-n?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pwOIX3P2VQNaSrzyzG5Z6d7mGFADXJp5?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1e0hl4GYF1BxqT7E4ttFWm3SCY0ocF9Qf?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BcLy2u0AHYxQMxLVVUpRbGjFjVwe4UQl?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1m4nzib6OiujGxxXJfdmMAj67KUFHNYRn?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> FORMACI&Oacute;N CIUDADANA </label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16xAurVNKDTwl-2_nJLV1ix0ZPLkrsg6I?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1uY4hoqIGJNQkgAw1PPktHetjwX9dRDMh?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13OjqImmAYXN-F0BEzdW0CnzCFWjYkU1l?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1zzX5tV6TaihNlCZvWtblc15y1YNwcuHo?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/17J98bXCwA4f7ZqnLMQFPDA5pDE0vAeTT?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOG&Iacute;A</label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/14qM52tDxqLmWPRwJ_e4FhGGvijAHx1U3?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1W4Y-eIYAoYqEN4jV-jRy7B7tUPsjFKBc?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1tCDWR7hBIkxPKngiRSnPrKQFbYX066KG?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Gd-ChyknU7uwlVzlWme9NtJ2W6BT8yCa?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1mGqWAIer-iLYWn5V6tJ4wZUvNYERK_aL?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1KdY2ag0ABXPgtol3UtzVWpupNvice62g?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VGA7ol4SS-CT80VI7vLclF8o4GANb5c1?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1An58N2e7XUW177NYaVREbBXaLwfKtzXA?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1empD_prw9Wg77TLZWAwApGw9YjYKV8F4?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1PrvhR4_8FHvGqYZMDsLwj4aW1mu7UNuT?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																			<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL</label>
																				<ul class="nav nav-list tree" style="display: none;">
																					<div class="col-xs-12 ">
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ssKlkq7C3SO7wQ0fuaDdbPQA9vxnTLOp?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1bvcEJRNb4_z0i6k-_oSJpAy9lVU0QBBF?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1XloOuImotWqevbRL93sraerkIePLdNMj?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1MeIS_BVhLxFicxg9cw7S-pQ2FbB8vNTU?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																						</li>
																						<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1P_WeY2aNS4epdaki5XIPxCAgYdaTtRz9?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																						</li>
																					</div>
																				</ul>
																			</li>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_grado == 3) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close "> TERCERO PRIMARIA</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/17itp_29doFCW9aQ03OtP-Oc_IxQSujlt?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18ubOh2woivrfZCV7PFOrbdCL8ZSpXpDr?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/15D36Ata_lRU-KzWVDTGSjikrpn-v86wZ?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YL3-dFg9dZsLHY6hf5fVwuK234-T_XcW?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18WbqDnjLmZ3049maxNFbJUfv9QK6aMpT?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1i-oLRqf-M4Ultg4exrNHiwNewltytXWJ?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cx7HwLNmTZz6zMiL689ZSX2P3K5tSiuN?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GichO41e6GanUtvqVx8IvGh6k2WlG6AT?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1H4eu3gUkiw5A-snUiCScYgfNeVx6qa4J?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1aSB36JMeLbMfgscPfG0QfK62cl3l1zvt?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MEDIO SOCIAL Y NATURAL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1vUEVVwPt--k9QnNj35cNxG63b90sCH30?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fBo1bYNU_rAYO8w-9tBE_o8A3FsNTHjt?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1HGx7o9cIumtdMub9yKUyNj-GxGjcowPa?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1iywc6Nj7Lmso5CbWKO5ZsceBGRQ6y7BO?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RmKiM-MQxZGy1L-1HPFFqDyrqMkgNUHG?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fHBFqCdAnq0i7CIOedjgQ7eeaCUUhXR2?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/17m7JCwABehUDRAcbud7CFtfBYFTsQs71?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1gD2fUomvtMNs7oz8UWREPlj9S-5P8hse?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1h2UTWmmFNiqlPvonn0ESvd5RB7kfkDER?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CVRXsj-uxJ9vl385Pq54r9bcqOX3_6a7?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/139Qmcwq7MA5HXzQqhFf1yc9vVKJ--7fJ?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CuWYnY0ftk6G_R2VvaEfTrgZiROTK-iv?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pX4IRnda_gTBJYSbMZ_MYTGZeh6BrwwL?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pgYTwK37gsovGOLiUNi3VIW7xTIQaEWC?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fXfVe_K_QxGma6cj6Z5fuE5_VABjMUJM?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> FORMACI&Oacute;N CIUDADANA </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1c10Q5EmfFKz4g1YM-Z82O8yREZl5o8sJ?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1w0DTJycm6_5rNwyiQxGJtC-ITapVxwNU?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ckhy1qdwA6oAjB1SZLDX7dCi7ONm2HrS?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1N6O7nlL2ghl59gkvxM-_WLzQVh4qwcoC?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1EzbwM57gbofGPR3ZuZxAArWhawaRxIEN?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOG&Iacute;A</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ypHALWNWUJ2GxcM_9KU4WtwZUUwzoS-J?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GIYNTeybGqbWSANBMEky6HWATUlTyEK6?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1gtAI39uKNQs8a_TpYASu_4BntToFFj1I?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Bx3ILgOswx7JKSbJHzVR6sSXX7RfoSpF?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Bv4VnUN2Gbvjmmd3nV70-AynKKFFSwdq?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1PPuKDgubn-lJyMM1LSMDKy4sV_8WwLwh?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cXrgiAAuRJUHW-mU0-613uyV_B6JVEny?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1dE2Bddg8iFufbIGOLmZbPHk1S9VuzVcK?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wkK9Iry4kSIHwNcAe6fmRVDutkTLkm6S?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pKwVxNjRRT8G3SxmZJcT7RgJyvfw5qJp?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11jgH5qG3ztkATzkkPIccWnMXjEUsZHuM?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1s7--o-sY9-R-Yt_VqBn6sLLswbboN6wU?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1q1wVzuChQucV3OuIlSrldGAL19Gkf_6T?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1QbSbTvq7esqqhkFJ597vkNyEdmVZN5Nw?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wgPTcr8zk1s-FuiB62qk3jVjZFojNS3V?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_grado == 4) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> CUARTO PRIMARIA</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cBvZCAkYXBY2zVwWLhaYoiqduW2jG71d?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sjtAaNBmAC_Hy6KK8ZnXXszdE93KWQOf?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11iMiZa5kyYQwfcAHSeW3C2dw_i2adWvA?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1qlPkEmAOAHxUTkeQgrT7aeCT2A6aZOnP?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1lfjhG73JS5DQpJzLR4MAfD8OeBFSrd95?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1v1qP2ItaF1ugOx7o_gP9Oq7ff8Fn7v3A?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1MszTBWwdvoude7JLetod49Er_vCQHrFt?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1DyeerrCZ77DA_9Fwlb3g6iOwwOfXO-zY?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/15IMAqykWy6COMIbIkXL4-c2Y_DGUvKzG?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16ZKwFaizva9yX9xwiG6Q-_CDWEgEvRfv?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS SOCIALES</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/17Zxr76Ivzq0G452qQegAMdoLtY3Gxu8C?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1rv16S34Zp1fVp8EeE6-u4K65uf75Tudc?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RCdYbk620DvQGY5wjY8Cz6ZIqR5_Aen5?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Ar0x7gYNkcTLUdfAB5Q_AmfRfige3kxE?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1H_5jFMEkxO-Igjfd0ytq5w8v2tTYF4Ww?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES Y TECNOLOG&Iacute;A</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RKexggksvnBwbwGbzUG-kppJpg4ZfcoA?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1REl_0ipmtL6OJ1OZJfN9haXhq_ZTmS9J?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wawWvvPqQNzxo6iKzxNyg_lDJ-QuwXcG?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12dJ-A3et1d_Nwj4n9s3Pq4waXLbqVmB-?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11L9rGTGEJCPr_dacnAfRbVhpPme5AZ0w?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1PcJdkMXaueN3meAOKuy05i1P-aSBMOQr?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1IKqLsOrXknXUZOJzlmQro0f_YytAOhT3?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1rePWa-N3obzcJdquVzGl3bdX64pXA9Ww?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1QWVNFgB0XgHjJbHi06VEbTnecr53YHpK?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1c8_6vMJme8r-IUPc7Y4TAvg9cXToUDWP?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12fUVVjT9CpKzzXCODOGXJSOvMbiDqRMK?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1SdTvHDZxKH6u8VkV1RPmNdR2Kit44tSv?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1IikhhRiTMRq0VQenFER_tKsvgXQ-qDKA?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1k12Hj2FTe3j9aulX5AWhZikZaL4BTyZg?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1xvjxpRZQ62L2ziZUn9kYWV4MU_BDRBJv?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> FORMACI&Oacute;N CIUDADANA </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1zab5upmiA9-FPZGZGGkDC911znBRyhsE?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1k_5b4VBj23IixtxN0wLfvr0luJVdk-Ie?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RCIQUhJugL0wxw8cqnnPR9UKw0whiWC-?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1frRZc34rBSgspc3i3jTHTumeYUn4N3FN?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1NPGcnkEemXH3J9pUXXi4Av8rQl4Wyx13?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PRODUCTIVIDAD Y DESARROLLO</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1i8U0XSPpyDpXs844eVT1nQvDyXuZYDku?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jJkNAZp0ctrNYk18uLI_8k5noBed0mys?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1WLEtsc_hS8EPNsH99rOiqFc-njsUgCfh?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16IDSSEyrcepDpuP0t1O3945KTyWwO-Bp?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/128zcYQjZFS_60N1Gkki446k-CmqbxoIm?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1xf5h3IeNHInzObdDFcqa0z-aj4GrWO6d?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1qlDIinRaoEyb2jf7CI4lrp-AwpkGmc_a?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16U6lECGMsX7P7LawS-NnKoSBfC-s-xSz?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZhhhZFrZzmZyGJoc5DKHhV5triSr5O7k?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1hVjafe2yA9NN1-wAqTMgKDWSNCgqQEGJ?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12COA7tRc1_0z61mUwLXRehsVFkXXir-k?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sm8y0TA4xtGAbmzr6iMgE6bSk2PV8hH9?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Hl_bYAWLwOOIxa6XpvXozKpkfZLXrCk8?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1JgQlrAotTmN97WcnJxikhBjKVn2cEZBq?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wYDDKLumvOGtv8v-BFLYrKbm-tfNn7c3?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_grado == 5) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> QUINTO PRIMARIA</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1FExJxjfIj63kDBjiIzAjVKk_L89bqwmH?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cBPpP8J_2Udu629KMdmYS3JsNLmccr5X?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13bDRRHRurj6vmtyr95knnSqdc7nEXuVQ?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1flFNYZh3ZTOSByeJI1xGIkU2HuhMfGsg?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1TrsXhpn2day3vRvJ9thQC6hUehehbmaW?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16yiBG08f4kBsAcfUJbJPigxLt57lO5x9?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ltRbyNUbGJk_GgS_pxMzLDqolZdWeCm-?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Q4eCehYM_a34o6O61czroZno2VWaT3q0?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1KYh9Zn3K5iF5iWOcTFkFLv9qaQgtuHT5?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fe87errSCWGq0TAHzhwh9Pq4sN4CfG5I?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS SOCIALES</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1uC-YClfZklrAwL0CZqcRg63lpSoX_AMw?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VBrwOCWmGj6w18E6GN5hP1D4MmXCm1_O?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VS7JXW33aKzpgDhF98u8_bTBtyj8rIf4?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/10XPEQx5XEJ-QJjvpa1HLTP5yCd9EEZ--?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1066-fke-VQGuNso-kMKQr-9vXeYiad_E?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES Y TECNOLOG&Iacute;A</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1mF-HPk1kZMFOwkv8K9hO0hJqIadYQeAq?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1q9fOwZy1BCh8qE0MV1faA7OuX1pOrHrC?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sCld7tvZiuDCmGP6XkNCx5Px8gtnJJNV?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13b1XnOlddHAMWFjjYOhmrFQBMyWOWW0r?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1UngS1-MKVPSK8X1vHXWzYKo20flN2wnW?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sUAgdhU0tEr0qzPJ4Yl7LBh3v13MYwZ4?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1UDkiVcZNDfEL2IDQMln1MvhnAi1tG7oL?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1S9KusH3LxxPnamFIopkPS5gVwXA9xL6E?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1lNRsYNjfHjrQ4OYYTWqxKIUOPrwfXjbV?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wvDOdwNwFAiK3XDiyuikRXUfr5cXcWWD?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11ijn3Jkusd9Tl4p18XzlpkhrnSXOuoAx?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1G4FlXPlhO1uV3Fefip4zussu34zEYibX?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12ocH7I26lO3iR-BDhzTQZjfe8rw7D-9W?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1uzZqHQCunBUxsxgLblf4pe_eh8t34u-n?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fW-qbRMLocS3G4YeDajUGHz3rDBRK77r?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> FORMACI&Oacute;N CIUDADANA </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1-Fog0fE9dWSJMWDSO2z_9rRox0HMDrMT?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1b7xuLY3tyBQgqUXtUkcbC9bVz5NlWJ_w?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1MlKa_lONYl_VvJKzKwM2YzuEXJqM86-u?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19YMRiBEaie5iiUNzooA8SrIQ55HDMa3h?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1rwFCiKuaB0wShC2eJoX1AKJtYtYmzEOf?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PRODUCTIVIDAD Y DESARROLLO</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1LaC-pHwmv-jWigjX1ar8S_tpirJ7AI15?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1nce9oZBo1Pm4pyDzTfaHJML8dfi3AATg?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1As6TXg-RjoXYjzajll7X1ZeOTbRLqjQm?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1q_GBfpD1g482UtGHZ49V81rrd0bOuHLp?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Jwv3urYT8O6QxlD5mtCpWxyqF4BLi5Vu?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1loXFECfMPRay1tDkMgSjSTCXdLzhZoT4?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1w9Bn6-CxGHZUWHS0KbSsIDneizchF_AL?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1M0ai2TYftOIovZA_XSaGCPr9fIaX_Wgy?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1QThq8jaMB2TJsmM9Mw4EbSLWEO8QscVc?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1c6LpQLg3ZWBaQo2jD4GRQTi1_K7t9BJ1?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12L1NtZM4rEd8YtVpUU-k58VhbrjVrorF?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1oteRwen_9x8OtwiBLDtPgbKj4eXcgwoF?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1C1ejGN4RwQ6fyrF1Wwnl4kxMNG2ezavU?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1QJqeXkPp6q6HwbhnhiBt9Z0eaiu_lcnB?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ryVCjmR2xhaPOngAlh9MAwfMjwRJ8eRI?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_nivel== 3 && $info_grado== 1) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> SEXTO PRIMARIA</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1TYhBfBQ6rcYWO23DpkEMildToL1x_ZVJ?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19n2O_9-a_KNHydGsPAt6kWi5jPj7C-qA?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1DTLacjnD7Bgbi5WucIMi_3ReRSJ7AfoX?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1kYAHJu2hLsK5ygVqouys9bEXkVhRCmB-?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Y3H-lREhyhLAPwCuVaIU6X7188c0oi-D?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1dlZORqvc3pOL-QUxwOeMI5X62l7aHoWB?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19PremJvtIMRh6FbQiwR8BJ5elWgtheBn?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ct4t6Xh6_UbbRcFV3NhX3QVQ6oa7fGwN?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/17N99PFAz9nfgzG67v85ZrnsRvhRlqwM7?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Dmq7STvj2jJYkx8OqidoU7K0uMFkKwsa?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS SOCIALES</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1hHnZMKi1LIN3e2Qhxo_U0AjHJ819yXwj?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/188_W9klJ-8ZRUmBEI-YPpxQ54rUgauo4?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1FdWfkqdKW6OZcEPeEZrsqcVqmFty0XRs?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1xiSd1jO9AS7yTebpf317ynlJ8uGDDkSh?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1WEgwMocWDIPfSwwkj1EX5u1cZit75ypr?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES Y TECNOLOG&Iacute;A</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/10Cl0neE9hpk1iIM86HomkqyOUZuCRu3Q?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RFbYJKuSG4zfARe0O-ccvxtNCJee1c20?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1X3xXO3GXLPFWYOOeAkZPMSsH6OuSARlO?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1D8jtj02o-BSlJSA0ZTzAfndRARKP_v13?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GY6Tl0UWq4DA98bBwXZXSTVwD--2vKnD?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jB7Jn5ZNypAsJ4gcPRI27AR9yG2nOCm1?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1z3e-coaVmfVwsryvfnJTEz3Xkw3LfMQR?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/14dx79A6UnC9Xhtcju-leiq0fRIvJhjEt?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YSDhXm6IT_kf6Pi4gjkwmEah3IjG1uUq?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13NGgihlWir1puMxvQZVxR1f09kc_LdG-?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Q-YCI-aYABHNuCwlyx-9dPOP9tn9VtpG?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/10ZAQivqnxvMSkBMVXCU3I6AYbXcwacKa?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11rgh-xxH22tTcO6E3QMH3wEZCh462xFG?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YdLgkRAbgB8afHNcor82ElMdUM-vSiRC?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1OVtdUMWDqcxmQaFvCySooz4UPDpNhl2d?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> FORMACI&Oacute;N CIUDADANA </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1H1FZ-Sb8oj-wYzbqjUFLE0OoumPPi5I1?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BkkUGlYOyr3H5FmAhtVku5DmG1P2VjaI?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1kbjLdbwXsgwzETAphwp_-zcc4-YgOoqq?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/17tSuigtEiIDqC6Fk4A39KUnvxMFqBLjg?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1_MpFesKXaMHirH_jya_GoQb86mW2Sthq?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PRODUCTIVIDAD Y DESARROLLO</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/15WPwu15aqwvGziu_vLxTNYuce5rzhCD3?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Wom_cDq--o63updfY4rOzB-MVSUOKRaY?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1r2ruCcerUslQhrSpYgVIsqmP0u9ujObV?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1y2kAgdUkL_u5bR2fd6w_2rDwVuIxydCH?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sC_IeiwdCMIdQ7XuTPdtgEyK1CxaA3te?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1qq8dVPVx8XIJCZrP75H5DyaVlJCuO5cE?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1dBBPzPLpnXningbaJKkt5wKTZ_NatXYn?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1NbZK2NFCAfZz1MJGYaIqJ2fKnBym0Z1o?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1_TdMZ2cejjemGwswvpDgTe0-ozYz467i?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZVKoo_aFwAM5-qKv4xvW0K-NTLA89UXf?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1UuIqguwPGb5v_KaHs_QYP8lGUuU9yy2z?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1z06jSfZrgRr9Qm8dlp5BP4sH821bdetp?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1R6KJ66NGHd37wP_YI3KwDgDv1fWzgQeD?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1lQ6FTbPr4Xlry9f-bH4h8GYjNSixL1Jp?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1iaphuW-iRPvy_xh2D-P_mloSPwj10Za2?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
															</div>
														</ul>
													</li>
												<?php } ?>
												<?php if ($info_nivel == 3 && $info_grado != 1 || $info_nivel == 4 && $info_grado == 1) { ?>
													<li><i class="fa fas fa-folder text-primary"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close  text-primary"> B&Aacute;SICOS <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>
														<ul class="nav nav-list tree" style="display: none;">
															<div class="col-xs-12 ">
																<?php if ($info_grado == 2) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> PRIMERO B&Aacute;SICO </label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1oHCvWYHFHob0jtCp8SLhD-m8utcQ1ie7?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cLUk1CGqjCRn8biDD237QjV6oeQGgSKS?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1tkqixUPCHdbOkmvVojF0us8oqFp8Tcpa?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1xpYzCQHPFLo-KPf5V2RD1qmTCiHkp0_c?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18YEX0nOjoDil_T4YEoyxD3akYza6mlu1?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sls9IQzGR7oigjO-zKDHntbqJiHLtxra?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1iI-Xkw9QRB9-rr06iBUsX5o_l32o8klj?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/14f_StIIhakp8wKLxmXp1eYJCtrXJMQop?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1eunv_PyWLLFNNr7WBEhG6I66vcBMDnAr?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1e-CMPM6VahPD0vSt2EfFYDvZppscjRqM?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1gw-NKc7uL7eQVHy3sCPb8WQJWAmWHR_o?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1tIENllMGirQQLgtIZdZqv8BorPCU8SVP?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1s6dh38RrtkeRGC1zeX1qgK4u2xhEWcHB?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19euMKyoER3LDMmVzBa9z3A-v7cL1S7B0?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1vBR6DjPO9Usqv1Q9d5Jyg0Hs8emyG-d_?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RSCdyovJDGEu5Ixx_wBsZ7fbggk6RR92?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1NJPnIKBHEa4w96qWPX98WSnmBFd3UHEj?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VePQK7DxgG6PFqngHv9zQi2QkBM1wKRv?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ey57LGaw5KXmjPvkxmtl7IUuE0_Q5pRf?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/17LiGDgOPMsmmXb61XzIDOm6thOP5W8Xp?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS SOCIALES, FORMACI&Oacute;N CIUDADANA E INTERCULTURALIDAD</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1O12s-GiD3WFiV4uPnQji0Mc0iME_Prxp?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Fy48V3NUzJr0cbC26dyc_EI6BInTChuq?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1OzsrBZgZMeuxAZVrYoGjpkAlJ119w0AF?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BOoy_ONEQ8ueQRguaS7VDdvrMiM2bGy8?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cfWh2YG4zCSzwse20GUR-UH5GlKsHy9X?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CwnCZRWFEPecrS7C8hzvMjsxvOi0lD7e?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1mCuQYZIjlAeV32d9EVV7SK2EFDANQUAg?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ahUJGPhxiWIYphgoqyM7GO5g2UfaIE1A?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1nObp5Zy3ZSgJjLmn08jV5I_6Q9mah9j3?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1LRguHV0LkUsxL4hk47ym-6Cwisg6x1bT?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1tW6Sfph1xL62KWmM_I-6BPXFvz4E-n-o?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1x3Nky3YEAZMNzLqS_egfohPYPWqQZP0t?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1yh9vgfCH7xwu9j-y4O6b8NyQo65bhwmx?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YWDWE72VzO-d_sbGGq0w5x080pLHE58z?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1odM_-BhITVuJ-ToYY-H1oqPJjvQ_wA5B?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pVuUWvBGeTCSy13nIO6ZGAmpPIXK3lEe?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jOhc-9QjX9MIcadqvxGaHBaUlTuhck5L?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1TsR_tIQOq9wgUCRV-zM0bcjJ5wA6NyUX?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jZFrfcIVRJSg7m7fedi4uQpM174oakE6?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1snSj2UMtqh6LB7VCSirjN6MYnsLPEuZn?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EMPRENDIMIENTO PARA LA PRODUCTIVIDAD </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fHJGOQYcy_PViN8JkeREy3RlmfdPPev1?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ovbzwMKeGWsBq5_2J6K7HQZvHjOyofd0?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1t9mrHjlhyxq2DQIsRosRKQA7k5z-N_kY?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1akuJfXfMPTXFSHtjYsPX9dEx1E1JnyGs?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1iMWX3TGVKvrYSzFVRQDWkt0Ks-iane3Q?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOG&Iacute;AS DEL APRENDIZAJE Y LA COMUNICACI&Oacute;N</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19K7dvayW33BUHsEC83TvOSlkM0qwNjQm?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1IfcFnsNlvVgLltfjrkFOlVrUmxMMLlL-?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1vR4VDfWOFpeYsqg2a6jI2E2u7F_jvk_C?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1LsxdKob_lCNoVasBP9_LlLduHw0xbIGc?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Iy8EjOqizrfZoLNW8FPEdo7JsNzuPKR_?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA DE VALORES (L&Iacute;der en M&Iacute;)</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RZzFkFhS06PC2C0cOtrsxPfCCTb3VK2F?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA PROGRENTIS</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GpZoSsaDr2HnqRdC98J4F5g360nynwZ2?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA DE R&Oacute;BOTICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sl9d5w87OtdOHQPlPNHRztzrhVPwlc-4?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZWQDek9JVeeyTpRLX3Kt1QdwLjfCTkF0?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1nvChC6aUJbJkUkTtnDW483_D8_hKLuFU?usp=sharing" target="_blank"> NOTAS PLATAFORMA</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_grado == 3) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close "> SEGUNDO B&Aacute;SICO</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fqalBcyi5Dpn8hFOa-w0OOcZS7GMp-Aj?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1B2SvEHYd5NbldAd0sgHywhyBLig3Gxqi?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1_Q8UFiJN_Ey-RY9Qc0Vphkk7x2kXrpMg?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1nJ4n3PxgLHxaQ1qQ8lhVm0jyPbZjotFi?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1OqxJ4X3szwLVrYzXLnkGFElNQzDVVUvL?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1lvA5EM06mWtIhjF_Ui8mmeNewfMkDnem?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1osO-pBaMNNqF1a-VRdoGyuCcxh9X4vYJ?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16G89WzT3W3qVvsYkFoWTAoovgbSUNN96?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1n2du4UHiHqJbU5AGlYx82Jdk7A-3Alzp?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1auUvsDecpHZ3T7j8dvbZK9RWXFGAPXRy?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1EZzG_NeHRVwbQmsIwQ0IAZk-Qo7y2Zl4?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1AwF3g6aZB43sv3fkT6-YObjP3Y6rRVG-?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Lqh7oSKqSAZBC20GwyTXtWwEGoKvgM9M?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1za0m5Ri6TuTPQC-gQDBjvrFhZl4sWDXe?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1irg_Nmt7UiigbigY6kFoCp3_b96rTfi5?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RwObCfLPUAQX4iB-rAxKJL3Nw01SxEnS?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZNJxTU9y8jUnVWJ55bDZ0Y3PJRMz3Hq-?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1bjt8GtYiGeDAGyG8rpCXNUHIapaU8cHc?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12inbUSZpTQxJtA4QumrZYz5WE4ySDrJR?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18MCFwTe4scADZRTjvfCBRXNQXxBHVDr2?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS SOCIALES, FORMACI&Oacute;N CIUDADANA E INTERCULTURALIDAD</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12vPpkMmy4JpnKaUcHZUWE-kRcE64DUg6?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GX9kL0JBfHv2Fic0Sixr5SLrjE4yF_CG?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/193mQFBl3XtJkDpXvOnLnUDegvYJRsJWE?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13k9c6l3kcB-DiQqAYfuDv8KD8wJjga3k?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Tz1ZO18tEExUse-qciAKSwaMOWZ1DC9-?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/14jrAr1cj7PyUfcloxrsPYpmn-dYXjcib?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CKVTN12vgMNyJfZPMaT7k2JgEieBQO_X?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/10iLnLs_AVBbpc1NaRwqxD-HoNCzLO9rJ?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1_XcrWRrpL3KwzFu--jEgysiwt7I1OXfs?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/17HFmE3XB2EgDqcuCkRgMDCpiw17H_fXi?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1lig_OSVU6MAUQ0J6olgPtvqkKRHi1oz_?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pqnrK5p_Pgj5f3JgKGtMlpsViPC4lO8e?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1HYv496ggMV8gUe00_Lxb64X6-VfVWbhq?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BWg4oWhYIE2FXgl9YoJJ2SebwcCAl89b?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1XDa1XUXXAJOqm3h90PWHpHAzdfMPseKl?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CS1QfKKPDWZTbGT3CHbWq9v9Vkx497c9?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1p0523cEC8YYXfX0cas2LNE9MZkQNknal?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1lHTWPYdy8pD429Zbw8fS-MZZTg2m77BX?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cNDL52UmTOzlp7JiyPnzyL2776sPDsAU?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1eQuYpZnKnoSsXVTaerBQmbx3Gd1GQ77V?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EMPRENDIMIENTO PARA LA PRODUCTIVIDAD </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1I9mT5UAImo80gpsoz8a8rvOswLGP-WIo?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1h_K2k4bdfsowzHVEKw_-pReSAQlVMjYF?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1KcZy7WTgiHNO4mgvbrnhCigPI-uR3BTR?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1SwFNT_SKeJ3pYIH1nS4r8gjA52AGkasW?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/131PLNhZyLocXyegkBAhPeT4Pf0w_89sk?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOG&Iacute;AS DEL APRENDIZAJE Y LA COMUNICACI&Oacute;N</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13aOFZfqSNxgX_rfg75iQZ68tGw9Fvq7J?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19_oCJKd7wn37-6Z6Ss40ODdIszIArij3?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1yNUf-mM-qHvNBtxy_xk5dcM_b-BiUXgE?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1dOV6QKE8bXnmxvChw14zIK1dBYDZnPbr?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1fP2UV2L4nABCoY3lKnDHT2hbFgcn-pox?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA DE VALORES (L&Iacute;der en M&Iacute;)</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Es9LkvwJvzTfbolPxNWmLm5akkOjH6Au?usp=sharing" target="_blank">PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA PROGRENTIS</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1LMjl_XNw8T5dQtyP0EcPAUTQZh60_Et7?usp=sharing" target="_blank">PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA DE R&Oacute;BOTICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12veU8xBHIq5pi3mt-89_xg9HxKkT51J8?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1-bsWKHidoBHcL6yqks0k_EHz5BBMekGH?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZXurDi1H-4dR_Rh-IW3eNTb-wK4QxZsm?usp=sharing" target="_blank"> NOTAS PLATAFORMA</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_nivel== 4 && $info_grado == 1) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> TERCERO B&Aacute;SICO</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L1 ESPA&Ntilde;OL</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sQ6-q4BnqxovUeJd7VacUMVX9FWQjl5a?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1iAh5_jsdhWRZxIe2-xuVm_b66eqrLCnp?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1RM73vBrPFcKfJcQBenfGNfOM0zxG5uZN?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12-ZoBxlv-5kwpeHQROcxZM4JTIKnN1qh?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/195imKEIbFnT87cbHu5VmSAZxBKPV8N6o?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L3 INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1mxeHYY67C6ifeNXYwQQzL7Uf_4LPF9GE?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ohRCsqnTwPfR6gBxkbAT_F2Sp_Mt87wy?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ntEXF0uPR7jN3o_QcJy2mol_eh7Plgz-?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1W3csItHMh3GTG1WDJeCkR6ne6Tfo5Jt-?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1nbspASm5auep1h1Blou0t5w5PpXaUXWH?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1x_zr3xbm7qXBJs4JHpFyT0PxC0zS-WmA?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1aat7vPu_h8BW5SOfJAZk9P9GJbWrL4hW?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1st5m8fACRpP-Z4tfjnjUXJAaGHGDgeGZ?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1nDJZuNK274a_9dRvWa8RL3QjzZzvkEQI?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YD31LSHQyNURTPNF_2plcMMvwPEqvlqT?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18jep_4yD3CpOQLCeOP2DqL3mEL7dX5hX?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wmc1hgFU_PdYsvwTsVq3t4V6xzpAHVM9?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pqHSYiNOzCx9LpZzww9wCSxaOWb57AH-?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Mj_isuN4urpfU3bUMNZBnmXdG6V9n4zD?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ALoourl5BFnW7CG_Q6LLvoWDfER6rugG?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS SOCIALES, FORMACI&Oacute;N CIUDADANA E INTERCULTURALIDAD</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1aSGhyLYYORwANheSQD8HJU3CnlCNmHKU?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GbAlIkiwUO5ywv_2IqbLrYOvmJPzoI0p?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1w1jgZgplPmXDztccQmM8Fnb2GxvX7KMd?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1g4AXSuFr5rTarOzSHtuua8-NOlVeYQbf?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1FYrwzPMzUcOrOjlj27BJr694KJLEoZCm?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE L2 CAKCHIQUEL </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1KRxUQ7muD44xcsOGBmzxayXCmERwaM93?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1bv-nz2_V5SlBariuJoVK2VN1j8k_bmUL?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1tSxtONx9hWxMrK6lFSfOUPAwxuRY7rrG?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1MYSqL2acW2qiVcVvEGg8XSVgV0bUtiHn?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19sy44WH382v3dj3qtdobiNXAQbROVrrP?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CprZvO3mQmh8VitTqshSpztfq6RIo5hd?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1MrV_Z7eyW5ftde_Wyqk4xRz-tnFTsBQL?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11rbjKutTuWepDyIa-MAJBgKun4CqtV5k?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1AY0brsyuhCrBzAEAXgK7Yy5nfxHbN37i?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1XGkeZVj-dSrZmUwQwUWeg_qJm8mY6jnX?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Q9HZTP_Mb4R-a90s8NhgDm0YshQFXIVm?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1P_iVwSk4g3zzuMzZkUJBZcM2zm6NbtWq?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1n1y7EYhdlgt6NYdUBtU0XoLr-vDYVjMi?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1AfjMyXKuw2DvwlGfsTRzprdGz0xnX5iE?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/10FAW5oIxnNwr90WTN_Sxh7usTeCtUwzb?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EMPRENDIMIENTO PARA LA PRODUCTIVIDAD </label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/170F4dtHGBRDjIItirraiSFHcrIjDbH8g?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1FkbA_d_TxQmEgCHfEr6CpDWW0AGYK6JO?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BoF-kR_toEEYVn9kjHXDn2wjUo2SdThs?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/10hE-fHAKK6uThHWaubA1Wtr4M9FwguQI?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1NxsYtStxXIqAfPWSQZNV7gF9IT2vRqSa?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOG&Iacute;AS DEL APRENDIZAJE Y LA COMUNICACI&Oacute;N</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Xl7K5s7ZZh88aeF3-x5_EDavFlu8yeE2?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1g3qwS8YOO_4S619tvuEk2NKqPFnxkcgt?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1o7jIFeFxDF0_87iwMGIZFsM6RdmFLYdH?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Kmdxky2aSXpyl22z3rnfbVSw2KSyHb_6?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sVpdJOXdrLu7Jyz_SuERrXXRdbuF_dfV?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA DE VALORES (L&Iacute;der en M&Iacute;)</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1pDyZKtL0xPI6w-U7x6OBryEs-WKSubBG?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA PROGRENTIS</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1sWjoyiyndKf6N5GyhKH3T9YwtyuDKpli?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA DE R&Oacute;BOTICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1qYP1nkcHh95bTIWjTCH7AiZPajOZX8Ux?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13kfQCC6XYX96-FJ5kXl0hl08XIsVy0YT?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13Dj8XZvtV1Nc4-xe3n7ZsFkm6OJx3zB6?usp=sharing" target="_blank"> NOTAS PLATAFORMA</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
															</div>
														</ul>
													</li>
												<?php } ?>
												<?php if ($info_nivel == 4 && $info_grado != 1) { ?>
													<li><i class="fa fas fa-folder text-primary"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close text-primary"> DIVERSIFICADO <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>
														<ul class="nav nav-list tree" style="display: none;">
															<div class="col-xs-12 ">
																<?php if ($info_grado == 2) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> CUARTO BACHILLERATO</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE LENGUA Y LITERATURA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1LFAtC3im3m3DvlbnEz0iMzxw7b0ymY1n?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1e9uywND9kSHZ1V7ms1rbM8xy5NDcs2Zx?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cH8Y0dF0Rh2rjAFm6qCSiaVxaN0l5XPv?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1cZIm239zupZsoYE1-cbfpgEVbDd01_rh?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1-68K1jaxVvTC0CxzRT115AF5H-GYXl5X?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1XY51UTFHhrsn3Tyh07bzxsgogRbnPvq1?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1acDssqCcBb91Jb9MFimdgV0Z5C40o3a3?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CPti8Gaa-uVupznQ9_4r0oNuW0pEkaPr?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1_987UTxfNzm4V3w30VY42D0xo81h9773?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16KUL3ogLvuRzR5v4sSajiH3QJ3sXK2gL?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOG&Iacute;AS DE LA INFORMACI&Oacute;N Y LA COMUNICACI&Oacute;N</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GTrCYmzThyoUDdf3lfCl6xho9J8Jf3bj?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1XJTN0VOmjeJSn7aNKiLGDYzovLn0_Oba?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Lpwnc99iZTLFyFCTz5s2y_42q3QKZpI6?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ZaGfkLhrmbSGjoJmMk4ne1HOTFXhbBOM?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ifShRXC1fCg9Cg8L8_fTs-1PwQnytxcH?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GgydQPNeAGVVYDkFv8w2kEVD6SjGR_OF?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GyQ59NSzdfiNKUJUVPcQNGjfnWUsgbNj?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1qxFNfLwMrdSdu9q2P_jOij8iciXi1YpS?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1OGg7T91rjzlvJ7UkmX7Tvu_-9_3B80EB?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1NNwgwO6uG8Et78ElK5wVoPpTnVkh7zIQ?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS SOCIALES Y FORMACI&Oacute;N CIUDADANA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1_CoJmAvXh9rXwV_sRMORxUIFaZWFZVCX?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1XnRuLD0tk4BfBfIn4URdCpY2fqnueDGj?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1QHn6vHh__znFhC0Jn_DKZrN0WL-aNLWC?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1kEeil5XFZQCVS5kMRJyjUksVg2FCR62x?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12H6WkNDtIaNegZxsvwMmZSr8EsSGPRuF?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES – F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1_58o6YECMUAqpXsqc5QaIFyAM4IxBcfP?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CMNzi2O4JUlfukJEZySRW-72iMjz7QGl?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jiHsfWzY403AReykvHvfRJzs1uXjZpzX?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1h_kXTN4mQkyt2k8y7mHmfE0OU_WtrjwN?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1EaVgQzMG0ShreOKkNQ4kh63TeydcsIn2?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1w109roOhCyvqAWuNp_KHEYuJpk3t3ows?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1zlvo5MSqSfDqgFp7d7k2jPF4rQO_uphw?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1QmChRj-iNqYumnAYI0i6-oXPr9Yx657Y?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1gSY66eJRIbauZQdRRV5SjpK_b5jBpsRD?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1IZqvCh6JcKjwSZj2Hbk_neaT9fa2tXaU?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> FILOSOF&Iacute;A</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1micJrfQpwjK2TxeeVXv1zQrYKl8OPwt2?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1a_08VyaI92myx8CoqDpjMlCSdvGlCDSC?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Hp5QxV9y58RSoeL_HsmyBH0oYZ2HkKOt?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1th7eDUEJcwNEgmVUSq709KiUYM4ir62Y?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16Iju_etJcrjXC3vBblF0E7xIS1tMAhP9?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PSICOLOG&Iacute;A</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BN06OZ3HZdrv7BNe2XLm6IkDt_3sidfh?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1AlwZnlK2OXNnKedtp_lhGvfWF8NYT5KZ?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/16NCJBm3gvENBGjf8usCYIhD3lQii49O3?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ldafPJ3bFXnmqSaENz0G6ScUu7q6eCgX?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1f6G9WD22ORB7SsW6xjp7SXbqOzmWuLXt?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> ELABORACI&Oacute;N Y GESTI&Oacute;N DE PROYECTOS</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1istajYA1JbGsLc018mUQ0ufb0FKVL2vr?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1vFlALSqp7ueyinsL3_lePUorSz1OTlIY?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19rzM72HxTWaXKOj7hp-I0SnEtZfn4sMe?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11t_dhfyl13alALg3YHh7SSAodTU7CJR8?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1-Ypy0_rYiavkFvW1kfmTsbWNTXbCTf0d?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA DE VALORES (L&Iacute;DER EN M&Iacute;)</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19eyz9pdT-Ou_CeRlD78HNgNC5YcnDoqu?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA PROGRENTIS</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Q5C_Cj3CzY9j3ayMrGhhOBHj57wo7m02?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA ROB&Oacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1eQE-EbEp6a1mioBFEhtvMauv9H31YYDD?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Tb_8QyUagSKLW1t1S-TN7mO6W_yzQIsn?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1mX-fL6lGufjvNO-9UfEVWvjSjT2zgTU_?usp=sharing" target="_blank"> NOTAS PARA PLATAFORMA</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
																<?php if ($info_grado == 3) { ?>
																	<li><i class="fa fas fa-folder"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close"> QUINTO BACHILLERATO</label>
																		<ul class="nav nav-list tree" style="display: none;">
																			<div class="col-xs-12 ">
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE LENGUA Y LITERATURA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1WAjnwvrI6UkPBsWA4hvc4c9Ad1NxBh1M?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1h6p0JpjX_ZC5lzzEmTL4Zy2o71xozPum?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YMc2PHynW6pRvgTxz2ZQbA3VFf5AdXsc?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1O8hC8zihdjvmZLZQCXBkVfiV9O8erL93?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1uyvCTn3wXKzRwBL6Z-tWhTO-IGdeJezq?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> COMUNICACI&Oacute;N Y LENGUAJE INGL&Eacute;S</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1bR_kcxi1ncs7VnLc3cexyJQL5yByejPy?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18kLt3eSCtAoo2m7vnfD6yHQAoq28ewB1?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1oTzR4Pae3HdRombJILR_KdZFFtG6KGSt?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/156MlPGjN4cBwvWOK9Uei5o7Re89aQbDn?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1imSFZmQIfmGxN3PuOGAhHrRmCZMqIbjD?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> TECNOLOGIAS DE LA INFORMACION Y LA COMUNICACI&Oacute;N</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1JqqTChNnyJrR74-Mnz2oTmQFC8iKsRBM?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13aufXZ0o1Mqz-Vvn6jKnw5lF1sPkVFQg?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13-9rAn7OYYbas2udgZNifJoHTY47Il8R?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1wMP-KUCTUGLr1mz9vvPdFRrWnZZX4xKn?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19MNf3AC-zyADJW9faanZWHhaB26R9bBh?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> MATEM&Aacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ETuvfcLBCzoiPBLlBf7IcEBHO-osA3di?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1QPZiya2SKFy3fJWyH7yUnwOl21cKaH2N?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18JtV92yePBhpJRp839uPAFLiSruAStHY?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1m22ZC3vyYYoAcfrKh9__GaVyghrysTrG?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1GgR3Icc2p--v2TWy7R0AhgdmwUmSY3oB?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> ESTAD&Iacute;STICA DESCRIPTIVA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BKAWIeFC_6mwzcF745t8M_zC_oFEhtHu?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1xsR7daloIZa6mIwLuBM1WXs8ZAGrS1ZN?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/19LFMfaOmNLmwBoM4LtxB3luQ54MwlrId?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/137VUFHkZ_F4DXIXTNJWYS-Tu6bd8lS2w?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ymz1UQHt2WimrdNt8iYRKbnrlFJOh392?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS SOCIALES Y FORMACI&Oacute;N CIUDADANA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1W0ehgoPGUS93tIBclYSWx-ceqbTTt1cW?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1kwBs4J7K4SFOF_2x3i33EwHWbHDtzw3x?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/12pR3ALfCJSj6fbJmARiCrOxS_u27wnt-?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11ISrRea4MmcxA9zZqsqAzOPHOsmVJsh8?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1U_yCSFIlNNmSzQCrMzNsuRCt-KRDZ1WN?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES QU&Iacute;MICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1IulOF5Sl5lKVKv7Xp3Yg1daPvhYVL9-v?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/142GTDjRVl5CnYQAfomXsESAU56q6VF90?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1ScY7_bggW1GRrjEz5TlCLsuB6PcDL5Ie?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VJCQoFnOeysEeH_ua4ejm8h37oM9cebA?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1BcJwZJeLjX7bp-3m_iwmInaijDVR-VsN?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EDUCACI&Oacute;N F&Iacute;SICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1clO_Htvu2QnJ1h4mLc1LStwgpPsByA6l?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1eKddMkzW86Veteb4x1vEyTt8f3Q1S11e?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1rHOYYYrnyZtvrauazGImL5GA_m2N0Fbc?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1aPAec8GyTszFG0p1_IAzqfrkLmXPf3f2?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1MKhWnx9KJTwoo0lSx4TvYls66ZKg5cL8?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> CIENCIAS NATURALES - BIOLOG&Iacute;A</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1xEwDErPOraxJDKIe7BUv7R3CGmS2Ggrr?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1vHhD_TiBsHgrAiFKqSGBYRBTpEHU9Zg6?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1yChwykwmz-aqAI1EjrIuU-5IMw-aoobh?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/13z8gTLHZClTDYEuLxin7PDqywF2LeZHp?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Wb-WPVL5n6OuHLWbOOBX8EKSB1LOJ6YD?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> EXPRESI&Oacute;N ART&Iacute;STICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Q2GMtPIcRGMMMtZ24HBjS2098F2j6cHE?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1YOoUAHUpkOWfsd6R_Q5c1dpBY5FmLdcp?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/10Xr0I_0AvbOmMG_dJjj8xsY1JKr8C2Rx?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1Hi8uqN9DkWiZ23dC-zIEaiMobnXGicgD?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1EaqKmgO-kpyrz6_LL5luu5SFKW2TzQFl?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> INVESTIGACI&Oacute;N-SEMINARIO</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1VhqjGqCWzRPfA_IvwNZQuzEJE_7OSRm2?usp=sharing" target="_blank"> ACTIVIDADES DE EVALUACI&Oacute;N</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/18SGg6XEhTdfltEFHjFqV4XciVue756RE?usp=sharing" target="_blank"> ORGANIZACI&Oacute;N DE LOS APRENDIZAJES</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1vkBHU_5Vw_bhTmS5OGpBqGjruTaTwmIX?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1CJpNb40V2UaVSwh_wLSSUEKRGO2mlCcJ?usp=sharing" target="_blank"> ACTIVIDADES DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/10QBlyYEUzIJWMUPVhVeY614ifaA7ugPI?usp=sharing" target="_blank"> CRITERIOS DE EVALUACI&Oacute;N</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA DE VALORES (L&Iacute;DER EN M&Iacute;)</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1zo3bMLTNtxaigGyVI9K-XhWdSaywihKL?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA PROGRENTIS</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1nrcj2kzBgOCyMbOfxyZQTTawv3HlJ-aW?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																				<li><i class="fa fas fa-folder-open"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-open"> PROGRAMA ROB&Oacute;TICA</label>
																					<ul class="nav nav-list tree" style="display: none;">
																						<div class="col-xs-12 ">
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/15Uiaq00zF2M9zuokbuRj9xjZzQTwl5uR?usp=sharing" target="_blank"> ACTIVIDAD DE APOYO</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/11--wp5_IC65I1gTc0f1n_XWV3qEjsBQh?usp=sharing" target="_blank"> PLANIFICACI&Oacute;N ANUAL</a></label>
																							</li>
																							<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1OH2BxADYenfWoEGQqQJyEpKHRYTR30G4?usp=sharing" target="_blank"> NOTA PARA PLATAFORMA</a></label>
																							</li>
																						</div>
																					</ul>
																				</li>
																			</div>
																		</ul>
																	</li>
																<?php } ?>
															</div>
														</ul>
													</li>
												<?php } ?>
								<?php
								}
								$i++;
							}
							$i--;
						
					
								?>
								<li><i class="fa fas fa-folder text-primary"></i>&nbsp;<label class="tree-toggler nav-header glyphicon glyphicon-folder-close  text-primary"> TUTORIALES Y SOPORTE T&Eacute;CNICO <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span></label>
									<ul class="nav nav-list tree" style="display: none;" style="display: none;">
										<li><i class="fas fa-link text-primary"></i>&nbsp;<label class="tree-toggler nav-header "><a href="https://drive.google.com/drive/folders/1jFAf9v5_OFzagGb8oTP9DcAGvhIljB4Y?usp=sharing" target="_blank"> INSTRUCTIVO PADRES E HIJOS</a></label>
										</li>
									</ul>
								</li>
											</ul>
										</div>
									</div>

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

		<!--Include the above in your HEAD ta-->
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

		<script>
			$(document).ready(function() {
				$('label.tree-toggler').click(function() {
					$(this).parent().children('ul.tree').toggle(300);
				});
			});
		</script>


</body>

</html>