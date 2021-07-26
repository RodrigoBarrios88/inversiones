<?php
	include_once('xajax_funct_boleta.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	$ClsAsig = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	
	
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
		
	//// fechas ///
	$mes = date("m");
	$anio = date("Y");
	$fini = "01/01/$anio";
	$ffin = "31/$mes/$anio";
	//echo "$fini - $ffin";
	
	/////// PROGRAMADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_boleta_cobro('','','',$cui,'',$anio,'',$fini,$ffin,1,2);
	$monto_programdo = 0;
	if(is_array($result)){
		foreach($result as $row){
			$mons = $row["mon_simbolo"];
			$monto_programdo+= $row["bol_monto"];
			$fecha_programdo = $row["bol_fecha_pago"];
		}
	}
	//echo $monto_programdo;
	$valor_programado = $mons ." ".number_format($monto_programdo, 2);
	
	/////// PAGADO ////////
	$ClsBol = new ClsBoletaCobro();
	$result = $ClsBol->get_pago_boleta_cobro('','','',$cui,'','','','','',$fini,$ffin);
	$monto_pagado = 0;
	if(is_array($result)){
		foreach($result as $row){
			$mons = $row["mon_simbolo"];
			$monto_pagado+= $row["pag_efectivo"]+$row["pag_cheques_propios"]+$row["pag_otros_bancos"]+$row["pag_online"];
			$fecha_pago = $row["pag_fechor"];
		}
	}
	//echo $monto_pagado;
	$valor_pagado = $mons ." ".number_format($monto_pagado, 2);
	
	////////// CALUCULO DE SOLVENCIA ///////////
	$diferencia = $monto_programdo - $monto_pagado;
	if($diferencia <= 0){
		$diferencia = ($diferencia * -1);
		$fecha_pago = cambia_fechaHora($fecha_pago);
		$diferencia = $mons ." ".number_format($diferencia, 2);
		$solvencia = '<h6 class="alert alert-success text-center">';
		$solvencia.= 'SOLVENTE. SALDO A FAVOR: <strong>'.$diferencia.'</strong>';
		$solvencia.= '<br><hr><small>EL &Uacute;LTIMO PAGO SE REALIZ&Oacute; EL '.$fecha_pago.'</small>';
		$solvencia.= '</h6>';
	}else{
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
			$diferencia = $mons ." ".number_format($diferencia, 2);
			$solvencia = '<h6 class="alert alert-warning text-center">';
			$solvencia.= 'SALDO PARA ESTE MES: <strong>'.$diferencia.'</strong>';
			$solvencia.= '<br><hr><small>EL PROXIMO PAGO EXPIRA EL '.$fecha_programdo.'</small>';
			$solvencia.= '</h6>';
		}
	}
	
if($usuario != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

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
	
	
	<!-- Calendarios -->
    <link href="../assets.3.6.2/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css">
	<script src="../assets.3.6.2/js/dhtmlgoodies_calendar.js" type="text/javascript"></script>

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
										<i class="fa fa-check"></i> Crear Configuraci&oacute;n
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMeditconfiguracion.php">
										<i class="fa fa-edit"></i> Actualizar Configuraci&oacute;n
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMprogramar.php?cui=<?php echo $cui; ?>">
										<i class="fa fa-calendar"></i> Programador de Boletas
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["NEWCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=GBOL">
										<i class="fa fa-edit"></i> Gestor de Boletas
									</a>
								</li>
								<?php } ?>
								<hr>
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
								<?php if($_SESSION["PAGOCUOTAS"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=GPAGO">
										<i class="fa fa-edit"></i> Gestor de Pagos Individuales
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
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
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="FRMsecciones.php?acc=SALDO">
										<i class="fa fa-money"></i> Listar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["VIEWSALDOCUOTA"] == 1){ ?>
								<li>
									<a href="FRMsaldo.php?hashkey=<?php echo $hashkey; ?>">
										<i class="fa fa-money"></i> Saldo
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
				<div class="panel-heading"><label>Saldos a Pagar</label></div>
                <div class="panel-body" id = "formulario">
					<form id='f1' name='f1' action='FRMprogramar.php' method='get'>
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right"><span class = " text-info">* Campos de Busqueda</span> </div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<div class="row">
								<div class="col-xs-12"><label>Alumno:</label></div>
								<div class="col-xs-12">
									<label class="form-info"><?php echo $alumno; ?></label>
									<input type="hidden" id="cui" name="cui" value="<?php echo $cui; ?>" />
									<input type="hidden" id="cod" name="cod" />
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12"><label>Grado y Secci&oacute;n:</label></div>
								<div class="col-xs-12">
									<label class="form-info"><?php echo $grado; ?> SECCI&Oacute;N "<?php echo $seccion; ?>"</label>
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<?php echo $solvencia; ?>
						</div>
					</div>
					</form>
				</div>
            </div>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<h6 class="alert alert-info text-center">
								Pagos programados en el a&ntilde;o hasta el mes actual
							</h6>
							<h6 class="text-center">Programado: <?php echo $valor_programado; ?></h6>
						</div>
						<div class="col-lg-6">
							<h6 class="alert alert-success text-center">
								Pagos realizados en el a&ntilde;o hasta el mes actual
							</h6>
							<h6 class="text-center">Pagado: <?php echo $valor_pagado; ?></h6>
						</div>
					</div>
				</div>
			</div>
	    <!-- /.panel-default -->
	    
	    <br>
	</div>
	<!-- /#page-wrapper -->
	
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
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
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/colegiatura/boleta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-1').DataTable({
				responsive: true
			});
			$('#dataTables-2').DataTable({
				responsive: true
			});
	    });
		
		$(function () {
            $('#fechor').datetimepicker({
                format: 'DD/MM/YYYY HH:mm'
            });
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