<?php
	include_once('xajax_funct_info.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAsi = new ClsAsignacion();
	$ClsInfo = new ClsInformacion();
	$ClsGruCla = new ClsGrupoClase();
	
	if($tipo_usuario == 2){ //// MAESTRO
		$pensum = $ClsPen->get_pensum_activo();
		$maestro = $tipo_codigo;
		$codigosInfo = '';
		$result_secciones = $ClsAcad->get_seccion_maestro($pensum,'','','',$maestro,'','',1);
		if(is_array($result_secciones)){
			foreach($result_secciones as $row){
				$nivel = $row["sec_nivel"];
				$grado = $row["sec_grado"];
				$seccion = $row["sec_codigo"];
				$codigosInfo.= $ClsInfo->get_codigos_secciones($pensum,$nivel,$grado,$seccion);
			}
		}
		$result = $ClsAsi->get_maestro_grupo("",$maestro,1);
		if(is_array($result)){
		   $grupos = "";
		   foreach($result as $row){
			  $grupos = $row["gru_codigo"];
			  $codigosInfo.= $ClsInfo->get_codigos_grupos($grupos);
		   }
		}
		$codigosInfo = substr($codigosInfo, 0, -1);
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$pensum = $ClsPen->get_pensum_activo();
		$director = $tipo_codigo;
		$codigosInfo = '';
		$result = $ClsAcad->get_grado_otros_usuarios($pensum,'','',$director);
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				$codigosInfo.= $ClsInfo->get_codigos_secciones($pensum,$nivel,$grado,'');
			}
		}
		$result = $ClsAsi->get_usuario_grupo("",$director,1);
		if(is_array($result)){
			$grupos = "";
			foreach($result as $row){
				$grupos = $row["gru_codigo"];
				$codigosInfo.= $ClsInfo->get_codigos_grupos($grupos);
			}
		}
		$codigosInfo = substr($codigosInfo, 0, -1);
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$pensum = $ClsPen->get_pensum_activo();
		$result = $ClsPen->get_grado($pensum,'','',1);
		$codigosInfo = '';
		if(is_array($result)){
			foreach($result as $row){
				$nivel = $row["gra_nivel"];
				$grado = $row["gra_codigo"];
				$codigosInfo.= $ClsInfo->get_codigos_secciones($pensum,$nivel,$grado,'');
			}
		}
		$result = $ClsGruCla->get_grupo_clase('','','','',1);
		if(is_array($result)){
		   $grupos = "";
		   foreach($result as $row){
			  $grupos = $row["gru_codigo"];
			  $codigosInfo.= $ClsInfo->get_codigos_grupos($grupos);
		   }
		}
		$codigosInfo = substr($codigosInfo, 0, -1);
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
						<a href="#"><i class="fa fa-paste"></i> Actividad</a>
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
                <p class="lead"><i class="fa fa-group-item"></i> Informaci&oacute;n de Actividades</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item active"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/IFRMencuestas.php" class="list-group-item"><i class="fa fa-paste"></i> Encuestas</a>
				   <!-- <a href="../CPTAREAS/IFRMinformacion.php" class="list-group-item"><i class="fa fa-paste"></i> Tareas</a>-->
                    <a href="../CPPOSTIT/FRMpinboard.php" class="list-group-item"><i class="fa fa-thumb-tack"></i> Pin Board</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>

            <div class="col-xs-9">
                <div class="well">

                    <div class="text-right">
                        <a class="btn btn-success"><i class="fa fa-thumbs-up"></i> Actividades </a>
                    </div>

                    <?php
						//////////////////////////////////////// GENERAL ///////////////////////////////////////////
						$result = $ClsInfo->get_informacion($codigosInfo);
						if(is_array($result)){
							foreach($result as $row){
								$cod = $row["inf_codigo"];
								$usu = $_SESSION["codigo"];
								$hashkey = $ClsInfo->encrypt($cod, $usu);
								$nombre = utf8_decode($row["inf_nombre"]);
								$tlink = trim($row["inf_link"]);
								$link = ($tlink == "#")?"javascript:void(0);":$tlink;
								$target = ($tlink == "#")?"":"_blank";
								$desc = utf8_decode($row["inf_descripcion"]);
								$fini = trim($row["inf_fecha_inicio"]);
								$ffin = trim($row["inf_fecha_fin"]);
								//--
								$fechaini = explode(" ",$fini); 
								$fecini = $fechaini[0];
									$fecini = str_replace("-","",$fecini);
									$horaini = substr($fechaini[1], 0, -3);
								//--
									$fechafin = explode(" ",$ffin); 
									$fecfin= $fechafin[0];
									$fecfin = str_replace("-","",$fecfin);
									$horafin = substr($fechafin[1], 0, -3);
									///---
								//--
								$salida.='<hr>';
									//--
								$salida.=' <div class="row">';
									$salida.='<div class="col-xs-12">';
										$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="">';
											$salida.='<h6>'.$nombre.'</h6>';
										$salida.='</a>';
										$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
										$salida.='<div class="pull-right">';
											$salida.='<a href="ICSinformacion.php?codigo='.$cod.'" target = "_blank" class="btn btn-default">';
												$salida.='<i class="fa fa-calendar"></i>';
											$salida.='</a> ';
											$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">';
												$salida.='<i class="fa fa-search-plus"></i>';
											$salida.='</a>';
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