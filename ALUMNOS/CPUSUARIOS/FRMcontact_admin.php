<?php
	include_once('html_fns_usuarios.php');
	$success = $_REQUEST["success"];
	
	//////////////////////// CREDENCIALES DE COLEGIO
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_credenciales();
	if(is_array($result)){
		foreach($result as $row){
			$nombre = utf8_decode($row['colegio_nombre']);
			$rotulo = utf8_decode($row['colegio_rotulo']);
			$rotulo_sub = utf8_decode($row['colegio_rotulo_subpantalla']);
			$nombre_reporte = utf8_decode($row['colegio_nombre_reporte']);
			$direccion1 = utf8_decode($row['colegio_direccion1']);
			$direccion2 = utf8_decode($row['colegio_direccion2']);
			$departamento = utf8_decode($row['colegio_departamento']);
			$municipio = utf8_decode($row['colegio_municipio']);
			$telefono = utf8_decode($row['colegio_telefono']);
			$correo = utf8_decode($row['colegio_correo']);
			$website = utf8_decode($row['colegio_website']);
			$nivel = utf8_decode($row['mineduc_nivel']);
			$ciclo = utf8_decode($row['mineduc_cliclo']);
			$modalidad = utf8_decode($row['mineduc_modalidad']);
			$jornada = utf8_decode($row['mineduc_jornada']);
			$sector = utf8_decode($row['mineduc_sector']);
			$area = utf8_decode($row['mineduc_area']);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cont&aacute;ctanos</title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
	<link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
	
	<!-- libraries -->
	<link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
	
	<!-- global styles -->
	<link rel="../stylesheet" type="text/css" href="../assets.3.5.20/css/util.css" />
	<!-- Custom CSS -->
	<link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
	<link href="../assets.3.5.20/css/util.css" rel="stylesheet" />
	
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- Sweet Alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<style>
		.jumbotron {
			font-size: 14px;
			font-weight: 200;
			line-height: 2.1428571435;
			color: inherit;
		}
	</style>

</head>
</head>
<body>
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
					<a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $nombre; ?></label> </a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active">
							<a href="javascript:void(0);">
							<label>Ayuda</label>
							</a>
						</li>
						<li>
							<a href="#" onclick= "window.close();">
								<i class="fa fa-times"></i> Cerrar
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
  
		<!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron" id = "jumbotron">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
					<!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
					<form action="FRMmail.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
						<?php if($success == "success"){ ?>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<h5 class="alert alert-success"><i class="fa fa-check-square-o text-success"></i> Correo enviado exitosamente!!!</h5>
							</div>
						</div>
						<?php }else if($success == "error"){ ?>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<h5 class="alert alert-danger"><i class="fa fa-warning text-danger"></i> Error en el envio de correos...</h5>
							</div>
						</div>
						<?php } ?>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label>Nombre</label>
								<input type="text" class="form-control" placeholder="Nombre" name="name" id="name" required data-validation-required-message="Por favor ingresa tu nombre">
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label>E-mail</label>
								<input type="email" class="form-control" placeholder="E-mail" name="email" id="email" required data-validation-required-message="Por favor ingresa tu e-mail">
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label>Telefono</label>
								<input type="tel" class="form-control" placeholder="Telefono" name="phone" id="phone" required data-validation-required-message="Por favor ingresa tu numero de telefono">
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label>Mensaje</label>
								<textarea rows="5" class="form-control" placeholder="Tu Mensaje" name="message" id="message" required data-validation-required-message="Por favor ingresa el mensaje o pregunta"></textarea>
								<p class="help-block text-danger"></p>
							</div>
						 </div>
						 <br>
						 <div id="success"></div>
						 <div class="row">
							<div class="form-group col-xs-12 text-right">
								<button type="submit" onclick = "enviar();" class="btn btn-primary btn-lg">Enviar &nbsp;&nbsp; <i class="fas fa-paper-plane"></i></button>
							</div>
						 </div>
					</form>
				</div>
			</div>
		</div>
   </div>
	<!-- /container -->
	
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
	<script type="text/javascript" src="../assets.3.5.20/js/modules/seguridad/pregunta.js"></script>
	<script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	
</body>

</html>

