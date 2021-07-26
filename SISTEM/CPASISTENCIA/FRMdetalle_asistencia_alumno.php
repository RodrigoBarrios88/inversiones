<?php
	include_once('xajax_funct_asistencia.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//--
	$ClsAsist = new ClsAsistencia();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	$ClsHor = new ClsHorario();
	//_$POST  //recibe el codigo de horario
	$hashkey = $_REQUEST["hashkey"];
	$alumno = $ClsAsist->decrypt($hashkey, $usuario);
	$fecha = ($_REQUEST["fecha"] != "")?$_REQUEST["fecha"]:date("d/m/Y");
	
	$result = $ClsAlu->get_alumno($alumno);
	if(is_array($result)){
		foreach($result as $row){
			$nombre = utf8_decode($row["alu_nombre"]).' '.utf8_decode($row["alu_apellido"]);
		}
	}
	
	$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$alumno,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = $row["sec_nivel"];
			$grado = $row["sec_grado"];
			$seccion = $row["sec_codigo"];
		}
	}
	
	$fecha_cambiada = regresa_fecha($fecha);
	// seleccional el nombre del día segun el numero de dia
	$dia = date('N', strtotime($fecha_cambiada));
	switch($dia){
		case 1: $dia_desc = "Lunes"; break;
		case 2: $dia_desc = "Martes"; break;
		case 3: $dia_desc = "Miercoles"; break;
		case 4: $dia_desc = "Jueves"; break;
		case 5: $dia_desc = "Viernes"; break;
		case 6: $dia_desc = "Sabado"; break;
	}
	
	$mes = date('m', strtotime($fecha_cambiada));
	switch($mes){
		case 1: $mes_desc = "Enero"; break;
		case 2: $mes_desc = "Febrero"; break;
		case 3: $mes_desc = "Marzo"; break;
		case 4: $mes_desc = "Abril"; break;
		case 5: $mes_desc = "Mayo"; break;
		case 6: $mes_desc = "Junio"; break;
		case 7: $mes_desc = "Julio"; break;
		case 8: $mes_desc = "Agosto"; break;
		case 9: $mes_desc = "Septiembre"; break;
		case 10: $mes_desc = "Octubre"; break;
		case 11: $mes_desc = "Noviembre"; break;
		case 12: $mes_desc = "Diciembre"; break;
	}
	
	$titulo1 = "Detalle de Asistencia de $nombre para el mes de $mes_desc el $dia_desc $fecha";
	
	$periodos = $ClsHor->count_horario('','',$dia,'','','',$pensum,$nivel,$grado,$seccion);
	$asistencias = $ClsAsist->count_asistencia('',$fecha,$alumno);
	$ausencias = $ClsAsist->count_ausencia_alumno('','',$alumno,$mes);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">

    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/shop-item.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
    
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	
	<!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    

</head>

<body>

   <!-- Navigation -->
   <nav class="navbar navbar-default navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo $_SESSION["rotulos_colegio"]; ?>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-paste"></i> Asistencia</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Page Content -->
	<div class="container">
      <div class="row">
         <div class="col-xs-3">
				<p class="lead"><i class="fa fa-check-square-o"></i> Asistencia</p>
				<div class="list-group">
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMperiodos.php" class="list-group-item"><i class="fa fa-check"></i> Tomar Asistencia</a>
					<?php } ?>
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMlist_seccion.php" class="list-group-item"><i class="fa fa-search"></i> Asistencia por Grado/Secci&oacute;n</a>
					<?php } ?>
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMlista_alumnos.php" class="list-group-item active"><i class="fa fa-search"></i> Asistencia por Alumno</a>
					<?php } ?>
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMlist_maestros.php" class="list-group-item"><i class="fa fa-search"></i> Asistencia por Maestro</a>
					<?php } ?>
				</div>
         </div>

         <div class="col-xs-9">
				<div class="panel panel-default">
					<div class="panel-heading"> 
						<i class="fa fa-calendar"></i>
						<?php echo $titulo1; ?>
					</div>
					<div class="panel-body">
						<form name = "f1" id = "f1" method="get">
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4 text-center">
								<label>Fecha a buscar:</label> <i class="fa fa-search"></i>
								<div class='input-group date' id='fec'>
									<input type='text' class="form-control" id = "fecha" name='fecha' value="<?php echo $fecha; ?>" onblur = "Submit();" />
									<input type="hidden" id = "hashkey" name = "hashkey" value = "<?php echo $hashkey; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading"> 
						<i class="fa fa-tasks"></i>
						RESUMEN DE ASISTENCIA
					</div>
					<div class="panel-body">
						<div class="panel-group" id="accordion">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h6 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" title="Click para ver detalle">
											<i class="fa fa-calendar"></i> 
											Cantidad de Periodos en el D&iacute;a <?php echo $periodos; ?>
										</a>
									</h6>
								</div>
								<div id="collapse1" class="panel-collapse collapse">
									<div class="panel-body">
										<?php
											if($dia != "" && $pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
												echo tabla_periodos_alumno($dia,$pensum,$nivel,$grado,$seccion);
											}else{
												echo '<div class="panel-body">';
												echo '<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> alg&uacute;n valor esta vacio, por favor refresque la p&aacute;gina...</h6>';
												echo '</div>';
											}
										?>
									</div>
								</div>
							</div>
							<div class="panel panel-success">
								<div class="panel-heading">
									<h6 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" title="Click para ver detalle">
											<i class="fa fa-check-square-o"></i> 
											Asistencias Registradas en el D&iacute;a <?php echo $asistencias; ?>
										</a>
									</h6>
								</div>
								<div id="collapse2" class="panel-collapse collapse">
									<div class="panel-body">
										<?php
											if($alumno != "" && $fecha != ""){
												echo tabla_asistencias_alumno($fecha,$alumno);
											}else{
												echo '<div class="panel-body">';
												echo '<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> alg&uacute;n valor esta vacio, por favor refresque la p&aacute;gina...</h6>';
												echo '</div>';
											}
										?>
									</div>
								</div>
							</div>
							<div class="panel panel-danger">
								<div class="panel-heading">
									<h6 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" title="Click para ver detalle">
											<i class="fa fa-ban"></i> &nbsp; 
											Ausencias del Mes <?php echo $ausencias; ?>
										</a>
									</h6>
								</div>
								<div id="collapse3" class="panel-collapse collapse in">
									<div class="panel-body">
										<?php
											if($alumno != "" && $mes != ""){
												echo tabla_ausencias_alumno($alumno,$mes);
											}else{
												echo '<div class="panel-body">';
												echo '<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> alg&uacute;n valor esta vacio, por favor refresque la p&aacute;gina...</h6>';
												echo '</div>';
											}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
					
         </div>
				
      </div>
	</div>
	<!-- /.container -->

   <div class="container">
		<hr>
		<!-- Footer -->
		<footer>
			<div class="row">
				<div class="col-lg-12">
					<p>Copyright &copy; ID <?php echo date("Y"); ?></p>
				</div>
			</div>
		</footer>
   </div>
   <!-- /.container -->

	<!-- Bootstrap Core JavaScript -->
	<script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- DataTables JavaScript -->
	<script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/academico/asistencia.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

   <!-- Page-Level Demo Scripts - Tables - Use for reference -->
   <script>
		$(document).ready(function() {
			$('#dataTables-periodos').DataTable({
				pageLength: 10,
				responsive: true
			});
		});
		$(document).ready(function() {
			$('#dataTables-ausencia').DataTable({
				pageLength: 10,
				responsive: true
			});
		});
		$(document).ready(function() {
			$('#dataTables-asistencia').DataTable({
				pageLength: 10,
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