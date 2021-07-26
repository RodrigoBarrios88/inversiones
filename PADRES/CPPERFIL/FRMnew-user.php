<?php
	include_once('xajax_funct_perfil.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($id);
	if(is_array($result)){
		foreach($result as $row){
			$tipo = trim($row["usu_tipo"]);
			$dpi = trim($row["usu_tipo_codigo"]);
			$nombre = trim($row["usu_nombre"]);
			$nombre_pantalla = utf8_decode($row["usu_nombre_pantalla"]);
		}
	}
	
	//$_POST
	$ClsUsu = new ClsUsuario();
	$foto = $ClsUsu->last_foto_usuario($id);
	
	if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg') && $foto != ""){
		$foto = 'USUARIOS/'.$foto.'.jpg';
	}else{
		$foto = "nofoto.png";
	}
	
	$disabled = ($tipo != 3)?"disabled":""; 
	
if($tipo != "" && $nombre != ""){	
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
    <link rel="shortcut icon" href="../../CONFIG/images/logo.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	?>
	
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
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	
	<!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/user-list.css" type="text/css" media="screen" />
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="../assets.3.5.20/css/compiled/personal-info.css" type="text/css" media="screen" />

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
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
            <a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
        	<a class="navbar-brand2" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
			<button type="button"  class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>
        <nav class="collapse navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
                <li><a href="../menu.php"><i class="icon-home"></i> Inicio</a></li>
				<li><a href="FRMperfil.php"><i class="icon-user"></i> Perfil</a></li>
				<li><a href="../CPHIJOS/FRMhijos.php"><i class="icon-users"></i> Hijos</a></li>
				<li class="active"><a href="FRMfamilia.php"><i class="fas fa-users"></i> Familia</a></li>
				<li><a href="FRMseguridad.php"><i class="fas fa-shield-alt"></i> Seguridad</a></li>
			</ul>
        </nav>        
    </header>
    <!-- end navbar -->

	<!-- main container .wide-content is used for this layout without sidebar :)  -->
    <div class="content wide-content">
        <div class="settings-wrapper" id="pad-wrapper">
            <div class="row">
                <!-- avatar column -->
                <div class="col-md-3 avatar-box">
                    <div class="personal-image col-md-10 col-md-offset-1">
                        <img src="../../CONFIG/Fotos/<?php echo $foto; ?>" class="avatar img-circle" alt="avatar" width="175px" />
					</div>
				</div>
                <!-- edit form column -->
                <div class="col-md-9 personal-info">
					<?php if($tipo == 3){ ?>
                    <div class="alert alert-info" style="width: 100%">
                        <i class="fa fa-question-circle fa-2x"></i> &nbsp; 
						Un nuevo usuario <strong><?php echo $nombre; ?></strong>?<br>
                         &nbsp;Solo te pedimos algunos datos iniciales, el resto los actualizara el usuario al ingresar por primera vez...
                    </div>
                    <?php }else{ ?>
					<div class="alert alert-danger" style="width: 100%">
                        <i class="icon-warning"></i>
                        Buenos d&iacute;as <strong><?php echo $nombre; ?></strong>! <br>
                        Usted como usuario Administrador no puede crear mas usuarios por este medio, debe realizarlo por en el Portal del Colegio.
					</div>
					<?php } ?>
                    <h5 class="personal-title">Perfil de Inscripci&oacute;n</h5>

                    	<div class="row">
                            <label class="col-lg-4 control-label">DPI:</label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" id = "dpi" name = "dpi" onkeyup = "enterosExtremos(this);" maxlength = "13" />
								<input type="hidden" id = "cod" name = "cod" value="<?php echo $id; ?>" />
								<input type="hidden" id = "padre" name = "padre" value="<?php echo $dpi; ?>" />
							</div>
                        </div>
                        <div class="row">
                            <label class="col-lg-4 control-label">Nombre:</label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" id = "nom" name = "nom" onkeyup="texto(this);" />
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-4 control-label">Apellido:</label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" id = "ape" name = "ape" onkeyup="texto(this);" />
                            </div>
                        </div>
						<div class="row">
                            <label class="col-lg-4 control-label">Parentesco:</label>
                            <div class="col-lg-6">
                                <select class="form-control" name = "parentesco" id = "parentesco" >
									<option value = "">Seleccione</option>
									<option value = "P">PADRE</option>
									<option value = "M">MADRE</option>
									<option value = "A">ABUELO(A)</option>
									<option value = "O">ENCARGADO (OTRO)</option>
								</select>
                            </div>
                        </div>
						<div class="row">
                            <label class="col-lg-4 control-label">Email (Usuario):</label>
                            <div class="col-lg-6">
                                <input class="form-control text-libre" type="text" id = "mail" name = "mail" />
                            </div>
                        </div>
						<div class="row">
                            <label class="col-lg-4 control-label">Tel&eacute;fono:</label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" id = "tel" name = "tel" onkeyup="enteros(this);" />
                            </div>
                        </div>
						<br>
						<h4 class="personal-title">Listado de hijos a autorizar el accesos</h6>
						<div class="row">
                            <div class="col-lg-12">
								<?php echo tabla_hijos($dpi); ?>
                            </div>
                        </div>
						<div class="actions">
							<a class="btn-glow default" href = "FRMnew-user.php" ><i class="fas fa-times"></i> Cancelar</a> 
							&nbsp;
                            <button class="btn-glow primary" id = "grab" onclick = "NewUser();" <?php echo $disabled; ?> ><i class="fas fa-save"></i> Grabar</button>
                        </div>
                   
                </div>
            </div>            
        </div>
    </div>
    <!-- end main container -->
	
	
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


	<!-- scripts -->
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/theme.js"></script>
	
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/perfil/perfil.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>