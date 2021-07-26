<?php
	include_once('xajax_funct_poliza.php');
	$usu = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	$ClsCon = new ClsConta();
	//CODIGO
	$hashkey = $_REQUEST["hashkey"];
	$poliza = $ClsCon->decrypt($hashkey, $usu);
	
	$result = $ClsCon->get_poliza($poliza);
	if(is_array($result)){
		foreach($result as $row){
			$documento = utf8_decode($row["pol_documento"]);
			$sucursal = utf8_decode($row["suc_nombre"]);
			$descripcion = utf8_decode($row["pol_descripcion"]);
			$fecha = trim($row["pol_fecha_contable"]);
			$fecha = cambia_fecha($fecha);
		}	
	}
	//$_POST
	$tipo = $_REQUEST["tipo"];
	$partida = $_REQUEST["par"];
	$clase = $_REQUEST["clase"];
	$reglon = $_REQUEST["reglon"];
	$subreglon = $_REQUEST["subreglon"];
	$monto = $_REQUEST["monto"];
	$moneda = $_REQUEST["moneda"];
	$mov = $_REQUEST["mov"];
	$motivo = $_REQUEST["motivo"];
	//--
	$descreglon = $_REQUEST["descreglon"];
	$descsubreglon = $_REQUEST["descsubreglon"];
	
