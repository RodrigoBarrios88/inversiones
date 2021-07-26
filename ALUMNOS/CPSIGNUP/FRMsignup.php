<?php
include_once("xajax_funct_signup.php");

?>
<!DOCTYPE html>
<html class="login-bg">
<head>
	<title>Hola!</title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	?>
	
    <!-- bootstrap -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/icons.css" />

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/lib/font-awesome.css" />
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/signup.css" type="text/css" media="screen" />

     <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	
	<!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
            <a class="navbar-brand" href="../index.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
        	<a class="navbar-brand2" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
			<button type="button"  class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>     
    </header>
    <!-- end navbar -->
	<br>
    <div class="row-fluid login-wrapper">
        <div class="box">
            <div class="content-wrap">
				<!--img src="../../CONFIG/images/logo.png" style="-webkit-filter: invert(50%);" width="50px" /-->
				<img src="../../CONFIG/images/escudo.png" width="150px" />
				<hr style="margin:0;">
                <div id = "alerta" class="alert"></div>
				<input id = "cod" type="hidden">
                <input class="span12" id = "cui" type="text" placeholder="CUI (DPI)" onkeyup="enteros(this);" onblur="Buscar_CUI(this);" maxlength="13" />
                <input class="span12" id = "nom" type="text" placeholder="Nombres">
                <input class="span12" id = "ape" type="text" placeholder="Apellidos">
				<input class="span12" id = "mail" type="text" placeholder="E-mail (Usuario)">
                <div class="action">
                    <button id = "new" class="btn-glow primary signup" onclick = "NewUser();" disabled ><i class="icon icon-checkmark"></i> Aceptar</button>
					<button id = "mod" class="btn-glow primary signup hidden" onclick="Actualizar();" ><i class="icon icon-checkmark"></i> Aceptar</button>
                </div>                
            </div>
        </div>

        <div class="span4 already">
            <p>Ya tengo una cuenta?</p>
            <a href="../index.php">Ingresar</a>
        </div>
    </div>
	
	<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="28px" /> &nbsp; </h4>
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
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/theme.js"></script>
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/seguridad/signup.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
</body>
</html>