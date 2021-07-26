<?php
	include_once('xajax_funct_poliza.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	//$_POST
	$suc = $_REQUEST["suc"];
	$doc = $_REQUEST["doc"];
	$desc = $_REQUEST["desc"];
	//--
	$desde = $_REQUEST["desde"];
	$desde = ($desde == "")? date ( 'd/m/Y' ,strtotime ( '-1 month' , strtotime ( date('Y-m-d') ) ) ) : $desde;
	$hasta = $_REQUEST["hasta"];
	$hasta = ($hasta == "")? date('d/m/Y') : $hasta;
if($id != "" && $nombre != ""){ 	
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
                       <li>
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
					<label><i class="fa fa-search"></i> Buscar Polizas</label>
				</div>
                <div class="panel-body">
					<form id='f1' name='f1' method='get'>
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
						</div>
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
								<label>Empresa o Entidad: </label> <span class="text-danger">*</span> 
								<?php echo empresa_html("suc","Submit()"); ?>
								<script>
									document.getElementById("suc").value = '<?php echo $suc; ?>';
								</script>
							</div>
							<div class="col-xs-5">
								<label>Documento de Respaldo: </label> <span class="text-danger">*</span> 
								<input type = "text" class = "form-control" name = "doc" id = "doc" value="<?php echo $doc; ?>" onkeyup = "texto(this);KeyEnter(this,Submit);"  />
							</div>
                        </div>
						<div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
								<label>Desde / Hasta: </label> <span class="text-danger">*</span>
								<div class="form-group" id="data_1">
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="form-control" name="desde" id="desde" value="<?php echo $desde; ?>"/>
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control" name="hasta" id="hasta" value="<?php echo $hasta; ?>" />
									</div>
								</div>
							</div>
							<div class="col-xs-5">
								<label>Frase o referencia de la descripci&oacute;n: </label> <span class="text-danger">*</span> 
								<input type = "text" class = "form-control" name = "desc" id = "desc" value="<?php echo $desc; ?>" onkeyup = "texto(this);KeyEnter(this,Submit);" />
							</div>
                        </div>
						<br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a class="btn btn-default" id = "limp" href = "FRMpolizas.php"><span class="fa fa-eraser"></span> Limpiar</a>
                                <button type="button" class="btn btn-primary" id = "gra" onclick = "Submit();"><span class="fa fa-search"></span> Buscar</button>
                            </div>
                        </div>
						<hr>
					</form>	
                </div>
				<div class="row">
                    <div class="col-xs-12">
						<?php
							if($doc != ""){ /// si el numero de documento es especifico
								$desde = "";
								$hasta = "";
							}
							echo tabla_polizas($suc,$doc,$desc,$desde,$hasta);
						?>
					</div>
				</div>
                <!-- /.panel-body -->
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
		
		$('#data_1 .input-daterange').datepicker({
            format: 'dd/mm/yyyy',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
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