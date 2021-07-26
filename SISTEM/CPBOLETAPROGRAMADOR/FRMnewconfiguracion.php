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
	
	//--
	$grupo = $_REQUEST["grupo"];
	$grupo = ($grupo != "")?$grupo:"1";
	$division = $_REQUEST["division"];
	$monto = $_REQUEST["monto"];
	$motivo = $_REQUEST["motivo"];
	$mes = $_REQUEST["mes"];
	$dia = $_REQUEST["dia"];
	$cant = $_REQUEST["cant"];
	$tipo = $_REQUEST["tipo"];
	$tipo = ($tipo != "")?$tipo:"C";
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$save = $_REQUEST["save"];
	
	
	
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
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
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
	
	<!-- Calendarios -->
	<link href="../assets.3.6.2/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css">
	<script src="../assets.3.6.2/js/dhtmlgoodies_calendar.js" type="text/javascript"></script>
	
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
                                <?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
                                <li>
									<a href="FRMnewconfiguracion.php">
										<i class="fa fa-check"></i> Crear Configuraci&oacute;n
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMeditconfiguracion.php">
										<i class="fa fa-edit"></i> Actualizar Configuraci&oacute;n
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php">
										<i class="fa fa-calendar"></i> Programador de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMlista_inscripciones.php">
										<i class="fa fa-certificate"></i> Programador para Inscripciones
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMsecciones.php?acc=GBOL">
										<i class="fa fa-edit"></i> Gestor de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMcarga.php">
										<i class="fa fa-table"></i> Carga Electr&oacute;nica .CSV
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="../CPBOLETAFACTURAS/FRMlist_cargas.php">
										<i class="fa fa-file-text-o"></i> Facturas y Recibos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="../CPBOLETA/FRMsecciones.php?acc=CUE">
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
				<div class="panel-heading"><i class="fa fa-check"></i> Crear Configuraci&oacute;n para Programar Boletas de Cobro</div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Grupo:</label>
							<?php echo division_grupo_html("grupo","xajax_Combo_Division_Grupo(this.value,'division','sdiv','');"); ?>
							<input type = "hidden" name = "cod" id = "cod" />
							<script type="text/javascript">
								document.getElementById("grupo").value = "<?php echo $grupo; ?>";
							</script>
						</div>	
						<div class="col-xs-5" id = "sdiv">
							<label>Divisi&oacute;n:</label>
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
							<label>Cantidad de Cuotas:</label>
							<input type="text" class="form-control" id="cant" name="cant" value="<?php echo $cant; ?>" onkeyup="enteros(this);" >
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Ciclo Escolar:</label> <span class="text-danger">*</span>
							<?php echo pensum_html("pensum", "Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("pensum").value = '<?php echo $pensum; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<label>Periodo Fiscal:</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" value="<?php echo $periodo_descripcion; ?>" disabled >
							<input type="hidden" id="periodo" name="periodo" value="<?php echo $periodo; ?>" >
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nivel:</label> <span class="text-danger">*</span>
							<?php echo nivel_html($pensum,"nivel","xajax_Nivel_Grado($pensum,this.value,'grado','divgra');"); ?>
						</div>
						<div class="col-xs-5">
							<label>Grado:</label> <small class="text-muted">(Opcional)</small>
							<div id = "divgra">
							<?php
								if($nivel != "" && $grado != ""){
									echo grado_html($pensum,$nivel,"grado","");
								}else{
									echo combos_vacios("grado");
								}	
							?>
							</div>
						</div>
						<script type="text/javascript">
							document.getElementById("nivel").value = "<?php echo $nivel; ?>";
							document.getElementById("grado").value = "<?php echo $grado; ?>";
						</script>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Monto:</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" id="monto" name="monto" value="<?php echo $monto; ?>" onkeyup="decimales(this);" >
						</div>
						<div class="col-xs-5">
							<label>Motivo:</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" id="motivo" name="motivo" value="<?php echo $motivo; ?>" onkeyup="texto(this);" >
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Mes de Inicio:</label>
							<select class="form-control" id="mes" name="mes">
								<option value = "">Seleccione</option>
								<option value = "1">ENERO</option>
								<option value = "2">FEBRERO</option>
								<option value = "3">MARZO</option>
								<option value = "4">ABRIL</option>
								<option value = "5">MAYO</option>
								<option value = "6">JUNIO</option>
								<option value = "7">JULIO</option>
								<option value = "8">AGOSTO</option>
								<option value = "9">SEPTIEMBRE</option>
								<option value = "10">OCTUBRE</option>
								<option value = "11">NOVIEMBRE</option>
								<option value = "12">DICIEMBRE</option>
							</select>
							<script type="text/javascript">
								document.getElementById("mes").value = "<?php echo $mes; ?>";
							</script>
						</div>
						<div class="col-xs-5">
							<label>D&iacute;a de Pago:</label>
							<input type="text" class="form-control" id="dia" name="dia" value="<?php echo $dia; ?>" onkeyup="enteros(this);" maxlength = "2" >
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<?php $hidden = ($save == 1)?"":"hidden"; ?> 
							<button type="button" class="btn btn-success" onclick = "TablaConfiguracion();"> <span class="fa fa-rss"></span> Calcular y Listar</button>
							<button type="button" class="btn btn-primary <?php echo $hidden; ?>" onclick = "ConfirmGrabarConfiguracion();" id = "btngrabar" > <span class="fa fa-save"></span> Grabar</button>
							<button type="button" class="btn btn-default" onclick = "window.location='FRMnewconfiguracion.php';"> <span class="fa fa-eraser"></span> Limpiar</button>
							<input type = "hidden" name = "save" id = "save" value = "<?php echo $dia; ?>">
						</div>
					</div>
					</form>
					<br>
					<br>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php
								if($monto != "" && $motivo != "" && $periodo != "" && $mes != "" && $dia != "" && $cant != ""){
									//echo tabla_pv_saldos($pv,$suc);
									echo tabla_new_configuracion_inicial($monto,$motivo,$periodo,$mes,$dia,$cant);
								}
							?>
						</div>
					</div>
				</div>
            </div>
			<!-- /.panel-default -->
			<br>
		</div>
		<!-- /#page-wrapper -->
	</div>
	<!-- /# wrapper -->
	
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/configuracion.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
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