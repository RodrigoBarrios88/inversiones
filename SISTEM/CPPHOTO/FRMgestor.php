<?php
	include_once('xajax_funct_photo.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	//--
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAlu = new ClsAlumno();
	
	if($tipo_usuario === "1"){ /// SI el Usuario es Director
		$result_alumnos = $ClsAcad->get_otros_usuarios_alumnos($pensum,$usunivel,'','',$tipo_codigo);
	}else if($tipo_usuario === "2"){ /// SI el Usuario es Maestro
		$result_alumnos = $ClsAcad->get_maestro_alumnos($pensum,'','','',$tipo_codigo);
	}else{ // Si el Usuario es Administrador
		$result_alumnos = $ClsAcad->get_seccion_alumno($pensum,'','','','');
	}	
	
	if(is_array($result_alumnos)){
		$combo_alumnos = '<select name="target" id="target"  class = "form-control chosen-select" data-placeholder="Seleccione..." multiple >';
		if(is_array($result_alumnos)){
			$seccionX = '';
			$i = 1; ///primera vuelta
			foreach ($result_alumnos as $row) {
				$seccion = utf8_decode(trim($row["gra_descripcion"]))." ".utf8_decode(trim($row["sec_descripcion"]));
				if($seccionX != $seccion){
					if($i > 1){
					$combo_alumnos.= '</optgroup>'; /// Si no es la primera viuelta ( > 1 ), cierra el optgroup
					}
					$combo_alumnos.= '<optgroup label="'.$seccion.'">';
					$seccionX = $seccion;
				}
				$nombres = utf8_decode($row['alu_nombre'])." ".utf8_decode($row['alu_apellido']);
				$combo_alumnos.= '<option value='.utf8_decode($row['alu_cui']).'>'.$nombres.'</option>';
				$i++;
			}
		}
		$combo_alumnos.='</select>';
	}else{
		$combo_alumnos = combos_vacios("target");
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
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Chosen CSS -->
	<link href="../assets.3.6.2/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
	<link href="../assets.3.6.2/css/plugins/chosen/chosen.css" rel="stylesheet">
	
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
						<li class="active">
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2  || $tipo_usuario == 5 ){ ?>
								<li>
									<a class="active" href="FRMgestor.php">
										<i class="fa fa-camera"></i> Nuevo Album
									</a>
								</li>
								<?php } ?>
								<li>
									<a href="FRMalbum.php">
										<i class="fa fa-image"></i> Photo Album
									</a>
								</li>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMlectura.php">
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
					<i class="fa fa-camera"></i>
					Nuevo Album
				</div>
				<div class="panel-body">
				<form action="EXEalbum.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Alumnos:</label>
							<?php echo $combo_alumnos; ?>
						</div>
						<div class="col-xs-5">
							<input type = "hidden" id="maestro" name = "maestro" value="<?php echo $tipo_codigo; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Descripci&oacute;n: <small class="text-muted">(Opcional)</small></label>
							<textarea class="form-control" id = "desc" name = "desc" rows="5" onkeyup="textoLargo(this)"></textarea>
						</div>
						<div class="col-lg-5 col-xs-12 text-center">
							<label>Imagenes: <span class="text-danger">*</span> <small class="text-muted">(m&aacute;ximo 1 por publicaci&oacute;n)</small></label>
							<button type="button" class="btn btn-block btn-primary btn-outline" id = "btn-foto" onclick = "FotoJs();" title = "Fotos del Album"><i class="fa fa-camera"></i></button>
							<input id="fotos" name="fotos" type="file" class="hidden" onchange="TextoFoto();" >
							<input type = "hidden" id="codigo" name = "codigo" />
							<input type = "hidden" id="cuantos" name = "cuantos" />
							<p id = "etiqueta"></p>
						</div>	
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "window.location.reload();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="fa fa-save"></span> Grabar</button>
						</div>
					</div>
				</form>
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
   
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Bootstrap Core JavaScript -->
   <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
	<!-- DataTables JavaScript -->
	<script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
	<!-- Chosen -->
   <script src="../assets.3.6.2/js/plugins/chosen/chosen.jquery.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/photo.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
		$('.chosen-select').chosen();
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