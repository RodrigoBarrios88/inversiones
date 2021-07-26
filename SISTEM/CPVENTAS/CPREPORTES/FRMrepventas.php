<?php
	include_once('xajax_funct_reportes.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa_nombre_1"];
	$empCodigo = $_SESSION['empCodigo'];
	$nivel = $_SESSION["nivel"];
	$valida = $_SESSION["GRP_GPOPER"];
	//$_Post
	$suc = ($_REQUEST["suc"] != "")?$_REQUEST["suc"]:$empCodigo;
	$regimen = ($_REQUEST["regimen"] != "")?$_REQUEST["regimen"]:$_SESSION["regimen"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	$desde = ($desde == "")?date("d/m/Y"):$desde;
	$hasta = ($hasta == "")?date("d/m/Y"):$hasta;
	//--
	$sit = $_REQUEST["sit"];
	$sit = ($sit == "")?"2":$sit;
	$cfac = $_REQUEST["confac"];
	
	
if($nivel != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("../..");
		 ?>	
    <!-- CSS personalizado -->
    <link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos Utilitarios -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

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
	
	
	<!-- Calendarios -->
    <link href="../../assets.3.6.2/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css">
	<script src="../../assets.3.6.2/js/dhtmlgoodies_calendar.js" type="text/javascript"></script>

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
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Perfil de Usuario</a></li>
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
                                <?php if($_SESSION["VENTA"] == 1){ ?>
                                <li>
									<a href="../FRMventas.php">
										<i class="fa fa-shopping-cart"></i> Ventas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTHIST"] == 1){ ?>
								<li>
									<a href="../FRMhistorial.php">
										<i class="fa fa-history"></i> Historial de Ventas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTANUL"] == 1){ ?>
								<li>
									<a href="../FRManula.php">
										<i class="fa fa-times-circle"></i> Anulaci&oacute;n de Ventas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CXCOB"] == 1){ ?>
								<li>
									<a href="../FRMcuentaxcob.php">
										<i class="fa fa-sort-numeric-desc"></i> Cuentas x Cobrar
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTPAG"] == 1){ ?>
								<li>
									<a href="../FRMpago.php">
										<i class="fa fa-money"></i> Pagos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTA"] == 1){ ?>
								<li>
									<a href="../FRMfacturarventas.php">
										<i class="fa fa-file-o"></i> Facturar Ventas Anteriores
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTPAG"] == 1){ ?>
								<li>
									<a href="../FRMprintcopy.php">
										<i class="fa fa-print"></i> Reimpresi&oacute;n de Facturas
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["VENTHIST"] == 1){ ?>
								<li>
									<a href="FRMrepventas.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Ventas
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../../CPMENU/MENUcontable.php">
										<i class="fa fa-indent"></i> Men&uacute;
									</a>
								</li>
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
            <div class="panel panel-default">
				<div class="panel-heading"><label><i class="fa fa-print"></i> Reporte de Ventas</label></div>
                <div class="panel-body" id = "formulario">
					<form name = "f1" name = "f1" method="get" action="REPventas.php" target="_blank">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label> <span class = " text-info">*</span></div>
						<div class="col-xs-5"><label>R&eacute;gimen Tributario:</label> <span class = " text-info">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("suc",""); ?>
							<input type = "hidden" name = "cod" id = "cod" />
							<script type="text/javascript">
								document.getElementById("suc").value = "<?php echo $suc; ?>";
							</script>
						</div>
						<div class="col-xs-5">
							<select class="form-control" name="regimen" id="regimen" >
								<option value="">Seleccione</option>
								<option value="1">R&Eacute;GIMEN DE PEQUE&Ntilde;O CONTRIBUYENTE</option>
								<option value="2">R&Eacute;GIMEN OPCIONAL SIMPLIFICADO SOBRE INGRESOS DE ACTIVIDADES LUCRATIVAS</option>
								<option value="3">R&Eacute;GIMEN SOBRE LAS UTILIDADES DE ACTIVIDADES LUCRATIVAS</option>
							</select>
							<script type="text/javascript">
								document.getElementById("regimen").value = "<?php echo $regimen; ?>";
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Situaci&oacute;n:</label> <span class = " text-info">*</span></div>
						<div class="col-xs-5"><label>Factura?:</label> <span class = " text-info">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id="sit" class="form-control" name="sit">
								<option value="2">PAGADA</option>
								<option value="1">PENDIENTE DE PAGO</option>
								<option value="0">ANULADA</option>
							</select>
							<script type="text/javascript">
								document.getElementById("sit").value = "<?php echo $sit; ?>";
							</script>
						</div>
						<div class="col-xs-5">
							<?php
								if($cfac == ""){
									$radio1 = "checked";
									$radio2 = "";
									$radio3 = "";
								}if($cfac == "1"){
									$radio1 = "";
									$radio2 = "checked";
									$radio3 = "";
								}if($cfac == "2"){
									$radio1 = "";
									$radio2 = "";
									$radio3 = "checked";
								}	
							?>
							&nbsp; <label><input type="radio" id = "todas" name = "confac" value="" <?php echo $radio1; ?> /><label for="todas" id = "labeltodas" > TODAS</label></label>
							&nbsp; <label><input type="radio" id = "con" name = "confac" value="1" <?php echo $radio2; ?> /><label for="con" id = "labelcon" > CON FACTURA</label></label>
							&nbsp; <label><input type="radio" id = "sin" name = "confac" value="2" <?php echo $radio3; ?> /><label for="sin" id = "labelsin" > SIN FACTURA</label></label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Desde (Fecha):</label> <span class = " text-info">*</span></div>
						<div class="col-xs-5"><label>Hasta (Fecha):</label> <span class = " text-info">*</span></div>
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
					<hr>
					</form>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
							<a type="button" class="btn btn-default" href = "FRMlibroventas.php"><span class="fa fa-eraser"></span> Limpiar</a>
                            <button type="button" class="btn btn-primary" onclick = "Submit();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                        </div>
                    </div>
					<br>
				</div>
            </div>
	    <!-- /.panel-default -->
	    
	    <br>
	</div>
	<!-- /#page-wrapper -->
	
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title" id="myModalLabel"><img src="../../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../assets.3.6.2/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/finanzas/libros.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
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
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>