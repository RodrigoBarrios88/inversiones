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
	
	$ClsPad = new ClsPadre();
	$result = $ClsPad->get_padre($dpi);
	if(is_array($result)){
		foreach($result as $row){
			$dpi = $row["pad_cui"];
			$tipodpi = trim($row["pad_tipo_dpi"]);
			$nombre = utf8_decode($row["pad_nombre"]);
			$apellido = utf8_decode($row["pad_apellido"]);
			$nombre_completo = "$nombre $apellido";
			$padrefecnac = trim($row["pad_fec_nac"]);
			$padrefecnac = ($padrefecnac != "0000-00-00")?$padrefecnac:date("Y-m-d");
			$padrefecnac = cambia_fecha($padrefecnac);
			//--
				$padrefecnacdia = substr($padrefecnac, 0, 2);
				$padrefecnacmes = substr($padrefecnac, 3, 2);
				$padrefecnacanio = substr($padrefecnac, 6, 4);
			//--
			$padreedad = Calcula_Edad($padrefecnac);
			$parentesco = trim($row["pad_parentesco"]);
			$ecivil = trim($row["pad_estado_civil"]);
			$nacionalidad = strtolower($row["pad_nacionalidad"]);
			$mail = strtolower($row["pad_mail"]);
			$telcasa = $row["pad_telefono"];
			$celular = $row["pad_celular"];
			$direccion = utf8_decode($row["pad_direccion"]);
			$departamento = utf8_decode($row["pad_departamento"]);
			$municipio = utf8_decode($row["pad_municipio"]);
			$trabajo = utf8_decode($row["pad_lugar_trabajo"]);
			$teltrabajo = $row["pad_telefono_trabajo"];
			$profesion = utf8_decode($row["pad_profesion"]);
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
	
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	
	
    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/form-wizard.css" type="text/css" media="screen" />

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body onload="JsonString('<?php echo url_origin( $_SERVER, true )."/SISTEM/API/API_inscripciones.php?request=bloqueados"; ?>');" >
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
				<?php if($situacion_contrato > 1){ ?>
				<div class = "row">
					<div class="col-lg-12">
						<h5 class="alert alert-warning text-center"><i class="fa fa-warning"></i> &nbsp; Usted ya completo el paso # 1</h5>
					</div>
				</div>
				<?php } ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="fuelux-wizard" class="wizard row-fluid">
                            <ul class="wizard-steps">
                                <li id = "label1" class="active">
                                    <span class="step">1</span>
                                    <span class="title">Datos del Padre</span>
                                </li>
                                <li id = "label2">
                                    <span class="step">2</span>
                                    <span class="title">Datos de Hijos</span>
                                </li>
                                <li id = "label3">
                                    <span class="step">3</span>
                                    <span class="title">Datos Administrativos</span>
                                </li>
                                <li id = "label4">
                                    <span class="step">4</span>
                                    <span class="title">Datos de Seguro</span>
                                </li>
                                <li id = "label5">
                                    <span class="step">5</span>
                                    <span class="title">Datos del Contrato</span>
                                </li>
                            </ul>                            
                        </div>
						<br>
                        <div class="step-content">
						<form name = "f1" name = "f1" method="get" enctype="multipart/form-data">
							<div class="step-pane active" id="step1">
                                <div class="">
								<div class="panel panel-default">
										<div class="panel-heading"> 
											<h5><span class="icon-user" aria-hidden="true"></span> Informaci&oacute;n del Padre, Madre o Encargado</h5>
										</div>
										<div class="panel-body">
											<div class = "row">
												<div class="col-lg-4 col-lg-offset-1"><label>DPI:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "dpi" name = "dpi" value="<?php echo $dpi; ?>" readonly />
													<input type="hidden" id = "inicio" name = "inicio" value="<?php echo $_REQUEST["inicio"]; ?>" />
													<input type="hidden" id = "pasohijo" name = "pasohijo" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Tipo de ID:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<select class="form-control" id = "tipodpi" name = "tipodpi" >
														<option value = "">Seleccione</option>
														<option value = "DPI">DPI</option>
														<option value = "PASAPORTE">PASAPORTE</option>
													</select>
													<script>
														document.getElementById("tipodpi").value = '<?php echo $tipodpi; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Nombres:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "nombre" name = "nombre" value="<?php echo $nombre; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Apellidos:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "apellido" name = "apellido" value="<?php echo $apellido; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Fecha de Nacimiento:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<div class='input-group date'>
														<?php echo input_fecha("padrefecnac","","valida_fecha('padrefecnac','');"); ?>
														<script>
															document.getElementById("padrefecnac").value = '<?php echo $padrefecnac; ?>';
															document.getElementById("padrefecnacdia").value = '<?php echo $padrefecnacdia; ?>';
															document.getElementById("padrefecnacmes").value = '<?php echo $padrefecnacmes; ?>';
															document.getElementById("padrefecnacanio").value = '<?php echo $padrefecnacanio; ?>';
														</script>
														<span class="input-group-addon">
															&nbsp; <span class="fa fa-calendar"></span> &nbsp;
														</span>
													</div>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Edad:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "edad" name = "edad" value="<?php echo $padreedad; ?> A&Ntilde;O(S)" readonly />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Parentesco:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<select class="form-control" name = "parentesco" id = "parentesco" >
														<option value = "">Seleccione</option>
														<option value = "P">PADRE</option>
														<option value = "M">MADRE</option>
														<option value = "A">ABUELO(A)</option>
														<option value = "O">ENCARGADO</option>
													</select>
													<script>
														document.getElementById("parentesco").value = '<?php echo $parentesco; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Estado Civil:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<select class="form-control" name = "ecivil" id = "ecivil" >
														<option value = "">Seleccione</option>
														<option value = "S">SOLTERO(A)</option>
														<option value = "C">CASADO(A)</option>
													</select>
													<script>
														document.getElementById("ecivil").value = '<?php echo $ecivil; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Nacionalidad:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "nacionalidad" name = "nacionalidad" value="<?php echo $nacionalidad; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>E-mail:</label> </div>
												<div class="col-lg-6">
													<input class="form-control text-libre" type="text" id = "mail" name = "mail" value="<?php echo $mail; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Direcci&oacute;n:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "direccion" name = "direccion" value="<?php echo $direccion; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Departamento:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<?php echo departamento_html('departamento',"xajax_depmun(this.value,'municipio','divmun');"); ?>
													<script>
														document.getElementById("departamento").value = '<?php echo $departamento; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Municipio:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6" id = "divmun">
													<?php
														if($departamento != ""){
															echo municipio_html($departamento,'municipio','');
														}else{
															echo combos_vacios("municipio");
														}
													?>
													<script>
														document.getElementById("municipio").value = '<?php echo $municipio; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Tel&eacute;fono Casa:</label> </div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "telcasa" name = "telcasa" value="<?php echo $telcasa; ?>" onkeyup = "enterosExtremos(this);" maxlength = "8" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Celular:</label> </div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "celular" name = "celular" value="<?php echo $celular; ?>" onkeyup = "enterosExtremos(this);" maxlength = "8" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Lugar de Trabajo:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "trabajo" name = "trabajo" value="<?php echo $trabajo; ?>" onkeyup="texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Tel&eacute;fono de Trabajo:</label> </div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "teltrabajo" name = "teltrabajo" value="<?php echo $teltrabajo; ?>" onkeyup = "enterosExtremos(this);" maxlength = "8" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Profesi&oacute;n u Oficio:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input class="form-control" type="text" id = "profesion" name = "profesion" value="<?php echo $profesion; ?>" onkeyup="texto(this);" />
												</div>
											</div>
										</div>
									</div>
									<hr>
								</div>
                            </div>
                        </form>
                        </div>
                        <div class="wizard-actions">
                            <button type="button" disabled class="btn-glow primary btn-prev"> 
                                <i class="fa fa-chevron-left"></i> Antes
                            </button>
                            <button type="button" class="btn-glow primary" onclick="ActualizaPadre();">
                                Siguiente <i class="fa fa-chevron-right"></i>
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
		$('#padrefecnac').datepicker().on('changeDate', function (ev) {
			$(this).datepicker('hide');
			xajax_Calcular_Edad( this.value, '');
		});
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