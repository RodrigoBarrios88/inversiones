<?php
	include_once('xajax_funct_reglas.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPADMIN"];
	
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_reglas();
		if(is_array($result)){
			foreach($result as $row){
				$mail = $row['reg_correo_admin'];
				$mon = $row['reg_moneda'];
				$pais = $row['reg_pais'];
				$dep = $row['reg_departamento'];
				$mun = $row['reg_municipio'];
				$regimen = $row['reg_regimen_tributario'];
				$iva = $row['reg_iva'];
				$confac = $row['reg_factura'];
				$serie = $row['reg_serie'];
				$margen = $row['reg_margen'];
				$minimo = $row['reg_minimo_producto'];
				$descargar = $row['reg_descarga'];
				$cargar = $row['reg_carga'];
				$igssemp = $row['reg_igss_empleado'];
				$igsspat = $row['reg_igss_patrono'];
				$irtra = $row['reg_irtra'];
				$intecap = $row['reg_intecap'];
			}
		}
	
if($valida != "" && $nombre != ""){ 	
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
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- Timeline CSS -->
	<link href="../dist/css/timeline.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
	<link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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
						<li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a></li>
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
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMconfig.php">
										<i class="fa fa-cogs"></i> Configuraci&oacute;n de Colegio
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMreglas.php">
										<i class="fa fa-cog"></i> Configuraci&oacute;n de Reglas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMmoneda.php">
										<i class="fa fa-money"></i> Monedas y Tasa de Cambio
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMseguridad.php">
										<i class="fa fa-lock"></i> Seguridad (Error Ing.)
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONFREG"] == 1){ ?>
								<li>
									<a href="FRMmodulos.php">
										<i class="fa fa-sitemap"></i> M&oacute;dulos del Sistema
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
					<i class="fa fa-cogs"></i> Configuraci&oacute;n Inicial para el Administrador
				</div>
            <div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class = "text-center text-primary"><br><hr> <label>CONFIGURACI&Oacute;N REGIONAL</label> <hr><br></div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>E-mail del Administrador: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<input type = "text" class = "form-control text-libre" name = "mail" id = "mail" onkeyup = "texto(this)" value = "<?php echo $mail; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Pa&iacute;s: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<?php echo Paises_html("pais"); ?> 
							<!-- setea tipo -->
							<script type="text/javascript">
							document.getElementById('pais').value = '<?php echo $pais; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Departamento: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<?php echo departamento_html('dep','mun','Smun'); ?> 
							<!-- setea tipo -->
							<script type="text/javascript">
							document.getElementById('dep').value = '<?php echo $dep; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Municipio: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<span id = "Smun">
							<?php echo municipio_html($dep,'mun'); ?> 
							</span>
							<!-- setea tipo -->
							<script type="text/javascript">
							document.getElementById('mun').value = '<?php echo $mun; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class = "text-center text-primary"><br><hr> <label>CONFIGURACI&Oacute;N FINANCIERA</label> <hr><br></div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>R&eacute;gimen Tributario: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<select class="form-control" name="regimen" id="regimen" >
								<option value="">Seleccione</option>
								<option value="1">R&Eacute;GIMEN DE PEQUE&Ntilde;O CONTRIBUYENTE</option>
								<option value="2">R&Eacute;GIMEN OPCIONAL SIMPLIFICADO SOBRE INGRESOS DE ACTIVIDADES LUCRATIVAS</option>
								<option value="3">R&Eacute;GIMEN SOBRE LAS UTILIDADES DE ACTIVIDADES LUCRATIVAS</option>
							</select>
							<script type="text/javascript">
								document.getElementById("regimen").value = "<?php echo $regimen; ?>";
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>IVA: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<input type = "text" class = "form-control" name = "iva" id = "iva" onkeyup = "decimales(this)" value = "<?php echo $iva; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Moneda por defecto: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<?php echo Moneda_html("mon"); ?>
							<!-- setea tipo -->
							<script type="text/javascript">
							document.getElementById('mon').value = '<?php echo $mon; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Desea Facturar por defecto?: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<?php
								if($confac == "0"){
									$radio1 = "checked";
									$radio2 = "";
								}if($confac == "1"){
									$radio1 = "";
									$radio2 = "checked";
								}
							?>
							&nbsp; <label><input type="radio" id = "facsi" name = "confac" value="1" <?php echo $radio2; ?> /><label for="facsi" id = "labelfacsi" > SI</label></label>
							&nbsp; <label><input type="radio" id = "facno" name = "confac" value="0" <?php echo $radio1; ?> /><label for="facno" id = "labelfacno" > NO</label></label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Serie de Factura a utliziar por defecto: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<div class='input-group'>
								<?php echo Serie_html("serie"); ?>
								<span class="input-group-addon" style="cursor:pointer" onclick = "AgregaSerie();" title="Agregar una nueva serie de facturas" >
									<span class="glyphicon glyphicon-plus"></span>
								</span>
							</div>
							<!-- setea tipo -->
							<script type="text/javascript">
							document.getElementById('serie').value = '<?php echo $serie; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class = "text-center text-primary"><br><hr> <label>CONFIGURACI&Oacute;N DE INVENTARIOS</label> <hr><br></div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Margen de Utilida en Productos (%): <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<input type = "text" class = "form-control" name = "margen" id = "margen" value = "<?php echo $margen; ?>" onkeyup = "decimales(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Cantidad M&iacute;nima de Producto: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<input type = "text" class = "form-control" name = "minimo" id = "minimo" value = "<?php echo $minimo; ?>" onkeyup = "decimales(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Descargar Automaticamente los Art&iacute;culos en las Ventas?: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<?php
								if($descargar == "0"){
									$radio1 = "checked";
									$radio2 = "";
								}if($descargar == "1"){
									$radio1 = "";
									$radio2 = "checked";
								}
							?>
							&nbsp; <label><input type="radio" id = "descsi" name = "descargar" value="1" <?php echo $radio2; ?> /><label for="descsi" id = "labeldescsi" > SI</label></label>
							&nbsp; <label><input type="radio" id = "descno" name = "descargar" value="0" <?php echo $radio1; ?> /><label for="descno" id = "labeldescno" > NO</label></label>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>Cargar Automaticamente los Art&iacute;culos o Insumos en las Compras?: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<?php
								if($cargar == "0"){
									$radio1 = "checked";
									$radio2 = "";
								}if($cargar == "1"){
									$radio1 = "";
									$radio2 = "checked";
								}
							?>
							&nbsp; <label><input type="radio" id = "carsi" name = "cargar" value="1" <?php echo $radio2; ?> /><label for="carsi" id = "labelcarsi" > SI</label></label>
							&nbsp; <label><input type="radio" id = "carno" name = "cargar" value="0" <?php echo $radio1; ?> /><label for="carno" id = "labelcarno" > NO</label></label>
						</div>
					</div>
					<div class="row">
						<div class = "text-center text-primary"><br><hr> <label>CONFIGURACI&Oacute;N DE PLANILLAS O N&Oacute;MINAS DE PAGO</label> <hr><br></div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>IGSS Cuota Empleado: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<input type = "text" class = "form-control" name = "igssemp" id = "igssemp" value = "<?php echo $igssemp; ?>" onkeyup = "decimales(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>IGSS Cuota Patronal: <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<input type = "text" class = "form-control" name = "igsspat" id = "igsspat" value = "<?php echo $igsspat; ?>" onkeyup = "decimales(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>IRTRA (Patrono): <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<input type = "text" class = "form-control" name = "irtra" id = "irtra" value = "<?php echo $irtra; ?>" onkeyup = "decimales(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5"><label>ITECAP (Patrono): <span class="text-danger">*</span></div>
						<div class="col-xs-6">
							<input type = "text" class = "form-control" name = "intecap" id = "intecap" value = "<?php echo $intecap; ?>" onkeyup = "decimales(this)" />
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" onclick = "Limpiar()"><span class="glyphicon glyphicon-erase"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
				</div>
				<!-- /.panel-body -->
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

	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/master/reglas.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>