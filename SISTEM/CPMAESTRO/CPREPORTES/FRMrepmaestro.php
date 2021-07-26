<?php
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//$_POST
	$tipoAsi = $_REQUEST["tipoAsi"];
	$area = $_REQUEST["area"];
	$pensum = $_SESSION["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$tipo = $_REQUEST["tipo"];
	$seccion = $_REQUEST["seccion"];
	
	
if($nombre != "" && $tipo_codigo != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
	
	<!-- CSS personalizado -->
    <link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>	
    
    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../assets.3.6.2/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body onload="Tipo_Asignacion('<?php echo $tipoAsi; ?>');" >
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
                <?php echo $_SESSION["rotulos_colegio_subpantalla"]; ?>
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
                        <li><a href="../../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
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
                                <?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
                                <li>
									<a href="../FRMnewmaestro.php">
										<i class="fa fa-user"></i> Gestor de Maestros
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMmaestro.php">
										<i class="fa fa-list-ol"></i> Listar Maestros
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMlistmaestro.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n de Maestros
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMlist_curso.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n a Cursos Libres
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMlistmaestro_desasig.php">
										<i class="fa fa-unlink"></i> Desasignaci&oacute;n por Secci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Maestros
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMrepmaestro.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Asignaciones
									</a>
                                </li>
								<?php } ?>
								<hr>
								<li>
									<a href="../../menu.php">
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
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<span class="fa fa-columns" aria-hidden="true"></span>
							Asignaci&oacute;n de Maestros a Grupos, Grados y Materias
						</div>
						<div class="panel-body"> 
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>T&iacute;po de Asignaci&oacute;n:</label> </div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<select class = "form-control" name = "tipoAsi" id = "tipoAsi" onchange="Submit();">
												<option value = "">Seleccione</option>
												<option value = "1">GRADOS Y SECCIONES</option>
												<option value = "2">MATERIAS</option>
												<option value = "3">GRUPOS</option>
											</select>
											<script type = "text/javascript">
												document.getElementById("tipoAsi").value = '<?php echo $tipoAsi; ?>';
											</script>
											<input type = "hidden" name = "area" id = "area" />
										</div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>Programa Acad&eacute;mico:</label></div>
										<div class="col-xs-5"><label>Nivel:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<?php echo pensum_html("pensum","Submit();"); ?>
											<?php if($pensum != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("pensum").value = '<?php echo $pensum; ?>';
											</script>
											<?php } ?>
										</div>
										<div class="col-xs-5" id = "divnivel">
											<?php if($pensum != ""){
												echo nivel_html($pensum,"nivel","Submit();");
											?>
											<script type = "text/javascript">
												document.getElementById("nivel").value = '<?php echo $nivel; ?>';
											</script>
											<?php
												}else{
													echo combos_vacios("nivel");
												}	
											?>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>Grado de los Alumnos:</label></div>
										<div class="col-xs-5"><label>T&iacute;po:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1" id = "divgrado">
											<?php if($pensum != "" && $nivel != ""){
													echo grado_html($pensum,$nivel,"grado","Submit();");
												}else{
													echo combos_vacios("grado");
												}	
											?>
											<?php if($pensum != "" && $nivel != ""){ ?>
												<script type = "text/javascript">
													document.getElementById("grado").value = '<?php echo $grado; ?>';
												</script>
											<?php } ?>
										</div>
										<div class="col-xs-5">
											<select id = "tipo" name = "tipo" class = "form-control" onchange="Submit();">
												<option value = "">Selecciones</option>
												<option value = "A">ACAD&Eacute;MICA</option>
												<option value = "P">PR&Aacute;CTICA</option>
												<option value = "D">Deportiva</option>
											</select>
											<?php if($tipo != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("tipo").value = '<?php echo $tipo; ?>';
											</script>
											<?php } ?>
										</div>
									</div>
									<div class="row">
										<hr>
									</div>
									<br>
									<div class="row">
										<div class="col-xs-12 text-center">
											<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
											<button type="button" class="btn btn-primary" id = "busc" onclick = "Reporte();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
            <div class="row">
				<div class="col-lg-12" id = "result">
					
				</div>
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
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../../CONFIG/images/logo.png" width = "60px;" /></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../../CONFIG/images/img-loader.gif"/><br>
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
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../assets.3.6.2/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/app/maestro.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Reporte(){
			myform = document.forms["f1"];
			myform.target ="_blank";
			myform.action ="REPmaestro.php";
			myform.submit();
			myform.action ="";
			myform.target ="";
		}
    </script>	
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>