<?php
	include_once('html_fns_pagos.php');
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
	$ClsBol = new ClsBoletaCobro();
	$ClsPer = new ClsPeriodoFiscal();
	$ClsDiv = new ClsDivision();
	$usuario = $_SESSION["codigo"];
	$hashkey = $_REQUEST["hashkey"];
	$ClsAsig = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	$periodo = $ClsPer->periodo;
	$periodo = ($_REQUEST["periodo"] == "")?$ClsPer->periodo:$_REQUEST["periodo"];
	$grupo = $_REQUEST["grupo"];
	$grupo = ($grupo != "")?$grupo:"1";
	$division = $_REQUEST["division"];
	
	
	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
			//--
			$foto = trim($row["alu_foto"]);
		}
		$nombres = ucwords(strtolower($nom." ".$ape));
	}
	
	if(file_exists ('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){ /// valida que tenga foto registrada
		$foto = 'ALUMNOS/'.$foto.'.jpg';
	}else{
		$foto = 'nofoto.png';
	}
	
	$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = trim($row["niv_descripcion"]);
			$grado = trim($row["gra_descripcion"]);
		}
	}
	
	$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$seccion = trim($row["sec_descripcion"]);
		}
	}
		
	////// AÑO DE CARGOS A LISTAR /////////
	$anio_periodo = $ClsPer->get_anio_periodo($periodo);
	$anio_actual = date("Y");
	$anio_periodo = ($anio_periodo == "")?$anio_actual:$anio_periodo;
	//// fechas ///
	if($anio_actual == $anio_periodo){
		$mes = date("m"); ///mes de este año para calculo de saldos y moras
		$fini = "01/01/$anio_actual";
		$ffin = "31/$mes/$anio_actual";
		$titulo_programado = "Programado a la fecha:";
		$titulo_pagado = "Pagado a la fecha:";
	}else{
		$fini = "01/01/$anio_periodo";
		$ffin = "31/12/$anio_periodo";
		$titulo_programado = "Programado para el a&ntilde;o $anio_periodo:";
		$titulo_pagado = "Pagado del el a&ntilde;o $anio_periodo:";
	}
	
	////// PROGRAMADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_vs_pago('','','',$cui,'',$periodo,'',$fini,$ffin,1,2);
	$monto_programdo = 0;
	$monto_pagado = 0;
	$referenciaX;
	if(is_array($result)){
		foreach($result as $row){
			$bolcodigo = $row["bol_codigo"];
			$mons = $row["bol_simbolo_moneda"];
			if($bolcodigo != $referenciaX){
				$monto_programdo+= $row["bol_monto"];
				$fecha_programdo = $row["bol_fecha_pago"];
				$fecha_pago = $row["pag_fechor"];
				$referenciaX = $bolcodigo;
			}
			$monto_pagado+= $row["pag_total"]; /// monto registrado en la boleta, ya con descuento
		}
	}
	//echo $monto_programdo;
	$valor_programado = $mons .". ".number_format($monto_programdo, 2, '.', ',');
	
	/////// PAGADO ////////
	$ClsBol = new ClsBoletaCobro();
	//$result = $ClsBol->get_pago_boleta_cobro('','','',$cui,'','','','','',$fini,$ffin);
	$result = $ClsBol->get_pago_aislado('','','', $cui,'',$periodo,'','0','',$fini,$ffin,'');
	if(is_array($result)){
		foreach($result as $row){
			$mons = $row["mon_simbolo"];
			$monto_pagado+= $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
		}
	}
	//echo $monto_pagado;
	$valor_pagado = $mons .". ".number_format($monto_pagado, 2, '.', ',');
	
	////////// CALUCULO DE SOLVENCIA ///////////
	$diferencia = $monto_programdo - $monto_pagado;
	$diferencia = round($diferencia, 2);
	if($diferencia <= 0){
		$diferencia = ($diferencia * -1);
		$fecha_pago = cambia_fechaHora($fecha_pago);
		$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
		$solvencia = '<h6 class="alert alert-success text-center">';
		$solvencia.= 'SOLVENTE. SALDO A FAVOR: <strong>'.$diferencia.'</strong>';
		$solvencia.= '<br><hr><small>EL &Uacute;LTIMO PAGO SE REALIZ&Oacute; EL '.$fecha_pago.'</small>';
		$solvencia.= '</h6>';
	}else{
		if($anio_actual == $anio_periodo){
			$hoy = date("Y-m-d");
			//echo "$fecha_programdo < $hoy";
			if($fecha_programdo < $hoy){
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2);
				$solvencia = '<h6 class="alert alert-danger text-center">';
				$solvencia.= 'FECHA DE PAGO EXPIRADA!. SALDO PENDIENTE: <strong>'.$diferencia.'</strong>';
				$solvencia.= '<br><hr><small>EL PAGO EXPIR&Oacute; EL '.$fecha_programdo.'</small>';
				$solvencia.= '</h6>';
			}else{
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
				$solvencia = '<h6 class="alert alert-warning text-center">';
				$solvencia.= 'SALDO PARA ESTE MES: <strong>'.$diferencia.'</strong>';
				$solvencia.= '<br><hr><small>EL PROXIMO PAGO EXPIRA EL '.$fecha_programdo.'</small>';
				$solvencia.= '</h6>';
			}
		}else{
			$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
			$solvencia = '<h6 class="alert alert-info text-center">';
			$solvencia.= 'MONTO PARA EL A&Ntilde;O '.$anio_periodo.': <strong>'.$diferencia.'</strong>';
			$solvencia.= '<br><hr><small>Datos calculados referentes al a&ntilde;o '.$anio_periodo.'</small>';
			$solvencia.= '</h6>';
		}
	}
		
	$ClsBol = new ClsBoletaCobro();
	$ClsPen = new ClsPensum();
	$pensum = $_SESSION["pensum"];
	$arr_hijos = $_SESSION["hijos"];
	$anio_pensum = $ClsPen->get_anio_pensum($pensum);
	$arr_hijos = ($arr_hijos == "")?"1111":$arr_hijos;
	$count_mora = $ClsBol->count_mora('','','',$arr_hijos,'','','','', $anio_pensum, '', '', '', 1, '',0);
	
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
	<!-- bootstrap -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../assets.3.5.20/css/util.css" rel="stylesheet">
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   
	<!-- Data Table plugin CSS -->
	<link href="../assets.3.5.20/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
     
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
   
	<!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/index.css" type="text/css" media="screen" />
	
	<!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<style>
		.btn-xs {
			padding: 5px 10px;
		}
	</style>
	
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
			<?php if($count_mora > 0){ ?>
			<li class="notification-dropdown hidden-phone">
                <a href="#" class="trigger active">
                    <i class="fas fa-money-bill-alt"></i>
                    <span class="count" style="background: #FF8000;">i</span>
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
						$anio_pensum = $ClsPen->get_anio_pensum($pensum);
						$arr_hijos = ($arr_hijos == "")?"1111":$arr_hijos;
						$result = $ClsBol->get_mora('','','',$arr_hijos,'','','','', $anio_pensum, '', '', '', 1, '',0);
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
                            <a href="../../CONFIG/BOLETAS/REPboleta.php?hashkey1=<?php echo $hashkey1; ?>&hashkey2=<?php echo $hashkey2; ?>&hashkey3=<?php echo $hashkey3; ?>" target = "_blank" class="item active">
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
			<li class="active">
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
			<div class="col-lg-10 col-md-offset-1">
				<br>
				<div class="panel panel-default">
					<div class="panel-heading"> 
						<h5><span class="fa fa-money" aria-hidden="true"></span> Estado de Cuenta de <?php echo $nombres; ?></label></h5>
					</div>
					<div class="panel-body">
						<div class = "row">
							<div class="col-md-4 col-md-offset-4 text-center">
								<a href="javascript:void(0);" class="thumbnail">
									<img src="../../CONFIG/Fotos/<?php echo $foto; ?>" alt="foto" width="150px" />
								</a>
							</div>
						</div>
						<hr>
						<form id='f1' name='f1' method='get'>
						<div class="row">
							<div class="col-md-6 col-md-offset-3 text-center">
								<label>Cargos para el a&ntilde;o:</label>
								<select class="form-control text-center" id="periodo" name="periodo" onchange="Submit();">
									<option value="3">2019</option>
									<option value="4">2020</option>
									<option value="5">2021</option>
								</select>
								<script type="text/javascript">
									document.getElementById("periodo").value = "<?php echo $periodo; ?>";
								</script>
								<input type="hidden" value="<?php echo $anio; ?>" >
								<input type="hidden" id="hashkey" name="hashkey" value="<?php echo $hashkey; ?>" />
								<input type="hidden" id="cui" name="cui" value="<?php echo $cui; ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-md-offset-3 text-center">
								<label>Grupo de Rubros:</label>
								<?php echo division_grupo_html("grupo","Submit();"); ?>
								<input type = "hidden" name = "codigo" id = "codigo" />
								<script type="text/javascript">
									document.getElementById("grupo").value = "<?php echo $grupo; ?>";
								</script>
							</div>
							<div class="col-md-3 text-center">
								<label>Rubro o Divisi&oacute;n:</label>
								<?php
									if($grupo != ""){
										echo division_html($grupo,"division","Submit();");
									}else{
										echo combos_vacios("division");
									}
								?>
							</div>
							<script type="text/javascript">
								document.getElementById("division").value = "<?php echo $division; ?>";
							</script>
						</div>
						</form>
						<br>
						<div class = "row">
							<div class="col-md-6 col-md-offset-3 text-center">
								<br>
								<?php echo $solvencia; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="row">
				<div class="col-xs-12 text-center">
					<a class="btn btn-outline btn-default" title="Imprimir" href = "../../CONFIG/BOLETAS/REPcuenta.php?hashkey=<?php echo $hashkey; ?>&periodo=<?php echo $periodo; ?>&division=<?php echo $division; ?>&grupo=<?php echo $grupo; ?>" target="_blank"><span class="fa fa-print"></span> Estado de Cuenta Condensado</a> 
					<a class="btn btn-outline btn-default" title="Imprimir" href = "../../CONFIG/BOLETAS/REPcuenta_detallado.php?hashkey=<?php echo $hashkey; ?>&periodo=<?php echo $periodo; ?>&division=<?php echo $division; ?>&grupo=<?php echo $grupo; ?>" target="_blank"><span class="fa fa-print"></span> Estado de Cuenta Detallado</a>
				</div>
			</div>
		</div>
		<hr>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="panel-group" id="cuentas">
					<?php
					$result = $ClsDiv->get_division($division,$grupo,'','',1);
					if(is_array($result)){
						$i = 1;
						foreach($result as $row){
							$divcodigo = trim($row["div_codigo"]);
							$divgrupo = trim($row["div_grupo"]);
							$nombre = utf8_decode($row["div_nombre"]);
							$collapse = ($i == 1)?"in":"";
					?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#cuentas" href="#<?php echo $divcodigo; ?>_<?php echo $divgrupo; ?>"><?php echo $nombre; ?></a>
								</h4>
							</div>
							<div id="<?php echo $divcodigo; ?>_<?php echo $divgrupo; ?>" class="panel-collapse collapse <?php echo $collapse; ?>">
								<div class="panel-body">
									  <?php echo tabla_estado_cuenta($cui,$periodo,$divcodigo,$divgrupo); ?>
								</div>
							</div>
						</div>
					<?php
							$i++;
						}
					}
					?>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<h6 class="alert alert-info text-center"><?php echo $titulo_programado." ".$valor_programado; ?></h6>
				</div>
				<div class="col-lg-6">
					<h6 class="alert alert-success text-center"><?php echo $titulo_pagado." ".$valor_pagado; ?></h6>
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
	
	<!-- Data Table plugin javascript -->
	<script src="../assets.3.5.20/js/plugins/dataTables/datatables.min.js"></script>
    
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/pagos/pagos.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	
	<script>
		$('#myTabs a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
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