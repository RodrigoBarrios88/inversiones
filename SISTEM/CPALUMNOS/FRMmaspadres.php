<?php
	include_once('xajax_funct_alumno.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	$padres = $_REQUEST["padres"];
	$leerBD = $_REQUEST["leerBD"];
	// valida //
	$padres = ($padres != "")?$padres : 1; 
	
	$ClsAlu = new ClsAlumno();
	$ClsCli = new ClsCliente();
	$ClsAcadem = new ClsAcademico();
	$ClsAsig = new ClsAsignacion();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	
	$result = $ClsAlu->get_alumno($cui,"","",1);
	if(is_array($result)){
		foreach($result as $row){
			$cui = $row["alu_cui"];
			$codigo = $row["alu_codigo_interno"];
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$genero = trim($row["alu_genero"]);
			$fecnac = trim($row["alu_fecha_nacimiento"]);
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$edad = Calcula_Edad($fecnac);
			$fecnac = $fecnac;
			$edad = $edad;
			$sedad = $edad;
			$cliente = $row["alu_cliente_factura"];
		}
	}
		
		
	
if($usuario != "" && $nombre != "" && $valida != ""){ 	
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
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<i class="glyphicon arrow"></i></a> 
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMnewalumno.php">
										<i class="fa fa-plus-circle"></i> Agregar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="FRMsecciones.php?acc=1">
										<i class="fa fa-edit"></i> Actualizar Datos de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=4">
										<i class="fa fa-list-alt"></i> Ficha T&eacute;cnica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../CPFICHAPRESCOOL/FRMsecciones.php">
										<i class="fa fa-file-text-o"></i> Ficha Preescolar
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=5">
										<i class="fa fa-comments"></i> Bit&aacute;cora Psicopedag&oacute;gica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=3">
										<i class="fa fa-camera"></i> Re-Ingreso de Fotograf&iacute;as
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=2">
										<i class="fa fa-group"></i> Asignaci&oacute;n Extracurricular
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=6">
										<i class="fa fa-ban"></i> Inhabilitar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=7">
										<i class="fa fa-check-circle-o"></i> Activar Alumnos
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMrepasiggrupo.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos/Grupos
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
			<!-- .panel-default -->
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-user"></i> Datos del Alumno
				</div>
				<div class="panel-body" id = "formulario">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>CUI:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-info" name = "cui" id = "cui" value = "<?php echo $cui; ?>" onkeyup = "enteros(this)" disabled  />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nombre:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-info" name = "nombre" id = "nombre"  value = "<?php echo $nombre; ?>" onkeyup = "texto(this)" disabled />
						</div>	
						<div class="col-xs-5">
							<label>Apellido:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-info" name = "apellido" id = "apellido" value = "<?php echo $apellido; ?>" onkeyup = "texto(this)" disabled />
						</div>	
					</div>
				</div>
			</div>
			<!-- /.panel-default -->
			<br>
			<!-- .panel-succes -->
			<div class="panel panel-success">
				<div class="panel-heading">
					<i class="fa fa-plus"></i> Formaulario de Padres o Responsables
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>DPI:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "dpi" id = "dpi" onkeyup = "enteros(this)" onblur = "xajax_Buscar_Padre(this.value,'');" onchange = "xajax_Buscar_Padre(this.value,'');" maxlength = "13"/>
						</div>
						<div class="col-xs-5">
							<label>Parentesco:  </label> <span class="text-danger">*</span>
							<select class = "form-control" name = "parentesco" id = "parentesco" >
								<option value ="">Seleccione</option>
								<option value ="P">Padre</option>
								<option value ="M">Madre</option>
								<option value ="A">Abuelo(a)</option>
								<option value ="O">Encargado (otro)</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>e-mail:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control text-libre" name = "mail" id = "mail" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>Telefono:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "tel" id = "tel" onkeyup = "enteros(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nombre:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "nom" id = "nom" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>Apellido:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "ape" id = "ape" onkeyup = "texto(this)" />
							<input type = "hidden" id ="existe" name = "existe" >
						</div>	
					</div>
				</div>
			</div>
			<!-- /.panel-success -->
			
			<!-- .panel-default -->
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6 col-xs-offset-3 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "AgregarPadre();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
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
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../images/logo.png" width = "60px;" /></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../images/img-loader.gif"/><br>
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/alumno.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(function () {
            $('#fecnac1').datetimepicker({
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