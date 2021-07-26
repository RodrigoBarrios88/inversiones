<?php
	include_once('html_fns_reportes.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//$_Post
	$suc = $_REQUEST["suc"];
	$pv = $_REQUEST["pv"];
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
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
	
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
                                <?php if($_SESSION["GPV"] == 1){ ?>
                                <li>
									<a href="../FRMpv.php">
										<i class="fa fa-credit-card"></i> Puntos de Venta
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["SALDOPV"] == 1){ ?>
								<li>
									<a href="../FRMsaldo.php">
										<i class="fa fa-money"></i> Saldo
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["INPV"] == 1){ ?>
								<li>
									<a href="../FRMpvingreso.php">
										<i class="fa fa-sign-in"></i> Ingresos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["OUTPV"] == 1){ ?>
								<li>
									<a href="../FRMpvegreso.php">
										<i class="fa fa-sign-out"></i> Retiros o Egresos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["SALDOPV"] == 1){ ?>
								<li>
									<a href="../FRMpvconcilia.php">
										<i class="fa fa-file-text-o "></i> Movimientos del P.V.
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["SALDOPV"] == 1){ ?>
								<li>
									<a href="FRMsaldos.php">
										<i class="fa fa-print"></i> Reporte de Saldos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["SALDOPV"] == 1){ ?>
								<li>
									<a href="FRMmovimiento.php">
										<i class="fa fa-print"></i> Reporte de Movimientos
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
				<div class="panel-heading"><label><i class="fa fa-print"></i> Cajas Monetarias (Movimientos de Caja)</label></div>
                <div class="panel-body" id = "formulario">
					<form name = "f1" id = "f1" method="get">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label></div>
						<div class="col-xs-5"><label>Punto de Venta:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("suc","Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("suc").value = "<?php echo $suc; ?>";
							</script>
						</div>	
						<div class="col-xs-5" id = "spv">
							<?php
								if($suc != ""){
									echo punto_venta_html($suc,"pv","");
								}else{
									echo combos_vacios("pv");
								}
							?>
						</div>
						<script type="text/javascript">
							document.getElementById("pv").value = "<?php echo $pv; ?>";
						</script>
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
					</form>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" onclick = "Reporte();"><span class="glyphicon glyphicon-search"></span> Buscar</button> 
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
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
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
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/finanzas/pventa.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Reporte(){
			pv = document.getElementById("pv");
			suc = document.getElementById("suc");
			if(pv.value !== "" && suc.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="REPmovimiento.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				abrir();
				if(pv.value ===""){
					pv.className = "form-control alert-info";
				}else{
					pv.className = "form-control";
				}
				if(suc.value ===""){
					suc.className = "form-control alert-info";
				}else{
					suc.className = "form-control";
				}
				msj = '<h5>Debe seleccionar la Empresa y el Punto de Venta a consultar...</h5><br><br>';
				msj+= '<button type="button" class="btn btn-primary" onclick = "cerrar()" ><span class="fa fa-check"></span> Aceptar</button> ';
				document.getElementById('lblparrafo').innerHTML = msj;
			}
		}
	
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