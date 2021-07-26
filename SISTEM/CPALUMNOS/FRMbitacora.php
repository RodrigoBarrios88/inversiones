<?php
	include_once('xajax_funct_alumno.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsAlu = new ClsAlumno();
	$ClsCli = new ClsCliente();
	$ClsAcadem = new ClsAcademico();
	$ClsAsig = new ClsAsignacion();
	$ClsSeg = new ClsSeguro();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	
	if($leerBD == ""){
		$result = $ClsAlu->get_alumno($cui,"","",1);
		if(is_array($result)){
			foreach($result as $row){
				$cui = $row["alu_cui"];
				$nombre = utf8_decode($row["alu_nombre"]);
				$apellido = utf8_decode($row["alu_apellido"]);
				$genero = trim($row["alu_genero"]);
				$genero = ($genero == "M")?"Masculino":"Femenino";
				$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
				$edad = Calcula_Edad($fecnac);
				$cliente = $row["alu_cliente_factura"];
				//--
				$tipo_sangre = trim($row["alu_tipo_sangre"]);
				$alergico = utf8_decode($row["alu_alergico_a"]);
				$emergencia = utf8_decode($row["alu_emergencia"]);
				$emergencia_tel = trim($row["alu_emergencia_telefono"]);
				//--
				$foto = $row["alu_foto"];
			}
		}
		
		if(file_exists ('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
			$foto = 'ALUMNOS/'.$foto.'.jpg';
		}else{
			$foto = 'ALUMNOS/nofoto.png';
		}
		
		$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = utf8_decode($row["niv_descripcion"]);
				$grado = utf8_decode($row["gra_descripcion"]);
			}
		}
		
		$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
		if(is_array($result)){
			foreach($result as $row){
				$seccion = utf8_decode($row["sec_descripcion"]);
			}
		}
		
		$result = $ClsAsig->get_alumno_padre('',$cui);
		if(is_array($result)){
			$i = 1;
			foreach($result as $row){
				$arrpapas["dpi$i"] = $row["pad_cui"];
				$arrpapas["nom$i"] = utf8_decode($row["pad_nombre"]);
				$arrpapas["ape$i"] = utf8_decode($row["pad_apellido"]);
				$arrpapas["mail$i"] = trim($row["pad_mail"]);
				$arrpapas["tel$i"] = trim($row["pad_telefono"]);
				$arrpapas["existe$i"] = 1;
				$i++;
			}
			$i--; //quita una vuelta para cuadrar
			$padres = $i;
		}
		
		if(strlen($cliente)>0){
			$result = $ClsCli->get_cliente($cliente);
			if(is_array($result)){
				foreach($result as $row){
					$nit = $row["cli_nit"];
					$cliente = $row["cli_nombre"];
				}
			}
		}
		
		//////SEGURO
		$result = $ClsSeg->get_seguro($cui);
		if(is_array($result)){
			foreach($result as $row){
				$seguro = trim($row["seg_tiene_seguro"]);
				$seguro = ($seguro == 1)?"Si":"No";
				$poliza = utf8_decode($row["seg_poliza"]);
				$aseguradora = utf8_decode($row["seg_aseguradora"]);
				$plan = utf8_decode($row["seg_plan"]);
				$asegurado = utf8_decode($row["seg_asegurado_principal"]);
				$instrucciones = utf8_decode($row["seg_instrucciones"]);
				$comentarios = utf8_decode($row["seg_comentarios"]);
			}
		}
	}
	
	
