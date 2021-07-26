<?php
include_once('html_fns_img.php');

//$foto =  "../../CONFIG/Fotos/ALUMNOS/9777870709753.jpg";
//$destino =  "../../CONFIG/Fotos/ALUMNOS/9777870709753-B.jpg";

$foto =  "foto.jpg";
$destino = "nueva.jpg";
// Cargar la estampa y la foto para aplicarle la marca de agua
$estampa = imagecreatefrompng('estampa.png');
$im = imagecreatefrompng('foto.jpg');

// Establecer los márgenes para la estampa y obtener el alto/ancho de la imagen de la estampa
$margen_dcho = 10;
$margen_inf = 10;
$sx = imagesx($estampa);
$sy = imagesy($estampa);

// Copiar la imagen de la estampa sobre nuestra foto usando los índices de márgen y el
// ancho de la foto para calcular la posición de la estampa. 
imagecopy($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa));





$dest_image = imagecreatetruecolor($wBase, $hBase);
imagesavealpha($dest_image, true);
$trans_background = imagecolorallocatealpha($dest_image, 0, 0, 0, 127);
imagefill($dest_image, 0, 0, $trans_background);
$a = imagecreatefrompng($foto);
$b = imagecreatefrompng($TempSelloAgua);
imagecopy($dest_image, $a, 0, 0, 0, 0, $wBase, $hBase);
imagecopy($dest_image, $b, 100, 100, 0, 0, $wSelloNew, $hSelloNew);
imagejpeg($dest_image, $destino);
//////////// -------- Convierte todas las imagenes a JPEG
// Abrimos una Imagen PNG
$imagen = imagecreatefrompng($destino);
// Creamos la Imagen JPG a partir de la PNG u otra que venga
imagejpeg($imagen,$destino,100);


// Imprimir y liberar memoria
//header('Content-type: image/png');
//imagepng($im,'nueva.png',100);
imagejpeg($im,'nueva.jpg',100);
//imagedestroy($im);

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
    <link href="../assets.3.6.2/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    
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
					<br><br>
					<button type="button" class="btn btn-primary btn-block" onclick="window.location.reload();" ><i class="fa fa-refresh"></i></button>
					<img src="<?php echo $selloAgua; ?>" style="width: 100%;" />
                    <button type="button" class="btn btn-default btn-block"><i class="fa fa-check"></i></button>
                </div>
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
				<br>
				<div class="panel panel-default">
					<div class="panel-heading">
						<label><i class="fa fa-image"></i> Redimensi&oacute;n de la imagen</label>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12 col-xs-12 text-center">
								<h5>Antes</h5>
								<img src="<?php echo $foto; ?>" class="img-thumbnail">
							</div>
						</div>
						<br><hr><br>
						<div class="row">
							<div class="col-lg-12 col-xs-12 text-center">
								<h5>Despues</h5>
								<img src="<?php echo $im; ?>" class="img-thumbnail">
							</div>
						</div>
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
	
	<!-- Image cropper -->
    <script src="../assets.3.6.2/js/plugins/cropper/cropper.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/alumno.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->

  </body>

</html>