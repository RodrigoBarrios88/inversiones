<?php
	include_once('html_fns_tarea.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
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
	
		//$_POST
	$materia = $_REQUEST["materia"];
	$unidad = $_REQUEST["unidad"];
	$sit = $_REQUEST["situacion"];
	$order = $_REQUEST["order"];
	$order = ($order == "")?"DESC":$order;
	//////////////////////////- MODULOS HABILITADOS
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
	
if($tipo_codigo != "" && $nombre != ""){	
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    <link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- bootstrap -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../assets.3.5.20/css/animate.css" rel="stylesheet">
    <link href="../assets.3.5.20/css/pinboard.css" rel="stylesheet">
	
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/index.css" type="text/css" media="screen" />
	
	<!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <!-- navbar -->
    <header class="navbar navbar-inverse" role="banner">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" id="menu-toggler">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
        	<a class="navbar-brand2" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
			<button type="button"  class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>
        <ul class="nav navbar-nav pull-right collapse" id="second-menu" >
			<?php if($_SESSION["MOD_panial"] == 1 || $_SESSION["MOD_golpe"] == 1 || $_SESSION["MOD_enfermedad"] == 1 || $_SESSION["MOD_conducta"] == 1){ // permisos del colegio ?>
			<li class="notification-dropdown hidden-phone">
                <a href="#" class="trigger">
                    <i class="fa fa-bell"></i>
					<?php
					if($pendientes > 0){
						echo '<span class="count" style="background: #FF8000;">'.$pendientes.'</span>';	
					}
					?>
                </a>
                <div class="pop-dialog">
                    <div class="body">
                        <a href="#" class="close-icon"><i class="fa fa-times"></i></a>
                        <div class="notifications">
                            <h3><i class="fa fa-paste"></i> Notificaciones Especiales </h3>
							<?php if($_SESSION["MOD_panial"] == 1){ // permisos del colegio ?>
                            <a href="../CPPANIAL/FRMreportes.php" class="item">
								<i class="fas fa-layer-group"></i>
                                <strong>*. </strong> 
								<small>Reporte de Pa&ntilde;al</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_golpe"] == 1){ // permisos del colegio ?>
                            <a href="../CPGOLPE/FRMreportes.php" class="item">
								<i class="fa fa-medkit"></i></span> 
                                <strong>*. </strong> 
								<small>Reporte de Golpe</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_enfermedad"] == 1){ // permisos del colegio ?>
                            <a href="../CPENFERMEDAD/FRMreportes.php" class="item">
								<i class="fa fa-stethoscope"></i></span> 
                                <strong>*. </strong> 
								<small>Reporte de Enfermedad</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_conducta"] == 1){ // permisos del colegio ?>
                            <a href="../CPCONDUCTA/FRMreportes.php" class="item">
								<i class="fas fa-smile"></i>
                                <strong>*. </strong> 
								<small>Reporte de Conducta (Diario)</small>
                            </a>
							<?php } ?>
							<div class="footer">
                                <a href="javascript:void(0);" class="logout"><i class="fa fa-check-square-o"></i> Marcar como le&iacute;das</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
			<?php } ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Perfil
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="../CPPERFIL/FRMperfil.php"> <i class="icon-user"></i> Informaci&oacute;n Personal</a></li>
                	<li><a href="../CPPERFIL/FRMfamilia.php"> <i class="fas fa-users"></i> Ver Familia</a></li>
                </ul>
            </li>
             <li class="settings">
                <a href="../CPPERFIL/FRMperfil.php" role="button">
                    <i class="icon-cog"></i>
                </a>
            </li>
            <li class="settings">
                <a href="../logout.php" role="button">
                    <i class="icon-exit"></i>
                </a>
            </li>
        </ul>
    </header>
    <!-- end navbar -->

    <!-- sidebar -->
    <div id="sidebar-nav">
		<ul id="dashboard-menu">
            <li>
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
                <a href="../menu.php">
                    <i class="icon-home"></i>
                    <span>Inicio</span>
                </a>
            </li>            
            <?php if($_SESSION["MOD_calendario"] == 1){ // permisos del colegio ?>
			<li>
                <a href="../CPCALENDARIO/FRMcalendario.php">
                    <i class="fas fa-calendar"></i>
                    <span>Calendario</span>
                </a>
            </li>
			<?php } ?>
			<li>
                <a href="../CPHIJOS/FRMhijos.php">
                    <i class="icon-users"></i>
                     <span>Hijos</span>
                </a>
            </li>
			<?php if($_SESSION["MOD_notas"] == 1){ ?>
			<li>
                <a href="../CPNOTAS/FRMhijos.php">
                    <i class="fa fa-paste"></i>
                    <span>Notas</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1){ ?>
			<li>
                <a href="../CPMATERIAS/FRMhijos.php">
                    <i class="fa fa-flask"></i>
                    <span>Materias</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_pagos"] == 1){ ?>
			<li>
                <a href="../CPPAGOS/FRMhijos.php">
                    <i class="fas fa-money-bill-alt"></i>
                    <span>Pagos</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_encuestas"] == 1){ ?> 
			<li class="active">
                <a href="../CPENCUESTAS/FRMencuestas.php">
					<i class="fas fa-clipboard-check"></i>
                    <span>Encuestas</span>
                </a>
            </li>
			<?php } ?>
			<li>
                <a href="../CPGRUPOS/FRMhijos.php">
                    <i class="fas fa-users"></i>
                    <span>Grupos</span>
                </a>
            </li>
			<br><br><br>
			<li>
                <a href="../logout.php">
                    <i class="icon-exit"></i>
                     <span>Salir</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- end sidebar -->


	<!-- main container -->
    <div class="content">
		
        <!-- upper main stats -->
        <div id="main-stats">
        <div class="row stats-row">
			<?php if($_SESSION["MOD_videocall"] == 1){ ?>
            <div class="<?php echo $cols_divs; ?> ">
				<a href="../CPVIDEOCALL/FRMhijos.php">
					<div class="data">
						<span class="number"><i class="fa fa-video"></i></span>
						VideoClases
					</div>
				</a>
            </div>
			<?php } ?>
			<?php if($_SESSION["MOD_videos"] == 1 || $_SESSION["MOD_photos"] == 1){ ?>
            <div class="<?php echo $cols_divs; ?>">
				<a href="../CPMULTIMEDIA/FRMvisualizar.php">
					<div class="data">
						<span class="number"><i class="fas fa-photo-video"></i></span>
						Multimedia
					</div>
				</a>
            </div>
			<?php } ?>
			<?php if($_SESSION["MOD_tareas"] == 1){ ?>
            <div class="<?php echo $cols_divs; ?>">
				<a href="../CPTAREAS/FRMtareas.php">
					<div class="data">
						<span class="number"><i class="icon-paste"></i></span>
						Tareas
					</div>
				</a>
            </div>
			<?php } ?>
			<?php if($_SESSION["MOD_pinboard"] == 1){ ?>
                <div class="<?php echo $cols_divs; ?>">
					<a href="../CPPOSTIT/FRMpinboard.php">
						<div class="data">
							<span class="number"><i class="icon-pushpin"></i></span>
							Pinboard
						</div>
					</a>
                </div>
				<?php } ?>
				
        </div>
    </div>
        <!-- end upper main stats -->
		<div class="row">
			<div class="col-lg-10 col-md-offset-1">
				<br>
				<div class="panel panel-default">
					<div class="panel-heading"> 
						<i class="icon-paste"></i>
						Tareas
					</div>
					<div class="panel-body">
						<form id='f1' name='f1' method='get'>
							<div class="row">
								<div class="col-xs-4"><label>Materia:</label></div>
								<div class="col-xs-4"><label>Unidad:</label></div>
								<div class="col-xs-4"><label>Situaci&oacute;n:</label></div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									<?php echo materia_html($pensum,$info_nivel,$info_grado,"materia","Submit();"); ?>
									<script>
										document.getElementById("materia").value = '<?php echo $materia; ?>';
									</script>
								</div>
								<div class="col-xs-4">
									<?php echo unidades_html($info_nivel,"unidad","Submit();") ?>
									<script>
										document.getElementById("unidad").value = '<?php echo $unidad; ?>';
									</script>
								</div>
								<div class="col-xs-4">
									<select class="form-control" name="situacion" id="situacion" onchange="Submit();">
										<option value="">TODAS</option>
										<option value="1">PENDIENTES DE CALIFICAR</option>
										<option value="2">CALIFICADAS</option>
										<option value="3">ENVIADAS</option>
									</select>
									<script>
										document.getElementById("situacion").value = '<?php echo $sit; ?>';
									</script>
								</div>
							</div>
						</form>
						<?php
							//////////////////////////////////////// GENERAL ///////////////////////////////////////////
							$result1 = $ClsAsi->get_alumno_padre($tipo_codigo,"");
                                		if (is_array($result1)) {
                                			foreach($result1 as $row){
                                				$cui = $row["alu_cui"];
                                			}
                                		}
							$ClsTar = new ClsTarea();
							if($sit == 3){
							    $sit = 1;
							    $vali = 1;
							}elseif($sit == 1){
							    $vali = 3;
							}else{
							    $vali = 2;
							}
							$result = $ClsTar->get_det_tarea('',$cui,$pensum,$info_nivel,$info_grado,$info_seccion,$materia,$unidad,'','',$sit,$order);
							if(is_array($result)){
								foreach($result as $row){
									$cod = $row["tar_codigo"];
									$usu = $_SESSION["codigo"];
									$hashkey = $ClsInfo->encrypt($cod, $usu);
									//--
									$materia_desc = utf8_decode($row["tar_materia_desc"]);
									$tema_nombre = utf8_decode($row["tem_nombre"]);
									$unidad_nombre = utf8_decode($row["tem_unidad"])." UNIDAD";
									$grado_desc = utf8_decode($row["tar_grado_desc"]);
									$seccion_desc = utf8_decode($row["tar_seccion_desc"]);
									//--
									$nombre = utf8_decode($row["tar_nombre"]);
									$tlink = trim($row["tar_link"]);
									$link = ($tlink == "")?"javascript:void(0);":$tlink;
									$target = ($tlink == "")?"":"_blank";
									$desc = utf8_decode($row["tar_descripcion"]);
									$fecha = trim($row["tar_fecha_entrega"]);
									$fecha = cambia_fechaHora($fecha);
									$fecha = substr($fecha, 0, -3);
                       				$sit = trim($row["dtar_situacion"]);
									$resolucion = trim($row["dtar_resolucion"]);
									$ClsAsi = new ClsAsignacion();
                                		
								if($vali == 2){
    									$salida.='<hr>';
    									//--
    									$salida.=' <div class="row">';
    										$salida.='<div class="col-md-12">';
    											$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
    												$salida.='<h5>'.$nombre.' ('.$fecha.')</h5> <label class = "text-muted">('.$materia_desc.' - '.$tema_nombre.', '.$unidad_nombre.')</label>';
    											$salida.='</a>';
    											$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
    											$salida.='<div class="pull-right">';
    												/// situacion --
    												if($sit == 1){
    													if($resolucion > 0){
    														$salida.='<small class = "text-info"><i class="fa fa-paper-plane"></i> respuesta enviada</small> &nbsp; ';
    													}else{
    														$salida.='<small class = "text-muted"><i class="fa fa-clock-o"></i> Pendiente de Calificar</small> &nbsp; ';
    													}
    												}else if($sit == 2){
    													$salida.='<small class = "text-success"><i class="fa fa-check-circle-o"></i> Calificada</small> &nbsp; ';
    												}
    												if($tipo == "OL"){ //valida si se respondera en linea
    														$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">'; 										
    														$salida.='<i class="fas fa-search-plus"></i>'; 			
    														$salida.='</a>';
    												}else{
    											        	$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">'; 										
    														$salida.='<i class="fas fa-search-plus"></i>'; 			
    														$salida.='</a>';
    													$salida.=' &nbsp; <i class="fa fa-file-text-o" title = "Se Calificar&aacute; de otra forma"></i>';
    												}
    												//--
    											$salida.='</div>';
    										$salida.='</div>';
    									$salida.='</div>';
								
									}elseif($vali == 1 && $resolucion > 0){
									    $salida.='<hr>';
    									//--
    									$salida.=' <div class="row">';
    										$salida.='<div class="col-md-12">';
    											$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
    												$salida.='<h5>'.$nombre.' ('.$fecha.')</h5> <label class = "text-muted">('.$materia_desc.' - '.$tema_nombre.', '.$unidad_nombre.')</label>';
    											$salida.='</a>';
    											$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
    											$salida.='<div class="pull-right">';
    												/// situacion --
    												if($sit == 1){
    													if($resolucion > 0){
    														$salida.='<small class = "text-info"><i class="fa fa-paper-plane"></i> respuesta enviada</small> &nbsp; ';
    													}else{
    														$salida.='<small class = "text-muted"><i class="fa fa-clock-o"></i> Pendiente de Calificar</small> &nbsp; ';
    													}
    												}else if($sit == 2){
    													$salida.='<small class = "text-success"><i class="fa fa-check-circle-o"></i> Calificada</small> &nbsp; ';
    												}
    												if($tipo == "OL"){ //valida si se respondera en linea
    													$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">'; 										
    													$salida.='<i class="fas fa-search-plus"></i>'; 			
    													$salida.='</a>';
    												}else{
    													$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">'; 										
    													$salida.='<i class="fas fa-search-plus"></i>'; 			
    												    $salida.='</a>';
    													$salida.=' &nbsp; <i class="fa fa-file-text-o" title = "Se Calificar&aacute; de otra forma"></i>';
    												}
    												//--
    											$salida.='</div>';
    										$salida.='</div>';
    									$salida.='</div>';
									}elseif($vali == 3 && $resolucion <= 0){
									    $salida.='<hr>';
    									//--
    									$salida.=' <div class="row">';
    										$salida.='<div class="col-md-12">';
    											$salida.='<a href="'.$link.'" target = "'.$target.'" class="">';
    												$salida.='<h5>'.$nombre.' ('.$fecha.')</h5> <label class = "text-muted">('.$materia_desc.' - '.$tema_nombre.', '.$unidad_nombre.')</label>';
    											$salida.='</a>';
    											$salida.='<p class="text-muted small text-justify"><em>'.$desc.'</em></p>';
    											$salida.='<div class="pull-right">';
    												/// situacion --
    												if($sit == 1){
    													if($resolucion > 0){
    														$salida.='<small class = "text-info"><i class="fa fa-paper-plane"></i> respuesta enviada</small> &nbsp; ';
    													}else{
    														$salida.='<small class = "text-muted"><i class="fa fa-clock-o"></i> Pendiente de Calificar</small> &nbsp; ';
    													}
    												}else if($sit == 2){
    													$salida.='<small class = "text-success"><i class="fa fa-check-circle-o"></i> Calificada</small> &nbsp; ';
    												}
    												if($tipo == "OL"){ //valida si se respondera en linea
    													$salida.='<a href="FRMdetalle_materias.php?codigo='.$cod.'" title = "Ver Detalles" class="btn btn-default">';
    													$salida.='<i class="fa fa-search-plus"></i>';
    													$salida.='</a> &nbsp; ';
    												}else{
    													$salida.='<a href="FRMdetalle.php?codigo='.$cod.'" class="btn btn-default">'; 										
    													$salida.='<i class="fas fa-search-plus"></i>'; 			
    													$salida.='</a>';
    													$salida.=' &nbsp; <i class="fa fa-file-text-o" title = "Se Calificar&aacute; de otra forma"></i>';
    												}
    												//--
    											$salida.='</div>';
    										$salida.='</div>';
    									$salida.='</div>';
									}
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
				<!-- /.panel-default -->
			</div>
		</div>
    </div>

	<!-- //////////////////////////////////////////////////////// -->
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div id = "ModalDialog" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-left" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
				</div>
				<div class="modal-body text-center" id= "lblparrafo">
					<img src = "../../CONFIG/images/img-loader.gif" width="50px" /><br>
					<label align ="center">Transaccion en Proceso...</label>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
				<div class="modal-body" id= "Pcontainer">
			
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	
	<!-- scripts -->
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>
    <!-- knob -->
    <script src="../assets.3.5.20/js/jquery.knob.js"></script>
    <!-- flot charts -->
    <script src="../assets.3.5.20/js/jquery.flot.js"></script>
    <script src="../assets.3.5.20/js/jquery.flot.stack.js"></script>
    <script src="../assets.3.5.20/js/jquery.flot.resize.js"></script>
    <script src="../assets.3.5.20/js/theme.js"></script>
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	<script type="text/javascript" src="../assets.3.5.20/js/modules/postit/postit.js"></script>
   

	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>