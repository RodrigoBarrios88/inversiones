<?php
	include_once('xajax_funct_tarea.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAsi = new ClsAsignacion();
	$ClsInfo = new ClsInformacion();
	
	if($tipo_usuario == 3){ //// PADRE DE ALUMNO
		$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
		////////// CREA UN ARRAY CON TODOS LOS DATOS DE SUS HIJOS
		if (is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$cui = $row["alu_cui"];
				///------------------
				$result_grado_alumno = $ClsAcad->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);  ////// este array se coloca en la columna de combos
				if(is_array($result_grado_alumno)){
					foreach($result_grado_alumno as $row_grado_alumno){
						$info_pensum.= $row_grado_alumno["seca_pensum"].",";
						$info_nivel.= $row_grado_alumno["seca_nivel"].",";
						$info_grado.= $row_grado_alumno["seca_grado"].",";
						$info_seccion.= $row_grado_alumno["seca_seccion"].",";
					}
				}
				///------------------
				$result_grupo_alumno = $ClsAsi->get_alumno_grupo('',$cui,1);  ////// este array se coloca en la columna
				if(is_array($result_grupo_alumno)){
					foreach($result_grupo_alumno as $row_grupo_alumno){
						$info_grupo.= $row_grupo_alumno["gru_codigo"].",";
					}
				}
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
			$info_seccion = substr($info_seccion,0,-1);
			//--
			$info_grupo = substr($info_grupo,0,-1);
		}
	}else if($tipo_usuario == 2){ //// MAESTRO
		$maestro = $tipo_codigo;
		$result_secciones = $ClsAcad->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
		if(is_array($result_secciones)){
			foreach($result_secciones as $row){
				$info_pensum.= $row["niv_pensum"].",";
				$info_nivel.= $row["niv_codigo"].",";
				$info_grado.= $row["gra_codigo"].",";
				$info_seccion.= $row["sec_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
			$info_seccion = substr($info_seccion,0,-1);
			//--
			$info_grupo = substr($info_grupo,0,-1);							
		}
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result = $ClsAcad->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
		if(is_array($result)){
			foreach($result as $row){
				$info_pensum.= $row["gra_pensum"].",";
				$info_nivel.= $row["gra_nivel"].",";
				$info_grado.= $row["gra_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
		}
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$result = $ClsPen->get_grado($pensum,'','',1);
		if(is_array($result)){
			foreach($result as $row){
				$info_pensum.= $row["gra_pensum"].",";
				$info_nivel.= $row["gra_nivel"].",";
				$info_grado.= $row["gra_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
		}
	}else{
		$valida == "";
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
				    <a href="../CPTAREAS/IFRMinformacion.php" class="list-group-item active"><i class="fa fa-paste"></i> Tareas</a>
                    <a href="../CPPOSTIT/FRMpinboard.php" class="list-group-item"><i class="fa fa-thumb-tack"></i> Pin Board</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-xs-9">
                <div class="well">

                    <div class="text-right">
                        <a class="btn btn-success"><i class="fa fa-paste"></i> Tareas </a>
                    </div>

                    <?php
								//////////////////////////////////////// GENERAL ///////////////////////////////////////////
								$ClsTar = new ClsTarea();
									$result = $ClsTar->get_tarea('',$pensum,$info_nivel,$info_grado,$info_seccion,'',$maestro,'','','');
									if(is_array($result)){
										foreach($result as $row){
											$cod = $row["tar_codigo"];
											$usu = $_SESSION["codigo"];
											$hashkey = $ClsInfo->encrypt($cod, $usu);
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
												$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
												$salida.='<div class="pull-right">';
													$salida.='<button href="#" class="btn btn-default">';
														$salida.='<i class="fa fa-calendar"></i>';
													$salida.='</button> ';
													$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">';
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

</body>

</html>