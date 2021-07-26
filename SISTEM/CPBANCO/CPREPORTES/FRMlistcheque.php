<?php
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//_$POST
	$ban = $_REQUEST["ban"];
	$cue = $_REQUEST["cue"];
	$ban = ($_REQUEST["ban"] != "")?$_REQUEST["ban"]:1;
	$desde = ($_REQUEST["desde"] != "")?$_REQUEST["desde"]:date("d/m/Y");
	$hasta = ($_REQUEST["hasta"] != "")?$_REQUEST["hasta"]:date("d/m/Y");
	//--
	
	
	
if($nombre != "" && $tipo_usuario != ""){	
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
                                <?php if($_SESSION["GBANCO"] == 1){ ?>
								<li>
									<a href="../FRMbanco.php">
										<i class="fa fa-bank"></i> Gestor de Bancos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GCUEBANCO"] == 1){ ?>
								<li>
									<a href="../FRMcuenta.php">
										<i class="fa fa-table"></i> Cuentas Bancarias
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCHEQUE"] == 1){ ?>
								<li>
									<a href="../FRMcheque.php">
										<i class="fa fa-money"></i> Nuevo Cheque
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCHEQUE"] == 1){ ?>
								<li>
									<a href="../FRMmodcheque.php">
										<i class="fa fa-edit"></i> Modificar Datos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["SITCHECQUE"] == 1){ ?>
								<li>
									<a href="../FRMexecheque.php">
										<i class="fa fa-check"></i> Ejecutar Montos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["REPCHEQUE"] == 1){ ?>
								<li>
									<a href="../FRMhistcheque.php">
										<i class="fa fa-history"></i> Historial de Cheques
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPCHEQUE"] == 1){ ?>
								<li>
									<a class="active" href="FRMlistcheque.php">
										<i class="fa fa-print"></i> Reporte de Cheques
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../../CPMENU/MENUcontable.php">
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
					<i class="fa fa-print"></i> 
					<label>Reporte de Cheques</label>
				</div>
                <div class="panel-body">
					<form id='f1' name='f1' method='get'>
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
						</div>
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
							<div class="col-xs-5 col-xs-offset-1">
								<label>Desde / Hasta: </label> <span class="text-danger">*</span>
								<div class="form-group" id="data_1">
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="form-control" name="desde" name="desde" value="<?php echo $desde; ?>"/>
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control" name="hasta" name="hasta" value="<?php echo $hasta; ?>" />
									</div>
								</div>
							</div>
							<div class="col-xs-5">
								<label>Situaci&oacute;n: </label> <span class="text-danger">*</span>
								<select class="form-control" name="sit" name="sit">
									<option value = "">TODOS</option>
									<option value = "1">En Circulaci&oacute;n</option>
									<option value = "2">Pagados</option>
									<option value = "0">Anulados</option>
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12 text-center">
								<a class="btn btn-default" href = "FRMlistcheque.php" ><span class="fa fa-eraser"></span> Limpiar</a>
								<button type="button" class="btn btn-primary" onclick = "Reporte();"><span class="fa fa-search"></span> Buscar</button>
								<button type="button" class="btn btn-outline btn-danger" onclick = "PDF();"><span class="fa fa-file-pdf-o"></span> Exportar PDF</button>
								<button type="button" class="btn btn-success" onclick = "Excel();"><span class="fa fa-file-excel-o"></span> Exportar Excel</button>
							</div>
						</div>
					</form>
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
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/bancos/cheque.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Reporte(){
			ban = document.getElementById("ban");
			cue = document.getElementById("cue");
			if(ban.value !== "" && cue.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="REPlistcheque.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(ban.value ===""){
					ban.className = "form-info";
				}else{
					ban.className = "form-control";
				}
				if(cue.value ===""){
					cue.className = "form-info";
				}else{
					cue.className = "form-control";
				}
				swal("Ohoo!", "Debe seleccionar el Banco y la Cuenta de Banco a consultar...", "info");
			}
		}
		
		
		function Excel(){
			ban = document.getElementById("ban");
			cue = document.getElementById("cue");
			if(ban.value !== "" && cue.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="EXCELlistcheque.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(ban.value ===""){
					ban.className = "form-info";
				}else{
					ban.className = "form-control";
				}
				if(cue.value ===""){
					cue.className = "form-info";
				}else{
					cue.className = "form-control";
				}
				swal("Ohoo!", "Debe seleccionar el Banco y la Cuenta de Banco a consultar...", "info");
			}
		}
		
		function PDF(){
			ban = document.getElementById("ban");
			cue = document.getElementById("cue");
			if(ban.value !== "" && cue.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="REPlistchequePDF.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(ban.value ===""){
					ban.className = "form-info";
				}else{
					ban.className = "form-control";
				}
				if(cue.value ===""){
					cue.className = "form-info";
				}else{
					cue.className = "form-control";
				}
				swal("Ohoo!", "Debe seleccionar el Banco y la Cuenta de Banco a consultar...", "info");
			}
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