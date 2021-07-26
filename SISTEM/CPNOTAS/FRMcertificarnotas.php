<?php
	include_once('xajax_funct_notas.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$materia = $_REQUEST["materia"];
	$unidad = $_REQUEST["unidad"];
	$calificacion = $_REQUEST["calificacion"];
	$calificacion = ($calificacion == "")?1:$calificacion;
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	$hashkey1 = $_REQUEST["hashkey1"];
	$pensum = $ClsAcadem->decrypt($hashkey1, $usuario);
	$hashkey2 = $_REQUEST["hashkey2"];
	$nivel = $ClsAcadem->decrypt($hashkey2, $usuario);
	$hashkey3 = $_REQUEST["hashkey3"];
	$grado = $ClsAcadem->decrypt($hashkey3, $usuario);
	$hashkey4 = $_REQUEST["hashkey4"];
	$seccion = $ClsAcadem->decrypt($hashkey4, $usuario);
	
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}
	
	if($tipo_usuario == 2){ //// MAESTRO
		$result_materias = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,'',$tipo_codigo);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado);
	}else if($tipo_usuario == 5){ /// ADMINISTRADOR
		$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado);
	}else{
		$valida = "";
	}
	
	if(is_array($result_materias)){
		if($tipo_usuario == 2){ //// MAESTRO
			$combo_materia = combos_html_onclick($result_materias,"materia","secmat_materia","materia_descripcion","Submit();");
		}else if($tipo_usuario == 1){ //// DIRECTORA
			$combo_materia = combos_html_onclick($result_materias,"materia","mat_codigo","mat_descripcion","Submit();");
		}else if($tipo_usuario == 5){ /// ADMINISTRADOR
			$combo_materia = combos_html_onclick($result_materias,"materia","mat_codigo","mat_descripcion","Submit();");
		}
	}else{
		$combo_materia = combos_vacios("materia");
	}
	
	
if($usunombre != "" && $valida != ""){	
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
								<?php if($tipo_usuario == 1 ||$tipo_usuario == 5 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_asignotas.php">
										<i class="fa fa-save"></i> Ingreso de Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a class="active" href="FRMlist_certificanotas.php">
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
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMnominanotas.php">
										<i class="fa fa-file-text-o"></i> Nomina de Notas  por Grados
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 2 ||$tipo_usuario == 5 || $tipo_usuario == 1){ ?>
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
			<form name = "f1" id = "f1" method="get">
			<div class="panel panel-default">
				<div class="panel-heading"> 
					<span class="fa fa-save" aria-hidden="true"></span>
					Asignaci&oacute;n o Ingreso de Notas 
				</div>
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Tipo de Calificaci&oacute;n:</label>
							<select class="form-control" id="calificacion" name="calificacion" onchange="Submit();" >
								<option value="1">Calificaci&oacute;n Num&eacute;rica</option>
								<option value="2">Calificaci&oacute;n con Literales</option>
								<option value="3">Calificaci&oacute;n por Tipificaci&oacute;n</option>
							</select>
							<input type = "hidden" id="pensum" name = "pensum" value="<?php echo $pensum; ?>" />
							<input type = "hidden" id="nivel" name = "nivel" value="<?php echo $nivel; ?>" />
							<input type = "hidden" id="grado" name = "grado" value="<?php echo $grado; ?>" />
							<input type = "hidden" id="seccion" name = "seccion" value="<?php echo $seccion; ?>" />
							<input type = "hidden" id="maestro" name = "maestro" value="<?php echo $maestro; ?>" />
							<input type = "hidden" id="tipo" name = "tipo" />
							<!-- -->
							<input type = "hidden" id="hashkey1" name = "hashkey1" value="<?php echo $hashkey1; ?>" />
							<input type = "hidden" id="hashkey2" name = "hashkey2" value="<?php echo $hashkey2; ?>" />
							<input type = "hidden" id="hashkey3" name = "hashkey3" value="<?php echo $hashkey3; ?>" />
							<input type = "hidden" id="hashkey4" name = "hashkey4" value="<?php echo $hashkey4; ?>" />
							<!-- -->
							<script type = "text/javascript">
								document.getElementById("calificacion").value = '<?php echo $calificacion; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<label>Grado y Secci&oacute;n:</label>
							<span class="form-info"><?php echo $grado_desc; ?> <?php echo $seccion_desc; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Materia:</label>
							<?php echo $combo_materia; ?>
							<script type = "text/javascript">
								document.getElementById("materia").value = '<?php echo $materia; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<label>Unidad:</label>
							<?php echo unidades_html($nivel,'unidad','Submit();'); ?>
							<?php if($unidad != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("unidad").value = '<?php echo $unidad; ?>';
							</script>
							<?php } ?>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a class="btn btn-default" id = "limp" href="FRMcertificarnotas.php?hashkey1=<?php echo $hashkey1; ?>&hashkey2=<?php echo $hashkey2; ?>&hashkey3=<?php echo $hashkey3; ?>&hashkey4=<?php echo $hashkey4; ?>"><span class="fa fa-times"></span> Cancelar</a>
							<button type="button" class="btn btn-success" onclick = "CertificarNotas();"><span class="fa fa-check-square-o"></span> Certificar</button>
						</div>
					</div>
					<br>
				</div>
			</div>
			<div class="row">
					<?php
						//echo "$pensum,$nivel,$grado,$seccion,$materia,$unidad";
						if($pensum != "" && $nivel != "" && $grado != "" && $materia != "" && $seccion != "" && $unidad != ""){
							if($calificacion == 1){
								echo tabla_secciones_certificacion($pensum,$nivel,$grado,$seccion,$materia,$unidad,1);
							}else if($calificacion == 2){
								echo tabla_secciones_certificacion_literales($pensum,$nivel,$grado,$seccion,$materia,$unidad,1);
							}else if($calificacion == 3){
								echo tabla_secciones_certificacion_tipificacion($pensum,$nivel,$grado,$seccion,$materia,$unidad,1);
							}else{
								echo "";
							}
						}
					?>
			</div>
			</form>
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
	<script src="../assets.3.6.2/dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/academico/notas.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
   <!-- Page-Level Demo Scripts - Tables - Use for reference -->
   <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 50,
				responsive: true,
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