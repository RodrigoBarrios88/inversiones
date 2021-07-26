<?php
	include_once('xajax_funct_boleta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$empresa = $_REQUEST["empresa"];
	$cue = $_REQUEST["cue"];
	$ban = $_REQUEST["ban"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$pagado = $_REQUEST["pagado"];
	$grupo = $_REQUEST["grupo"];
	//--
	
if($pensum != "" && $nombre != ""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	  <?php
		  //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		  $xajax->printJavascript("..");
		?>
	  <link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	
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
							<li class="active" >
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
										<a href="FRMhistorial_csv.php">
											<i class="fa fa-file-excel-o"></i> Historial de .CSV
										</a>
									</li>
									<?php } ?>
									<hr>
									<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
									<li>
										<a href="FRMmora.php">
											<i class="fa fa-clock-o"></i> Registro de Moras
										</a>  
									</li>
									<?php } ?>
									<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
									<li>
										<a class="active" href="FRMmoras.php">
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
			<div class="panel-heading"><i class="fa fa-clock-o"></i> <i class="fa fa-edit"></i> Gestor de Moras</div>
         <div class="panel-body">
				<div class="row">
					<div class="col-lg-5 col-lg-offset-1 col-xs-12 text-left">
						<button type="button" class="btn btn-defaultbtn-xs text-info" onclick="window.history.back();"><i class="fa fa-arrow-left"></i>  Atras</button>
					</div>
					<div class="col-lg-6 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<label class="text-info">Alumno:</label>
						<input type="text" class="form-info" id="nombre" name="nombre" readonly />
						<input type="hidden" id="cui" name="cui" />
						<input type="hidden" id="codint" name="codint" />
						<input type="hidden" id="anio" name="anio" value="<?php echo $anio; ?>" />
					</div>
					<div class="col-xs-5">
						<label class="text-info">Grado y Secci&oacute;n:</label>
						<input type="text" class="form-info" id="grasec" name="grasec" readonly />
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1"><label>Banco:</label></div>
					<div class="col-xs-5"><label>Cuenta de Banco:</label></div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<?php echo banco_html("ban","Submit();"); ?>
						<input type = "hidden" name = "cod" id = "cod" />
						<script type="text/javascript">
							document.getElementById("ban").value = "<?php echo $ban; ?>";
						</script>
					</div>
					<div class="col-xs-5" id = "scue">
						<?php
							if($ban != ""){
								echo cuenta_banco_html($ban,"cue","Submit();");
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
					<div class="col-xs-5 col-xs-offset-1">
						<label>No. Boleta:</label>
						<input type="text" class="form-control" id="boleta" name="boleta" onkeyup="enteros(this);" />
					</div>
					<div class="col-xs-5">
						<label>Fecha:</label>
						<div class="form-group">
							<div class='input-group date' id='fec'>
								<input type='text' class="form-control" id = "fecha" name='fecha' />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-5 col-xs-offset-1">
						<label>Tipo de Boleta:</label>
						<select class="form-control" id="tipo" name="tipo">
							<option value = "C">Cargos Regulares Programados</option>
							<option value = "M">Mora</option>
						</select>
					</div>
					<div class="col-xs-5">
						<label>Monto:</label>
						<input type="text" class="form-control" id="monto" name="monto" onkeyup="decimales(this);" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1"><label>Motivo:</label></div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<input type="text" class="form-control" id="motivo" name="motivo" onkeyup="texto(this);" />
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-3 col-xs-offset-1"><label>Tipo de Descuento:</label> <span class="text-danger">*</span></div>
					<div class="col-xs-2"><label>Descuento:</label> <span class="text-danger">*</span></div>
					<div class="col-xs-5"><label>Justificaci&oacute;n del Descuento:</label> </div>
				</div>
				<div class="row">
					<div class="col-xs-3 col-xs-offset-1">
						<select class="form-control" id="tipodesc" name="tipodesc">
							<option value = "M" selected >Monto (Q.)</option>
							<option value = "P">Porcentaje (%)</option>
						</select>
						<script type="text/javascript">
							document.getElementById("tipodesc").value = "<?php echo $tipodesc; ?>";
						</script>
					</div>
					<div class="col-xs-2">
						<input type="text" class="form-control" id="desc" name="desc" onkeyup="decimales(this);" value = "<?php echo $desc; ?>" maxlength = "6" />
					</div>
					<div class="col-xs-5">
						<input type="text" class="form-control" id="motdesc" name="motdesc" onkeyup="texto(this);" value = "<?php echo $motdesc; ?>" />
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-default" title="Limpiar" onclick = "window.location.reload();"><span class="fa fa-eraser"></span> Limpiar</button>
						<button type="button" class="btn btn-primary" id = "mod" onclick = "ModificarBoleta();"><span class="glyphicon glyphicon-floppy-disk"></span> Modificar</button>
					</div>
				</div>
			</div>
		</div>
	   <!-- /.panel-default -->
	   <br>
		<div class="row">
		<?php
			echo tabla_gestor_moras($cue,$ban,$empresa,$nivel,$grado,$seccion,$pagado,$grupo);
		?>
		</div>
	</div>
	<!-- /#page-wrapper -->

   <!-- //////////////////////////////////////////////////////// -->
   <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
				<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" width = "60px;" /> ASMS</h4>
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

   <!-- Custom Theme JavaScript -->
   <script src="../dist/js/sb-admin-2.js"></script>
		
	<!-- DataTables JavaScript -->
   <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>

   <!-- Custom Theme JavaScript -->
   <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
   <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/boleta.js"></script>
   <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

   <!-- Page-Level Demo Scripts - Tables - Use for reference -->
   <script>
        $(document).ready(function(){
           $('#dataTables-example').DataTable({
                pageLength: 100,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });
		  
		  $(function () {
            $('#fecha').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
   </script>

	</div>
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
