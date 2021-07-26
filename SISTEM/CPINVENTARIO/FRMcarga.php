<?php
	include_once('xajax_funct_inventario.php');
	$nombre = $_SESSION["nombre"];
	$pventa = $_SESSION["cajapv"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPCONTA"];
	$moneda = $_SESSION["moneda"];
	$facturar = $_SESSION["facturar"];
	$sifact = ($facturar == 1)?"checked":"";
	
if($pensum != "" && $nombre != "" && $valida != ""){ 	
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

    <!-- DataTables Responsive CSS -->
    

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>

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
								<?php if($_SESSION["INVRCAR"] == 1){ ?>
                                <li>
									<a href="FRMcarga.php">
										<i class="fa fa-sign-in"></i> Carga a Inventario
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["INVCCAR"] == 1){ ?>
								<li>
									<a href="FRMcarga_compra.php">
										<i class="fa fa-sign-in"></i> Carga Compra
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["INVRDESC"] == 1){ ?>
								<li>
									<a href="FRMdescarga.php">
										<i class="fa fa-sign-out"></i> Descarga a Inventario
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["INVVDESC"] == 1){ ?>
								<li>
									<a href="FRMdescarga_venta.php">
										<i class="fa fa-sign-out"></i> Descarga Venta
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["INVHIST"] == 1){ ?>
								<li>
									<a href="FRMhistorial.php">
										<i class="fa fa-history"></i> Historial Inventario
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["KARDEX"] == 1){ ?>
								<li>
									<a href="FRMkardex.php">
										<i class="fa fa-list-alt"></i> Kardex
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
					<br>
				</div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			<br>
            <div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-sign-in"></i> <label>Carga de Art&iacute;culos a Inventario</label></div>
                <div class="panel-body" id = "formulario">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-center">
							<a href = "#" onclick="window.location.reload();" >
								<i class="fa fa-refresh fa-2x"></i>
							</a> 
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-danger">* Campos Obligatorios</span> <span class = " text-info">* Campos de Busqueda</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Fecha de Carga:</label></div>
						<div class="col-xs-5"><label id = "cntsuc">Empresa:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="form-group">
								<div class='input-group date' id='fecha'>
									<input type='text' class="form-control" id = "fec" name='fec' value="<?php echo date("d/m/Y"); ?>" />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<?php echo empresa_html("suc"); ?>
							<input type = "hidden" name = "sucX" id = "sucX" value = "<?php echo $_SESSION["empCodigo"]; ?>" />
							<script type="text/javascript">
								document.getElementById('suc').value = '<?php echo $_SESSION["empCodigo"]; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Motivo de la Carga:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Documento de Respaldo:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id = "clase" name = "clase" class = "form-control">
									<option value = "P">POR PRODUCCI&Oacute;N</option>
									<option value = "D">POR DONACI&Oacute;N</option>
									<option value = "C2">A CONSIGNACI&Oacute;N</option>
									<option value = "C3">POR DEVOLUCI&Oacute;N DE CONSIGNACI&Oacute;N</option>
									<option value = "B">BONIFICACI&Oacute;N DE COMPRA</option>
									<option value = "IF">CUADRE DE INVENTARIO FISICO</option>
									<option value = "CI">CARGA INICIAL DE INVENTARIO</option>
							</select>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "doc" id = "doc" onkeyup = "texto(this);" />
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1" id = "lb1"><label>Codigo de Barras:</label> <span class = " text-info">*</span> &nbsp; <i class="fa fa-barcode"></i></div>
						<div class="col-xs-5"><label id = "cntart">Art&iacute;culo:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "barc" id = "barc" onkeyup = "texto(this);KeyEnter(this,Articulo);" />
						</div>
						<div class="col-xs-5">
							<?php echo articulo_transaccion_html('art',"Articulo();"); ?>
							<input type = "hidden" name = "artn" id = "artn" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Cantidad:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Pr&eacute;cio:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "cant" id = "cant" onkeyup = "enteros(this);KeyEnter(this,NewFilaCarga);" />
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "prec" id = "prec" onkeyup = "decimales(this);KeyEnter(this,NewFilaCarga);" />
						</div>
					</div>
					<div class="row hidden">
						<div class="col-xs-5 col-xs-offset-1"><label>Precio Compra:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Compra + Margen:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row hidden">
						<div class="col-xs-5 col-xs-offset-1">
							<input type = "text" class = "form-control" name = "prem" id = "prem" value = "0" />
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "prev" id = "prev" value = "0" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Moneda:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Existencia:</label> <span class = " text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo moneda_transacciones_html("mon","NewFilaCarga();"); ?>
						</div>
						<div class="col-xs-5">
							<input type = "text" class = "form-control" name = "cantlimit" id = "cantlimit" disabled />
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Nit:</label> <span class = " text-danger">*</span></div>
						<div class="col-xs-5"><label>Proveedor:</label> <span class = " text-danger">*</span></div>
					</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<div class='input-group'>
									<input type="text" class="form-control" name = "nit" id = "nit" onkeyup = "texto(this);KeyEnter(this,Proveedor);" onblur = "Proveedor();" />
									<input type = "hidden" name = "prov" id = "prov" />
									<span class="input-group-addon" style="cursor:pointer" onclick = "SearchProveedor();" >
										<span class="fa fa-search"></span>
									</span>
								</div>
							</div>
							<div class="col-xs-5">
								<div class='input-group'>
									<input type="text" class="form-control" name = "nom" id = "nom" readonly />
									<span class="input-group-addon" style="cursor:pointer" onclick = "ResetProv();" >
										<span class="fa fa-refresh"></span>
									</span>
								</div>
							</div>
						</div>
					<hr>
					<div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" onclick = "NewFilaCarga();"><span class="fa fa-plus"></span> <span class="fa fa-shopping-cart"></span></button>
                        </div>
                    </div>
					<br>
				</div>
            </div>
	    <!-- /.panel-default -->
	    
		<!-- /.panel-success -->
	    <div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12" id = "result">
					<?php
						echo tabla_inicio_carga(1);
						//tabla_filas_venta(1,$moneda,$cant,$tip,$barc,$artc,$desc,$prev,$mon,$mons,$monc,$tfdsc,$fdsc,$tdsc,$dsc,$IVA)
					?>
				</div>
			</div>
		</div>
	    </div>
	    
	    <!-- /.panel-default -->
	    <div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
                <div class="col-xs-12 text-center">
                    <button type="button" class="btn btn-default" onclick = "Limpiar();"><span class="glyphicon glyphicon-erase"></span> Limpiar</button>
                    <button type="button" class="btn btn-success" onclick = "ConfirmCargaJS();"><span class="fa fa-cloud-upload"></span> Cargar </button>
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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Select2 -->
	<link href="../assets.3.6.2/css/plugins/select2/select2.min.css" rel="stylesheet">
    <script src="../assets.3.6.2/js/plugins/select2/select2.full.min.js"></script>

	<!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/inventario/inventario.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
	    });
	
		$(function () {
            $('#fec').datetimepicker({
                format: 'DD/MM/YYYY'
            });
			
			$(".select2").select2();
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