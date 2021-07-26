<?php
	include_once('xajax_funct_asistencia.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//--
	$ClsAsist = new ClsAsistencia();
	$ClsCur = new ClsCursoLibre();
	$ClsAlu = new ClsAlumno();
	$ClsHor = new ClsHorario();
	//_$POST  //recibe el codigo de horario
	$alumno = $tipo_codigo;
	$curso = $_REQUEST["curso"];
	$sede = $_REQUEST["sede"];
	$fecha = ($_REQUEST["fecha"] != "")?$_REQUEST["fecha"]:date("d/m/Y");
	
	$result = $ClsAlu->get_alumno($alumno);
	if(is_array($result)){
		foreach($result as $row){
			$nombre = utf8_decode($row["alu_nombre"]).' '.utf8_decode($row["alu_apellido"]);
		}
	}
	
	if($tipo_usuario == 10){ //// PADRE DE ALUMNO
		$tipo_codigo = $_SESSION['tipo_codigo'];
		$result = $ClsCur->get_curso_alumno($curso,$tipo_codigo,$sede);
		if(is_array($result)){
			foreach($result as $row){
				$info_curso.= $row["asi_curso"].",";
			}
			$info_curso = substr($info_curso,0,-1);
		}else{
			$info_curso = 0;
		}
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$tipo_codigo = "";
		$result = $ClsCur->get_curso($curso,$sede);
		if(is_array($result)){
			foreach($result as $row){
				$info_curso.= $row["cur_codigo"].",";
			}
			$info_curso = substr($info_curso,0,-1);
		}else{
			$info_curso = 0;
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
	
	$titulo1 = "DETALLE DE ASISTENCIA DE $nombre PARA EL MES DE $mes_desc EL $dia_desc $fecha";

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
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		 ?>	
   <!-- Bootstrap Core CSS -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
    <link href="../assets.3.5.20/css/util.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui-1.10.2.custom.min.js"></script>
	
    <!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../js/plugins/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../js/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../js/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    
    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../assets.3.5.20/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Sweet Alert -->
	<script src="../js/plugins/sweetalert/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/plugins/sweetalert/sweetalert.css">

    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
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
				<a class="navbar-brand" href="index.php">C<small>olegio</small>&nbsp;  L<small>os</small>&nbsp;  O<small>Livos del</small>&nbsp;  N<small>orte</small></a>
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
		<br><br><br><br>
        <div class="row">

            <div class="col-md-3">
                <p class="lead"><i class="fa fa-paste"></i> Tarea de Cursos</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/IFRMencuestas.php" class="list-group-item"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPTAREAS/FRMinicio.php" class="list-group-item"><i class="fa fa-paste"></i> Tareas</a>
                    <a href="../CPTEST/FRMinicio.php" class="list-group-item"><i class="icon-spell-check"></i> Evaluaciones</a>
                	<a href="../CPASISTENCIA/FRMinicio.php" class="list-group-item active"><i class="fa fa-check-square-o"></i> Asistencia</a>
                    <a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-xs-9">
				<div>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading"> 
									<span class="fa fa-calendar" aria-hidden="true"></span>
									<?php echo $titulo1; ?>
								</div>
								<div class="panel-body">
									<form name = "f1" id = "f1" method="get">
										<div class="row">
											<div class="col-xs-4"> &nbsp; <label>Curso:</label></div>
											<div class="col-xs-4"> &nbsp; <label>Sede:</label></div>
											<div class="col-xs-4"> &nbsp; <label>Fecha a buscar:</label> <i class="fa fa-search"></i></div>
										</div>
										<div class="row">
											<div class="col-xs-4">
												<?php echo combos_vacios("curso","",$tipo_codigo,$sede,"Submit();"); ?>
												<script>
													document.getElementById("curso").value = '<?php echo $curso; ?>';
												</script>
											</div>
											<div class="col-xs-4">
												<?php echo combos_vacios("sede","Submit();"); ?>
												<script>
													document.getElementById("sede").value = '<?php echo $sede; ?>';
												</script>
											</div>
											<div class="col-xs-4">
												<div class='input-group date' id='fec'>
													<input type='text' class="form-control" id = "fecha" name='fecha' value="<?php echo $fecha; ?>" onblur = "Submit();" />
													<input type="hidden" id = "hashkey" name = "hashkey" value = "<?php echo $hashkey; ?>" />
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
												</div>
											</div>
										</div>
										<br>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading"> 
									<span class="fa fa-check-square-o" aria-hidden="true"></span>
									Lista de Periodos a Confirmar
								</div>
								<div class="panel-body">
									<?php
										if($dia != ""){
											echo tabla_periodos_reservados($dia,$info_curso,$fecha,$alumno);
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
    <!-- /.container -->
    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; ID 2017.</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- scripts -->
    <script src="../js/bootstrap.min.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../js/modules/lms/asistencia.js"></script>
    <script type="text/javascript" src="../js/modules/util.js"></script>
	
	<script>
		$(function () {
            $('#fecha').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
		
    </script>

</html>
</body>

</html>
