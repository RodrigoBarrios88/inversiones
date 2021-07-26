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
			//--NIVEL Y GRADO
			if(strlen($cui)>0){
				$result = $ClsIns->get_grado_alumno('','',$cui);
				if(is_array($result)){
                    foreach($result as $row){
                        //$cliente = $row["cli_id"];
                        $_REQUEST["nivel$i"] = trim($row["graa_nivel"]);
                        $_REQUEST["grado$i"] = trim($row["graa_grado"]);
                    }
				}
			}		
			//--
			$_REQUEST["nit$i"] = trim($row["alu_nit"]);
			$_REQUEST["clinombre$i"]= utf8_decode($row["alu_cliente_nombre"]);
			$_REQUEST["clidireccion$i"] = utf8_decode($row["alu_cliente_direccion"]);
			
			//////SEGURO (TABLAS DE INSCRICIONES)
			$result = $ClsIns->get_seguro($cui);
			if(is_array($result)){
				foreach($result as $row){
                    $_REQUEST["seguro$i"] = trim($row["seg_tiene_seguro"]);
                    $_REQUEST["poliza$i"] = utf8_decode($row["seg_poliza"]);
                    $_REQUEST["aseguradora$i"] = utf8_decode($row["seg_aseguradora"]);
                    $_REQUEST["plan$i"] = utf8_decode($row["seg_plan"]);
                    $_REQUEST["asegurado$i"] = utf8_decode($row["seg_asegurado_principal"]);
                    $_REQUEST["instrucciones$i"] = utf8_decode($row["seg_instrucciones"]);
                    $_REQUEST["comentarios$i"] = utf8_decode($row["seg_comentarios"]);
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
                                <li class="active">
                                    <span class="step">3</span>
                                    <span class="title">Datos Administrativos</span>
                                </li>
                                <li>
                                    <span class="step">4</span>
                                    <span class="title">Datos de Seguro</span>
                                </li>
                                <li>
                                    <span class="step">5</span>
                                    <span class="title">Datos del Contrato</span>
                                </li>
                            </ul>                              
                        </div>
						<br>
                        <div class="step-content">
						<form name = "f1" name = "f1" method="get" enctype="multipart/form-data">
							<div class="step-pane active" id="step3">
                                <div class="">
								<input type = "hidden" name = "alumnos" id = "alumnos" value = "<?php echo $alumnos; ?>" />
								<input type = "hidden" name = "dpi" id = "dpi" value = "<?php echo $dpi; ?>" />
                                <?php for($i = 1; $i <= $alumnos; $i++){ ?>	
									<div class="panel panel-default">
										<div class="panel-heading"> 
											<h5><span class="fa fa-paste" aria-hidden="true"></span> Informaci&oacute;n de Datos Administrativos</h5>
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
												<div class="col-lg-4 col-md-offset-1"><label>Nivel:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<?php echo inscripcion_nivel_html("nivel$i","xajax_Nivel_Grado(this.value,'grado','divgrado',$i);"); ?>
													<script>
														document.getElementById("nivel<?php echo $i; ?>").value = '<?php echo $_REQUEST["nivel$i"]; ?>';
													</script>
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Grado:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6" id = "divgrado<?php echo $i; ?>">
													<?php
														if($_REQUEST["nivel$i"] != ""){
															echo inscripcion_grado_html($_REQUEST["nivel$i"],"grado$i","");
														}else{
															echo combos_vacios("grado$i");
														}
													?>
													<script>
														document.getElementById("grado<?php echo $i; ?>").value = '<?php echo $_REQUEST["grado$i"]; ?>';
													</script>
												</div>
											</div>
											<hr>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Nit a Facturar:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input type = "text" class = "form-control" name = "nit<?php echo $i; ?>" id = "nit<?php echo $i; ?>"  value = "<?php echo $_REQUEST["nit$i"]; ?>" onkeyup = "texto(this);" onblur = "Cliente(<?php echo $i; ?>);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Nombre a Facturar:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input type="text" class="form-control" name = "clinombre<?php echo $i; ?>" id = "clinombre<?php echo $i; ?>" value = "<?php echo $_REQUEST["clinombre$i"]; ?>"  onkeyup = "texto(this);" />
												</div>
											</div>
											<div class = "row">
												<div class="col-lg-4 col-md-offset-1"><label>Direcci&oacute;n de Facturaci&oacute;n:</label> <span class = "text-danger">*</span></div>
												<div class="col-lg-6">
													<input type="text" class="form-control" name = "clidireccion<?php echo $i; ?>" id = "clidireccion<?php echo $i; ?>" value = "<?php echo $_REQUEST["clidireccion$i"]; ?>"  onkeyup = "texto(this);" />
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
                            <a href="FRMpaso1B.php" class="btn-glow primary btn-prev"> 
                                <i class="fa fa-chevron-left"></i> Antes
                            </a>
                            <button type="button" class="btn-glow primary" onclick="ActualizaDatos();">
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
	
	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>