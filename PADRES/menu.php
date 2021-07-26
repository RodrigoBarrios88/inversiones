<?php
	include_once('xajax_funct.php');
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	$id = $_SESSION["codigo"];
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

	$ClsAcad = new ClsAcademico();
	$ClsAsi = new ClsAsignacion();
	$ClsPush = new ClsPushup();
	$ClsIns = new ClsInscripcion();
	$ClsPen = new ClsPensum();
	$pensum = $ClsPen->get_pensum_activo();

	if($tipo_usuario == 3){ //// PADRE DE ALUMNO
		$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
		////////// CREA UN ARRAY CON TODOS LOS DATOS DE SUS HIJOS
		if (is_array($result)) {
			$i = 0;
			$arr_hijos = "";
			foreach($result as $row){
				$cui = $row["alu_cui"];
				$arr_hijos.= $row["alu_cui"].",";
			}
			$arr_hijos = substr($arr_hijos,0,-1);
			$_SESSION["hijos"] = $arr_hijos;
		}
	}

	$pendientes = $ClsPush->count_pendientes_leer_type($tipo_codigo,1);

	////// COBROS /////
	$ClsBol = new ClsBoletaCobro();
	$ClsPen = new ClsPensum();
	$pensum = $_SESSION["pensum"];
	$anio = $ClsPen->get_anio_pensum($pensum);
	$arr_hijos = ($arr_hijos == "")?"1111":$arr_hijos;
	$count_mora = $ClsBol->count_mora('','','',$arr_hijos,'','','','', $anio, '', '', '', 1, '',0);

	/// NOTIFICACIONES DE INSCRIPCIONES
	$ClsIns = new ClsInscripcion();
	$InscripcionesActivas = $ClsIns->activo;
	$InscripcionesAnio = $ClsIns->anio;
	if($ClsIns->activo == 1){
		$InscripcionesLabel = '<strong class="text-success">Inscripciones Activas</strong>';
	}else{
		$InscripcionesLabel = '<strong class="text-danger">Inscripciones No Activas </strong>';
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
	<link rel="shortcut icon" href="../CONFIG/images/logo.png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("");
	?>

	<!-- bootstrap -->
	<link href="assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
	<link href="assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

	<!-- libraries -->
	<link href="assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
	<link href="assets.3.5.20/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

	<!-- global styles -->
	<link rel="stylesheet" type="text/css" href="assets.3.5.20/css/compiled/layout.css" />
	<link rel="stylesheet" type="text/css" href="assets.3.5.20/css/compiled/elements.css" />
	<!-- Utilitaria -->
	<link rel="stylesheet" type="text/css" href="assets.3.5.20/css/util.css" rel="stylesheet">

	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<!-- this page specific styles -->
	<link rel="stylesheet" href="assets.3.5.20/css/compiled/index.css" type="text/css" media="screen" />

	<!-- open sans font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

	<!-- lato font -->
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

	<!-- Sweet Alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
            <a class="navbar-brand" href="#"><img src="../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
			<a class="navbar-brand2" href="#"><img src="../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
			<button type="button"  class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>
		<ul class="nav navbar-nav pull-right collapse" id="second-menu" >
			<ul class="nav navbar-nav" style="font-size: 14px;">						
				<li><a href="CPSOLICITUD_MINEDUC/FRMmineduc.php"> <span class="fa fa-book"></span> Educaci&oacute;n Virtual a Distancia</a></li>
			</ul>
			<?php if($_SESSION["MOD_inscripciones"] == 1){ ?>
			<li class="notification-dropdown hidden-phone">
				<?php
					$Ins_active = ($InscripcionesActivas == 1)?"active":"";
					$Ins_visible = ($InscripcionesActivas == 1)?"is-visible":"";
				?>
                <a href="#" class="trigger <?php echo $Ins_active; ?>">
                    <i class="icon-paste"></i>
                    <?php if($InscripcionesActivas == 1){
						echo '<span class="count" style="background: #FF8000;">i</span>';
					} ?>
                </a>
                <div class="pop-dialog <?php echo $Ins_visible; ?>">
                    <div class="pointer right">
                        <div class="arrow"></div>
                        <div class="arrow_border"></div>
                    </div>
                    <div class="body">
                        <a href="#" class="close-icon"><i class="fa fa-times"></i></a>
                        <div class="notifications">
                            <h3>
								<?php echo $InscripcionesLabel; ?><br>
								Formulario de Inscripciones para el <?php echo $InscripcionesAnio; ?><br>
								<small>Esta opci&oacute;n esta sujeta a la hailitaci&oacute;n y notificaci&oacute;n del colegio...</small>
							</h3>
							<a href="CPINSCRIPCIONES/FRMpaso1.php" class="item active">
								<i class="fa fa-edit"></i>
                                <strong>Paso 1.</strong>
								<small>Actualizar Informaci&oacute;n</small>
                            </a>
                            <a href="CPINSCRIPCIONES/FRMpaso2.php" class="item">
								<i class="fas fa-hand-holding-usd"></i>
                                <strong> Paso 2. </strong>
								<small>Pagar la Inscripci&oacute;n</small>
                            </a>
                            <a href="CPINSCRIPCIONES/FRMpaso3.php" class="item">
								<i class="fa fa-check"></i>
                                <strong>Paso 3.</strong>
								<small>Solicitar Verificaci&oacute;n</small>
                            </a>
                            <a href="CPINSCRIPCIONES/FRMpaso4.php" class="item">
								<i class="fa fa-print"></i></span>
                                <strong>Paso 4.</strong>
								<small>Imprimir Contrato, firmar y presentar</small>
                            </a>
							<div class="footer">
                                <a href="CPINSCRIPCIONES/FRMpaso1.php" class="logout"><i class="fa fa-trophy"></i> Iniciar!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_pagos"] == 1){ // permisos del colegio?>
				<?php if($count_mora > 0){ ?>
				<li class="notification-dropdown hidden-phone">
					<a href="#" class="trigger active">
						<i class="fas fa-money-bill-alt"></i>
						<span class="count"><i class="fa fa-warning" style="font-size: 12px; color: #FF8000; position: absolute; top: 2px;"></i></span>
					</a>
					<div class="pop-dialog is-visible">
						<div class="pointer right">
							<div class="arrow"></div>
							<div class="arrow_border"></div>
						</div>
						<div class="body">
							<a href="#" class="close-icon"><i class="fas fa-money-bill-alt"></i></a>
							<div class="notifications">
								<h3>Se han girado - <?php echo $count_mora; ?> - boleta(s) de Mora</h3>
						<?php
							$ClsBol = new ClsBoletaCobro();
							$ClsPen = new ClsPensum();
							$pensum = $_SESSION["pensum"];
							$anio = $ClsPen->get_anio_pensum($pensum);
							$arr_hijos = ($arr_hijos == "")?"1111":$arr_hijos;
							$result = $ClsBol->get_mora('','','',$arr_hijos,'','','','', $anio, '', '', '', 1, '',0);
							if(is_array($result)){
								foreach($result as $row){
									$codboleta = $row["bol_codigo"];
									$cuenta = $row["bol_cuenta"];
									$banco = $row["bol_banco"];
									$usu = $_SESSION["codigo"];
									$hashkey1 = $ClsBol->encrypt($codboleta, $usu);
									$hashkey2 = $ClsBol->encrypt($cuenta, $usu);
									$hashkey3 = $ClsBol->encrypt($banco, $usu);
									//--
									$referencia = utf8_decode($row["bol_referencia"]);
									$motivo = utf8_decode($row["bol_motivo"]);
						?>
								<a href="../CONFIG/BOLETAS/REPboleta.php?hashkey1=<?php echo $hashkey1; ?>&hashkey2=<?php echo $hashkey2; ?>&hashkey3=<?php echo $hashkey3; ?>" target = "_blank" class="item active">
									<i class="fa fa-print"></i>
									<strong>Boleta <?php echo $referencia; ?></strong>
									<small><?php echo $motivo; ?></small>
								</a>
						<?php
								}
							}
						?>
								<div class="footer">
									<a href="CPPAGOS/FRMhijos.php" class="logout"><i class="fas fa-search"></i> ver estado de cuenta</a>
								</div>
							</div>
						</div>
					</div>
				</li>
				<?php } ?>
			<?php } ?>
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
                            <a href="CPPANIAL/FRMreportes.php" class="item">
								<i class="fas fa-layer-group"></i>
                                <strong>*. </strong>
								<small>Reporte de Pa&ntilde;al</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_golpe"] == 1){ // permisos del colegio ?>
                            <a href="CPGOLPE/FRMreportes.php" class="item">
								<i class="fa fa-medkit"></i></span>
                                <strong>*. </strong>
								<small>Reporte de Golpe</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_enfermedad"] == 1){ // permisos del colegio ?>
                            <a href="CPENFERMEDAD/FRMreportes.php" class="item">
								<i class="fa fa-stethoscope"></i></span>
                               <strong>*. </strong>
								<small>Reporte de Enfermedad</small>
                            </a>
							<?php } ?>
							<?php if($_SESSION["MOD_conducta"] == 1){ // permisos del colegio ?>
                            <a href="CPCONDUCTA/FRMreportes.php" class="item">
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
                    <i class="fas fa-user"></i> Perfil
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="CPPERFIL/FRMperfil.php"> <i class="icon-user"></i> Informaci&oacute;n Personal</a></li>
                	<li><a href="CPPERFIL/FRMfamilia.php"> <i class="fas fa-users"></i> Ver Familia</a></li>
                	<li><a href="CPPERFIL/FRMseguridad.php"> <i class="fas fa-shield-alt"></i> Seguridad y Bloqueo de Dispositivos</a></li>
                </ul>
            </li>
            <li class="settings">
                <a href="CPPERFIL/FRMperfil.php" role="button">
                    <i class="icon-cog"></i>
                </a>
            </li>
            <li class="settings">
                <a href="logout.php" role="button">
                    <i class="icon-exit"></i>
                </a>
            </li>
        </ul>
    </header>
    <!-- end navbar -->

    <!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <li class="active">
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
				<a href="menu.php">
                    <i class="icon-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
			<?php if($_SESSION["MOD_calendario"] == 1){ // permisos del colegio ?>
			<li>
                <a href="CPCALENDARIO/FRMcalendario.php">
                    <i class="fas fa-calendar"></i>
                    <span>Calendario</span>
                </a>
            </li>
			<?php } ?>
			<li>
                <a href="CPHIJOS/FRMhijos.php">
                    <i class="icon-users"></i>
                     <span>Hijos</span>
                </a>
            </li>
			<?php if($_SESSION["MOD_notas"] == 1){ ?>
			<li>
                <a href="CPNOTAS/FRMhijos.php">
                    <i class="fa fa-paste"></i>
                    <span>Notas</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_academico"] == 1 || $_SESSION["MOD_academico2"] == 1){ ?>
			<li>
                <a href="CPMATERIAS/FRMhijos.php">
                    <i class="fa fa-flask"></i>
                    <span>Materias</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_pagos"] == 1){ ?>
			<li>
                <a href="CPPAGOS/FRMhijos.php">
                    <i class="fas fa-money-bill-alt"></i>
                    <span>Pagos</span>
                </a>
            </li>
			<?php } ?>
			<?php if($_SESSION["MOD_encuestas"] == 1){ ?>
			<li>
                <a href="CPENCUESTAS/FRMencuestas.php">
					<i class="fas fa-clipboard-check"></i>
                    <span>Encuestas</span>
                </a>
            </li>
			<?php } ?>
			<li>
                <a href="CPGRUPOS/FRMhijos.php">
                    <i class="fas fa-users"></i>
                    <span>Grupos</span>
                </a>
            </li>
			<br><br><br>
			<li>
                <a href="logout.php">
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
					<a href="CPVIDEOCALL/FRMhijos.php">
						<div class="data">
							<span class="number"><i class="fa fa-video"></i></span>
							VideoClases
						</div>
					</a>
                </div>
				<?php } ?>
				<?php if($_SESSION["MOD_videos"] == 1 || $_SESSION["MOD_photos"] == 1){ ?>
                <div class="<?php echo $cols_divs; ?>">
					<a href="CPMULTIMEDIA/FRMvisualizar.php">
						<div class="data">
							<span class="number"><i class="fas fa-photo-video"></i></span>
							Multimedia
						</div>
					</a>
                </div>
				<?php } ?>
				<?php if($_SESSION["MOD_tareas"] == 1){ ?>
                <div class="<?php echo $cols_divs; ?>">
					<a href="CPTAREAS/FRMtareas.php">
						<div class="data">
							<span class="number"><i class="icon-paste"></i></span>
							Tareas
						</div>
					</a>
                </div>
				<?php } ?>
				<?php if($_SESSION["MOD_pinboard"] == 1){ ?>
                <div class="<?php echo $cols_divs; ?>">
					<a href="CPPOSTIT/FRMpinboard.php">
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

        <div id="pad-wrapper" style= "margin-top:25px;">

            <!-- Carusel -->
			<div class="row">
			    <div class="row">
				<div class="col-lg-12">
					<h2 class="alert alert-info text-center">PARA UNA MEJOR EXPERIENCIA DESCARGA NUESTRA APP:
					<div>
					<br>
					<a type="button" class="btn btn-default btn-lg" href="https://play.google.com/store/apps/details?id=gt.asms.olivos" target="_blank"><i class="fab fa-android text-success"></i> ANDROID</a>
					<a type="button" class="btn btn-default btn-lg" href="https://apps.apple.com/us/app/colegio-los-olivos/id1537800240" target="_blank"><i class="fab fa-app-store-ios text-primary"></i> IOS</a>
					<div class="text-right">
					    <small>
                        <a class="trigger-btn" href="https://youtu.be/cpsaV1sH6gs" target="_blank"><i class="fab fa-android text-success"></i>&nbsp;Como descargar ANDROID?&nbsp; </a>
                        </small>
                        <small>
                            <a class="trigger-btn" href="https://youtu.be/Lm6AEcemt9c"target="_blank"><i class="fab fa-app-store-ios text-primary">&nbsp;Como descargar IOS?</i></a>
                        </small>
					</div>
					</div>
					</h2>
					
				</div>
			</div>
				<div class="container">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<!--==================================== Obtiene Informacion ====================================--!>

						<?php
							$ClsInfo = new ClsInformacion();
							$ClsPen = new ClsPensum();
							$pensum = $ClsPen->get_pensum_activo();
							//--
							$arralumnos = array();
							$arralumnos = explode(",", $arr_hijos);
							$cantidad = count($arralumnos);

							$codigos = "";
							for($i = 0; $i <= $cantidad; $i ++){
								$alumno = $arralumnos[$i];
								if($alumno != ""){
									//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
									$codigos1 = $ClsInfo->get_codigos_informacion_secciones($pensum,$alumno);
									//////////////////////////////////////// GRUPOS //////////////////////////////////////
									$codigos2 = $ClsInfo->get_codigos_informacion_grupos($alumno);
									//////////////////////////////////////// TODOS //////////////////////////////////////
									$codigos3 = $ClsInfo->get_codigos_informacion_todos();
									//////////////////////////////////////// --- ////////////////////////////////////////
									if($codigos1 != ""){
										$codigos.= $codigos1.",";
									}
									if($codigos2 != ""){
										$codigos.= $codigos2.",";
									}
									if($codigos3 != ""){
										$codigos.= $codigos3.",";
									}
								}
							}
							$codigos = substr($codigos, 0, -1);

							$contador_informacion = 0;
							$result_informacion = $ClsInfo->get_informacion($codigos);
                            if(is_array($result_informacion)){
								foreach($result_informacion as $row){
                                    $imagen = trim($row["inf_imagen"]);
									$codigo = trim($row["inf_codigo"]);
									if(file_exists('../CONFIG/Actividades/'.$imagen) && $imagen != ""){
										$codX = $codigo;
										$imagen = trim($row["inf_imagen"]);
										$tlink = trim($row["inf_link"]);
										$link = ($tlink == "#")?'javascript:void(0);':$tlink;
										$target = ($tlink == "#")?'':'_blank';
										$nombre = utf8_decode($row["inf_nombre"]);
										//--
											$active = ($contador_informacion == 0)?"active":"";
											$carousel_li.='<li data-target="#myCarousel" data-slide-to="'.$contador_informacion.'" class="'.$active.'"></li>';

											$carousel_item.='<div class="item '.$active.' text-center">';
												$carousel_item.='<a href = "javascript:void(0);" onclick="Ver_Informacion('.$codigo.');">';
												$carousel_item.='<img src="../CONFIG/Actividades/'.$imagen.'" alt="Chania" width="460" height="345">';
												$carousel_item.='</a>';
												$carousel_item.='<div class="carousel-caption">';
													  //$carousel_item.='<h3>'.$nombre.'</h3>';
													  //$carousel_item.='<h6>'.$horaini.' - '.$horafin.'</h6>';
													  //$carousel_item.='<p>'.$desc.'</p>';
												  $carousel_item.='</div>';
											$carousel_item.='</div>';
										//--
										$contador_informacion++;
									}
								}
								$contador_informacion--; /// le quita la ultima vuelta de mas
							}
						?>
						<!--==================================== Despliega Informacion ====================================--!>

						<!-- Indicators -->
						<ol class="carousel-indicators">
							<?php echo $carousel_li; ?>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner text-center" role="listbox">
							<?php echo $carousel_item; ?>
						</div>
						<!--==================================== ---------------------- ====================================--!>
					  <!-- Left and right controls -->
					  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="fa fa-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Anterior</span>
					  </a>
					  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="fa fa-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Siguiente</span>
					  </a>
					</div>
				</div>
			</div>
			<!-- Carusel -->
			<br><br>
			<!-- table sample -->
            <!-- the script for the toggle all checkboxes from header is located in assets.3.5.20/js/theme.js -->
			<div class="table-products">
                <div class="row head">
                    <div class="col-md-12">
                        <h4>
							<i class="fa fa-file-text fa-2x"></i> &nbsp;
							Circulares<small>(Documentos)</small>
						</h4>
                    </div>
                </div>
			</div>
			<br>
			<div class="table-responsive">
				<table class="table table-hover">
					<?php
						//////////////////////////////////////// GENERAL ///////////////////////////////////////////
						$ClsCir = new ClsCircular();
						$arralumnos = array();
						$arralumnos = explode(",", $arr_hijos);
						$cantidad = count($arralumnos);

						$codigos = "";
						for($i = 0; $i <= $cantidad; $i ++){
							$alumno = $arralumnos[$i];
							if($alumno != ""){
								//////////////////////////////////////// GRADOS Y SECCIONES ///////////////////////////
								$codigos1 = $ClsCir->get_codigos_circular_secciones($pensum,$alumno);
								//////////////////////////////////////// GRUPOS //////////////////////////////////////
								$codigos2 = $ClsCir->get_codigos_circular_grupos($alumno);
								//////////////////////////////////////// TODOS //////////////////////////////////////
								$codigos3 = $ClsCir->get_codigos_circular_todos();
								//////////////////////////////////////// --- ////////////////////////////////////////
								if($codigos1 != ""){
									$codigos.= $codigos1.",";
								}
								if($codigos2 != ""){
									$codigos.= $codigos2.",";
								}
								if($codigos3 != ""){
									$codigos.= $codigos3.",";
								}
							}
						}
						$codigos = substr($codigos, 0, -1);

						$salida = "";
						$result_circulares = $ClsCir->get_circular($codigos);
						if(is_array($result_circulares)){
							$codX = "";
							foreach($result_circulares as $row){
								$cod = $row["cir_codigo"];
								if($cod != $codX){
									$codX = $cod;
									$usu = $_SESSION["codigo"];
									$documento = trim($row["cir_documento"]);
									$titulo = utf8_decode($row["cir_titulo"]);
									$desc = utf8_decode($row["cir_descripcion"]);
									$autorizacion = trim($row["cir_autorizacion"]);
									if($autorizacion == 1){
										$autorizacion_desc ='<span class="text-success small text-center"><em>Requiere Autorizaci&oacute;n</em></span>';
										$hidden = "";
										///-
										$respuatoriza = array();
										$persona = $_SESSION["tipo_codigo"];
										$respuatoriza = $ClsCir->get_autorizacion_directa($cod,$persona);
										$autoriza = $respuatoriza["autoriza"];
										$fecha_autoriza = $respuatoriza["fecha"];
										if($autoriza == null){
											$color = "btn btn-default";
											$iconoAut = "fas fa-check-circle text-success";
											$texto_botonAut = "&iquest;Autoriza?";
											//--
											$color = "btn btn-default";
											$iconoDeni = "fa fa-times-circle text-danger";
											$texto_botonDeni = "&iquest;No Autoriza?";
											$disabled = "";
											$label_desc ='';
										}else if($autoriza == 1){
											$fecha_autoriza = cambia_fechaHora($fecha_autoriza);
											$fecha_autoriza = substr($fecha_autoriza, 0, -3);
											$color = "btn btn-success";
											$iconoAut = "fa fa-check";
											$texto_botonAut = "Autorizado";
											$disabled = "disabled";
											$hidden = "hidden";
											$label_desc ='<label class="text-success text-center"><i class = "fas fa-check"></i> Autorizado '.$fecha_autoriza.'</label>';
										}else if($autoriza == 2){
											$fecha_autoriza = cambia_fechaHora($fecha_autoriza);
											$fecha_autoriza = substr($fecha_autoriza, 0, -3);
											$color = "btn btn-danger";
											$iconoAut = "fa fa-ban";
											$texto_botonAut = "Denegado";
											$disabled = "disabled";
											$hidden = "hidden";
											$label_desc ='<label class="text-danger text-center"><i class = "fa fa-times"></i> No Autorizado '.$fecha_autoriza.'</label>';
										}
									}else{
										$autorizacion_desc ='<span class="text-muted small text-center"><em>No Requiere Autorizaci&oacute;n</em></span>';
										$hidden = "hidden";
									}
									//--
									$salida.='<tr>';
										$salida.='<td class = "text-justify" width = "45%">';
										$salida.='<a href="../CONFIG/Circulares/'.$documento.'" target = "_blank" class="atablero">';
											$salida.='<h6>'.$titulo.'</h6>';
												$salida.='<span class="text-muted small text-justify"><em>'.$desc.'</em></span>';
											$salida.='</a>';
										$salida.='</td>';
										$salida.='<td class = "text-center" width = "20%">';
											$salida.= $autorizacion_desc;
										$salida.='</td>';
										$salida.='<td class = "text-center" width = "30%">';
											$salida.='<button type = "button" class="'.$color.' '.$hidden.'" onclick = "AutorizarCircular('.$cod.');" '.$disabled.' >';
												$salida.='<i class="'.$iconoAut.'"></i> '.$texto_botonAut;
											$salida.='</button> ';
											$salida.='<button type = "button" class="'.$color.' '.$hidden.'" onclick = "DenegarCircular('.$cod.');" '.$disabled.' >';
												$salida.='<i class="'.$iconoDeni.'"></i> '.$texto_botonDeni;
											$salida.='</button>';
											//--
											$salida.= $label_desc;
										$salida.='</td>';
										$salida.='<td class = "text-right" width = "5%">';
											$salida.='<a href="../CONFIG/Circulares/'.$documento.'" target = "_blank" class="btn btn-default">';
												$salida.='<i class="fas fa-file-pdf fa-2x text-danger"></i>';
											$salida.='</a>';
										$salida.='</td>';
										$salida.='<td class = "text-right" width = "5%">';
											$salida.='<a href="EXEdownload_circular.php?archivo='.$documento.'" class="btn btn-default">';
												$salida.='<i class="fas fa-file-download fa-2x"></i>';
											$salida.='</a>';
										$salida.='</td>';
									$salida.='</tr>';
								}
							}
						}
					?>

					<?php echo $salida; ?>
				</table>
			</div>
			<hr>
			<div class="table-products">
                <div class="row head">
                    <div class="col-md-12">
                        <h4>
							<i class="icon-rss fa-2x"></i> &nbsp;
							Noticias<small>(Actividades)</small>
						</h4>
                    </div>
                </div>
			</div>
			<br>
			<div class="table-responsive">
				<table class="table table-hover">
					<?php
						//////////////////////////////////////// GENERAL ///////////////////////////////////////////
						$ClsInfo = new ClsInformacion();
						$salida = "";
						if(is_array($result_informacion)){
							foreach($result_informacion as $row){
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
								$salida.='<tr>';
									$salida.='<td class = "text-justify" width = "90%">';
									$salida.='<a href="'.$link.'" target = "'.$target.'" class="atablero">';
										$salida.='<h6>'.$nombre.'</h6>';
											$salida.='<span class="text-muted small text-justify"><em>'.$desc.'</em></span>';
										$salida.='</a>';
									$salida.='</td>';
									$salida.='<td class = "text-justify" width = "5%">';
										$salida.='<a href="CPINFO/ICSinformacion.php?codigo='.$cod.'" target = "_blank" class="btn btn-default">';
											$salida.='<i class="fa fa-calendar"></i>';
										$salida.='</a> ';
									$salida.='</td>';
									$salida.='<td class = "text-justify" width = "5%">';
										$salida.='<a href="CPINFO/FRMdetalle.php?codigo='.$cod.'" target = "_blank" class="btn btn-default">';
											$salida.='<i class="fas fa-search-plus"></i>';
										$salida.='</a>';
									$salida.='</td>';
								$salida.='</tr>';
							}
						}
					?>
					<?php echo $salida; ?>
				</table>
			</div>
			<!-- end table sample -->
        </div>
    </div>

	<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div id = "ModalDialog" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-left" id="myModalLabel"><img src="../CONFIG/images/logo.png" alt="logo" width="28px" /> &nbsp;  <?php echo $_SESSION["nombre_colegio"]; ?></h4>
				</div>
				<div class="modal-body text-center" id= "lblparrafo">
					<img src="../CONFIG/images/img-loader.gif"/><br>
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
    <script src="assets.3.5.20/js/jquery-latest.js"></script>
    <script src="assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="assets.3.5.20/js/bootstrap.min.js"></script>
    <!-- knob -->
    <script src="assets.3.5.20/js/jquery.knob.js"></script>
    <!-- flot charts -->
    <script src="assets.3.5.20/js/theme.js"></script>
	<script src="assets.3.5.20/js/modules/circulares/circulares.js"></script>
	<script src="assets.3.5.20/js/modules/ejecutaModal.js"></script>

    <script type="text/javascript">
        function Ver_Informacion(codigo){
			//Realiza una peticion de contenido a la contenido.php
			$.post("promts/calendario/informacion_menu.php",{codigo:codigo}, function(data){
			// Ponemos la respuesta de nuestro script en el DIV recargado
			$("#Pcontainer").html(data);
			});
			abrirModal();
		}
    </script>
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
