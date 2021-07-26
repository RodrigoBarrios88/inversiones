<?php
	include_once('xajax_funct_valida.php');
	$ClsUsu = new ClsUsuario();
	
	$hashkey = $_REQUEST["hashkey"];
	$cod = $ClsUsu->decrypt($hashkey, "clave");
	
	$result = $ClsUsu->get_usuario($cod);
	if(is_array($result)){
		foreach($result as $row){
			$usu = $row["usu_usuario"];
			$mail = $row["usu_mail"];
			$tel = $row["usu_telefono"];
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../images/icono.ico">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	?>
	<!-- Bootstrap Core CSS -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
    
    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
	<link href="../assets.3.5.20/css/password.css" rel="stylesheet" />
    
	<!-- global styles -->
    <link rel="../stylesheet" type="text/css" href="../assets.3.5.20/css/util.css" />
	
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body style = "background-color:#fff;">
 
      <div class="container">
	<!-- Static navbar -->
	 <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					
				</ul>
			</div>
		</div>
	</nav>
  
	<br>
	  <!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron" id = "jumbotron">
		<form name = "f1" id = "f1" action = "EXEactivate.php" method = "post" >
			<div class="row">
			    <div class="col-xs-12 col-md-12 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
			</div>
            <div class="row">
				<div class="col-md-8 col-md-offset-2 text-center"><label>
					<h2>
						<i class="icon icon-info text-info"></i> <br>
						Hola!, para activar su usuario por favor ingrese una contrase&ntilde;a.
					</h2>
				</div>
			</div>
			<br>
			<div class="panel panel-info">
				<div class="panel-heading"><h4><i class="icon icon-users"></i> Datos de Perfil</h4></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8 col-md-offset-2"><label>Nombre en Pantalla: </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<input type = "text" class = "form-control text-libre" name = "nompant" id = "nompant" value = "<?php echo $nombre_pantalla; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2"><label>Correo Electr&oacute;nico: </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<input type = "text" class = "form-control text-libre" name = "mail" id = "mail" value = "<?php echo $mail; ?>" />
							<input type = "hidden" name = "tel" id = "tel" value = "<?php echo $tel; ?>" />
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
					<small class="col-md-2 col-md-offset-10">Copyright &copy; ID 2019.</small>
					</div>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading"><h4><i class="icon icon-lock"></i> Seguridad</h4></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8 col-md-offset-2"><label>Usuario: </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<input type = "text" class = "form-control text-libre" name = "usu" id = "usu" value = "<?php echo $usu; ?>" readonly />
							<input type = "hidden" name = "cod" id = "cod" value = "<?php echo $cod; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2"><label>Nuevo Password: </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<input type = "password" class = "form-control text-libre" name = "pass1" id = "pass1" onkeyup = "comprueba_vacios(this,'pas1')"/>
						</div>
						<div class="col-md-1"><span id = "pas1"></span></div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2"><label>Confirme el Nuevo Password: </label> <span class="text-danger">*</span></div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<input type = "password" class = "form-control text-libre" name = "pass2" id = "pass2" onkeyup = "comprueba_iguales(this,document.f1.pass1);"/>
						</div>
						<div class="col-md-1"><span id = "pas2"></span></div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-3 col-md-offset-1 text-right"><small>Fortaleza de la Contrase&ntilde;a</small></div>
						<div class="col-md-6">
							<div class="progress">
								<div id = "progress1" class="progress-bar progress-bar-danger progress-bar-striped" style="width: 0%">
									
								</div>
								<div id = "progress2" class="progress-bar progress-bar-warning progress-bar-striped" style="width: 0%">
									
								</div>
								<div id = "progress3" class="progress-bar progress-bar-success progress-bar-striped" style="width: 0%">
									
								</div>
							</div>
					      </div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<small class="col-md-2 col-md-offset-10">Copyright &copy; ID 2019.</small>
					</div>
					<input type = "hidden" name = "preg" id = "preg" />
					<input type = "hidden" name = "resp" id = "resp" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<br>
					<button type="button" class="btn btn-primary" onclick = "aceptar();"><span class="fa fa-check"></span> Aceptar</button>	
				</div>
			</div>
		</form>
	</div>
      </div> <!-- /container -->
      

    <!-- //////////////////////////////////////////////////////// -->
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
    
	<!-- jQuery -->
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/perfil/perfil.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/perfil/cambiapass.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
    
</body>

</html>