if($usuario != "" && $nombre != "" && $valida != ""){ 	
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
	
	<!-- Personal CSS -->
	<link href="../assets.3.6.2/css/dhtmlgoodies_calendar.css" rel="stylesheet">
	
	<!-- JS snapshot -->
	<script type="text/javascript" src="../assets.3.6.2/js/webcam.js"></script>
	
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
							<li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario de Perfil de Usuarios</a></li>
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
						<li class= "active">
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<i class="glyphicon arrow"></i></a> 
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMnewalumno.php">
										<i class="fa fa-plus-circle"></i> Agregar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=1">
										<i class="fa fa-edit"></i> Actualizar Datos de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=4">
										<i class="fa fa-list-alt"></i> Ficha T&eacute;cnica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../CPFICHAPRESCOOL/FRMsecciones.php">
										<i class="fa fa-file-text-o"></i> Ficha Preescolar
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="FRMsecciones.php?acc=5">
										<i class="fa fa-comments"></i> Bit&aacute;cora Psicopedag&oacute;gica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=3">
										<i class="fa fa-camera"></i> Re-Ingreso de Fotograf&iacute;as
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=2">
										<i class="fa fa-group"></i> Asignaci&oacute;n Extracurricular
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=6">
										<i class="fa fa-ban"></i> Inhabilitar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=7">
										<i class="fa fa-check-circle-o"></i> Activar Alumnos
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMrepasiggrupo.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos/Grupos
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
					<i class="fa fa-comments"></i> Bit&aacute;cora Psicopedag&oacute;gica
					<a href="CPREPORTES/REPbitacora.php?hashkey=<?php echo $hashkey; ?>" target="_blank" class = "pull-right text-muted">
						<i  class = "fa fa-file-pdf-o fa-2x"></i> PDF
					</a>
				</div>
            <div class="panel-body">
					<div class="row">
						<div class="col-lg-4 col-xs-12 text-center">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-user"></i> Fotograf&iacute;a</div>
								<div class="panel-body">
									<br>
									<img src = "../../CONFIG/Fotos/<?php echo $foto; ?>" width = "100%" class="thumbnail" />
									<br><br>
								</div>
							</div>
						</div>
						<div class="col-lg-8 col-xs-12 ext-center">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-file-text-o"></i> Datos Generales</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6 col-xs-12">
											<label>CUI:  </label> 
											<label class = "form-control"><?php echo $cui; ?></label>
										</div>	
										<div class="col-lg-6 col-xs-12">
											<label>Genero:  </label>
											<label class = "form-control"><?php echo $genero; ?></label>
										</div>	
									</div>
									<div class="row">
										<div class="col-lg-6 col-xs-12">
											<label>Nombres:  </label>
											<label class = "form-control"><?php echo $nombre; ?></label>
										</div>	
										<div class="col-lg-6 col-xs-12">
											<label>Apellidos:  </label>
											<label class = "form-control"><?php echo $apellido; ?></label>
										</div>	
									</div>
									<div class="row">
										<div class="col-lg-6 col-xs-12">
											<label>Fecha de Nacimiento:  </label>
											<label class = "form-control"><?php echo $fecnac; ?></label>
										</div>	
										<div class="col-lg-6 col-xs-12">
											<label>Edad:  </label>
											<label class = "form-control"><?php echo $edad; ?> a&ntilde;os</label>
										</div>	
									</div>
									<div class="row">
										<div class="col-lg-6 col-xs-12">
											<label>Nivel:  </label>
											<label class = "form-control"><?php echo $nivel; ?></label>
										</div>	
										<div class="col-lg-6 col-xs-12">
											<label>Grado:  </label>
											<label class = "form-control"><?php echo $grado; ?></label>
										</div>	
									</div>
									<div class="row">
										<div class="col-lg-6 col-xs-12">
											<label>Secci&oacute;n:  </label>
											<label class = "form-control"><?php echo $seccion; ?></label>
										</div>
										<div class="col-lg-6 col-xs-12">
											<label>Tipo de Sangre:  </label>
											<label class = "form-control"><?php echo $tipo_sangre; ?></label>
										</div>
									</div>
								</div>
							 </div>
						</div>
					</div>
            </div>
            <!-- /.panel-body -->
         </div>
         <!-- /.panel-default -->
			<!-- .panel-info -->
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-comment"></i> Historial de Comentarios Psicopedag&oacute;gicos &nbsp; &nbsp; 
					<button type="button" class="btn btn-info btn-xs" onclick="NuevoComentario('<?php echo $cui; ?>');" title= "Agregar Nuevo comentario a la Bit&aacute;acora Psicopedag&oacute;gica"><i class="fa fa-comments"></i> <i class="fa fa-plus"></i> Agregar Comentarios</button>
				</div>
				<div class="panel-body">
					<?php echo tabla_psicopedagogica($cui); ?>
				</div>
			</div>
			<!-- /.panel-info -->
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/alumno.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
		});
		
		$(document).ready(function() {
			$('#dataTables-psico').DataTable({
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