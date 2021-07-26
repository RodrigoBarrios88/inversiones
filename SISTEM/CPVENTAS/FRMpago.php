<?php
	include_once('xajax_funct_ventas.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPCONTA"];
	// $_POST
	$vent = $_REQUEST["vent"];
	$ventC = $_REQUEST["ventC"];
	$serie = $_REQUEST["serie"];
	$facc  = $_REQUEST["facc"];
	$cli  = $_REQUEST["cli"];
	$nit  = $_REQUEST["nit"];
	$nom  = $_REQUEST["nom"];
	
	$ClsFac = new ClsFactura();
	$ClsVent = new ClsVenta();
	$ClsCred = new ClsCredito();
   
	if($vent != "" || $cli){
		$result = $ClsVent->get_venta($vent,$cli);
	}else if($serie != "" && $facc != ""){
		$result = $ClsFac->get_factura($facc,$serie,$vent);
	}
	if(is_array($result)){
		$ventas = 0;
		foreach($result as $row){
			$ventC = trim($row["ven_codigo"]);
			$empresa = trim($row["ven_sucursal"]);
			$vent = trim($row["ven_codigo"]);
			$vent = Agrega_Ceros($vent);
			$serie = trim($row["fac_serie"]);
			$facc = trim($row["fac_numero"]);
			$factotal = trim($row["ven_total"]);
			$monid = trim($row["mon_id"]);
			$montext = trim($row["mon_desc"]);
			$tcambio = trim($row["mon_cambio"]);
			$monsimbolo = trim($row["mon_simbolo"]);
			$ventas++;
		}
		$credtotal = $ClsCred->total_credito_venta($vent,$tcambio); //pregunta por los creditos que tiene esa venta
		$ventC = ($ventas > 1)?"":$ventC;
		$credtotal = ($ventas > 1)?"":$credtotal;
	}
	
	if($vent != ""){
    	$ClsPag = new ClsPago();
    	$result = $ClsPag->get_pago_venta("",$vent);
    	$montototal = 0;
    	if(is_array($result)){
    		foreach($result as $row){
    			//monto
    			$mont = $row["pag_monto"];
    			$mons = $row["mon_simbolo"];
    			$moncamb = $row["mon_cambio"];
    			//acumulado
    			$Dcambiar = Cambio_Moneda($moncamb,$tcambio,$mont);
    			$montototal += $Dcambiar;
    		}
    	}
    	$saldo = $factotal - $montototal;
    	$saldo0 = ($saldo == 0)?true:false;
	}
	
if($pensum != "" && $nombre != ""){ 
if($valida == 1){ 	
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
				<div class="panel-heading"><label><i class="fa fa-money"></i> Pago de Ventas y Cuentas pendientes</label></div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label># Venta o Transacci&oacute;n: <span class = " text-info">*</span></label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "vent" id = "vent" value = "<?php echo $vent; ?>" onkeyup = "enteros(this);KeyEnter(this,Submit);" />
							<input type = "hidden" name = "ventC" id = "ventC" value = "<?php echo $ventC; ?>" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Serie: <span class = " text-info">*</span></label></div>
						<div class="col-xs-5"><label>No. de Factura: <span class = " text-info">*</span></label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo serie_html("serie",""); ?>
							<script>
								document.getElementById("serie").value = '<?php echo $serie; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "facc" id = "facc" value = "<?php echo $facc; ?>" onkeyup = "enteros(this);KeyEnter(this,Submit);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Nit:</label> <span class = " text-danger">*</span> <span class = " text-info">*</span></div>
						<div class="col-xs-5"><label>Cliente:</label> <span class = " text-danger">*</span> <span class = " text-info">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
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
							<div class='input-group'>
								<input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>" readonly />
								<span class="input-group-addon" style="cursor:pointer" onclick = "ResetCli();" >
									<span class="fa fa-refresh"></span>
								</span>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
							<a type="button" class="btn btn-default" href = "FRMpago.php"><span class="fa fa-eraser"></span> Limpiar</a>
                            <button type="button" class="btn btn-primary" onclick = "Submit();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                        </div>
                    </div>
				<?php if($vent != "" && $ventC != "" && $ventas == 1 && $saldo0 === false){ ?>
					<div class="row">
						<hr>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Punto de Venta:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("suc","xajax_SucPuntVnt(this.value,'pv');"); ?>
							<input type = "hidden" name = "sucX" id = "sucX" value = "<?php echo $empresa; ?>" />
						</div>
						<div class="col-xs-5" id = "spv">
							<?php
								if($empresa != ""){
									echo punto_venta_html($empresa,"pv");
								}else{
									echo combo_vacio("pv");
								}
							?>
						</div>
						<script>
							document.getElementById("suc").value = '<?php echo $empresa; ?>';
							document.getElementById("pv").value = '1';
						</script>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-4 col-xs-offset-4 text-center">
                            <table class="table table-striped table-bordered">
                                <tr>
									<th class = "text-center alert alert-info" colspan = "2"><span>Forma de Pago</span></th>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "PromtPagoJS(1);"><strong>Efectivo</strong></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "PromtPagoJS(1);">
											<span id = "spanpago1"> 0 </span>
											<input type = "hidden" name = "Pag1" id = "Pag1" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "PromtPagoJS(2);"><strong>Tarjeta</strong></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "PromtPagoJS(2);">
											<sapn id = "spanpago2"> 0 </sapn>
											<input type = "hidden" name = "Pag2" id = "Pag2" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "PromtPagoJS(4);"><strong>Cheque</strong></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "PromtPagoJS(4);">
											<span id = "spanpago4"> 0 </span>
											<input type = "hidden" name = "Pag4" id = "Pag4" value = "0" />
										</a>
									</td>
								</tr>
								<tr>
									<td><a href="javascript:void(0);" onclick = "PromtPagoJS(6);"><strong>Deposito</strong></a></td>
									<td class = "text-center">
										<a href="javascript:void(0);" onclick = "PromtPagoJS(6);">
											<span id = "spanpago6"> 0 </span>
											<input type = "hidden" name = "Pag6" id = "Pag6" value = "0" />
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
                        </div>
                    </div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <a type="button" class="btn btn-default" href = "FRMpago.php"><span class="fa fa-times"></span> Cancelar</a>
							<button type="button" class="btn btn-success" onclick = "ConfirmPagoJS();"><span class="fa fa-money"></span> Pagar</button>
						</div>
                    </div>
				<?php } ?>
					</form>
					<br>
					<div class="row">
						<div class="col-lg-12" >
							<h5 class = "text-center alert alert-info">Informaci&oacute;n del Cr&eacute;dito</h5>
							<?php
								if($vent != "" && $ventC != "" && $ventas == 1){
									echo tabla_creditos($vent,$montext,$tcambio,$monsimbolo,$saldo0);
								}else if($ventas > 1){
									echo tabla_lista_ventas($result);
								}
							?>
							<h5 class = "text-center alert alert-success">Resumen de Pagos</h5>
							<?php
								if($vent != "" && $ventC != "" && $ventas == 1){
									echo tabla_pagos($vent,$factotal,$credtotal,$monid,$montext,$tcambio,$monsimbolo);
								}
							?>
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
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/ventas/venta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>


</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../menu.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
} 
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>