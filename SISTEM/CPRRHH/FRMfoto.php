<?php
	include_once('html_fns_rrhh.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsPer = new ClsPersonal();
	$dpi = $ClsPer->decrypt($hashkey, $usuario);
	
	if(file_exists ('../../CONFIG/Fotos/RRHH/'.$dpi.'.jpg')){ /// valida que tenga foto registrada
		$foto = 'RRHH/'.$dpi.'.jpg';
	}else{
		$foto = 'nofoto.png';
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
    <!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Personal CSS -->
    <link href="../assets.3.6.2/css/dhtmlgoodies_calendar.css" rel="stylesheet">
    
    <!-- JS snapshot -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/plugins/jpegcamera/jpeg_camera_with_dependencies.min.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/plugins/jpegcamera/jpegcamera.js"></script>
	<link href="../assets.3.6.2/css/plugins/jpegcamera/jpegcamera.css" media="all" rel="stylesheet" type="text/css" /></link>
	
    <!-- Sweet Alert -->
	<script src="../assets.3.6.2/js/plugins/sweetalert/sweetalertnew.min.js"></script>
	
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
								<li>
									<a href="FRMfoto.php?hashkey=<?php echo $hashkey; ?>">
										<i class="fa fa-camera"></i> Tomar Fotograf&iacute;a
									</a>
								</li>
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
					<div class="panel-heading"><i class="fa fa-camera"></i> Formulario de Busqueda de Personal</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-6 text-center">
								<div class="alert alert-info">
									<label id="camera_info"></label>
									<hr>
									<label id="stream_stats"></label>
								</div>
								
								<div id="camera">
									<div class="placeholder">
										<br>
										Tu navegador no soporta un accesos a camara web.<br><br>
										Te recomendamos
										<a href="https://www.google.com/chrome/" target="_blank">Chrome</a>
										&mdash; el moderno, seguro, r&aacute;pido navegador de Google.<br>
										Es gratis!
									</div>
								</div><br>
							
								<button type="button" class="btn btn-primary" id="take_snapshots"><span class="fa fa-photo"></span> Tomar Foto</button>
								<button type="button" class="" id="show_stream"><span class="fa fa-refresh"></span> Camara</button><br>
							
								<div id="snapshots"></div>
							
								<button type="button" class="" id="discard_snapshot"><span class="fa fa-times-circle"></span> Descartar</button>
								<button type="button" class="" id="upload_snapshot"><span class="fa fa-check-circle"></span> Aceptar</button><br>
								
								<input type="hidden" id="api_url" value="EXEeditfoto.php"><br>
								<input type="hidden" name="cui" id="cui" value = "<?php echo $dpi; ?>" />
								<img src = "../../CONFIG/images/img-loader.gif" id="loader" width = "100px" />
								<div id="upload_status"></div>
								<div id="upload_result"></div>
							</div>	
								
							<div class="col-xs-4 col-xs-offset-1 panel panel-warning" style = "padding:0px;">
								<div class="panel-heading">
									Fotograf&iacute;as Existentes
								</div>
								<div class="panel-body text-center">
									<h5 class = "text-justify">No tengo camara web &oacute; ya tome la fotografia con anterioridad y deseo subirla...</h5>
									<br>
									<div class="row">
										<div class="col-xs-10 col-xs-offset-1">
											<button type="button" class="btn btn-default btn-block" onclick = "window.location.reload();" title = "Refrescar P&aacute;gina"><i class="fa fa-refresh"></i></button>
										</div>	
									</div>
									<hr>
									<img src = "../../CONFIG/Fotos/<?php echo $foto; ?>" width = "150px" class = ""class="thumbnail" />
									<hr>
									<div class="row">
										<div class="col-xs-10 col-xs-offset-1">
											<form action="EXEcarga_imagen.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
												<button type="button" class="btn btn-primary btn-block" onclick = "FotoJs();" title = "Cambiar Fotograf&iacute;a"><i class="fa fa-camera"></i> <i class="fa fa-plus"></i>  Cambiar Fotograf&iacute;a...</button>
												<input id="imagen" name="imagen" type="file" multiple="false" class = "hidden" onchange="Cargar();" >
												<input type="hidden" name="nom" id="nom" value = "<?php echo $dpi; ?>" />
												<input type="hidden" name="hashkey" id="hashkey" value = "<?php echo $hashkey; ?>" />
											</form>
										</div>	
									</div>
									<br>
								</div>
								<div class="panel-footer">
									&nbsp;
								</div>
							</div>
							
						</div>
						<br>
					</div>
					<!-- /.panel-body -->
				</div>
				 <!-- /.panel-default -->
		</div>
        <!-- /#page-wrapper -->
        
        <!-- //////////////////////////////// -->

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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/rrhh/rrhh.js"></script>

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>