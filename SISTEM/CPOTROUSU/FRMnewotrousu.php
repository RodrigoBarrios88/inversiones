<?php
	include_once('xajax_funct_otrousu.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	$pensum = $_SESSION["pensum"];
	
if($pensum != "" && $nombre != ""){ 	
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
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
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
							 <li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
							 </li>
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
							 <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
										<li>
								 <a href="FRMnewotrousu.php">
									 <i class="fa fa-user"></i> Gestor de Autoridades
								 </a>
										</li>
							 <?php } ?>
							 <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							 <li>
								 <a href="FRMotrousu.php">
									 <i class="fa fa-list-ol"></i> Listar Autoridades
								 </a>
										</li>
							 <?php } ?>
							 <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							 <li>
								 <a href="FRMlistotrousu.php">
									 <i class="fa fa-link"></i> Asignaci&oacute;n de Autoridades
								 </a>
										</li>
							 <?php } ?>
							 <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							 <li>
								 <a href="FRMlist_curso.php">
									 <i class="fa fa-link"></i> Asignaci&oacute;n a Cursos Libres
								 </a>
										</li>
							 <?php } ?>
							 <hr>
							 <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
							 <li>
								 <a href="CPREPORTES/FRMreplistado.php">
									 <i class="glyphicon glyphicon-print"></i> Reporte de Autoridades
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
         <div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-edit"></i> Formulario Gestor de Directores o Autoridades
				</div>
				<div class="panel-body">
					<div class="row">
						 <div class="col-lg-11 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>CUI:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "cui" id = "cui"  value = "<?php echo $cui; ?>" onkeyup = "enteros(this)" maxlength = "15"/>
						</div>	
						<div class="col-xs-5">
							<label>Titulo o Tratamiento:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "titulo" id = "titulo" onkeyup = "texto(this)" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nombre:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "nom" id = "nom"  value = "<?php echo $nom; ?>" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>Apellido:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "ape" id = "ape" onkeyup = "texto(this)" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Fecha de Nacimiento:  </label> <span class="text-danger">*</span>
							<div class='input-group date'>
								<input type='text' class="form-control" id = "fecnac" name="fecnac" onblur="xajax_Calcular_Edad(this.value);" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>	
						<div class="col-xs-5">
							<label>Edad:  </label> <span class="text-danger">*</span>
							<strong class="form-control text-center" id = "sedad"></strong>
							<input type = "hidden" name = "edad" id = "edad" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>e-mail:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control text-libre" name = "mail" id = "mail" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>Telefono:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "tel" id = "tel" onkeyup = "texto(this)" />
						</div>	
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
							<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
				</div>
				<!-- /.panel-body -->
         </div>
         <!-- /.panel-default -->
			<div class="row">
				<div class="col-lg-12" id = "result">
					<?php echo tabla_otros_usuarios($cod,$nom,$ape,$sit,1); ?>
				</div>
			</div>
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
					<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?></h4>
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
	
	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/otrousu.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
   <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100,
				responsive: true
			});
		});
		
		$(function () {
			$('#fecnac').datetimepicker({
				 format: 'DD/MM/YYYY'
			});
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