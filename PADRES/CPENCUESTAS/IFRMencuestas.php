<?php
	include_once('xajax_funct_encuesta.php');
	$id = $_SESSION["codigo"];
	$titulo = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAsi = new ClsAsignacion();
	$ClsEnc = new ClsEncuesta();
	
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
    <link href="../css.3.5.8/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../css.3.5.8/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../css.3.5.8/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../css.3.5.8/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../css.3.5.8/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../css.3.5.8/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css.3.5.8/lib/shop-item.css" rel="stylesheet">
    
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
						<a href="#"><i class="fa fa-paste"></i> Encuesta</a>
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
                <p class="lead"><i class="fa fa-paste"></i> Encuestas</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/IFRMencuestas.php" class="list-group-item active"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPTAREAS/IFRMinformacion.php" class="list-group-item"><i class="fa fa-paste"></i> Tareas</a>
                    <a href="../CPPOSTIT/FRMpinboard.php" class="list-group-item"><i class="fa fa-thumb-tack"></i> Pin Board</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="thumbnail">
					<div class="caption-full">
						<h4 class="alert alert-info">
							<i class="fa fa-paste"></i> Listado de Encuestas
						</h4>
	
						<?php
							//////////////////////////////////////// GENERAL ///////////////////////////////////////////
							$result = $ClsEnc->get_encuesta("","","0","");
							if(is_array($result)){
								foreach($result as $row){
									$cod = $row["enc_codigo"];
									$usu = $_SESSION["codigo"];
									$hashkey = $ClsEnc->encrypt($cod, $usu);
									$titulo = utf8_decode($row["enc_titulo"]);
									$desc = utf8_decode($row["enc_descripcion"]);
									$feclimit = trim($row["enc_fecha_limite"]);
									//-
									$salida.='<hr>';
										//--
									$salida.=' <div class="row">';
										$salida.='<div class="col-md-12">';
											$salida.='<a href="FRMresponder.php?hashkey='.$hashkey.'" target = "'.$target.'" class="">';
												$salida.='<h6>'.$titulo.'</h6>';
											$salida.='</a>';
											$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
											$salida.='<div class="pull-right">';
												$salida.='<a href="FRMresponder.php?hashkey='.$hashkey.'" class="btn btn-default">';
													$salida.='<i class="fa fa-paste"></i>';
												$salida.='</a> ';
											$salida.='</div>';
										$salida.='</div>';
									$salida.='</div>';
									//--
								}
							}
							//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////////////////////
							$result = $ClsEnc->get_encuesta_target_grados('',$pensum,$info_nivel,$info_grado);
							if(is_array($result)){
								foreach($result as $row){
									$cod = $row["enc_codigo"];
									$usu = $_SESSION["codigo"];
									$hashkey = $ClsEnc->encrypt($cod, $usu);
									$titulo = utf8_decode($row["enc_titulo"]);
									$desc = utf8_decode($row["enc_descripcion"]);
									$feclimit = trim($row["enc_fecha_limite"]);
									//$feclimit = cambiar_fecha($feclimit);
									//--
									$salida.='<hr>';
									//--
									$salida.=' <div class="row">';
										$salida.='<div class="col-md-12">';
											$salida.='<a href="FRMresponder.php?hashkey='.$hashkey.'" target = "'.$target.'" class="">';
												$salida.='<h6>'.$titulo.'</h6>';
											$salida.='</a>';
											$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
											$salida.='<div class="pull-right">';
												$salida.='<a href="FRMresponder.php?hashkey='.$hashkey.'" class="btn btn-default" title = "Responder Encuesta">';
													$salida.='<i class="fa fa-paste"></i>';
												$salida.='</a> ';
											$salida.='</div>';
										$salida.='</div>';
									$salida.='</div>';
									//--
								}
							}
							//////////////////////////////////////// GRUPOS ///////////////////////////////////////////
							$result = $ClsEnc->get_encuesta_target_grupos('',$info_grupo);
							if(is_array($result)){
								foreach($result as $row){
									$cod = $row["enc_codigo"];
									$usu = $_SESSION["codigo"];
									$hashkey = $ClsEnc->encrypt($cod, $usu);
									$titulo = utf8_decode($row["enc_titulo"]);
									$tlink = trim($row["enc_link"]);
									$desc = utf8_decode($row["enc_descripcion"]);
									$feclimit = trim($row["enc_fecha_limite"]);
									$salida.='<hr>';
									//--
									$salida.=' <div class="row">';
										$salida.='<div class="col-md-12">';
											$salida.='<a href="FRMresponder.php?hashkey='.$hashkey.'" target = "'.$target.'" class="">';
												$salida.='<h6>'.$titulo.'</h6>';
											$salida.='</a>';
											$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
											$salida.='<div class="pull-right">';
												$salida.='<a href="FRMresponder.php?hashkey='.$hashkey.'" class="btn btn-default" title = "Responder Encuesta">';
													$salida.='<i class="fa fa-paste"></i>';
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
    <script src="../js.3.5.8/jquery-latest.js"></script>
    <script src="../js.3.5.8/bootstrap.min.js"></script>
    <script src="../js.3.5.8/jquery-ui-1.10.2.custom.min.js"></script>

</body>

</html>