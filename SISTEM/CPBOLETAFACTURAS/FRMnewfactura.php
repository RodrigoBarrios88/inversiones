<?php
	include_once('xajax_funct_boleta.php');
	$usuario = $_SESSION["codigo"];
	$nombre_usuario = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$pensum = $_SESSION["pensum"];
	$mon = $_SESSION["moneda"];
	//--
	$ClsFac = new ClsFactura();
	$ClsBol = new ClsBoletaCobro();
	$ClsAcadem = new ClsAcademico();
	$ClsCli = new ClsCliente();
	$hashkey = $_REQUEST["hashkey"];
	$codigo = $ClsBol->decrypt($hashkey, $usuario);
	
	$result = $ClsBol->get_pago_boleta_cobro($codigo);
	if(is_array($result)){
		foreach($result as $row){
			//Codigo de pago
			$codpago = $row["pag_codigo"];
			//boleta
			$referencia = $row["pag_referencia"];
			//monto
			$monto = number_format(($row["pag_efectivo"] + $row["pag_cheques_propios"] + $row["pag_otros_bancos"] + $row["pag_online"]),2,'.','');
			//motivo
			$motivo = utf8_decode($row["bol_motivo"]);
			//cuenta
			$cliente = $row["alu_nit"];
			//alumno
			$cui = $row["pag_alumno"];
			$alumno = utf8_decode($row["alu_nombre_completo"]);
			//Fecha de Pago
			$fecha = $row["pag_fechor"];
			$fecha = cambia_fechaHora($fecha);
			//$fecha = substr($fecha,0,10);
		}	
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
	
	if(strlen($cliente)>0){
		$result = $ClsCli->get_cliente('',$cliente);
		if(is_array($result)){
			foreach($result as $row){
				$nit = $row["cli_nit"];
				$clinombre = $row["cli_nombre"];
			}
		}
	}
	
	///$_POST
	$suc = ($_REQUEST["suc"] != "")?$_REQUEST["suc"]:$empCodigo;
	$pv = ($_REQUEST["pv"] != "")?$_REQUEST["pv"]:1;
	$serie = ($_REQUEST["serie"] != "")?$_REQUEST["serie"]:1;
	
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
    
    <!-- Bootstrap Core CSS -->
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
	
	
	<!-- Calendarios -->
    <link href="../assets.3.6.2/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css">
	<script src="../assets.3.6.2/js/dhtmlgoodies_calendar.js" type="text/javascript"></script>

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
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMsecciones.php?acc=GBOL">
										<i class="fa fa-edit"></i> Gestor de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMsecciones.php?acc=GPAGO">
										<i class="fa fa-edit"></i> Gestor de Pagos Individuales
									</a>
								</li>
								<?php } ?>
								<hr>
                                <?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlist_cargas.php">
										<i class="fa fa-file-text-o"></i> Facturas y Recibos por Cargas <i class="fa fa-table"></i>
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a class="active" href="FRMlista_boleta_facturas.php">
										<i class="fa fa-file-text-o"></i> Generador de Factura Individual
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlista_boleta_recibos.php">
										<i class="fa fa-file-text-o"></i> Generador de Recibo Individual
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php">
										<i class="fa fa-file-text-o"></i> Facturas y Recibos ya Generados
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlista_facturas.php">
										<i class="fa fa-edit"></i> Edici&oacute;n de Factura Individual
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlista_recibos.php">
										<i class="fa fa-edit"></i> Edici&oacute;n de Recibo Individual
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMsecciones.php?acc=CUE">
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
				<div class="panel-heading"><label class="text-info"><i class="fa fa-file-text-o"></i> Gestor de Facturas Derivadas de Boletas de Pago </label></div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Alumno:</label></div>
						<div class="col-xs-5"><label>Grado y Secci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label class="form-info"><?php echo $alumno; ?></label>
							<input type="hidden" id="codpago" name="codpago" value="<?php echo $codpago; ?>" />
							<input type="hidden" id="cui" name="cui" value="<?php echo $cui; ?>" />
							<input type="hidden" id="codint" name="codint" value="<?php echo $codalu; ?>" />
							<input type="hidden" id="hashkey" name="hashkey" value="<?php echo $hashkey; ?>" />
						</div>
						<div class="col-xs-5">
							<label class="form-info"><?php echo $grado; ?> SECCI&Oacute;N "<?php echo $seccion; ?>"</label>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Fecha de la Factura:</label></div>
						<div class="col-xs-5"><label>Fecha de Pago de la Boleta:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="form-group">
								<div class='input-group date'>
									<input type='text' class="form-control" id = "fecha" name='fecha' value="<?php echo date("d/m/Y"); ?>" />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-xs-5 text-center">
							<div class="form-group">
								<div class='input-group'>
									<input type='text' class="form-control" id = "fecpag" name='fecpag' value="<?php echo $fecha; ?>" disabled />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Punto de Venta:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("suc","Submit();"); ?>
							<input type="hidden" id = "carga" name = "carga" value = "0" />
							<script>
								document.getElementById("suc").value = '<?php echo $suc; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<?php
								if($suc != ""){
									echo punto_venta_html($suc,"pv","Submit();");
								}else{
									echo combos_vacios("pv");
								}
							?>
							<script>
								document.getElementById("pv").value = '<?php echo $pv; ?>';
							</script>
						</div>
					</div>
					<div class="row" id="lbf1">
						<div class="col-xs-5 col-xs-offset-1"><label>Serie de Factura:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>N&uacute;mero de Factura:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row" id="lbf2">
						<div class="col-xs-5 col-xs-offset-1">
							<?php
								echo serie_html("serie","Submit();");
							?>
							<script>
								document.getElementById("serie").value = '<?php echo $serie; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<?php
								if($suc != '' && $pv != '' && $serie != ''){	
									$facc = $ClsFac->max_factura_base($suc,$pv,$serie);
								}else{
									$facc = "";
								}
							?>
							<input type = "text" class = "form-control" name = "facc" id = "facc" value = "<?php echo $facc; ?>" onkeyup = "enteros(this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Moneda a Facturar:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Descripci&oacute;n:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo moneda_transacciones_html("mon",""); ?>
							<script>
								document.getElementById("mon").value = '<?php echo $mon; ?>';
								document.getElementById("mon").setAttribute("disabled","disabled");
							</script>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "desc" id = "desc" value = "<?php echo $motivo; ?>"  onkeyup = "texto(this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>No. Boleta:</label></div>
						<div class="col-xs-5"><label>Monto:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "boleta" id = "boleta" value = "<?php echo $referencia; ?>" disabled />
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "monto" id = "monto" value = "<?php echo $monto; ?>" disabled />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Cliente (NIT):</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Cliente (Nombre):</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class='input-group date'>
								<input type = "text" class = "form-control" name = "nit" id = "nit"  value = "<?php echo $nit; ?>" onkeyup = "texto(this);" onblur = "Cliente('');" />
								<input type = "hidden" name = "cli" id = "cli" value = "<?php echo $cliente; ?>" />
								<input type = "hidden" name = "filaalumno" id = "filaalumno" />
								<span class="input-group-addon" onclick = "SearchCliente('');" >
									<span class="fa fa-search"></span> 
								</span>
							</div>
						</div>	
						<div class="col-xs-5">
							<div class='input-group date'>
								<input type="text" class="form-control" name = "cliente" id = "cliente" value = "<?php echo $clinombre; ?>" readonly />
								<span class="input-group-addon" onclick = "ResetCli('');" >
									<span class="fa fa-refresh"></span>
								</span>
							</div>
						</div>	
					</div>
					<br>
					<div class="row">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
                                <button type="button" class="btn btn-primary" id = "grab" onclick = "GrabarFactura();"><span class="fa fa-save"></span> Grabar</button>
                            </div>
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
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/facturacion.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-facturas').DataTable({
				pageLength: 100,
				responsive: true
			});
	    });
		
		$(function () {
            $('#fecha').datetimepicker({
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