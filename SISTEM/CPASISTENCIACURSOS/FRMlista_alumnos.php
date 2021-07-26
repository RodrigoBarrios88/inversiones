<?php
	include_once('xajax_funct_asistencia.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$curso = $_REQUEST["curso"];
	
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
					<a href="FRMlist_cursos.php" class="list-group-item"><i class="fa fa-search"></i> Asistencia por Cursos Libres</a>
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
					<br>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-4"><label>Curso:</label> <span class = "text-info">*</span></div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-4">
							<form name = "f1" id = "f1" method="get">
								<?php echo cursos_libres_html("curso","","Submit();"); ?>
								<script type = "text/javascript">
									document.getElementById("curso").value = '<?php echo $curso; ?>';
								</script>
							</form>	
						</div>
					</div>
					<br>
					<?php
						if($curso != ""){
							echo tabla_lista_alumnos_detalle($curso);
						}else{
							echo '<div class="row">';
							echo '<div class="col-xs-10 col-xs-offset-1 text-center">';
							echo '<br><i class = "fa fa-folder-open fa-5x text-muted" ></i>';
							echo '<br><label class = "text-muted" >Seleccione un Curso para listar a los alumnos...</label>';
							echo '</div>';
							echo '</div>';
						}
					?>
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
		
    </script>	

</body>

</html>
