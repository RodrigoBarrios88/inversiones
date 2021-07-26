<?php
	include_once('xajax_funct_tarea.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
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
                <p class="lead"><i class="fa fa-paste"></i> Tareas</p>
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
						<input type = "hidden" id="hashkey3" name = "hashkey3" value="<?php echo $hashkey3; ?>" />
						<input type = "hidden" id="hashkey4" name = "hashkey4" value="<?php echo $hashkey4; ?>" />
						<input type = "hidden" id="hashkey5" name = "hashkey5" value="<?php echo $hashkey5; ?>" />
						<input type="hidden" name = "order" id = "order" />
					<div class="row">
						<div class="col-xs-4"><label>Grado:</label></div>
						<div class="col-xs-4"><label>Materia:</label></div>
						<div class="col-xs-4"><label>Ornedar por Fecha:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-4"><label class="text-info"><?php echo $grado_desc; ?> secci&oacute;n <?php echo $seccion_desc; ?></label></div>
						<div class="col-xs-4"><label class="text-info"><?php echo $materia_desc; ?></label></div>
						<div class="col-xs-2">
							<a href="javascript:void(0);" onclick="OrderBy('ASC');"><i class="fa fa-sort-asc"></i> Ascendente</a>
						</div>
						<div class="col-xs-2">
							<a href="javascript:void(0);" onclick="OrderBy('DESC');"><i class="fa fa-sort-desc"></i> Descendente</a>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-4"><label>Unidad:</label></div>
						<div class="col-xs-4"><label>Tema:</label></div>
						<div class="col-xs-4"><label>Situaci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<?php echo unidades_html($nivel,"unidad","Submit();") ?>
							<script>
								document.getElementById("unidad").value = '<?php echo $unidad; ?>';
							</script>
						</div>
						<div class="col-xs-4">
							<?php echo tema_html($pensum,$nivel,$grado,$seccion,$materia,$unidad,"tema","Submit();"); ?>
							<script>
								document.getElementById("tema").value = '<?php echo $tema; ?>';
							</script>
						</div>
						<div class="col-xs-4">
							<select class="form-control" name="situacion" id="situacion" onchange="Submit();">
								<option value="">TODAS</option>
								<option value="1">PENDIENTES DE CALIFICAR</option>
								<option value="2">ENTREGADAS</option>
								<option value="3">CALIFICADAS</option>
							</select>
							<script>
								document.getElementById("situacion").value = '<?php echo $situacion; ?>';
							</script>
						</div>
					</div>
                    </form>
					<?php
								//////////////////////////////////////// GENERAL ///////////////////////////////////////////
								$ClsTar = new ClsTarea();
									$result = $ClsTar->get_tarea('',$pensum,$nivel,$grado,$seccion,$materia,'',$unidad,$tema,'','','','',$order);
									if(is_array($result)){
										foreach($result as $row){
											$codigo = $row["tar_codigo"];
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
											$pendientes = trim($row["tar_pendientes"]);
											$entregadas = trim($row["tar_entregadas"]);
											$calificadas = trim($row["tar_calificadas"]);
											//--
										    
										    //--
    										if($situacion == ""){
    										    $salida.='<hr>';
    										$salida.=' <div class="row">';
    											$salida.='<div class="col-xs-12">';
    												$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
    													$salida.='<h6>'.$nombre.'</h6>';
    												$salida.='</a>';
    												$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
    													$salida.='<div "class="pull-right">';
    													$salida.='<small class = "text-info">Total Entregadas: '.$entregadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total Calificadas: '.$calificadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total sin Calificar: '.$pendientes.'</small> &nbsp; ';
    													$salida.='</div>';
    												$salida.='<div class="pull-right">';
    													//$salida.='<button href="#" class="btn btn-default">';
    													//	$salida.='<i class="fa fa-calendar"></i>';
    													//$salida.='</button> ';
    													$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">';
    														$salida.='<i class="fa fa-search-plus"></i>';
    													$salida.='</a>';
    												$salida.='</div>';
    											$salida.='</div>';
    										$salida.='</div>';
    										}else if($situacion == 1 && intval($pendientes) > 0 ){
    										    $salida.='<hr>';
    										$salida.=' <div class="row">';
    											$salida.='<div class="col-xs-12">';
    												$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
    													$salida.='<h6>'.$nombre.'</h6>';
    												$salida.='</a>';
    												$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
    												$salida.='<div "class="pull-right">';
    													$salida.='<small class = "text-info">Total Entregadas: '.$entregadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total Calificadas: '.$calificadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total sin Calificar: '.$pendientes.'</small> &nbsp; ';
    													$salida.='</div>';
    												$salida.='<div class="pull-right">';
    													//$salida.='<button href="#" class="btn btn-default">';
    													//	$salida.='<i class="fa fa-calendar"></i>';
    													//$salida.='</button> ';
    													$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">';
    														$salida.='<i class="fa fa-search-plus"></i>';
    													$salida.='</a>';
    												$salida.='</div>';
    											$salida.='</div>';
    										$salida.='</div>';
    										}else if($situacion == 2 && intval($entregadas) > 0 ){
    										    $salida.='<hr>';
    										$salida.=' <div class="row">';
    											$salida.='<div class="col-xs-12">';
    												$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
    													$salida.='<h6>'.$nombre.'</h6>';
    												$salida.='</a>';
    												$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
    												$salida.='<div "class="pull-right">';
    													$salida.='<small class = "text-info">Total Entregadas: '.$entregadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total Calificadas: '.$calificadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total sin Calificar: '.$pendientes.'</small> &nbsp; ';
    													$salida.='</div>';
    												$salida.='<div class="pull-right">';
    													//$salida.='<button href="#" class="btn btn-default">';
    													//	$salida.='<i class="fa fa-calendar"></i>';
    													//$salida.='</button> ';
    													$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">';
    														$salida.='<i class="fa fa-search-plus"></i>';
    													$salida.='</a>';
    												$salida.='</div>';
    											$salida.='</div>';
    										$salida.='</div>';
    										}else if($situacion == 3 && intval($calificadas) > 0 ){
    										    $salida.='<hr>';
    										$salida.=' <div class="row">';
    											$salida.='<div class="col-xs-12">';
    												$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
    													$salida.='<h6>'.$nombre.'</h6>';
    												$salida.='</a>';
    												$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
    												$salida.='<div "class="pull-right">';
    													$salida.='<small class = "text-info">Total Entregadas: '.$entregadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total Calificadas: '.$calificadas.'</small> &nbsp; ';
    													$salida.='<small class = "text-info">Total sin Calificar: '.$pendientes.'</small> &nbsp; ';
    													$salida.='</div>';
    												$salida.='<div class="pull-right">';
    													//$salida.='<button href="#" class="btn btn-default">';
    													//	$salida.='<i class="fa fa-calendar"></i>';
    													//$salida.='</button> ';
    													$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">';
    														$salida.='<i class="fa fa-search-plus"></i>';
    													$salida.='</a>';
    												$salida.='</div>';
    											$salida.='</div>';
    										$salida.='</div>';
    										}
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
	<!-- propios -->
	<script type="text/javascript" src="../assets.3.6.2/js/modules/academico/tarea.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	<script>
		function OrderBy(ordena){
			order = document.getElementById("order").value = ordena;
			Submit();
			return;
		}
	</script>

</body>

</html>