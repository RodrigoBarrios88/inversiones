<?php
	include_once('../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	$codigo = $_SESSION["codigo"];
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
		<link href="../assets.3.6.2/bower_components/font-awesome/css/fontello.css" rel="stylesheet" type="text/css">
		
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
						<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-bookmark" aria-hidden="true"></span> Esquema Curricular <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							    <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/FRMbloqueoNotas.php"><span class="fa fa-tag" aria-hidden="true"></span> Bloqueo de Notas</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/FRMpensum.php"><span class="fa fa-tag" aria-hidden="true"></span> Programa Acad&eacute;mico (A&ntilde;o)</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/FRMnivel.php"><span class="fa fa-tag" aria-hidden="true"></span> Niveles</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/FRMgrado.php"><span class="fa fa-tags" aria-hidden="true"></span> Grados</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/FRMseccion.php"><span class="fa fa-tags" aria-hidden="true"></span> Secciones</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPMATERIA/FRMmateria.php"><span class="fa fa-book" aria-hidden="true"></span> Materias</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPNOTAS/FRMunidades.php"><span class="fa fa-edit" aria-hidden="true"></span> Unidades de Calificaci&oacute;n</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li><a href="../CPTEMA/FRMlista_secciones.php"><span class="fa fa-list-ol" aria-hidden="true"></span> Temas </a></li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/CPREPORTES/FRMreppensum.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Programa Acad&eacute;mico (A&ntilde;o)</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/CPREPORTES/FRMrepnivel.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Niveles</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/CPREPORTES/FRMrepgrado.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Grados</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/CPREPORTES/FRMrepseccion.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Secciones</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPMATERIA/CPREPORTES/FRMrepmateria.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Materias</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPTEMA/CPREPORTES/FRMlista_secciones.php"><span class="fa fa-print" aria-hidden="true"></span> Dosificaci&oacute;n (Esquema) Curricular</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($_SESSION["MOD_academico"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-bookmark-o" aria-hidden="true"></span> Cursos Libres <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPCURSOLIBRE/FRMcurso.php"><span class="fa fa-tag" aria-hidden="true"></span> Gestor de Cursos Libres</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPCURSOLIBRE/FRMlista_cursos_temas.php"><span class="fa fa-tags" aria-hidden="true"></span> Gestor de Temas</a></li>
									<?php } ?>
									<hr>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPCURSOLIBRE/CPREPORTES/FRMrepcurso.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Cursos</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPCURSOLIBRE/CPREPORTES/FRMesquema.php"><span class="fa fa-print" aria-hidden="true"></span> Dosificaci&oacute;n (Esquema) Curricular</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-book" aria-hidden="true"></span> Asignaciones<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/FRMasiggrado.php"><span class="fa fa-link" aria-hidden="true"></span> Asignaci&oacute;n de Alumnos a Grados</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/FRMasigseccion.php"><span class="fa fa-link" aria-hidden="true"></span> Asignaci&oacute;n de Alumnos a Secciones</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPCURSOLIBRE/FRMlista_cursos.php"><span class="fa fa-link" aria-hidden="true"></span> Asignaci&oacute;n de Alumnos a Cursos Libres</a></li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/CPREPORTES/FRMrepasiggrado.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Alumnos por Grados</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPACADEMICO/CPREPORTES/FRMrepasigseccion.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Alumnos por Secciones</a></li>
								<?php } ?>
								<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="../CPCURSOLIBRE/CPREPORTES/FRMrepasigcurso.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Alumnos Asignados a Cursos Libres</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($_SESSION["MOD_academico"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-mortar-board" aria-hidden="true"></span> LMS Acad&eacute;mico <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-copy"></i> Gestor de Tareas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-copy"></i> Calificar Tareas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-copy"></i> Visualizaci&oacute;n de Tareas</a></li>
									<?php } ?>
									<hr>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPEXAMEN/FRMlista_secciones.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-laptop"></i> Gestor de Evaluaciones </a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPEXAMEN/FRMlista_secciones.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-laptop"></i> Calificar Evaluaciones </a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPEXAMEN/FRMlista_secciones.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-laptop"></i> Visualizaci&oacute;n de Evaluaciones</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_academico"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-mortar-board" aria-hidden="true"></span> LMS para Cursos Libres <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["MOD_tareas"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPLMSTAREA/FRMcursotarea.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-copy"></i> Gestor de Tareas para Cursos Libres</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPLMSTAREA/FRMcursotarea.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-copy"></i> Calificar Tareas para Cursos Libres</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPLMSTAREA/FRMcursotarea.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-copy"></i> Visualizaci&oacute;n de Tareas para Cursos Libres</a></li>
										<?php } ?>
									<?php } ?>
									<hr>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPLMSEXAMEN/FRMcursoexamen.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-laptop"></i> Gestor de Notas  para Cursos Libres</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPLMSEXAMEN/FRMcursoexamen.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-laptop"></i> Calificar Notas  para Cursos Libres</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPLMSEXAMEN/FRMcursoexamen.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-laptop"></i> Visualizaci&oacute;n de Notas  para Cursos Libres</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_academico"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-clipboard" aria-hidden="true"></span> Notas <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMlist_vernotas.php"><span class="fa fa-list-ol" aria-hidden="true"></span> Ver Notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMlist_sabana.php"><span class="fa fa-list-ol" aria-hidden="true"></span> Sabana de notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5 || $tipo_usuario == 1){ ?>
									<li><a href="../CPNOTAS/FRMlist_asignotas.php"><span class="fa fa-save" aria-hidden="true"></span> Ingreso de Notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMlist_certificanotas.php"><span class="fa fa-check-square-o" aria-hidden="true"></span> Certificaci&oacute;n de Notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMlist_editnotas.php"><span class="fa fa-edit" aria-hidden="true"></span> Modificaci&oacute;n de Notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMnominanotas.php"><span class="fa fa-file-text-o" aria-hidden="true"></span> Nomina de Notas  por Grado</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 ||$tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMlist_alumnosnotas.php"><span class="fa fa-file-text-o" aria-hidden="true"></span> Tarjeta de Calificaciones</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<!--li><a href="../CPNOTAS/FRMlist_alumnoscuadro.php"><i class="fa fa-trophy"></i> Cuadro de Honor por Grado y Unidad</a></li-->
									<?php } ?>
									<li class="divider"></li>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMlista_graficasseccion.php"><span class="fa fa-bar-chart-o" aria-hidden="true"></span> Estad&iacute;sticas por Alumnos, Grados y Secci&oacute;n</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMlista_graficasmateria.php"><span class="fa fa-bar-chart-o" aria-hidden="true"></span> Estad&iacute;sticas por Materias, Grados y Secci&oacute;n</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTAS/FRMlista_diplomas.php"><span class="fa fa-file-o"></span> Diplomas de Grado</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_academico"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Reportes <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPMINEDUC/FRMsecciones.php"><span class="fa fa-edit" aria-hidden="true"></span> Actualizar Codigo MINEDUC</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPMINEDUC/CPREPORTES/FRMinscritos.php"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Listado de Alumnos Inscritos (MINEDUC)</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPMINEDUC/CPREPORTES/FRMlistado.php"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Listados de Trabajo (Auxiliares)</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
												<?php if($_SESSION["MOD_academico3"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-bookmark-o" aria-hidden="true"></span> Cursos Libres <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPCURSOLIBRE/FRMcurso.php"><span class="fa fa-tag" aria-hidden="true"></span> Gestor de Cursos Libres</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPCURSOLIBRE/FRMlista_cursos_temas.php"><span class="fa fa-tags" aria-hidden="true"></span> Gestor de Temas</a></li>
									<?php } ?>
									<hr>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPCURSOLIBRE/CPREPORTES/FRMrepcurso.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Cursos</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPCURSOLIBRE/CPREPORTES/FRMesquema.php"><span class="fa fa-print" aria-hidden="true"></span> Dosificaci&oacute;n (Esquema) Curricular</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_academico3"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-mortar-board" aria-hidden="true"></span> LMS Acad&eacute;mico <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-copy"></i> Gestor de Tareas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-copy"></i> Calificar Tareas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-copy"></i> Visualizaci&oacute;n de Tareas</a></li>
									<?php } ?>
									<hr>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPEXAMEN/FRMlista_secciones.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-laptop"></i> Gestor de Evaluaciones </a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPEXAMEN/FRMlista_secciones.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-laptop"></i> Calificar Evaluaciones </a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPEXAMEN/FRMlista_secciones.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-laptop"></i> Visualizaci&oacute;n de Evaluaciones</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_academico3"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-mortar-board" aria-hidden="true"></span> LMS para Cursos Libres <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["MOD_tareas"] == 1){ //permisos al colegio?>
										<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPLMSTAREA/FRMcursotarea.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-copy"></i> Gestor de Tareas para Cursos Libres</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPLMSTAREA/FRMcursotarea.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-copy"></i> Calificar Tareas para Cursos Libres</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
										<li><a href="../CPLMSTAREA/FRMcursotarea.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-copy"></i> Visualizaci&oacute;n de Tareas para Cursos Libres</a></li>
										<?php } ?>
									<?php } ?>
									<hr>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPLMSEXAMEN/FRMcursoexamen.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-laptop"></i> Gestor de Notas  para Cursos Libres</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPLMSEXAMEN/FRMcursoexamen.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-laptop"></i> Calificar Notas  para Cursos Libres</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPLMSEXAMEN/FRMcursoexamen.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-laptop"></i> Visualizaci&oacute;n de Notas  para Cursos Libres</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_academico3"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-clipboard" aria-hidden="true"></span> Notas <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMlist_vernotas.php"><span class="fa fa-list-ol" aria-hidden="true"></span> Ver Notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMlist_sabana.php"><span class="fa fa-list-ol" aria-hidden="true"></span> Sabana de notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5 || $tipo_usuario == 1){ ?>
									<li><a href="../CPNOTASPROM/FRMlist_asignotas.php"><span class="fa fa-save" aria-hidden="true"></span> Ingreso de Notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMlist_certificanotas.php"><span class="fa fa-check-square-o" aria-hidden="true"></span> Certificaci&oacute;n de Notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMlist_editnotas.php"><span class="fa fa-edit" aria-hidden="true"></span> Modificaci&oacute;n de Notas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMnominanotas.php"><span class="fa fa-file-text-o" aria-hidden="true"></span> Nomina de Notas  por Grado</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 ||$tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMlist_alumnosnotas.php"><span class="fa fa-file-text-o" aria-hidden="true"></span> Tarjeta de Calificaciones</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<!--li><a href="../CPNOTASPROM/FRMlist_alumnoscuadro.php"><i class="fa fa-trophy"></i> Cuadro de Honor por Grado y Unidad</a></li-->
									<?php } ?>
									<li class="divider"></li>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMlista_graficasseccion.php"><span class="fa fa-bar-chart-o" aria-hidden="true"></span> Estad&iacute;sticas por Alumnos, Grados y Secci&oacute;n</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMlista_graficasmateria.php"><span class="fa fa-bar-chart-o" aria-hidden="true"></span> Estad&iacute;sticas por Materias, Grados y Secci&oacute;n</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPNOTASPROM/FRMlista_diplomas.php"><span class="fa fa-file-o"></span> Diplomas de Grado</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_academico3"] == 1){ //permisos al colegio?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Reportes <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPMINEDUC/FRMsecciones.php"><span class="fa fa-edit" aria-hidden="true"></span> Actualizar Codigo MINEDUC</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPMINEDUC/CPREPORTES/FRMinscritos.php"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Listado de Alumnos Inscritos (MINEDUC)</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
									<li><a href="../CPMINEDUC/CPREPORTES/FRMlistado.php"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Listados de Trabajo (Auxiliares)</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
						<?php if($_SESSION["MOD_academico2"] == 1 && $_SESSION["MOD_tareas"] == 1){ ?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-mortar-board" aria-hidden="true"></span> Gestor de Tareas <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=gestor"><i class="fa fa-pencil"></i> <i class="fa fa-copy"></i> Gestor de Tareas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=calificar"><i class="fa fa-paste"></i> <i class="fa fa-copy"></i> Calificar Tareas</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="../CPTAREAS/FRMlista_secciones.php?acc=ver"><i class="fa fa-search"></i> <i class="fa fa-copy"></i> Visualizaci&oacute;n de Tareas</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
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
				<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico3"] == 1){ ?>
				<h2 class='text-primary'>M&oacute;dulo Acad&eacute;mico</h2>
				<?php } ?>
				<?php if($_SESSION["MOD_academico2"] == 1){ ?>
				<h2 class='text-primary'>Esquema Curricular</h2>
				<?php } ?>
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
