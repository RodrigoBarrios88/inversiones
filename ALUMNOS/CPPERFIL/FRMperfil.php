<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
	
	include_once('xajax_funct_perfil.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
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
	
	$ClsAlu = new ClsAlumno();
	$ClsCli = new ClsCliente();
	$ClsAsi = new ClsAsignacion();
	$ClsSeg = new ClsSeguro();
	$result = $ClsAlu->get_alumno($tipo_codigo);
	if(is_array($result)){
		foreach($result as $row){
			$cui = trim($row["alu_cui"]);
			$tipocui = trim($row["alu_tipo_cui"]);
			$codigo = trim($row["alu_codigo_interno"]);
			//pasa a mayusculas
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
			$nombre_completo = ucwords(strtolower($nombre." ".$apellido));
			//--------
			$fecnac = cambia_fecha($row["alu_fecha_nacimiento"]);
			//--
				$fecnacdia = substr($fecnac, 0, 2);
				$fecnacmes = substr($fecnac, 3, 2);
				$fecnacanio = substr($fecnac, 6, 4);
			//--
			$edad = Calcula_Edad(cambia_fecha($row["alu_fecha_nacimiento"]));
			$genero = trim($row["alu_genero"]);
			$nacionalidad = utf8_decode($row["alu_nacionalidad"]);
			$religion = utf8_decode($row["alu_religion"]);
			$idioma = utf8_decode($row["alu_idioma"]);
			$mail = trim($row["alu_mail"]);
			$nit = trim($row["alu_nit"]);
			$clinombre= utf8_decode($row["alu_cliente_nombre"]);
			$clidireccion = utf8_decode($row["alu_cliente_direccion"]);
			//--
			$sangre = trim($row["alu_tipo_sangre"]);
			$alergico = utf8_decode($row["alu_alergico_a"]);
			$emergencia = utf8_decode($row["alu_emergencia"]);
			$emergencia_tel = trim($row["alu_emergencia_telefono"]);
			$recoge = utf8_decode($row["alu_recoge"]);
			$redesociales = trim($row["alu_redes_sociales"]);
			//--
			$seguro = trim($row["tiene_seguro"]);
			$poliza = utf8_decode($row["poliza"]);
			$aseguradora = utf8_decode($row["aseguradora"]);
			$plan = utf8_decode($row["plan"]);
			$asegurado_principla = utf8_decode($row["asegurado_principla"]);
			$instrucciones = utf8_decode($row["instrucciones"]);
			$comentario = utf8_decode($row["comentario"]);
			//---
			$foto = trim($row["alu_foto"]);
			if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){
				$foto = 'ALUMNOS/'.$foto.'.jpg';
			}else{
				$foto = "nofoto.png";
			}
		}
		
		//////SEGURO
		$result = $ClsSeg->get_seguro($cui);
		if(is_array($result)){
			foreach($result as $row){
				$seguro = utf8_decode($row["seg_tiene_seguro"]);
				$poliza = utf8_decode($row["seg_poliza"]);
				$aseguradora = utf8_decode($row["seg_aseguradora"]);
				$plan = utf8_decode($row["seg_plan"]);
				$asegurado = utf8_decode($row["seg_asegurado_principal"]);
				$instrucciones = utf8_decode($row["seg_instrucciones"]);
				$comentarios = utf8_decode($row["seg_comentarios"]);
			}
		}
	}
	
	$disabled = ($tipo != 10)?"disabled":""; 
	
