<?php
	include_once('html_fns_asistencia.php');
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
	
	$fecha = ($_REQUEST["fecha"] != "")?$_REQUEST["fecha"]:date("d/m/Y");
	
	$alumno = $tipo_codigo;
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
		case 1: $dia_desc = "LUNES"; break;
		case 2: $dia_desc = "MARTES"; break;
		case 3: $dia_desc = "MIERCOLES"; break;
		case 4: $dia_desc = "JUEVES"; break;
		case 5: $dia_desc = "VIERNES"; break;
		case 6: $dia_desc = "SABADO"; break;
	}
	
	$mes = date('m', strtotime($fecha_cambiada));
	switch($mes){
		case 1: $mes_desc = "ENERO"; break;
		case 2: $mes_desc = "FEBRERO"; break;
		case 3: $mes_desc = "MARZO"; break;
		case 4: $mes_desc = "ABRIL"; break;
		case 5: $mes_desc = "MAYO"; break;
		case 6: $mes_desc = "JUNIO"; break;
		case 7: $mes_desc = "JULIO"; break;
		case 8: $mes_desc = "AGOSTO"; break;
		case 9: $mes_desc = "SEPTIEMBRE"; break;
		case 10: $mes_desc = "OCTUBRE"; break;
		case 11: $mes_desc = "NOVIEMBRE"; break;
		case 12: $mes_desc = "DICIEMBRE"; break;
	}
	
	$titulo1 = "DETALLE DE ASISTENCIA PARA EL MES DE $mes_desc EL $dia_desc $fecha";
	
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
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
    
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-paste"></i> Asistencia</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead"><i class="fas fa-check-square"></i> Asistencia de Clases</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item"><i class="fa fa-calendar"></i> Actividades</a>
                    <a href="../CPENCUESTAS/FRMencuestas.php" class="list-group-item"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPTAREAS/FRMinicio.php" class="list-group-item"><i class="fa fa-paste"></i> Tareas</a>
                    <a href="../CPTEST/FRMinicio.php" class="list-group-item"><i class="icon-spell-check"></i> Evaluaciones</a>
                	<a href="../CPASISTENCIA/FRMinicio.php" class="list-group-item active"><i class="fas fa-check-square"></i> Asistencia</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
                        <div class="panel panel-default">
							<div class="panel-heading"> 
								<span class="fa fa-calendar" aria-hidden="true"></span>
								<?php echo $titulo1; ?>
							</div>
							<div class="panel-body">
								<form name = "f1" id = "f1" method="get">
									<div class="row">
										<div class="col-xs-3 col-xs-offset-3"><label>Fecha a buscar:</label> <i class="fa fa-search"></i></div>
										<div class="col-xs-4 ">
											<div class='input-group date' id='fec'>
												<input type='text' class="form-control" id = "fecha" name='fecha' value="<?php echo $fecha; ?>" onblur = "Submit();" />
												<span class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</span>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
                        <div class="panel panel-default">
							<div class="panel-heading"> 
								<span class="fa fa-tasks" aria-hidden="true"></span>
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
														echo tabla_periodos_alumno_materias($dia,$pensum,$nivel,$grado,$seccion);
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
														echo tabla_asistencias_alumno_materias($fecha,$alumno);
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
														echo tabla_ausencias_alumno_materias($alumno,$mes);
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
                    <br>
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

    <!-- scripts -->
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>
	
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/lms/asistencia.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(function () {
            $('#fecha').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
	</script>	

</body>

</html>
