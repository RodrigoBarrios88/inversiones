<?php
	include_once('xajax_funct_ficha.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
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
	$hashkey = $_REQUEST["hashkey"];
	//--
	
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $id);
	
	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
            $genero = trim($row["alu_genero"]);
			$genero = ($genero == "M")?"Ni&ntilde;o":"Ni&ntilde;a";
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			$edad_actual = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
        }	
	}
	
	$ClsFic = new ClsFicha();
	$result = $ClsFic->get_lenguaje($cui);
	if(is_array($result)){
		foreach($result as $row){
			$dientes = utf8_decode($row["len_dientes"]);
			$balbuceo = utf8_decode($row["len_balbuceo"]);
			$palabras = utf8_decode($row["len_palabras"]);
			$oraciones = utf8_decode($row["len_oraciones"]);
			$articula = utf8_decode($row["len_articula"]);
			$entiende = utf8_decode($row["len_entiende"]);
			$actualizo = utf8_decode($row["len_fecha_actualiza"]);
		}	
	}
	
	if($actualizo != ""){
		$actualizo = cambia_fechaHora($actualizo);
		$actualizado = '<small class = "pull-right text-success"><i  class = "fas fa-check-circle"></i> Actualizado el '.$actualizo.'</small>';
	}else{
		$actualizado = '<small class = "pull-right text-danger"><i  class = "fa fa-times-circle-o"></i> No ha actualizado la informaci&oacute;n</small>';
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
    <link href="../assets.3.5.20/css/util.css" rel="stylesheet">
	<link href="../assets.3.5.20/css/ficha.css" rel="stylesheet">
	
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
				<div class="col-lg-10 col-xs-12 col-md-offset-1">
					<br>
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<h5><span class="fas fa-file-alt" aria-hidden="true"></span> Ficha Preescolar de <?php echo $nombre; ?></label></h5>
						</div>
						<div class="panel-body">
							<div class = "row">
								<div class = "col-md-12">
									<ul class="nav nav-tabs" role="tablist">
										<li class="fila1"><a href="FRMpaso1.php?hashkey=<?php echo $hashkey; ?>" ><label>1. Historial Personal</label></a></li>
										<li class="fila1"><a href="FRMpaso2.php?hashkey=<?php echo $hashkey; ?>" ><label>2. Embarazo</label></a></li>
										<li class="fila1"><a href="FRMpaso3.php?hashkey=<?php echo $hashkey; ?>" ><label>3. Parto</label></a></li>
										<li class="fila1"><a href="FRMpaso4.php?hashkey=<?php echo $hashkey; ?>" ><label>4. Lactancia</label></a></li>
										<li class="fila1"><a href="FRMpaso5.php?hashkey=<?php echo $hashkey; ?>" ><label>5. Desarrollo Motor</label></a></li>
										<li class="active fila2"><a href="FRMpaso6.php?hashkey=<?php echo $hashkey; ?>" ><label>6. Lenguaje</label></a></li>
										<li class="fila2"><a href="FRMpaso7.php?hashkey=<?php echo $hashkey; ?>" ><label>7. Sue&ntilde;o</label></a></li>
										<li class="fila2"><a href="FRMpaso8.php?hashkey=<?php echo $hashkey; ?>" ><label>8. Alimentaci&oacute;n</label></a></li>
										<li class="fila2"><a href="FRMpaso9.php?hashkey=<?php echo $hashkey; ?>" ><label>9. Vista</label></a></li>
										<li class="fila2"><a href="FRMpaso10.php?hashkey=<?php echo $hashkey; ?>" ><label>10. O&iacute;do</label></a></li>
										<li class="fila2"><a href="FRMpaso11.php?hashkey=<?php echo $hashkey; ?>" ><label>11. Caracter</label></a></li>
									</ul>
									<!-- TABS -->
									<div class="tab-content">
										<!---- POR UNIDADES -->
										<div role="tabpanel" class="tab-pane active col-md-10 col-md-offset-1" id="unidades">
											<br><br>
											<div class = "row">
												<div class="col-lg-10 col-md-offset-1">
													<h5 class="alert alert-info">
														<i class="fa fa-language"></i> &nbsp;  Lenguaje
														<?php echo $actualizado; ?>
													</h5>
													<input type = "hidden" id = "cui" name = "cui" value="<?php echo $cui; ?>" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-10 col-lg-offset-1 col-xs-12">
													<label class = "etiqueta">&iquest;A que edad empez&oacute; su dentici&oacute;n? (meses)</label> <br>
													<input class="form-control text-libre" type="text" id = "dientes" name = "dientes" value="<?php echo $dientes; ?>" onkeyup="enteros(this);" maxlength = "2" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-10 col-lg-offset-1 col-xs-12">
													<label class = "etiqueta">&iquest;A que edad empez&oacute; a balbucear? (meses)</label> <br>
													<input class="form-control text-libre" type="text" id = "balbuceo" name = "balbuceo" value="<?php echo $balbuceo; ?>" onkeyup="enteros(this);" maxlength = "2" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-10 col-lg-offset-1 col-xs-12">
													<label class = "etiqueta">&iquest;A que edad empez&oacute; a decir sus primeras palabras? (meses)</label> <br>
													<input class="form-control text-libre" type="text" id = "palabras" name = "palabras" value="<?php echo $palabras; ?>" onkeyup="enteros(this);" maxlength = "2" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-10 col-lg-offset-1 col-xs-12">
													<label class = "etiqueta">&iquest;A que edad empez&oacute; a decir sus primeras oraciones? (meses)</label> <br>
													<input class="form-control text-libre" type="text" id = "oraciones" name = "oraciones" value="<?php echo $oraciones; ?>" onkeyup="enteros(this);" maxlength = "2" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-10 col-lg-offset-1 col-xs-12">
													<label class = "etiqueta">&iquest;El ni&ntilde;o articula bien todas las palabras?</label> <span class = "text-danger">*</span><br>
													&nbsp; <label><input type="radio" id = "articulasi" name = "articula" /><label for="articulasi" id = "larticulasi" > Si</label></label>
													&nbsp; <label><input type="radio" id = "articulano" name = "articula" /><label for="articulano" id = "larticulano" > No</label></label>
													<script>
														var sino = parseInt('<?php echo $articula; ?>');
														if(sino == 1){
															document.getElementById("articulasi").checked = true;
														}else{
															document.getElementById("articulano").checked = true;
														}
														
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-10 col-lg-offset-1 col-xs-12">
													<label class = "etiqueta">&iquest;Comprende lo que se le dice?</label> <span class = "text-danger">*</span><br>
													&nbsp; <label><input type="radio" id = "entiendesi" name = "entiende" /><label for="entiendesi" id = "lentiendesi" > Si</label></label>
													&nbsp; <label><input type="radio" id = "entiendeno" name = "entiende" /><label for="entiendeno" id = "lentiendeno" > No</label></label>
													<script>
														var sino = parseInt('<?php echo $entiende; ?>');
														if(sino == 1){
															document.getElementById("entiendesi").checked = true;
														}else{
															document.getElementById("entiendeno").checked = true;
														}
													</script>
												</div>
											</div>
											<hr>
											<div class = "row">
												<div class="col-md-12 text-center">
													<a  href="FRMpaso5.php?hashkey=<?php echo $hashkey; ?>" class="btn-glow default" ><i class="fa fa-arrow-left"></i> Atras (Paso Anterior)</a> 
													<button class="btn-glow primary" onclick = "Paso6();" ><i class="fa fa-save"></i> Guardar y Siguiente <i class="fa fa-arrow-right"></i></button>
												</div>
											</div>
										</div>	
									</div>
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
    <script type="text/javascript" src="../assets.3.5.20/js/modules/hijos/ficha.js"></script>
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