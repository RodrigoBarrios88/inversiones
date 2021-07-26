<?php
	include_once('xajax_funct_reglas.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPADMIN"];
	
	
if($valida != "" && $nombre != ""){ 		
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
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- Timeline CSS -->
	<link href="../dist/css/timeline.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
	<link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

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
						<li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Perfil de Usuario</a></li>
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
							<ul class="nav nav-second-level">
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMconfig.php">
										<i class="fa fa-cogs"></i> Configuraci&oacute;n de Colegio
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMreglas.php">
										<i class="fa fa-cog"></i> Configuraci&oacute;n de Reglas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMmoneda.php">
										<i class="fa fa-money"></i> Monedas y Tasa de Cambio
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMseguridad.php">
										<i class="fa fa-lock"></i> Seguridad (Error Ing.)
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMmodulos.php">
										<i class="fa fa-sitemap"></i> M&oacute;dulos del Sistema
									</a>
								</li>
								<?php } ?>
								<hr>
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
			<form name = "f1" id = "f1" method="get">
         <div class="panel panel-default">
            <div class="panel-heading">
					<i class="fa fa-sitemap"></i> M&oacute;dulos del Sistema
				</div>
            <div class="panel-body">
					<div class="row">
						<div class="col-xs-6 text-center" id = "divxasignar">
							<?php
								$ClsReg = new ClsRegla();
								$result = $ClsReg->get_modulos();
								echo lista_multiple_html($result,"modulo","mod_codigo","mod_nombre","Listado de M&oacute;dulos");
							?>
							<script>
								<?php
								if(is_array($result)){
									$i = 1;
									foreach($result as $row){
										$codigo = $row["mod_codigo"];
										$nombre = $row["mod_nombre"];
										$situacion = $row["mod_situacion"];
										if($situacion == 1){
											echo "document.getElementById('modulo$i').checked = true;";
										}else{
											echo "document.getElementById('modulo$i').checked = false;";
										}
										$i++;
									}
								}
								?>
							</script>
						</div>
						<div class="col-xs-6 text-center">
							<h5 class="alert alert-info text-center">
								<i class="fa fa-info-circle"></i><br>
								La habilitaci&oacute;n de los m&oacute;dulos se ver&aacute; reflejada en los portales de Padres, Alumnos y del Colegio...
							</h5>
							<br>
							<button type="button" class="btn btn-default" onclick = "Limpiar()"><span class="glyphicon glyphicon-erase"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" onclick = "modificarModulos();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
            </div>
				<!-- /.panel-body -->
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
					<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
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
    
	<!-- jQuery -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Bootstrap Core JavaScript -->
	<script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
	<script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>
	
	<!-- DataTables JavaScript -->
	<script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/master/config.js"></script>
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