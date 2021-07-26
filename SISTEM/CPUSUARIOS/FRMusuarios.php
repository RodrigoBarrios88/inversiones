<?php
	include_once('xajax_funct_usuarios.php');
	$nombre = $_SESSION["nombre"];
	$nombre_pantalla = $_SESSION["nombre_pantalla"];
	$tipo = $_SESSION["nivel"];
	$valida = $_SESSION["GRP_GPADMIN"];
	
if($tipo != "" && $nombre != ""){	
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

    <!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    

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
						<li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario Gestor de Usuarios</a></li>
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
								<?php if($_SESSION["GUSU"] == 1){ ?>
								<li>
									<a href="FRMusuarios.php">
										<i class="glyphicon glyphicon-user"></i> Gestor de Usuarios
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GUSU"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php">
										<i class="fa fa-group"></i> Usuarios de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["ASIROL"] == 1){ ?>
								<li>
									<a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(1);">
										<i class="glyphicon glyphicon-pawn"></i> Asignaci&oacute;n de Rol
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["INFUSU"] == 1){ ?>
								<li>
									<a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(2);">
										<i class="glyphicon glyphicon-file"></i> Info. de Usuarios
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["LISTPERM"] == 1){ ?>
								<li>
									<a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(4);">
										<i class="glyphicon glyphicon-option-horizontal"></i> Ver Permisos de Usuario
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["HISTPERM"] == 1){ ?>
								<li>
									<a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(5);">
										<i class="glyphicon glyphicon-option-vertical"></i> Ver Hist. Permisos Usuario
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["ARUSU"] == 1){ ?>
								<li>
									<a href="javascript:void(0);" onclick = "Promt_Buscar_Usuarios(3);">
										<i class="glyphicon glyphicon-asterisk"></i> Cambiar Sit. de Usuario
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["REPUSU"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMrepusuarios.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Usuarios
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
         <div id = "cuerpo" class="panel panel-default">
				<div class="panel-heading"><i class="glyphicon glyphicon-user"></i> Gestor de Usuarios</div>
            <div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label> <label class = " text-info">* Campos de Busqueda</label></div>
					</div>
					<div class="row">
						<div class="col-xs-2 text-right"><label>Tipo de Usuario: </label> <span class="text-danger">*</span> <span class="text-info">*</span></div>
						<div class="col-xs-4">
							<select name = "tipo" id = "tipo" class="form-control">
								<option>Seleccione</option>
								<option value="5">ADMINISTRADOR</option>
								<option value="7">ADMINISTRADOR INTERNO (COLEGIO)</option>
								<option value="1">DIRECTOR O AUTORIDAD</option>
								<option value="2">DOCENTE O MAESTO</option>
								<option value="3">PADRE DE FAMILIA</option>
								<option value="10">ALUMNO</option>
								<option value="6">USUARIO ADMINISTRATIVO</option>
							</select>
							<input type = "hidden" name = "cod" id = "cod" />
						</div>
						<div class="col-xs-2 text-right"><label>Nombre: </label> <span class="text-danger">*</span> <span class="text-info">*</span></div>
						<div class="col-xs-4 text-left"><input type = "text" class="form-control" name = "nom" id = "nom" onkeyup = "texto(this)" /></div>
					</div>
					<div class="row">
						<div class="col-xs-2 text-right"><label>Email: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4"><input type = "text" class="form-control text-libre" name = "mail" id = "mail" onkeyup = "texto(this)" /></div>
						<div class="col-xs-2 text-right"><label>Telefono: </label> &nbsp;&nbsp;</div>
						<div class="col-xs-4 text-left"><input type = "text" class="form-control" name = "tel" id = "tel" onkeyup = "texto(this)" /></div>
					</div>
					<div class="row">
						<div class="col-xs-2 text-right"><label>Usuario: </label> <span class="text-danger">*</span> <span class="text-info">*</span></div>
						<div class="col-xs-4"><input type = "text" class="form-control text-libre" name = "usu" id = "usu" onkeyup = "texto(this)" /></div>
						<div class="col-xs-2 text-right"><label>Contrase&ntilde;a: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left"><input type = "password" class="form-control" name = "pass" id = "pass" /></div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-6 col-xs-offset-4 text-left checkbox">
						<label>
							<input type="checkbox" name = "avi" id = "avi" value = "0" checked disabled />
							- Pedir Cambio de Contrase&ntilde;a al Iniciar Sesi&oacute;n. 
						</label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-xs-offset-4 text-left radio">
						<label>
							<input type="radio" name = "cambio1" id = "cambio1" value = "1" checked  onclick = "checkValue(1)" />
							- Pedir cambio de Contrase&ntilde;a cada cierto tiempo.
						</label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-xs-offset-4 text-left radio">
							<label>
								<input type="radio" name = "cambio2" id = "cambio2" value = "0"  onclick = "checkValue(2)" />
								- Nunca pedir cambio de Contrase&ntilde;a por tiempo.
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-xs-offset-4 text-left checkbox">
							<label>
								<input type="checkbox" name = "seg" id = "seg" value = "0" disabled />
								- Constraint de Seguridad. 
							</label>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-info" id = "busc" onclick = "Buscar();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
							<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
				</div>
				<!-- /.panel-body -->
				<br>
				<div class="row">
					<div class="col-lg-12" id = "result">
						<?php
							echo tabla_usuarios($cod,$suc,$nom,$niv,$sit);
						?>
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/usuario.js"></script>
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