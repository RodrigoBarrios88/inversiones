<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
	
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
			$mail = $row["usu_mail"];
			$tel = $row["usu_telefono"];
			//---
			$usuario = $row["usu_usuario"];
			//--
			$preg = $row["usu_pregunta"];
			$resp = $row["usu_respuesta"];
			$resp = $ClsUsu->decrypt($resp,$usuario);
		}
	}
	
	$ClsPad = new ClsPadre();
	$result = $ClsPad->get_padre($dpi);
	if(is_array($result)){
		foreach($result as $row){
			$dpi = $row["pad_cui"];
			$tipodpi = trim($row["pad_tipo_dpi"]);
			$nombre = utf8_decode($row["pad_nombre"]);
			$apellido = utf8_decode($row["pad_apellido"]);
			$nombre_completo = "$nombre $apellido";
			$fecnac = trim($row["pad_fec_nac"]);
			$fecnac = ($fecnac != "0000-00-00")?$fecnac:date("Y-m-d");
			$fecnac = cambia_fecha($fecnac);
			//--
				$fecnacdia = substr($fecnac, 0, 2);
				$fecnacmes = substr($fecnac, 3, 2);
				$fecnacanio = substr($fecnac, 6, 4);
			//--
			$padreedad = Calcula_Edad($fecnac);
			$parentesco = trim($row["pad_parentesco"]);
			$ecivil = trim($row["pad_estado_civil"]);
			$nacionalidad = strtolower($row["pad_nacionalidad"]);
			$mail = strtolower($row["pad_mail"]);
			$telcasa = $row["pad_telefono"];
			$celular = $row["pad_celular"];
			$direccion = utf8_decode($row["pad_direccion"]);
			$departamento = utf8_decode($row["pad_departamento"]);
			$municipio = utf8_decode($row["pad_municipio"]);
			$trabajo = utf8_decode($row["pad_lugar_trabajo"]);
			$teltrabajo = $row["pad_telefono_trabajo"];
			$profesion = utf8_decode($row["pad_profesion"]);
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
	<link href="../assets.3.5.20/css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />
	
    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	
	<!-- Inpuut File Uploader libs -->
	<link href="../assets.3.5.20/css/lib/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="../assets.3.5.20/js/plugins/file-input/fileinput.js" type="text/javascript"></script>
    <script src="../assets.3.5.20/js/plugins/file-input/fileinput_locale_fr.js" type="text/javascript"></script>
    <script src="../assets.3.5.20/js/plugins/file-input/fileinput_locale_es.js" type="text/javascript"></script>
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
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
            <a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
        	<a class="navbar-brand2" href="#"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /></a>
			<button type="button"  class="navbar-toggle second-menu-toggler pull-right" id="second-menu-toggler" data-toggle="collapse" data-target="#second-menu">
				<i class="fa fa-th"></i>
			</button>
		</div>
        <nav class="collapse navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
                <li><a href="../menu.php"><i class="icon-home"></i> Inicio</a></li>
				<li class="active"><a href="FRMperfil.php"><i class="icon-user"></i> Perfil</a></li>
				<li><a href="../CPHIJOS/FRMhijos.php"><i class="icon-users"></i> Hijos</a></li>
				<li><a href="FRMfamilia.php"><i class="fas fa-users"></i> Familia</a></li>
				<li><a href="FRMseguridad.php"><i class="fas fa-shield-alt"></i> Seguridad</a></li>
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
                <div class="col-md-3 avatar-box text-center">
                    <div class="personal-image col-md-10 col-md-offset-1">
						<button type="button" class="btn btn-default btn-block" onclick = "window.location.reload();"><span class="fas fa-sync"></span></button>
						<br><br>
                        <img src="../../CONFIG/Fotos/<?php echo $foto; ?>" class="avatar img-circle" alt="avatar" width="175px" />
						<form action="EXEcarga_foto.php" name = "f1" name = "f1" method="post" enctype="multipart/form-data">
							<button type="button" class="btn-glow btn-block primary" onclick = "FotoJs();" title = "Cambiar Fotograf&iacute;a"><i class="fa fa-camera"></i> Cambiar Fotograf&iacute;a...</button>
							<input id="doc" name="doc" type="file" multiple="false" class = "hidden" onchange="Cargar();" >
							<input type="hidden" name="nom" id="nom" />
						</form>
					</div>
				</div>
                <!-- edit form column -->
                <div class="col-md-9 personal-info">
					<?php if($tipo == 3){ ?>
                    <div class="alert alert-info text-center" style="width: 100%">
                        <i class="icon-magic-wand"></i>
						<h4>Buenos d&iacute;as <strong><?php echo $nombre; ?></strong>!</h4>
                    </div>
                    <?php }else{ ?>
					<div class="alert alert-danger text-center" style="width: 100%">
                        <i class="icon-warning"></i>
                        Buenos d&iacute;as <strong><?php echo $nombre; ?></strong>! <br>
                        Usted como usuario Administrador no puede actualizar su informaci&oacute;n por este medio, debe realizarlo por en el Portal del Colegio.
					</div>
					<?php } ?>
					<div class="panel panel-default">
						<div class="panel-heading"> 
							<i class="fa fa-user"></i> Actualizar Informaci&oacute;n de Perfil
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-5 col-lg-offset-1">
									<button type ="button" class="btn btn-default" onclick="window.history.back();">
										<i class="fa fa-chevron-left"></i> Regresar
									</button>
								</div>
								<div class="col-lg-5 text-right text-danger">* Campos Obligatorios</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-lg-offset-1"></div>
								<div class="col-lg-5 text-right">
									<button type ="button" class="btn btn-warning btn-outline" onclick="datosFamilia(<?php echo $dpi; ?>);">
										<i class="fa fa-copy"></i> Utilizar datos de familiar
									</button>
								</div>
							</div>
							<br>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>DPI:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "dpi" name = "dpi" value="<?php echo $dpi; ?>" readonly />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Tipo de ID:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<select class="form-control" id = "tipodpi" name = "tipodpi" >
										<option value = "">Seleccione</option>
										<option value = "DPI">DPI</option>
										<option value = "PASAPORTE">PASAPORTE</option>
									</select>
									<script>
										document.getElementById("tipodpi").value = '<?php echo $tipodpi; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Nombres:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "nombre" name = "nombre" value="<?php echo $nombre; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Apellidos:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "apellido" name = "apellido" value="<?php echo $apellido; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Fecha de Nacimiento:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<div class='input-group date'>
										<?php echo input_fecha("fecnac","","valida_fecha('fecnac','');"); ?>
										<script>
											document.getElementById("fecnac").value = '<?php echo $fecnac; ?>';
											document.getElementById("fecnacdia").value = '<?php echo $fecnacdia; ?>';
											document.getElementById("fecnacmes").value = '<?php echo $fecnacmes; ?>';
											document.getElementById("fecnacanio").value = '<?php echo $fecnacanio; ?>';
										</script>
										<span class="input-group-addon">
											&nbsp; <span class="fa fa-calendar"></span> &nbsp;
										</span>
									</div>
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Edad:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "edad" name = "edad" value="<?php echo $padreedad; ?> A&Ntilde;O(S)" readonly />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Parentesco:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<select class="form-control" name = "parentesco" id = "parentesco" >
										<option value = "">Seleccione</option>
										<option value = "P">PADRE</option>
										<option value = "M">MADRE</option>
										<option value = "A">ABUELO(A)</option>
										<option value = "O">ENCARGADO</option>
									</select>
									<script>
										document.getElementById("parentesco").value = '<?php echo $parentesco; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Estado Civil:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<select class="form-control" name = "ecivil" id = "ecivil" >
										<option value = "">Seleccione</option>
										<option value = "S">SOLTERO(A)</option>
										<option value = "C">CASADO(A)</option>
									</select>
									<script>
										document.getElementById("ecivil").value = '<?php echo $ecivil; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Nacionalidad:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "nacionalidad" name = "nacionalidad" value="<?php echo $nacionalidad; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>E-mail:</label> </div>
								<div class="col-lg-6">
									<input class="form-control text-libre" type="text" id = "mail" name = "mail" value="<?php echo $mail; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Direcci&oacute;n:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "direccion" name = "direccion" value="<?php echo $direccion; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Departamento:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6">
									<?php echo departamento_html('departamento',"xajax_depmun(this.value,'municipio','divmun');"); ?>
									<script>
										document.getElementById("departamento").value = '<?php echo $departamento; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Municipio:</label> <span class = "text-danger">*</span></div>
								<div class="col-lg-6" id = "divmun">
									<?php
										if($departamento != ""){
											echo municipio_html($departamento,'municipio','');
										}else{
											echo combos_vacios("municipio");
										}
									?>
									<script>
										document.getElementById("municipio").value = '<?php echo $municipio; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Tel&eacute;fono Casa:</label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "telcasa" name = "telcasa" value="<?php echo $telcasa; ?>" onkeyup = "enterosExtremos(this);" maxlength = "8" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Celular:</label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "celular" name = "celular" value="<?php echo $celular; ?>" onkeyup = "enterosExtremos(this);" maxlength = "8" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Lugar de Trabajo:</label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "trabajo" name = "trabajo" value="<?php echo $trabajo; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Tel&eacute;fono de Trabajo:</label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "teltrabajo" name = "teltrabajo" value="<?php echo $teltrabajo; ?>" onkeyup = "enterosExtremos(this);" maxlength = "8" />
								</div>
							</div>
							<div class = "row">
								<div class="col-lg-4 col-md-offset-1"><label>Profesi&oacute;n u Oficio:</label> </div>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "profesion" name = "profesion" value="<?php echo $profesion; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<hr>
							<div class="row">
								<label class="col-lg-4 col-md-offset-1">Nombre en Pantalla:</label>
								<div class="col-lg-6">
									<input class="form-control text-libre" type="text" id = "nompant" name = "nompant" value="<?php echo $nombre_pantalla; ?>" onkeyup="texto(this);" />
									<input type = "hidden" name = "usuid" id = "usuid" value="<?php echo $id; ?>" />
								</div>
							</div>
							<div class="row">
								<label class="col-lg-4 col-md-offset-1">Usuario: <span class = "text-danger">*</span></label>
								<div class="col-lg-6">
									<input class="form-control text-libre" type="text" id = "usu" name = "usu" value="<?php echo $usuario; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class="row">
								<label class="col-lg-4 col-md-offset-1">Contrase&ntilde;a:</label>
								<div class="col-lg-6">
									<div class='input-group'>
									<input class="form-control" type="password" class="form-control text-libre" name = "pass1" id = "pass1" onkeyup = "comprueba_vacios(this,'pas1');" />
									<span class="input-group-addon" id = "pas1"></span>
									</div>
								</div>
							</div>
							 <div class="row">
								<label class="col-lg-4 col-md-offset-1">Confirmar Contrase&ntilde;a:</label>
								<div class="col-lg-6">
									<div class='input-group'>
									<input class="form-control" type="password" class="form-control text-libre" name = "pass2" id = "pass2" onkeyup = "comprueba_iguales(this,document.datos.pass1);" />
									<span class="input-group-addon" id = "pas2"></span>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-lg-4 col-md-offset-1"></label>
								<div class="col-lg-6">
									<div class="progress">
										<div id = "progress1" class="progress-bar progress-bar-danger progress-bar-striped" style="width: 0%"></div>
										<div id = "progress2" class="progress-bar progress-bar-warning progress-bar-striped" style="width: 0%"></div>
										<div id = "progress3" class="progress-bar progress-bar-success progress-bar-striped" style="width: 0%"></div>
									</div>
								</div>
							</div>
						   <hr>
							<div class="row">
								<label class="col-lg-4 col-md-offset-1">Pregunta Secreta:</label>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "preg" name = "preg" value="<?php echo $preg; ?>" />
								</div>
							</div>
							<div class="row">
								<label class="col-lg-4 col-md-offset-1">Respuesta:</label>
								<div class="col-lg-6">
									<input class="form-control" type="text" id = "resp" name = "resp" value="<?php echo $resp; ?>" />
								</div>
							</div>
							<hr>
							<div class = "row">
								<div class="col-lg-10 col-md-offset-1 text-center">
									<a class="btn-glow default" href = "FRMperfil.php" ><i class="fas fa-times"></i> Cancelar</a> &nbsp; 
									<button type="button" class="btn-glow primary" id = "grab" onclick = "ModificarPerfil();" <?php echo $disabled; ?> ><i class="fas fa-save"></i> Grabar</button>
								</div>
							</div>
						</div>
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
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="../assets.3.5.20/js/theme.js"></script>
	<script src="../assets.3.5.20/js/bootstrap.datepicker.js"></script>
    
	<!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/perfil/perfil.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	
	<script>
		$('#fecnac').datepicker().on('changeDate', function (ev) {
			$(this).datepicker('hide');
            xajax_Calcular_Edad( this.value, '');
		});
	</script>	
	
</body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>