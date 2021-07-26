<?php
	include_once('../validacion.php');
	include_once('html_fns_usuarios.php');
	$nombre_pantalla = $_SESSION["nombre_pantalla"];
	$empresa = $_SESSION["empresa"];
	$cod = $_SESSION["codigo"];
	$usu = $_SESSION["usu"];
	
if($cod != ""){ 	
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($cod);
	if(is_array($result)){
		foreach($result as $row){
			$nombre_pantalla = utf8_decode($row["usu_nombre"]);
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
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="../logout.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a></li>
		  </ul>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<p class="navbar-text navbar-right" style="color:#fff"><strong>Nombre del Usuario:</strong> <?php echo $nombre_pantalla; ?></p>
	       </div><!--/.nav-collapse -->
	      </div><!--/.container-fluid -->
	    </nav>
  
	<br>
	  <!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
		<form name = "f1" id = "f1" action = "EXEcambia_pass.php" method = "post" >
			<div class="row">
			    <div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
			</div>
                        <div class="row">
				<div class="col-xs-8 col-xs-offset-2 text-center"><label>
					<br/>
					<h2>Usted ingreso al sistema por primera vez, por favor cambie su contrase&ntilde;a.</h2>
					<br/>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">Datos de Perfil</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-2 col-xs-offset-2 text-right"><label>Nombre en Pantalla: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control text-libre" name = "nom" id = "nom" value = "<?php echo $nombre_pantalla; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-2 text-right"><label>Correo Electr&oacute;nico: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control text-libre" name = "mail" id = "mail" value = "<?php echo $mail; ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-2 text-right"><label>Celular: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control" name = "tel" id = "tel" value = "<?php echo $tel; ?>" />
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
				<div class="panel-heading">Seguridad</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-3 col-xs-offset-1 text-right"><label>Usuario: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control text-libre" name = "usu" id = "usu" value = "<?php echo $usu; ?>" />
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
							<input type = "password" class = "form-control text-libre" name = "pass2" id = "pass2" onkeyup = "comprueba_iguales(this,document.f1.pass1)"/>
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
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">Pregunta Clave (Recuperaci&oacute;n de Contrase&ntilde;a)</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-8 col-xs-offset-2 text-right">
							<p class = "text-justify" >Si usted olvida su usuario o contrase&ntilde;a, podra recuperrarla, 
							recibiendo un correo electronico al seleccionar la pregunta clave y validar la respuesta correcta.
							&iquest; Desea elegir la Pregunta Clave y Respuesta respuesta a utilizar en dichos casos? (si ya le eligio con anterioridad no es necesario cambiarla...).</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-2 text-right"><label>Pregunta Clave: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control" name = "preg" id = "preg" onkeyup = "texto(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2 col-xs-offset-2 text-right"><label>Respuesta: </label> <span class="text-danger">*</span></div>
						<div class="col-xs-4 text-left">
							<input type = "text" class = "form-control" name = "resp" id = "resp" />
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
					<small class="col-xs-2 col-xs-offset-10">Copyright &copy; ID 2017.</small>
					</div>
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
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>