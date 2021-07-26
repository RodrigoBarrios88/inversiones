<?php
	include_once('html_fns_cursos.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$cui = $_REQUEST['cui'];
	$curso = $_REQUEST['curso'];
	
	
	if($curso != ""){
		/*$ClsAcad = new ClsAcademico();
		$ClsPen = new ClsPensum();
		$result = $ClsPen->get_materia($curso,$nivel,$grado,$materia,'',1);
		if(is_array($result)){
			foreach ($result as $row){
				$materia_codigo = $row["mat_codigo"];
				$materia_descripcion = utf8_decode($row["mat_descripcion"]);
			}
		}else{
			
		}
		
		$result = $ClsAcad->get_seccion_maestro($curso,$nivel,$grado,$seccion,'','','',1);
		if(is_array($result)) {
			foreach ($result as $row){
				$maestro = $row["mae_cui"];
				$result_materia = $ClsAcad->get_materia_maestro($curso,$nivel,$grado,$materia,$maestro,'','',1);
				$i = 0;	
				if(is_array($result_materia)) {
					foreach ($result_materia as $row_materia){
						$maestro_nombre = utf8_decode($row_materia["mae_nombre"])." ".utf8_decode($row_materia["mae_apellido"]);
						$i++;
					}
				}	
			}
		}else{
			
		}	*/
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

    <!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
    
    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../assets.3.5.20/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

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
						<a href="FRMhijos.php"><i class="fa fa-book"></i> Cursos Libres</a>
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
                <p class="lead"><i class="fa fa-paste"></i> Cursos Libres</p>
                <div class="list-group">
					<a href="#" class="list-group-item active"><i class="fa fa-book"></i> Detalle de Cursos Libres</a>
                </div>
            </div>

            <div class="col-md-9">
				<div>
                    <img class="img-responsive" src="../images/logo_largo.png" alt="">
                    <div class="caption-full">
                        <h4><a href="javascript:void(0);"><?php echo $materia_descripcion; ?></a></h4>
						<small>Maestro:</small>
                        <p><?php echo $maestro_nombre; ?></p>
					<br>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-paste"></i> Notas</div>
								<div class="panel-body">
									<?php echo lista_notas($cui,$curso); ?>
								</div>	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-clock-o"></i> Horarios</div>
								<div class="panel-body">
									<?php echo lista_horarios($curso); ?>
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
                    <p>Copyright &copy; ID 2017</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- scripts -->
    <script src="../js/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui-1.10.2.custom.min.js"></script>

</body>

</html>
