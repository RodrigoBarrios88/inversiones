<?php
	include_once('xajax_funct_boleta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_Post
	$ClsPer = new ClsPeriodoFiscal();
	$cuenta = $_REQUEST["cuenta"];
	$banco = $_REQUEST["banco"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$tipo = $_REQUEST["tipo"];
	//--
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	//--
	$tipomora = $_REQUEST["tipomora"];
	$monto = $_REQUEST["monto"];
	$motivo = $_REQUEST["motivo"];
	//--
	$banco = ($banco == "")?1:$banco;
	
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
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>

    <!-- Datepicker Bootstrap v3.0 -->
	<link href="../assets.3.6.2/css/plugins/datapicker/datepicker3.css"rel="stylesheet"/>

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
											<a href="FRMhistorial_csv.php">
												<i class="fa fa-file-excel-o"></i> Historial de .CSV
											</a>
										</li>
										<?php } ?>
										<hr>
										<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
										<li>
											<a class="active" href="FRMmora.php">
												<i class="fa fa-clock-o"></i> Registro de Moras
											</a>  
										</li>
										<?php } ?>
										<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
										<li>
											<a href="FRMmoras.php">
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
			<div class="panel-heading"><i class="fa fa-clock-o"></i> <i class="fa fa-times"></i> Registro de Moras (Alumnos que tienen saldo pendiente a la fecha)</div>
         <div class="panel-body" id = "formulario">
				<form name = "f1" id = "f1" method="get">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Banco:</label> <small class = " text-info">(Opcional)</small></div>
						<div class="col-xs-5"><label>Cuenta de Banco:</label> <small class = " text-info">(Opcional)</small></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo banco_html("banco","Submit();"); ?>
							<input type = "hidden" name = "grupo" id = "grupo" />
							<script type="text/javascript">
								document.getElementById("banco").value = "<?php echo $banco; ?>";
							</script>
						</div>
						<div class="col-xs-5" id = "scue">
							<?php
								if($banco != ""){
									echo cuenta_banco_html($banco,"cuenta","");
								}else{
									echo combos_vacios("cuenta");
								}
							?>
						</div>
						<script type="text/javascript">
							document.getElementById("cuenta").value = "<?php echo $cuenta; ?>";
						</script>
					</div>
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
						<div class="col-xs-5 col-xs-offset-1">
							<label>Desde / Hasta:</label> <span class = "text-danger">*</span>
							<div class="form-group" id="data_1">
								<div class="input-daterange input-group" id="datepicker">
									<input type="text" class="form-control" name="desde" id="desde" value="<?php echo $desde; ?>"/>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" class="form-control" name="hasta" id="hasta" value="<?php echo $hasta; ?>" />
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<label>Nivel:</label> <span class = "text-danger">*</span>
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
					<hr>
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Tipo de Mora:</label> <span class="text-danger">*</span>
							<select class="form-control" id="tipomora" name="tipomora">
								<option value = "P">Porcentaje (%)</option>
								<option value = "M" selected >Monto (Q.)</option>
							</select>
						</div>
						<div class="col-lg-5 col-xs-12">
							<label>Monto:</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" id="monto" name="monto" onkeyup="decimales(this);" value = "<?php echo $monto; ?>" maxlength = "6" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Motivo de la Mora:</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" id="motivo" name="motivo" onkeyup="texto(this);" value = "<?php echo $motivo; ?>" />
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a class="btn btn-default" href = "FRMmora.php"><span class="fa fa-eraser"></span> Limpiar</a>
							<button type="button" class="btn btn-primary" onclick = "GrabarMora();"><span class="fa fa-save"></span> Grabar</button>
							<button type="button" class="btn btn-info" onclick = "Reporte();"><span class="fa fa-search"></span> Revisar</button>
						</div>
					</div>
				</form>
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
	
	<!-- Metis Menu Plugin JavaScript -->
	<script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>
	
	<!-- DataTables JavaScript -->
	<script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
	<!-- Datepicker Bootstrap v3.0 -->
	<script src="../assets.3.6.2/js/plugins/datapicker/bootstrap-datepicker.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/mora.js?v=1.1.2"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Reporte(){
			cuenta = document.getElementById("cuenta");
			banco = document.getElementById("banco");
			if(cuenta.value !== "" && banco.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="CPREPORTES/REPmorosos.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(cuenta.value ===""){
					cuenta.className = "form-info";
				}else{
					cuenta.className = "form-control";
				}
				if(banco.value ===""){
					banco.className = "form-info";
				}else{
					banco.className = "form-control";
				}
				swal("Error","Debe Seleccione los filtros de consulta","info");
			}
		}
		
		function Boletas(grupo){
			document.getElementById("cuenta").value = 2; //cuenta 2 es dinamica educativa (la cuentanta por defecto de Los Olivos para las moras)
			document.getElementById("grupo").value = grupo;
			myform = document.forms.f1;
			myform.target ="_blank";
			myform.action ="CPREPORTES/REPboletas_mora.php";
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
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
