<?php
	include_once('html_fns_reportes.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	///---
	$ClsPen = new ClsPensum();
	$ClsPer = new ClsPeriodoFiscal();
	$periodo_vigente = $ClsPer->get_periodo_activo();
	//$_Post
	$division = $_REQUEST["division"];
	$grupo = $_REQUEST["grupo"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	//--
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	//--
	if($_REQUEST["periodo"] == ""){
		$periodo = $ClsPer->get_periodo_activo();
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}else{
		$periodo = $_REQUEST["periodo"];
		$pensum = $ClsPer->get_pensum_periodo($periodo);
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
	
	<!-- CSS personalizado -->
    <link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>

    <!-- Datepicker Bootstrap v3.0 -->
	<link href="../../assets.3.6.2/css/plugins/datapicker/datepicker3.css"rel="stylesheet"/>

    <!-- DataTables CSS -->
    <link href="../../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                                <?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=GBOL">
										<i class="fa fa-file-text-o"></i> Gestor de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlistboletas.php">
										<i class="fa fa-print"></i> Reporte de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlistpagos.php">
										<i class="fa fa-print"></i> Reporte de Pagos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlistcarga.php">
										<i class="fa fa-print"></i> Reporte de Cargas Electr&oacute;nicas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMcargos.php">
										<i class="fa fa-plus"></i> <i class="fa fa-dollar"></i> Reporte de Cargos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMdescuentos.php">
										<i class="fa fa-minus"></i> <i class="fa fa-dollar"></i> Reporte de Descuentos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMingresos.php">
										<i class="fa fa-dollar"></i> <i class="fa fa-dollar"></i> Reporte de Ingresos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMcartera.php">
										<i class="fa fa-folder-open"></i> <i class="fa fa-dollar"></i> Reporte de Cartera
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMventas.php">
										<i class="fa fa-shopping-cart"></i> <i class="fa fa-print"></i> Reporte de Ventas con Boleta
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a class="active" href="FRMmorosos.php">
										<i class="fa fa-ban"></i> <i class="fa fa-dollar"></i> Reporte de Saldos
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsolventes.php">
										<i class="fa fa-check"></i> <i class="fa fa-dollar"></i> Reporte de Solventes
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMantiguedad.php">
										<i class="fa fa-calendar"></i> <i class="fa fa-dollar"></i> Reporte Antiguedad de Saldos
									</a>
                                </li>
								<?php } ?>
								<hr>
								<li>
									<a href="../../CPMENU/MENUcuenta.php">
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
				<div class="panel-heading">
					<i class="fa fa-print"></i> Reporte de Saldos (Alumnos que tienen saldo pendiente a la fecha)
				</div>
                <div class="panel-body">
					<form name = "f1" id = "f1" method="get">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Grupo:</label> <small class = " text-info">(Opcional)</small>
							<?php echo division_grupo_html("grupo","Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("grupo").value = "<?php echo $grupo; ?>";
							</script>
						</div>	
						<div class="col-xs-5" id = "scue">
							<label>Divisi&oacute;n:</label> <small class = " text-info">(Opcional)</small>
							<?php
								if($grupo != ""){
									echo division_html($grupo,"division","");
								}else{
									echo combos_vacios("division");
								}
							?>
						</div>
						<script type="text/javascript">
							document.getElementById("division").value = "<?php echo $division; ?>";
						</script>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Periodo Fiscal:</label>
							<?php echo periodo_fiscal_html("periodo","Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("periodo").value = "<?php echo $periodo; ?>";
							</script>
						</div>
						<div class="col-xs-5">
							<label>Ciclo Escolar:</label>
							<?php echo pensum_html("pensum","Submit();"); ?>
							<script type = "text/javascript">
								document.getElementById("pensum").value = '<?php echo $pensum; ?>';
								document.getElementById("pensum").setAttribute("disabled",true);
							</script>
						</div>
                    </div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Desde / Hasta:</label></div>
						<div class="col-xs-5"><label>Nivel:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="form-group" id="data_1">
								<div class="input-daterange input-group" id="datepicker">
									<input type="text" class="form-control" name="desde" id="desde" value="<?php echo $desde; ?>"/>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" class="form-control" name="hasta" id="hasta" value="<?php echo $hasta; ?>" />
								</div>
							</div>
						</div>
						<div class="col-xs-5" id = "divnivel">
							<?php
								if($pensum != ""){
									echo nivel_html($pensum,"nivel","Submit();");;
								}else{
									echo combos_vacios("nivel");
								}	
							?>
							<?php if($nivel != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("nivel").value = '<?php echo $nivel; ?>';
							</script>
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Grado:</label> <span class = "text-danger">*</span></div>
						<div class="col-xs-5"><label>Secci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1" id = "divgrado">
							<?php if($pensum != "" && $nivel != ""){
									echo grado_html($pensum,$nivel,"grado","Submit();");
								}else{
									echo combos_vacios("grado");
								}	
							?>
							<?php if($grado != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("grado").value = '<?php echo $grado; ?>';
							</script>
							<?php } ?>
						</div>
						<div class="col-xs-5" id = "divseccion">
							<?php if($pensum != "" && $nivel != "" && $grado != ""){
									echo seccion_html($pensum,$nivel,$grado,"","seccion","Submit();");
								}else{
									echo combos_vacios("seccion");
								}	
							?>
							<?php if($seccion != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("seccion").value = '<?php echo $seccion; ?>';
							</script>
							<?php } ?>
						</div>
					</div>
					<br>
					</form>
					<br>
					<div class="row">
                        <div class="col-xs-12 text-center">
							<a class="btn btn-default" href = "FRMmorosos.php"><span class="fa fa-eraser"></span> Limpiar</a> 
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
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../../CONFIG/images/logo.png" width = "60px;" /> ASMS</h4>
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
    
    <!-- jQuery -->
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
    <!-- Datepicker Bootstrap v3.0 -->
    <script src="../../assets.3.6.2/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/colegiatura/boleta.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Reporte(){
			myform = document.forms.f1;
			myform.target ="_blank";
			myform.action ="REPmorosos.php";
			myform.submit();
			myform.action ="";
			myform.target ="";
		}
	
		$('#data_1 .input-daterange').datepicker({
            format: 'dd/mm/yyyy',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
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