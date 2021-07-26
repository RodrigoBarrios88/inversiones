<?php
	include_once('xajax_funct_presupuesto.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	//$_POST
	$suc = $_REQUEST["suc"];
	$clase = $_REQUEST["clase"];
	$anio = $_REQUEST["anio"];
	$mes = $_REQUEST["mes"];
	
if($tipo != "" && $nombre != ""){ 	
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
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    

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
                                <?php if($_SESSION["PRESUPUESTOIN"] == 1){ ?>
                                <li>
									<a href="FRMingresos.php">
										<i class="fa fa-sign-in"></i> Planificador de Ingresos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["PRESUPUESTOOUT"] == 1){ ?>
								<li>
									<a href="FRMegresos.php">
										<i class="fa fa-sign-out"></i> Planificador de Egresos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GRAPHPIN"] == 1){ ?>
								<li>
									<a href="FRMvsingresos.php">
										<i class="fa fa-bar-chart-o"></i> Vs Ingresos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GRAPHPOUT"] == 1){ ?>
								<li>
									<a href="FRMvsegresos.php">
										<i class="fa fa-bar-chart-o"></i> Vs Egresos
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["GRAPHTODO"] == 1){ ?>
								<li>
									<a href="FRMcondensado.php">
										<i class="fa fa-bar-chart-o"></i> Anual Condensado
									</a>
								</li>
								<?php } ?>
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
				<div class="panel-heading"><label>Planificador de Egresos</label></div>
                    <div class="panel-body">
					<form id='f1' name='f1' action='FRMegresos.php' method='get'>
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
						</div>
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1"><label>Empresa: </label> <span class="text-danger">*</span> </div>
                            <div class="col-xs-5"><label>Clase: </label> <span class="text-danger">*</span> </div>
                        </div>
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
								<?php echo empresa_html("suc","Submit();"); ?>
								<script>
									document.getElementById("suc").value = '<?php echo $suc; ?>';
								</script>
							</div>
                            <div class="col-xs-5">
								<select class="form-control" name = "clase" id = "clase" onchange ="Submit();">
									<option value = "">Seleccione</option>
									<option value = "C">COMPRAS</option>
									<option value = "G">GASTOS</option>
								</select>
								<script>
									document.getElementById("clase").value = '<?php echo $clase; ?>';
								</script>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1"><label>A&ntilde;o: </label> <span class="text-danger">*</span> </div>
                            <div class="col-xs-5"><label>Mes: </label> <span class="text-danger">*</span> </div>
                        </div>
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
								<input type = "text" class="form-control" name = "anio" id = "anio" value="<?php echo $anio; ?>" onkeyup = "enteros(this);" onblur="Submit();" />
							</div>
                            <div class="col-xs-5">
								<select class="form-control" name = "mes" id = "mes" onchange ="Submit();">
									<option value = "">Seleccione</option>
									<option value = "1">ENERO</option>
									<option value = "2">FEBRERO</option>
									<option value = "3">MARZO</option>
									<option value = "4">ABRIL</option>
									<option value = "5">MAYO</option>
									<option value = "6">JUNIO</option>
									<option value = "7">JULIO</option>
									<option value = "8">AGOSTO</option>
									<option value = "9">SEPTIEMBRE</option>
									<option value = "10">OCTUBRE</option>
									<option value = "11">NOVIEMBRE</option>
									<option value = "12">DICIEMBRE</option>
								</select>
							</div>
							<script>
								document.getElementById("mes").value = '<?php echo $mes; ?>';
							</script>
                        </div>
                        <br>
                    </div>
                    <!-- /.panel-body -->
					<br>
					<div class="row">
						<div class="col-lg-12" id = "result">
							<?php
								if($clase != "" && $suc != "" && $anio != "" && $mes != ""){
									echo tabla_reglones('','',"E",$clase,$suc,$anio,$mes);
								}
							?>
						</div>
					</div>
				</form>
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
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/finanzas/presupuesto.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
			responsive: true
		});
	    });
    </script>	

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	//echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>