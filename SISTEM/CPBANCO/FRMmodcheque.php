<?php
	include_once('xajax_funct_bancos.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_Post
	$ban = $_REQUEST["ban"];
	$cue = $_REQUEST["cue"];
	$fini = $_REQUEST["fini"];
	$ffin = $_REQUEST["ffin"];
	
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
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($_SESSION["GBANCO"] == 1){ ?>
								<li>
									<a href="FRMbanco.php">
										<i class="fa fa-bank"></i> Gestor de Bancos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GCUEBANCO"] == 1){ ?>
								<li>
									<a href="FRMcuenta.php">
										<i class="fa fa-table"></i> Cuentas Bancarias
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCHEQUE"] == 1){ ?>
								<li>
									<a href="FRMcheque.php">
										<i class="fa fa-money"></i> Nuevo Cheque
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCHEQUE"] == 1){ ?>
								<li>
									<a href="FRMmodcheque.php">
										<i class="fa fa-edit"></i> Modificar Datos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["SITCHECQUE"] == 1){ ?>
								<li>
									<a href="FRMexecheque.php">
										<i class="fa fa-check"></i> Ejecutar Montos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["REPCHEQUE"] == 1){ ?>
								<li>
									<a href="FRMhistcheque.php">
										<i class="fa fa-history"></i> Historial de Cheques
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPCHEQUE"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMlistcheque.php">
										<i class="fa fa-print"></i> Reporte de Cheques
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
				<div class="panel-heading"><label><i class="fa fa-edit"></i> Modificaci&oacute;n de Datos de Cheques</label></div>
                <div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Obligatorios</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Banco:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Cuenta de Banco:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo banco_html("ban","xajax_Combo_Cuenta_Banco(this.value,'cue','scue','');"); ?>
							<input type = "hidden" name = "cod" id = "cod" />
							<script type="text/javascript">
								document.getElementById("ban").value = "<?php echo $ban; ?>";
							</script>
						</div>	
						<div class="col-xs-5" id = "scue">
							<?php
								if($ban != ""){
									echo cuenta_banco_html($ban,"cue","");
								}else{
									echo combos_vacios("cue");
								}
							?>
						</div>
						<script type="text/javascript">
							document.getElementById("cue").value = "<?php echo $cue; ?>";
						</script>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>No. de Cheque:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Monto:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "num" id = "num" onkeyup = "enteros(this)" />
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "monto" id = "monto" onkeyup = "decimales(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1"><label>Paguese a:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "quien" id = "quien" onkeyup = "texto(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1"><label>Por concepto de:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "concept" id = "concept" onkeyup = "texto(this)" />
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
                            <button type="button" class="btn btn-primary" id = "gra" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
                        </div>
                    </div>
					<br>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php echo tabla_cheques($cod,$cue,$ban,$num,$quien,$fini,$ffin,1); ?>
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
		<h4 class="modal-title" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/bancos/cheque.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
			responsive: true
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