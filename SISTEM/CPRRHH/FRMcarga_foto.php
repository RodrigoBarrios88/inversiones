<?php
	include_once('xajax_funct_rrhh.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPADMON"];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsPer = new ClsPersonal();
	$catalogo = $ClsPer->decrypt($hashkey, $usuario);
	
if($pensum != "" && $nombre != "" && $valida != ""){ 	
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
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Inpuut File Uploader libs -->
	<link href="../assets.3.6.2/bower_components/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput_locale_fr.js" type="text/javascript"></script>
	<script src="../assets.3.6.2/bower_components/bootstrap-fileinput/js/fileinput_locale_es.js" type="text/javascript"></script>
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- Timeline CSS -->
	<link href="../dist/css/timeline.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
	<link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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
                               <?php if($_SESSION["NEWRRHH"] == 1){ ?>
                                <li>
									<a href="FRMformulario.php">
										<i class="glyphicon glyphicon-file"></i> Nuevo Formulario
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["UPDRRHH"] == 1){ ?>
								<li>
									<a href="FRMbuscar.php">
										<i class="fa fa-search"></i> Busqueda de Personal
									</a>
								</li>
								<?php } ?>
								<?php if($_SESSION["UPDRRHH"] == 1){ ?>
								<li>
									<a href="FRMcarga_foto.php?hashkey=<?php echo $hashkey; ?>">
										<i class="fa fa-picture-o"></i> Carga Fotograf&iacute;a
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPCARNE"] == 1){ ?>
								<li>
									<a href="FRMcarne.php">
										<i class="fa fa-credit-card"></i> Generador de Carn&eacute;
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($_SESSION["REPCARNE"] == 1){ ?>
								<li>
									<a href="FRMlistplazas.php">
										<i class="fa fa-file-text-o"></i> Tarjeta de Responsabilidad
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUadministrativo.php">
										<i class="fa fa-indent"></i> Men&uacute;
									</a>
								</li>
								<li>
									<a href="../menu.php">
										<i class="glyphicon glyphicon-list"></i> Men&uacute; Principal
									</a>
								</li>
                            </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
		<br><br>
		<form action="EXEcarga_imagen.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
           <div class="panel panel-default">
				<div class="panel-heading"><label>Cargar de Fotograf&iacute;a </label></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-1"><label>Seleccione una Imagen: <span class="text-danger">*</span></div>
						<div class="col-xs-5 text-center">
							<div class="form-group">
								<input id="imagen" name="imagen" type="file" multiple="false" >
								<input type="hidden" name="clase" id="clase" value = "F" />
								<input type="hidden" name="nom" id="nom" value = "<?php echo $catalogo; ?>" />
							</div>
						</div>	
					</div>
					<br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-default" onclick = "Limpiar()"><span class="fa fa-eraser"></span> Limpiar</button>
                                <button type="button" class="btn btn-primary" id = "gra" onclick = "Cargar()"><span class="glyphicon glyphicon-cloud-upload"></span> Cargar</button>
                            </div>
                        </div>
                </div>
                <!-- /.panel-body -->
            </div>
             <!-- /.panel-default -->
		</form>	
        </div>
        <!-- /#page-wrapper -->
	
	<!-- //////////////////////////////// -->
        <!-- .footer -->
        <footer class="footer-login">
		<div class="container">
		      <img src = "../../CONFIG/images/logo.png" style= "width:28px" >
		      <p>
			    Powered by Inversiones Digitales S.A. Software Web Development Team.
                            Copyright &copy; <?php echo date("Y"); ?>.
		      </p>
		      
		</div>
	</footer>
        <!-- /.footer -->

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
    
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/rrhh/rrhh.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$("#imagen").fileinput({
			showUpload: false,
			showCaption: true,
			browseClass: "btn btn-primary btn-md",
			fileType: "any",
			allowedFileExtensions : ['jpg', 'png'],
			previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
			//minImageWidth: 600,
			//minImageHeight: 600,
			//maxImageWidth: 5000,
			//maxImageHeight: 5000,
			maxFileSize: 2000
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