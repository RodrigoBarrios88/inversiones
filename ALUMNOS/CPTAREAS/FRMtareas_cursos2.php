<?php
	include_once('html_fns_tarea.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//$_POST
	$curso = $_REQUEST["curso"];
	$sede = $_REQUEST["sede"];
	$sit_tarea = $_REQUEST["sit_tarea"];
	$order = $_REQUEST["order"];
	//--
	$ClsTar = new ClsTarea();
	$ClsCur = new ClsCursoLibre();
	
	if($tipo_usuario == 10){ //// PADRE DE ALUMNO
		$tipo_codigo = $_SESSION['tipo_codigo'];
		$result = $ClsCur->get_curso_alumno($curso,$tipo_codigo,$sede);
		if(is_array($result)){
			foreach($result as $row){
				$info_curso.= $row["asi_curso"].",";
			}
			$info_curso = substr($info_curso,0,-1);
		}else{
			$info_curso = 0;
		}
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$tipo_codigo = "";
		$result = $ClsCur->get_curso($curso,$sede);
		if(is_array($result)){
			foreach($result as $row){
				$info_curso.= $row["cur_codigo"].",";
			}
			$info_curso = substr($info_curso,0,-1);
		}else{
			$info_curso = 0;
		}
	}else{
		$valida == "";
		$info_curso = 0;
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
    <link href="../css.3.5.18/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../css.3.5.18/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="../css.3.5.18/lib/shop-item.css" rel="stylesheet">
    
    <!-- libraries -->
    <link href="../css.3.5.18/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../css.3.5.18/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../css.3.5.18/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../css.3.5.18/compiled/elements.css" />
    
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
						<a href="#"><i class="fa fa-paste"></i> Tareas</a>
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
		<br><br><br><br>
        <div class="row">

            <div class="col-md-3">
                <p class="lead"><i class="fa fa-paste"></i> Tareas de Cursos</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/IFRMencuestas.php" class="list-group-item"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPTAREAS/FRMinicio.php" class="list-group-item active"><i class="fa fa-paste"></i> Tareas</a>
                    <a href="../CPTEST/FRMinicio.php" class="list-group-item"><i class="icon-spell-check"></i> Evaluaciones</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="well">
					<form id='f1' name='f1' method='get'>
						<div class="row">
							<div class="col-xs-4"><label>Curso:</label></div>
							<div class="col-xs-4"><label>Sede:</label></div>
							<div class="col-xs-4"><label>Situaci&oacute;n de la Tarea:</label></div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<?php echo combos_vacios("curso","",$tipo_codigo,$sede,"Submit();"); ?>
								<script>
									document.getElementById("curso").value = '<?php echo $curso; ?>';
								</script>
							</div>
							<div class="col-md-4">
								<?php echo combos_vacios("sede","Submit();"); ?>
								<script>
									document.getElementById("sede").value = '<?php echo $sede; ?>';
								</script>
							</div>
							<div class="col-xs-4">
								<select class="form-control" name="sit_tarea" id="sit_tarea" onchange="Submit();">
									<option value="">TODAS</option>
									<option value="1">PENDIENTES DE CALIFICAR</option>
									<option value="2">CALIFICADAS</option>
								</select>
								<script>
									document.getElementById("sit_tarea").value = '<?php echo $sit_tarea; ?>';
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
							$result = $ClsTar->get_det_tarea_curso('',$tipo_codigo,$info_curso,'','',$sit_tarea,$order);
							if(is_array($result)){
								foreach($result as $row){
									$cod = $row["tar_codigo"];
									$usu = $_SESSION["codigo"];
									$hashkey = $ClsTar->encrypt($cod, $usu);
									//--
									$curso_nombre = utf8_decode($row["tar_curso_nombre"]);
									$tema_nombre = utf8_decode($row["tar_tema_nombre"]);
									$nombre = utf8_decode($row["tar_nombre"]);
									$tlink = trim($row["tar_link"]);
									$link = ($tlink == "")?"javascript:void(0);":$tlink;
									$target = ($tlink == "")?"":"_blank";
									$desc = utf8_decode($row["tar_descripcion"]);
									$fecha = trim($row["tar_fecha_entrega"]);
									$fecha = cambia_fechaHora($fecha);
									//$fecha = substr($fecha, 0, -3);
									$tipo = trim($row["tar_tipo"]);
									$situacion = trim($row["dtar_situacion"]);
									//.
									$fecentrega = trim($row["tar_fecha_entrega"]);
									$fecentrega = strtotime($fecentrega);
									$fecahora = strtotime(date("Y-m-d H:i:s",time()));
									if(($fecahora < $fecentrega)){
										$disabled = "";
									}else{
										$disabled = "disabled";
									}
									//--
									$salida.='<hr>';
									//--
									$salida.=' <div class="row">';
										$salida.='<div class="col-md-12">';
											$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
												$salida.='<h5>'.$nombre.' ('.$fecha.')</h5> <label class = "text-muted">('.$curso_nombre.' - '.$tema_nombre.')</label>';
											$salida.='</a>';
											$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
											$salida.='<div class="pull-right">';
												/// situacion --
												if($situacion == 1){
													$salida.='<small class = "text-muted"><i class="fa fa-clock-o"></i> Pendiente de Calificar</small> &nbsp; ';
												}else if($situacion == 2){
													$salida.='<small class = "text-success"><i class="fa fa-check-circle-o"></i> Calificada</small> &nbsp; ';
												}
												/// ver --
													//$salida.='<button href="#" class="btn btn-default">';
													//	$salida.='<i class="fa fa-calendar"></i>';
													//$salida.='</button> ';
												/// tipo de respuesta --
												if($tipo == "OL"){ //valida si se respondera en linea
													$salida.='<a href="FRMdetalle_cursos.php?codigo='.$cod.'" title = "Ver Detalles" class="btn btn-default">';
													$salida.='<i class="fa fa-search-plus"></i>';
													$salida.='</a> &nbsp; ';
													$salida.='<a href="FRMresolver_cursos.php?codigo='.$cod.'" title = "Resolver" '.$disabled.' class="btn btn-primary">';
													$salida.='<i class="fa fa-edit"></i>';
													$salida.='</a>';
												}else{
													$salida.='<a href="FRMdetalle_cursos.php?codigo='.$cod.'" title = "Ver Detalles" class="btn btn-default">';
													$salida.='<i class="fa fa-search-plus"></i>';
													$salida.='</a>';
													$salida.=' &nbsp; <i class="fa fa-file-text-o" title = "Se Calificar&aacute; de otra forma"></i>';
												}
												//--
											$salida.='</div>';
										$salida.='</div>';
									$salida.='</div>';
								}
							}else{
								$salida.='<br>';
								$salida.='<h5 class="alert alert-warning text-center">';
								$salida.='<i class="fa fa-warning"></i> No hay tareas con estos criterios...';
								$salida.='</h5>';
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
                    <p>Copyright &copy; ID 2017.</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- scripts -->
    <script src="../js/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui-1.10.2.custom.min.js"></script>
	
	<!-- propio -->
	<script src="../js/modules/lms/tareacursos.js"></script>
	<script>
		function OrderBy(ordena){
			order = document.getElementById("order").value = ordena;
			Submit();
			return;
		}
	</script>

</body>

</html>