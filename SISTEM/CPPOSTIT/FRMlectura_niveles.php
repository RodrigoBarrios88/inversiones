<?php
	include_once('xajax_funct_postit.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_usuario == 2){ //// MAESTRO - DIRECTORA
		$result_niveles = $ClsAcadem->get_nivel_maestro($pensum,'',$tipo_codigo);
	}else if($tipo_usuario == 1){ ////// 
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
		if(is_array($result)){
			$nivel = "";
			$grado = "";
			foreach($result as $row){
				$nivel.= $row["gra_nivel"].",";
			}
			$nivel = substr($nivel, 0, -1);
		}
		$result_niveles = $ClsPen->get_nivel($pensum,$nivel,1);
	}else if($tipo_usuario == 5){
		$result_niveles = $ClsPen->get_nivel($pensum,'',1);
	}else{
		$valida = "";
	}
	
	$pensum = $_SESSION["pensum"];
	$pensum_hashkey = $ClsAcadem->encrypt($pensum, $usuario);
	
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
									<a class="active" href="FRMlectura.php">
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
					<span class="fa fa-paste" aria-hidden="true"></span>
					Seleccione el nivel a revisar lectura
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-3 text-left">
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5 ){ ?>
							<a class="btn btn-primary btn-outline" href="FRMconfirmacion.php?hashkey1=<?php echo $pensum_hashkey; ?>">
								<i class="fa fa-paste"></i> <i class="fa fa-bank"></i> Postit para todo el Colegio
							</a>
							<?php }else{ ?>
							<a class="btn btn-default" href="#" disabled >
								<i class="fa fa-paste"></i> <i class="fa fa-bank"></i> Postit para todo el Colegio
							</a>
							<?php } ?>
						</div>	
						<div class="col-lg-3 text-center">
							<?php if($tipo_usuario == 1 || $tipo_usuario == 5 ){ ?>
							<a class="btn btn-primary active" href="FRMlectura_niveles.php">
								<i class="fa fa-paste"></i> <i class="fa fa-tag"></i> Postit para todo un Nivel
							</a>
							<?php }else{ ?>
							<a class="btn btn-default" href="#" disabled >
								<i class="fa fa-paste"></i> <i class="fa fa-tag"></i> Postit para todo un Nivel
							</a>
							<?php } ?>
						</div>	
						<div class="col-lg-3 text-center">
							<a class="btn btn-primary btn-outline" href="FRMlectura_grados.php">
								<i class="fa fa-paste"></i> <i class="fa fa-tags"></i> Postit para todo un Grado
							</a>
						</div>
						<div class="col-lg-3 text-right">
							<a class="btn btn-primary btn-outline" href="FRMlectura.php">
								<i class="fa fa-paste"></i> <i class="fa fa-thumb-tack"></i> Postit por Secciones
							</a>
						</div>
					</div>
					<br>
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">
						<thead>
							<tr>
							<th width = "10px" class = "text-center">No.</td>
							<th width = "300px" class = "text-center">Niveles</td>
							<th width = "100px" class = "text-center"><i class="fa fa-cogs"></i></td>
							</tr>
						</thead>
						<?php
							if(is_array($result_niveles)){
								$i = 1;
								$usu = $_SESSION["codigo"];
								foreach($result_niveles as $row){
									$pensum = $row["niv_pensum"];
									$pensum = $ClsAcadem->encrypt($pensum, $usu);
									$nivel = $row["niv_codigo"];
									$nivel = $ClsAcadem->encrypt($nivel, $usu);
									//--
									$nivel_desc = utf8_decode($row["niv_descripcion"]);
									$salida.= '<tr>';
									//No.
									$salida.= '<td class = "text-center">'.$i.'. </td>';
									//Nivel
									$salida.= '<td class = "text-left">'.$nivel_desc.'</td>';
									//boton
									$salida.= '<td class = "text-center">';
									$salida.= '<a type="button" class="btn btn-primary btn-block" href="FRMconfirmacion.php?hashkey1='.$pensum.'&hashkey2='.$nivel.'" title = "Seleccionar Secci&oacute;n" ><span class="fa fa-chevron-right"></span></a>';   
									$salida.= '</td>';
									//--
									$salida.= '</tr>';
									$i++;
								}
								
								echo $salida;
							}else{
								
							}
						?>
						</table>
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
				pageLength: 50,
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