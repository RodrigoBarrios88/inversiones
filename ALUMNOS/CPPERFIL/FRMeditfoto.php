<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
	
	include_once('html_fns_perfil.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//$_POST
	$ClsUsu = new ClsUsuario();
	$foto = $ClsUsu->last_foto_usuario($usuario);
	
	if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg') && $foto != ""){
		$foto = '../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg';
	}else{
		$foto = "../../CONFIG/Fotos/nofoto.png";
	}
	
if($usuario != "" && $tipo_usuario != ""){ 	
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    <link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
	
    <!-- bootstrap -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/icons.css" />

    <!-- libraries -->
	<link href="../assets.3.5.20/css/util.css" rel="stylesheet">
	
    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	
	<!-- Cropper CSS -->
    <link href="../assets.3.5.20/css/plugins/cropper/cropper.min.css" rel="stylesheet">
    <link href="../assets.3.5.20/css/plugins/cropper/visualizador.css" rel="stylesheet">
    
    <!-- Sweet Alert -->
	<script src="../assets.3.5.20/js/plugins/sweetalert/sweetalertnew.min.js"></script>
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/personal-info.css" type="text/css" media="screen" />

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

    <!-- navbar -->
    <header class="navbar navbar-inverse" role="banner">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
        	<a class="navbar-brand2" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
			<button type="button"  class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>
        <nav class="collapse navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
                <li><a href="../menu.php"><i class="icon-home"></i> Inicio</a></li>
				<!--li><a href="../CPHIJOS/FRMhijos.php"><i class="icon-users"></i> Hijos</a></li-->
				<li><a href="javascript:void(0);"></a></li>
            </ul>
        </nav>          
    </header>
    <!-- end navbar -->

    <!-- main container .wide-content is used for this layout without sidebar :)  -->
    <div class="content wide-content">
        <div class="settings-wrapper" id="pad-wrapper">
            <div class="row">
                <!-- edit form column -->
                <div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<label><i class="fa fa-image"></i> Redimensi&oacute;n de la imagen</label>
						</div>
						<div class="panel-body">
									<div class="row">
										<div class="col-lg-6 col-xs-12">
											<div class="image-crop">
												<img src="<?php echo $foto; ?>">
											</div>
										</div>
										<div class="col-lg-6 col-xs-12">
											<h4>Previsualizaci&oacute;n de la Imagen</h4>
											<div class="img-preview img-preview-sm"></div>
											<br>
											<div class="btn-group">
												<label title="Donload image" id="download" class="btn btn-primary btn-block">
													<i class="fa fa-save"></i> &nbsp; 
													Guardar Imagen
												</label>
											</div>
											<hr>
											<h4><i class="fa fa-wrench"></i>  Herramientas de Edici&oacute;n</h4>
											<br>
											<div class="btn-group">
												<button class="btn btn-default" id="zoomIn" type="button"><i class="fas fa-search-plus"></i> Zoom</button>
												<button class="btn btn-default" id="zoomOut" type="button"><i class="fas fa-search-minus"></i> Zoom</button>
												<button class="btn btn-default" id="rotateLeft" type="button"><i class="fa fa-rotate-left"></i> Rotar a la Izquierda</button>
												<button class="btn btn-default" id="rotateRight" type="button"><i class="fa fa-rotate-right"></i> Rotar a la Derecha</button>
											</div>
										</div>
									</div>
									<br><br>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel-default -->
                </div>
            </div>            
        </div>
    </div>
    <!-- end main container -->
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="28px" /> &nbsp;  <?php echo $_SESSION["nombre_colegio"]; ?></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../CONFIG/images/img-loader.gif"/><br>
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

	<!-- scripts -->
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/theme.js"></script>
	
	<!-- Image cropper -->
    <script src="../assets.3.5.20/js/plugins/cropper/cropper.min.js"></script>
	
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/hijos/hijos.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
        $(document).ready(function(){
			var $image = $(".image-crop > img")
            $($image).cropper({
                aspectRatio: 1.1,
                preview: ".img-preview",
                done: function(data) {
                    // Output the result data for cropping image.
                }
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                            files = this.files,
                            file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            $image.cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#download").click(function() {
                var dataurl = $image.cropper("getDataURL");
				var blob = dataURLtoBlob(dataurl);
				var f1 = new FormData();
				f1.append("imagen", blob);
				var request = new XMLHttpRequest();
				request.open("POST", "EXEeditfoto.php");
				request.send(f1);
				
				window.setTimeout(redirige,1000);
            });
			
			function dataURLtoBlob(dataurl) {
				var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
					bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
				while(n--){
					u8arr[n] = bstr.charCodeAt(n);
				}
				return new Blob([u8arr], {type:mime});
			}
			
			function redirige(){
				swal("Excelete!", "La imagen fue editada satisfactoriamente...", "success").then((value)=>{ window.location.href="FRMperfil.php" });
			}

            $("#zoomIn").click(function() {
                $image.cropper("zoom", 0.1);
            });

            $("#zoomOut").click(function() {
                $image.cropper("zoom", -0.1);
            });

            $("#rotateLeft").click(function() {
                $image.cropper("rotate", 45);
            });

            $("#rotateRight").click(function() {
                $image.cropper("rotate", -45);
            });

            $("#setDrag").click(function() {
                $image.cropper("setDragMode", "crop");
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