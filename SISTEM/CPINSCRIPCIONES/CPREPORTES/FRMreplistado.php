<?php
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	
	
if($nombre != "" && $valida != ""){	
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
                                <?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
                                <li>
									<a href="../FRMimpresion_boletas.php">
										<i class="fa fa-print"></i> Impresi&oacute;n de Boletas de Inscripci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
                                <li>
									<a href="../FRMboletas.php">
										<i class="fa fa-money"></i> Recepci&oacute;n de Boletas de Inscripci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["APROVCON"] == 1){ ?>
								<li>
									<a href="../FRMaprobacion.php">
										<i class="fa fa-file-text-o"></i> Abrobaci&oacute;n de Contratos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["RECEPCON"] == 1){ ?>
								<li>
									<a href="../FRMrecepcion.php">
										<i class="fa fa-inbox"></i> Recepci&oacute;n de Contratos
									</a>
                                </li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="../FRMblacklist.php">
										<i class="fa fa-ban"></i> Listas Reservada
									</a>
                                </li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="FRMdatos_actualizados.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Datos Actualizados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="FRMboletas_giradas.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Boletas en Circulaci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="FRMboletas_aprobadas.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Boletas Pagadas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="FRMcontratos_aprobados.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Contratos Aprobados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte General del Proceso
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
							<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
							Reporte de Contratos de Inscripci&oacute;n
						</div>
						<div class="panel-body"> 
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>Nivel:</label></div>
										<div class="col-xs-5"><label>Grado de los Alumnos:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<?php echo inscripcion_nivel_html("nivel","Submit();"); ?>
											<script type = "text/javascript">
												document.getElementById("nivel").value = '<?php echo $nivel; ?>';
											</script>
										</div>
										<div class="col-xs-5">
											<?php if($nivel != ""){
													echo inscripcion_grado_html($nivel,"grado","Submit();");
												}else{
													echo combos_vacios("grado");
												}	
											?>
											<script type = "text/javascript">
												document.getElementById("grado").value = '<?php echo $grado; ?>';
											</script>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1"><label>Situaci&oacute;n de Contratos:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<select class="form-control" id = "sit" name="sit">
												<option value="">TODOS</option>
												<option value="2">DATOS ACTUALIZADOS</option>
												<option value="3">BOLETAS GIRADAS</option>
												<option value="4">BOLETAS PAGADAS - CONTRATOS PENDIENTES DE APROBAR</option>
												<option value="5">CONTRATOS APROBADOS</option>
												<option value="6">CONTRATOS ENTREGADOS (en el Colegio)</option>
											</select>
											<script type = "text/javascript">
												document.getElementById("sit").value = '<?php echo $sit; ?>';
											</script>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-xs-12 text-center">
											<button type="button" class="btn btn-info" id = "busc" onclick = "Reporte();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
											<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
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
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/academico/academico.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Reporte(){
			myform = document.forms.f1;
			myform.target ="_blank";
			myform.action ="FRMreporte_general.php";
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
	//echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>