<?php
	include_once('xajax_funct_encuesta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//$_POST
	$ClsEnc = new ClsEncuesta();
	$hashkey = $_REQUEST["hashkey"];
	$encuesta = $ClsEnc->decrypt($hashkey, $id);
	
if($tipo_codigo != "" && $tipo_usuario != ""){ 	
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
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	
	<!-- Inpuut File Uploader libs -->
	<link href="../assets.3.6.2/bower_components/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput_locale_fr.js" type="text/javascript"></script>
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput_locale_es.js" type="text/javascript"></script>
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
	<link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Sweet Alert -->
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
									<a href="FRMnewencuesta.php">
										<i class="fa fa-paste"></i> Nueva Encuesta
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="FRMmodencuesta.php">
										<i class="fa fa-edit"></i> Actualizar Encuesta
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 3 || $tipo_usuario == 5){ ?>
								<li>
									<a href="IFRMencuestas.php">
										<i class="fa fa-file-text"></i> Ver Encuesta
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
					<i class="fa fa-question"></i> Gestor de Preguntas
				</div>
            <div class="panel-body" id = "formulario">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Pregunta:</label> <span class = "text-danger">*</span>
							<textarea class = "form-control" name = "pregunta" id = "pregunta"  onkeyup = "textoLargo(this)" rows="5" /></textarea>
							<input type="hidden" id = "encuesta" name = "encuesta" value="<?php echo $encuesta; ?>" />
							<input type="hidden" id = "codigo" name = "codigo" />
						</div>	
						<div class="col-xs-5">
							<label>Tipo de Respuesta:</label> <span class = "text-danger">*</span>
							<select class = "form-control" name = "tipo" id = "tipo" >
								<option value = "">Seleccione</option>
								<option value = "1">PUNTUACI&Oacute;N (1 - 5)</option>
								<option value = "2">VERDADERO - FALSO (V - F)</option>
								<option value = "3">RESPUESTA ABIERTA</option>
							</select>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "grab" onclick = "GrabarPregunta();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
							<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "ModificarPregunta();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a class="btn btn-success" href = "FRMnotificar.php?hashkey=<?php echo $hashkey; ?>"><i class="fa fa-bell"></i> Revisar y Notificar</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<?php
						echo tabla_preguntas($codigo,$encuesta);
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/encuestas.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
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