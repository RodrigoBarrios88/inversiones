<?php
	include_once('xajax_funct_ventas.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//$_Post
	$suc = $_REQUEST["suc"];
	$tipo = $_REQUEST["tipo"];
	$operador = $_REQUEST["operador"];
	$orderby = $_REQUEST["orderby"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	$desde = ($desde == "")?date("d/m/Y"):$desde;
	$hasta = ($hasta == "")?date("d/m/Y"):$hasta;
	//--
	$cli  = $_REQUEST["cli"];
	$nit  = $_REQUEST["nit"];
	$nom  = $_REQUEST["nom"];
	
	
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
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Datepicker Bootstrap v3.0 -->
	<link href="../assets.3.6.2/css/plugins/datapicker/datepicker3.css"rel="stylesheet"/>

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
                                <?php if($_SESSION["VENTA"] == 1){ ?>
                                <li>
									<a href="FRMventas.php">
										<i class="fa fa-shopping-cart"></i> Ventas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTHIST"] == 1){ ?>
								<li>
									<a href="FRMhistorial.php">
										<i class="fa fa-history"></i> Historial de Ventas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTANUL"] == 1){ ?>
								<li>
									<a href="FRManula.php">
										<i class="fa fa-times-circle"></i> Anulaci&oacute;n de Ventas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CXCOB"] == 1){ ?>
								<li>
									<a href="FRMcreditos.php">
										<i class="fa fa-files-o"></i> Cr&eacute;ditos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CXCOB"] == 1){ ?>
								<li>
									<a href="FRMcuentaxcob.php">
										<i class="fa fa-credit-card"></i> Trajetas y Cheques
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTPAG"] == 1){ ?>
								<li>
									<a href="FRMpago.php">
										<i class="fa fa-money"></i> Pagos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTA"] == 1){ ?>
								<li>
									<a href="FRMfacturarventas.php">
										<i class="fa fa-file-o"></i> Facturar Ventas Anteriores
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTPAG"] == 1){ ?>
								<li>
									<a href="FRMprintcopy.php">
										<i class="fa fa-print"></i> Reimpresi&oacute;n de Facturas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VENTHIST"] == 1){ ?>
								<li>
									<a href="FRMdiario.php">
										<i class="fa fa-calendar"></i>  Reporte Diario
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUcontable.php">
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
				<div class="panel-heading"><label><i class="fa fa-credit-card"></i> Ejecuci&oacute;n de Cobros con Trajetas y Cheques</label></div>
                <div class="panel-body">
					<form id='f1' name='f1' action='FRMcuentaxcob.php' method='get'>
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Empresa:</label>
								<?php echo empresa_html("suc","Submit();"); ?>
								<input type = "hidden" name = "cod" id = "cod" />
								<script type="text/javascript">
									document.getElementById("suc").value = "<?php echo $suc; ?>";
								</script>
							</div>	
							<div class="col-xs-5" id = "spv">
								<label>Tipo de Cuenta:</label>
								<select id="tipo" name="tipo" class="form-control" onchange="Submit();">
									<option value="" selected="">TODAS</option>
									<option value="4">CHEQUES</option>
									<option value="2">TARJETAS</option>
								</select>
							</div>
							<script type="text/javascript">
								document.getElementById("tipo").value = "<?php echo $tipo; ?>";
							</script>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Operador de Tarjetas / Banco:</label>
								<input type='text' class="form-control" id = "operador" name='operador' value="<?php echo $operador; ?>" onkeyup = "texto(this);KeyEnter(this,Submit);" />
							</div>	
							<div class="col-xs-5">
								<label>Ordenado Por:</label>
								<select id="orderby" name="orderby" class="form-control" onchange="Submit();">
									<option value="" selected="">VENTA</option>
									<option value="TIPO">TIPO DE TRANSACCI&Oacute;N</option>
									<option value="FECHA">FECHA DE TRANSACCI&Oacute;N</option>
								</select>
							</div>
							<script type="text/javascript">
								document.getElementById("orderby").value = "<?php echo $orderby; ?>";
							</script>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Nit:</label> <span class = " text-info">*</span>
								<div class='input-group'>
									<input type = "text" class = "form-control" name = "nit" id = "nit" onkeyup = "texto(this);KeyEnter(this,Cliente);" value="<?php echo $nit; ?>" onblur = "Cliente();" />
									<input type = "hidden" name = "cli" id = "cli" />
									<span class="input-group-addon" style="cursor:pointer" title = "Buscar Cliente" onclick = "SearchCliente();" >
										<span class="fa fa-search"></span>
									</span>
									<input type="hidden" id = "vcod" name = "vcod">
								</div>
							</div>
							<div class="col-xs-5">
								<label>Cliente:</label> <span class = " text-info">*</span>
								<div class='input-group'>
									<input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>" readonly />
									<span class="input-group-addon" style="cursor:pointer" onclick = "ResetCli();" >
										<span class="fa fa-refresh"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label>Desde / Hasta: </label> <span class="text-danger">*</span>
								<div class="form-group" id="data_1">
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="form-control" name="desde" name="desde" value="<?php echo $desde; ?>"/>
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control" name="hasta" name="hasta" value="<?php echo $hasta; ?>" />
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12 text-center">
								<a type="button" class="btn btn-default" href = "FRMcuentaxcob.php"><span class="fa fa-eraser"></span> Limpiar</a>
								<button type="button" class="btn btn-primary" onclick = "Submit();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
							</div>
						</div>
					</form>
				</div>
            </div>
			<!-- /.panel-default -->
			<?php
				if($desde != "" && $hasta != ""){
					echo tabla_cuentas_x_cobrar('',$suc,$tipo,$desde,$hasta,$operador,$orderby);
				}
			?>
	    <br>
	</div>
	<!-- /#page-wrapper -->
	
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../CONFIG/images/img-loader.gif"/><br>
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
    
	<!-- Datepicker Bootstrap v3.0 -->
    <script src="../assets.3.6.2/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/ventas/venta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [ ]
			});
	    });
	
		$('#data_1 .input-daterange').datepicker({
            format: 'dd/mm/yyyy',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
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