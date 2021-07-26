<?php
	$success = $_REQUEST["success"];
	
	//////////////////////// CREDENCIALES DE COLEGIO
	require_once ("../Clases/ClsRegla.php");
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_credenciales();
	if(is_array($result)){
		foreach($result as $row){
			$colegio_nombre = utf8_decode($row['colegio_nombre']);
		}
	}
	////////////////
?>
<!DOCTYPE html>
<html lang="en">
  <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Ayuda</title>
		<link rel="shortcut icon" href="../../CONFIG/images/icono.ico" >
		
		<!-- CSS personalizado -->
		<link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Bootstrap Core CSS -->
		<link href="../assets.3.6.2/css/menu.css" rel="stylesheet">
		<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
		
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
		
		<!-- Custom Fonts -->
    <script src="https://kit.fontawesome.com/907a027ade.js" crossorigin="anonymous"></script>
		
		<!-- Sweet Alert -->
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<style>
		body{
			padding-top: 20px;
		}
	</style>
    
  </head>
  <body>
    <div class="container">
		<!-- Static navbar -->
		<nav class="navbar navbar-default" id = "menu">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					  <span class="sr-only"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"><img src = "../../CONFIG/images/logo_white.png" width = "30px"></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</nav>
	<!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                    <form name = "f1" name = "f1" method="get">
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
                                <button type="button" id = "btn-enviar" onclick = "enviar();" class="btn btn-primary btn-lg"> <i class="fas fa-paper-plane"></i> Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
    </div> <!-- /container -->
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

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/loading.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/pregunta.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
  </body>
</html>

