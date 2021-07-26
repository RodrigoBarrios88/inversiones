<?php
	include_once('xajax_funct_inscripciones.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	// $_POST
	$cui = $_REQUEST["cui"];
	
	$ClsIns = new ClsInscripcion();
	$ClsCli = new ClsCliente();
	$ClsAsi = new ClsAsignacion();
	$ClsSeg = new ClsSeguro();
	
	/////////// VALIDA SI YA ACTUALIZÓ O AUN NO ////////////
	// si está inscrito
	$i = 1;
	$result = $ClsIns->get_alumno($cui);
	if(is_array($result)){
		foreach($result as $row){
			$cuinew = trim($row["alu_cui_new"]);
			$cuiold = trim($row["alu_cui_old "]);
			$codigo = trim($row["alu_codigo_interno"]);
			$tipocui = trim($row["alu_tipo_cui"]);
			//pasa a mayusculas
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			//--
			$cliente = trim($row["alu_cliente_factura"]);
			$cli = trim($row["alu_cliente_factura"]);
			//cliente
			if(strlen($cliente)>0){
				$result = $ClsCli->get_cliente($cliente);
				if(is_array($result)){
                    foreach($result as $row){
                        //$cliente = $row["cli_id"];
                        $nit = $row["cli_nit"];
                        $cliente = utf8_decode($row["cli_nombre"]);
                    }
				}
			}		
			$i++;
		}
		$i--;
	}
	
if($tipo != "" && $nombre != ""){ 	
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
	
	<!-- Social Buttons CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap-social/bootstrap-social.css" rel="stylesheet">
	
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
                                <?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
                                <li>
									<a href="FRMimpresion_boletas.php">
										<i class="fa fa-print"></i> Impresi&oacute;n de Boletas de Inscripci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["BOLINSCRIP"] == 1){ ?>
                                <li>
									<a href="FRMboletas.php">
										<i class="fa fa-money"></i> Recepci&oacute;n de Boletas de Inscripci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["APROVCON"] == 1){ ?>
								<li>
									<a class="active" href="FRMaprobacion.php">
										<i class="fa fa-file-text-o"></i> Abrobaci&oacute;n de Contratos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["RECEPCON"] == 1){ ?>
								<li>
									<a href="FRMrecepcion.php">
										<i class="fa fa-inbox"></i> Recepci&oacute;n de Contratos
									</a>
                                </li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="FRMblacklist.php">
										<i class="fa fa-ban"></i> Listas Reservada
									</a>
                                </li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMdatos_actualizados.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Datos Actualizados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMboletas_giradas.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Boletas en Circulaci&oacute;n
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMboletas_aprobadas.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Boletas Pagadas
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMcontratos_aprobados.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Contratos Aprobados
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPINSCRP"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte General del Proceso
									</a>
                                </li>
								<?php } ?>
								<hr>
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
				<div class="panel-heading"> 
					<i class="fa fa-edit"></i> Corregir Informaci&oacute;n de Facturaci&oacute;n del Alumno (para el siguiente ciclo)
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-5 col-lg-offset-1 col-xs-6">
							<button type ="button" class="btn btn-defaul" onclick="window.history.back();">
								<i class="fa fa-chevron-left"></i> Regresar al men&uacute;
							</button>
						</div>
						<div class="col-xs-5 col-xs-6 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<br>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Alumno:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input type="text" class="form-info" id = "cuinew" name = "cuinew" value="<?php echo $cuinew; ?>" readonly />
							<label class="form-info"><?php echo trim($nombre); ?> <?php echo trim($apellido); ?></label>
						</div>
					</div>
					<hr>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Nit a Facturar:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<div class='input-group'>
								<input type = "text" class = "form-control" name = "nit" id = "nit"  value = "<?php echo $nit; ?>" onkeyup = "texto(this);" onblur = "Cliente();" />
								<input type = "hidden" name = "cli" id = "cli" value = "<?php echo $cli; ?>" />
								<span class="input-group-addon" title="Buscar por NIT" style="cursor:pointer" onclick = "Cliente();" >
									&nbsp; <span class="fa fa-check"></span> &nbsp; 
								</span>
							</div>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Nombre a Facturar:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<div class='input-group'>
								<input type="text" class="form-control" name = "cliente" id = "cliente" value = "<?php echo $cliente; ?>" readonly />
								<span class="input-group-addon" title="Click editar, actualizar o modificar datos de facturaci&oacute;n" style="cursor:pointer" onclick = "ModCliente(<?php echo $cli; ?>,);" >
									&nbsp; <span class="fa fa-pencil"></span> &nbsp; 
								</span>
								<span class="input-group-addon" title="Click para limpiar y volver a buscar" style="cursor:pointer" onclick = "ResetCli();" >
									&nbsp; <span class="fa fa-refresh"></span> &nbsp; 
								</span>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-default" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
                            <button type="button" class="btn btn-primary" onclick = "ActualizaNit();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
                        </div>
                    </div>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/inscripcion/modificaciones.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 50,
				responsive: true
			});
	    });
    </script>	

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	//echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>