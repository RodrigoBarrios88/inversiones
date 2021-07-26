<?php
	include_once('xajax_funct_chat.php');
	$id = $_SESSION["codigo"];
	$usuario_nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$usuario = $_REQUEST["usuario"];
	$ClsUsu = new ClsUsuario();
	if($usuario != ""){
		$result = $ClsUsu->get_usuario($usuario);
		if(is_array($result)){
			foreach($result as $row){
				$cui = $row["usu_tipo_codigo"];
				$nombre = $row["usu_nombre"];
				$nombre_pantalla = $row["usu_nombre_pantalla"];
				$mail = $row["usu_mail"];
			}
		}
	}
	
	$titulo = "Community Manager";
	$hini = "08:00";
	$hfin = "15:00";
	$obs = "Los mensajes se contestan en horarios establecidos por el colegio para tal fin.  Se agradece de antemano su comprensi&oacute;n.";
	
if($pensum != "" && $id != ""){ 	
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
	
	<!-- clockpicker -->
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
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="FRMusuario.php">
										<i class="fa fa-user"></i> Gestor de Usuarios
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMusuarios.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n de Usuarios
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Usuarios
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMrepasignacion.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Asignaciones
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
					<i class="fa fa-edit"></i> Formulario Gestor de Usuarios CM para el Chat
				</div>
            <div class="panel-body">
					<form id="f1" name="f1" method="get">
					<div class="row">
						<div class="col-lg-11 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Usuario a Habilitar:  </label><span class="text-danger">*</span>
							<?php echo usuarios_colegio_html("usuario","Submit();"); ?>
							<script>
								document.getElementById("usuario").value = '<?php echo $usuario; ?>';
							</script>
						</div>	
						<div class="col-xs-5">
							<label>CUI:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "cui" id = "cui" value = "<?php echo $cui; ?>" disabled />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nombre del Usuario:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "usunombre" id = "usunombre" value = "<?php echo $nombre; ?>" disabled />
						</div>	
						<div class="col-xs-5">
							<label>Nombre en el Chat:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "nombre" id = "nombre"  value = "<?php echo $nombre_pantalla; ?>" onkeyup = "texto(this)" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>E-mail para el Chat:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control text-libre" name = "mail" id = "mail" value = "<?php echo $mail; ?>" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>T&iacute;tulo para el Chat:  </label><span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "titulo" id = "titulo" value = "<?php echo $titulo; ?>" onkeyup = "texto(this)" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Hora de inicio de atenci&oacute;n:</label>
							<div class="form-group">
								<div class="input-group clockpickerini" data-autoclose="true">
									<input type="text" class="form-control" name = "hini" id = "hini" value = "<?php echo $hini; ?>" readonly >
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							 </div>
						</div>
						<div class="col-xs-5">
							<label>Hora de final de atenci&oacute;n:</label>
							<div class="form-group">
								<div class="input-group clockpickerfin" data-autoclose="true">
									<input type="text" class="form-control" name = "hfin" id = "hfin" value = "<?php echo $hfin; ?>" readonly >
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Observaciones:</label> <span class = "text-danger">*</span>
							<textarea class = "form-control text-libre" name = "obs" id = "obs" rows = "3" onkeyup = "textoLargo(this);" /><?php echo $obs; ?></textarea>
						</div>	
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a type="button" class="btn btn-default" href = "FRMusuario.php"><i class="fa fa-eraser"></i> Limpiar</a>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><i class="glyphicon glyphicon-floppy-disk"></i> Grabar</button>
							<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "Modificar();"><i class="glyphicon glyphicon-floppy-disk"></i> Grabar</button>
						</div>
					</div>
					</form>
				</div>
         </div>
         <!-- /.panel-default -->
			<div class="row">
				<div class="col-lg-12" id = "result">
					<?php echo tabla_usuarios($cui,"",1); ?>
				</div>
			</div>
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
	
	<!-- jQuery -->
   <script src="../assets.3.6.2/js/core/jquery.min.js"></script>
    
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/cm.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100,
				responsive: true
			});
		});
		
		$('.clockpickerini').clockpicker();
		$('.clockpickerfin').clockpicker();
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