if($tipo_codigo != "" && $nombre != ""){
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
				<!--li><a href="../CPHIJOS/FRMhijos.php"><i class="icon-users"></i> Hijos</a></li-->
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
                    <div class="personal-image col-md-10">
						<img src="../../CONFIG/Fotos/<?php echo $foto; ?>" class="avatar img-circle" alt="avatar" width="175px" />
					</div>
				</div>
                <!-- edit form column -->
                <div class="col-md-9 personal-info">
					<?php if($tipo == 10){ ?>
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
								<div class="col-lg-6">
									<button type ="button" class="btn btn-default" onclick="window.history.back();">
										<i class="fa fa-chevron-left"></i> Regresar
									</button>
								</div>
								<div class="col-lg-6 text-right text-danger">* Campos Obligatorios</div>
							</div>
							<br>
							<div class = "row">
								<div class="col-md-5"><label>CUI:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<div class="form-info"><?php echo $cui; ?></div>
									<input type="hidden" id = "cui" name = "cui" value="<?php echo $cui; ?>" />
									<input type="hidden" id = "codigo" name = "codigo" value="<?php echo $codigo; ?>" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Tipo de Identificaci&oacute;n:</label> <span class = "text-danger">*</span></div>
								<div class="col-xs-7">
									<select class="form-control" id = "tipocui" name = "tipocui" >
										<option value = "">Seleccione</option>
										<option value = "CUI">CUI (RENAP)</option>
										<option value = "PASAPORTE">Pasaporte</option>
									</select>
									<script>
										document.getElementById("tipocui").value = '<?php echo $tipocui; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Nombres:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "nombre" name = "nombre" value="<?php echo $nombre; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Apellidos:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "apellido" name = "apellido" value="<?php echo $apellido; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Genero:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<select class="form-control" id = "genero" name = "genero" >
										<option value = "">Seleccione</option>
										<option value = "M">Ni&ntilde;o (M)</option>
										<option value = "F">Ni&ntilde;a (F)</option>
									</select>
									<script>
										document.getElementById("genero").value = '<?php echo $genero; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Fecha de Nacimiento:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<div class='input-group date'>
										<?php echo input_fecha("fecnac","$i","valida_fecha('fecnac','$i');"); ?>
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
								<div class="col-md-5"><label>Edad:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "edad" name = "edad" value="<?php echo $edad; ?>" readonly />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Nacionalidad:</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "nacionalidad" name = "nacionalidad" value="<?php echo $nacionalidad; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Religi&oacute;n:</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "religion" name = "religion" value="<?php echo $religion; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Idioma Nativo :</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "idioma" name = "idioma" value="<?php echo $idioma; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Email del Alumno: <small class="text-muted">(no aplica para preescolar)</small> </label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "mail" name = "mail" value="<?php echo $mail; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>T&iacute;po de Sangre:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<select class="form-control" id = "sangre" name = "sangre" >
										<option value = "">Seleccione</option>
										<option value = "O+">O Rh +</option>
										<option value = "O-">O Rh -</option>
										<option value = "A+">A Rh +</option>
										<option value = "A-">A Rh -</option>
									   <option value = "B+">B Rh +</option>
									   <option value = "B-">B Rh -</option>
									   <option value = "AB+">AB Rh +</option>
									   <option value = "AB-">AB Rh -</option>
									</select>
									<script>
										document.getElementById("sangre").value = '<?php echo $sangre; ?>';
									</script>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Al&eacute;rgico A:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "alergia" name = "alergia" value="<?php echo $alergico; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>En una emergencia avisar a:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "emergencia" name = "emergencia" value="<?php echo $emergencia; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Telefono de emergencia:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input class="form-control text-libre" type="text" id = "emetel" name = "emetel" value="<?php echo $emergencia_tel; ?>" onkeyup="enteros(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Qui&eacute;n recoge en el colegio:</label></div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "recoge" name = "recoge" value="<?php echo $recoge; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Autoriza publicar imagenes en redes Sociales:</label></div>
								<div class="col-md-7">
									<select class="form-control" id = "redsoc" name = "redsoc" >
										<option value = "">Seleccione</option>
										<option value = "Si" selected >Si</option>
										<option value = "No">No</option>
									</select>
									<script>
										document.getElementById("redsoc").value = '<?php echo $redesociales; ?>';
									</script>
								</div>
							</div>
							<hr>
							<div class = "row">
								<div class="col-md-5"><label>Nit a Facturar:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input type = "text" class = "form-control" name = "nit" id = "nit"  value = "<?php echo $nit; ?>" onkeyup = "texto(this);" onblur = "Cliente(1);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Nombre a Facturar:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input type="text" class="form-control" name = "clinombre" id = "clinombre" value = "<?php echo $clinombre; ?>" onkeyup = "texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Direcci&oacute;n de Facturaci&oacute;n:</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									<input type="text" class="form-control" name = "clidireccion" id = "clidireccion" value = "<?php echo $clidireccion; ?>" onkeyup = "texto(this);" />
								</div>
							</div>
							<hr>
							<div class = "row">
								<div class="col-md-5"><label>El ni&ntilde;o(a) tiene seguro?</label> <span class = "text-danger">*</span></div>
								<div class="col-md-7">
									&nbsp; <label><input type="radio" id = "segurosi" name = "seguro" onclick="valida_seguro();" /><label for="segurosi" id = "labelsi" > Si</label></label>
									&nbsp; <label><input type="radio" id = "segurono" name = "seguro" onclick="valida_seguro();" /><label for="segurono" id = "labelno" > No</label></label>
									<script>
										var sino = <?php echo $seguro; ?>;
										if(sino == 1){
											document.getElementById("segurosi").checked = true;
										}else if(sino == 0){
											document.getElementById("segurono").checked = true;
										}
										
									</script>
								</div>
							</div>
							<br>
							<div class = "row">
								<div class="col-md-5"><label>No. de Poliza:</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "poliza" name = "poliza" value="<?php echo $poliza; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Aseguradora:</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "aseguradora" name = "aseguradora" value="<?php echo $aseguradora; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Plan:</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "plan" name = "plan" value="<?php echo $plan; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Asegurado Principal:</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "asegurado" name = "asegurado" value="<?php echo $asegurado; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Instrucciones:</label> </div>
								<div class="col-md-7">
									<textarea class="form-control" id = "instrucciones" name = "instrucciones" onkeyup="texto(this);" ><?php echo $instrucciones; ?></textarea>
								</div>
							</div>
							<div class = "row">
								<div class="col-md-5"><label>Comentarios:</label> </div>
								<div class="col-md-7">
									<textarea class="form-control" id = "comentarios" name = "comentarios" onkeyup="texto(this);" ><?php echo $comentarios; ?></textarea>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-5"><label>Nombre en Pantalla:</label> </div>
								<div class="col-md-7">
									<input class="form-control text-libre" type="text" id = "nompant" name = "nompant" value="<?php echo $nombre_pantalla; ?>" onkeyup="texto(this);" />
									<input type = "hidden" name = "usuid" id = "usuid" value="<?php echo $id; ?>" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-5"><label>Usuario: <span class = "text-danger">*</span></label> </div>
								<div class="col-md-7">
									<input class="form-control text-libre" type="text" id = "usu" name = "usu" value="<?php echo $usuario; ?>" onkeyup="texto(this);" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-5"><label>Contrase&ntilde;a:</label> </div>
								<div class="col-md-7">
									<div class='input-group'>
									<input class="form-control" type="password" class="form-control text-libre" name = "pass1" id = "pass1" onkeyup = "comprueba_vacios(this,'pas1');" />
									<span class="input-group-addon" id = "pas1"></span>
									</div>
								</div>
							</div>
							 <div class="row">
								<div class="col-md-5"><label>Confirmar Contrase&ntilde;a:</label> </div>
								<div class="col-md-7">
									<div class='input-group'>
									<input class="form-control" type="password" class="form-control text-libre" name = "pass2" id = "pass2" onkeyup = "comprueba_iguales(this,document.datos.pass1);" />
									<span class="input-group-addon" id = "pas2"></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5"><label></label> </div>
								<div class="col-md-7">
									<div class="progress">
										<div id = "progress1" class="progress-bar progress-bar-danger progress-bar-striped" style="width: 0%"></div>
										<div id = "progress2" class="progress-bar progress-bar-warning progress-bar-striped" style="width: 0%"></div>
										<div id = "progress3" class="progress-bar progress-bar-success progress-bar-striped" style="width: 0%"></div>
									</div>
								</div>
							</div>
						   <hr>
							<div class="row">
								<div class="col-md-5"><label>Pregunta Secreta:</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "preg" name = "preg" value="<?php echo $preg; ?>" />
								</div>
							</div>
							<div class="row">
								<div class="col-md-5"><label>Respuesta:</label> </div>
								<div class="col-md-7">
									<input class="form-control" type="text" id = "resp" name = "resp" value="<?php echo $resp; ?>" />
								</div>
							</div>
							<hr>
							<div class = "row">
								<div class="col-lg-10 text-center">
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