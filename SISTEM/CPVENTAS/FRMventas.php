<?php
	include_once('xajax_funct_ventas.php');
	$nombre = $_SESSION["nombre"];
	$pventa = $_SESSION["cajapv"];
	$pensum = $_SESSION["pensum"];
	$moneda = $_SESSION["moneda"];
	$facturar = $_SESSION["facturar"];
	$sifact = ($facturar == 1)?"checked":"";
	
if($pensum != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
	<link href="../assets.3.6.2/css/iframe-detalle.css" rel="stylesheet">

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
				<!-- /.dropdown -->
                <li class="dropdown">
					<a>
						<i class="fa fa-expand" id = "view-fullscreen"></i>
						<i class="fa fa-compress hidden" id = "cancel-fullscreen"></i>
					</a>
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
					<br>
					
					<ul class="nav">
                       <li>
                            <table class="table table-striped table-bordered">
                                <tr>
									<th class = "text-center alert alert-info" colspan = "2"><h5>Forma de Pago</h5></th>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "VentaPagoJS(1);"><h6>Efectivo</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "VentaPagoJS(1);">
											<h6 id = "spanpago1"> 0 </h6>
											<input type = "hidden" name = "Pag1" id = "Pag1" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "VentaPagoJS(2);"><h6>Tarjeta</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "VentaPagoJS(2);">
											<h6 id = "spanpago2"> 0 </h6>
											<input type = "hidden" name = "Pag2" id = "Pag2" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "VentaPagoJS(4);"><h6>Cheque</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "VentaPagoJS(4);">
											<h6 id = "spanpago4"> 0 </h6>
											<input type = "hidden" name = "Pag4" id = "Pag4" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "VentaPagoJS(5);"><h6>C&eacute;dito</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "VentaPagoJS(5);">
											<h6 id = "spanpago5"> 0 </h6>
											<input type = "hidden" name = "Pag5" id = "Pag5" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<th class = "text-center" colspan = "2">
										<button type="button" class="btn btn-primary" onclick = "xajax_Reset_Pago();"> Limpiar Pagos</button>
									</th>
								</tr>
							</table>
							<div id = "divPagos" align = "center" >
								<?php echo tabla_inicio_venta_pago(1); ?>
							</div>
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
					<label><i class="fa fa-shopping-cart"></i> POS (Punto de Venta o Caja)</label>
				</div>
                <div class="panel-body">
				<form id='f1' name='f1' method='get' action="FRMventa_detalle.php" target="IFdetalle">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-center">
							<a href = "FRMventas.php" >
								<i class="fa fa-refresh fa-2x"></i>
							</a>
							<input type="hidden" id = "vent" name = "vent">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-danger">* Campos Obligatorios</span> <span class = " text-info">* Campos de Busqueda</span></div>
					</div>
					<div class="row">
						<div class="alert alert-info text-center" role="alert"><em>Datos de la Venta</em></div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<div class="form-group" id="data_1">
								<label>Fecha de Venta: </label> <span class="text-danger">*</span> 
								<div class="input-group date">
									<input type='text' class="form-control" id = "fec" name='fec' value="<?php echo date("d/m/Y"); ?>" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-xs-12 text-center">
							<button type="button" class="btn btn-default text-center" onclick = "NewCliente('');"  title = "Nuevo Cliente"><span class="fa fa-plus"></span> <span class="fa fa-users"></span></button>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Nit:</label> <span class = " text-danger">*</span> <span class = " text-info">*</span>
							<div class='input-group'>
								<input type = "text" class = "form-control" name = "nit" id = "nit" onkeyup = "texto(this);KeyEnter(this,Cliente);" onblur = "Cliente();" />
								<input type = "hidden" name = "cli" id = "cli" />
								<span class="input-group-addon" style="cursor:pointer" title = "Buscar Cliente" onclick = "SearchCliente();" >
									<span class="fa fa-search"></span>
								</span>
								<input type="hidden" id = "vcod" name = "vcod">
							</div>
						</div>
						<div class="col-lg-5 col-xs-12">
							<label>Cliente:</label> <span class = " text-danger">*</span> <span class = " text-info">*</span>
							<div class='input-group'>
								<input type="text" class="form-control" id="nom" name="nom" readonly />
								<span class="input-group-addon" style="cursor:pointer" onclick = "ResetCli();" >
									<span class="fa fa-refresh"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Empresa:</label> <span class = " text-danger">*</span>
							<?php echo empresa_html("suc","xajax_SucPuntVnt(this.value,'pv');"); ?>
							<input type = "hidden" name = "sucX" id = "sucX" value = "<?php echo $_SESSION["empresa"]; ?>" />
						</div>
						<div class="col-lg-5 col-xs-12" id = "spv">
							<label>Punto de Venta:</label> <span class = " text-danger">*</span>
							<?php
								if($_SESSION["empCodigo"] != ""){
									echo punto_venta_html($_SESSION["empCodigo"],"pv","Submit();");
								}else{
									echo combos_vacios("pv");
								}
							?>
						</div>
						<script>
							document.getElementById("suc").value = '<?php echo $_SESSION["empCodigo"]; ?>';
							document.getElementById("pv").value = '1';
						</script>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Moneda a Facturar:</label> <span class = " text-danger">*</span>
							<?php echo moneda_transacciones_html("Tmon","Submit();"); ?>
						</div>
						<div class="col-lg-5 col-xs-12">
							<label>Factura:</label> <br>
							<input type = "checkbox"  name = "fac" id = "fac" onclick = "Factura(this)" <?php echo $sifact; ?> />
						</div>
					</div>
					<div class="row" id="lbf1" ></div>
					<div class="row" id="lbf2">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Serie:</label> <span class = " text-danger">*</span>
							<?php echo serie_html("ser","NextFactura();"); ?>
						</div>
						<div class="col-lg-5 col-xs-12">
							<label>N&uacute;mero:</label> <span class = " text-danger">*</span>
							<input type = "text" class = "form-control" name = "facc" id = "facc" onkeyup = "enteros(this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Tipo de Descuento (Factura Global):</label>
							<select id="tfdsc" name="tfdsc" class = "form-control" onchange= "Submit();">
								<option value="P">Por Porcerntaje (%)</option>
								<option value="M">Por Monto Monetario (Q.)</option>
							</select>
						</div>
						<div class="col-lg-5 col-xs-12">
							<label>Monto del Descuento:</label>
							<input type = "text" class = "form-control" name = "fdsc" id = "fdsc" onkeyup = "decimales(this);" onblur = "Submit();" value = "0" />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="alert alert-info text-center" role="alert"><em>Detalle de Venta</em></div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>C&oacute;digo de Barras:</label> <span class = " text-info">*</span>&nbsp; <i class="fa fa-barcode"></i>
							<input type = "text" class = "form-control" name = "barc" id = "barc" onkeyup = "texto(this);KeyEnter(this,Barcode);"  onblur = "Barcode();" />
						</div>
						<div class="col-lg-5 col-xs-12">
							<label id = "cntart">Tipo de Venta:</label> <span class = " text-danger">*</span>
							<select id = "tip" name = "tip" class = "form-control" onchange = "TipoVenta(this.value)">
								<option value = "P">PRODUCTOS</option>
								<option value = "S">SERVICIOS</option>
								<option value = "O">OTROS</option>
							</select>
						</div>
					</div>
					<div class="row" id = "row1">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Art&iacute;culo:</label> <span class = " text-info">*</span> <br>
							<?php echo articulo_transaccion_html('Aart',"Articulo();"); ?>
						</div>
						<div class="col-lg-5 col-xs-12">
							<label id = "cntart">Existencia:</label> <span class = " text-danger">*</span>
							<input type = "text" class = "form-control" name = "cantlimit" id = "cantlimit" readonly />
							<input type = "hidden" name = "art" id = "art" />
							<input type = "hidden" name = "artn" id = "artn" />
							<input type = "hidden" name = "barc" id = "barc" />
							<input type = "hidden" name = "prec" id = "prec" />
							<input type = "hidden" name = "prem" id = "prem" />
							<input type = "hidden" name = "prov" id = "prov" />
							<input type = "hidden" name = "nit" id = "nit" />
							<input type = "hidden" name = "nom" id = "nom" />
						</div>
					</div>
					<div class="row hidden" id = "row2">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label id = "cntart">Servicio:</label> <span class = " text-danger">*</span>
							<?php echo servicio_transaccion_html('Sart',"Servicio();"); ?>
						</div>
					</div>
					<div class="row hidden" id = "row3">
						<div class="col-lg-10 col-xs-12 col-lg-offset-1">
							<label>Descripci&oacute;n:</label> <span class = " text-danger">*</span>
							<input type = "text" class = "form-control" name = "desc" id = "desc" onkeyup = "texto(this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Cantidad:</label> <span class = " text-danger">*</span>
							<input type = "text" class = "form-control" name = "cant" id = "cant" onkeyup = "enteros(this);KeyEnter(this,NewFilaVenta);" />
						</div>
						<div class="col-lg-5 col-xs-12">
							<label>Pr&eacute;cio:</label> <span class = " text-danger">*</span>
							<input type = "text" class = "form-control" name = "prev" id = "prev" onkeyup = "decimales(this);KeyEnter(this,NewFilaVenta);" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Moneda:</label> <span class = " text-danger">*</span>
							<?php echo moneda_transacciones_html("mon","ExeTipoCambio(this);"); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Tipo de Descuento (Individual):</label>
							<select id="tdsc" name="tdsc" class = "form-control" onchange= "ExeTipoCambio(document.getElementById('Tmon'));">
								<option value="P">Por Porcerntaje (%)</option>
								<option value="M">Por Monto Monetario (Q.)</option>
							</select>
						</div>
						<div class="col-lg-5 col-xs-12">
							<label>Monto del Descuento:</label>
							<input type = "text" class = "form-control" name = "dsc" id = "dsc" onkeyup = "decimales(this);KeyEnter(this,NewFilaVenta);" value = "0" />
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" onclick = "NewFilaVenta();"><span class="fa fa-plus"></span> <span class="fa fa-shopping-cart"></span></button>
							<input type = "hidden" name = "filas" id = "filas" value = "0"/>
                        </div>
                    </div>
					<br>
				</form>
				</div>
            </div>
			<!-- /.panel-default -->
	    
			<!-- /.panel-detalle -->
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						 <iframe id = "IFdetalle" name = "IFdetalle" src="FRMventa_detalle.php"></iframe>
					</div>
				</div>
			</div>
	    
			<!-- /.panel-default -->
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" onclick = "LimpiarVenta();"><span class="glyphicon glyphicon-erase"></span> Limpiar</button>
							<button type="button" class="btn btn-success" onclick = "ConfirmVentaJS();"><span class="fa fa-shopping-cart"></span> Vender</button>
						</div>
					</div>
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
    
    <!-- Select2 -->
	<link href="../assets.3.6.2/css/plugins/select2/select2.min.css" rel="stylesheet">
    <script src="../assets.3.6.2/js/plugins/select2/select2.full.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/ventas/venta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$(".select2").select2();
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