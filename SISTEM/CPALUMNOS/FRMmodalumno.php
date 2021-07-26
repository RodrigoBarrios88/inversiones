<?php
	include_once('xajax_funct_alumno.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsAlu = new ClsAlumno();
	$ClsAsi = new ClsAsignacion();
	$ClsCli = new ClsCliente();
	$ClsAcadem = new ClsAcademico();
	$ClsSeg = new ClsSeguro();
	$cui = $ClsAlu->decrypt($hashkey, $usuario);
	
	$result = $ClsAlu->get_alumno($cui,"","",1);
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
			$clinombre = utf8_decode($row["alu_cliente_nombre"]);
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
		}
	}
	
	$result = $ClsAcadem->get_grado_alumno($pensum,'','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$nivel = trim($row["graa_nivel"]);
			$grado = trim($row["graa_grado"]);
		}
	}
	
	$result = $ClsAcadem->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);
	if(is_array($result)){
		foreach($result as $row){
			$seccion = trim($row["seca_seccion"]);
		}
	}
	
	if(file_exists('../../CONFIG/Fotos/ALUMNOS/'.$foto.'.jpg')){
		$foto = 'ALUMNOS/'.$foto.'.jpg';
	}else{
		$foto = "nofoto.png";
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
		
if($usuario != "" && $valida != ""){ 	
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<?php
		//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		$xajax->printJavascript("..");
	?>	
	<!-- CSS personalizado -->
	<link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Estilos Utilitarios -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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
<body>
   <div id="wrapper">
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header"> 
				 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					  <span class="sr-only"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
					  <span class="icon-bar"></span>
				 </button>
				 <?php echo $_SESSION["rotulos_colegio"]; ?>
			</div>
			<!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario de Perfil de Usuarios</a></li>
						<li class="divider"></li>
						<li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a></li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
				<li class="dropdown">
					 <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="glyphicon glyphicon-question-sign fa-fw"></i>  <i class="fa fa-caret-down"></i>
					 </a>
					 <ul class="dropdown-menu dropdown-user">
						<li><a href="#"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Ayuda</a></li>
					 </ul>
					 <!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
			</ul>
			<!-- /.navbar-top-links -->

			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<i class="glyphicon arrow"></i></a> 
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMnewalumno.php">
										<i class="fa fa-plus-circle"></i> Agregar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="FRMsecciones.php?acc=1">
										<i class="fa fa-edit"></i> Actualizar Datos de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=4">
										<i class="fa fa-list-alt"></i> Ficha T&eacute;cnica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../CPFICHAPRESCOOL/FRMsecciones.php">
										<i class="fa fa-file-text-o"></i> Ficha Preescolar
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=5">
										<i class="fa fa-comments"></i> Bit&aacute;cora Psicopedag&oacute;gica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=3">
										<i class="fa fa-camera"></i> Re-Ingreso de Fotograf&iacute;as
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=2">
										<i class="fa fa-group"></i> Asignaci&oacute;n Extracurricular
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=6">
										<i class="fa fa-ban"></i> Inhabilitar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMsecciones.php?acc=7">
										<i class="fa fa-check-circle-o"></i> Activar Alumnos
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMrepasiggrupo.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos/Grupos
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../menu.php">
										<i class="glyphicon glyphicon-list"></i> Men&uacute; Principal
									</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
					</ul>
				</div>
				<!-- /.sidebar-collapse -->
			</div>
			<!-- /.navbar-static-side -->
		</nav>
		
		<div id="page-wrapper">
		<form name = "f1" name = "f1" method="post" enctype="multipart/form-data">
			<br>
			<!-- .panel-default -->
         <div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-user"></i> Formulario de Actualizaci&oacute;n de Datos del Alumno
				</div>
            <div class="panel-body" id = "formulario">
					<div class="row">
						<div class="col-xs-5 col-lg-offset-1 col-xs-6">
							<button type ="button" class="btn btn-defaul" onclick="window.history.back();">
								<i class="fa fa-chevron-left"></i> Regresar
							</button>
						</div>
						<div class="col-xs-5 col-xs-6 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>CUI:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "cui" id = "cui" value = "<?php echo $cui; ?>" onkeyup = "enteros(this)" readonly />
						</div>	
						<div class="col-xs-5">
							<label>Tipo de Identificaci&oacute;n:  </label> <span class="text-danger">*</span>
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
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nombre:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "nombre" id = "nombre"  value = "<?php echo $nombre; ?>" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>Apellido:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "apellido" id = "apellido" value = "<?php echo $apellido; ?>" onkeyup = "texto(this)" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Fecha de Nacimiento:  </label> <span class="text-danger">*</span>
							<div class='input-group date'>
								<input type='text' class="form-control" id = "fecnac" name="fecnac" value = "<?php echo $fecnac; ?>" onblur="xajax_Calcular_Edad(this.value,'');" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>	
						<div class="col-xs-5">
							<label>Edad:  </label> <span class="text-danger">*</span>
							<strong class="form-control text-center" id = "sedad"><?php echo $edad; ?> a&ntilde;os</strong>
							<input type = "hidden" name = "edad" id = "edad" value = "<?php echo $edad; ?>" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Genero:  </label> <span class="text-danger">*</span>
							<select class="form-control" id = "genero" name = "genero" >
								<option value = "">Seleccione</option>
								<option value = "M">Ni&ntilde;o (M)</option>
								<option value = "F">Ni&ntilde;a (F)</option>
							</select>
							<script>
								document.getElementById("genero").value = '<?php echo $genero; ?>';
							</script>
						</div>
						<div class="col-xs-5">
							<label>Religi&oacute;n:  </label>
							<input class="form-control" type="text" id = "religion" name = "religion" value="<?php echo $religion; ?>" onkeyup="texto(this);" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nacionalidad:  </label>
							<input class="form-control" type="text" id = "nacionalidad" name = "nacionalidad" value="<?php echo $nacionalidad; ?>" onkeyup="texto(this);" />
						</div>
						<div class="col-xs-5">
							<label>Idioma Nativo:  </label>
							<input class="form-control" type="text" id = "idioma" name = "idioma" value="<?php echo $idioma; ?>" onkeyup="texto(this);" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Tipo de Sangre:  </label> <span class="text-danger">*</span>
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
						<div class="col-xs-5">
							<label>Al&eacute;rgico a:  </label>
							<input class="form-control" type="text" id = "alergia" name = "alergia" value="<?php echo $alergico; ?>" onkeyup="texto(this);" />
						</div>	
					</div>
					<div class = "row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>En una emergencia avisar a:</label>
							<input class="form-control" type="text" id = "emergencia" name = "emergencia" value="<?php echo $emergencia; ?>" onkeyup="texto(this);" />
						</div>
						<div class="col-xs-5">
							<label>Tel&eacute;fono de emergencia:</label>
							<input class="form-control" type="text" id = "emetel" name = "emetel" value="<?php echo $emergencia_tel; ?>" onkeyup="enteros(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Qui&eacute;n recoge en el colegio:</label>
							<input class="form-control" type="text" id = "recoge" name = "recoge" value="<?php echo $recoge; ?>" onkeyup="texto(this);" />
						</div>
						<div class="col-xs-5">
							<label>Autoriza publicar imagenes en redes Sociales:</label>
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
					<div class = "row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Email del Alumno: <small class="text-muted">(no aplica para preescolar)</small> </label>
							<input class="form-control" type="text" id = "mail" name = "mail" value="<?php echo $mail; ?>" onkeyup="texto(this);" />
						</div>
						<div class="col-xs-5">
							<label>C&oacute;digo Interno: <small class="text-muted">(Colegio/Instituci&oacute;n)</small> </label>
							<input type = "text" class = "form-control" name = "codigo" id = "codigo" value = "<?php echo $codigo; ?>" onkeyup = "enteros(this)" maxlength = "15"/>
						</div>	
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nivel:  </label> <span class="text-danger">*</span>
							<?php echo nivel_html($pensum,"nivel","xajax_Nivel_Grado($pensum,this.value,'grado','divgra','');"); ?>
							<input type="hidden" id = "pensum" name = "pensum" value = "<?php echo $pensum; ?>" />
							<script>
								document.getElementById("nivel").value = '<?php echo $nivel; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Grado:  </label> <span class="text-danger">*</span>
							<div id = "divgra">
							<?php
								if($nivel != ""){
									echo grado_html($pensum,$nivel,"grado","xajax_Grado_Seccion_Alumno($pensum,$nivel,this.value,'seccion','divsec');");
								}else{
									echo combos_vacios("grado");
								}	
							?>
							</div>
							<script>
								document.getElementById("grado").value = '<?php echo $grado; ?>';
							</script>
						</div>	
						<div class="col-xs-5">
							<label>Secci&oacute;n:  &nbsp;</label>
							<div id = "divsec">
							<?php
								if($nivel != "" && $grado != ""){
									echo seccion_html($pensum,$nivel,$grado,"","seccion","");
								}else{
									echo combos_vacios("seccion");
								}	
							?>
							</div>
							<script>
								document.getElementById("seccion").value = '<?php echo $seccion; ?>';
							</script>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nit a Facturar:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "nit" id = "nit"  value = "<?php echo $nit; ?>" onkeyup = "texto(this);" onblur = "Cliente('');" />
						</div>	
						<div class="col-xs-5">
							<label>Nombre del Cliente:  </label> <span class="text-danger">*</span>
							<input type="text" class="form-control" name = "clinombre" id = "clinombre" value = "<?php echo $clinombre; ?>"  onkeyup = "texto(this);" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Direcci&oacute;n de Facturaci&oacute;n:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "clidireccion" id = "clidireccion"  value = "<?php echo $clidireccion; ?>" onkeyup = "texto(this);" />
						</div>	
					</div>
					<hr>
					
					<div class = "row">
						<div class="col-xs-5 col-xs-offset-1">
						<label>El ni&ntilde;o(a) tiene seguro?</label> <span class = "text-danger">*</span>
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
					<div class = "row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>No. de Poliza:</label>
							<input class="form-control" type="text" id = "poliza" name = "poliza" value="<?php echo $poliza; ?>" onkeyup="texto(this);" />
						</div>
						<div class="col-xs-5">
						<label>Aseguradora:</label>
							<input class="form-control" type="text" id = "aseguradora" name = "aseguradora" value="<?php echo $aseguradora; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Plan:</label>
							<input class="form-control" type="text" id = "plan" name = "plan" value="<?php echo $plan; ?>" onkeyup="texto(this);" />
						</div>
						<div class="col-xs-5">
							<label>Asegurado Principal:</label>
							<input class="form-control" type="text" id = "asegurado" name = "asegurado" value="<?php echo $asegurado; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Instrucciones:</label>
							<textarea class="form-control" id = "instrucciones" name = "instrucciones" onkeyup="texto(this);" ><?php echo $instrucciones; ?></textarea>
						</div>
					</div>
					<div class = "row">
						<div class="col-xs-10 col-xs-offset-1">
							<label>Comentarios:</label>
							<textarea class="form-control" id = "comentarios" name = "comentarios" onkeyup="texto(this);" ><?php echo $comentarios; ?></textarea>
						</div>
					</div>
					<br>
				</div>
         </div>
			<!-- /.panel-default -->
			
			<!-- .panel-succes -->
			<div class="panel panel-success">
				<div class="panel-heading"><i class="fa fa-group"></i> Familiares </div>
				<div class="panel-body">
					<a href="FRMmaspadres.php?hashkey=<?php echo $hashkey; ?>" title="Agregar otro Padre, Madre o Encargado" class="btn btn-success btn-sm btn-outline pull-right"><i class="fa fa-plus"></i> Agregar</a>
					<br>
					<ins class="text-success"><i class="fa fa-group"></i> Padre/Madre o Encargados</ins>
					<?php echo tabla_padres($cui); ?>
					<hr>
					<ins class="text-success"><i class="fa fa-group"></i> Hermanos</ins>
					<?php echo tabla_hermanos($cui); ?>
				</div>
			</div>
			<!-- /.panel-success -->
			
			<!-- .panel-default -->
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /.panel-default -->
			<br>
		</form>
		</div>
		<!-- /#page-wrapper -->
   </div>
   <!-- /#wrapper -->
	
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
    
	<!-- Bootstrap Core JavaScript -->
	<script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	
	<!-- DataTables JavaScript -->
	<script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
	
	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/alumno.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-padres').DataTable({
				responsive: true
			});
		});
		$(document).ready(function() {
			$('#dataTables-hermanos').DataTable({
				responsive: true
			});
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