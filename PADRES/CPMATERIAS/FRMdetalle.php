<?php
	include_once('html_fns_materias.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
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
	$ClsPer = new ClsPeriodoFiscal();
	$cui = $_REQUEST['cui'];
	$pensum = $_REQUEST['pensum'];
	$nivel = $_REQUEST['nivel'];
	$grado = $_REQUEST['grado'];
	$seccion = $_REQUEST['seccion'];
	$materia = $_REQUEST['materia'];
	
	
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $materia != ""){
		$ClsAcad = new ClsAcademico();
		$ClsPen = new ClsPensum();
		$result = $ClsPen->get_materia($pensum,$nivel,$grado,$materia,'',1);
		if(is_array($result)){
			foreach ($result as $row){
				$materia_codigo = $row["mat_codigo"];
				$materia_descripcion = utf8_decode($row["mat_descripcion"]);
			}
		}else{
			
		}
		
		$result = $ClsAcad->get_seccion_maestro($pensum,$nivel,$grado,$seccion,'','','',1);
		if(is_array($result)) {
			$maestro_nombre = "";
			foreach ($result as $row){
				$maestro = $row["mae_cui"];
				$result_materia = $ClsAcad->get_materia_maestro($pensum,$nivel,$grado,$materia,$maestro,'','',1);
				$i = 0;	
				if(is_array($result_materia)) {
					foreach ($result_materia as $row_materia){
						$maestro_nombre = "- ".utf8_decode($row_materia["mae_nombre"])." ".utf8_decode($row_materia["mae_apellido"])."<br>";
						$i++;
					}
				}	
			}
		}else{
			
		}	
	}else{
		
	}
	
	////// AÑO DE CARGOS A LISTAR /////////
	$periodo = $ClsPer->get_periodo_activo();
	$anio_periodo = $ClsPer->get_anio_periodo($periodo);
	$anio_actual = date("Y");
	$anio_periodo = ($anio_periodo == "")?$anio_actual:$anio_periodo;
	//// fechas ///
	if($anio_actual == $anio_periodo){
		$mes = date("m"); ///mes de este año para calculo de saldos y moras
		$fini = "00/01/$anio_actual";
		$ffin = "31/$mes/$anio_actual";
		$titulo_programado = "Programado a la fecha:";
		$titulo_pagado = "Pagado a la fecha:";
	}else{
		$fini = "00/01/$anio_periodo";
		$ffin = "31/12/$anio_periodo";
		$titulo_programado = "Programado para el a&ntilde;o $anio_periodo:";
		$titulo_pagado = "Pagado del el a&ntilde;o $anio_periodo:";
	}
	
	/////// PROGRAMADO ////////
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
	$solvente = true;
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
		$solvente = true;
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
				$solvente = false;
			}else{
				$fecha_programdo = cambia_fecha($fecha_programdo);
				$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
				$solvencia = '<h6 class="alert alert-warning text-center">';
				$solvencia.= 'SALDO PARA ESTE MES: <strong>'.$diferencia.'</strong>';
				$solvencia.= '<br><hr><small>EL PROXIMO PAGO EXPIRA EL '.$fecha_programdo.'</small>';
				$solvencia.= '</h6>';
				$solvente = false;
			}
		}else{
			$diferencia = $mons ." ".number_format($diferencia, 2, '.', '');
			$solvencia = '<h6 class="alert alert-danger text-center">';
			$solvencia.= 'MONTO PARA EL A&Ntilde;O '.$anio_periodo.': <strong>'.$diferencia.'</strong>';
			$solvencia.= '<br><hr><small>Datos calculados referentes al a&ntilde;o '.$anio_periodo.'</small>';
			$solvencia.= '</h6>';
			$solvente = true;
		}
	}
	////PARA BLOQUEAR NOTAS ///
		$ClsPen = new ClsPensum();
		$resultado = $ClsPen->get_nivel_alumno($cui,'',$pensum);
		if(is_array($resultado)){
            foreach($resultado as $row){
		        $nivel=$row["graa_nivel"];
		        echo($nivel);
            }
		}
        $result = $ClsPen->get_nivel_bloqueo($pensum,'',$nivel);
       // echo($result);
        if(is_array($result)){
            foreach($result as $row){
		        $status =$row["notv_status"];
            }
		        if($status !== "1"){
		            $solvente = false;
	                $solvencia = '<br><h5 class="alert alert-info text-center"><i class="fa fa-info-circle"></i> Pendientes de P&uacute;blicar...</h5>';
		        
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
?>
<!DOCTYPE html>
<html lang="en">

<head><meta charset="shift_jis">

    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    
	<!-- Bootstrap Core CSS -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
    
    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    

</head>

<body>

	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="FRMhijos.php"><i class="fa fa-flask"></i> Materias</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<br><br>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

           <div class="col-md-3">
                <p class="lead"><i class="fa fa-paste"></i> Materias</p>
                <div class="list-group">
					<a href="#" class="list-group-item active"><i class="fa fa-flask"></i> Detalle de Materias</a>
                </div>
            </div>

            <div class="col-md-9">
				<div class="well">
				    <div class="row">
				        <div class="col-md-6">
				            <h4 class="alert alert-info"><?php echo $materia_descripcion; ?></h4>
    						<label>Maestro:</label>
                            <p><?php echo $maestro_nombre; ?></p>
                    	</div>
                    	<div class="col-md-6 text-center">
                            <img class="img-responsive" src="../../CONFIG/images/logo_largo.png" alt="" width="100%">
                    	</div>
					</div>
                    <hr>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-paste"></i> Notas</div>
								<div class="panel-body">
									<?php
										if($solvente == true){
											echo lista_notas($cui,$pensum,$nivel,$grado,$seccion,$materia);
										}else{
											echo $solvencia;
										}
									?>
								</div>	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-clock-o"></i> Horarios</div>
								<div class="panel-body">
									<?php echo lista_horarios($pensum,$nivel,$grado,$seccion,$materia); ?>
								</div>	
							</div>
						</div>
					</div>
                </div>
				<div class="text-info">
					<p class="pull-right"> ASMS team</p>
				</div>
				<br>
            </div>
        </div>

    </div>
	<!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; ID <?php echo date("Y"); ?></p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- scripts -->
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>

</body>

</html>