<?php
	include_once('xajax_funct_contabilidad.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//$_Post
	$suc = $_REQUEST["suc"];
	$suc = ($suc != "")?$suc:$empCodigo;
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	$desde = ($desde == "")?date("d/m/Y"):$desde;
	$hasta = ($hasta == "")?date("d/m/Y"):$hasta;

	
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
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($_SESSION["CONTAPAR"] == 1){ ?>
                                <li>
									<a href="FRMclase.php">
										<i class="fa fa-folder-open"></i> Clasificaci&oacute;n de Partidas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONTAPAR"] == 1){ ?>
                                <li>
									<a href="FRMpartida.php">
										<i class="fa fa-superscript"></i> Partidas Contables
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONTAREG"] == 1){ ?>
								<li>
									<a href="FRMreglon.php">
										<i class="fa fa-subscript"></i> Reglones Contables
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONTAPAR"] == 1){ ?>
                                <li>
									<a href="FRMsubreglon.php">
										<i class="fa fa-sort-numeric-asc"></i> Sub-Reglones Contables
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["LIBVENTA"] == 1){ ?>
								<li>
									<a href="FRMlibroventas.php">
										<i class="fa fa-book"></i> Libro de Ventas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["LIBCOMPRA"] == 1){ ?>
								<li>
									<a href="FRMlibrocompras.php">
										<i class="fa fa-book"></i> Libro de Compras
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["LIBINV"] == 1){ ?>
								<li>
									<a href="FRMlibroinventario.php">
										<i class="fa fa-book"></i> Libro de Inventarios
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["LIBINV"] == 1){ ?>
								<li>
									<a href="FRMbalance.php">
										<i class="fa fa-book"></i> Balance General
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["LIBINV"] == 1){ ?>
								<li>
									<a href="FRMresultados.php">
										<i class="fa fa-book"></i> Estado de Resultados
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
				<div class="panel-heading"><i class="fa fa-book"></i> Estado de Resultados</div>
                <div class="panel-body" id = "formulario">
					<form name = "f1" name = "f1" method="get" >
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Empresa:</label>
								<?php echo empresa_html("suc",""); ?>
								<input type = "hidden" name = "cod" id = "cod" />
								<script type="text/javascript">
									document.getElementById("suc").value = "<?php echo $suc; ?>";
								</script>
							</div>
							<div class="col-xs-5">
								<label>Desde / Hasta: </label> <span class="text-danger">*</span>
								<div class="form-group" id="data_1">
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="form-control" id="desde" name="desde" value="<?php echo $desde; ?>"/>
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control" id="hasta" name="hasta" value="<?php echo $hasta; ?>" />
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>No. de Contador:</label>
								<input type='text' class="form-control" id = "cnum" name='cnum' value="<?php echo $cnum; ?>" onkeyup="texto(this);" />
							</div>
							<div class="col-xs-5">
								<label>Nombre del Contador:</label> 
								<input type='text' class="form-control" id = "cnom" name='cnom' value="<?php echo $cnom; ?>" onkeyup="texto(this);" />
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-12 text-center">
								<a type="button" class="btn btn-default" href = "FRMlibroinventario.php"><span class="fa fa-eraser"></span> Limpiar</a>
								<a type="button" class="btn btn-primary" target="_blank" href = "CPREPORTES/REPresultados.pdf"><span class="glyphicon glyphicon-print"></span> Generar</a>
								<!--button type="button" class="btn btn-primary" onclick = "Reporte();"><span class="glyphicon glyphicon-search"></span> Buscar</button-->
								<!--button type="button" class="btn btn-success" onclick = "Excel();"><span class="fa fa-file-excel-o"></span> Exportar</button-->
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
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/finanzas/libros.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Excel(){
			suc = document.getElementById("suc");
			desde = document.getElementById("desde");
			hasta = document.getElementById("hasta");
			cnum = document.getElementById("cnum");
			cnom = document.getElementById("cnom");
			if(suc.value !== "" && desde.value !== "" && hasta.value !== "" && cnum.value !== "" && cnom.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="REPlibroinventario.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(suc.value ===""){
					suc.className = "form-danger";
				}else{
					suc.className = "form-control";
				}
				if(desde.value ===""){
					desde.className = "form-danger";
				}else{
					desde.className = "form-control";
				}
				if(hasta.value ===""){
					hasta.className = "form-danger";
				}else{
					hasta.className = "form-control";
				}
				if(cnum.value ===""){
					cnum.className = "form-danger";
				}else{
					cnum.className = "form-control";
				}
				if(cnom.value ===""){
					cnom.className = "form-danger";
				}else{
					cnom.className = "form-control";
				}
				swal("Ohoo!", "Debe llenar los datos obligatorios", "error");
			}
		}
		
		function Reporte(){
			suc = document.getElementById("suc");
			desde = document.getElementById("desde");
			hasta = document.getElementById("hasta");
			cnum = document.getElementById("cnum");
			cnom = document.getElementById("cnom");
			if(suc.value !== "" && desde.value !== "" && hasta.value !== "" && cnum.value !== "" && cnom.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="REPlibroinventario.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(suc.value ===""){
					suc.className = "form-danger";
				}else{
					suc.className = "form-control";
				}
				if(desde.value ===""){
					desde.className = "form-danger";
				}else{
					desde.className = "form-control";
				}
				if(hasta.value ===""){
					hasta.className = "form-danger";
				}else{
					hasta.className = "form-control";
				}
				if(cnum.value ===""){
					cnum.className = "form-danger";
				}else{
					cnum.className = "form-control";
				}
				if(cnom.value ===""){
					cnom.className = "form-danger";
				}else{
					cnom.className = "form-control";
				}
				swal("Ohoo!", "Debe llenar los datos obligatorios", "error");
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
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>