<?php
	include_once('xajax_funct_permiso.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPADMIN"];
if($pensum != "" && $nombre != ""){ 
if($valida == 1){ 	
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
                                <li>
									<a href="#"><i class="glyphicon glyphicon-briefcase"></i> Permisos<span class="glyphicon arrow"></span></a>
									<ul class="nav nav-third-level collapse">
										<li>
										<a href="FRMgrupo.php"><i class="glyphicon glyphicon-king"></i> Grupos de Permisos</a>
										</li>
										<li>
										<a href="FRMpermiso.php"><i class="glyphicon glyphicon-pawn"></i> Permisos</a>
										</li>
										<li>
										<a href="CPREPORTES/FRMrepgrupo.php"><i class="glyphicon glyphicon-print"></i> Reporte Grupo/Permisos</a>
										</li>
										<li>
										<a href="CPREPORTES/FRMreppermiso.php"><i class="glyphicon glyphicon-print"></i> Reporte de Permisos</a>
										</li>
									</ul>
									<!-- /.nav-second-level -->
								</li>
								<li>
									<a href="FRMrollmod.php"><i class="glyphicon glyphicon-briefcase"></i> Roles<span class="glyphicon arrow"></span></a>
									<ul class="nav nav-third-level collapse">
										<li>
										<a href="FRMrollver.php"><i class="glyphicon glyphicon-eye-open"></i> Ver Roles</a>
										</li>
										<li>
										<a href="FRMroll.php"><i class="glyphicon glyphicon-copy"></i> Nuevo Rol</a>
										</li>
										<li>
										<a href="FRMrollmod.php"><i class="glyphicon glyphicon-refresh"></i> Actualizar Roles</a>
										</li>
										<li>
										<a href="FRMrolldel.php"><i class="glyphicon glyphicon-floppy-remove"></i> Deshabilitar Roles</a>
										</li>
										 <li>
										<a href="CPREPORTES/FRMreproll.php"><i class="glyphicon glyphicon-print"></i> Reporte de Roles</a>
										</li>
									</ul>
									<!-- /.nav-second-level -->
								</li>
								<hr>
                                <li>
                                    <a href="../menu.php"><i class="glyphicon glyphicon-list"></i> Men&uacute; Principal</a>
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
		<form name = "f1" name = "f1" method="post" enctype="multipart/form-data">
            <br>
            <div class="panel panel-default">
				<div class="panel-heading"><label><i class="glyphicon glyphicon-refresh"></i> Formulario de Actualizaci&oacute;n de Roles </label></div>
                <div class="panel-body">
					<div class="row">
						<div class="col-lg-12" id = "result">
						<?php echo tabla_roles('','M') ?>
						</div>
					</div>
            	</div>		
                <!-- /.panel-body -->
			</div>
             <!-- /.panel-default -->
		</form>	     
        </div>
        <!-- /#page-wrapper -->
        
    </div>
    <!-- /#wrapper -->
    
    <!-- //////////////////////////////////////////////////////// -->
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/rol.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../menu.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
} 
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>