<?php
	include_once('../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	$id = $_SESSION["codigo"];
	//--
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
		
if($tipo != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
		<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
		<!-- Bootstrap -->
		<link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom Fonts -->
		<link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<!-- Estilos Utilitarios -->
		<link href="../assets.3.6.2/css/menu.css" rel="stylesheet">
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
	
	<div class="container">
    
		<!-- Static navbar -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"><img src = "../../CONFIG/images/logo_white.png" width = "30px"></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="../menu.php"><i class="fa fa-arrow-left"></i> Regresar</a></li>
						<li>&nbsp;</li>
						<?php if($_SESSION["MOD_calendario"] == 1 || $_SESSION["MOD_calendario"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){  //permisos al colegio?>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-video-camera"></i> Videoclases <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["MOD_calendario"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPVIDEOCALL/FRMvideoclases.php"><i class="fa fa-video-camera"></i> Gestor de Videoclases</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPVIDEOCALL/FRMdashboard.php"><i class="fa fa-th-large"></i> Tablero de Videoclases</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPVIDEOCALL/FRMlista.php"><i class="fa fa-calendar"></i> Historial de Videoclases</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPVIDEOCALL/FRMconfirmacion.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Videoclases)</a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_videos"] == 1 || $_SESSION["MOD_videos"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){  //permisos al colegio?>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-film"></i> Multimedia <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["MOD_videos"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){  //permisos al usuario?>
										<li><a href="../CPMULTIMEDIA/FRMvisualizar.php"><i class="fa fa-film"></i> Videos Sugeridos</a></li>
										<?php } ?>
									<?php } ?>
									<hr>
									<?php if($_SESSION["MOD_photos"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPPHOTO/FRMalbum.php"><i class="fa fa-photo"></i> Photo Album</a></li>
										<?php } ?>
									<?php } ?>
									<hr>
									<?php if($_SESSION["MOD_photos"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPCHAT/FRMusuarios.php"><i class="fa fa-comments"></i> Configuraci&oacute;n del Chat</a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_pinboard"] == 1 || $_SESSION["MOD_calendario"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-calendar"></i> Tablero de Actividades y Pinboard <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["MOD_calendario"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPINFO/FRMnewinfo.php"><i class="fa fa-calendar"></i> Calendarizaci&oacute;n de Actividades</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPINFO/FRMmodinfo.php"><i class="fa fa-edit"></i> Actualizaci&oacute;n de Informaci&oacute;n de Actividades</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPINFO/FRMconfirmacion.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Actividades)</a></li>
										<?php } ?>
									<?php } ?>
									<hr>
									<?php if($_SESSION["MOD_pinboard"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPPOSTIT/FRMpostit.php"><i class="fa fa-thumb-tack"></i> Gestor de Notificaciones a Padres (Pin Board)</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPPOSTIT/FRMpinboard.php"><i class="fa fa-clipboard"></i> Visualizaci&oacute;n de Notificaciones a Padres (Pin Board)</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPPOSTIT/FRMlectura.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Postits)</a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_panial"] == 1 || $_SESSION["MOD_conducta"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-sun-o"></i> Reporte de Pa&ntilde;al y de Conducta <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["MOD_panial"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
											<li><a href="../CPPANIAL/FRMalumnos.php"><i class="fa fa-square-o"></i> Gestor de Reporte de Pa&ntilde;al</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
											<li><a href="../CPPANIAL/FRMreportes.php"><i class="fa fa-clipboard"></i> Visualizaci&oacute;n de Reportes de Pa&ntilde;al</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPPANIAL/FRMlectura.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Reporte de Pa&ntilde;al)</a></li>
										<?php } ?>
									<?php } ?>
									<hr>
									<?php if($_SESSION["MOD_conducta"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
											<li><a href="../CPCONDUCTA/FRMalumnos.php"><i class="fa fa-sun-o"></i> Gestor de Reporte de Conducta</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
											<li><a href="../CPCONDUCTA/FRMreportes.php"><i class="fa fa-clipboard"></i> Visualizaci&oacute;n de Reportes de Conducta</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPCONDUCTA/FRMlectura.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Reporte de Conducta)</a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_golpe"] == 1 || $_SESSION["MOD_enfermedad"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-medkit"></i> Reportes de M&eacute;dicos <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["MOD_golpe"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
											<li><a href="../CPGOLPE/FRMalumnos.php"><i class="fa fa-ambulance"></i> Gestor de Reporte de Golpes</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
											<li><a href="../CPGOLPE/FRMreportes.php"><i class="fa fa-clipboard"></i> Visualizaci&oacute;n de Reportes de Golpes</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPGOLPE/FRMlectura.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Reporte de Golpes)</a></li>
										<?php } ?>
									<?php } ?>
									<br>
									<?php if($_SESSION["MOD_enfermedad"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
											<li><a href="../CPENFERMEDAD/FRMalumnos.php"><i class="fa fa-stethoscope"></i> Gestor de Reporte de Enfermedad</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
											<li><a href="../CPENFERMEDAD/FRMreportes.php"><i class="fa fa-clipboard"></i> Visualizaci&oacute;n de Reportes de Enfermedad</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPENFERMEDAD/FRMlectura.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Reporte de Enfermedad)</a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_encuestas"] == 1 || $_SESSION["MOD_circulares"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-clipboard"></i> Encuestas y Circulares <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["MOD_encuestas"] == 1){ //permisos al colegio?>
										<?php if(($tipo_usuario == 1 || $tipo_usuario == 5)){ ?>
										<li><a href="../CPENCUESTAS/FRMnewencuesta.php"><i class="fa fa-file-text"></i> Crear Encuestas</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="../CPENCUESTAS/FRMmodencuesta.php"><i class="fa fa-edit"></i> Editar Encuesta</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="../CPENCUESTAS/FRMlistencuesta.php"><i class="fa fa-bar-chart-o"></i> Resultados Encuesta</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPENCUESTAS/IFRMencuestas.php"><i class="fa fa-paste"></i> Revisar Encuesta</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPENCUESTAS/FRMconfirmacion.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Encuestas)</a></li>
										<?php } ?>
									<?php } ?>
									<hr>
									<?php if($_SESSION["MOD_circulares"] == 1){ //permisos al colegio?>
										<?php if(($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5)){ ?>
										<li><a href="../CPCIRCULAR/FRMnewcircular.php"><i class="fa fa-file-pdf-o"></i> Publicaci&oacute;n de Circulares</a></li>
										<?php } ?>
										<?php if(($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5)){ ?>
										<li><a href="../CPCIRCULAR/FRMmodcircular.php"><i class="fa fa-edit"></i> Actualizaci&oacute;n de Circulares</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="../CPCIRCULAR/FRMautorizacion.php"><i class="fa fa-question-circle"></i> Autorizaciones de Circulares</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPCIRCULAR/FRMconfirmacion.php"><i class="fa fa-info-circle"></i> Confirmaciones de Lectura (Circulares)</a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="../logout.php"><span class="glyphicon glyphicon-off"></i></a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</nav>
		
		<!-- Main component for a primary marketing message or call to action -->
		<div id = "contenedor" class="jumbotron">
			<!--================================================== /.navbar ===========================================================-->
			<!--===============================================================================================================================================-->
			<!--========================================================START WORK AREA========================================================================-->
			<!--===============================================================================================================================================-->
			<div class="text-center" >
				<h2 class='text-primary'>M&oacute;dulo Comunicaci&oacute;n</h2>
				<p class="lead">
					<?php 
						$nombre = $_SESSION["nombre"];
						echo $nombre;
					?>
				</p>
				<div>
					<br><br>
					<img src = "../../CONFIG/images/escudo.png" width='20%' >
					<br><br>
				</div>
				<br>
				<small class='text-primary'>
					Powered by ID Web Development Team.
                    Copyright &copy; <?php echo date("Y"); ?>
				</small>
				<br>
				<small class='text-primary'>
					Versi&oacute;n 3.6.2
				</small>
			</div>	
			<!--===============================================================================================================================================-->
			<!--======================================================END WORK AREA============================================================================-->
			<!--===============================================================================================================================================-->
			<br>
		</div>
	</div> <!-- /container -->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/menu.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	</body>
</html>
<?php 
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
