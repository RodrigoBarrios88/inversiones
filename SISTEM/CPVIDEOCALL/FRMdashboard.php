<?php
	include_once('xajax_funct_videoclase.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//---
	$desde = date("01/01/Y");
	$hasta = date("31/12/Y");

	///////// FILTROS DE CODIGOS /////////////
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsVid = new ClsVideoclase();
	$codigosVideo = '';
	$codigo = $ClsVid->get_codigos_videoclase_todos();
	$codigosVideo.= ($codigo != "")?$codigo.',':'';
	////////////////
	if($tipo_usuario == 2){ //// MAESTRO
		$result_clases = $ClsVid->get_videoclase('','','','','',$desde,$hasta,$usuario);
		if(is_array($result_clases)){
			foreach($result_clases as $row){
				$codigo = $row["vid_codigo"];
				$codigosVideo.= ($codigo != "")?$codigo.',':'';
			}
		}
		$codigosVideo = substr($codigosVideo, 0, -1);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$pensum = $ClsPen->get_pensum_activo();
		$director = $tipo_codigo;
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$director);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				$codigo = $ClsVid->get_codigos_secciones($pensum,$nivel,$grado,'');
				$codigosVideo.= ($codigo != "")?$codigo.',':'';
			}
		}
		$codigosVideo = substr($codigosVideo, 0, -1);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsPen->get_grado($pensum,'','',1);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				$codigo = $ClsVid->get_codigos_secciones($pensum,$nivel,$grado,'');
				$codigosVideo.= ($codigo != "")?$codigo.',':'';
			}
		}
		$codigosVideo = substr($codigosVideo, 0, -1);
	}else{
		$valida == "";
	}

if($usunivel != "" && $usunombre != ""){
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
	<!-- CSS personalizado -->
	<link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Estilos Utilitarios -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	<link href="../assets.3.6.2/css/plugins/treeview/treeview.css" rel="stylesheet">

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	<link href="../assets.3.6.2/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style>
		.blink {
			animation: blink-animation 0.8s steps(5, start) infinite;
			-webkit-animation: blink-animation 0.8s steps(5, start) infinite;
			color: #228938;
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
   <div id="wrapper">
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					  <span class="sr-only"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
				 </button>
				 <?php echo $_SESSION["rotulos_colegio"]; ?>
			</div>
			<!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario de Perfil de Usuarios</a></li>
						<li class="divider"></li>
						<li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a></li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="glyphicon glyphicon-question-sign fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="#"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Ayuda</a></li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
			</ul>
			<!-- /.navbar-top-links -->

			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMvideoclases.php">
										<i class="fa fa-video-camera"></i> Gestor de Videoclases
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMdashboard.php">
										<i class="fa fa-th-large"></i> Tablero de Videoclases
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMlista.php">
										<i class="fa fa-calendar"></i> Historial de Videoclases
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMconfirmacion.php">
										<i class="fa fa-info-circle"></i> Confirmaci&oacute;n de Lectura
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUcomunicacion.php">
									<i class="fa fa-indent"></i> Men&uacute
									</a>
								</li>
								<li>
									<a href="../menu.php">
										<i class="glyphicon glyphicon-list"></i> Men&uacute; Principal
									</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
					</ul>
				</div>
				<!-- /.sidebar-collapse -->
			</div>
			<!-- /.navbar-static-side -->
      </nav>

      <div id="page-wrapper">
         <br>
         <div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-th-large"></i>
					Dashboard de Videoclases
				</div>
				<div class="panel-body">
				<?php
					$fechaRepetida = '';
					$result = $ClsVid->get_videoclase($codigosVideo,$target,$tipo,$plataforma,$fecha);
					if(is_array($result)){
				?>
					<div class="row">
					<?php
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
								$enlace = "FRMviewer.php?codigo=$codigo";
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
												<i class="fa fa-video-camera fa-5x text-primary"></i>
											</div>
											<div class="col-xs-9 text-right text-primary">
												<h6 class="text-right"><i class="fa fa-bullseye fa-2x blink"></i></h6>
												<h6><?php echo $nombre ?></h6>
												<span>Plataforma: <?php echo $plataforma ?></span><br>
											</div>
										</div>
									</div>
									<a href="<?php echo $enlace ?>" target="_blank" >
										<div class="panel-footer">
											<span class="pull-left text-primary"><?php echo $fini ?></span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</a>
						</div>
						<?php }else if($fecha_actual < $fecha_1){ ?>
						<div class="col-lg-4 col-xs-12">
							<a href="<?php echo $enlace ?>" target="_blank">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-video-camera fa-5x text-primary"></i>
											</div>
											<div class="col-xs-9 text-right text-primary">
												<h6 class="text-right"><i class="fa fa-clock-o fa-2x"></i></h6>
												<h6><?php echo $nombre ?></h6>
												<span>Plataforma: <?php echo $plataforma ?></span><br>
											</div>
										</div>
									</div>
									<a href="<?php echo $enlace ?>" target="_blank" >
										<div class="panel-footer">
											<span class="pull-left text-primary"><?php echo $fini ?></span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</a>
						</div>
						<?php } ?>
					<?php
						}
					?>
					</div>
				<?php
					}
				?>
				</div>
			</div>
			<!-- /.panel-default -->
			<br>
		</div>
		<!-- /#page-wrapper -->
	</div>
   <!-- /#wrapper -->

   <!-- //////////////////////////////////////////////////////// -->
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div id = "ModalDialog" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-left" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
				</div>
				<div class="modal-body text-center" id= "lblparrafo">
					<img src = "../../CONFIG/images/img-loader.gif" width="100px" /><br>
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

 <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>

	<!-- Clock picker -->
    <script src="../assets.3.6.2/js/plugins/clockpicker/clockpicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../assets.3.6.2/dist/js/sb-admin-2.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/videoclase.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
   

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
