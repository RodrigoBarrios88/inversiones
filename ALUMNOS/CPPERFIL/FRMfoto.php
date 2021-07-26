<?php
	include_once('xajax_funct_perfil.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo = $_SESSION["nivel"];
	
	//$_POST
	$ClsUsu = new ClsUsuario();
	$foto = $ClsUsu->last_foto_usuario($usuario);
	
	if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg') && $foto != ""){
		$foto = 'USUARIOS/'.$foto.'.jpg';
	}else{
		$foto = "nofoto.png";
	}
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
	
	<!-- Inpuut File Uploader libs -->
	<link href="../assets.3.5.20/css/lib/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="../assets.3.5.20/js/plugins/file-input/fileinput.js" type="text/javascript"></script>
    <script src="../assets.3.5.20/js/plugins/file-input/fileinput_locale_fr.js" type="text/javascript"></script>
    <script src="../assets.3.5.20/js/plugins/file-input/fileinput_locale_es.js" type="text/javascript"></script>
    
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
				<li><a href="FRMperfil.php"><i class="icon-user"></i> Perfil</a></li>
				<li><a href="FRMnew-user.php"><i class="icon-plus"></i> Familia</a></li>
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
                <!-- avatar column -->
                <div class="col-md-4 avatar-box">
                    <div class="personal-image col-md-10 col-md-offset-1">
                        <img src="../../CONFIG/Fotos/<?php echo $foto; ?>" class="avatar img-circle" alt="avatar" width="175px" />
					</div>
				</div>
                <!-- edit form column -->
                <div class="col-md-7 personal-info">
					<form action="EXEcarga_foto.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-12 col-md-12 text-right text-danger">* Campos Obligatorios</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-10 col-md-offset-1" id = "alerta">
										
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 col-md-offset-4">
										<a href="#" class="thumbnail">
											<img src="../../CONFIG/Fotos/<?php echo $foto; ?>" alt="..." width="250px">
										</a>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-10 col-md-offset-1">
										<label>Seleccione una Imagen: <span class="text-danger">*</span>
									</div>
								</div>
								<div class="row">
									<div class="input-group col-md-10 col-md-offset-1">
										<div class="form-group">
											<input id="doc" name="doc" type="file" multiple="false" >
											<input type="hidden" name="nom" id="nom" value = "<?php echo $usuario; ?>" />
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6 col-md-offset-3 text-center">
										<button type="button" class="btn btn-default" onclick = "Limpiar();"><span class="glyphicon glyphicon-erase"></span> Limpiar</button>
										<button type="button" class="btn btn-primary" onclick = "Cargar();"><span class="fas fa-file-upload"></span> Cargar</button>
									</div>
								</div>
							</div>
							<!-- /.panel-body -->
						</div>
						<!-- /.panel-default -->
					</form>	   
                </div>
            </div>            
        </div>
    </div>
    <!-- end main container -->

	<!-- scripts -->
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/theme.js"></script>
	
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/perfil/perfil.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	<script>
		$("#doc").fileinput({
			showUpload: false,
			showCaption: true,
			browseClass: "btn btn-primary btn-md",
			fileType: "any",
			allowedFileExtensions : ['jpg','jpeg', 'png'],
			previewFileIcon: "<i class='glyphicon glyphicon-picture'></i>",
			//minImageWidth: 600,
			//minImageHeight: 600,
			//maxImageWidth: 5000,
			//maxImageHeight: 5000,
			maxFileSize: 2000
		});
    </script>
	
</body>
</html>
