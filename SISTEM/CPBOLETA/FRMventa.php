<?php
	include_once('xajax_funct_boleta.php');
	$usuario = $_SESSION["codigo"];
	$nombre_usuario = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$pensum_vigente = $_SESSION["pensum"];
	//$_POST
	$ClsPer = new ClsPeriodoFiscal();
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_vigente:$pensum;
	if($_REQUEST["periodo"] == ""){
		$periodo = $ClsPer->get_periodo_pensum($pensum);
	}else{
		$periodo = $_REQUEST["periodo"];
	}
	
	//$_REQUEST
	$hashkey = $_REQUEST["hashkey"];
	$ClsAsig = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	
	$ban = $_REQUEST["ban"];
	$ban = ($ban != "")?$ban:"1";
	$cue = $_REQUEST["cue"];
	$cue = ($_REQUEST["cue"] != "")?$_REQUEST["cue"]:2;
	$suc = ($_REQUEST["suc"] != "")?$_REQUEST["suc"]:3;
	$pv = ($_REQUEST["pv"] != "")?$_REQUEST["pv"]:1;
	$referencia = $_REQUEST["boleta"];
	
	$fecpago = $_REQUEST["fecpago"];
	$fecboleta = $_REQUEST["fecboleta"];
	//--
	$fecha = date("Y-m-d");
	$fecha = date("d/m/Y");
	$fecha_pago = date("31/12/Y");
	$fecboleta = ($fecboleta == "")?$fecha:$fecboleta;
	$fecpago = ($fecpago == "")?$fecha_pago:$fecpago;
	
	
	
	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
		}
		$alumno = "$nom $ape";
	}
	
	$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = trim($row["niv_descripcion"]);
			$grado = trim($row["gra_descripcion"]);
		}
	}
		
	$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$seccion = trim($row["sec_descripcion"]);
		}
	}
	
