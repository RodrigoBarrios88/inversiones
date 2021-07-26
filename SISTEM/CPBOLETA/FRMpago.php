<?php
	include_once('xajax_funct_boleta.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$pensum_vigente = $_SESSION["pensum"];
	//$_POST
	$ClsPer = new ClsPeriodoFiscal();
	$ClsDiv = new ClsDivision();
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_vigente:$pensum;
	$cuenta = $_REQUEST["cuenta"];
	
	if($_REQUEST["periodo"] == ""){
		$periodo = $ClsPer->get_periodo_pensum($pensum);
	}else{
		$periodo = $_REQUEST["periodo"];
	}
	$grupo = $_REQUEST["grupo"];
	$grupo = ($grupo != "")?$grupo:"1";
	$division = $_REQUEST["division"];
	//--
	$hashkey = $_REQUEST["hashkey"];
	$ClsAsig = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	$ban = $_REQUEST["ban"];
	$ban = ($ban != "")?$ban:"1";
	
	$result = $ClsAlu->get_alumno($cui,'','',1);
	if(is_array($result)){
		foreach($result as $row){
			$nom = utf8_decode($row["alu_nombre"]);
			$ape = utf8_decode($row["alu_apellido"]);
		}
		$alumno = "$nom $ape";
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
			$solvencia.= '<br><hr><small>Datos calculados referentes al a&ntilde;o</small>';
			$solvencia.= '</h6>';
		}
	}
	
