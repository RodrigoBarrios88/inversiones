<?php
	include_once('../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	$codigo = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
		
if($tipo_usuario != "" && $codigo != ""){ 	
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
		
		<!-- DataTables CSS -->
		<link href="../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
		
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
						<li><a href="../menu.php"><span class="fa fa-arrow-left" aria-hidden="true"></span> Regresar</a></li>
						<li>&nbsp;</li>
						<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-clock-o" aria-hidden="true"></span> Periodos Acad&eacute;micos<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/FRMtipo_periodo.php"><span class="fa fa-trello" aria-hidden="true"></span> Gestor de Tipo de Periodos</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/FRMperiodos.php"><span class="fa fa-table" aria-hidden="true"></span> Gestor de Periodos</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/FRMhorario.php"><span class="fa fa-clock-o " aria-hidden="true"></span> Definici&oacute;n de Horario</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-clock-o" aria-hidden="true"></span> Periodos de Cursos Libres<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIOCURSOS/FRMtipo_periodo.php"><span class="fa fa-trello" aria-hidden="true"></span> Gestor de Tipo de Periodos</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIOCURSOS/FRMperiodos.php"><span class="fa fa-table" aria-hidden="true"></span> Gestor de Periodos</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIOCURSOS/FRMhorario.php"><span class="fa fa-clock-o " aria-hidden="true"></span> Definici&oacute;n de Horario</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-print" aria-hidden="true"></span> Reportes <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_dia_seccion.php"><span class="fa fa-calendar" aria-hidden="true"></span> Calendario por D&iacute;a</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_semana_seccion.php"><span class="fa fa-calendar" aria-hidden="true"></span> Calendario por Semana</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_maestro.php"><span class="fa fa-calendar" aria-hidden="true"></span> Calendario por Maestro</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_aula.php"><span class="fa fa-calendar" aria-hidden="true"></span> Calendario por Aula</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_maestro_libres.php"><span class="fa fa-list" aria-hidden="true"></span> Periodos Libres de Maestros</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_aula_libres.php"><span class="fa fa-building" aria-hidden="true"></span> Periodos libres de Instalaciones</a></li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_maestro_grafica_diaria.php"><span class="fa fa-bar-chart-o" aria-hidden="true"></span> Estad&iacute;sticas de Tiempo Laborado Diario por Maestro</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_aula_grafica_diaria.php"><span class="fa fa-bar-chart-o" aria-hidden="true"></span> Estad&iacute;sticas de Tiempo de Uso Diario por Aula</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_maestro_grafica_semana.php"><span class="fa fa-bar-chart-o" aria-hidden="true"></span> Estad&iacute;sticas de Tiempo Laborado Semanal por Maestro</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPHORARIO/CPREPORTES/FRMhor_aula_grafica_semana.php"><span class="fa fa-bar-chart-o" aria-hidden="true"></span> Estad&iacute;sticas de Tiempo de Uso Semanal por Aula</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-calendar-o" aria-hidden="true"></span> Calendarizaci&oacute;n e Informaci&oacute;n<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPINFO/FRMnewinfo.php"><span class="fa fa-calendar" aria-hidden="true"></span> Calendarizaci&oacute;n de Actividades</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPINFO/FRMmodinfo.php"><span class="fa fa-edit" aria-hidden="true"></span> Actualizaci&oacute;n de Informaci&oacute;n de Actividades</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="../logout.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a></li>
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
				<h2 class='text-primary'>M&oacute;dulo de Control de Horarios</h2>
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
	<!-- DataTables JavaScript -->
	<script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
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