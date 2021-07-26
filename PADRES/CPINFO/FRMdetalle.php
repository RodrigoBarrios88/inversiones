<?php
	include_once('html_fns_info.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//--
	$ClsPush = new ClsPushup();
	$sql = $ClsPush->update_push_status($tipo_codigo);
	$rs = $ClsPush->exec_sql($sql);
	//--
	//$_POST
	$codigo = $_REQUEST['codigo'];
	
	$ClsInfo = new ClsInformacion();
	$result = $ClsInfo->get_informacion($codigo,"","","");
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["inf_codigo"];
			$imagen = trim($row["inf_imagen"]);
			$link = trim($row["inf_link"]);
			$titulo = utf8_decode($row["inf_nombre"]);
			$descripcion = utf8_decode(nl2br($row["inf_descripcion"]));
			$fini = trim($row["inf_fecha_inicio"]);
			$ffin = trim($row["inf_fecha_fin"]);
			//--				
			$fechaini = explode(" ",$fini);
			$fini = cambia_fecha($fechaini[0]);
			$fecha_inicio = $fini;
			$hora_inicio = substr($fechaini[1], 0, -3);
			//--
			$fechafin = explode(" ",$ffin);
			$fini = cambia_fecha($fechafin[0]);
			$fecha_final = $fini;
			$hora_final = substr($fechafin[1], 0, -3);
			//--
		}
		if(file_exists('../../CONFIG/Actividades/'.$imagen) && $imagen != ""){
			$imagen = '../../CONFIG/Actividades/'.$imagen;
		}else{
			$imagen = "../../CONFIG/images/logo_largo.png";
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
						<a href="#"><i class="fa fa-paste"></i> Informaci&oacute;n</a>
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
                <p class="lead"><i class="fa fa-group-item"></i> Informaci&oacute;n de Actividades</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item active"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/FRMencuestas.php" class="list-group-item"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPTAREAS/FRMtareas.php" class="list-group-item"><i class="fa fa-paste"></i> Tareas</a>
                    <a href="../CPPOSTIT/FRMpinboard.php" class="list-group-item"><i class="fas fa-thumbtack"></i> Pin Board</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
                        <h4 class="alert alert-info">
							<?php echo $titulo; ?>
							<label class="pull-right"><?php echo $fecha_inicio." - ".$fecha_final; ?></label>
						</h4>
						<img class="img-responsive" src="<?php echo $imagen; ?>" alt=""><br>
                        <p class="text-justify"><?php echo $descripcion; ?></p>
						<br>
						<hr>
						<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="panel panel-default">
									<div class="panel-heading"><i class="fa fa-clock-o"></i> Fecha y Hora</div>
									<div class="panel-body">
										<h5>Inicia: <label class = "text-info"><?php echo $fecha_inicio; ?></label></h5>
										<h6>Hora: <label class = "text-info"><?php echo $hora_inicio; ?></label></h6>
										<hr>
										<h5>Finaliza: <label class = "text-info"><?php echo $fecha_final; ?></label></h5>
										<h6>Hora: <label class = "text-info"><?php echo $hora_final; ?></label></h6>
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

</body>

</html>
