<?php
	include_once('xajax_funct_lms.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//$_POST
	$situacion = $_REQUEST["situacion"];
	$order = $_REQUEST["order"];
	
	$ClsTar = new ClsTarea();
	$ClsCur = new ClsCursoLibre();
	
	$hashkey1 = $_REQUEST["hashkey1"];
	$curso = $ClsCur->decrypt($hashkey1, $usuario);
	$hashkey2 = $_REQUEST["hashkey2"];
	$tema = $ClsCur->decrypt($hashkey2, $usuario);
	
	$result = $ClsCur->get_tema($tema,$curso);
	if(is_array($result)){
		foreach($result as $row){
			//curso
			$curso_nombre = utf8_decode($row["cur_nombre"]);
			//tema
			$tema_nombre = utf8_decode($row["tem_nombre"]);
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
                <div class="well">
					<form id='f1' name='f1' method='get'>
						<input type = "hidden" id="hashkey1" name = "hashkey1" value="<?php echo $hashkey1; ?>" />
						<input type = "hidden" id="hashkey2" name = "hashkey2" value="<?php echo $hashkey2; ?>" />
					<div class="row">
						<div class="col-xs-4"><label>Curso:</label></div>
						<div class="col-xs-4"><label>Sede:</label></div>
						<div class="col-xs-4"><label>Situaci&oacute;n de la Tarea:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-4"><label class="text-info"><?php echo $curso_nombre; ?></></div>
						<div class="col-xs-4"><label class="text-info"><?php echo $tema_nombre; ?></div>
						<div class="col-xs-4">
							<select class="form-control" name="situacion" id="situacion" onchange="Submit();">
								<option value="">TODAS</option>
								<option value="1">PENDIENTES DE CALIFICAR</option>
								<option value="2">CALIFICADAS</option>
							</select>
							<script>
								document.getElementById("situacion").value = '<?php echo $situacion; ?>';
							</script>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-4">
							<label>Ornedar por Fecha:</label>
							<input type="hidden" name = "order" id = "order" />
						</div>
						<div class="col-xs-2">
							<a href="javascript:void(0);" onclick="OrderBy('ASC');"><i class="fa fa-sort-asc"></i> Ascendente</a>
						</div>
						<div class="col-xs-2">
							<a href="javascript:void(0);" onclick="OrderBy('DESC');"><i class="fa fa-sort-desc"></i> Descendente</a>
						</div>
					</div>
					</form>
						<?php
								//////////////////////////////////////// GENERAL ///////////////////////////////////////////
									$ClsTar = new ClsTarea();
									$result = $ClsTar->get_tarea_curso('',$curso,$tema,$maestro,'','','',$situacion,$order);
									if(is_array($result)){
										foreach($result as $row){
											$cod = $row["tar_codigo"];
											$usu = $_SESSION["codigo"];
											$hashkey = $ClsTar->encrypt($cod, $usu);
											$nombre = utf8_decode($row["tar_nombre"]);
											$tlink = trim($row["tar_link"]);
											$link = ($tlink == "")?"javascript:void(0);":$tlink;
											$target = ($tlink == "")?"":"_blank";
											$desc = utf8_decode($row["tar_descripcion"]);
											$fecha = trim($row["tar_fecha_entrega"]);
											$fecha = cambia_fechaHora($fecha);
											$fecha = substr($fecha, 0, -3);
											//--
										$salida.='<hr>';
										//--
										$salida.=' <div class="row">';
											$salida.='<div class="col-xs-12">';
												$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
													$salida.='<h6>'.$nombre.'</h6>';
												$salida.='</a>';
												$salida.='<p class="text-muted text-justify"><em>'.$desc.'</em></p>';
												$salida.='<div class="pull-right">';
													//$salida.='<button href="#" class="btn btn-default">';
														//$salida.='<i class="fa fa-calendar"></i>';
													//$salida.='</button> ';
													$salida.='<a href="FRMdetalletarea.php?codigo='.$cod.'" class="btn btn-default">';
														$salida.='<i class="fa fa-search-plus"></i>';
													$salida.='</a>';
												$salida.='</div>';
											$salida.='</div>';
										$salida.='</div>';
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
	
	<script type="text/javascript" src="../assets.3.6.2/js/modules/lms/tarea.js"></script>
	
	<script>
		function OrderBy(ordena){
			order = document.getElementById("order").value = ordena;
			Submit();
			return;
		}
	</script>

</body>

</html>