<?php
	include_once('xajax_funct_monitor.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsMoni = new ClsMonitorBus();
	$cuiigo = $ClsMoni->decrypt($hashkey, $usuario);
	
	$result = $ClsMoni->get_monitores_buses($cuiigo,'','',1);
	if(is_array($result)){
		
		foreach($result as $row){
			$cui = $row["mbus_cui"];
			$nombre = trim($row["mbus_nombre"])." ".trim($row["mbus_apellido"]);
			$mail = $row["mbus_mail"];
		}
	}
	
	$ClsAsi = new ClsAsignacion();
	$result = $ClsAsi->get_monitor_bus_grupo("",$cui,1);
	$grupos = "";
	if(is_array($result)){
		
		foreach($result as $row){
			$grupos.= $row["gru_codigo"].",";
		}
		$grupos = substr($grupos, 0, -1);
	}
	
if($pensum != "" && $nombre != ""){ 	
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
                               <?php if($_SESSION["GMONITOR"] == 1){ ?>
                                <li>
									<a href="FRMnewmonitor.php">
										<i class="fa fa-user"></i> Gestor de Monitores
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["GMONITOR"] == 1){ ?>
								<li>
									<a href="FRMmonitor.php">
										<i class="fa fa-list-ol"></i> Listar Monitores
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["ASIMONITOR"] == 1){ ?>
								<li>
									<a href="FRMmonitorasig.php?hashkey=<?php echo $hashkey; ?>">
										<i class="fa fa-link"></i> Asignaci&oacute;n de Monitores
									</a>
                                </li>
								<?php } ?>
								<?php if($_SESSION["REPMONITOR"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Monitores
									</a>
                                </li>
								<?php } ?>
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
				<div class="panel-heading"><label>Asignaci&oacute;n de Monitores de Buses a Grupo</label></div>
                    <div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label> <label class = " text-info">* Campos de Busqueda</label></div>
						</div>
						<div class="row">
							<div class="col-xs-3 text-right"><label>Nombre y Apellido:  <span class="text-danger">*</span> </label><span class="text-info">*</span></div>
							<div class="col-xs-8 text-info"><?php echo $nombre; ?><input type = "hidden" name = "cui" id = "cui" value = "<?php echo $cui; ?>" /></div>
						</div>
						<div class="row">
							<div class="col-xs-3 text-right"><label>e-mail:  <span class="text-danger">*</span> </label><span class="text-info">*</span></div>
							<div class="col-xs-8 text-info"><?php echo $mail; ?></div>
						</div>
						<div class="row">
							<div class="col-xs-3 text-right"><label>&Aacute;rea:  <span class="text-danger">*</span> </label><span class="text-info">*</span></div>
							<div class="col-xs-8 text-info"><?php echo Area_html("area","xajax_Area_Grupos(this.value,'$grupos');"); ?></div>
						</div>
						<div class="row">
							<hr>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-4 text-center" id = "divxasignar">
								<?php echo lista_multiple_vacia("xasignar"," Listado de Grupos no asignados"); ?>
								<?php //echo grupos_no_monitor_lista_multiple("xasignar","",$grupos); ?>
							</div>
										<div class="col-xs-4 text-center">
							<div class="list-group">
								<span class="list-group-item">
								  <button type="button" class="btn btn-primary" id = "asig" onclick = "Asigna_Grupos_Monitor();"><span class="fa fa-arrow-right "></span> Asignar</button>
								</span>
								<span class="list-group-item">
								  <button type="button" class="btn btn-primary" id = "quita" onclick = "Quitar_Grupos_Monitor();"><span class="fa fa-arrow-left "></span> &nbsp;Quitar &nbsp;</button>
								</span>
							</div>
							</div>
							<div class="col-xs-4 text-center" id = "divasignados">
								<?php //echo lista_multiple_vacia("asignados","Grupos ya Asignados a este Maestro"); ?>
								<?php echo grupos_monitor_lista_multiple("asignados",$cui); ?>
							</div>
						</div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-info" id = "busc" onclick = "Buscar(2);"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                                <button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
                            </div>
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
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/monitor.js"></script>
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
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>