if($usuario != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="shift_jis">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	 ?>	
	<!-- CSS personalizado -->
	<link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Estilos Utilitarios -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
	<link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo $_SESSION["rotulos_colegio"]; ?>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Perfil de Usuario</a></li>
                        <li class="divider"></li>
                        <li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-question-sign fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Ayuda</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
                                <li>
									<a href="../CPBOLETAPROGRAMADOR/FRMnewconfiguracion.php">
										<i class="fa fa-check"></i> Configuraciones de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="../CPBOLETAPROGRAMADOR/FRMsecciones.php">
										<i class="fa fa-calendar"></i> Programador de Boletas
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=GBOL">
										<i class="fa fa-edit"></i> Gestor de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a class="active" href="FRMsecciones.php?acc=GPAGO">
										<i class="fa fa-edit"></i> Gestor de Pagos Individuales
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMcarga.php">
										<i class="fa fa-table"></i> Carga Electr&oacute;nica .CSV
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMhistorial_cargas.php">
										<i class="fa fa-table"></i> Historial de Cargas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="FRMhistorial_csv.php">
										<i class="fa fa-file-excel-o"></i> Historial de .CSV
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["CARGAELECTRO"] == 1){ ?>
								<li>
									<a href="../CPBOLETAFACTURAS/FRMlist_cargas.php">
										<i class="fa fa-file-text-o"></i> Facturas y Recibos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GESMOR"] == 1){ ?>
									<li>
										<a href="FRMmoras.php">
											<i class="fa fa-edit"></i> Gestor de Moras
										</a>
									</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=CUE">
										<i class="fa fa-money"></i> Estado de Cuenta
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUcuenta.php">
										<i class="fa fa-indent"></i> Men&uacute;
									</a>
								</li>
								<li>
									<a href="../menu.php">
										<i class="glyphicon glyphicon-list"></i> Men&uacute; Principal
									</a>
								</li>
                            </ul>
							<!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			<br>
            <div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-edit"></i> Gestor de Pagos Individuales
				</div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' method='get'>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Periodo Fiscal:</label>
							<?php echo periodo_fiscal_html("periodo","Submit();"); ?>
							<script type="text/javascript">
								document.getElementById("periodo").value = "<?php echo $periodo; ?>";
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Grupo:</label>
							<?php echo division_grupo_html("grupo","Submit();"); ?>
							<input type = "hidden" name = "codigo" id = "codigo" />
							<script type="text/javascript">
								document.getElementById("grupo").value = "<?php echo $grupo; ?>";
							</script>
						</div>	
						<div class="col-xs-5" id = "sdiv">
							<label>Divisi&oacute;n:</label>
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
					<hr>	
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="row">
								<div class="col-xs-12">
									<label>Alumno:</label>
									<label class="form-info"><?php echo trim($alumno); ?></label>
									<input type="hidden" id="hashkey" name="hashkey" value="<?php echo $hashkey; ?>" />
									<input type="hidden" id="cui" name="cui" value="<?php echo $cui; ?>" />
									<input type="hidden" id="codint" name="codint" value="<?php echo $codint; ?>" />
									<input type="hidden" id="codboleta" name="codboleta" />
									<input type="hidden" id="pagada" name="pagada" />
									<input type="hidden" id="cod" name="cod" />
									<input type="hidden" name = "acc" id = "acc" value="<?php echo $acc; ?>" />
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<label>Grado y Secci&oacute;n:</label>
									<label class="form-info"><?php echo utf8_decode($grado); ?> Secc&oacute;n "<?php echo utf8_decode($seccion); ?>"</label>
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<br>
							<?php echo $solvencia; ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Banco:</label>
							<?php echo banco_html("ban","xajax_Combo_Cuenta_Banco(this.value,'cue','scue','');"); ?>
							<input type = "hidden" name = "cod" id = "cod" />
							<script type="text/javascript">
								document.getElementById("ban").value = "1";
							</script>
						</div>	
						<div class="col-xs-5" id = "scue">
							<label>Cuenta de Banco:</label>
							<?php
								if($ban != ""){
									echo cuenta_banco_html($ban,"cue","");
								}else{
									echo combos_vacios("cue");
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>No. Referencia:</label></div>
						<div class="col-xs-5"><label>Fecha:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type="text" class="form-control" id="referencia" name="referencia" onkeyup="enteros(this);" />
						</div>
						<div class="col-xs-3">
							<div class='input-group date' id='fec'>
								<input type='text' class="form-control" id = "fecha" name='fecha' value="<?php echo date("d/m/Y"); ?>" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<div class="input-group clockpicker" data-autoclose="true">
									<input type="text" class="form-control" name = "hora" id = "hora" value = "<?php echo date("H:i"); ?>" >
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Efectivo:</label></div>
						<div class="col-xs-5"><label>Cheques Propios (mismo banco):</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type="text" class="form-control" id="efectivo" name="efectivo" onkeyup="decimales(this);" />
						</div>
						<div class="col-xs-5">
							<input type="text" class="form-control" id="chp" name="chp" onkeyup="decimales(this);" value = "0" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Cheques de Otros Bancos:</label></div>
						<div class="col-xs-5"><label>Pagos con POS (Tarjeta) o en L&iacute;nea:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<input type="text" class="form-control" id="otb" name="otb" onkeyup="decimales(this);" value = "0" />
						</div>
						<div class="col-xs-5">
							<input type="text" class="form-control" id="online" name="online" onkeyup="decimales(this);" value = "0" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1" id = "labelalerta"></div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "grab" onclick = "GrabarPagosIndividual();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
							<button type="button" class="btn btn-primary hidden" id = "mod" onclick = "ModificarPagosIndividual();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
					</form>
				</div>
            </div>
			<!-- boletas -->
			<div class="row">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 text-center">
                    	<a class="btn btn-outline btn-default" title="Imprimir" href = "../../CONFIG/BOLETAS/REPcuenta.php?hashkey=<?php echo $hashkey; ?>&periodo=<?php echo $periodo; ?>&division=<?php echo $division; ?>&grupo=<?php echo $grupo; ?>" target="_blank"><span class="fa fa-print"></span> Estado de Cuenta Condensado</a> 
						<a class="btn btn-outline btn-default" title="Imprimir" href = "../../CONFIG/BOLETAS/REPcuenta_detallado.php?hashkey=<?php echo $hashkey; ?>&periodo=<?php echo $periodo; ?>&division=<?php echo $division; ?>&grupo=<?php echo $grupo; ?>" target="_blank"><span class="fa fa-print"></span> Estado de Cuenta Detallado</a>
						<a class="btn btn-outline btn-primary" title="Imprimir" href = "../CPBOLETAFACTURAS/FRMalumno.php?hashkey=<?php echo $hashkey; ?>&periodo=<?php echo $periodo; ?>&division=<?php echo $division; ?>&grupo=<?php echo $grupo; ?>"><i class="fa fa-plus"></i> <i class="fa fa-file-text-o"></i> Generar Recibo o Factura</a> 
                    </div>
                </div>
            </div>
			<hr>
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
										<?php echo tabla_estado_pagos($cui,$periodo,$divcodigo,$divgrupo); ?>
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
					<h6 class="alert alert-info text-center">
						<?php echo $titulo_programado; ?> <strong><?php echo $valor_programado; ?></strong>
					</h6>
				</div>
				<div class="col-lg-6">
					<h6 class="alert alert-info text-center">
						<?php echo $titulo_pagado; ?> <strong><?php echo $valor_pagado; ?></strong>
					</h6>
				</div>
			</div>
			<br>
			<!-- /boletas -->
	    <br>
	</div>
	<!-- /#page-wrapper -->
	
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src = "../../CONFIG/images/img-loader.gif" width="100px" /><br>
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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    
	<!-- Clock picker -->
    <script src="../assets.3.6.2/js/plugins/clockpicker/clockpicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/pago.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		
		$(function () {
            $('#fecha').datetimepicker({
                format: 'DD/MM/YYYY'
            });
			
			$('.clockpicker').clockpicker();
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