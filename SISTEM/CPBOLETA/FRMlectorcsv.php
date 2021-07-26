<?php
	include_once('xajax_funct_boleta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$periodo_vigente = $_SESSION["periodo"];
	
	$archivo = $_REQUEST["name"];
	$cuenta = $_REQUEST["cue"];
	$banco = $_REQUEST["ban"];
	$banco = ($banco == "")?1:$banco;
	//--
	$desc = $_REQUEST["desc"];
	$desc = ($desc == "")?$archivo:$desc;
	
	//$_POST
	$ClsPer = new ClsPeriodoFiscal();
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_vigente:$pensum;
	
	if($_REQUEST["periodo"] == ""){
		$periodo = $ClsPer->periodo;
	}else{
		$periodo = $_REQUEST["periodo"];
	}
	
	
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
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
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
									<a href="FRMsecciones.php?acc=GPAGO">
										<i class="fa fa-edit"></i> Gestor de Pagos Individuales
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
									<a class="active" href="FRMhistorial_csv.php">
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
				<div class="panel-heading"><i class="fa fa-file-excel-o"></i> Formulario Lector de Archivos .CSV</div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' action='#' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right">
							<h6 class = " text-warning">* Filas con un erorr de digitaci&oacute;n <small>(Codigo de Alumno o No. de Referencia)</small></h6>
							<h6 class = " text-danger">* Filas con doble erorr de digitaci&oacute;n <small>(Codigo de Alumno y No. de Referencia)</small></h6>
							<h6 class = " text-info">* Filas con error de monto <small>(El monto cancelado no coincide con el monto programado)</small></h6>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Periodo Fiscal:</label>
							<?php echo periodo_fiscal_html("periodo","Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("periodo").value = "<?php echo $periodo; ?>";
							</script>
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Banco:</label>
							<?php echo banco_html("ban","Submit();"); ?>
							<input type = "hidden" name = "cod" id = "cod" />
							<input type = "hidden" name = "name" id = "name" value ="<?php echo $archivo; ?>" />
							<script type="text/javascript">
								document.getElementById("ban").value = "<?php echo $banco; ?>";
							</script>
						</div>	
						<div class="col-xs-5">
							<label>Cuenta de Banco:</label>
							<?php
								if($banco != ""){
									echo cuenta_banco_html($banco,"cue","Submit();");
								}else{
									echo combos_vacios("cue");
								}
							?>
							<script type="text/javascript">
								document.getElementById("cue").value = "<?php echo $cuenta; ?>";
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Descripci&oacute;n:</label>
							<input type = "text" class="form-control" name = "desc" id = "desc" value ="<?php echo $desc; ?>" onkeyup="texto(this);" />
						</div>
						<div class="col-xs-5">
							<label>Nombre de Archivo:</label>
							<input type = "text" class="form-control" name = "archivo" id = "archivo" value ="<?php echo $archivo; ?>" readonly />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php
								if($periodo != "" && $cuenta != "" && $banco != ""){
									echo tabla_lectora_csv($archivo,$periodo,$cuenta,$banco);
								}else{
									echo '<h5 class = "alert alert-info text-center"><i class = "fa fa-exclamation-circle"></i> Seleccione el Banco y la Cuenta donde se operar&aacute; la carga... </h5>';
									echo '<input type = "hidden" id = "filas" name = "filas" value = "0" />';
								}
							?>
						</div>
					</div>
					</form>
					<br>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "GrabarPagosCarga();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
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
    
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/carga.js?v=1.1"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100000,
				responsive: true
			});
	    });
		
		var errorgarrafal = parseInt(document.getElementById("errorgarrafal").value);
		if(errorgarrafal > 0){
			//document.getElementById("lblparrafo").innerHTML = '<h5>Error de formato en el archivo .CSV</h5><br><br><button type = "button" class="btn btn-primary" onclick = "cerrar();" ><span class="fa fa-check"></span> Aceptar</a> ';
			document.getElementById("gra").setAttribute("disabled","disabled");
			//alert("Error de formato en el archivo .CSV ...");
			swal('Error','Error de formato en el archivo .CSV ...','error');
		}
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