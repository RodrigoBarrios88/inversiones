<?php
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

	include_once('xajax_funct_inscripcion.php');
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
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($id);
	if(is_array($result)){
		foreach($result as $row){
			$tipo = trim($row["usu_tipo"]);
			$dpi = trim($row["usu_tipo_codigo"]);
		}
	}
	
	$ClsIns = new ClsInscripcion();
	$ClsCli = new ClsCliente();
	$ClsAsi = new ClsAsignacion();
	$ClsSeg = new ClsSeguro();
	
	$i = 1;
	$result = $ClsIns->get_alumno_padre($dpi,"");
	if(is_array($result)) {
		$i = 1;
		foreach($result as $row){
			$cui = trim($row["alu_cui_new"]);
            $_REQUEST["cuinew$i"] = trim($row["alu_cui_new"]);
			$_REQUEST["cuiold$i"] = trim($row["alu_cui_old "]);
			$_REQUEST["codigo$i"] = trim($row["alu_codigo_interno"]);
			$_REQUEST["tipocui$i"] = trim($row["alu_tipo_cui"]);
			//pasa a mayusculas
			$_REQUEST["nombre$i"] = utf8_decode($row["alu_nombre"]);
			$_REQUEST["apellido$i"] = utf8_decode($row["alu_apellido"]);
			//--------
			$_REQUEST["fecnac$i"] = cambia_fecha($row["alu_fecha_nacimiento"]);
			//--
				$_REQUEST["fecnacdia$i"] = substr($_REQUEST["fecnac$i"], 0, 2);
				$_REQUEST["fecnacmes$i"] = substr($_REQUEST["fecnac$i"], 3, 2);
				$_REQUEST["fecnacanio$i"] = substr($_REQUEST["fecnac$i"], 6, 4);
			//--
			$_REQUEST["edad$i"] = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
			$_REQUEST["genero$i"] = trim($row["alu_genero"]);
			$_REQUEST["cli$i"] = trim($row["alu_cliente_factura"]);
			//--
			$_REQUEST["sangre$i"] = trim($row["alu_tipo_sangre"]);
			$_REQUEST["alergico$i"] = utf8_decode($row["alu_alergico_a"]);
			$_REQUEST["emergencia$i"] = utf8_decode($row["alu_emergencia"]);
			$_REQUEST["emertel$i"] = trim($row["alu_emergencia_telefono"]);
			//-- DATOS DEL CONTRATO
			$result2 = $ClsIns->get_status($cui);
			if(is_array($result2)){
				foreach($result2 as $row2){
					$_REQUEST["status$i"] = 1;
					$situacion_contrato = $row2["stat_situacion"];
					$_REQUEST["contrato$i"] = $row2["stat_contrato"];
					$_REQUEST["contradpi$i"] = utf8_decode($row2["stat_dpi_firmante"]);
					$_REQUEST["contratipodpi$i"] = trim($row2["stat_tipo_dpi"]);
					$_REQUEST["contranombre$i"] = utf8_decode($row2["stat_nombre"]);
					$_REQUEST["contraapellido$i"] = utf8_decode($row2["stat_apellido"]);
					$_REQUEST["contrafecnac$i"] = cambia_fecha($row2["stat_fec_nac"]);
					//--
						$_REQUEST["contrafecnacdia$i"] = substr($_REQUEST["contrafecnac$i"], 0, 2);
						$_REQUEST["contrafecnacmes$i"] = substr($_REQUEST["contrafecnac$i"], 3, 2);
						$_REQUEST["contrafecnacanio$i"] = substr($_REQUEST["contrafecnac$i"], 6, 4);
					//--
					$_REQUEST["contraedad$i"] = Calcula_Edad(cambia_fecha($row2["stat_fec_nac"]));
					$_REQUEST["contraparentesco$i"] = trim($row2["stat_parentesco"]);
					$_REQUEST["contraecivil$i"] = trim($row2["stat_estado_civil"]);
					$_REQUEST["contranacionalidad$i"] = strtolower($row2["stat_nacionalidad"]);
					$_REQUEST["contramail$i"] = strtolower($row2["stat_mail"]);
					$_REQUEST["contradireccion$i"] = utf8_decode($row2["stat_direccion"]);
					$_REQUEST["contradep$i"] = utf8_decode($row2["stat_departamento"]);
					$_REQUEST["contramun$i"] = utf8_decode($row2["stat_municipio"]);
					$_REQUEST["contratelcasa$i"] = $row2["stat_telefono"];
					$_REQUEST["contracelular$i"] = $row2["stat_celular"];
					$_REQUEST["contratrabajo$i"] = utf8_decode($row2["stat_lugar_trabajo"]);
					$_REQUEST["contrateltrabajo$i"] = $row2["stat_telefono_trabajo"];
					$_REQUEST["contraprofesion$i"] = utf8_decode($row2["stat_profesion"]);
				}
			}
	
			$i++;
		}
		$i--;
		$alumnos = $i;
        $_REQUEST["alumnos"] = $i;
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
    <link href="../assets.3.5.20/css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />
	
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	
	
    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/index.css" type="text/css" media="screen" />
	
	<!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/form-wizard.css" type="text/css" media="screen" />

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body onload="JsonString();">
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
			<li class="active">
                <a class="dropdown-toggle" href="#">
                    <i class="fa fa-edit"></i>
                    <span>Inscripciones</span>
                </a>
                <ul class="submenu" style="display: block;">
                    <li><a href="FRMpaso1.php"> <label>Paso # 1</label></a></li>
                    <li><a href="FRMpaso2.php"> Paso # 2</a></li>
                    <li><a href="FRMpaso3.php"> Paso # 3</a></li>
					<li><a href="FRMpaso4.php"> Paso # 4</a></li>
                </ul>
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
		<div class="container-fluid">
            <div id="pad-wrapper">
                <div class="row-fluid head">
					<button type="button" onclick="Limpiar();" class="btn-glow default pull-right"> 
                        <i class="fas fa-sync"></i> Limpiar
                    </button>
					<!--button type="button" onclick="CompareNombreBloqueado(1);" class="btn-glow success pull-right"> 
                        <i class="fa fa-check"></i> Prueba
                    </button-->
                    <div class="span12">
                        <h3>PASO # 1:</h3>
						<h5>Actualizaci&oacute;n de Datos</h5>
					</div>
                </div>
				<hr><br>
				<div class="row-fluid">
                    <div class="span12">
                        <div id="fuelux-wizard" class="wizard row-fluid">
                            <ul class="wizard-steps">
                                <li>
									<a href="FRMpaso1.php" style="text-decoration:none;">
										<span class="step">1</span>
										<span class="title">Datos del Padre</span>
									</a>
                                </li>
                                <li>
                                    <a href="FRMpaso1B.php" style="text-decoration:none;">
										<span class="step">2</span>
										<span class="title">Datos de Hijos</span>
									</a>
                                </li>
                                <li>
									<a href="FRMpaso1C.php" style="text-decoration:none;">
										<span class="step">3</span>
										<span class="title">Datos Administrativos</span>
									</a>
                                </li>
                                <li>
									<a href="FRMpaso1D.php" style="text-decoration:none;">
										<span class="step">4</span>
										<span class="title">Datos de Seguro</span>
									</a>
                                </li>
                                <li class="active">
                                    <span class="step">5</span>
                                    <span class="title">Datos del Contrato</span>
                                </li>
                            </ul>                              
                        </div>
						<br>
                        <div class="step-content">
						<form name = "f1" name = "f1" method="get" enctype="multipart/form-data">
							<div class="step-pane active" id="step5">
                                <div class="">
								<input type = "hidden" name = "alumnos" id = "alumnos" value = "<?php echo $alumnos; ?>" />
								<input type = "hidden" name = "dpi" id = "dpi" value = "<?php echo $dpi; ?>" />
								<?php for($i = 1; $i <= $alumnos; $i++){ ?>	
									<div class="panel panel-default">
										<div class="panel-heading"> 
											<h5><span class="fas fa-file-alt" aria-hidden="true"></span> Informaci&oacute;n del firmante del contrato</h5>
											<small class="import-button pull-right">
												<button type="button" class="btn btn-default btn-xs" onclick="DePadreHaciaCotrato('<?php echo $dpi; ?>',<?php echo $i; ?>);" title="Usar Datos del Padre/Madre" data-container="body" data-toggle="popover" data-placement="top" data-content=" Click para usar los datos actualizados inicialmente por el/la padre o madre">   
													<i class="icon-download2"></i>
												</button>
											</small>
										</div>
										<div class="panel-body">
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Alumno:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input type="text" class="form-info" id = "cuinew<?php echo $i; ?>" name = "cuinew<?php echo $i; ?>" value="<?php echo $_REQUEST["cuinew$i"]; ?>" readonly />
													<label class="form-info" id = "NomAdmin<?php echo $i; ?>"><?php echo trim($_REQUEST["nombre$i"]); ?> <?php echo trim($_REQUEST["apellido$i"]); ?></label>
													<input type="hidden" id = "cuiold<?php echo $i; ?>" name = "cuiold<?php echo $i; ?>" value="<?php echo $_REQUEST["cuiold$i"]; ?>" />
													<input type="hidden" id = "codigo<?php echo $i; ?>" name = "codigo<?php echo $i; ?>" value="<?php echo $_REQUEST["codigo$i"]; ?>" />
													<input type="hidden" id = "existe<?php echo $i; ?>" name = "existe<?php echo $i; ?>"  value = "<?php echo $_REQUEST["existe$i"]; ?>" />
													<input type="hidden" id = "contrato<?php echo $i; ?>" name = "contrato<?php echo $i; ?>"  value = "<?php echo $_REQUEST["contrato$i"]; ?>" />
												</div>
											</div>
											<hr>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>DPI:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contradpi<?php echo $i; ?>" name = "contradpi<?php echo $i; ?>" value="<?php echo $_REQUEST["contradpi$i"]; ?>" onkeyup = "enterosExtremos(this);" maxlength = "13" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Tipo de ID:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<select class="form-control" id = "contratipodpi<?php echo $i; ?>" name = "contratipodpi<?php echo $i; ?>" >
														<option value = "">Seleccione</option>
														<option value = "DPI">DPI</option>
														<option value = "PASAPORTE">PASAPORTE</option>
													</select>
													<script>
														document.getElementById("contratipodpi<?php echo $i; ?>").value = '<?php echo $_REQUEST["contratipodpi$i"]; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Nombres:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contranombre<?php echo $i; ?>" name = "contranombre<?php echo $i; ?>" value="<?php echo $_REQUEST["contranombre$i"]; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Apellidos:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contraapellido<?php echo $i; ?>" name = "contraapellido<?php echo $i; ?>" value="<?php echo $_REQUEST["contraapellido$i"]; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Fecha de Nacimiento:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<div class='input-group date'>
														<?php echo input_fecha("contrafecnac","$i","valida_fecha('contrafecnac','$i');"); ?>
														<script>
															document.getElementById("contrafecnac<?php echo $i; ?>").value = '<?php echo $_REQUEST["contrafecnac$i"]; ?>';
															document.getElementById("contrafecnacdia<?php echo $i; ?>").value = '<?php echo $_REQUEST["contrafecnacdia$i"]; ?>';
															document.getElementById("contrafecnacmes<?php echo $i; ?>").value = '<?php echo $_REQUEST["contrafecnacmes$i"]; ?>';
															document.getElementById("contrafecnacanio<?php echo $i; ?>").value = '<?php echo $_REQUEST["contrafecnacanio$i"]; ?>';
														</script>
														<span class="input-group-addon">
															&nbsp; <span class="fa fa-calendar"></span> &nbsp;
														</span>
													</div>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Parentesco:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<select class="form-control" name = "contraparentesco<?php echo $i; ?>" id = "contraparentesco<?php echo $i; ?>" >
														<option value = "">Seleccione</option>
														<option value = "P">PADRE</option>
														<option value = "M">MADRE</option>
														<option value = "A">ABUELO(A)</option>
														<option value = "O">ENCARGADO</option>
													</select>
													<script>
														document.getElementById("contraparentesco<?php echo $i; ?>").value = '<?php echo $_REQUEST["contraparentesco$i"]; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Estado Civil:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<select class="form-control" name = "contraecivil<?php echo $i; ?>" id = "contraecivil<?php echo $i; ?>" >
														<option value = "">Seleccione</option>
														<option value = "S">SOLTERO(A)</option>
														<option value = "C">CASADO(A)</option>
													</select>
													<script>
														document.getElementById("contraecivil<?php echo $i; ?>").value = '<?php echo $_REQUEST["contraecivil$i"]; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Nacionalidad:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contranacionalidad<?php echo $i; ?>" name = "contranacionalidad<?php echo $i; ?>" value="<?php echo $_REQUEST["contranacionalidad$i"]; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>E-mail:</label> </div>
												<div class="col-lg-6">
													<input class="form-control text-libre" type="text" id = "contramail<?php echo $i; ?>" name = "contramail<?php echo $i; ?>" value="<?php echo $_REQUEST["contramail$i"]; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Direcci&oacute;n:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contradireccion<?php echo $i; ?>" name = "contradireccion<?php echo $i; ?>" value="<?php echo $_REQUEST["contradireccion$i"]; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Departamento:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<?php echo departamento_html("contradep$i","xajax_depmun(this.value,'contramun$i','contradivmun$i');"); ?>
													<script>
														document.getElementById("contradep<?php echo $i; ?>").value = '<?php echo $_REQUEST["contradep$i"]; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Municipio:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6" id = "contradivmun<?php echo $i; ?>">
													<?php
														$tempdep = ($_REQUEST["contradep$i"] != "")?$_REQUEST["contradep$i"]:100;
														echo municipio_html($tempdep,"contramun$i","");
													?>
													<script>
														document.getElementById("contramun<?php echo $i; ?>").value = '<?php echo $_REQUEST["contramun$i"]; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Tel&eacute;fono Casa:</label> </div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contratelcasa<?php echo $i; ?>" name = "contratelcasa<?php echo $i; ?>" value="<?php echo $_REQUEST["contratelcasa$i"]; ?>" onkeyup="enteros(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Celular:</label> </div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contracelular<?php echo $i; ?>" name = "contracelular<?php echo $i; ?>" value="<?php echo $_REQUEST["contracelular$i"]; ?>" onkeyup="enteros(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Lugar de Trabajo:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contratrabajo<?php echo $i; ?>" name = "contratrabajo<?php echo $i; ?>" value="<?php echo $_REQUEST["contratrabajo$i"]; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Tel&eacute;fono de Trabajo:</label> </div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contrateltrabajo<?php echo $i; ?>" name = "contrateltrabajo<?php echo $i; ?>" value="<?php echo $_REQUEST["contrateltrabajo$i"]; ?>" onkeyup="enteros(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Profesi&oacute;n u Oficio:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "contraprofesion<?php echo $i; ?>" name = "contraprofesion<?php echo $i; ?>" value="<?php echo $_REQUEST["contraprofesion$i"]; ?>" onkeyup="texto(this);" />
												</div>
											</div>
										</div>
									</div>
									<hr>
								<?php } ?>
								</div>
                            </div>
                        </form>
                        </div>
                        <div class="wizard-actions">
                            <a href="FRMpaso1D.php" class="btn-glow primary btn-prev"> 
                                <i class="fa fa-chevron-left"></i> Antes
                            </a>
                            <button type="button" class="btn-glow success" onclick="ActualizaContrato();">
								<i class="fa fa-check-square-o"></i> Finalizar Paso # 1
							</button>
                        </div>
                    </div>
                </div>
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
	<script src="../assets.3.5.20/js/bootstrap.datepicker.js"></script>
	<!-- matches string score -->
	<script src="../assets.3.5.20/js/plugins/string_score/string_score.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/inscripcion/paso1.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	
	<script>
		$("[data-toggle=popover]").popover('show');
	</script>
	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>