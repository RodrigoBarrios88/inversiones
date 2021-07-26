<?php
	include_once('xajax_funct_boleta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum_vigente = $_SESSION["pensum"];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_vigente:$pensum;
	$ClsPer = new ClsPeriodoFiscal();
	$periodo = $ClsPer->get_periodo_pensum($pensum);
	$result = $ClsPer->get_periodo($periodo);
	if(is_array($result)){
		foreach($result as $row){
			$periodo_descripcion = utf8_decode($row["per_descripcion_completa"]);
		}
	}else{
		$periodo_descripcion = "- No habilitado -";
	}
	
	$ClsAlu = new ClsAlumno();
	$hashkey = $_REQUEST["hashkey"];
	$cui = $ClsAlu->decrypt($hashkey,$id);
	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			$codalu = utf8_decode($row["alu_codigo_interno"]);
		}
		$alumno = "$nom $ape";
	}
	
	$ClsAcadem = new ClsAcademico();
	$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = trim($row["graa_nivel"]);
			$grado = trim($row["graa_grado"]);
			//echo "$grado <br>";
			$nivel_desc = trim($row["niv_descripcion"]);
			$grado_desc = trim($row["gra_descripcion"]);
		}
	}
	//$_POST
	$grupo = $_REQUEST["grupo"];
	$grupo = ($grupo != "")?$grupo:"1";
	$division = $_REQUEST["division"];
	$referencia = $_REQUEST["boleta"];
	$fecha = $_REQUEST["fecha"];
	$monto = $_REQUEST["monto"];
	$motivo = $_REQUEST["motivo"];
	$tipo = $_REQUEST["tipo"];
	$tipo = ($tipo != "")?$tipo:"C";
	
	$tipodesc = $_REQUEST["tipodesc"];
	$tipodesc = ($tipodesc != "")?$tipodesc:"M";
	$desc = $_REQUEST["desc"];
	$desc = ($desc != "")?$desc:"0";
	
	
if($id != "" && $nombre != ""){ 	
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
									<a class="active" href="FRMsecciones.php?acc=GBOL">
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
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="../CPBOLETAFACTURAS/FRMlist_cargas.php">
										<i class="fa fa-file-text-o"></i> Facturas y Recibos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GESMOR"] == 1){ ?>
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
				<div class="panel-heading"><i class="fa fa-edit"></i> Gestor de Boletas de Cobro</div>
            <div class="panel-body" id = "formulario">
				<form id='f1' name='f1' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Ciclo Escolar:</label> <span class="text-danger">*</span>
							<input type="hidden" name = "acc" id = "acc" value="<?php echo $acc; ?>" />
							<?php echo pensum_html("pensum", "Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("pensum").value = '<?php echo $pensum; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<label>Periodo Fiscal:</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" id="periododesc" name="periododesc" value="<?php echo $periodo_descripcion; ?>" disabled >
							<input type="hidden" id="periodo" name="periodo" value="<?php echo $periodo; ?>" >
						</div>
					</div>
					<hr>	
					<div class="row">
						<div class="col-lg-5 col-xs-12 col-lg-offset-1">
							<label>Alumno:</label>
							<input type="text" class="form-info" id="nombre" value = "<?php echo trim($alumno); ?>" readonly />
							<input type="hidden" id="cui" name="cui" value="<?php echo $cui; ?>" />
							<input type="hidden" id="codint" name="codint" value="<?php echo $codalu; ?>" />
							<input type="hidden" id="hashkey" name="hashkey" value="<?php echo $hashkey; ?>" />
							<input type="hidden" id="anio" name="anio" value="<?php echo $anio; ?>" />
							<input type="hidden" id="boletas_in" name="boletas_in" />
						</div>
						<div class="col-lg-2 col-xs-12">
							<label>Nivel:</label> <span class="text-danger">*</span>
							<input type="text" class="form-info" value = "<?php echo utf8_decode($nivel_desc); ?>" readonly />
						</div>
						<div class="col-lg-3 col-xs-12">
							<label>Grado:</label> <span class="text-danger">*</span>
							<input type="text" class="form-info" value = "<?php echo utf8_decode($grado_desc); ?>" readonly />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Grupo:</label>
							<?php echo division_grupo_html("grupo","Submit();"); ?>
							<input type = "hidden" name = "codigo" id = "codigo" />
							<script type="text/javascript">
								document.getElementById("grupo").value = "<?php echo $grupo; ?>";
							</script>
						</div>	
						<div class="col-xs-5" id = "sdiv">
							<label>Divisi&oacute;n:</label>
							<?php
								if($grupo != ""){
									echo division_html($grupo,"division","Submit();");
								}else{
									echo combos_vacios("division");
								}
							?>
						</div>
						<script type="text/javascript">
							document.getElementById("division").value = "<?php echo $division; ?>";
						</script>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>No. Referencia:</label> <small class="text-muted">(no obligatorio)</small>
							<input type="text" class="form-control" id="referencia" name="referencia" onkeyup="enteros(this);" value = "<?php echo $referencia; ?>" />
						</div>
						<div class="col-xs-5">
							<label>Fecha de Generaci&oacute;n:</label>
							<div class="form-group">
								<div class='input-group date' id='fec'>
									<input type='text' class="form-control" id = "fecha" name='fecha' value = "<?php echo $fecha; ?>" />
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
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
								<option value = "I">Inscripciones</option>
								<option value = "E">Examenes de Conocimiento (Admisi&oacute;n)</option>
								<option value = "V">Ventas de Uniformes o Art&iacute;culos Auxiliares</option>
							</select>
							<script type="text/javascript">
								document.getElementById("tipo").value = "<?php echo $tipo; ?>";
							</script>
						</div>
						<div class="col-xs-5">
							<label>Monto:</label>
							<input type="text" class="form-control" id="monto" name="monto" onkeyup="decimales(this);" value = "<?php echo $monto; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Motivo:</label>
							<input type="text" class="form-control" id="motivo" name="motivo" onkeyup="texto(this);" maxlength="250" value = "<?php echo $motivo; ?>" />
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
						<div class="row">
							<div class="col-xs-12 text-center">
								<a class="btn btn-default" title="Limpiar" href = "FRMboleta.php?hashkey=<?php echo $hashkey; ?>&pensum=<?php echo $pensum; ?>"><span class="fa fa-eraser"></span> Limpiar</a>
								<button type="button" class="btn btn-primary" id = "grab" onclick = "GrabarBoleta();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
								<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "ModificarBoleta();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
								<button type="button" class="btn btn-danger" onclick = "anularBoletas();"><span class="fa fa-trash"></span> Anular Boletas</button>
								<button type="button" class="btn btn-default" title="Imprimir Todas las Boletas" onclick = "printBoletas();"><span class="glyphicon glyphicon-print"></span> Imprimir Boletas</button>
							</div>
						</div>
					</div>
				</form>
				</div>
         </div>
			<!-- /.panel-default -->
			<div class="row">
				<?php echo tabla_boletas_cobro('',$division,$grupo,$cui,'',$periodo,""); ?>
			</div>
			<br><br>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/boleta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 1000,
				responsive: true
			});
	    });
	
		$(function () {
            $('#fecha').datetimepicker({
                format: 'DD/MM/YYYY'
            });
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