<?php
	include_once('xajax_funct_examen.php');
	$usuario = $_SESSION["codigo"];
	$titulo = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//---
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	//$_POST
	$tema = $_REQUEST["tema"];
	$unidad = $_REQUEST["unidad"];
	$situacion = $_REQUEST["situacion"];
	$order = $_REQUEST["order"];
	
	$hashkey1 = $_REQUEST["hashkey1"];
	$pensum = $ClsAcadem->decrypt($hashkey1, $usuario);
	$hashkey2 = $_REQUEST["hashkey2"];
	$nivel = $ClsAcadem->decrypt($hashkey2, $usuario);
	$hashkey3 = $_REQUEST["hashkey3"];
	$grado = $ClsAcadem->decrypt($hashkey3, $usuario);
	$hashkey4 = $_REQUEST["hashkey4"];
	$seccion = $ClsAcadem->decrypt($hashkey4, $usuario);
	$hashkey5 = $_REQUEST["hashkey5"];
	$materia = $ClsAcadem->decrypt($hashkey5, $usuario);
	
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			//nivel
			$nivel_desc = utf8_decode($row["niv_descripcion"]);
			//grado
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			//descripcion
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}	
	}
	
	$result = $ClsPen->get_materia($pensum,$nivel,$grado,$materia);
	if(is_array($result)){
		foreach($result as $row){
			//descripcion
			$materia_desc = utf8_decode($row["mat_descripcion"]);
		}	
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
						<a href="#"><i class="fa fa-paste"></i> Evaluacion</a>
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
                <p class="lead"><i class="fa fa-paste"></i> Evaluaciones de Cursos</p>
                <div class="list-group">
					<a href="FRMlista_secciones.php?acc=gestor" class="list-group-item"><i class="fa fa-pencil"></i> Crear Evaluacion</a>
                    <a href="FRMlistarexamen.php?hashkey1=<?php echo $hashkey1; ?>&hashkey2=<?php echo $hashkey2; ?>&hashkey3=<?php echo $hashkey3; ?>&hashkey4=<?php echo $hashkey4; ?>&hashkey5=<?php echo $hashkey5; ?>&acc=clave" class="list-group-item"><i class="fa fa-key"></i> Resolver (Clave)</a>
				    <a href="FRMlista_secciones.php?acc=calificar" class="list-group-item"><i class="fa fa-paste"></i> Calificar Evaluacion</a>
                    <a href="FRMlista_secciones.php?acc=ver" class="list-group-item active"><i class="fa fa-search"></i> Visualizar Evaluacion</a>
                </div>
            </div>

            <div class="col-xs-9">
                <div class="well">

                    <div class="text-right">
                        <a class="btn btn-success"><i class="fa fa-paste"></i> Evaluaciones </a>
                    </div>

                    <?php
								//////////////////////////////////////// GENERAL ///////////////////////////////////////////
								$ClsExa = new ClsExamen();
								$result = $ClsExa->get_examen('',$pensum,$nivel,$grado,$seccion,$materia,'','','');
								if(is_array($result)){
									foreach($result as $row){
										$cod = $row["exa_codigo"];
										$usu = $_SESSION["codigo"];
										$hashkey = $ClsExa->encrypt($cod, $usu);
										$titulo = utf8_decode($row["exa_titulo"]);
										$unidad = utf8_decode($row["exa_unidad"])." Unidad";
										$desc = utf8_decode($row["exa_descripcion"]);
										$feclimit = trim($row["exa_fecha_limite"]);
										$feclimit = cambia_fechaHora($feclimit);
										//-
										$salida.='<hr>';
											//--
										$salida.=' <div class="row">';
											$salida.='<div class="col-xs-12">';
												$salida.='<a href="FRMresponder.php?hashkey='.$hashkey.'" target = "'.$curso.'" class="">';
													$salida.='<h5>'.$titulo.' <label>('.$unidad.')</label></h5>';
												$salida.='</a>';
												$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
												$salida.='<div class="pull-right">';
													$salida.='<a href="CPREPORTES/REPexamen.php?hashkey='.$hashkey.'" target = "_blank" class="btn btn-default">';
														$salida.='<i class="fa fa-print"></i> Imprimir Evaluaciones';
													$salida.='</a> ';
												$salida.='</div>';
											$salida.='</div>';
										$salida.='</div>';
										//--
									}
								}
							?>	
							
							<?php echo $salida; ?>

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