<?php
	include_once('xajax_funct_bancos.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	
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
										<i class="fa fa-table"></i> Apertura de Cuenta
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GCUEBANCO"] == 1){ ?>
								<li>
									<a href="FRMmodcuenta.php">
										<i class="fa fa-edit"></i> Actualizaci&oacute;n de Datos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CUECONCIL"] == 1){ ?>
								<li>
									<a href="FRMsaldo.php">
										<i class="fa fa-money"></i> Saldo
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["INCUEBANCO"] == 1){ ?>
								<li>
									<a href="FRMcueingreso.php">
										<i class="fa fa-sign-in"></i> Depositos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["OUTCUEBANCO"] == 1){ ?>
								<li>
									<a href="FRMcueegreso.php">
										<i class="fa fa-sign-out"></i> Egresos o Retiros
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCHEQUE"] == 1){ ?>
								<li>
									<a href="FRMcheque.php">
										<i class="fa fa-suitcase"></i> Cheques
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CUECONCIL"] == 1){ ?>
								<li>
									<a href="FRMconcilia.php">
										<i class="glyphicon glyphicon-print"></i> Conciliaci&oacute;n Bancaria
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
				<div class="panel-heading"><label><i class="fa fa-table"></i> Apertura de Cuentas Bancarias</label></div>
                <div class="panel-body" id = "formulario">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Banco:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Empresa o Entidad:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo banco_html("ban"); ?>
						</div>
						<div class="col-xs-5">
							<?php echo empresa_html("suc",""); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>No. de Cuenta:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Tipo de Cuenta:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "num" id = "num" onkeyup = "enteros(this);" />
						</div>
						<div class="col-xs-5">
							<?php echo tipo_cuenta_html("tip"); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Nombre o Descripci&oacute;n:</label> <span class = "text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "nom" id = "nom" onkeyup = "texto(this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Pago Intereses:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Tasa:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id = "fpag" name = "fpag" class = "form-control">
								<option value = "NA">NO APLICA</option>
								<option value = "A">ANUAL</option>
								<option value = "S">SEMESTRAL</option>
								<option value = "T">TRIMESTRAL</option>
								<option value = "M">MENSUAL</option>
								<option value = "Q">QUINCENAL</option>
							</select>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "tasa" id = "tasa" onkeyup = "decimales(this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Plazo <small>(en d&iacute;as)</small>:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Fecha de Inicio de Inversi&oacute;n o Apertura:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "dias" id = "dias" onkeyup = "decimales(this);" />
						</div>
						<div class="col-xs-5">
							<div class="form-group">
								<div class='input-group date' id='fec'>
									<input type='text' class="form-control" id = "fini" name='fini' value="<?php echo date("d/m/Y"); ?>" />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Moneda:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Monto de Apertura: </label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo moneda_html("mon"); ?>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "monto" id = "monto" onkeyup = "decimales(this)" />
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
                            <button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
                        </div>
                    </div>
					<br><hr>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php echo tabla_cuenta_banco($cod,$ban,$num,$tip,$mon,$pai,$sit,""); ?>
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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/bancos/bancuenta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
	    });
	
		$(function () {
            $('#fini').datetimepicker({
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