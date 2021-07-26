<?php
	include_once('xajax_funct_hijos.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
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
	
	
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($id);
	if(is_array($result)){
		foreach($result as $row){
			$tipo = trim($row["usu_tipo"]);
			$dpi = trim($row["usu_tipo_codigo"]);
		}
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
	
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	
    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/index.css" type="text/css" media="screen" />
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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
			<li class="active">
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
			<li>
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
				<div class="col-md-10 col-md-offset-1">
					<br>
					<?php
						$ClsCli = new ClsCliente(); 
						$ClsAsi = new ClsAsignacion();
						$ClsSeg = new ClsSeguro();
						$result = $ClsAsi->get_alumno_padre($dpi,"");
						if (is_array($result)) {
							$i = 1;
							foreach($result as $row){
								$cui = trim($row["alu_cui"]);
								$tipocui = trim($row["alu_tipo_cui"]);
								$codigo = trim($row["alu_codigo_interno"]);
								//pasa a mayusculas
								$nombre = utf8_decode($row["alu_nombre"]);
								$apellido = utf8_decode($row["alu_apellido"]);
								$nombre_completo = ucwords(strtolower($nombre." ".$apellido));
								//--------
								$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
								//--
									$fecnacdia = substr($fecnac, 0, 2);
									$fecnacmes = substr($fecnac, 3, 2);
									$fecnacanio = substr($fecnac, 6, 4);
								//--
								$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
								$genero = trim($row["alu_genero"]);
								$nacionalidad = utf8_decode($row["alu_nacionalidad"]);
								$religion = utf8_decode($row["alu_religion"]);
								$idioma = utf8_decode($row["alu_idioma"]);
								$mail = trim($row["alu_mail"]);
								$nit = trim($row["alu_nit"]);
								$clinombre= utf8_decode($row["alu_cliente_nombre"]);
								$clidireccion = utf8_decode($row["alu_cliente_direccion"]);
								//--
								$sangre = trim($row["alu_tipo_sangre"]);
								$alergico = utf8_decode($row["alu_alergico_a"]);
								$emergencia = utf8_decode($row["alu_emergencia"]);
								$emergencia_tel = trim($row["alu_emergencia_telefono"]);
								$recoge = utf8_decode($row["alu_recoge"]);
								$redesociales = trim($row["alu_redes_sociales"]);
								//--
								$seguro = trim($row["tiene_seguro"]);
								$poliza = utf8_decode($row["poliza"]);
								$aseguradora = utf8_decode($row["aseguradora"]);
								$plan = utf8_decode($row["plan"]);
								$asegurado_principla = utf8_decode($row["asegurado_principla"]);
								$instrucciones = utf8_decode($row["instrucciones"]);
								$comentario = utf8_decode($row["comentario"]);
								//---
								$foto = trim($row["alu_foto"]);
								if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){
									$foto = 'ALUMNOS/'.$foto.'.jpg';
								}else{
									$foto = "nofoto.png";
								}
								$usu = $_SESSION["codigo"];
								$hashkey = $ClsAsi->encrypt($cui, $usu);
								
								
								//////SEGURO
								$result = $ClsSeg->get_seguro($cui);
								if(is_array($result)){
									foreach($result as $row){
										$seguro = utf8_decode($row["seg_tiene_seguro"]);
										$poliza = utf8_decode($row["seg_poliza"]);
										$aseguradora = utf8_decode($row["seg_aseguradora"]);
										$plan = utf8_decode($row["seg_plan"]);
										$asegurado = utf8_decode($row["seg_asegurado_principal"]);
										$instrucciones = utf8_decode($row["seg_instrucciones"]);
										$comentarios = utf8_decode($row["seg_comentarios"]);
									}
								}
							
							//hash para la ficha	
							$usu = $_SESSION["codigo"];
							$hashkey = $ClsAsi->encrypt($cui, $usu);
					?>
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<h5><span class="fa fa-group" aria-hidden="true"></span> Informaci&oacute;n de <strong><?php echo $nombre_completo; ?></strong></h5>
						</div>
						<div class="panel-body">
							<div class = "row">
								<div class="col-md-4 col-md-offset-4 text-center">
									<button type="button" class="btn btn-default btn-block" onclick = "window.location.reload();"><span class="fas fa-sync"></span></button>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-4 text-center">
									<a href="javascript:void(0);" class="thumbnail" id="img-container<?php echo $i; ?>">
										<img src="../../CONFIG/Fotos/<?php echo $foto; ?>" alt="foto" width="150px" />
									</a>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-4 text-center">
									<button type="button" class="btn-glow btn-block primary" id = "btn-cargar<?php echo $i; ?>" onclick = "FotoJs(<?php echo $i; ?>);" title = "Cambiar Fotograf&iacute;a"><i class="fa fa-camera"></i> Cambiar Fotograf&iacute;a...</button>
									<input id="imagen<?php echo $i; ?>" name="imagen<?php echo $i; ?>" type="file" multiple="false" class = "hidden" onchange="Cargar(<?php echo $i; ?>);" >
									<input type="hidden" id = "foto<?php echo $i; ?>" name = "foto<?php echo $i; ?>" value="<?php echo $cui; ?>"  />
								</div>
							</div>
							<br>
							<div class = "row">
								<div class="col-md-4 col-md-offset-4 text-center">
									<a href="../CPFICHA/FRMpaso1.php?hashkey=<?php echo $hashkey; ?>" title="Actualizar datos de la ficha preescolar">
										<i class="fas fa-file-alt fa-5x text-muted"></i> <br><br>
										<label class="text-muted"> Ficha Preescolar</label>
									</a>
								</div>
							</div>
							<br>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>CUI:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<div class="form-info"><?php echo $cui; ?></div>
									<input type="hidden" id = "cui<?php echo $i; ?>" name = "cui<?php echo $i; ?>" value="<?php echo $cui; ?>" />
									<input type="hidden" id = "codigo<?php echo $i; ?>" name = "codigo<?php echo $i; ?>" value="<?php echo $codigo; ?>" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Tipo de Identificaci&oacute;n:</label> <span class = "text-danger">*</span></div>
								<div class="col-xs-6">
									<select class="form-control" id = "tipocui<?php echo $i; ?>" name = "tipocui<?php echo $i; ?>" >
										<option value = "">Seleccione</option>
										<option value = "CUI">CUI (RENAP)</option>
										<option value = "PASAPORTE">Pasaporte</option>
									</select>
									<script>
										document.getElementById("tipocui<?php echo $i; ?>").value = '<?php echo $tipocui; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Nombres:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "nombre<?php echo $i; ?>" name = "nombre<?php echo $i; ?>" value="<?php echo $nombre; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Apellidos:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "apellido<?php echo $i; ?>" name = "apellido<?php echo $i; ?>" value="<?php echo $apellido; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Genero:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<select class="form-control" id = "genero<?php echo $i; ?>" name = "genero<?php echo $i; ?>" >
										<option value = "">Seleccione</option>
										<option value = "M">Ni&ntilde;o (M)</option>
										<option value = "F">Ni&ntilde;a (F)</option>
									</select>
									<script>
										document.getElementById("genero<?php echo $i; ?>").value = '<?php echo $genero; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Fecha de Nacimiento:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<div class='input-group date'>
										<?php echo input_fecha("fecnac","$i","valida_fecha('fecnac','$i');"); ?>
										<script>
										document.getElementById("fecnac<?php echo $i; ?>").value = '<?php echo $fecnac; ?>';
										document.getElementById("fecnacdia<?php echo $i; ?>").value = '<?php echo $fecnacdia; ?>';
										document.getElementById("fecnacmes<?php echo $i; ?>").value = '<?php echo $fecnacmes; ?>';
										document.getElementById("fecnacanio<?php echo $i; ?>").value = '<?php echo $fecnacanio; ?>';
										</script>
										<span class="input-group-addon">
										&nbsp; <span class="fa fa-calendar"></span> &nbsp;
										</span>
									</div>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Edad:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "edad<?php echo $i; ?>" name = "edad<?php echo $i; ?>" value="<?php echo $edad; ?>" readonly />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Nacionalidad:</label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "nacionalidad<?php echo $i; ?>" name = "nacionalidad<?php echo $i; ?>" value="<?php echo $nacionalidad; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Religi&oacute;n:</label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "religion<?php echo $i; ?>" name = "religion<?php echo $i; ?>" value="<?php echo $religion; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Idioma Nativo :</label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "idioma<?php echo $i; ?>" name = "idioma<?php echo $i; ?>" value="<?php echo $idioma; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Email del Alumno: <small class="text-muted">(no aplica para preescolar)</small> </label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "mail<?php echo $i; ?>" name = "mail<?php echo $i; ?>" value="<?php echo $mail; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>T&iacute;po de Sangre:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<select class="form-control" id = "sangre<?php echo $i; ?>" name = "sangre<?php echo $i; ?>" >
										<option value = "">Seleccione</option>
										<option value = "O+">O Rh +</option>
										<option value = "O-">O Rh -</option>
										<option value = "A+">A Rh +</option>
										<option value = "A-">A Rh -</option>
									   <option value = "B+">B Rh +</option>
									   <option value = "B-">B Rh -</option>
									   <option value = "AB+">AB Rh +</option>
									   <option value = "AB-">AB Rh -</option>
									</select>
									<script>
										document.getElementById("sangre<?php echo $i; ?>").value = '<?php echo $sangre; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Al&eacute;rgico A:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "alergia<?php echo $i; ?>" name = "alergia<?php echo $i; ?>" value="<?php echo $alergico; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>En una emergencia avisar a:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "emergencia<?php echo $i; ?>" name = "emergencia<?php echo $i; ?>" value="<?php echo $emergencia; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Telefono de emergencia:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input class="form-control text-libre" type="text" id = "emetel<?php echo $i; ?>" name = "emetel<?php echo $i; ?>" value="<?php echo $emergencia_tel; ?>" onkeyup="enteros(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Qui&eacute;n recoge en el colegio:</label></div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "recoge<?php echo $i; ?>" name = "recoge<?php echo $i; ?>" value="<?php echo $recoge; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Autoriza publicar imagenes en redes Sociales:</label></div>
								<div class="col-md-6">
									<select class="form-control" id = "redsoc<?php echo $i; ?>" name = "redsoc<?php echo $i; ?>" >
										<option value = "">Seleccione</option>
										<option value = "Si" selected >Si</option>
										<option value = "No">No</option>
									</select>
									<script>
										document.getElementById("redsoc<?php echo $i; ?>").value = '<?php echo $redesociales; ?>';
									</script>
								</div>
							</div>
							<hr>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Nit a Facturar:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input type = "text" class = "form-control" name = "nit<?php echo $i; ?>" id = "nit<?php echo $i; ?>"  value = "<?php echo $nit; ?>" onkeyup = "texto(this);" onblur = "Cliente(1);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Nombre a Facturar:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input type="text" class="form-control" name = "clinombre<?php echo $i; ?>" id = "clinombre<?php echo $i; ?>" value = "<?php echo $clinombre; ?>" onkeyup = "texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Direcci&oacute;n de Facturaci&oacute;n:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									<input type="text" class="form-control" name = "clidireccion<?php echo $i; ?>" id = "clidireccion<?php echo $i; ?>" value = "<?php echo $clidireccion; ?>" onkeyup = "texto(this);" />
								</div>
							</div>
							<hr>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>El ni&ntilde;o(a) tiene seguro?</label> <span class = "text-danger">*</span></div>
								<div class="col-md-6">
									&nbsp; <label><input type="radio" id = "segurosi<?php echo $i; ?>" name = "seguro<?php echo $i; ?>" onclick="valida_seguro(<?php echo $i; ?>);" /><label for="segurosi<?php echo $i; ?>" id = "labelsi<?php echo $i; ?>" > Si</label></label>
									&nbsp; <label><input type="radio" id = "segurono<?php echo $i; ?>" name = "seguro<?php echo $i; ?>" onclick="valida_seguro(<?php echo $i; ?>);" /><label for="segurono<?php echo $i; ?>" id = "labelno<?php echo $i; ?>" > No</label></label>
									<script>
										var sino = <?php echo $seguro; ?>;
										if(sino == 1){
											document.getElementById("segurosi<?php echo $i; ?>").checked = true;
										}else if(sino == 0){
											document.getElementById("segurono<?php echo $i; ?>").checked = true;
										}
										
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>No. de Poliza:</label> </div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "poliza<?php echo $i; ?>" name = "poliza<?php echo $i; ?>" value="<?php echo $poliza; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Aseguradora:</label> </div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "aseguradora<?php echo $i; ?>" name = "aseguradora<?php echo $i; ?>" value="<?php echo $aseguradora; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Plan:</label> </div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "plan<?php echo $i; ?>" name = "plan<?php echo $i; ?>" value="<?php echo $plan; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Asegurado Principal:</label> </div>
								<div class="col-md-6">
									<input class="form-control" type="text" id = "asegurado<?php echo $i; ?>" name = "asegurado<?php echo $i; ?>" value="<?php echo $asegurado; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Instrucciones:</label> </div>
								<div class="col-md-6">
									<textarea class="form-control" id = "instrucciones<?php echo $i; ?>" name = "instrucciones<?php echo $i; ?>" onkeyup="texto(this);" ><?php echo $instrucciones; ?></textarea>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-4 col-md-offset-1"><label>Comentarios:</label> </div>
								<div class="col-md-6">
									<textarea class="form-control" id = "comentarios<?php echo $i; ?>" name = "comentarios<?php echo $i; ?>" onkeyup="texto(this);" ><?php echo $comentarios; ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<br>
					<!-- /.panel-default -->
					<?php
								$i++;
							}
							$i--;
						}						
					?>	
					<!-- Botones -->
					<hr>
					<div class = "row">
						<div class="col-md-6 col-md-offset-3 text-center">
							<input type= "hidden" id = "hijos" name= "hijos" value = "<?php echo $i; ?>" />
						</div>
					</div>
					<div class = "row">
						<div class="col-md-6 col-md-offset-3 text-center">
							<a class="btn-glow default" href = "FRMhijos.php" ><i class="fas fa-times"></i> Cancelar</a> &nbsp;
							<button class="btn-glow primary" id = "grab" onclick = "Modificar();" <?php echo $disabled; ?> ><i class="fas fa-save"></i> Grabar</button>
						</div>
					</div>
					<!-- / Botones -->
				</div>
			</div>
    </div>
	
	<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="28px" /> &nbsp;  <?php echo $_SESSION["nombre_colegio"]; ?></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../CONFIG/images/img-loader.gif"/><br>
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
    <script src="../assets.3.5.20/js/theme.js"></script>
	<script src="../assets.3.5.20/js/jquery.dataTables.js"></script>
    
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/hijos/hijos.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/loading.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>