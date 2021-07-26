<?php
	include_once('xajax_funct_asistencia.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//--
	$ClsAsist = new ClsAsistencia();
	//_$POST  //recibe el codigo de horario
	$hashkey1 = $_REQUEST["hashkey1"];
	$hashkey2 = $_REQUEST["hashkey2"];
	$horario = $ClsAsist->decrypt($hashkey1, $usuario);
	$fecha = $ClsAsist->decrypt($hashkey2, $usuario);
	
	$result = $ClsAsist->get_reserva_horario_asistencia_alumno($horario,$fecha);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = $row["hor_nivel"];
			$grado = $row["hor_grado"];
			$seccion = $row["hor_seccion"];
			$dia = $row["hor_dia"];
			$ini = $row["per_hini"];
			$fin = $row["per_hfin"];
			$hora = "$ini - $fin";
			//---
			$curso_desc = utf8_decode($row["cur_nombre"]);
		}
		$bandera = 1;
	}else{
		$bandera = 0;
	}
	
	// seleccional el nombre del día segun el numero de dia
	switch($dia){
		case 1: $dia_desc = "LUNES"; break;
		case 2: $dia_desc = "MARTES"; break;
		case 3: $dia_desc = "MIERCOLES"; break;
		case 4: $dia_desc = "JUEVES"; break;
		case 5: $dia_desc = "VIERNES"; break;
		case 6: $dia_desc = "SABADO"; break;
	}
	
	//echo $bandera;
	
	if($bandera === 1){
		$titulo = '<i class = "fa fa-check"></i>'." ALUMNOS QUE CONFIRMAN SU ASISTENCIA DEL CURSO $curso_desc PARA EL DIA $dia_desc $fecha de $hora";
	}else{
		$titulo = '<label class = "text-danger"><i class = "fa fa-ban"></i> NO HAY CONFIRMACIONES NI RESERVAS PARA ESTE PERIODO...</label>';
	}

	
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
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-times"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

           <div class="col-xs-3">
                <p class="lead"><i class="fa fa-check-square-o"></i> Confirmaci&oacute;n de Asistencia (por alumno)</p>
                <div class="list-group">
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMperiodos.php" class="list-group-item"><i class="fa fa-check"></i> Tomar Asistencia</a>
                    <?php } ?>
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMlist_cursos.php" class="list-group-item"><i class="fa fa-search"></i> Asistencia por Curso Libre</a>
				    <?php } ?>
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMlista_alumnos.php" class="list-group-item"><i class="fa fa-search"></i> Asistencia por Alumno</a>
                    <?php } ?>
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMlist_maestros.php" class="list-group-item"><i class="fa fa-search"></i> Asistencia por Maestro</a>
                	<?php } ?>
					<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
					<a href="FRMlist_cursos.php" class="list-group-item active"><i class="fa fa-check-square-o"></i> Confirmaci&oacute;n de Asistencia (por Alumno)</a>
				    <?php } ?>
				</div>
            </div>

            <div class="col-xs-9">
				<div>
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading"> 
									<?php echo $titulo; ?>
								</div>
								<br>
								<?php
									if($horario != "" && $fecha){
										echo tabla_detalle_confirmacion_asistencia_curso($horario,$fecha);
									}else{
										echo '<div class="panel-body">';
										echo '<h6 class="alert alert-warning text-center"> <i class="fa fa-warning"></i> No hay registros reportados...</h6>';
										echo '</div>';
									}
								?>
								<br>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/lms/asistencia.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

   <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100,
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
