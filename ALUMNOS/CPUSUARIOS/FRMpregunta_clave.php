<?php
	include_once('xajax_funct_usuarios.php');
	
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
    <title> Ayuda </title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	?>
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
				<div class="col-xs-12 col-md-12 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center"><label>
					<i class="fa fa-info-circle fa-3x text-info"></i> 
					<h2>Recuperaci&oacute;n de Contrase&ntilde;a</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center"><label>
					<p align = "justify">
						Estimado Usuario, para nosotros es un gusto servirle y prestarle apoyo en su trabajo diario dentro del sistema.<br><br>
						Por normativos de seguridad, se le preguntaran ciertos datos propios de su cuenta para comprobar que usted es el titular de la misma, 
						si tiene algun problema con este formulario o alguna duda sobre el procedimiento, le sugerimos que contacte al administrador del sistema
						por medio del siguiente link: 
						<a href = "FRMcontact_admin.php" title = "Click aqui para Contactar al Administrador..." ><b>Contactar al Administrador</b></a>.
					</p>
				</div>
			</div>
			<br>
			<form name = "f1" id = "f1" method = "post" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-user"></i> Datos de Perfil
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-2 col-md-offset-2 text-right"><label>E-Mail: </label> <span class="text-danger">*</span></div>
						<div class="col-md-4 text-left">
							<input type = "text" class = "form-control" name = "email" id = "email" />
							<input type = "hidden" name = "tipo" id = "tipo" value = "3" />
							<input type = "hidden" name = "cod" id = "cod" />
							<input type = "hidden" name = "usu" id = "usu" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 text-center">
							<br>
							<button id = "bot2" type="button" class="btn btn-primary" onclick = "aceptar();"><span class="fas fa-paper-plane"></span> Enviar</button>	
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
					<small class="col-md-12 text-rigth">Copyright &copy; ID 2017.</small>
					</div>
				</div>
			</div>
			</form>
		</div>
    </div>
	<!-- /container -->
      

    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div id = "ModalDialog" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" width = "60px;" /></h4>
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