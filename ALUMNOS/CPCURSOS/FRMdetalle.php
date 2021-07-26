<?php
	include_once('html_fns_cursos.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//////////////////////////- MODULOS HABILITADOS
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_modulos();
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["mod_codigo"];
			$nombre = $row["mod_nombre"];
			$modclave = $row["mod_clave"];
			$situacion = $row["mod_situacion"];
			if($situacion == 1){
				$_SESSION["MOD_$modclave"] = 1;
			}else{
				$_SESSION["MOD_$modclave"] = "";
			}
		}
	}
	//////////////////////////- MODULOS HABILITADOS
	
	//$_POST
	$cui = $tipo_codigo;
	$curso = $_REQUEST['curso'];
	
	if($curso != ""){
		$ClsCur = new ClsCursoLibre();
		$result = $ClsCur->get_curso($curso);
		if(is_array($result)){
			foreach ($result as $row){
				$curso_codigo = $row["cur_codigo"];
				$curso_descripcion = utf8_decode($row["cur_nombre"]);
			}
		}else{
			
		}
		
		$result = $ClsCur->get_curso_maestro($curso,'');
		if(is_array($result)) {
			foreach ($result as $row){
				$maestro = $row["mae_cui"];
				$maestro_nombre = utf8_decode($row_materia["mae_nombre"])." ".utf8_decode($row_materia["mae_apellido"]);	
			}
		}else{
			$maestro_nombre = "- Sin asignar -";
		}
	}else{
		
	}
	///////////////////////////// MODULOS //////////////////////////////
	$modulos = 0;
	if($_SESSION["MOD_videocall"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_videos"] == 1 || $_SESSION["MOD_photos"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_tareas"] == 1){
		$modulos++;
	}
	if($_SESSION["MOD_pinboard"] == 1){
		$modulos++;
	}
	switch($modulos){
		case 1: $cols_divs = "col-md-12 col-sm-12 stat"; break;
		case 2: $cols_divs = "col-md-6 col-sm-12 stat"; break;
		case 3: $cols_divs = "col-md-4 col-sm-12 stat"; break;
		case 4: $cols_divs = "col-md-3 col-sm-12 stat"; break;
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
    
	<!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
    
    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

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
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-times"></i> Cerrar</a>
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
                <p class="lead"><i class="fa fa-paste"></i> Cursos</p>
                <div class="list-group">
					<a href="#" class="list-group-item active"><i class="fa fa-flask"></i> Informaci&oacute;n del Curso</a>
                </div>
            </div>

            <div class="col-md-9">
				<div class="well">
				    <div class="row">
				        <div class="col-md-6">
				            <h4 class="alert alert-info"><?php echo $curso_descripcion; ?></h4>
    						<label>Maestro:</label>
                            <p><?php echo $maestro_nombre; ?></p>
                    	</div>
                    	<div class="col-md-6 text-center">
                            <img class="img-responsive" src="../../CONFIG/images/logo_largo.png" alt="" width="100%">
                    	</div>
					</div>
                    <hr>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-paste"></i> Notas</div>
								<div class="panel-body">
									<?php //echo lista_notas($cui,$curso); ?>
									<h5 class="alert alert-info text-center"><i class="fa fa-info-circle"></i> Pendientes de P&uacute;blicar...</h5>
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