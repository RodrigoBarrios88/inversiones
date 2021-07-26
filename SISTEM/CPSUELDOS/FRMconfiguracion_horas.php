<?php
	include_once('xajax_funct_sueldos.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	$ClsPla = new ClsPlanilla();
	$dpi = $ClsPla->decrypt($hashkey, $usuario);
	//--
	$dpi = ($dpi != "")?$dpi:$_REQUEST["dpi"];
	$codigo = $_REQUEST["cod"];
	$monto = $_REQUEST["monto"];
	$mon = $_REQUEST["mon"];
	$mon = ($mon != "")?$mon:1;
	$tcambio = $_REQUEST["tcambio"];
	$tcambio = ($tcambio != "")?$tcambio:"1.00";
	$desc = $_REQUEST["desc"];
	
	$ClsPlan = new ClsPlanillaAsignaciones();
	$result = $ClsPlan->get_configuracion_horas($dpi);
	if(is_array($result)){
		foreach($result as $row){
			$nombres = utf8_decode($row["per_nombres"])." ".utf8_decode($row["per_apellidos"]);
			$cantreg = trim($row["conf_cantidad_regulares"]);
			$montoreg = trim($row["conf_monto_regulares"]);
			$cantext = trim($row["conf_cantidad_extras"]);
			$montoext = trim($row["conf_monto_extras"]);
			$moneda = trim($row["conf_moneda"]);
		}	
	}else{
		$ClsPer = new ClsPersonal();
		$result = $ClsPer->get_personal($dpi);
		if(is_array($result)){
			foreach($result as $row){
				$nombres = utf8_decode($row["per_nombres"])." ".utf8_decode($row["per_apellidos"]);
			}
			$cantext = 0;
			$moneda = 1;
		}
	}
	
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
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMtipo_nomina.php">
										<i class="fa fa-file-text-o"></i> T&iacute;po de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMpersonal_planillas.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n a Listados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a class="active" href="FRMlist_personal_configuracion.php?acc=1">
										<i class="fa fa-list"></i> Horas Laborales (Conf.)
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMlist_personal_configuracion.php?acc=1">
										<i class="fa fa-list"></i> Asignaci&oacute;n Bonos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMlist_personal_configuracion.php?acc=2">
										<i class="fa fa-list"></i> Asignaci&oacute;n Descuentos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMnewnomina.php">
										<i class="fa fa-folder-open"></i> Apertura de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMeditnomina.php">
										<i class="fa fa-edit"></i> Edici&oacute;n de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="FRMstatusnomina.php">
										<i class="fa fa-tasks"></i> Status de Nominas
									</a>
                                </li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUadministrativo.php">
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
				<div class="panel-heading"><i class="fa fa-tasks"></i> Configura&oacute;n de Precios en Horas Laborales</div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' action='#' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
						<input type = "hidden" name = "dpi" id = "dpi" value="<?php echo $dpi; ?>" />
						<input type = "hidden" name = "cod" id = "cod" value="<?php echo $codigo; ?>" />
						<input type = "hidden" name = "hashkey" id = "hashkey" value="<?php echo $hashkey; ?>" />
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>DPI:  </label> <span class="text-danger">*</span>
							<label class="form-info"><?php echo $dpi; ?></label>
						</div>
						<div class="col-xs-5">
							<label>Nombres y Apellidos:  </label> <span class="text-danger">*</span>
							<label class="form-info"><?php echo $nombres; ?></label>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Cantidad Promedio de Horas Regulares: </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "cantreg" id = "cantreg" onkeyup = "decimales(this);" value = "<?php echo $cantreg; ?>" />
						</div>
						<div class="col-xs-5">
							<label>Valor por Hora Regular</label> <span class="text-danger">*</span> <small class="text-muted">(Precio)</small>
							<input type = "text" class = "form-control" name = "montoreg" id = "montoreg" onkeyup = "decimales(this);" value = "<?php echo $montoreg; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Cantidad Promedio de Horas Extas: </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "cantext" id = "cantext" onkeyup = "decimales(this);" value = "<?php echo $cantext; ?>" />
						</div>
						<div class="col-xs-5">
							<label>Valor por Hora Extra</label> <span class="text-danger">*</span> <small class="text-muted">(Precio)</small>
							<input type = "text" class = "form-control" name = "montoext" id = "montoext" onkeyup = "decimales(this);" value = "<?php echo $montoext; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Moneda:  </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo moneda_transacciones_html("moneda",""); ?>
							<script type = "text/javascript">
								document.getElementById("moneda").value = '<?php echo $moneda; ?>';
							</script>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "GrabarHoras();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
					</form>
					<br>
				</div>
            </div>
             <!-- /.panel-default -->
		</div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?></h4>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/rrhh/planilla.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
		});
		
		function Tipo_Cambio(){
			mon = document.getElementById("mon");
			tcamb = document.getElementById("tcambio");
			//--
			// manejo del texto del combo moneda
			var montext = mon.options[mon.selectedIndex].text;
			//-- extrae el simbolo de la moneda y tipo de cambio
			var monchunk = montext.split("/");
			var Fmons = monchunk[1]; // Simbolo de Moneda
			var Fmonc = monchunk[2]; // Tipo de Cambio
			Fmonc = Fmonc.replace("(",""); //le quita el primer parentesis que rodea el tipo de cambio
			Fmonc = Fmonc.replace(" x 1)",""); //le quita el 2do. parentesis y el x 1
					//--
			tcamb.value = Fmonc;
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