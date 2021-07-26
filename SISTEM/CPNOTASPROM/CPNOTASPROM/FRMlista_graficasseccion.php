<?php
	include_once('xajax_funct_notas.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_usuario == 2){ //// MAESTRO
		$result_secciones = $ClsAcadem->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
		if(is_array($result)){
			$nivel = "";
			$grado = "";
			foreach($result as $row){
				$nivel.= $row["gra_nivel"].",";
				$grado.= $row["gra_codigo"].",";
			}
			$nivel = substr($nivel, 0, -1);
			$grado = substr($grado, 0, -1);
		}
		$result_secciones = $ClsPen->get_seccion_IN($pensum,$nivel,$grado,'','',1);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$result_secciones = $ClsPen->get_seccion($pensum,'','','','',1);
	}else{
		$valida = "";
	}
	
if($usunivel != "" && $usunombre != "" && $valida != ""){	
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
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
						<li class="active">
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_vernotas.php">
										<i class="fa fa-list-ol"></i> ver  Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_sabana.php">
										<i class="fa fa-list-ol"></i> ver  Notas Sabana
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_asignotas.php">
										<i class="fa fa-save"></i> Ingreso de Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlist_certificanotas.php">
										<i class="fa fa-check-square-o"></i> Certificar  Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlist_editnotas.php">
										<i class="fa fa-edit"></i> Modificar de Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMnominanotas.php">
										<i class="fa fa-file-text-o"></i> Nomina de Notas  por Grados
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlist_alumnosnotas.php">
										<i class="fa fa-file-text-o"></i> Tarjeta de Calificaciones
									</a>
								</li>	
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlist_alumnoscuadro.php">
										<i class="fa fa-trophy"></i> Cuadro de Honor por Grado y Unidad
									</a>
								</li>	
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlista_graficasseccion.php">
										<i class="fa fa-bar-chart-o"></i> Estad&iacute;sticas por Alumnos
									</a>
								</li>
								<?php } ?><?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlista_graficasmateria.php">
									<i class="fa fa-bar-chart-o"></i> Estad&iacute;sticas por Materias
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlista_diplomas.php">
										<i class="fa fa-graduation-cap"></i> Generador de Diplomas
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUacademico.php">
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
					Seleccione la Secci&oacute;n a Generar Estad&iacute;stica
				</div>
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<table class="table table-striped table-bordered table-hover font-10" id="dataTables-example">
								<thead>
									<tr>
										<th width = "10px" class = "text-center">No.</th>
										<th width = "200px" class = "text-center">Grado y Secci&oacute;n</th>
										<th width = "100px" class = "text-center"><span class="fa fa-cogs"></span></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if(is_array($result_secciones)){
										$i = 1;
										$usu = $_SESSION["codigo"];
										foreach($result_secciones as $row){
											$pensum = $row["niv_pensum"];
											$pensum = $ClsAcadem->encrypt($pensum, $usu);
											$nivel = $row["niv_codigo"];
											$nivel = $ClsAcadem->encrypt($nivel, $usu);
											$grado = $row["gra_codigo"];
											$grado = $ClsAcadem->encrypt($grado, $usu);
											$seccion = $row["sec_codigo"];
											$seccion = $ClsAcadem->encrypt($seccion, $usu);
											$grado_desc = utf8_decode($row["gra_descripcion"]);
											$seccion_desc = utf8_decode($row["sec_descripcion"]);
											//--
											$salida.= '<tr>';
											//No.
											$salida.= '<td class = "text-center">'.$i.'. </td>';
											//grado
											$salida.= '<td class = "text-center">'.$grado_desc.' '.$seccion_desc.'</td>';
											//boton
											$salida.= '<td class = "text-center">';
											$salida.= '<a class="btn btn-primary btn-block" href="FRMgraficas_seccion.php?hashkey1='.$pensum.'&hashkey2='.$nivel.'&hashkey3='.$grado.'&hashkey4='.$seccion.'" title = "Seleccionar Secci&oacute;n" >Seleccionar <i class="fa fa-chevron-right"></i></a>';   
											$salida.= '</td>';
											//--
											$salida.= '</tr>';
											$i++;
										}
										
										echo $salida;
									}else{
										
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<br>
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/academico/promnotas.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
  
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
   <script>
	  $(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100,
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