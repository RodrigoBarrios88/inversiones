<?php
	include_once('xajax_funct_ventas.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$filas = $_REQUEST["filas"];
	$ventas = $_REQUEST["ventas"];
	$seriesanula = $_REQUEST["seriesanula"];
	$numerosanula = $_REQUEST["numerosanula"];
	$subtotales = $_REQUEST["subtotales"];
	$descuentos = $_REQUEST["descuentos"];
	$totales = $_REQUEST["totales"];
	$monedas = $_REQUEST["monedas"];
	$tcambio = $_REQUEST["tcambio"];
	$clientes = $_REQUEST["clientes"];
	
	$arrcli = explode("|", $clientes);
	$ClsCli = new ClsCliente();
	$result = $ClsCli->get_cliente($arrcli[1],'','');
	if(is_array($result)){
		foreach($result as $row){
			$cod = $row["cli_id"];
			$nom = utf8_decode($row["cli_nombre"]);
			$nit = trim($row["cli_nit"]);
		}
	}
	
	$arrventas = explode("|", $ventas);
	$arrnumerosAnul = explode("|", $numerosanula);
	$codIN = "";
	$cont_anulaciones = 0;
	for($i = 1; $i <= $filas; $i++){
		$codIN.= $arrventas[$i].",";
		$anulacion = $arrnumerosAnul[$i];
		if($anulacion != ""){
			$cont_anulaciones++;
		}
	}
	$codIN = substr($codIN, 0, -1);
	
	
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
                       <li class="active">
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
									<a class="active" href="FRMfacturarventas.php">
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
				<div class="panel-heading"><i class="fa fa-file-o"></i> <label>Facturar Ventas Anteriores</label></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 text-right">
							<span class = "text-danger">* Campos Obligatorios</span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="form-group" id="data_1">
								<label>Fecha de Venta: </label> <span class="text-danger">*</span> 
								<div class="input-group date">
									<input type='text' class="form-control" id = "fecha" name='fecha' value="<?php echo date("d/m/Y"); ?>" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<input type = "hidden" name = "filas" id = "filas" value = "<?php echo $filas; ?>" />
							<input type = "hidden" name = "ventas" id = "ventas" value = "<?php echo $ventas; ?>" />
							<input type = "hidden" name = "seriesanula" id = "seriesanula" value = "<?php echo $seriesanula; ?>" />
							<input type = "hidden" name = "numerosanula" id = "numerosanula" value = "<?php echo $numerosanula; ?>" />
							<input type = "hidden" name = "subtotales" id = "subtotales" value = "<?php echo $subtotales; ?>" />
							<input type = "hidden" name = "descuentos" id = "descuentos" value = "<?php echo $descuentos; ?>" />
							<input type = "hidden" name = "totales" id = "totales" value = "<?php echo $totales; ?>" />
							<input type = "hidden" name = "monedas" id = "monedas" value = "<?php echo $monedas; ?>" />
							<input type = "hidden" name = "tcambio" id = "tcambio" value = "<?php echo $tcambio; ?>" />
							<input type = "hidden" name = "clientes" id = "clientes" value = "<?php echo $cliente; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nit:</label> <span class = " text-danger">*</span> <span class = " text-info">*</span>
							<div class='input-group'>
								<input type = "text" class = "form-control" name = "nit" id = "nit" value = "<?php echo $nit; ?>" onkeyup = "texto(this);KeyEnter(this,Cliente);" onblur = "Cliente();" />
								<input type = "hidden" name = "cli" id = "cli" value = "<?php echo $cod; ?>" />
								<span class="input-group-addon" style="cursor:pointer" onclick = "SearchCliente();" >
									<span class="fa fa-search"></span>
								</span>
								<input type="hidden" id = "vcod" name = "vcod">
							</div>
						</div>
						<div class="col-xs-5">
							<label>Cliente:</label> <span class = " text-danger">*</span> <span class = " text-info">*</span>
							<div class='input-group'>
								<input type="text" class="form-control" id="nom" name="nom" value = "<?php echo $nom; ?>" readonly />
								<span class="input-group-addon" style="cursor:pointer" onclick = "ResetCli();" >
									<span class="fa fa-refresh"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"></div>
						<div class="col-xs-5"></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Empresa:</label> <span class = " text-danger">*</span>
							<?php echo empresa_html("suc1","xajax_SucPuntVnt(this.value,'pv1');"); ?>
						</div>
						<div class="col-xs-5" id = "spv1">
							<label>Punto de Venta:</label> <span class = " text-danger">*</span>
							<?php
								if($_SESSION["empresa"] != ""){
									echo punto_venta_html($_SESSION["empresa"],"pv1");
								}else{
									echo combo_vacio("pv1");
								}
							?>
						</div>
						<script>
							document.getElementById("suc1").value = '<?php echo $_SESSION["empresa"]; ?>';
							document.getElementById("pv1").value = '1';
						</script>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Serie de Factura:</label> <span class = " text-danger">*</span>
							<?php echo serie_html("ser","NextFacturaAnterior();"); ?>
						</div>
						<div class="col-xs-5">
							<label>N&uacute;mero de Factura:</label> <span class = " text-danger">*</span>
							<input type = "text" class = "form-control" name = "facc" id = "facc" onkeyup = "enteros(this);" />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1 text-center">
							<?php if($cont_anulaciones > 0){ ?>
							<h6 class="alert alert-danger">
								<i class="fa fa-warning"></i> <?php echo $cont_anulaciones; ?> Venta(s) ya cuenta(n) con factura(s). Las facturas anteriores seran anuladas...
							</h6>
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" onclick = "window.history.back();"><span class="fa fa-times"></span> Cancelar</button>
							<button type="button" class="btn btn-primary" onclick = "GrabarFacturaAnteriores();"><span class="fa fa-check"></span> Aceptar</button>
						</div>
					</div>
				</div>		
			</div>
			<!-- /.panel-default -->
			<br>
			<?php echo tabla_montos_ventas_anteriores($codIN); ?>
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
				responsive: true
			});
	    });
	
		$('#data_1 .input-group.date').datepicker({
            format: 'dd/mm/yyyy',
			todayBtn: "linked",
			keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
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