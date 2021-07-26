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
	$periodo = $_REQUEST["periodo"];
	if($periodo == ""){
		$periodo = $ClsPer->get_periodo_pensum($pensum);
	}else{
		$pensum = $ClsPer->get_pensum_periodo($periodo);
	}
	$result = $ClsPer->get_periodo($periodo);
	if(is_array($result)){
		foreach($result as $row){
			$periodo_descripcion = utf8_decode($row["per_descripcion_completa"]);
		}
	}else{
		$periodo_descripcion = "- No habilitado -";
	}
	
	////////////--------////////////
	$hashkey = $_REQUEST["hashkey"];
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $id);
	
	//$_POST
	$grupo = $_REQUEST["grupo"];
	$division = $_REQUEST["division"];
	$tipo = $_REQUEST["tipo"];
	$referencia = $_REQUEST["referencia"];
	$save = $_REQUEST["save"];
	//--
	$tipodesc = $_REQUEST["tipodesc"];
	$tipodesc = ($tipodesc == "")?"M":$tipodesc; //valida si no hay cambio en el descuento
	$desc = $_REQUEST["desc"];
	$desc = ($desc == "")?0:$desc; //valida si no hay cambio en el descuento
	$motdesc = $_REQUEST["motdesc"];
	
	
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
	}else{
		$nivel = 1;
		$grado = 1;
	}
	
	
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
							<li class="active">
								  <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
								  <ul class="nav nav-second-level collapse in" aria-expanded="true">
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
								 <a class="active" href="FRMsecciones.php">
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
				<div class="panel-heading"><i class="fa fa-calendar"></i> Programaci&oacute;n de Boletas de Cobro</div>
            <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' action='FRMprogramar.php' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
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
					<br>	
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Alumno:</label> <span class="text-danger">*</span>
							<label class="form-info"><?php echo $alumno; ?></label>
							<input type="hidden" id="hashkey" name="hashkey" value="<?php echo $hashkey; ?>" />
							<input type="hidden" id="cui" name="cui" value="<?php echo $cui; ?>" />
							<input type="hidden" id="codint" name="codint" value="<?php echo $codalu; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nivel:</label> <span class="text-danger">*</span>
							<label class="form-info"><?php echo utf8_decode($nivel_desc); ?></label>
						</div>
						<div class="col-xs-5">
							<label>Grado:</label> <span class="text-danger">*</span>
							<label class="form-info"><?php echo utf8_decode($grado_desc); ?></label>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Grupo:</label> <span class="text-danger">*</span>
							<?php echo division_grupo_html("grupo","Submit();"); ?>
							<input type = "hidden" name = "codigo" id = "codigo" />
							<script type="text/javascript">
								document.getElementById("grupo").value = "<?php echo $grupo; ?>";
							</script>
						</div>
						<div class="col-xs-5">
							<label>Divisi&oacute;n:</label> <span class="text-danger">*</span>
							<?php echo division_html($grupo,"division","Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("division").value = "<?php echo $division; ?>";
							</script>
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Tipo de Descuento:</label> <span class="text-danger">*</span>
							<select class="form-control" id="tipodesc" name="tipodesc">
								<option value = "M" selected >Monto (Q.)</option>
								<option value = "P">Poercentaje (%)</option>
							</select>
							<script type="text/javascript">
								document.getElementById("tipodesc").value = "<?php echo $tipodesc; ?>";
							</script>
						</div>
						<div class="col-xs-5">
							<label>Descuento:</label> <span class="text-danger">*</span>
							<input type="text" class="form-control" id="desc" name="desc" onkeyup="decimales(this);" value = "<?php echo $desc; ?>" maxlength = "6" />
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Justificaci&oacute;n del Descuento:</label>
							<input type="text" class="form-control" id="motdesc" name="motdesc" onkeyup="texto(this);" value = "<?php echo $motdesc; ?>" />
						</div>
					</div>
					<br>
					<div class="row">
                  <div class="col-xs-10 col-xs-offset-1 text-center">
							<?php $hidden = ($save == 1)?"":"hidden"; ?> 
                     <button type="button" class="btn btn-success" onclick = "TablaBoletas();"> <span class="fa fa-rss"></span> Calcular y Listar</button>
							<button type="button" class="btn btn-primary <?php echo $hidden; ?>" onclick = "ConfirmProgramarBoletas();" id = "btngrabar" > <span class="fa fa-save"></span> Grabar</button>
							<a class="btn btn-default" href = "FRMprogramar.php?hashkey=<?php echo $hashkey; ?>"> <span class="fa fa-eraser"></span> Limpiar</a> 
							<input type = "hidden" name = "save" id = "save" value = "<?php echo $dia; ?>">
							<a class="btn btn-outline btn-primary pull-right" href = "FRMnotificar.php?hashkey=<?php echo $hashkey; ?>" target="_blank"> <span class="fa fa-envelope"></span> Notificar</a>
						</div>
               </div>
					</form>
					<br>
					<br>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<div class="alert alert-info">
								<h6 class="alert-link">Boletas por Asignar</h6>
							</div>
							<?php
								if($grupo != "" && $desc != "" && $periodo != "" && $pensum != "" && $nivel != "" && $grado != ""){
									echo tabla_inicial_boletas_cobro($grupo,$division,$periodo,$cui,$tipodesc,$desc,$motdesc,$referencia,$pensum,$nivel,$grado);
								}else{
									if($nivel == "" || $grado == ""){
							?>
								<div class="alert alert-danger alert-dismissable text-center">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<h5>Este alumno no est&aacute; asignado a ning&uacute;n grado en este Ciclo Escolar...</h5>
								</div>
							<?php }else{ ?> 
								<div class="alert alert-warning alert-dismissable text-center">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<h5>Seleccione los Campos Obligatorios...</h5>
								</div>
							<?php
									}
								}
							?> 
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<div class="alert alert-success">
								<h6 class="alert-link">Boletas ya Asignadas</h6>
							</div>
							<?php
								if($cui != "" && $periodo != ""){
									echo tabla_boletas_cobro('','','',$cui,'',$periodo);
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/configuracion.js?v=1.1.1"></script>
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
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>