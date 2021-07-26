<?php
	include_once('xajax_funct.php');
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	$id = $_SESSION["codigo"];
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
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAsi = new ClsAsignacion();
	$ClsCir = new ClsCircular();
	$ClsInfo = new ClsInformacion();
	$ClsPost = new ClsPostit();
	$ClsGruCla = new ClsGrupoClase();

	if($tipo_usuario == 2){ //// MAESTRO
		$pensum = $ClsPen->get_pensum_activo();
		$maestro = $tipo_codigo;
		$codigosPostit = '';
		$codigosInfo = '';
		$codigosCircular = '';
		$result_secciones = $ClsAcad->get_seccion_maestro($pensum,'','','',$maestro,'','',1);
		if(is_array($result_secciones)){
			foreach($result_secciones as $row){
				$nivel = $row["sec_nivel"];
				$grado = $row["sec_grado"];
				$seccion = $row["sec_codigo"];
				//--
				$codPostit = $ClsPost->get_postit_codigos('',$pensum,$nivel,$grado,$seccion,'','','','','',1);
				$codInfo = $ClsInfo->get_codigos_secciones($pensum,$nivel,$grado,$seccion);
				$codCircular = $ClsCir->get_codigos_secciones($pensum,$nivel,$grado,$seccion);
				///--
				$codigosPostit.= ($codPostit != "")?$codPostit.",":"";
				$codigosInfo.= ($codInfo != "")?$codInfo.",":"";
				$codigosCircular.= ($codCircular != "")?$codCircular.",":"";
			}
		}
		$result = $ClsAsi->get_maestro_grupo("",$maestro,1);
		if(is_array($result)){
		   $grupos = "";
		   foreach($result as $row){
				$grupos = $row["gru_codigo"];
				//--
				$codInfo = $ClsInfo->get_codigos_grupos($grupos);
				$codCircular = $ClsCir->get_codigos_grupos($grupos);
				//--
				$codigosInfo.= ($codInfo != "")?$codInfo.",":"";
				$codigosCircular.= ($codCircular != "")?$codCircular.",":"";
		   }
		}
		$codigosPostit = substr($codigosPostit, 0, -1);
		$codigosInfo = substr($codigosInfo, 0, -1);
		$codigosCircular = substr($codigosCircular, 0, -1);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$pensum = $ClsPen->get_pensum_activo();
		$director = $tipo_codigo;
		$codigosPostit = '';
		$codigosInfo = '';
		$codigosCircular = '';
		$result = $ClsAcad->get_grado_otros_usuarios($pensum,'','',$director);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				///--
				$codPostit = $ClsPost->get_postit_codigos('',$pensum,$nivel,$grado,'','','','','','',1);
				$codInfo = $ClsInfo->get_codigos_secciones($pensum,$nivel,$grado,'');
				$codCircular = $ClsCir->get_codigos_secciones($pensum,$nivel,$grado,'');
				///--
				$codigosPostit.= ($codPostit != "")?$codPostit.",":"";
				$codigosInfo.= ($codInfo != "")?$codInfo.",":"";
				$codigosCircular.= ($codCircular != "")?$codCircular.",":"";
			}
		}
		$result = $ClsAsi->get_usuario_grupo("",$director,1);
		if(is_array($result)){
		   $grupos = "";
		   foreach($result as $row){
				$grupos = $row["gru_codigo"];
				//--
				$codInfo = $ClsInfo->get_codigos_grupos($grupos);
				$codCircular = $ClsCir->get_codigos_grupos($grupos);
				//--
				$codigosInfo.= ($codInfo != "")?$codInfo.",":"";
				$codigosCircular.= ($codCircular != "")?$codCircular.",":"";
		   }
		}
		$codigosPostit = substr($codigosPostit, 0, -1);
		$codigosInfo = substr($codigosInfo, 0, -1);
		$codigosCircular = substr($codigosCircular, 0, -1);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsPen->get_grado($pensum,'','',1);
		$codigosPostit = '';
		$codigosInfo = '';
		$codigosCircular = '';
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				///--
				$codPostit = $ClsPost->get_postit_codigos('',$pensum,$nivel,$grado,'','','','','','',1);
				$codInfo = $ClsInfo->get_codigos_secciones($pensum,$nivel,$grado,'');
				$codCircular = $ClsCir->get_codigos_secciones($pensum,$nivel,$grado,'');
				///--
				$codigosPostit.= ($codPostit != "")?$codPostit.",":"";
				$codigosInfo.= ($codInfo != "")?$codInfo.",":"";
				$codigosCircular.= ($codCircular != "")?$codCircular.",":"";
			}
		}
		$result = $ClsGruCla->get_grupo_clase('','','','',1);
		if(is_array($result)){
		   $grupos = "";
		   foreach($result as $row){
				$grupos = $row["gru_codigo"];
				//--
				$codInfo = $ClsInfo->get_codigos_grupos($grupos);
				$codCircular = $ClsCir->get_codigos_grupos($grupos);
				//--
				$codigosInfo.= ($codInfo != "")?$codInfo.",":"";
				$codigosCircular.= ($codCircular != "")?$codCircular.",":"";
		   }
		}
		$codigosPostit = substr($codigosPostit, 0, -1);
		$codigosInfo = substr($codigosInfo, 0, -1);
		$codigosCircular = substr($codigosCircular, 0, -1);
	}else{
		$valida == "";
	}

	$ClsIns = new ClsInscripcion();
	$InscripcionesActivas = $ClsIns->activo;

	///////////////////////////// MODULOS //////////////////////////////
	$modulos = 0;
	if($_SESSION["MOD_academico"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_academico2"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_horarios"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_comunicacion"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_administraativo"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_cuenta"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_conta"] == 1){
		$modulos++;
	}
	if($modulos > 4){
		$cols_divs = "col-lg-4 col-xs-12";
	}else{
		$cols_divs = "col-lg-6 col-xs-12";
	}

