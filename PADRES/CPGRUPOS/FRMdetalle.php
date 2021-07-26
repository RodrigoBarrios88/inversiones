<?php
	include_once('html_fns_grupos.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$cui = $_REQUEST['cui'];
	$grupo = $_REQUEST['grupo'];
	//--
	$ClsAsi = new ClsAsignacion();
	$ClsGru = new ClsGrupoClase();
	$result = $ClsGru->get_grupo_clase($grupo,'','','',1);
	if(is_array($result)){
		foreach ($result as $row){
			$codigo = $row["gru_codigo"];
			$area_descripcion = utf8_decode($row["are_nombre"]);
			$grupo_descripcion = utf8_decode($row["gru_nombre"]);
		}
	}else{
		
	}
	
	$result = $ClsAsi->get_maestro_grupo($grupo,'',1);
	if(is_array($result)) {
		foreach ($result as $row){
			$maestro = $row["mae_cui"];
			$maestro_nombre = utf8_decode($row["mae_nombre"])." ".utf8_decode($row["mae_apellido"]);
		}
	}else{
		$maestro_nombre = '- No hay maestro asignado a&uacute;n -';
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
						<a href="FRMhijos.php"><i class="fa fa-flask"></i> Grupos Extracurriculares</a>
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
	<br><br>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

           <div class="col-md-3">
                <p class="lead"><i class="fa fa-paste"></i> Grupos</p>
                <div class="list-group">
					<a href="#" class="list-group-item active"><i class="fa fa-book"></i> Informaci&oacute;n del Grupo</a>
                </div>
            </div>

            <div class="col-md-9">
				<div class="well">
                    <div class="row">
				        <div class="col-md-6">
				            <h4 class="alert alert-info"><?php echo $area_descripcion." / ".$grupo_descripcion; ?></h4>
    						<label>Maestro:</label>
                            <p><?php echo $maestro_nombre; ?></p>
                    	</div>
                    	<div class="col-md-6 text-center">
                            <img class="img-responsive" src="../../CONFIG/images/logo_largo.png" alt="" width="100%">
                    	</div>
					</div>
                </div>
				<div class="text-info">
					<p class="pull-right"> ASMS team</p>
				</div>
				<br>
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
