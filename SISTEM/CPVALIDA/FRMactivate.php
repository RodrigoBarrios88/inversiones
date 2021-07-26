<?php
	include_once('html_fns_valida.php');
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
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/menu.css" rel="stylesheet">

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

</head>
<body style = "background-color:#fff;">
 
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
				<p class="navbar-text navbar-right"></p>
			</div><!--/.nav-collapse -->
	    </div><!--/.container-fluid -->
	</nav>
  
	<br>
	  <!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
		<form name = "f1" id = "f1" action = "EXEactivate.php" method = "post" >
			<div class="row">
			    <div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
			</div>
            <div class="row">
				<div class="col-xs-8 col-xs-offset-2 text-center"><label>
					<i class="fa fa-info-circle text-info fa-3x"></i>
					<h2>Hola, para activar su usuario, por favor agregue una contrase&ntilde;a.</h2>
					
				</div>
			</div>
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-group"></i> Datos de Perfil</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-2 col-xs-offset-2 text-right"><label>Nombre en Pantalla: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control text-libre" name = "nom" id = "nom" value = "" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-2 text-right"><label>Correo Electr&oacute;nico: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control" name = "mail" id = "mail" value = "<?php echo $mail; ?>" />
							<input type = "hidden" name = "tel" id = "tel" value = "<?php echo $tel; ?>" />
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
					<small class="col-xs-2 col-xs-offset-10">Copyright &copy; ID 2017.</small>
					</div>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-lock"></i> Seguridad</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-3 col-xs-offset-1 text-right"><label>Usuario: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control text-libre" name = "usu" id = "usu" value = "<?php echo $usu; ?>" readonly />
							<input type = "hidden" name = "cod" id = "cod" value = "<?php echo $cod; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-1 text-right"><label>Nuevo Password: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "password" class = "form-control text-libre" name = "pass1" id = "pass1" onkeyup = "comprueba_vacios(this,'pas1')"/>
						</div>
						<div class="col-xs-1"><span id = "pas1"></span></div>
					</div>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-1 text-right"><label>Confirme el Nuevo Password: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "password" class = "form-control text-libre" name = "pass2" id = "pass2" onkeyup = "comprueba_iguales(this,document.f1.pass1);"/>
						</div>
						<div class="col-xs-1"><span id = "pas2"></span></div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-1 text-right"><small>Fortaleza de la Contrase&ntilde;a</small></div>
						<div class="col-xs-4">
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
						<small class="col-xs-2 col-xs-offset-10">Copyright &copy; ID 2017.</small>
					</div>
					<input type = "hidden" name = "preg" id = "preg" />
					<input type = "hidden" name = "resp" id = "resp" />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2 text-center">
					<br>
					<button type="button" class="btn btn-primary" onclick = "aceptar();"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>	
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
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/usuario.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/cambiapass.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
    
</body>

</html>