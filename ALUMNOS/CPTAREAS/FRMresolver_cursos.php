<?php
	include_once('xajax_funct_tarea.php');
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
	$codigo = $_REQUEST['codigo'];
	
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_tarea_curso($codigo);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$cod = $row["tar_codigo"];
			$curso_nombre = utf8_decode($row["tar_curso_nombre"]);
			$tema_nombre = utf8_decode($row["tar_tema_nombre"]);
			$titulo = utf8_decode($row["tar_nombre"]);
			$tipo_respuesta = trim($row["tar_codigo"]);
			$tipo_respuesta = ($tipo_respuesta == "OL")?"RESPUESTA EN L&Iacute;NEA" : "POR OTROS MEDIOS";
			$tlink = trim($row["tar_link"]);
			$link = ($tlink == "")?"javascript:void(0);":$tlink;
			$target = ($tlink == "")?"":"_blank";
			$descripcion = utf8_decode($row["tar_descripcion"]);
			$fechor = trim($row["tar_fecha_entrega"]);
			$fecha = cambia_fechaHora($fechor);
			$fecha = substr($fecha, 0, -3);
			$tipo = trim($row["tar_tipo"]);
			//-
			$pondera = trim($row["tar_ponderacion"]);
			$tipocalifica = trim($row["tar_tipo_calificacion"]);
			switch($tipocalifica){
				case 'Z': $tipocal = "ZONA"; break;
				case 'E': $tipocal = "AL EX&Aacute;MEN"; break;
			}
		}
		$result = $ClsTar->get_det_tarea_curso($codigo,$tipo_codigo);
		if(is_array($result)){
			foreach($result as $row){
				$nota = $row["dtar_nota"];
				$obs = utf8_decode($row["dtar_observaciones"]);
				$nota = ($nota == 0)?"":$nota;
				//--
				$sit = trim($row["dtar_situacion"]);
			}
			$sit_tarea = ($sit == 1)?'<h4 class = "text-info"><i class = "fa fa-clock-o"></i> PENDIENTE DE CALIFICAR</h4>':'<h4 class = "text-success"><i class = "fa fa-check"></i> CALIFICADA</h4>';
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

	
if($id != "" && $nombre != ""){	
?>
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
						<h5><i class="fas fa-file-signature"></i> Resolver Tarea de Curso</h5>
					</div>
					<div class="panel-body">
						<h4><a href="javascript:void(0);"><?php echo $titulo; ?></a></h4>
						<label class="text-muted"><?php echo $curso_nombre.' - '.$tema_nombre; ?></label><br>
                        <div class="text-justify"><?php echo $descripcion; ?></div>
						<br>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<label class="text-muted"><i class="fa fa-copy"></i> Archivos Auxiliares o Gu&iacute;as</label>
							</div>
						</div>
						<br>
						<div class="row">
						<?php
							$result = $ClsTar->get_tarea_curso_archivo('',$codigo,'');
							$cantidad = 0;
							$salida = "";
							if(is_array($result)){
								foreach($result as $row){
									$archcod = trim($row["arch_codigo"]);
									$tarea = trim($row["arch_tarea"]);
									$extension = trim($row["arch_extencion"]);
									$archivo = trim($row["arch_codigo"])."_".trim($row["arch_tarea"]).".".trim($row["arch_extencion"]);
									$archivo_nombre = utf8_decode($row["arch_nombre"]);
									$desc = utf8_decode($row["arch_descripcion"]);
									$cantidad++;
									
									switch($extension){
										case "doc": $icono = '<i class = "fas fa-file-word text-info"></i>'; break;
										case "docx": $icono = '<i class = "fas fa-file-word text-info"></i>'; break;
										case "ppt": $icono = '<i class = "fas fa-file-powerpoint text-danger"></i>'; break;
										case "pptx": $icono = '<i class = "fas fa-file-powerpoint text-danger"></i>'; break;
										case "xls": $icono = '<i class = "fas fa-file-excel text-success"></i>'; break;
										case "xlsx": $icono = '<i class = "fas fa-file-excel text-success"></i>'; break;
										case "jpg": $icono = '<i class = "fas fa-file-image text-muted"></i>'; break;
										case "jpeg": $icono = '<i class = "fas fa-file-image text-muted"></i>'; break;
										case "png": $icono = '<i class = "fas fa-file-image text-muted"></i>'; break;
										case "pdf": $icono = '<i class = "fas fa-file-pdf text-warning"></i>'; break;
									}
									
									$salida.='<small class="col-md-8">';
										$salida.=$cantidad.'. '.$archivo_nombre.'</i>';
									$salida.='</small>';
									$salida.='<small class="col-md-2">'.$icono.' .'.$extension.'</small>';
									$salida.='<small class="col-md-2">';
										$salida.='<a href="EXEdownload_archivo_tarea_curso_maestro.php?archivo='.$archivo.'" class="btn btn-default btn-xs" title = "Descargar Archivo" ><i class="fas fa-file-download fa-2x"></i></a>';
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
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><i class="icon-info"></i> Informaci&oacute;n</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12">
								<h5>Fecha de entrega: <label class = "text-info"><?php echo $fecha; ?></label></h5>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-12 text-center">
								<?php echo $sit_tarea; ?>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-3">
								<label>Tipo de Respuesta: </label><br>
							</div>
							<div class="col-xs-9">
								<label class="text-info"><?php echo $tipo_respuesta ?></label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-3">
								<label>Link de Referencia:  </label><br>
							</div>
							<div class="col-xs-9">
								<label class="text-info"><a href="<?php echo $link ?>" target="<?php echo $target ?>"><?php echo $tlink ?></a></label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-3">
								<label>Ponderaci&oacute;n de Zona:</label><br>
							</div>
							<div class="col-xs-9">
								<label class="text-info"><?php echo $pondera ?> Punto(s).</label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-3">
								<label>Tipo de Calificaci&oacute;n:</label><br>
							</div>
							<div class="col-xs-9">
								<label class="text-info"><?php echo $tipocal ?></label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-3">
								<label>Nota: </label><br>
							</div>
							<div class="col-xs-9">
								<label class="text-info"><?php echo $nota ?></label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-3">
								<label>Observaciones: </label><br>
							</div>
							<div class="col-xs-9">
								<p class="text-justify"><?php echo $obs ?></p>
							</div>
						</div>
						<br>
					</div>	
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-paste"></i> Resoluci&oacute;n de la Tarea</div>
					<div class="panel-body">
						<br>
						<?php
							if($tipo == "OL"){ /// Requiere respuesta Online
								$result = $ClsTar->get_respuesta_directa_curso($codigo,$tipo_codigo);
								if(is_array($result)){
									foreach($result as $row){
										$texto = utf8_decode($row["reso_texto"]);
										$fecha_respuesta = cambia_fechaHora($row["reso_fecha_registro"]);
									}
									$resuelto = true;
								}
								
								$disabled = "";
								$titulo = "";
								$fec_limite = strtotime($fechor);
								$fec_hoy = strtotime(date("d-m-Y H:i:00",time()));
								if($fec_hoy > $fec_limite){
									if($resuelto == false){
										$disabled = 'disabled';
										$titulo = '<label class="text-danger"><i class = "fa fa-ban"></i> La fecha de entrega ha vencido!</label>';
									}else if($resuelto == true){
										$disabled = "disabled";
										$titulo = '<label class="text-success"><i class = "icon-envelop"></i> Respuesta Enviada!</label>';
									}
								}else{
									if($sit == 1){
										$disabled = "";
										$titulo = '<label class="text-info"><i class = "fa fa-clock-o"></i> Tarea en tiempo...</label>';
									}else if($sit == 2){
										$disabled = "disabled";
										$titulo = '<label class="text-success"><i class = "fa fa-check"></i> La tarea ha sido calificada...</label>';
									}
								}
							}else{ /// la solución se presentará fisicamente
								$disabled = 'disabled';
								$titulo = '<label class = "text-info"><i class = "fa fa-folder-open"></i> No necesita respuesta en l&iacute;nea</label>';
							}
						
						?>
						<div class="row">
							<p>
								
							</p>
							<div class="col-xs-4 text-left">
								<?php echo $titulo; ?>
								<input type = "hidden" name = "tarea" id = "tarea" value = "<?php echo $codigo; ?>" />
								<input type = "hidden" name = "alumno" id = "alumno" value = "<?php echo $tipo_codigo; ?>" />
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-2 col-xs-offset-1"><label>Resoluci&oacute;n:  <small class = "text-muted">Actualizado el: <?php echo $fecha_respuesta; ?></small></div>
							<div class="col-xs-9 text-left">
								<textarea class="form-control" id = "texto" name = "texto" rows="5" onkeyup="textoLargo(this)" <?php echo $disabled; ?> ><?php echo $texto; ?></textarea>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<label class="text-muted"><i class="fa fa-copy"></i> Documentos de Respuesta</label>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-primary btn-block" <?php echo $disabled; ?> id = "btn-cargar" onclick = "FileJs();" title="Cargar Archivos de Respuesta o Resoluci&oacute;n">
									<i class="fas fa-file-upload"></i> <i class="fas fa-file-image"></i> Cargar Archivos
								</button>
								<input id="archivo" name="archivo[]" type="file" multiple class="hidden" onchange="subirArchivos();" >
							</div>
							<div class="col-md-3">
								<a class="btn btn-default btn-block" href = "IFRMarchivos_tarea_cursos.php?tarea=<?php echo $codigo; ?>&alumno=<?php echo $tipo_codigo; ?>" target = "_blank" title="Ver Documentos Cargados" ><i class="fa fa-search"></i> <i class="fas fa-file-pdf-o"></i> Ver</a>
							</div>
						</div>
						<br>
						<div class="row">
						<?php
							$result = $ClsTar->get_respuesta_tarea_curso_archivo('',$codigo,$tipo_codigo,'');
							$cantidad = 0;
							$salida = "";
							if(is_array($result)){
								foreach($result as $row){
									$codigo = trim($row["arch_codigo"]);
									$tarea = trim($row["arch_tarea"]);
									$alumno = trim($row["arch_alumno"]);
									$extension = trim($row["arch_extencion"]);
									$archivo = trim($row["arch_codigo"])."_".trim($row["arch_tarea"])."_".trim($row["arch_alumno"]).".".trim($row["arch_extencion"]);
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
										$salida.='<a class="btn btn-default" href="EXEdownload_archivo_tarea_curso.php?archivo='.$archivo.'" class="btn btn-default btn-xs" title = "Descargar Archivo"><i class="fas fa-file-download"></i></a>';
									$salida.='</div>';
									$salida.='<div class="col-md-1">';
										$salida.='<button type = "button" onclick = "Eliminar_Archivo('.$codigo.','.$tarea.',\''.$alumno.'\',\''.$archivo.'\');" '.$disabled.' class="btn btn-danger" title = "Eliminar Archivo"><i class="fa fa-trash"></i></button>';
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
						<hr>
						<div class="row">
							<div class="col-xs-12 text-center">
								<button type="button" class="btn btn-default" id = "limp" onclick = "location.reload();"> <i class="fa fa-eraser"></i> Limpiar </button>
								<button type="button" class="btn btn-primary" id = "btn-grabar" onclick = "Respuesta();" <?php echo $disabled; ?> > <i class="fa fa-save"></i> Grabar </button>
							</div>
						</div>
					</div>	
				</div>
				<br>
			</div>
		</div>
    </div>
	
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
	<script type="text/javascript" src="../assets.3.5.20/js/modules/lms/tareacursos.js"></script>
	
	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>