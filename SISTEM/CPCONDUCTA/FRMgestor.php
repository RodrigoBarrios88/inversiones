<?php
	include_once('xajax_funct_conducta.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["GPOSTIT"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	/////-----
	$ClsAlu = new ClsAlumno();
	$ClsAsi = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	
	$result = $ClsAlu->get_alumno($cui,"","",1);
	if(is_array($result)){
		foreach($result as $row){
			$cui = trim($row["alu_cui"]);
			$tipocui = trim($row["alu_tipo_cui"]);
			$codigo = trim($row["alu_codigo_interno"]);
			//pasa a mayusculas
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombre_completo = $nombre." ".$apellido;
			//---
			$foto = trim($row["alu_foto"]);
		}
	}
	
	$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = trim($row["graa_nivel"]);
			$grado = trim($row["graa_grado"]);
			//--
			$nivel_desc = utf8_decode($row["niv_descripcion"]);
			$grado_desc = utf8_decode($row["gra_descripcion"]);
		}
	}
	
	$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$seccion = trim($row["seca_seccion"]);
			//--
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}else{
		$seccion = 0;
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
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
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
	
	<!-- Sweet Alert -->
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
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario de Perfil de Usuarios</a></li>
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
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2  || $tipo_usuario == 5 ){ ?>
								<li>
									<a class="active" href="FRMalumnos.php">
										<i class="fa fa-paste"></i> Gestor de Reportes
									</a>
								</li>
								<?php } ?>
								<li>
									<a href="FRMreportes.php">
										<i class="fa fa-thumb-tack "></i> Vista de Reportes
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
					<span class="fa fa-sun-o" aria-hidden="true"></span>
					Gestor de Reporte de Conducta
				</div>
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<a href="FRMalumnos.php" class="btn btn-default"><i class="fa fa-chevron-left"></i> Atras</a>
						</div>
						<div class="col-xs-5 col-xs-6 text-right text-danger">* Campos Obligatorios &nbsp; </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Alumnos:</label> <span class="text-danger">*</span>
							<input type = "text" class="form-info" value="<?php echo $nombre_completo; ?>" />
							<input type = "hidden" id="pensum" name = "pensum" value="<?php echo $pensum; ?>" />
							<input type = "hidden" id="nivel" name = "nivel" value="<?php echo $nivel; ?>" />
							<input type = "hidden" id="grado" name = "grado" value="<?php echo $grado; ?>" />
							<input type = "hidden" id="seccion" name = "seccion" value="<?php echo $seccion; ?>" />
							<input type = "hidden" id="alumno" name = "alumno" value="<?php echo $cui; ?>" />
							<input type = "hidden" id="codigo" name = "codigo" />
							<input type = "hidden" id="texto" name = "texto" value = "Reporte de Conducta" />
						</div>
						<div class="col-xs-5">
							<label>Grado / Secci&oacute;n:</label> <span class="text-danger">*</span>
							<input type = "text" class="form-info" value="<?php echo $grado_desc." ".$seccion_desc; ?>" />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Hoy me port&eacute;:</label> <span class="text-danger">*</span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-1">
							<label>
								<input type="radio" id = "conducta1" name = "conducta" />
								<label for="conducta1" id = "labelconducta1" > Muy Bien</label>
							</label>
						</div>
						<div class="col-xs-2">
							<label>
								<input type="radio" id = "conducta2" name = "conducta" />
								<label for="conducta2" id = "labelconducta2" > Bien</label>
							</label>
						</div>
						<div class="col-xs-2">
							<label>
								<input type="radio" id = "conducta3" name = "conducta" />
								<label for="conducta3" id = "labelconducta3" > Regular</label>
							</label>
						</div>
						<div class="col-xs-2">
							<label>
								<input type="radio" id = "conducta4" name = "conducta" />
								<label for="conducta4" id = "labelconducta4" > Debo Mejorar</label>
							</label>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Observaciones: <small class="text-muted">(no obligatorio)</small></label>
							<textarea class="form-control" id = "obs" name = "obs" rows="5" onkeyup="texto(this)" maxlength="250"></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "window.location.reload();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="fa fa-save"></span> Grabar</button>
							<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "Modificar();"><span class="fa fa-save"></span> Grabar</button>
						</div>
					</div>
					<br>
				</div>
			</div>
			<!-- /.panel-default -->
			<br>
			<div class="row">
				<div class="col-lg-12">
					<?php
						echo tabla_reportes($cui);
					?>
				</div>
			</div>		
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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/conducta.js"></script>
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