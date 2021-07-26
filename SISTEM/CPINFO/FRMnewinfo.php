<?php
	include_once('xajax_funct_info.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//---
	$desde = date("d/m/Y H:i");
	$hasta = date("d/m/Y H:i");
	
	
if($tipo_usuario != "" && $tipo_codigo != ""){ 	
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
	
	<!-- Inpuut File Uploader libs -->
	<link href="../assets.3.6.2/bower_components/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput_locale_fr.js" type="text/javascript"></script>
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput_locale_es.js" type="text/javascript"></script>
	
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
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMnewinfo.php">
										<i class="fa fa-plus-circle"></i> Nueva Actividad
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMmodinfo.php">
										<i class="fa fa-edit"></i> Actualizar Actividad
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
					<i class="fa fa-plus-circle"></i> Nueva Actividad
				</div>
				<div class="panel-body">
				<form action="EXEgrabar.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Target:</label> <span class = "text-danger">*</span>
							<select class = "form-control" name = "target" id = "target" onchange="TipoTarget();" >
								<option value = "">Seleccione</option>
								<option value = "TODOS">TODOS</option>
								<option value = "SELECT">SELECTIVO</option>
							</select>
						</div>	
						<div class="col-lg-5 col-xs-12">
							<label>Tipo de Target:</label> <span class = "text-danger">*</span>
							<select class = "form-control" name = "tipotarget" id = "tipotarget" onchange="TipoTarget();" disabled >
								<option value = "0">Seleccione</option>
								<option value = "1">GRADOS Y SECCIONES</option>
								<option value = "2">GRUPOS</option>
							</select>
						</div>	
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Nombre:</label> <span class = "text-danger">*</span>
							<input type = "text" class = "form-control text-libre" name = "nom" id = "nom"  onkeyup = "texto(this);" />
						</div>	
						<div class="col-lg-5 col-xs-12">
							<label>Link:</label> <small class = "text-info">(Opcional)</small>
							<input type = "text" class = "form-control text-libre" name = "link" id = "link" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Fecha y Hora de Inicio:</label></div>
						<div class="col-xs-5"><label>Fecha y Hora de Finalizaci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="form-group" id="simpleini">
								<div class='input-group date'>
									<input type="text" class="form-control" id = "fecini" name="fecini" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<div class="form-group" id="simplefin">
								<div class='input-group date'>
									<input type="text" class="form-control" id = "fecfin" name="fecfin" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="form-group">
								<div class="input-group clockpickerini" data-autoclose="true">
									<input type="text" class="form-control" name = "horini" id = "horini" readonly >
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							 </div>
						</div>
						<div class="col-xs-5">
							<div class="form-group">
								<div class="input-group clockpickerfin" data-autoclose="true">
									<input type="text" class="form-control" name = "horfin" id = "horfin" readonly >
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Descripci&oacute;n:</label> <span class = "text-danger">*</span>
							<textarea class = "form-control text-libre" name = "desc" id = "desc" rows = "5" onkeyup = "textoLargo(this);" /></textarea>
						</div>	
					</div>
					<hr>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1"><label>Listado de Grupos o Secciones a Incluir:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-5 col-xs-12"><label>Adjuntar Archivo:</label> <small class = "text-info">(Opcional)</small></div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1" id = "divgrupos">
							<?php
								echo lista_multiple_vacia("grupos"," Listado de Grupos");
								//echo tabla_grados_secciones()
							?>
						</div>
						<div class="col-lg-5 col-xs-12 text-center">
							<div class="form-group">
								<input id="imagen" name="imagen" type="file" multiple="false" >
								<input type = "hidden" id="codigo" name = "codigo" />
								<input type = "hidden" id="docname" name = "docname" />
							</div>
						</div>	
					</div>
				</form>
				</div>
			</div>
			<br>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
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
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/informacion.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$('#fecini').datetimepicker({
            format: 'DD/MM/YYYY'
        });
		
		$('#fecfin').datetimepicker({
            format: 'DD/MM/YYYY'
        });
		
		$('.clockpickerini').clockpicker();
		$('.clockpickerfin').clockpicker();
		
		$("#imagen").fileinput({
			showUpload: false,
			showCaption: true,
			browseClass: "btn btn-primary btn-md",
			fileType: "any",
			allowedFileExtensions : ['jpg', 'jpeg', 'png','gif'],
			previewFileIcon: "<i class='fa fa-image'></i>",
			maxFileSize: 2000
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