if($usu != "" && $nombre != ""){ 	
?>
<!DOCTYPE html>
<html lang="es">
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
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet"/>

    <!-- Datepicker Bootstrap v3.0 -->
	<link href="../assets.3.6.2/css/plugins/datapicker/datepicker3.css"rel="stylesheet"/>

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
                       <li class="active">
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
								<?php if($_SESSION["CONTAPAR"] == 1){ ?>
                                <li>
									<a href="FRMnewpoliza.php">
										<i class="fa fa-plus"></i> Nueva Poliza
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONTAPAR"] == 1){ ?>
                                <li>
									<a class="active" href="FRMdetalle.php?hashkey=<?php echo $hashkey; ?>">
										<i class="fa fa-folder-open"></i> Detalle de Poliza
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["CONTAPAR"] == 1){ ?>
                                <li>
									<a href="FRMpolizas.php">
										<i class="fa fa-search"></i> Buscar Polizas
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUcontable.php">
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
					<label><i class="fa fa-folder-open"></i> Detalle de Poliza</label>
				</div>
                <div class="panel-body">
					<form id='f1' name='f1' method='get'>
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
								<label>Poliza # </label> <br>
								<label class = "text-info"><?php echo Agrega_Ceros($poliza); ?></label>
								<input type = "hidden" name = "hashkey" id = "hashkey" value="<?php echo $hashkey; ?>" />
								<input type = "hidden" name = "poliza" id = "poliza" value="<?php echo $poliza; ?>" />
							</div>
							<div class="col-xs-5">
								<label>Documento de Respaldo: </label> <br>
								<label class = "text-info"><?php echo$documento; ?></label>
							</div>
                        </div>
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
								<label>Empresa o Entidad: </label> <br> 
								<label class = "text-info"><?php echo$sucursal; ?></label>
							</div>
							<div class="col-xs-5">
								<label>Fecha Contable: </label> <br>
								<label class = "text-info"><?php echo$fecha; ?></label>
							</div>
                        </div>
						<div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
								<label>Descripci&oacute;n: </label>  <br>
								<p class = "text-info text-justify"><?php echo$descripcion; ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
						</div>
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
								<label>Tipo (1er. Nivel): </label> <span class="text-danger">*</span> 
								<select id = "tipo" name = "tipo" class = "form-control" onchange = "Submit();">
									<option value = "">Seleccione</option>
									<option value = "A" >ACTIVO</option>
									<option value = "P1" >PASIVO</option>
									<option value = "P2" >PATRIMONIO</option>
									<option value = "E" >EGRESOS</option>
									<option value = "I">INGRESOS</option>
								</select>
								<script>
									document.getElementById("tipo").value = '<?php echo $tipo; ?>';
								</script>
							</div>
                            <div class="col-xs-5">
								<label>Partida: </label> <span class="text-danger">*</span> 
								<div id = "spar">
									<?php
										if($tipo != ""){
											echo partida_html($tipo,'','par','Submit()');
										}else{
											echo combos_vacios('par');
										}
									?>
								</div>
								<script>
									document.getElementById("par").value = '<?php echo $partida; ?>';
								</script>
								<input type = "hidden" name = "clase" id = "clase" value="<?php echo $clase; ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Regl&oacute;n: </label> <span class="text-danger">*</span>
								<div class="input-group date">
									<a href="javascript:void(0)" onclick="SubReglones();" title="Seleccionar Reglones" class="input-group-addon"><i class="fa fa-search"></i></a>
									<input type = "text" class = "form-control" name = "descreglon" id = "descreglon" value="<?php echo $descreglon; ?>" readonly />
								</div>
								<input type = "hidden" name = "reglon" id = "reglon" value="<?php echo $reglon; ?>" />
							</div>
							<div class="col-xs-5">
								<label>Sub-Regl&oacute;n: </label> <span class="text-danger">*</span>
								<div class="input-group date">
									<a href="javascript:void(0)" onclick="SubReglones();" title="Seleccionar Subreglones" class="input-group-addon"><i class="fa fa-search"></i></a>
									<input type = "text" class = "form-control" name = "descsubreglon" id = "descsubreglon" value="<?php echo $descsubreglon; ?>" readonly />
								</div>
								<input type = "hidden" name = "subreglon" id = "subreglon" value="<?php echo $subreglon; ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4 col-xs-offset-1">
								<label>Monto: </label> <span class="text-danger">*</span>
								<input type = "text" class = "form-control" name = "monto" id = "monto" value="<?php echo $monto; ?>" onkeyup = "decimales(this);" />
							</div>
							<div class="col-xs-3">
								<label>Moneda: </label> <span class="text-danger">*</span>
								<?php echo moneda_transacciones_html("moneda"); ?>
								<script>
									document.getElementById("moneda").value = '<?php echo $moneda; ?>';
								</script>
							</div>
							<div class="col-xs-3">
								<label>Movimiento: </label> <span class="text-danger">*</span>
								<select id = "mov" name = "mov" class = "form-control">
									<option value = "D">Debe</option>
									<option value = "H">Haber</option>
								</select>
								<script>
									document.getElementById("mov").value = '<?php echo $mov; ?>';
								</script>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label>Motivo o Justificaci&oacute;n: </label> <span class="text-danger">*</span>
								<input type = "text" class = "form-control" name = "motivo" id = "motivo" value="<?php echo $motivo; ?>" onkeyup = "texto(this)" />
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a class="btn btn-default" id = "limp" href = "FRMdetalle.php?hashkey=<?php echo $hashkey; ?>"><span class="fa fa-eraser"></span> Limpiar</a>
                                <button type="button" class="btn btn-primary" id = "gra" onclick = "GrabarDetalle();"><span class="fa fa-save"></span> Grabar</button>
                            </div>
                        </div>
					</form>
				</div>
                <!-- /.panel-body -->
				<div class="row">
                    <div class="col-xs-12">
						<?php
							echo tabla_detalle($poliza);
						?>
					</div>
				</div>
            </div>
            <!-- /.panel-default -->
		</div>
        <!-- /#page-wrapper -->
	</div>
    <!-- /#wrapper -->
    
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
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
    <!-- Datepicker Bootstrap v3.0 -->
    <script src="../assets.3.6.2/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/finanzas/poliza.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 100,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Reporte de Polizas Contables'},
                    //{extend: 'pdf', title: 'ReporteUsuario'},

                    {extend: 'print',
						customize: function (win){
							   $(win.document.body).addClass('white-bg');
							   $(win.document.body).css('font-size', '10px');
   
							   $(win.document.body).find('table')
									   .addClass('compact')
									   .css('font-size', 'inherit');
					    },
						title: 'Reporte de Polizas Contables'
                    }
                ]
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