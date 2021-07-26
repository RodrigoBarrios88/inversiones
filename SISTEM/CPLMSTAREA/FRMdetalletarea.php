<?php
	include_once('xajax_funct_lms.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$codigo = $_REQUEST['codigo'];
	
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_tarea_curso($codigo);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$cod = $row["tar_codigo"];
			$titulo = utf8_decode($row["tar_nombre"]);
			$tipo_respuesta = trim($row["tar_codigo"]);
			$tipo_respuesta = ($tipo_respuesta == "OL")?"RESPUESTA EN L&Iacute;NEA" : "POR OTROS MEDIOS";
			$tlink = trim($row["tar_link"]);
			$link = ($tlink == "")?"javascript:void(0);":$tlink;
			$target = ($tlink == "")?"":"_blank";
			$descripcion = utf8_decode($row["tar_descripcion"]);
			$fecha = trim($row["tar_fecha_entrega"]);
			$fecha = cambia_fechaHora($fecha);
			$fecha = substr($fecha, 0, -3);
			//--
			$porcentzona = trim($row["tar_porcentaje_zona"]);
			$tipocalifica = trim($row["tar_tipo_calificacion"]);
			switch($tipocalifica){
				case 1: $tipocal = "SOBRE 100pts."; break;
				case 2: $tipocal = "SOBRE 10pts."; break;
				case 3: $tipocal = "CALIFICACI&Oacute;N REAL"; break;
			}
		}
	}else{
		
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
						<a href="#"><i class="fa fa-paste"></i> Tareas</a>
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

           <div class="col-xs-3">
                <p class="lead"><i class="fa fa-paste"></i> Tareas de Cursos Libres</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/IFRMencuestas.php" class="list-group-item"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPTAREAS/FRMlista_secciones.php?acc=ver" class="list-group-item"><i class="fa fa-paste"></i> Tareas de Materias</a>
                    <a href="../CPLMSTAREA/FRMcursotarea.php?acc=ver" class="list-group-item active"><i class="fa fa-paste"></i> Tareas de Cursos Libres</a>
                    <a href="../CPPOSTIT/FRMpinboard.php" class="list-group-item"><i class="fa fa-thumb-tack"></i> Pin Board</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-xs-9">
				<div>
                    <img class="img-responsive" src = "../../CONFIG/images/logo_largo.png" alt="">
                    <div class="caption-full">
                        <h4><a href="javascript:void(0);"><?php echo $titulo; ?></a></h4>
                        <p class="text-justify"><?php echo $descripcion; ?></p>
						<br>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading"><i class="fa fa-info-circle"></i> Informaci&oacute;n</div>
									<div class="panel-body">
										<h5>Entrega: <label class = "text-info"><?php echo $fecha; ?></label></h5>
										<hr>
										<h4><?php echo $sit_tarea; ?></h4>
										<label>Tipo de Respuesta: </label><br>
										<label class="text-info"><?php echo $tipo_respuesta ?></label>
										<hr>
										<label>Link de Referencia: </label><br>
										<label class="text-info"><a href="<?php echo $link ?>" target="<?php echo $target ?>"><?php echo $tlink ?></a></label>
										<hr>
										<label>Ponderaci&oacute;n Actividades: </label><br>
										<label class="text-info"><?php echo $porcentzona ?></label>
										<hr>
										<label>Tipo de Calificaci&oacute;n: </label><br>
										<label class="text-info"><?php echo $tipocal ?></label><br>
									</div>	
								</div>
							</div>
						</div>
                    </div>
                    <div class="ratings">
                        <p class="pull-right"> Visualizado el <?php echo date("d/m/Y"); ?> a las <?php echo date("H:i"); ?></p>
                        <p>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            
                        </p>
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

    <!-- jQuery -->
    <script src="../assets.3.6.2/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/js/bootstrap.min.js"></script>

</body>

</html>
