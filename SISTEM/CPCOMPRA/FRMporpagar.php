<?php
	include_once('xajax_funct_compra.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//$_Post
	$suc = $_REQUEST["suc"];
	$class = $_REQUEST["class"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	$desde = ($desde == "")?date("d/m/Y"):$desde;
	$hasta = ($hasta == "")?date("d/m/Y"):$hasta;
	//--
	$sit = $_REQUEST["sit"];
	
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
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			<br>
            <div class="panel panel-default">
				<div class="panel-heading"><label><i class="fa fa-sort-numeric-desc"></i> Cr&eacute;ditos por Pagar</label></div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label></div>
						<div class="col-xs-5"><label>Clasificaci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("suc","xajax_SucPuntVnt(this.value,'pv','spv');"); ?>
							<input type = "hidden" name = "cod" id = "cod" />
							<script type="text/javascript">
								document.getElementById("suc").value = "<?php echo $suc; ?>";
							</script>
						</div>	
						<div class="col-xs-5">
							<select id = "class" name = "class" class = "form-control">
								<option value = "">Seleccione</option>
								<option value = "C">COMPRA</option>
								<option value = "G">GASTO</option>
							</select>
							<script type="text/javascript">
								document.getElementById("class").value = "<?php echo $class; ?>";
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Situaci&oacute;n:</label></div>
						<div class="col-xs-5"></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id="sit" class="form-control" name="sit">
								<option value="2">PAGADA</option>
								<option value="1">PENDIENTE DE PAGO</option>
								<option value="0">ANULADA</option>
							</select>
						</div>
						<div class="col-xs-5">
							<script type="text/javascript">
								document.getElementById("sit").value = "<?php echo $sit; ?>";
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
					</form>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <a type="button" class="btn btn-default" href = "FRMporpagar.php"><span class="fa fa-eraser"></span> Limpiar</a>
                            <button type="button" class="btn btn-primary" onclick = "Submit();"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                        </div>
                    </div>
					<br>
				</div>
            </div>
	    <!-- /.panel-default -->
			<br>
			<div class="row">
				<div class="col-lg-12" id = "result">
					<h5 class = "text-center alert alert-info">Cr&eacute;ditos por Pagar</h5>
					<?php
						if($desde != "" && $hasta != ""){
							echo tabla_creditos_x_pagar("",$class,$suc,$doc,$desde,$hasta);
						}
					?>
				</div>
			</div>
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
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/compras/compra.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 50,
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