<?php
	include_once('xajax_funct_boleta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum_vigente = $_SESSION["pensum"];
	//$_POST
	$suc = ($_REQUEST["suc"] != "")?$_REQUEST["suc"]:$empCodigo;
	$pv = $_REQUEST["pv"];
	$serie = $_REQUEST["serie"];
	$numero = $_REQUEST["numero"];
	$referencia = $_REQUEST["boleta"];
	$alumno = $_REQUEST["alumno"];
	
	
if($id != "" && $nombre != ""){ 	
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
									<a href="FRMlista_boleta_facturas.php">
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
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMbusca_factura.php">
										<i class="fa fa-search"></i> Buscar Facturas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a class="active" href="FRMbusca_recibo.php">
										<i class="fa fa-search"></i> Buscar Recibos
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
					<br>
                </div>
				<!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			<br>
            <div class="panel panel-default">
				<div class="panel-heading"><label><i class="fa fa-search"></i> Buscador de Recibibos</label></div>
                <div class="panel-body">
					<form id='f1' name='f1' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Empresa:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Punto de Venta:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo empresa_html("suc","Submit();"); ?>
							<input type = "hidden" name = "hashkey" id = "haskey" value = "<?php echo $hashkey; ?>" />
							<input type = "hidden" name = "carga" id = "carga" value = "<?php echo $carga; ?>" />
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
						<div class="col-xs-5 col-xs-offset-1"><label>Serie del Recibo:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>N&uacute;mero de Recibo:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row" id="lbf2">
						<div class="col-xs-5 col-xs-offset-1">
							<?php
								echo serie_recibo_html("serie","Submit();");
							?>
							<script>
								document.getElementById("serie").value = '<?php echo $serie; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "numero" id = "numero" value = "<?php echo $numero; ?>" onkeyup = "enteros(this);KeyEnter(this,Submit);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>No. Boleta:</label></div>
						<div class="col-xs-5"><label>CUI de Alumno:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type="text" class="form-control" id="boleta" name="boleta" onkeyup="enteros(this);KeyEnter(this,Submit);" value = "<?php echo $referencia; ?>" />
						</div>
						<div class="col-xs-5">
							<input type="text" class="form-control" id="alumno" name="alumno" onkeyup="enteros(this);KeyEnter(this,Submit);" value = "<?php echo $alumno; ?>" maxlength="13" />
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a class="btn btn-default" href = "FRMbusca_recibo.php"><i class="fa fa-eraser"></i> Limpiar</a>
                                <button type="button" class="btn btn-primary" onclick = "Submit();"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
					</form>
					<br>
					<br>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php
								if($suc != ""){
									if($referencia != "" || $alumno != "" || $numero != ""){
										echo tabla_lista_recibos($suc,$ser,$numero,$alumno,$referencia,$carga);
										//echo "$cue,$ban,$alumno,$referencia,$anio";
									}else{
										echo '<h5 class = "alert alert-info text-center">';
										echo '<i class = "fa fa-check-circle"></i> Selecciones un # de recibo, # de boleta o CUI de alumno para filtrar...';
										echo '</h5>';
									}
								}else{
									echo '<h5 class = "alert alert-info text-center">';
									echo '<i class = "fa fa-info-circle"></i> Selecciones el ciclo escolar a filtrar...';
									echo '</h5>';
								}
							?>
						</div>
					</div>
					<br>
				</div>
				<br>
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

    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/boleta.js"></script>
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