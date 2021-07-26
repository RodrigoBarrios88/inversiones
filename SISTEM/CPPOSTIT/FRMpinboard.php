<?php
	include_once('xajax_funct_postit.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsPost = new ClsPostit();
	
	if($tipo_usuario == 2){ //// MAESTRO
		$pensum = $ClsPen->get_pensum_activo();
		$maestro = $tipo_codigo;
		$codigosPostit = '';
		$result_secciones = $ClsAcadem->get_seccion_maestro($pensum,'','','',$maestro,'','',1);
		if(is_array($result_secciones)){
			foreach($result_secciones as $row){
				$nivel = $row["sec_nivel"];
				$grado = $row["sec_grado"];
				$seccion = $row["sec_codigo"];
				$codigosPostit.= $ClsPost->get_postit_codigos('',$pensum,$nivel,$grado,$seccion,'','','','','',1);
			}
		}
		$codigosPostit = substr($codigosPostit, 0, -1);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$pensum = $ClsPen->get_pensum_activo();
		$director = $tipo_codigo;
		$codigosPostit = '';
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$director);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				$codigosPostit.= $ClsPost->get_postit_codigos('',$pensum,$nivel,$grado,'','','','','','',1);
			}
		}
		$codigosPostit = substr($codigosPostit, 0, -1);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsPen->get_grado($pensum,'','',1);
		$codigosPostit = '';
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				$codigosPostit.= $ClsPost->get_postit_codigos('',$pensum,$nivel,$grado,'','','','','','',1);
			}
		}
		$codigosPostit = substr($codigosPostit, 0, -1);
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
	
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>	
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	<link href="../assets.3.6.2/css/animate.css" rel="stylesheet">
	<link href="../assets.3.6.2/css/pinboard.css" rel="stylesheet">
	
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
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2  || $tipo_usuario == 5 ){ ?>
								<li>
									<a href="FRMpostit.php">
										<i class="fa fa-paste"></i> Gestor de Notificaciones
									</a>
								</li>
								<?php } ?>
								<li>
									<a href="FRMpinboard.php">
										<i class="fa fa-thumb-tack"></i> Vista de Notificaciones
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
					<i class="fa fa-thumb-tack"></i>
					Pinboard (Tablero de Notitas)
				</div>
				<div class="panel-body">
				<?php
					$fechaRepetida = '';
					$result = $ClsPost->get_postit($codigosPostit);
					if(is_array($result)){
				?>
					<ul class="notes">
					<?php
						foreach($result as $row){
							////////////////// AGRUPA OBJETO POR FECHAS ///////////////////////
							$fecha = trim($row["post_fecha_registro"]);
							$fecha = cambia_fechaHora($fecha);
							$fecha = substr($fecha,0,-9); //quita la hora
							$fecha = trim($fecha); //limpia cadenas
							$fecha = str_replace(" ","",$fecha);
							if($fechaRepetida != $fecha){
								echo '<li class="fecha"><h6 class="alert alert-warning text-left"><i class="fa fa-thumb-tack" ></i> Notas del '.$fecha.'</h6></li>';
								$fechaRepetida = $fecha;
							}
							////////////////////////////////////////////////////////////////
							//grado
							$grado = utf8_decode($row["post_grado_desc"]);
							$seccion = utf8_decode($row["post_seccion_desc"]);
							//materia
							$materia = utf8_decode($row["post_materia_desc"]);
							//target
							$target = trim($row["post_target"]);
							$target_nombre = trim(utf8_decode($row["post_target_nombre"]));
							$target = ($target != "")?$target_nombre:"TODOS";
							//descripcion
							$titulo = utf8_decode($row["post_titulo"]);
							$desc = utf8_decode($row["post_descripcion"]);
							if(strlen($desc) > 200){
								$desc = substr($desc, 0, 100).'... <br><br>';
								$codigo = trim($row["post_codigo"]);
								$desc.= '<button type="button" class="btn btn-warning btn-block btn-xs" onclick="verPostit('.$codigo.');" ><i class="fa fa-search"></i> Ver completo</button> ';
							}
							//fecha
							$fecha = $row["post_fecha_registro"];
							$fecha = cambia_fechaHora($fecha);
					?>
						<li>
							<div>
								<small><?php echo $fecha; ?></small>
								<h5><?php echo $titulo; ?></h5>
								<p><?php echo $desc; ?></p>
								<strong>PARA:</strong><br>
								<em> <?php echo "$target"; ?></em>
								<br>
								<label><?php echo "$grado $seccion"; ?></label>
								<a href="javascript:void(0)"><i class="fa fa-check "></i></a>
							</div>
						</li>
					<?php
						}
					?>
					</ul>
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/postit.js"></script>
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