<?php
	include_once('html_fns_info.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//$_POST
	$codigo = $_REQUEST["info"];
	$ClsInf = new ClsInformacion();
	$result = $ClsInf->get_informacion($codigo);
	if(is_array($result)){
		foreach($result as $row){
			$codigo = $row["inf_codigo"];
			$nombre = utf8_decode($row["inf_nombre"]);
			$desc = utf8_decode($row["inf_descripcion"]);
			$imagen = $row["inf_imagen"];
		}
	}
	
	if(file_exists("../../CONFIG/Actividades/".$imagen)){
		$foto = "../../CONFIG/Actividades/".$imagen;
	}else{
		
	}
	
	if(file_exists("../../CONFIG/images/sello_agua.png")){
		$selloAgua = '../../CONFIG/images/sello_agua.png';
	}else{
		$selloAgua = '';
	}
	
if($usuario != "" && $tipo_usuario != ""){ 	
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
                    <ul class="nav" id="side-menu">
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
                                <li>
									<a href="FRMnewinfo.php">
										<i class="fa fa-plus-circle"></i> Nueva Actividad
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMmodinfo.php">
										<i class="fa fa-edit"></i> Actualizar Actividad
									</a>
                                </li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMeditfoto.php?info=<?php echo $codigo; ?>">
										<i class="fa fa-image"></i> Redimensi&oacute;n de la imagen
									</a>
                                </li>
								<?php } ?>
								<hr>
								<li>
                                    <a href="../CPMENU/MENUcomunicacion.php">
									<i class="fa fa-indent"></i> Men&uacute
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
					<br><br>
					<div class="btn btn-default btn-block">
						<label>Agregar Sello de Agua</label>
						<input type="checkbox" id = "sello" name= "sello" checked= />
					</div>
					<h4 class="text-center text-info">Sello de Agua</h5>
					<div class="text-center">
						<img src="<?php echo $selloAgua; ?>" style="width: 50%;" />
					</div>
					<br>
					<button type="button" class="btn btn-primary btn-block" onclick="window.location.reload();" ><i class="fa fa-refresh"></i></button>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			<br>
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-image"></i>
					Redimensi&oacute;n de la imagen
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
							<div class="img-preview img-preview-lg"></div>
							<br>
							<div class="btn-group">
								<label title="Donload image" id="download" class="btn btn-primary btn-block">
									<i class="fa fa-save"></i> &nbsp; 
									Guardar Imagen
								</label>
								<a href = "FRMnewinfo.php" class="btn btn-warning btn-block">
									<i class="fa fa-ban"></i> &nbsp; 
									Saltar este paso
								</a>
							</div>
							<hr>
							<h4><i class="fa fa-wrench"></i>  Herramientas de Edici&oacute;n</h4>
							<br>
							<div class="btn-group">
								<button class="btn btn-default" id="zoomIn" type="button"><i class="fa fa-search-plus"></i> Zoom</button>
								<button class="btn btn-default" id="zoomOut" type="button"><i class="fa fa-search-minus"></i> Zoom</button>
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
				<h4 class="modal-title text-left" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/informacion.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
        $(document).ready(function(){
			var $image = $(".image-crop > img")
            $($image).cropper({
                aspectRatio: 1.618,
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
                abrir();
				var dataurl = $image.cropper("getDataURL");
				var blob = dataURLtoBlob(dataurl);
				var f1 = new FormData();
				//--
					chk = document.getElementById("sello");
					var sello = '';
					sello = (chk.checked)?'1':'';
				//--
				f1.append("nombre", "<?php echo $imagen; ?>");
				f1.append("imagen", blob);
				f1.append("sello", sello);
				var request = new XMLHttpRequest();
				request.open("POST", "EXEeditfoto.php");
				request.send(f1);
				
				window.setTimeout(redirige,500);
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
				cerrar();
				swal("Excelete!", "La imagen fue editada satisfactoriamente...", "success").then((value)=>{ window.location.href = 'FRMnewinfo.php'; });
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