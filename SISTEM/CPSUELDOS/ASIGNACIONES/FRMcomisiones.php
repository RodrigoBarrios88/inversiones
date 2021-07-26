<?php
	include_once('xajax_funct_asignaciones.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$hashkey1 = $_REQUEST["hashkey1"];
	$hashkey2 = $_REQUEST["hashkey2"];
	$ClsPla = new ClsPlanilla();
	$nomina = $ClsPla->decrypt($hashkey1, $usuario);
	$dpi = $ClsPla->decrypt($hashkey2, $usuario);
	//--
	$dpi = ($dpi != "")?$dpi:$_REQUEST["dpi"];
	$codigo = $_REQUEST["cod"];
	$monto = $_REQUEST["monto"];
	$mon = $_REQUEST["mon"];
	$mon = ($mon != "")?$mon:1;
	$tcambio = $_REQUEST["tcambio"];
	$tcambio = ($tcambio != "")?$tcambio:"1.00";
	$desc = $_REQUEST["desc"];
	
	$ClsPer = new ClsPersonal();
	$result = $ClsPer->get_personal($dpi);
	if(is_array($result)){
		foreach($result as $row){
			$nombres = utf8_decode($row["per_nombres"])." ".utf8_decode($row["per_apellidos"]);
		}	
	}
	
	$result = $ClsPla->get_nomina($nomina,'','');
	foreach($result as $row){
		$tipo = trim($row["nom_tipo"]);
		$sit = trim($row["nom_situacion"]);
	}
	if($sit != 1){
		echo "<script>window.close();</script>";
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
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
	<?php
	   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
	   $xajax->printJavascript("../..");
	 ?>	
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
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 	 	
	
	<!-- Custom CSS -->
	<link href="../../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	<link href="../../assets.3.6.2/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
	
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
                <?php echo $_SESSION["rotulos_colegio_subpantalla"]; ?>
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
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="../FRMtipo_nomina.php">
										<i class="fa fa-file-text-o"></i> T&iacute;po de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="../FRMpersonal_planillas.php">
										<i class="fa fa-link"></i> Asignaci&oacute;n a Listados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="../FRMlist_personal_configuracion.php?acc=1">
										<i class="fa fa-list"></i> Asignaci&oacute;n Bonos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="../FRMlist_personal_configuracion.php?acc=2">
										<i class="fa fa-list"></i> Asignaci&oacute;n Descuentos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="../FRMnewnomina.php">
										<i class="fa fa-folder-open"></i> Apertura de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="../FRMeditnomina.php">
										<i class="fa fa-edit"></i> Edici&oacute;n de Nominas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["PLANILLA"] == 1){ ?>
                                <li>
									<a href="javascript:void(0);" onclick="window.history.back();">
										<i class="fa fa-tasks"></i> Status de Nominas
									</a>
                                </li>
								<?php } ?>
								<hr>
								<li>
									<a href="../../CPMENU/MENUadministrativo.php">
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
				<div class="panel-heading"><label>Asignaci&oacute;n de Comisiones para la Nomina # <?php echo $nomina; ?></label></div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' action='#' method='get'>
					<div class="row">
						<div class="col-xs-6">
							<a class="btn btn-default" href="javascript:void(0);" onclick="window.history.back();" title="Regresar"><i class="fa fa-chevron-left"></i> &nbsp; Atras</a>
						</div>
						<div class="col-xs-6 text-right text-danger">* Campos Obligatorios</div>
						<input type = "hidden" name = "dpi" id = "dpi" value="<?php echo $dpi; ?>" />
						<input type = "hidden" name = "nomina" id = "nomina" value="<?php echo $nomina; ?>" />
						<input type = "hidden" name = "cod" id = "cod" value="<?php echo $codigo; ?>" />
						<input type = "hidden" name = "hashkey1" id = "hashkey1" value="<?php echo $hashkey1; ?>" />
						<input type = "hidden" name = "hashkey2" id = "hashkey2" value="<?php echo $hashkey2; ?>" />
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-1"><label>DPI:  </label> <span class="text-danger">*</span></div>
						<div class="col-xs-5"><label>Nombres y Apellidos:  </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-1"><label class="text-info"><?php echo $dpi; ?></label></div>
						<div class="col-xs-5"><label class="text-info"><?php echo $nombres; ?></label></div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-1"><label>Monto:  </label> <span class="text-danger">*</span></div>
						<div class="col-xs-3"><label>Moneda:  </label> <span class="text-danger">*</span></div>
						<div class="col-xs-3"><label>Tipo de Cambio:  </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-1">
							<input type = "text" class = "form-control" name = " monto" id = "monto" onkeyup = "decimales(this)" value = "<?php echo $monto; ?>" />
						</div>
						<div class="col-xs-3">
							<?php echo moneda_transacciones_html("mon","Tipo_Cambio();"); ?>
							<script type = "text/javascript">
								document.getElementById("mon").value = '<?php echo $mon; ?>';
							</script>
						</div>
						<div class="col-xs-3">
							<input type = "text" class = "form-control" name = " tcambio" id = "tcambio" onkeyup = "decimales(this)" value = "<?php echo $tcambio; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1"><label>Descripci&oacute;n:  </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<input type = "text" class = "form-control" name = " desc" id = "desc" onkeyup = "texto(this)" value = "<?php echo $desc; ?>" maxlength = "150"/>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "GrabarComision();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
							<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "ModificarComision();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
					</form>
					<br>
					<div class="row">
						<div class="col-lg-12">
							<?php
								echo tabla_personal_comisiones($nomina,$dpi);
							?>
						</div>
					</div>
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
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../../CONFIG/images/logo.png" width = "60px;" /></h4>
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
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/rrhh/planilla.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
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
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>