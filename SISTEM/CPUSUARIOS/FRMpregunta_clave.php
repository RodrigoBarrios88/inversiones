<?php
	include_once('xajax_funct_usuarios.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Ayuda </title>
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	?>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/menu.css" rel="stylesheet">
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <script src="https://kit.fontawesome.com/907a027ade.js" crossorigin="anonymous"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
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
			    <div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
			</div>
            <div class="row">
				<div class="col-lg-8 col-xs-12 col-lg-offset-2 text-center"><label>
					<i class="fa fa-info-circle fa-3x text-info"></i> 
					<h2>Recuperaci&oacute;n de Contrase&ntilde;a</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 col-xs-12 col-lg-offset-2 text-center"><label>
					<p  class = "text-justify">
						Estimado Usuario, para nosotros es un gusto servirle y prestarle apoyo en su trabajo diario adentro del sistema.<br><br>
						Por normativos de seguridad, se le preguntaran ciertos datos propios de su cuenta para comprobar que usted es el titular de la misma, 
						si tiene algun problema con este formulario o alguna duda sobre el procedimiento, le sugerimos que contacte al administrador del sistema
						por medio del siguiente link: 
						<a href = "FRMcontact_admin.php" title = "Click aqui para Contactar al Administrador..." ><b>Contactar al Administrador</b></a>.
					</p>
				</div>
			</div>
			<form name = "f1" id = "f1" method = "post" >
			<div class="panel panel-info">
				<div class="panel-heading"> <i class="fa fa-user"></i> Datos de Perfil</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-2 col-lg-offset-2 col-xs-12"><label>Tipo de Usuario: </label> <span class="text-danger">*</span></div>
						<div class="col-lg-4 col-xs-12">
							<select name = "tipo" id = "tipo" class="form-control">
								<option>Seleccione</option>
								<option value="5">ADMINISTRADOR</option>
								<option value="1">DIRECTOR O AUTORIDAD</option>
								<option value="2">DOCENTE O MAESTO</option>
								<option value="3">PADRE DE FAMILIA</option>
								<option value="6">USUARIO ADMINISTRATIVO</option>
							</select>
							<input type = "hidden" name = "cod" id = "cod" />
							<input type = "hidden" name = "usu" id = "usu" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-2 col-lg-offset-2 col-xs-12"><label>E-Mail: </label> <span class="text-danger">*</span></div>
						<div class="col-lg-4 col-xs-12">
							<input type = "text" class = "form-control text-libre" name = "email" id = "email" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center">
							<br>
							<button id = "btn-aceptar" type="button" class="btn btn-primary" onclick = "aceptar();"><i class="fas fa-paper-plane"></i> Enviar</button>	
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
					<small class="col-xs-12 text-right">Copyright &copy; ID 2017.</small>
					</div>
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