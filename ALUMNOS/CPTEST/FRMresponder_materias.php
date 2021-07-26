<?php
	include_once('xajax_funct_examen.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
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
	//////////////////////////- MODULOS HABILITADOS

	

	
	
	//$_POST
	$ClsExa = new ClsExamen();
	$hashkey = $_REQUEST["hashkey"];
	$examen = $ClsExa->decrypt($hashkey, $id);
	resolucion_examen_materias_1($examen,$tipo_codigo);
	$result = $ClsExa->get_det_examen($examen,$tipo_codigo);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["exa_codigo"];
			$titulo = utf8_decode($row["exa_titulo"]);
			$descripcion = utf8_decode($row["exa_descripcion"]);
			//--
			$fini = trim($row["exa_fecha_inicio"]);
			$fini = cambia_fechaHora($fini);
			$ffin = trim($row["exa_fecha_limite"]);
			$ffin = cambia_fechaHora($ffin);
			//--
			$feclimit = trim($row["exa_fecha_limite"]);
			//--
			$situacion = trim($row["dexa_situacion"]);
		}
		if($situacion == 1){
			$situacion_desc ='<small class = "text-muted"><i class="fa fa-clock-o"></i> Sin Resolver</small> &nbsp; ';
		}else if($situacion == 2){
			$situacion_desc ='<small class = "text-info"><i class="fa fa-check"></i> Resuelto</small> &nbsp; ';
		}else if($situacion == 3){
			$situacion_desc ='<small class = "text-success"><i class="fa fa-check-circle-o"></i> Calificado</small> &nbsp; ';
		}
	}else{
		
	}
	
	//PUEDE O NO REPETIR
	$ClsExa = new ClsExamen();
	$result = $ClsExa->get_examen($codigo);
	if(is_array($result)){
		 foreach($result as $row){
			 $repetir = $row["exa_repetir"];
			 
			 ///---
			 $acalificar = $row["exa_calificar"]; 
		}
	}
	$flimit = strtotime($feclimit);
	$fecahora = strtotime(date("Y-m-d H:i:s",time()));
	if(($fecahora < $flimit)){
		$disabled = "";
		$title = '<h6 class = "alert alert-info text-center" ><i class = "fa fa-clock-o"></i> Exitos! el tiempo esta corriendo...</h6>';
	}else{
		$disabled = "disabled";
		$title = '<h6 class = "alert alert-danger text-center" ><i class = "fa fa-ban"></i> Ooops! el tiempo ha terminado...</h6>';
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

	
if($id != "" && $nombre != ""){	
?>
<script>
var $jrepetir  = '<?php echo $repetir; ?>';
var $jacalificar  = '<?php echo $acalificar; ?>';
//console.log($jrepetir);
//console.log($jacalificar);
</script>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    <link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	?>
	<!-- bootstrap -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../assets.3.5.20/css/util.css" rel="stylesheet">
	<!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery.dataTables.css" type="text/css" rel="stylesheet" />
    
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
	
	<!-- swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!--fontawesome-->
	<script src="https://kit.fontawesome.com/907a027ade.js" crossorigin="anonymous"></script>

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
			<ul class="nav navbar-nav" style="font-size: 14px;">						
				<li><a href="../CPSOLICITUD_MINEDUC/FRMmineduc.php"> <span class="fa fa-book"></span> Educaci&oacute;n Virtual a Distancia</a></li>
			</ul>
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
							<?php if($_SESSION["MOD_pinboard"] == 1){ // permisos del colegio ?>
                            <a href="../CPPOSTIT/FRMpinboard.php" class="item">
								<i class="fas fa-thumbtack"></i>
                                <strong>*. </strong> 
								<small>Pinboard</small>
                            </a>
							<?php } ?>
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
                	<li><a href="../CPPERFIL/FRMseguridad.php"> <i class="fas fa-shield-alt"></i> Seguridad y Bloqueo de Dispositivos</a></li>
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
			<?php if($_SESSION["MOD_asistencia"] == 1){ // permisos del colegio ?>
			<li>
                <a href="../CPASISTENCIA/FRMinicio.php">
                    <i class="fas fa-check-square"></i>
                    <span>Asistencia</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_notas"] == 1){ ?>
			<li>
                <a href="../CPNOTAS/FRMinicio.php">
                    <i class="fa fa-paste"></i>
                    <span>Notas</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1 || $_SESSION["MOD_academico3"] == 1){ ?>
			<li>
                <a href="../CPMATERIAS/FRMmaterias.php">
                    <i class="fa fa-flask"></i>
                    <span>Materias</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1 || $_SESSION["MOD_academico3"] == 1){ ?>
			<li>
                <a href="../CPCURSOS/FRMcursos.php">
                    <i class="fa fa-book"></i>
                    <span>Cursos Libres</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_encuestas"] == 1){ ?> 
			<li>
                <a href="../CPENCUESTAS/FRMencuestas.php">
					<i class="fas fa-clipboard-check"></i>
                    <span>Encuestas</span>
                </a>
            </li>
			<?php } ?>
			<li>
                <a href="../CPGRUPOS/FRMgrupos.php">
                    <i class="fas fa-users"></i>
                    <span>Grupos</span>
                </a>
            </li>
			<br><br>
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
				<a href="../CPVIDEOCALL/FRMvideoclases.php">
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
				<a href="../CPTAREAS/FRMinicio.php">
					<div class="data">
						<span class="number"><i class="icon-paste"></i></span>
						Tareas
					</div>
				</a>
            </div>
			<?php } ?>
			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1 || $_SESSION["MOD_academico3"] == 1){ ?>
            <div class="<?php echo $cols_divs; ?>">
				<a href="../CPTEST/FRMinicio.php">
					<div class="data">
						<span class="number"><i class="icon-spell-check"></i></span>
						Evaluaciones
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
						<h5><i class="fas fa-file-signature"></i> Responder Ex&aacute;men</h5>
					</div>
					<div class="panel-body">
						<h4><a href="javascript:void(0);"><?php echo $titulo; ?></a></h4>
						<input type= "hidden" name = "examen" id = "examen" value = "<?php echo $examen; ?>" />
						<input type= "hidden" name = "alumno" id = "alumno" value = "<?php echo $tipo_codigo; ?>" />
						<input type= "hidden" name = "feclimit" id = "feclimit" value = "<?php echo $feclimit; ?>" />
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-3"><?php echo $situacion_desc; ?></div>
						</div>
                        <div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-10">
								<p class="text-justify"><?php echo $descripcion; ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<label class="text-muted"><i class="fa fa-copy"></i> Archivos Auxiliares o Gu&iacute;as</label>
							</div>
						</div>
						<br>
						<div class="row">
						<?php
							$result = $ClsExa->get_examen_archivo('',$codigo,'');
							$cantidad = 0;
							$salida = "";
							if(is_array($result)){
								foreach($result as $row){
									$archcod = trim($row["arch_codigo"]);
									$examen = trim($row["arch_examen"]);
									$extension = trim($row["arch_extencion"]);
									$archivo = trim($row["arch_codigo"])."_".trim($row["arch_examen"]).".".trim($row["arch_extencion"]);
									$archivo_nombre = utf8_decode($row["arch_nombre"]);
									$desc = utf8_decode($row["arch_descripcion"]);
									$cantidad++;
									
									switch($extension){
										case "doc": $icono = '<i class = "fas fa-file-word fa-2x text-info"></i>'; break;
										case "docx": $icono = '<i class = "fas fa-file-word fa-2x text-info"></i>'; break;
										case "ppt": $icono = '<i class = "fas fa-file-powerpoint fa-2x text-danger"></i>'; break;
										case "pptx": $icono = '<i class = "fas fa-file-powerpoint fa-2x text-danger"></i>'; break;
										case "xls": $icono = '<i class = "fas fa-file-excel fa-2x text-success"></i>'; break;
										case "xlsx": $icono = '<i class = "fas fa-file-excel fa-2x text-success"></i>'; break;
										case "jpg": $icono = '<i class = "fas fa-file-image fa-2x text-muted"></i>'; break;
										case "jpeg": $icono = '<i class = "fas fa-file-image fa-2x text-muted"></i>'; break;
										case "png": $icono = '<i class = "fas fa-file-image fa-2x text-muted"></i>'; break;
										case "pdf": $icono = '<i class = "fas fa-file-pdf fa-2x text-warning"></i>'; break;
									}
									
									$salida.='<small class="col-md-8">';
										$salida.=$cantidad.'. '.$archivo_nombre.'</i>';
									$salida.='</small>';
									$salida.='<small class="col-md-2">'.$icono.' .'.$extension.'</small>';
									$salida.='<small class="col-md-2">';
										$salida.='<a href="EXEdownload_archivo_examen_maestro.php?archivo='.$archivo.'" class="btn btn-default" title = "Descargar Archivo" ><i class="fas fa-file-download"></i></a>';
									$salida.='</small>';
								}
								echo $salida;
							}
						?>
						</div>
						<div class="row">
							<div class="col-md-12 text-right">
								<small class="text-muted text-rigth"><?php echo $cantidad; ?> Archivo(s).</small>
							</div>
						</div>
						<br>
						<?php
							$result = $ClsExa->get_pregunta('',$examen);
							if(is_array($result)){
								$i = 1;	
								foreach ($result as $row){
									$codigo = $row["pre_codigo"];
									$pregunta = utf8_decode($row["pre_descripcion"]);
									$tipo = trim($row["pre_tipo"]);
									$puntos = trim($row["pre_puntos"]);
									$result_clave = $ClsExa->get_clave_directa($examen,$codigo);
									   if(is_array($result_clave)){
										   foreach($result_clave as $row){
											   $eponderacion = trim($row["cla_ponderacion"]);
											   }
										   }
									$result_respuesta = $ClsExa->get_respuesta_directa($examen,$codigo,$tipo_codigo);
									if(is_array($result_respuesta)){
										foreach ($result_respuesta as $row_respuesta){
											$ponderacion = trim($row_respuesta["resp_ponderacion"]);
											$respuesta = utf8_decode($row_respuesta["resp_respuesta"]);
									   }
										if($numero == $eponderacion){
											$total1 = $puntos;
										}else{
											$total1 = '0';
										}
									}else{
										$ponderacion = "";
										$respuesta = "";
									}
									$salida="";
									//echo($eponderacion);
									if($tipo == 1){
										$result_multiple = $ClsExa->get_multiple('',$examen);
									if(is_array($result_multiple)){
										foreach ($result_multiple as $row){
										$numero = $row["mult_numero"];
										$mdescripcion = utf8_decode($row["mult_descripcion"]);
										$codigom = $row["mult_codigo"];
										if($numero == $eponderacion){
											$total1 = $puntos;
										}else{
											$total1 = '0';
										}
										if ($codigo==$codigom){
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radio'.$numero.''.$i.'" value="'.$numero.'" onclick = "Responder(\''.$codigo.'\',1,\''.$numero.'\',0,\''.$total1.'\',\'\');" '.$disabled.' /> <label for="radio'.$numero.''.$i.'" >'.$mdescripcion.' </label>';
										$salida.='</label>';
									
										}
										$salida.='<script>';
										if($ponderacion != ''){
										if($ponderacion === $numero ){
										//$salida.='document.getElementById("radio'.$numero.''.$i.'").checked = true;';
										}
									}
										$salida.='</script>';
										}
									}
									}else if($tipo == 2){
										$result_multiple = $ClsExa->get_multiple('',$examen);
									if(is_array($result_multiple)){
										foreach ($result_multiple as $row){
										$numero = $row["mult_numero"];
										$mdescripcion = utf8_decode($row["mult_descripcion"]);
										$codigom = $row["mult_codigo"];
										if($numero == $eponderacion){
											$total1 = $puntos;
										}else{
											$total1 = '0';
										}
										if ($codigo==$codigom){
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radio'.$numero.''.$i.'" value="'.$numero.'" onclick = "Responder(\''.$codigo.'\',1,\''.$numero.'\',0,\''.$total1.'\',\'\');" '.$disabled.' /> <label for="radio'.$numero.''.$i.'" >'.$mdescripcion.' </label>';
										$salida.='</label>';
									
										}
										$salida.='<script>';
										if($ponderacion != ''){
										if($ponderacion === $numero ){
									//	$salida.='document.getElementById("radio'.$numero.''.$i.'").checked = true;';
										}
									}
										$salida.='</script>';
										}
									}
									}else if($tipo == 3){
										$salida.='<div class="form-group">';
											$salida.='<textarea class = "form-control" name = "respuesta'.$i.'" id = "respuesta'.$i.'"  rows="5" onkeyup="textoLargo(this);" onblur = "Responder(\''.$codigo.'\',3,\'0\',this.value);" '.$disabled.' >'.$respuesta.'</textarea>';
										$salida.='</div>';
									}
										
							
										
										
									
						?>
							<div class="row">
								<div class="col-xs-1 text-right"><label><?php echo $i; ?>.</label></div>
								<div class="col-xs-10">
									<p class="text-justify"><?php echo $pregunta; ?> &nbsp; <label>(<?php echo $puntos; ?> Puntos)</label></p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-1"></div>
								<div class="col-xs-10"><?php echo $salida; ?></div>
							</div>
							<br>
						<?php
									$i++;
								}
							}else{
								
							}
							
											
						?>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-paste"></i> Archivos de Resoluci&oacute;n del Ex&aacute;men</div>
					<div class="panel-body">
						<br>
						<div class="row">
							<div class="col-md-9">
								<label class="text-muted"><i class="fa fa-copy"></i> Documentos de Respuesta</label>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-primary btn-block" <?php echo $disabled; ?> id = "btn-cargar" onclick = "FileJs();" title="Cargar Archivos de Respuesta o Resoluci&oacute;n">
									<i class="fas fa-file-upload"></i> <i class="fas fa-file-image"></i> Cargar Archivos
								</button>
								<input id="archivo" name="archivo[]" type="file" multiple class="hidden" onchange="subirArchivos();" >
							</div>
						</div>
						<br>
						<div class="row">
						<?php
							$result = $ClsExa->get_resolucion_examen_archivo('',$examen,$tipo_codigo,'');
							$cantidad = 0;
							$salida = "";
							if(is_array($result)){
								foreach($result as $row){
									$codigo = trim($row["arch_codigo"]);
									$examen = trim($row["arch_examen"]);
									$alumno = trim($row["arch_alumno"]);
									$extension = trim($row["arch_extencion"]);
									$archivo = trim($row["arch_codigo"])."_".trim($row["arch_examen"])."_".trim($row["arch_alumno"]).".".trim($row["arch_extencion"]);
									$archivo_nombre = utf8_decode($row["arch_nombre"]);
									$desc = utf8_decode($row["arch_descripcion"]);
									$cantidad++;
									
									switch($extension){
										case "doc": $icono = '<i class = "fas fa-file-word fa-2x text-info"></i>'; break;
										case "docx": $icono = '<i class = "fas fa-file-word fa-2x text-info"></i>'; break;
										case "ppt": $icono = '<i class = "fas fa-file-powerpoint fa-2x text-danger"></i>'; break;
										case "pptx": $icono = '<i class = "fas fa-file-powerpoint fa-2x text-danger"></i>'; break;
										case "xls": $icono = '<i class = "fas fa-file-excel fa-2x text-success"></i>'; break;
										case "xlsx": $icono = '<i class = "fas fa-file-excel fa-2x text-success"></i>'; break;
										case "jpg": $icono = '<i class = "fas fa-file-image fa-2x text-muted"></i>'; break;
										case "jpeg": $icono = '<i class = "fas fa-file-image fa-2x text-muted"></i>'; break;
										case "png": $icono = '<i class = "fas fa-file-image fa-2x text-muted"></i>'; break;
										case "pdf": $icono = '<i class = "fas fa-file-pdf fa-2x text-warning"></i>'; break;
									}
									
									$salida.='<small class="col-md-8">';
										$salida.=$cantidad.'. '.$archivo_nombre.' &nbsp; <span title = "'.$desc.'"></span>';
									$salida.='</small>';
									$salida.='<small class="col-md-2">'.$icono.' .'.$extension.'</small>';
									$salida.='<div class="col-md-1">';
										$salida.='<a href="EXEdownload_archivo_examen.php?archivo='.$archivo.'" class="btn btn-default" title = "Descargar Archivo"><i class="fas fa-file-download"></i></a>';
									$salida.='</div>';
									$salida.='<div class="col-md-1">';
										$salida.='<button type = "button" onclick = "Eliminar_Archivo('.$codigo.','.$examen.',\''.$alumno.'\',\''.$archivo.'\');" '.$disabled.' class="btn btn-danger" title = "Eliminar Archivo"><i class="fa fa-trash"></i></button>';
									$salida.='</div>';
								}
								echo $salida;
							}
						?>
						</div>
						<div class="row">
							<div class="col-md-11 text-right">
								<small class="text-muted text-rigth"><?php echo $cantidad; ?> Archivo(s).</small>
							</div>
						</div>
					</div>	
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<p class="text-info"> Revise el contenido de la clave para evitar errores en la calificaci&oacute;n</p>
                        <p class="pull-right"> Visualizado el <?php echo date("d/m/Y"); ?> a las <?php echo date("H:i"); ?></p>
						<br><br>
						<div class="row">
							<div class="col-xs-12 text-center">
								<button type="button" class="btn btn-success" id = "btn-grabar" onclick="FinalizarExamen($jrepetir ,$jacalificar);" <?php echo $disabled; ?> ><i class="fa fa-check"></i> Listo !</button> &nbsp; 
								<?php echo $situacion_desc; ?>
							</div>
						</div>
					</div>	
				</div>
				<br>
			</div>
		</div>
    </div>
	
	<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document"  id = "ModalDialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="text-primary" id="myModalLabel"><img src="../../CONFIG/images/logo.png" width = "60px;" /> &nbsp; Transacci&oacute;n en proceso...</h6>
				</div>
				<div class="modal-body text-center" id= "lblparrafo">
					<label class="text-muted" id="progressLabel">0%</label>
					<div class="progress">
						<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" id="progressStatus" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<br>
				</div>
				<div id= "Pcontainer"></div>
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
	<script type="text/javascript" src="../assets.3.5.20/js/modules/loading.js"></script>
	<script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	<script type="text/javascript" src="../assets.3.5.20/js/modules/lms/examen.js"></script>
	
	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>