if($tipo_usuario != "" && $nombre != ""){
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
		<link rel="shortcut icon" href="../CONFIG/images/logo.png">
		<?php
			//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
			$xajax->printJavascript("");
		?>
		<!-- CSS personalizado -->
		<link href="assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- Estilos Utilitarios -->
		<link href="assets.3.6.2/css/menu.css" rel="stylesheet">

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
		<!-- DataTables CSS -->
    	<link href="assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

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
					<a class="navbar-brand"><img src = "../CONFIG/images/logo_white.png" width = "30px"></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<?php if($_SESSION["GRP_GPADMIN"] == 1){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span> Sistema <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							<?php if($_SESSION["GUSU"] == 1){ ?>
								<li><a href="CPUSUARIOS/FRMusuarios.php"><span class="glyphicon glyphicon-user"></span> Usuarios</a></li>
							<?php } ?>
							<?php if($_SESSION["GUSU"] == 1){ ?>
								<li><a href="CPUSUARIOS/FRMsecciones.php"><span class="fa fa-group"></span> Usuarios de Alumnos</a></li>
							<?php } ?>
							<?php if($_SESSION["GPERM"] == 1){ ?>
								<li><a href="CPPERMISOS/FRMpermiso.php"><span class="glyphicon glyphicon-link"></span> Administraci&oacute;n de Accesos y Permisos</a></li>
							<?php } ?>
							<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li><a href="CPREGLAS/FRMconfig.php"><span class="glyphicon glyphicon-cog"></span> Configuraci&oacute;n Inicial</a></li>
							<?php } ?>
							<?php if($_SESSION["BITSEG"] == 1){ ?>
								<li><a href="CPBITACORA/FRMbitacora.php"><span class="glyphicon glyphicon-list-alt"></span> Bit&aacute;cora del Sistema</a></li>
							<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-home"></span> Inicio <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="CPPERFIL/FRMperfil.php"><span class="glyphicon glyphicon-user"></span> Mi Perfil</a></li>
								<li><a href="CPHELPDESK/FRMtablero.php"><span class="fa fa-exclamation-circle"></span> Incidentes (Help Desk)</a></li>
							</ul>
						</li>
						<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-gears"></span> Gesti&oacute;n T&eacute;cnica <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPGRUPOS/FRMgrupos.php"><span class="fa fa-book"></span> Gestor de Grupos, Segmentos y &Aacute;reas</a></li>
							<?php } ?>
							<hr>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPOTROUSU/FRMotrousu.php"><span class="fa fa-group"></span> Gestor de Directores y Autoridades</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPOTROUSU/FRMlistotrousu.php"><span class="fa fa-link"></span> Asignaci&oacute;n de Directores y Autoridades a Grupos</a></li>
							<?php } ?>
							<hr>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPMAESTRO/FRMmaestro.php"><span class="fa fa-mortar-board"></span> Gestor de Maestros</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPMAESTRO/FRMlistmaestro.php"><span class="fa fa-link"></span> Asignaci&oacute;n de Maestros a Grupos, Materias, Grados y Secciones</a></li>
							<?php } ?>
							<!--hr-->
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<!--li><a href="CPMONITOR/FRMmonitor.php"><span class="fa fa-mortar-board"></span> Gestor de Monitores</a></li-->
							<?php } ?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<!--li><a href="CPMONITOR/FRMlistmonitor.php"><span class="fa fa-link"></span> Asignaci&oacute;n de Monitores a Grupos</a></li-->
							<?php } ?>
							<hr>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPAULA/FRMaula.php"><span class="fa fa-university"></span> Gestor de Aulas e Instalaciones</a></li>
							<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-users"></span> Alumnos <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/FRMnewalumno.php"><span class="fa fa-plus-circle"></span> Agregar Alumnos</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/FRMsecciones.php?acc=1"><span class="fa fa-edit"></span> Actualizar Datos de Alumnos</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/FRMsecciones.php?acc=4"><span class="fa fa-list-alt"></span> Visualizar Ficha T&eacute;cnica del Alumnos</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPFICHAPRESCOOL/FRMsecciones.php"><span class="fa fa-file-text-o"></span> Visualizar Ficha Preescolar</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/FRMsecciones.php?acc=5"><span class="fa fa-comments"></span> Bit&aacute;cora Psicopedag&oacute;gica</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/FRMsecciones.php?acc=3"><i class="fa fa-camera"></i> Re-Ingreso de Fotograf&iacute;as (Alumno)</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/FRMsecciones.php?acc=6"><i class="fa fa-ban"></i> Inhabilitaci&oacute;n de Alumnos</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/FRMsecciones.php?acc=7"><i class="fa fa-check-circle-o"></i> Re-Activaci&oacute;n Alumnos</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/CPREPORTES/FRMreplistado.php"><i class="glyphicon glyphicon-print"></i> Reporte de Alumnos</a></li>
							<?php } ?>
							<hr>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPALUMNOS/FRMsecciones.php?acc=2"><span class="fa fa-group"></span> Asignaci&oacute;n de Alumnos a Grupos (Actividades Extracurriculares)</a></li>
							<?php } ?>
							<hr>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPPADRES/FRMnewpadre.php"><i class="fa fa-user"></i> Gestor de Padres</a></li>
							<?php } ?>
							<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li><a href="CPPADRES/FRMpadre.php"><span class="fa fa-list-alt"></span> Ficha de Padres</a></li>
							<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if($_SESSION["MOD_asistencia"] == 1){ ?>
							<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-check-square-o"></span> Asistencia <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIA/FRMperiodos.php"><span class="fa fa-check"></span> Tomar Asistencia Acad&eacute;mica</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIA/FRMlist_seccion.php"><span class="fa fa-search"></span> Revisar Asistencia Acad&eacute;mica por Grado/Secci&oacute;n</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIA/FRMlista_alumnos.php"><span class="fa fa-search"></span> Revisar Asistencia Acad&eacute;mica por Alumno</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIA/FRMlist_maestros.php"><span class="fa fa-search"></span> Revisar Asistencia Acad&eacute;mica por Maestro</a></li>
									<?php } ?>
									<hr>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIACURSOS/FRMperiodos.php"><span class="fa fa-check"></span> Tomar Asistencia de Cursos Libres</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIACURSOS/FRMlist_cursos.php"><span class="fa fa-search"></span> Revisar Asistencia de Cursos Libres por Curso Libre</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIACURSOS/FRMlista_alumnos.php"><span class="fa fa-search"></span> Revisar Asistencia de Cursos Libres por Alumno</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIACURSOS/FRMlist_maestros.php"><span class="fa fa-search"></span> Revisar Asistencia de Cursos Libres por Maestro</a></li>
									<?php } ?>
									<br>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIACURSOS/FRMlist_cursos_confirmacion.php"><span class="fa fa-check-square-o"></span> Confirmaci&oacute;n de Asistencia (por Alumno)</a></li>
									<?php } ?>
									<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
									<li><a href="CPASISTENCIA/CPREPORTES/FRMrepasistencia.php"><span class="fa fa-print"></span> Reporte de Asitencia por materia</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>

						<?php if($_SESSION["MOD_inscripciones"] == 1){ ?>
							<?php if($_SESSION["GRP_INSCRIP"] == 1){ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									<span class="fa fa-edit"></span> Inscripciones <span class="caret"></span>
									<?php if($InscripcionesActivas == 1){
										echo '<span class="count"><i class="fa fa-info"></i></span>';
									} ?>
								</a>
								<ul class="dropdown-menu" role="menu">
									<?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/FRMimpresion_boletas.php"><span class="fa fa-print"></span> Re-Impresi&oacute;n de Boletas de Inscripci&oacute;n</a></li>
									<?php } ?>
									<?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/FRMboletas.php"><span class="fa fa-money"></span> Recepci&oacute;n de Boletas de Inscripci&oacute;n Pagadas</a></li>
									<?php } ?>
									<?php if($_SESSION["APROVCON"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/FRMaprobacion.php"><span class="fa fa-check-square-o"></span> Aprobaci&oacute;n de Pre-Contratos</a></li>
									<?php } ?>
									<?php if($_SESSION["RECEPCON"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/FRMrecepcion.php"><span class="fa fa-inbox"></span> Recepci&oacute;n de Contratos</a></li>
									<?php } ?>
									<?php if($_SESSION["RECEPCON"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/FRMinscripcion.php"><span class="fa fa-certificate"></span> Inscripci&oacute;n al Pr&oacute;ximo Ciclo</a></li>
									<?php } ?>
									<?php if($_SESSION["REPINSCRP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/FRMblacklist.php"><span class="fa fa-ban"></span> Lista Reservada de Inscripci&oacute;n</a></li>
									<?php } ?>
									<hr>
									<?php if($_SESSION["REPINSCRP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMdatos_actualizados.php"><span class="glyphicon glyphicon-print"></span> Reporte de Datos Actualizados</a></li>
									<?php } ?>
									<?php if($_SESSION["REPINSCRP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMcorrecciones.php"><span class="glyphicon glyphicon-print"></span> Reporte de Contratos en Correcciones</a></li>
									<?php } ?>
									<?php if($_SESSION["REPINSCRP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMboletas_giradas.php"><span class="glyphicon glyphicon-print"></span> Reporte de Boletas en Circulaci&oacute;n</a></li>
									<?php } ?>
									<?php if($_SESSION["REPINSCRP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMboletas_aprobadas.php"><span class="glyphicon glyphicon-print"></span> Reporte de Boletas Pagadas</a></li>
									<?php } ?>
									<?php if($_SESSION["REPINSCRP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMcontratos_aprobados.php"><span class="glyphicon glyphicon-print"></span> Reporte de Contratos Aprobados</a></li>
									<?php } ?>
									<?php if($_SESSION["REPINSCRP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMreplistado.php"><span class="glyphicon glyphicon-print"></span> Reporte General de Contratos</a></li>
									<?php } ?>
									<?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMcargos.php"><i class="fa fa-plus"></i> <i class="fa fa-dollar"></i> Reporte de Cargos</a></li>
									<?php } ?>
									<?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMdescuentos.php"><i class="fa fa-minus"></i> <i class="fa fa-dollar"></i> Reporte de Descuentos</a></li>
									<?php } ?>
									<?php if($_SESSION["BOLINSCRIP"] == 1){ ?> 
									<li><a href="CPINSCRIPCIONES/CPREPORTES/FRMingresos.php"><i class="fa fa-dollar"></i> <i class="fa fa-dollar"></i> Reporte de Ingresos</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						<?php } ?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right" style="font-size: 14px;">
					<?php if($tipo_usuario == 1 || $tipo_usuario == 5 || $tipo_usuario == 2){ ?>	
						<?php if($_SESSION["MOD_mineduc"] == 1){ ?>
							<li><a href="CPSOLICITUD_MINEDUC/FRMmineduc.php"> <span class="fa fa-book"></span> Educaci&oacute;n Virtual a Distancia</a></li>
						<?php } ?>
					<?php } ?>
					</ul>
				</div>

				<!--/.nav-collapse -->
			</div>
			<!--/.container-fluid -->
		</nav>
		<!-- Main component for a primary marketing message or call to action -->

		<div id = "contenedor" class="jumbotron">
			<!-- .row 1 -->
			<div class="row">
				<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico3"] == 1){ ?>
					<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="CPMENU/MENUacademico.php">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-mortar-board fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo Acad&eacute;mico</div>
										</div>
									</div>
								</div>
								<a href="CPMENU/MENUacademico.php">
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo Acad&eacute;mico</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</a>
					</div>
					<?php }else{ ?>
					<div class="<?php echo $cols_divs; ?>">
						<span title = "No tiene acceso a este M&oacute;odulo">
							<div class="panel panel-mutted">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-mortar-board fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo Acad&eacute;mico</div>
										</div>
									</div>
								</div>
								<span>
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo Acad&eacute;mico</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-mutted"></i></span>
										<div class="clearfix"></div>
									</div>
								</span>
							</div>
						</span>
					</div>
					<?php } ?>
				<?php } ?>


				<?php if($_SESSION["MOD_academico2"] == 1){ ?>
					<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="CPMENU/MENUacademico.php">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-tasks fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>Esquema Curricular</div>
										</div>
									</div>
								</div>
								<a href="CPMENU/MENUacademico2.php">
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al Esquema Curricular</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</a>
					</div>
					<?php }else{ ?>
					<div class="<?php echo $cols_divs; ?>">
						<span title = "No tiene acceso a este M&oacute;odulo">
							<div class="panel panel-mutted">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-tasks fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>Esquema Curricular</div>
										</div>
									</div>
								</div>
								<span>
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al Esquma Curricular</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-mutted"></i></span>
										<div class="clearfix"></div>
									</div>
								</span>
							</div>
						</span>
					</div>
					<?php } ?>
				<?php } ?>
				

				<?php if($_SESSION["MOD_horarios"] == 1){ ?>
					<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="CPMENU/MENUhorario.php">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-calendar fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo de Control de Horarios</div>
										</div>
									</div>
								</div>
								<a href="CPMENU/MENUhorario.php">
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo de Horarios</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</a>
					</div>
					<?php }else{ ?>
					<div class="<?php echo $cols_divs; ?>">
						<span title = "No tiene acceso a este M&oacute;odulo">
							<div class="panel panel-mutted">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-calendar fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo de Control de Horarios</div>
										</div>
									</div>
								</div>
								<span>
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo de Horarios</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-mutted"></i></span>
										<div class="clearfix"></div>
									</div>
								</span>
							</div>
						</span>
					</div>
					<?php } ?>
				<?php } ?>

				<?php if($_SESSION["MOD_comunicacion"] == 1){ ?>
					<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="CPMENU/MENUcomunicacion.php">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-comments fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo de Comunicaci&oacute;n</div>
										</div>
									</div>
								</div>
								<a href="CPMENU/MENUcomunicacion.php">
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo de Comunicaci&oacute;n</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</a>
					</div>
					<?php }else{ ?>
					<div class="<?php echo $cols_divs; ?>">
						<span title = "No tiene acceso a este M&oacute;odulo">
							<div class="panel panel-mutted">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-comments fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo de Comunicaci&oacute;n</div>
										</div>
									</div>
								</div>
								<span>
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo de Comunicaci&oacute;n</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-mutted"></i></span>
										<div class="clearfix"></div>
									</div>
								</span>
							</div>
						</span>
					</div>
					<?php } ?>
				<?php } ?>

				<?php if($_SESSION["MOD_administraativo"] == 1){ ?>
					<?php if($_SESSION["GRP_GPADMON"] == 1){ ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="CPMENU/MENUadministrativo.php">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-building fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo Administrativo</div>
										</div>
									</div>
								</div>
								<a href="CPMENU/MENUadministrativo.php">
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo Administrativo</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</a>
					</div>
					<?php }else{ ?>
					<div class="<?php echo $cols_divs; ?>">
						<span title = "No tiene acceso a este M&oacute;odulo">
							<div class="panel panel-mutted">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-building fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo Administrativo</div>
										</div>
									</div>
								</div>
								<span>
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo Administrativo</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-mutted"></i></span>
										<div class="clearfix"></div>
									</div>
								</span>
							</div>
						</span>
					</div>
					<?php } ?>
				<?php } ?>

				<?php if($_SESSION["MOD_cuenta"] == 1){ ?>
					<?php if($_SESSION["GRP_GPCONTA"] == 1){ ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="CPMENU/MENUcuenta.php">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-money fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>Cuenta Corriente</div>
										</div>
									</div>
								</div>
								<a href="CPMENU/MENUcuenta.php">
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al Cuenta Corriente</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</a>
					</div>
					<?php }else{ ?>
					<div class="<?php echo $cols_divs; ?>">
						<span title = "No tiene acceso a este M&oacute;odulo">
							<div class="panel panel-mutted">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-money fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>Cuenta Corriente</div>
										</div>
									</div>
								</div>
								<span>
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al Cuenta Corriente</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-mutted"></i></span>
										<div class="clearfix"></div>
									</div>
								</span>
							</div>
						</span>
					</div>
					<?php } ?>
				<?php } ?>

				<?php if($_SESSION["MOD_conta"] == 1){ ?>
					<?php if($_SESSION["GRP_GPCONTA"] == 1){ ?>
					<div class="<?php echo $cols_divs; ?>">
						<a href="CPMENU/MENUcontable.php">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-bank fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo Contable-Financiero</div>
										</div>
									</div>
								</div>
								<a href="CPMENU/MENUcontable.php">
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo Contable</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</a>
					</div>
					<?php }else{ ?>
					<div class="<?php echo $cols_divs; ?>">
						<span title = "No tiene acceso a este M&oacute;odulo">
							<div class="panel panel-mutted">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-bank fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge"></div>
											<div>M&oacute;dulo Contable-Financiero</div>
										</div>
									</div>
								</div>
								<span>
									<div class="panel-footer">
										<span class="pull-left text-info">Ir al M&oacute;dulo Contable</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right text-mutted"></i></span>
										<div class="clearfix"></div>
									</div>
								</span>
							</div>
						</span>
					</div>
					<?php } ?>
				<?php } ?>
			</div>
			<!-- /.row 2 -->

			<!-- .row -->
			<?php if( $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
			<div class="row">
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<i class="fa fa-calendar fa-fw"></i> Tablero de Informaci&oacute;n
							<div class="pull-right" style= "margin-left:5px;">
								<div class="btn-group">
									<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
										Acciones
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu pull-right" role="menu">
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPINFO/FRMnewinfo.php"><span class="fa fa-plus-circle"></span> Nueva Actividad</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPINFO/FRMmodinfo.php"><span class="fa fa-edit"></span> Actualizar Actividades</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPINFO/FRMconfirmacion.php"><i class="fa fa-info-circle"></i> Confirmaci&oacute;n de Lectura</a></li>
										<?php } ?>
										<li><a href="CPINFO/IFRMinformacion.php"><i class="fa fa-arrows-alt text-info"></i> Vista Completa</a></li>
										<li><a href="javascript:void(0)" onclick = "OcultarFrame('iftable');"><i class="fa fa-eye-slash text-danger"></i> Ocultar Tablero</a></li>
										<li><a href="javascript:void(0)" onclick = "VisualizarFrame('iftable');"><i class="fa  fa-eye text-success"></i> Visualizar Tablero</a></li>
									</ul>
								</div>
							</div>
						</div>
					 <!-- /.panel-heading -->
					<div class="panel-body">
						<div id = "iftable" class = "info">
							<div class="table-responsive">
								<table class="table table-hover">
								<?php
									//////////////////////////////////////// GENERAL ///////////////////////////////////////////
									$result = $ClsInfo->get_informacion($codigosInfo);
									if(is_array($result)){
										$codigoX = "";
										foreach($result as $row){
											$codigo = $row["inf_codigo"];
											if($codigo != $codigoX){
												$codigoX = $codigo;
												$usu = $_SESSION["codigo"];
												$hashkey = $ClsInfo->encrypt($codigo, $usu);
												$nombre = utf8_decode($row["inf_nombre"]);
												$tlink = trim($row["inf_link"]);
												$link = ($tlink == "#")?"javascript:void(0);":$tlink;
												$target = ($tlink == "#")?"":"_blank";
												$desc = utf8_decode($row["inf_descripcion"]);
												$desc = nl2br($desc);
												$fini = trim($row["inf_fecha_inicio"]);
												$ffin = trim($row["inf_fecha_fin"]);
												//--
												$fechaini = explode(" ",$fini);
												$fecini = $fechaini[0];
												$fecini = str_replace("-","",$fecini);
												$horaini = substr($fechaini[1], 0, -3);
												//--
												$fechafin = explode(" ",$ffin);
												$fecfin= $fechafin[0];
												$fecfin = str_replace("-","",$fecfin);
												$horafin = substr($fechafin[1], 0, -3);
												///---
												$salida.='<tr>';
													$salida.='<td class = "text-justify">';
													$salida.='<a href="'.$link.'" target = "'.$target.'" class="atablero">';
														$salida.='<h6>'.$nombre.'</h6>';
															$salida.='<span class="text-muted small text-justify"><em>'.$desc.'</em></span>';
														$salida.='</a>';
													$salida.='</td>';
													$salida.='<td>';
														$salida.='<a href="CPINFO/ICSinformacion.php?codigo='.$codigo.'" target = "_blank" class="btn btn-default">';
															$salida.='<i class="fa fa-calendar"></i>';
														$salida.='</a> ';
														$salida.='<a href="CPINFO/FRMdetalle.php?codigo='.$codigo.'" target = "_blank" class="btn btn-default">';
															$salida.='<i class="fa fa-search-plus"></i>';
														$salida.='</a>';
													$salida.='</td>';
												$salida.='</tr>';
												///---
											}
										}
									}
								?>
								<?php echo $salida; ?>

								</table>
							</div>
						</div>
					</div>
					<!-- /.panel-body -->
					</div>
				</div>
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<i class="fa fa-file-pdf-o fa-fw"></i> Tablero de Circulares
							<div class="pull-right" style= "margin-left:5px;">
								<div class="btn-group">
									<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
										Acciones
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu pull-right" role="menu">
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPCIRCULAR/FRMnewcircular.php"><i class="fa fa-plus-circle"></i> Nueva Circular</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPCIRCULAR/FRMmodcircular.php"><i class="fa fa-edit"></i> Actualizaci&oacute;n de Circulares</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPCIRCULAR/FRMautorizacion.php"><i class="fa fa-check-square-o"></i> Revisar Autorizaciones</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPCIRCULAR/FRMconfirmacion.php"><i class="fa fa-info-circle"></i> Confirmaci&oacute;n de Lectura</a></li>
										<?php } ?>
										<li><a href="javascript:void(0)" onclick = "OcultarFrame('ifchart');"><i class="fa fa-eye-slash text-danger"></i> Ocultar Calendario</a></li>
										<li><a href="javascript:void(0)" onclick = "VisualizarFrame('ifchart');"><i class="fa  fa-eye text-success"></i> Visualizar Calendario</a></li>
									</ul>
								</div>
							</div>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div id = "ifchart" class = "tareas">
								<div class="table-responsive">
									<table class="table table-hover">
									<?php
									$salida = "";
									if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){
										$result = $ClsCir->get_circular($codigosCircular);
										if(is_array($result)){
											$codigoX = '';
											foreach($result as $row){
												$codigo = $row["cir_codigo"];
												if($codigo != $codigoX){
													$codigoX = $codigo;
													//titulo
													$titulo = trim(utf8_decode($row["cir_titulo"]));
													//desc
													$desc = trim(utf8_decode($row["cir_descripcion"]));
													$desc = nl2br($desc);
													//fecha inicia
													$publicacion = trim($row["cir_fecha_publicacion"]);
													$publicacion = cambia_fechaHora($publicacion);
													//documento
													$documento = trim($row["cir_documento"]);
													//--
													$salida.='<tr>';
														$salida.='<td class = "text-justify">';
														$salida.='<a href="../CONFIG/Circulares/'.$documento.'" target = "_blank" class="atablero">';
															$salida.='<h6>'.$titulo.'</h6>';
															$salida.='<span class="text-muted small text-justify"><em>'.$desc.'</em></span>';
														$salida.='</a>';
														$salida.='</td>';
														$salida.='<td class="text-right">';
															$salida.='<small class="text-info">'.$fecha.'</small> ';
															$salida.='<a href="../CONFIG/Circulares/'.$documento.'" target = "_blank" class="btn btn-default">';
																$salida.='<i class="fa fa-search-plus"></i>';
															$salida.='</a>';
														$salida.='</td>';
													$salida.='</tr>';
													//--
												}
											}
										}
									}
									?>
									<?php echo $salida; ?>
									</table>
								</div>
							</div>
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<i class="fa fa-paste fa-fw"></i> Tablero de Notificaciones (Pin Board)
							<div class="pull-right" style= "margin-left:5px;">
								<div class="btn-group">
									<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
										Acciones
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu pull-right" role="menu">
										<?php if($tipo_usuario == 2 || $tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPPOSTIT/FRMpostit.php"><span class="fa fa-edit"></span> Crear Notas (Pin Board)</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 3 || $tipo_usuario == 5){ ?>
										<li><a href="CPPOSTIT/FRMpinboard.php" target = "_blank"><i class="fa fa-arrows-alt text-info"></i> Vista Completa</a></li>
										<?php } ?>
										<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li><a href="CPPOSTIT/FRMconfirmacion.php"><i class="fa fa-info-circle"></i> Confirmaci&oacute;n de Lectura</a></li>
										<?php } ?>
										<li><a href="javascript:void(0)" onclick = "OcultarFrame('ifnotes');"><i class="fa fa-eye-slash text-danger"></i> Ocultar Calendario</a></li>
										<li><a href="javascript:void(0)" onclick = "VisualizarFrame('ifnotes');"><i class="fa  fa-eye text-success"></i> Visualizar Calendario</a></li>
									</ul>
								</div>
							</div>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div id = "ifnotes" class = "tareas">
								<div class="table-responsive">
									<table class="table table-hover">
									<?php
									$salida = "";
									if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){
										$result = $ClsPost->get_postits_dashboard($codigosPostit);
										if(is_array($result)){
											foreach($result as $row){
												$codigo = $row["post_codigo"];
												$usu = $_SESSION["codigo"];
												$hashkey = $ClsInfo->encrypt($codigo, $usu);
												$nombre = utf8_decode($row["post_titulo"]);
												$desc = utf8_decode($row["post_descripcion"]);
												$desc = nl2br($desc);
												//--
												$maestra = utf8_decode($row["post_maestro_nombre"]);
												$maestra = ($maestra == "")?"Usuario Administrativo":$maestra;
												$target_nombre = utf8_decode($row["post_target_nombre"]);
												$target = ($target != "")?$target_nombre:"Todos";
												$grado_seccion = utf8_decode($row["post_grado_desc"])." ".utf8_decode($row["post_seccion_desc"]);
												//--
												$salida.='<tr>';
													$salida.='<td class = "text-justify">';
													$salida.='<a href="javascript:void(0);" class="atablero">';
														$salida.='<h6>'.$nombre.'</h6>';
														$salida.='<span class="text-muted small text-justify"><em>'.$desc.'</em></span><br>';
														$salida.='<strong class="text-dark pull-right">'.$maestra.'</strong><br>';
														$salida.='<span class="text-muted pull-right">'.$target.'</span><br>';
														$salida.='<span class="text-muted pull-right">'.$grado_seccion.'</span>';
													$salida.='</a>';
													$salida.='</td>';
												$salida.='</tr>';
												//--
											}
										}
									}
									?>

									<?php echo $salida; ?>
									</table>
								</div>
							</div>
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
			</div> <!-- /row -->
			<?php } ?>
			 <?php if($tipo_usuario == 2 ){ ?>
			<div class="row">
				<div class="col-lg-12 col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<i class="fa fa-calendar fa-fw"></i> Pendientes de Calificar
						</div>
					 <!-- /.panel-heading -->
					<div class="panel-body">
						<div id = "pentable" class = "info">
							<div class="table-responsive">
								<?php
								$ClsAcadem = new ClsAcademico();
								if($tipo_usuario == 2){ //// MAESTRO
									$result_materias = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,'',$tipo_codigo);
								}else if($tipo_usuario == 1){ //// DIRECTORA
									$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado);
								}else if($tipo_usuario == 5){ /// ADMINISTRADOR
									$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado);
								}
									$salida2.= '<div class="panel-body">';
                                    $salida2.= '<div class="dataTable_wrapper">';
										$salida2.= '<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">';
										$salida2.= '<thead>';
										$salida2.= '<tr>';
										$salida2.= '<th width = "10px" class = "text-center">No.</td>';
										$salida2.= '<th width = "50px" class = "text-center">CUI</td>';
										$salida2.= '<th width = "170px" class = "text-center">ALUMNO</td>';
										$salida2.= '<th width = "50px" class = "text-center">TIPO</td>';
										$salida2.= '<th width = "10px" class = "text-center"><span class="fa fa-pencil"></span></td>';
										$salida2.= '<th width = "10px" class = "text-center">Descripcion.</td>';
										$salida2.= '</tr>';
										$salida2.= '</thead>';
								
								if(is_array($result_materias)){
								    foreach($result_materias as $row){
										if($tipo_usuario == 2){ //// MAESTRO - DIRECTORA
											$materia = $row["secmat_materia"];
										}else if($tipo_usuario == 1){ ///DERECTOR
											$materia = $row["mat_codigo"];
										}else if($tipo_usuario == 5){ //ADMINISTRADOR
											$materia = $row["mat_codigo"];
										}
										
									$ClsTar = new ClsTarea();
									$ClsExa = new ClsExamen();	
									$examenesarr = $ClsExa->get_examen('',$pensum,$nivel,$grado,$seccion,$materia);	
									$tareasarr = $ClsTar->get_tarea('',$pensum,$nivel,$grado,$seccion,$materia);
									$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
									//////////////////////////////////////// GENERAL ///////////////////////////////////////////
                                    if(is_array($tareasarr)){
										foreach($tareasarr as $row){
											$codigo = $row["tar_codigo"];
											$usu = $_SESSION["codigo"];
											$hashkey = $ClsTar->encrypt($cod, $usu);
											$nombre = utf8_decode($row["tar_nombre"]);
											$tlink = trim($row["tar_link"]);
											$link = ($tlink == "")?"javascript:void(0);":$tlink;
											$target = ($tlink == "")?"":"_blank";
											$desc = utf8_decode($row["tar_descripcion"]);
											$fecha = trim($row["tar_fecha_entrega"]);
											$fecha = cambia_fechaHora($fecha);
											$fecha = substr($fecha, 0, -3);
											$pendientes = trim($row["tar_pendientes"]);
											$entregadas = trim($row["tar_entregadas"]);
											$calificadas = trim($row["tar_calificadas"]);
											$fecha = strtotime($row["tar_fecha_entrega"]);
                                			$hashkey = $ClsTar->encrypt($codigo, $usu);
											//--
										    //--
										    if($fecha_actual >= $fecha && intval($pendientes) > 0 ){
    										$salida.=' <div class="col-xs-12">';
    										$salida.='<hr>';
    												$salida.='<a href="CPTAREAS/FRMcalificartarea.php?hashkey='.$hashkey.'" target = "'.$target.'" class="">';
    													$salida.='<h6>'.$nombre.'</h6>';
    												$salida.='</a>';
    												$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
    												$salida.='<div "class="pull-right">';
    													$salida.='<small class = "text-info">Total Entregadas: '.$entregadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total Calificadas: '.$calificadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total sin Calificar: '.$pendientes.'</small> &nbsp; ';
    														$salida.='<div class="pull-right">';
    													$salida.= '<a class="btn btn-primary" href="CPTAREAS/FRMcalificartarea.php?hashkey='.$hashkey.'" title = "Calificar Tarea" ><span class="fa fa-paste"></span> Calificar Tarea</a> ';
    												$salida.='</div>';
    												$salida.='</div>';
    											
    										$salida.='</div>';
    										
    										}
										}
									}
									if(is_array($examenesarr)){
									foreach($examenesarr as $row){
										$cod = $row["exa_codigo"];
										$usu = $_SESSION["codigo"];
										$hashkey = $ClsExa->encrypt($cod, $usu);
										$titulo = utf8_decode($row["exa_titulo"]);
										$unidad = utf8_decode($row["exa_unidad"])." Unidad";
										$desc = utf8_decode($row["exa_descripcion"]);
										$feclimit = trim($row["exa_fecha_limite"]);
										$feclimit = cambia_fechaHora($feclimit);
										$pendientes = trim($row["exa_pendientes"]);
										$entregadas = trim($row["exa_entregadas"]);
										$calificadas = trim($row["exa_calificadas"]);
										$fecha = strtotime($row["exa_fecha_limite"]);
										$hashkey = $ClsExa->encrypt($cod, $usu);
										//-
											//--
										if($fecha_actual >= $fecha && intval($pendientes) > 0 ){	
										$salida.=' <div class="col-xs-12">';
										$salida.='<hr>';
											$salida.='<a  href="CPEXAMEN/FRMcalificarexamen.php?hashkey='.$hashkey.'" target = "'.$curso.'" class="">';
											$salida.='<h5>'.$titulo.' <label>('.$unidad.')</label></h5>';
											$salida.='</a>';
											$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
											$salida.='<div "class="pull-right">';
    											$salida.='<small class = "text-info">Total Entregadas: '.$entregadas.'</small> &nbsp; ';
    											$salida.='<small class = "text-info">Total Calificadas: '.$calificadas.'</small> &nbsp; ';
    											$salida.='<small class = "text-info">Total sin Calificar: '.$pendientes.'</small> &nbsp; ';
    											$salida.='<div class="pull-right">';
												$salida.= '<a class="btn btn-primary" href="CPEXAMEN/FRMcalificarexamen.php?hashkey='.$hashkey.'" title = "Calificar Tarea" ><span class="fa fa-paste"></span> Calificar Evaluacion</a> '; 
											$salida.='</div>';
    										$salida.='</div>';
										$salida.='</div>';
										//--
									}
									}	
								}
									}
									//echo $tareas;
									
                                		$salida2.= '</table>';
									
								
							    }	
									echo $salida
								?>	
	
							
							</div>
						</div>
					</div>
					<!-- /.panel-body -->
					</div>
				</div>
			</div>
			<?php } ?>
		</div>

		<br>
		<div class="row text-center">
			<small class='text-primary'>
				Powered by ID Web Development Team.
				Copyright &copy; <?php echo date("Y"); ?>
			</small>
			<br>
			<small class='text-primary'>
				Versi&oacute;n 3.6.2
			</small>
		</div>
	</div>
	<!-- /container -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="assets.3.6.2/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="assets.3.6.2/js/menu.js"></script>
    <script type="text/javascript" src="assets.3.6.2/js/core/util.js"></script>
    <script type="text/javascript" src="assets.3.6.2/js/modules/academico/tarea.js"></script>


	<!-- Import and configure the Firebase SDK -->
	<!-- These scripts are made available when the app is served or deployed on Firebase Hosting -->
	<!-- If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup -->
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>
	<!--script type="text/javascript" src="assets.3.6.2/js/firebase-init.js"></script -->

  </body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