if($usuario != "" && $nombre_usuario != ""){ 	
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
	
	<!-- Swal -->
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
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="../CPBOLETAPROGRAMADOR/FRMnewconfiguracion.php">
										<i class="fa fa-check"></i> Configuraciones de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="../CPBOLETAPROGRAMADOR/FRMsecciones.php">
										<i class="fa fa-calendar"></i> Programador de Boletas
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=GBOL">
										<i class="fa fa-edit"></i> Gestor de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a class="active" href="FRMsecciones.php?acc=VENT">
										<i class="fa fa-shopping-cart"></i> Ventas con Boleta de Dep&oacute;sito
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMcarga.php">
										<i class="fa fa-table"></i> Carga Electr&oacute;nica .CSV
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMhistorial_cargas.php">
										<i class="fa fa-table"></i> Historial de Cargas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMhistorial_csv.php">
										<i class="fa fa-file-excel-o"></i> Historial de .CSV
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="../CPBOLETAFACTURAS/FRMlist_cargas.php">
										<i class="fa fa-file-text-o"></i> Facturas y Recibos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
									<li>
										<a href="FRMmoras.php">
											<i class="fa fa-edit"></i> Gestor de Moras
										</a>
									</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=CUE">
										<i class="fa fa-money"></i> Estado de Cuenta
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUcuenta.php">
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
				<div class="panel-heading"><i class="fa fa-shopping-cart"></i> Ventas con Boletas de Pago Dep&oacute;sito</div>
            <div class="panel-body" id = "formulario">
				<form id='f1' name='f1' method='get' action="FRMventa_detalle.php" target="IFdetalle">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Periodo Fiscal:</label>
							<?php echo periodo_fiscal_html("periodo","Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("periodo").value = "<?php echo $periodo; ?>";
							</script>
							<input type="hidden" name = "acc" id = "acc" value="<?php echo $acc; ?>" />
						</div>
						<div class="col-xs-5">
							
						</div>
					</div>
					<br>	
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Alumno:</label></div>
						<div class="col-xs-5"><label>Grado y Secci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label class="form-info"><?php echo $alumno; ?></label>
							<input type="hidden" id="cui" name="cui" value="<?php echo $cui; ?>" />
							<input type="hidden" id="codint" name="codint" value="<?php echo $codalu; ?>" />
							<input type="hidden" id="hashkey" name="hashkey" value="<?php echo $hashkey; ?>" />
						</div>
						<div class="col-xs-5">
							<label class="form-info"><?php echo $grado; ?> SECCI&Oacute;N "<?php echo $seccion; ?>"</label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Fecha de la Boleta:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Fecha de Pago de la Boleta:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="form-group">
								<div class='input-group date'>
									<input type='text' class="form-control" id = "fecboleta" name='fecboleta' value="<?php echo $fecboleta; ?>" />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-xs-5 text-center">
							<div class="form-group">
								<div class='input-group'>
									<input type='text' class="form-control" id = "fecpago" name='fecpago' value="<?php echo $fecpago; ?>" />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>No. Referencia:</label> <small class="text-muted">(no obligatorio, se genera autom&aacute;tico)</small>
							<input type="text" class="form-control" id="referencia" name="referencia" value="<?php echo $referencia; ?>" onkeyup="enteros(this);" />
						</div>
						<div class="col-xs-5">
							<label>Moneda a Facturar:</label> <span class = " text-danger">*</span>
							<?php echo moneda_transacciones_html("Tmon","ExeTipoCambio(this);"); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Punto de Venta:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("suc","Empresa_CajaJS(this.value);"); ?>
							<input type="hidden" id = "carga" name = "carga" value = "0" />
							<script>
								document.getElementById("suc").value = '<?php echo $suc; ?>';
							</script>
						</div>
						<div class="col-xs-5" id = "divpv">
							<?php
								if($suc != ""){
									echo punto_venta_html($suc,"pv","");
								}else{
									echo combos_vacios("pv");
								}
							?>
							<script>
								document.getElementById("pv").value = '<?php echo $pv; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Banco:</label></div>
						<div class="col-xs-5"><label>Cuenta de Banco:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo banco_html("ban","Banco_CuentaJS(this.value);"); ?>
							<script type="text/javascript">
								document.getElementById("ban").value = "<?php echo $ban; ?>";
							</script>
						</div>
						<div class="col-xs-5" id = "divcue">
							<?php
								if($ban != ""){
									echo cuenta_banco_html($ban,"cue","");
								}else{
									echo combos_vacios("cue");
								}
							?>
							<script type="text/javascript">
								document.getElementById("cue").value = "<?php echo $cue; ?>";
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Tipo de Descuento (Factura Global):</label> </div>
						<div class="col-xs-5"><label>Monto del Descuento:</label> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id="tfdsc" name="tfdsc" class = "form-control" onchange= "ExeTipoCambio(document.getElementById('Tmon'));">
								<option value="P">Por Porcerntaje (%)</option>
								<option value="M">Por Monto Monetario (Q.)</option>
							</select>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "fdsc" id = "fdsc" onkeyup = "decimales(this);" onblur = "ExeTipoCambio(document.getElementById('Tmon'));" value = "0" />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="alert alert-info text-center" role="alert"><em>Detalle de Venta</em></div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Codigo de Barras:</label> <span class = " text-info">*</span>&nbsp; <i class="fa fa-barcode"></i></div>
						<div class="col-xs-5"><label id = "cntart">Tipo de Venta:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "barc" id = "barc" onkeyup = "texto(this);KeyEnter(this,Barcode);"  onblur = "Barcode();" />
						</div>
						<div class="col-xs-5">
							<select id = "tip" name = "tip" class = "form-control" onchange = "TipoVenta(this.value)">
								<option value = "P">PRODUCTOS</option>
								<option value = "S">SERVICIOS</option>
								<option value = "O">OTROS</option>
							</select>
						</div>
					</div>
					<div class="row" id = "row1">
						<div class="col-xs-5 col-xs-offset-1"><label>Articulo:</label> <span class = " text-info">*</span></div>
						<div class="col-xs-5"><label id = "cntart">Existencia:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row" id = "row2">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo articulo_transaccion_html('Aart',"Articulo();"); ?>
						</div>
						<div class="col-xs-5">
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
					<div class="row hidden" id = "row3">
						<div class="col-xs-5 col-xs-offset-1"><label id = "cntart">Servicio:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row hidden" id = "row4">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo servicio_transaccion_html('Sart',"Servicio();"); ?>
						</div>
					</div>
					<div class="row hidden"  id = "row5">
						<div class="col-xs-5 col-xs-offset-1"><label>Descripci&oacute;n:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row hidden" id = "row6">
						<div class="col-xs-10 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "desc" id = "desc" onkeyup = "texto(this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Cantidad:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Pr&eacute;cio:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "cant" id = "cant" onkeyup = "enteros(this);KeyEnter(this,NewFilaVenta);" />
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "prev" id = "prev" onkeyup = "decimales(this);KeyEnter(this,NewFilaVenta);" />
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
							<input type = "text" class = "form-control" name = "dsc" id = "dsc" onkeyup = "decimales(this);KeyEnter(this,NewFilaVenta);" value = "0" />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-primary" onclick = "NewFilaVenta();"><span class="fa fa-plus"></span> <span class="fa fa-shopping-cart"></span></button>
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
						<button type="button" class="btn btn-default" onclick = "LimpiarVenta();"><span class="fa fa-eraser"></span> Limpiar</button>
						<button type="button" class="btn btn-success" onclick = "BoletaJS();"><span class="fa fa-list-alt"></span> Generar Boleta</button>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/venta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-recibos').DataTable({
				pageLength: 100,
				responsive: true
			});
			
			$(".select2").select2();
	    });
		
		$(function () {
            $('#fecpago').datetimepicker({
                format: 'DD/MM/YYYY'
            });
			$('#fecboleta').datetimepicker({
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