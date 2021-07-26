<?php
	include_once('xajax_funct_sueldos.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$cod = $_REQUEST["cod"];
	$tipo = $_REQUEST["tipo"];
	$clase = $_REQUEST["clase"];
	$titulo = $_REQUEST["titulo"];
	$periodo = $_REQUEST["periodo"];
	$obs = $_REQUEST["obs"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	$desde = ($desde == "")?date("d/m/Y"):$desde;
	$hasta = ($hasta == "")?date("d/m/Y"):$hasta;
	
if($pensum != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="es">
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
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Perfil de Usuario</a></li>
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
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMtipo_nomina.php">
										<i class="fa fa-file-text-o"></i> T&iacute;po de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMpersonal_planillas.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n a Listados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMlist_personal_configuracion.php?acc=3">
										<i class="fa fa-list"></i> Horas Laborales (Conf.)
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMlist_personal_configuracion.php?acc=1">
										<i class="fa fa-list"></i> Asignaci&oacute;n Bonos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMlist_personal_configuracion.php?acc=2">
										<i class="fa fa-list"></i> Asignaci&oacute;n Descuentos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMnewnomina.php">
										<i class="fa fa-folder-open"></i> Apertura de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMeditnomina.php">
										<i class="fa fa-edit"></i> Edici&oacute;n de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMstatusnomina.php">
										<i class="fa fa-tasks"></i> Status de Nominas
									</a>
                                </li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUadministrativo.php">
										<i class="fa fa-indent"></i> Men&uacute;
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
				<div class="panel-heading"><label>Formulario de Edici&oacute;n de Nominas de Pago</label></div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' action='#' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>T&iacute;po de Nomina:  </label> <span class="text-danger">*</span></div>
						<div class="col-xs-5"><label>Clase:  </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo tipo_nomina_planilla_html("tipo","Submit();"); ?>
							<script type = "text/javascript">
								document.getElementById("tipo").value = '<?php echo $tipo; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<select class = "form-control" name = "clase" id = "clase" onchange="Submit();">
								<option value = "">Seleccione</option>
								<option value = "P">PERSONAL POR PLANILLA</option>
								<option value = "F">PERSONAL QUE FACTURA POR SERVICIOS PROFESIONALES</option>
							</select>
							<script type = "text/javascript">
								document.getElementById("clase").value = '<?php echo $clase; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>T&iacute;tulo de la Nomina:  </label> <span class="text-danger">*</span></div>
						<div class="col-xs-5"><label>Tipo de Periodo:  </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = " titulo" id = "titulo" onkeyup = "texto(this)" value = "<?php echo $titulo; ?>" maxlength = "150"/>
							<input type = "hidden" name = " cod" id = "cod" value="<?php echo $cod; ?>" />
						</div>
						<div class="col-xs-5">
							<select class = "form-control" name = "periodo" id = "periodo" onchange="Submit();">
								<option value = "">Seleccione</option>
								<option value = "S">SEMANAL</option>
								<option value = "Q">QUINCENAL</option>
								<option value = "M">MENSUAL</option>
								<option value = "E">ESPECIAL</option>
							</select>
							<script type = "text/javascript">
								document.getElementById("periodo").value = '<?php echo $periodo; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Desde (Fecha):</label></div>
						<div class="col-xs-5"><label>Hasta (Fecha):</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="form-group">
								<div class='input-group date' id='fini'>
									<input type='text' class="form-control" id = "desde" name='desde' value="<?php echo $desde; ?>" />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
                        <div class="col-xs-5">
							<div class="form-group">
								<div class='input-group date' id='ffin'>
									<input type='text' class="form-control" id = "hasta" name='hasta' value="<?php echo $hasta; ?>" />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
                    </div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1"><label>Observaciones:</label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<textarea class = "form-control" name = " obs" id = "obs" onkeyup = "texto(this)"><?php echo $obs; ?></textarea>
						</div>	
					</div>
					</form>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a type="button" class="btn btn-default" id = "limp" href = "FRMeditnomina.php"><span class="fa fa-eraser"></span> Limpiar</a>
							<button type="button" class="btn btn-primary" id = "mod" onclick = "ModificarNomina();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php
								echo tabla_edicion_nominas('','','','',1);
							?>
						</div>
					</div>
				</div>
            </div>
             <!-- /.panel-default -->
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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/rrhh/planilla.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
		});
		
		$(function () {
            $('#desde').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
		
		$(function () {
            $('#hasta').datetimepicker({
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