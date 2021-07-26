<?php
	include_once('xajax_funct_compra.php');
	$nombre = $_SESSION["nombre"];
	$pventa = $_SESSION["cajapv"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPCONTA"];
	$moneda = $_SESSION["moneda"];
	$facturar = $_SESSION["facturar"];
	$sifact = ($facturar == 1)?"checked":"";
	$margen = $_SESSION['margenutil'];
	$margen = ($margen == "")?"0":$margen;
	
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
	<link href="../assets.3.6.2/css/iframe-detalle.css" rel="stylesheet">
	
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

    <!-- DataTables Responsive CSS -->
    

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Sweet Alert -->
	<script src="../assets.3.6.2/js/plugins/sweetalert/sweetalertnew.min.js"></script>

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
								<?php if($_SESSION["COMPRA"] == 1){ ?>
                                <li>
									<a href="FRMcompra.php">
										<i class="fa fa-dollar"></i> Compras
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GASTO"] == 1){ ?>
								<li>
									<a href="FRMgasto.php">
										<i class="fa fa-dollar"></i> Gastos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["COMPHIST"] == 1){ ?>
								<li>
									<a href="FRMhistorial.php">
										<i class="fa fa-history"></i> Historial Compras/Gastos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["COMPANUL"] == 1){ ?>
								<li>
									<a href="FRManula.php">
										<i class="fa fa-times-circle"></i> Anulaci&oacute;n Compras/Gastos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CXPAG"] == 1){ ?>
								<li>
									<a href="FRMporpagar.php">
										<i class="fa fa-sort-numeric-desc"></i> Cuentas x Pagar
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["COMPPAG"] == 1){ ?>
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
									<td><a href="javascript:void(0);" onclick = "CompraPagoJS(1);"><h6>Efectivo</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "CompraPagoJS(1);">
											<h6 id = "spanpago1"> 0 </h6>
											<input type = "hidden" name = "Pag1" id = "Pag1" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "CompraPagoJS(2);"><h6>Tarjeta de D&eacute;bito</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "CompraPagoJS(2);">
											<h6 id = "spanpago2"> 0 </h6>
											<input type = "hidden" name = "Pag2" id = "Pag2" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "CompraPagoJS(3);"><h6>Tarjeta de Cr&eacute;dito</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "CompraPagoJS(3);">
											<h6 id = "spanpago3"> 0 </h6>
											<input type = "hidden" name = "Pag3" id = "Pag3" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "CompraPagoJS(4);"><h6>Cheque</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "CompraPagoJS(4);">
											<h6 id = "spanpago4"> 0 </h6>
											<input type = "hidden" name = "Pag4" id = "Pag4" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "SearchChequePagado();"><h6>Cheque Pagado</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "SearchChequePagado();">
											<h6 id = "spanpago7"> 0 </h6>
											<input type = "hidden" name = "Pag7" id = "Pag7" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "CompraPagoJS(5);"><h6>C&eacute;dito</h6></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "CompraPagoJS(5);">
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
							<br>
							<div id = "divPagos" align = "center" >
								<?php echo tabla_inicio_compra_pago(1); ?>
							</div>
							<br>
							<hr>
							<br>
							<table class="table table-striped table-bordered">
								<tr>
									<th class="text-center" colspan = "2">
										<button type="button" class="btn btn-primary" onclick = "SearchLote();" title = "Click para enlazar lotes a esta compra"> Lotes Enlazados</button>
									</th>
								</tr>
							</table>
							<br>
							<div id = "divLotes" align = "center" >
								<?php echo tabla_lotes_compra(0); ?>
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
				<div class="panel-heading"><label><i class="fa fa-dollar"></i> Registro de Compras</label></div>
                <div class="panel-body" id = "formulario">
				<form id='f1' name='f1' method='get' action="FRMcompra_detalle.php" target="IFdetalle">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-center">
							<a href = "FRMcompra.php" >
								<i class="fa fa-refresh fa-2x"></i>
							</a> 
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-danger">* Campos Obligatorios</span> <span class = " text-info">* Campos de Busqueda</span></div>
					</div>
					<div class="row">
						<div class="alert alert-info text-center" role="alert"><em>Datos de la Compra</em></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Fecha de Compra:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class='input-group date'>
								<div class="form-group">
									<div class='input-group date' id='fini'>
										<input type='text' class="form-control" id = "fec" name='fec' value="<?php echo date("d/m/Y"); ?>" />
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-5 text-center">
							<button type="button" class="btn btn-default text-center" onclick = "NewProveedor('');"  title = "Nuevo Proveedor"><span class="fa fa-plus"></span> <span class="fa fa-users"></span></button>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Nit:</label> <span class = " text-danger">*</span> <span class = " text-info">*</span></div>
						<div class="col-xs-5"><label>Proveedor:</label> <span class = " text-danger">*</span> <span class = " text-info">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class='input-group'>
								<input type = "text" class = "form-control" name = "nit" id = "nit" onkeyup = "texto(this);KeyEnter(this,Proveedor);" onblur = "Proveedor();" />
								<input type = "hidden" name = "prov" id = "prov" />
								<span class="input-group-addon" style="cursor:pointer" onclick = "SearchProveedor();" >
									<span class="fa fa-search"></span>
								</span>
							</div>
						</div>
						<div class="col-xs-5">
							<div class='input-group'>
								<input type="text" class="form-control" id="nom" name="nom" readonly />
								<span class="input-group-addon" style="cursor:pointer" onclick = "ResetProv();" >
									<span class="fa fa-refresh"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label id = "cntsuc">Empresa:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Doc. de Respaldo:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("suc",""); ?>
							<input type = "hidden" name = "class" id = "class" value = "C" />
							<input type = "hidden" name = "sucX" id = "sucX" value = "<?php echo $_SESSION["empresa"]; ?>" />
							<script>
								document.getElementById("suc").value = '<?php echo $_SESSION["empCodigo"]; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "ref" id = "ref" onkeyup = "texto(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label id = "cntTmon">Moneda a Facturar:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo moneda_transacciones_html("Tmon","ExeTipoCambio(this);"); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Tipo de Descuento (Factura Global):</label> </div>
						<div class="col-xs-5"><label>Monto del Descuento:</label> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id="tfdsc" name="tfdsc" class = "form-control" onchange= "Submit();">
								<option value="P">Por Porcerntaje (%)</option>
								<option value="M">Por Monto Monetario (Q.)</option>
							</select>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "fdsc" id = "fdsc" onkeyup = "decimales(this);" onblur = "Submit();" value = "0" />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="alert alert-info text-center" role="alert"><em>Detalle de Compra</em></div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Listar Art&iacute;culos Adquiridos a este Proveedor:</label> <span class = " text-info">*</span></div>
						<div class="col-xs-5"><label>Codigo de Importaci&oacute;n de Compras Anteriores:</label> <span class = " text-info">*</span>&nbsp; <i class="fa fa-qrcode"></i></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<button type="button" class="btn btn-default btn-block" onclick = "ImportarProductosProveedor('C');"><span class="fa fa-download"></span> <span class="fa fa-navicon"></span></button>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "importar" id = "importar" onkeyup = "enteros(this);KeyEnter(this,ImportarCompra);" />
							<input type = "hidden" name = "tipoCompra" id = "tipoCompra" value = "C" />
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Tipo de Compra:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5 "><label>Regl&oacute;n de Compra:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id = "tip" name = "tip" class = "form-control" onchange = "TipoCompra(this.value);">
									<option value = "P">PRODUCTOS INVENTARIADOS</option>
									<option value = "S">SERVICIOS O PROD. NO INV.</option>
									<option value = "U">SUMINISTROS</option>
									<option value = "E">MOVILIARIO Y EQUIPO</option>
							</select>
							<input type = "hidden" name = "par" id = "par" value = "1" />
						</div>
						<div class="col-xs-5" id = "divreg">
							<div id = "cntreg">
								<?php echo reglon_html(1,"reg"); ?>
							</div>
							<script>
								document.getElementById("reg").value = '1';
							</script>
						</div>
					</div>
					<div class="row" id = "row1">
						<div class="col-xs-5 col-xs-offset-1"><label>Codigo de Barras:</label> <span class = " text-info">*</span>&nbsp; <i class="fa fa-barcode"></i></div>
						<div class="col-xs-5"><label id = "cntart">Art&iacute;culo:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row" id = "row2">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "Abarc" id = "Abarc" onkeyup = "texto(this);KeyEnter(this,Barcode);"  onblur = "Barcode();" />
						</div>
						<div class="col-xs-5">
							<?php echo articulo_transaccion_html('Aart',"Articulo();"); ?>
						</div>
					</div>
					<div class="row hidden" id = "row3">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "Sbarc" id = "Sbarc" onkeyup = "texto(this);KeyEnter(this,Barcode);"  onblur = "Barcode();" />
						</div>
						<div class="col-xs-5">
							<?php echo suministro_transaccion_html('Sart',"Suministro();"); ?>
						</div>
					</div>
					<div class="row hidden"  id = "row4">
						<div class="col-xs-5 col-xs-offset-1"><label>Descripci&oacute;n:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row hidden" id = "row5">
						<div class="col-xs-10 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "desc" id = "desc" onkeyup = "texto(this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Cantidad:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Pr&eacute;cio de Compra:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "cant" id = "cant" onkeyup = "enteros(this);KeyEnter(this,NewFilaCompra);" />
							<input type = "hidden" name = "cantlimit" id = "cantlimit" />
							<input type = "hidden" name = "art" id = "art" />
							<input type = "hidden" name = "artn" id = "artn" />
							<input type = "hidden" name = "barc" id = "barc" />
							<input type = "hidden" name = "prov" id = "prov" />
							<input type = "hidden" name = "nit" id = "nit" />
							<input type = "hidden" name = "nom" id = "nom" />
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "prec" id = "prec" onkeyup = "decimales(this);KeyEnter(this,NewFilaCompra);Calcula_Precios(<?php echo $margen; ?>);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Precio Sugerido:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Pr&eacute;cio de Venta:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "prem" id = "prem" readonly />
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "prev" id = "prev" onkeyup = "decimales(this);KeyEnter(this,NewFilaCompra);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Moneda:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo moneda_transacciones_html("mon","ExeTipoCambio(this);"); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Tipo de Descuento (Individual):</label> </div>
						<div class="col-xs-5"><label>Monto del Descuento:</label> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id="tdsc" name="tdsc" class = "form-control" onchange= "ExeTipoCambio(document.getElementById('Tmon'));">
								<option value="P">Por Porcerntaje (%)</option>
								<option value="M">Por Monto Monetario (Q.)</option>
							</select>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "dsc" id = "dsc" onkeyup = "decimales(this);KeyEnter(this,NewFilaCompra);" value = "0" />
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" onclick = "NewFilaCompra();"><span class="fa fa-plus"></span> <span class="fa fa-shopping-cart"></span></button>
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
					 <iframe id = "IFdetalle" name = "IFdetalle" src="FRMcompra_detalle.php?tipoCompra=C"></iframe>
				</div>
			</div>
	    </div>
	    
	    <!-- /.panel-default -->
	    <div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
                <div class="col-xs-12 text-center">
                    <button type="button" class="btn btn-default" onclick = "LimpiarCompra();"><span class="fa fa-eraser"></span> Limpiar</button>
                    <button type="button" class="btn btn-success" onclick = "ConfirmCompraJS();"><span class="fa fa-dollar"></span> Comprar</button>
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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Select2 -->
	<link href="../assets.3.6.2/css/plugins/select2/select2.min.css" rel="stylesheet">
    <script src="../assets.3.6.2/js/plugins/select2/select2.full.min.js"></script>

     <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/compras/compra.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	<script src="../assets.3.6.2/js/plugins/fullscreen/fullscreen.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$(".select2").select2();
	    });
		
		$(function () {
            $('#fec').datetimepicker({
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