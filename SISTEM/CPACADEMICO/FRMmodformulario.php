<?php
	include_once('xajax_funct_formulario.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["FISP"];
	
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsPer = new ClsPersonal();
	$catalogo = $ClsPer->decrypt($hashkey, $usuario);
	$result = $ClsPer->get_personal('',$catalogo);
	if(is_array($result)){
		foreach($result as $row){
			//rrhh_personal 
			$codigo = $row["per_codigo"];
			$per_codigo = $row["per_codigo"];
			$per_catalogo = $row["per_catalogo"];
			$per_serie = $row["per_serie"];
			$per_promocion = $row["per_promocion"];
			$per_antiguedad = $row["per_antiguedad"];
			$per_grado = $row["per_grado"];
			$per_arma = $row["per_arma"];
			$per_nombres = $row["per_nombres"];
			$per_apellidos = $row["per_apellidos"];
			$per_dpi = $row["per_dpi"];
			$per_nit = $row["per_nit"];
			$per_profesion = $row["per_profesion"];
			$per_religion = $row["per_religion"];
			$per_pasaporte_of = $row["per_pasaporte_of"];
			$per_pasaporte_per = $row["per_pasaporte_per"];
			$per_genero = $row["per_genero"];
			$per_ecivil = $row["per_ecivil"];
			$per_lugar_nac = $row["per_lugar_nac"];
			$per_pais_nac = $row["per_pais_nac"];
			$per_fecnac = $row["per_fecnac"];
			$per_edad = calcula_edad($per_fecnac);
			$per_fecnac = cambia_fecha($per_fecnac);
			$per_direccion_eventual = $row["per_direccion_eventual"];
			$per_depmun_eventual = $row["per_depmun_eventual"];
			$per_dep_eventual = substr($per_depmun_eventual, 0, strlen($per_depmun_eventual) - 2)."00";
			$per_telefono_eventual = $row["per_telefono_eventual"];
			$per_direccion_permanente = $row["per_direccion_permanente"]; 
			$per_depmun_permanente = $row["per_depmun_permanente"];
			$per_dep_permanente = substr($per_depmun_permanente, 0, strlen($per_depmun_permanente) - 2)."00";
			$per_telefono_permanente = $row["per_telefono_permanente"];
			$per_tipo_sangre = $row["per_tipo_sangre"];
			$per_alergico = $row["per_alergico"];
			$per_celular = $row["per_celular"];
			$per_mail = $row["per_mail"];
			$per_emergencia_nombre = $row["per_emergencia_nombre"];
			$per_emergencia_apellido = $row["per_emergencia_apellido"];
			$per_emergencia_dir = $row["per_emergencia_dir"];
			$per_emergencia_tel = $row["per_emergencia_tel"];
			$per_emergencia_cel = $row["per_emergencia_cel"];
			$per_fec_alta = $row["per_fec_alta"];
			$per_fec_alta = cambia_fecha($per_fec_alta);
			$per_lugar_alta = $row["per_lugar_alta"];
			$per_talla_camisa = $row["per_talla_camisa"];
			$per_talla_pantalon = $row["per_talla_pantalon"];
			$per_chumpa = $row["per_chumpa"];
			$per_talla_botas = $row["per_talla_botas"];
			$per_talla_gorra = $row["per_talla_gorra"];
			$per_estatura = $row["per_estatura"];
			$per_peso = $row["per_peso"];
			$per_tez = $row["per_tez"];
			$per_ojos = $row["per_ojos"];
			$per_nariz = $row["per_nariz"];
			$per_tipo_lic_veh = $row["per_tipo_lic_veh"];
			$per_num_lic_veh = $row["per_num_lic_veh"];
			$per_num_lic_moto = $row["per_num_lic_moto"];
			$per_num_lic_digecam = $row["per_num_lic_digecam"];
			$per_digecam_fecini = $row["per_digecam_fecini"];
			$per_digecam_fecfin = $row["per_digecam_fecfin"];
			$per_deportes = $row["per_deportes"];
			$per_fec_penales = $row["per_fec_penales"];
			$per_fec_penales = cambia_fecha($per_fec_penales);
			$per_fec_policiacos = $row["per_fec_policiacos"];
			$per_fec_policiacos = cambia_fecha($per_fec_policiacos);
			$per_status = $row["per_status"];
			if($per_status == "O"){
				$status1 = "checked";
			}else if($per_status == "C"){
				$status2 = "checked";
			}else if($per_status == "M"){
				$status3 = "checked";
			}else if($per_status == "E"){
				$status4 = "checked";
			}else if($per_status == "P"){
				$status5 = "checked";
			}
			//rrhh_economica   
			$eco_trabaja_conyugue = $row["eco_trabaja_conyugue"];
			$eco_sueldo_conyugue = $row["eco_sueldo_conyugue"];
			$eco_lugar_trabajo_conyuge = $row["eco_lugar_trabajo_conyuge"];
			$eco_cargas_familiares = $row["eco_cargas_familiares"];
			$eco_vivienda = $row["eco_vivienda"];
			$eco_pago_vivienda = $row["eco_pago_vivienda"];
			$eco_cuenta_banco = $row["eco_cuenta_banco"];
			$eco_banco = $row["eco_banco"];
			$eco_tarjeta = $row["eco_tarjeta"];
			$eco_operador_tarjeta = $row["eco_operador_tarjeta"];
			$eco_otros_ingresos = $row["eco_otros_ingresos"];
			$eco_monto_otros = $row["eco_monto_otros"];
			$eco_sueldo = $row["eco_sueldo"];
			$eco_descuentos = $row["eco_descuentos"];
			$eco_prestamos = $row["eco_prestamos"];
			$eco_saldo_prestamos = $row["eco_saldo_prestamos"];
			 //rrhh_penal  
			$pen_detenido = $row["pen_detenido"];
			$pen_motivo_detenido = $row["pen_motivo_detenido"];
			$pen_donde_detenido = $row["pen_donde_detenido"];
			$pen_cuando_detenido = $row["pen_cuando_detenido"];
			$pen_porque_detenido = $row["pen_porque_detenido"];
			$pen_fec_libertad = $row["pen_fec_libertad"];
			$pen_arraigado = $row["pen_arraigado"];
			$pen_motivo_arraigo = $row["pen_motivo_arraigo"];
			$pen_donde_arraigo = $row["pen_donde_arraigo"];
			$pen_cuando_arraigo = $row["pen_cuando_arraigo"];
			 //rrhh_laboral_anterior   
			$lab_empleo = $row["lab_empleo"];
			$lab_telefono = $row["lab_telefono"];
			$lab_direccion = $row["lab_direccion"];
			$lab_puesto = $row["lab_puesto"];
			$lab_sucursal = $row["lab_sucursal"];
			$lab_sueldo = $row["lab_sueldo"];
			$lab_fecha = $row["lab_fecha"];
			//rrhh_educacion
			$edu_catalogo = $row["edu_catalogo"];
			$edu_grado_primaria = $row["edu_grado_primaria"];
			$edu_lugar_primaria = $row["edu_lugar_primaria"];
			$edu_grado_secundaria = $row["edu_grado_secundaria"];
			$edu_lugar_secundaria = $row["edu_lugar_secundaria"];
			$edu_carrera_secundaria = $row["edu_carrera_secundaria"];
		}
	}	
	
if($nivel != "" && $nombre != "" && $usuario != ""){	
?>
<!DOCTYPE html>
<html lang="es">
  <head>
	 <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/icono.ico" >
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		?>
	<!-- Bootstrap -->
	<link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!--Librerias Utilitarias-->
	<link href="../assets.3.6.2/css/isp.css" rel="stylesheet">
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
  </head>
  <body onload="setTimeout(function(){ Instrucciones(); }, 500);">
	<div id="cuerpo" class="container-fluid" style = "width:95%">
		<form name='f1' id='f1' method='post' class="form-horizontal" role="form">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
				  <!-- Brand and toggle get grouped for better mobile display -->
				  <div class="navbar-header">
				    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				      <span class="sr-only"></span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				    </button>
				    <a class="navbar-brand" href="#"><img width="30px" src = "../../CONFIG/images/escudo.png"></a>
				  </div>
			      
				  <!-- Collect the nav links, forms, and other content for toggling -->
				  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				    <ul class="nav navbar-nav">
				      <li class="active"><a href="#">Nuevo ISP <span class="sr-only">(current)</span></a></li>
				      <li><a href="../menu.php">Menu</a></li>
				    </ul>
				  </div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
			
			<!--nav class="navbar navbar-default">
				<div class="row">
					<div class="col-xs-2 text-left"><img src = "../../CONFIG/images/escudo.png" width="100px" class="img-thumbnail"></div>
					<div class="col-xs-8 text-center"><img src = "../../CONFIG/images/rotulo_isp.png" width="500px"></div>
					<div class="col-xs-2 text-right"><img src = "../../CONFIG/images/medallon.png" width="100px" class="img-thumbnail"></div>
				</div-->
			<div class="panel panel-default">
			<div class="panel-heading">DATOS INDIVIDUALES</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<p class="text-muted text-center">Sitaci&oacute;n en la Instituci&oacute;n</p>
					<div class="row">
						<div class="col-xs-2">
							<div class="col-sm-3">
							  <input type="radio" class="radiobutton" id="radiosit1" name="radiosit" value = "O" <?php echo $status1; ?> onclick="Valida_Status(this);" />
							</div>
							<label class="col-sm-9 text-left">Oficiales</label>
						</div>
						<div class="col-xs-3">
							<div class="col-sm-3">
							  <input type="radio" class="radiobutton" id="radiosit2" name="radiosit" value = "C" <?php echo $status2; ?> onclick="Valida_Status(this);" />
							</div>
							<label class="col-sm-9 text-left">Cadetes</label>
						</div>
						<div class="col-xs-2">
							<div class="col-sm-3">
							  <input type="radio" class="radiobutton" id="radiosit3" name="radiosit" value = "M" <?php echo $status3; ?> onclick="Valida_Status(this);" />
							</div>
							<label class="col-sm-9 text-left">Catedraticos</label>
						</div>
						<div class="col-xs-2">
							<div class="col-sm-3">
							  <input type="radio" class="radiobutton" id="radiosit4" name="radiosit" value = "E" <?php echo $status4; ?> onclick="Valida_Status(this);" />
							</div>
							<label class="col-sm-9 text-left">Especialistas</label>
						</div>
						<div class="col-xs-3">
							<div class="col-sm-3 text-right">
							  <input type="radio" class="radiobutton" id="radiosit5" name="radiosit" value = "P" <?php echo $status5; ?> onclick="Valida_Status(this);" />
							</div>
							<label class="col-sm-9 text-left">Planilleros</label>
						</div>
					</div>
					<br>
					<p class="text-muted text-center">Militar</p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">C&oacute;digo &Uacute;nico: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
								<h5 class = "text-success"><?php echo $per_codigo; ?></h5>
							  <input type="hidden" id="cod" name="cod" value = "<?php echo $per_codigo; ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Cat&aacute;logo: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="cat" name="cat" placeholder="Cat&aacute;logo" value = "<?php echo $per_catalogo; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">No. Serie: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="serie" name="serie" placeholder="N&uacute;mero Serie" value = "<?php echo $per_serie; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Grado: <span class = "text-danger">*</span></label>
							<div class="col-sm-8" id = "divgrado">
								<?php
									if($per_status == "O"){
										echo grado_html('gra',1);
									}else if($per_status == "C"){
										echo grado_cadete_html('gra');
									}else if($per_status == "M"){
										echo grado_html('gra',3);
									}else if($per_status == "E"){
										echo grado_html('gra',4);
									}else if($per_status == "P"){
										echo grado_html('gra',0);
									}
								?>
								<script>
									document.getElementById("gra").value = <?php echo $per_grado; ?>; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Arma: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
								<?php echo arma_html('arm','Arma'); ?>
								<script>
									document.getElementById("arm").value = <?php echo $per_arma; ?>; 
								</script>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">No. Antiguedad: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="anti" name="anti" placeholder="N&uacute;mero Antiguedad" value = "<?php echo $per_antiguedad; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Promoci&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="promo" name="promo" placeholder="N&uacute;mero de Promoci&oacute;n" value = "<?php echo $per_promocion; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha de Alta: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
								<div class='input-group date'>
									<input type="text" class="form-control" id="fecalta" name="fecalta" placeholder="Fecha de Alta en el Ej&eacute;rcito" value = "<?php echo $per_fec_alta; ?>" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecalta'),'dd/mm/yyyy', this)" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecalta'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Lugar de Alta: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <?php echo dependencia_html('lugaralta','Lugar de Alta'); ?>
								<script>
									document.getElementById("lugaralta").value = <?php echo $per_lugar_alta; ?>;
									document.getElementById('lugaralta').disabled = true;
								</script>
							</div>
						</div>
					</div>
					<br><p class="text-muted text-center">Personal</p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nombres: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="nom" name="nom" placeholder="Nombres" value = "<?php echo $per_nombres; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Apellidos: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="ape" name="ape" placeholder="Apellidos" value = "<?php echo $per_apellidos; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Profesi&oacute;n u Oficio: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="profesion" name="profesion" placeholder="Profesi&oacute;n u Oficio" value = "<?php echo $per_profesion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Religi&oacute;n: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="religion" name="religion" placeholder="Religi&oacute;n" value = "<?php echo $per_religion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Genero: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
								<select id="genero" name="genero" class="form-control">
								      <option value = "">Genero</option>
								      <option value = "M">MASCULINO</option>
								      <option value = "F">FEMENINO</option>
								</select>
								<script>
									document.getElementById("genero").value = "<?php echo $per_genero; ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Estado Civil: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
								<select id="ecivil" name="ecivil" class="form-control">
								      <option value = "">Estado Civil</option>
								      <option value = "S">SOLTERO(A)</option>
								      <option value = "C">CASADO(A)</option>
								      <option value = "V">VIUDO(A)</option>
								      <option value = "D">DIVORCIADO(A)</option>
								</select>
								<script>
									document.getElementById("ecivil").value = "<?php echo $per_ecivil; ?>"; 
								</script>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha de Nac.: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
								<div class='input-group date'>
									<input type="text" class="form-control" id="fecnac" name="fecnac" placeholder="Fecha de Nacimiento" value = "<?php echo $per_fecnac; ?>" onchange="CalculaEdad(this.value,'edad')" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecnac'),'dd/mm/yyyy', this)" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecnac'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Edad: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad en A&ntilde;os" value = "<?php echo $per_edad; ?>" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Lugar de Nac.: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <?php echo departamento_html2('depn','Departamento de Nacimiento'); ?>
								<script>
									document.getElementById("depn").value = <?php echo $per_lugar_nac; ?>; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nacionalidad: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							   <?php echo Paises_html('paisn','Pa&iacute;s de Nacimiento o Nacionalidad'); ?>
								<script>
									document.getElementById("paisn").value = <?php echo $per_pais_nac; ?>; 
								</script>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Dir. Eventual: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="dir2" name="dir2" placeholder="Direcci&oacute;n Eventual" value = "<?php echo $per_direccion_eventual; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Tel. Eventual: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="tel2" name="tel2" placeholder="Tel&eacute;fono Eventual" value = "<?php echo $per_telefono_eventual; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Dep. Direcci&oacute;n: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <?php echo departamento_html2('depde','Departamento de Direccion Eventual',"xajax_depmun(this.value,'munde','Smunde')"); ?>
								<script>
									document.getElementById("depde").value = <?php echo $per_dep_eventual; ?>; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Mun. Direcci&oacute;n: <span class = "text-danger">*</span></label>
							<div class="col-sm-8" id = "Smunde">
								<?php echo municipio_html($per_dep_eventual,"munde",'Municipio'); ?>
								<script>
									document.getElementById("munde").value = <?php echo $per_depmun_eventual; ?>; 
								</script>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Dir. Permanente: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="dir1" name="dir1" placeholder="Direcci&oacute;n Permanente" value = "<?php echo $per_direccion_permanente; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Tel. Permanente: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="tel1" name="tel1" placeholder="Tel&eacute;fono Permanente" value = "<?php echo $per_telefono_permanente; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Dep. Direcci&oacute;n: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <?php echo departamento_html2('depdp','Departamento de Direccion Permanente',"xajax_depmun(this.value,'mundp','Smundp')"); ?>
								<script>
									document.getElementById("depdp").value = <?php echo $per_dep_permanente; ?>; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Mun. Direcci&oacute;n: <span class = "text-danger">*</span></label>
							<div class="col-sm-8" id = "Smundp">
								<?php echo municipio_html($per_dep_permanente,"mundp",'Municipio'); ?>
								<script>
									document.getElementById("mundp").value = <?php echo $per_depmun_permanente; ?>; 
								</script>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">T&iacute;po de Sangre: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
								<select id="sangre" name="sangre" class="form-control">
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
									document.getElementById("sangre").value = "<?php echo $per_tipo_sangre; ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Alergico a: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="alergia" name="alergia" placeholder="Alergico a" value = "<?php echo $per_alergico; ?>" onkeyup = "textolibre(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Celular: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="cel" name="cel" placeholder="Tel&eacute;fono Celular" value = "<?php echo $per_celular; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">e-mail: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control text-libre" id="email" name="email" placeholder="Direcci&oacute;n de Correo Electr&oacute;nico" value = "<?php echo $per_mail; ?>" onkeyup = "textolibre(this);">
							</div>
						</div>
					</div>
					<br>
					<p class="text-muted text-center">Documentos y Pertenencias</p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">No. DPI: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="dpi" name="dpi" placeholder="Documento Personal de Identificaci&oacute;n" value = "<?php echo $per_dpi; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">No. NIT: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="nit" name="nit" placeholder="N&uacute;mero de Identificaci&oacute;n Tributaria" value = "<?php echo $per_nit; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Pasaporte Of.: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="pasa1" name="pasa1" placeholder="Pasaporte Oficial" value = "<?php echo $per_pasaporte_of; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Pasaporte Per.: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="pasa2" name="pasa2" placeholder="Pasaporte Personal" value = "<?php echo $per_pasaporte_per; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
					</div>
					<br>
					<p class="text-muted text-center"><small>Datos de los Vehiculos</small></p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Tipo Lic. Veh.: </label>
							<div class="col-sm-8">
								<select id="tlicv" name="tlicv" class="form-control">
								      <option value = "">Liciencia Tipo</option>
								      <option value = "C">LIC. PARTICULAR (C)</option>
								      <option value = "B">LIC. TRANS. LIVIANO (B)</option>
								      <option value = "A">LIC. TRANS. PESADO (A)</option>
								</select>
								<script>
									document.getElementById("tlicv").value = "<?php echo $per_tipo_lic_veh; ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">No. Lic. Veh.: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="nlicv" name="nlicv" placeholder="N&uacute;mero de Licencia de Vehiculo" value = "<?php echo $per_num_lic_veh; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
					</div>
			<?php
				$ClsVeh = new ClsVehiculo();
				$cant_vehiculos = $ClsVeh->count_vehiculos($codigo);
				
			?>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">No. Lic. Moto: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="nlicm" name="nlicm" placeholder="N&uacute;mero de Licencia de Moto" value = "<?php echo $per_num_lic_moto; ?>" onkeyup = "enteros(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Cant. de Vehiculos: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="cantvehiculos" name="cantvehiculos" placeholder="Cantidad de Vehiculos que Posee" value = "<?php echo $cant_vehiculos; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Vehiculos)" onchange = "Filas_Vehiculos()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="font-10" id = "VehiculosContainer">
						<br>
						<br>
						<table class="table table-striped table-bordered font-10">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Tipo</th>
								<th class="text-center">Marca</th>
								<th class="text-center">Linea</th>
								<th class="text-center">Modelo</th>
								<th class="text-center">Tarjeta/Circulaci&oacute;n</th>
								<th class="text-center">Color</th>
								<th class="text-center">No. Chasis</th>
								<th class="text-center">No. Motor</th>
								<th class="text-center">No. Placas</th>
								<th class="text-center">Pais/Reg.</th>
							</tr>
			<?php
				$result = $ClsVeh->get_vehiculos($codigo);
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_vehiculos   
						$veh_tipo = $row["veh_tipo"];
						$veh_marca = $row["veh_marca"];
						$veh_linea = $row["veh_linea"];
						$veh_modelo = $row["veh_modelo"];
						$veh_tarjeta = $row["veh_tarjeta"];
						$veh_color = $row["veh_color"];
						$veh_chasis = $row["veh_chasis"];
						$veh_motor = $row["veh_motor"];
						$veh_placas = $row["veh_placas"];
						$veh_pais_reg = $row["veh_pais_reg"];
				
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<select id="tipoveh<?php echo $i; ?>" name="tipoveh<?php echo $i; ?>" class="form-control input-sm" >
										<option value = "">Tipo</option>
										<option value = "SEDAN">SEDAN</option>
										<option value = "HATCHBACK">HATCHBACK</option>
										<option value = "SUV">SUV</option>
										<option value = "PICKUP">PICKUP</option>
										<option value = "MICROBUS">MICROBUS</option>
										<option value = "MOTO">MOTO</option>
										<option value = "OTRO">OTRO</option>
									</select>
									<script>
										document.getElementById("tipoveh<?php echo $i; ?>").value = "<?php echo $veh_tipo; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="marcaveh<?php echo $i; ?>" name="marcaveh<?php echo $i; ?>" value = "<?php echo $veh_marca; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="lineaveh<?php echo $i; ?>" name="lineaveh<?php echo $i; ?>" value = "<?php echo $veh_linea; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="modeloveh<?php echo $i; ?>" name="modeloveh<?php echo $i; ?>" value = "<?php echo $veh_modelo; ?>" onkeyup = "enteros(this);" >
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="tarjetaveh<?php echo $i; ?>" name="tarjetaveh<?php echo $i; ?>" value = "<?php echo $veh_tarjeta; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="colorveh<?php echo $i; ?>" name="colorveh<?php echo $i; ?>" value = "<?php echo $veh_color; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="chasisveh<?php echo $i; ?>" name="chasisveh<?php echo $i; ?>" value = "<?php echo $veh_chasis; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="motorveh<?php echo $i; ?>" name="motorveh<?php echo $i; ?>" value = "<?php echo $veh_motor; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="placasveh<?php echo $i; ?>" name="placasveh<?php echo $i; ?>" value = "<?php echo $veh_placas; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<?php echo Paises_html("paisveh$i","Pa&iacute;s de Registro"); ?>
									<script>
										document.getElementById("paisveh<?php echo $i; ?>").value = "<?php echo $veh_pais_reg; ?>"; 
									</script>
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<select id="tipoveh1" name="tipoveh1" class="form-control input-sm" disabled>
										<option value = "">Tipo</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="marcaveh1" name="marcaveh1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="lineaveh1" name="lineaveh1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="modeloveh1" name="modeloveh1" onkeyup = "enteros(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="tarjetaveh1" name="tarjetaveh1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="colorveh1" name="colorveh1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="chasisveh1" name="chasisveh1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="motorveh1" name="motorveh1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control input-sm" id="placasveh1" name="placasveh1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<select id="paisveh1" name="paisveh1" class="form-control input-sm" disabled>
										<option value = "">Pais</option>
									</select>
								</td>
							</tr>
			<?php
				}
			?>
						</table>
						</div>
					</div>
			<?php
				$ClsArm = new ClsArmamento();
				$cant_armas = $ClsArm->count_armamento($codigo);
				
			?>
					<p class="text-muted text-center"><small>Datos del Armamento</small></p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">No. de Licencia: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="licportacion" name="licportacion" placeholder="N&uacute;mero de Licencia de Portaci&oacute;n" value = "<?php echo $per_num_lic_digecam; ?>" onkeyup = "enteros(this);" >
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Cantidad de Armas: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="cantarmas" name="cantarmas" placeholder="Cantidad de Armas Registradas la Lic. de Portaci&oacute;n" value = "<?php echo $cant_armas; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Armamento)" onchange = "Filas_Armamento()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha Extenci&oacute;n: </label>
							<div class="col-sm-8">
								<div class='input-group date'>
									<input type="text" class="form-control" id="feciniarma" name="feciniarma" placeholder="Fecha de alta de la &Uacute;ltima Dependencia" value = "<?php echo $per_digecam_fecini; ?>" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('feciniarma'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha Expiraci&oacute;n: </label>
							<div class="col-sm-8">
								<div class='input-group date'>
									<input type="text" class="form-control" id="fecfinarma" name="fecfinarma" placeholder="Fecha de Traslado de la &Uacute;ltima Dependencia" value = "<?php echo $per_digecam_fecfin; ?>" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecfinarma'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "ArmamentoContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Tipo Arma</th>
								<th class="text-center">Marca</th>
								<th class="text-center">Calibre</th>
								<th class="text-center">No. Registro</th>
							</tr>
			<?php
				$result = $ClsArm->get_armamento($codigo);
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_armamento
						$arm_tipo = $row["arm_tipo"];
						$arm_marca = $row["arm_marca"];
						$arm_calibre = $row["arm_calibre"];
						$arm_num_reg = $row["arm_num_reg"];
				
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<select id="tipoarma<?php echo $i; ?>" name="tipoarma<?php echo $i; ?>" class="form-control">
										<option value = "">Seleccione</option>
										<option value = "PISTOLA">PISTOLA</option>
										<option value = "REVOLVER">REVOLVER</option>
										<option value = "ESCOPETA">ESCOPETA</option>
										<option value = "RIFLE">RIFLE</option>
									</select>
									<script>
										document.getElementById("tipoarma<?php echo $i; ?>").value = "<?php echo $arm_tipo; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="marcaarma<?php echo $i; ?>" name="marcaarma<?php echo $i; ?>" value = "<?php echo $arm_marca; ?>" >
								</td>
								<td>
									<select id="calarma<?php echo $i; ?>" name="calarma<?php echo $i; ?>" class="form-control">
										<option value = "">Seleccione</option>
										<option value = "9MM">9mm</option>
										<option value = "0.40">.40"</option>
										<option value = "0.45">.45"</option>
										<option value = "22">22</option>
										<option value = "7.62">7.62</option>
										<option value = "5.56">5.56</option>
										<option value = "OTRO">OTRO</option>
									</select>
									<script>
										document.getElementById("calarma<?php echo $i; ?>").value = "<?php echo $arm_calibre; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="numarma<?php echo $i; ?>" name="numarma<?php echo $i; ?>" value = "<?php echo $arm_num_reg; ?>" onkeyup = "enteros(this);">
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<select id="tipoarma1" name="tipoarma1" class="form-control" disabled>
										<option value = "">Seleccione</option>
										<option value = "PISTOLA">PISTOLA</option>
										<option value = "REVOLVER">REVOLVER</option>
										<option value = "ESCOPETA">ESCOPETA</option>
										<option value = "RIFLE">RIFLE</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="marcaarm1" name="marcaarm1" disabled>
								</td>
								<td>
									<select id="calarma1" name="calarma1" class="form-control" disabled>
										<option value = "">Seleccione</option>
										<option value = "9mm">9mm</option>
										<option value = "0.40">.40"</option>
										<option value = "0.45">.45"</option>
										<option value = "22">22</option>
										<option value = "7.62">7.62</option>
										<option value = "5.56">5.56</option>
										<option value = "OTRO">OTRO</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="numarma1" name="numarma1" onkeyup = "enteros(this);" disabled>
								</td>
							</tr>
			<?php
				}
			?>
						</table>
						</div>
					</div>
				</div>
			</div>
			
			<!----------------->	
			<div class="panel panel-default">
			<div class="panel-heading">INFORMACI&Oacute;N PROFESIONAL (EDUCACI&Oacute;N)</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<p class="text-muted text-center">C&iacute;clos Educativos</p>
					<div class="row">
						<div class="col-xs-12">
							<label class="col-sm-2 control-label">Prim&aacute;ria: <span class = "text-danger">*</span></label>
							<div class="col-sm-4">
								<select id="primaria" name="primaria" class="form-control">
									<option value = "" >Seleccione el &uacute;ltimo a&ntilde;o cursado...</option>
									<option value = "1">1ER. PRIM&Aacute;RIA</option>
									<option value = "2">2DO. PRIM&Aacute;RIA</option>
									<option value = "3">3RO. PRIM&Aacute;RIA</option>
									<option value = "4">4TO. PRIM&Aacute;RIA</option>
									<option value = "5">5TO. PRIM&Aacute;RIA</option>
									<option value = "6">6TO. PRIM&Aacute;RIA</option>
									<script>
										document.getElementById("primaria").value = <?php echo $edu_grado_primaria; ?>; 
									</script>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<label class="col-sm-2 control-label">Establecimientos: <span class = "text-danger">*</span></label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="lugprimaria" name="lugprimaria" placeholder="Establecimientos donde estudio la Prim&aacute;ria" value = "<?php echo $edu_lugar_primaria; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<label class="col-sm-2 control-label">Secund&aacute;ria: &nbsp;&nbsp;</label>
							<div class="col-sm-4">
								<select id="secundaria" name="secundaria" class="form-control">
									<option value = "">Seleccione el &uacute;ltimo a&ntilde;o cursado...</option>
									<option value = "1">1ER. B&Aacute;SICO</option>
									<option value = "2">2DO. B&Aacute;SICO</option>
									<option value = "3">3RO. B&Aacute;SICO</option>
									<option value = "4">4TO. DIVERSIFICADO</option>
									<option value = "5">5TO. DIVERSIFICADO</option>
									<option value = "6">6TO. DIVERSIFICADO</option>
									<script>
										document.getElementById("secundaria").value = <?php echo $edu_grado_secundaria; ?>; 
									</script>
								</select>
							</div>
							<div class="col-xs-5">
								<label class="col-sm-4 control-label">Carrera: </label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" id="secuncarrera" name="secuncarrera" placeholder="Carrera o Rama" value = "<?php echo $edu_carrera_secundaria; ?>" onkeyup = "texto(this);" >
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<label class="col-sm-2 control-label">Establecimientos: &nbsp;&nbsp;</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="lugsecundaria" name="lugsecundaria" placeholder="Establecimientos donde estudio la Secund&aacute;ria" value = "<?php echo $edu_lugar_secundaria; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<br>
			<?php
				$ClsEdu = new ClsEducacion();
				$cant_cursos = $ClsEdu->count_cursos($codigo,"U");
				
			?>
					<p class="text-muted text-center">T&iacute;tulos Universitarios</p>
					<div class="row">
						<div class="col-xs-6 col-xs-offset-1">
							<label class="col-sm-8 control-label">Cantidad de T&iacute;tulos: <span class = "text-danger">*</span></label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="canttitulos" name="canttitulos" placeholder="Cantidad de T&iacute;tulos" value = "<?php echo $cant_cursos; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Titulos)" onchange = "Filas_Titulos()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "TitulosContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Nivel</th>
								<th class="text-center">T&iacute;tulo</th>
								<th class="text-center">Universidad</th>
								<th class="text-center">Pa&iacute;s</th>
								<th class="text-center">A&ntilde;o</th>
								<th class="text-center">Sem&eacute;stres</th>
								<th class="text-center">Graduado?</th>
							</tr>
			<?php
				$result = $ClsEdu->get_cursos($codigo,"U");
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_cursos   
						$cur_nivel = $row["cur_nivel"];
						$cur_titulo = $row["cur_titulo"];
						$cur_lugar = $row["cur_lugar"];
						$cur_pais = $row["cur_pais"];
						$cur_anio = $row["cur_anio"];
						$cur_semestre = $row["cur_semestre"];
						$cur_graduado = $row["cur_graduado"];
				
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<select id="nivelu<?php echo $i; ?>" name="nivelu<?php echo $i; ?>" class="form-control">
										<option value = "">Nivel Universitario</option>
										<option value = "PROF">PROFESORADO (Equivalente)</option>
										<option value = "LIC">LICENCIATURA (Equivalente)</option>
										<option value = "POST">POST-GRADO</option>
										<option value = "MAST">MAESTRIA</option>
										<option value = "DOC">DOCTORADO</option>
									</select>
									<script>
										document.getElementById("nivelu<?php echo $i; ?>").value = "<?php echo $cur_nivel; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="titulo<?php echo $i; ?>" name="titulo<?php echo $i; ?>" value = "<?php echo $cur_titulo; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="unversidad<?php echo $i; ?>" name="universidad<?php echo $i; ?>" value = "<?php echo $cur_lugar; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<?php echo Paises_html("paistit$i","Pa&iacute;s de Estudio"); ?>
									<script>
										document.getElementById("paistit<?php echo $i; ?>").value = "<?php echo $cur_pais; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="aniotit<?php echo $i; ?>" name="aniotit<?php echo $i; ?>" value = "<?php echo $cur_anio; ?>" onkeyup = "enteros(this);" maxlength="4" >
								</td>
								<td>
									<input type="text" class="form-control" id="semtit<?php echo $i; ?>" name="semtit<?php echo $i; ?>" value = "<?php echo $cur_semestre; ?>" onkeyup = "enteros(this);" maxlength="2">
								</td>
								<td>
									<select id="graduadotit<?php echo $i; ?>" name="graduadotit<?php echo $i; ?>" class="form-control">
										<option value = "NO">NO</option>
										<option value = "SI">SI</option>
									</select>
									<script>
										document.getElementById("graduadotit<?php echo $i; ?>").value = "<?php echo $cur_graduado; ?>"; 
									</script>
								</td>
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<select id="nivelu1" name="nivelu1" class="form-control" disabled>
										<option value = "">Nivel Universitario</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="titulo1" name="titulo1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="unversidad1" name="universidad1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<select id="paistit1" name="paistit1" class="form-control" disabled>
										<option value = "">Pa&iacute;s de Estudio</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="aniotit1" name="aniotit1" onkeyup = "enteros(this);" maxlength="4" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="semtit1" name="semtit1" onkeyup = "enteros(this);" maxlength="2" disabled>
								</td>
								<td>
									<select id="graduadotit1" name="graduadotit1" class="form-control" disabled>
										<option value = "NO">NO</option>
										<option value = "SI">SI</option>
									</select>
								</td>
								</td>
							</tr>	
			<?php
				}
			?>
						</table>
						</div>
					</div>
					<br>
			<?php
				$ClsEdu = new ClsEducacion();
				$cant_idiomas = $ClsEdu->count_idiomas($codigo);
				
			?>
					<p class="text-muted text-center">Idiomas</p>
					<div class="row">
						<div class="col-xs-6 col-xs-offset-1">
							<label class="col-sm-8 control-label">Cantidad de Idiomas que domina: <span class = "text-danger">*</span></label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="cantidiomas" name="cantidiomas" placeholder="Cantidad de Idiomas" value = "<?php echo $cant_idiomas; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Idiomas)" onchange = "Filas_Idiomas()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "IdiomasContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th rowspan = "2" class="text-center">No.</th>
								<th rowspan = "2" class="text-center">Idioma</th>
								<th colspan = "3" class="text-center">Porcentajes</th>
							</tr>
							<tr>
								<th class="text-center">% Habla</th>
								<th class="text-center">% Lee</th>
								<th class="text-center">% Escribe</th>
							</tr>
			<?php
				$result = $ClsEdu->get_idiomas($codigo);
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_idiomas
						$idi_idioma = $row["idi_idioma"];
						$idi_habla = $row["idi_habla"];
						$idi_lee = $row["idi_lee"];
						$idi_escribe = $row["idi_escribe"];
				
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<input type="text" class="form-control" id="idioma<?php echo $i; ?>" name="idioma<?php echo $i; ?>" onkeyup = "texto(this);" value = "<?php echo $idi_idioma; ?>" >
								</td>
								<td>
									<input type="text" class="form-control" id="habla<?php echo $i; ?>" name="habla<?php echo $i; ?>" onkeyup = "enteros(this);" maxlength="3" value = "<?php echo $idi_habla; ?>" >
								</td>
								<td>
									<input type="text" class="form-control" id="lee<?php echo $i; ?>" name="lee<?php echo $i; ?>" onkeyup = "enteros(this);" maxlength="3" value = "<?php echo $idi_lee; ?>" >
								</td>
								<td>
									<input type="text" class="form-control" id="escribe<?php echo $i; ?>" name="escribe<?php echo $i; ?>" onkeyup = "enteros(this);" maxlength="3" value = "<?php echo $idi_escribe; ?>" >
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<input type="text" class="form-control" id="idioma1" name="idioma1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="habla1" name="habla1" onkeyup = "enteros(this);" maxlength="3" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="lee1" name="lee1" onkeyup = "enteros(this);" maxlength="3" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="escribe1" name="escribe1" onkeyup = "enteros(this);" maxlength="3" disabled>
								</td>
							</tr>	
			<?php
				}
			?>
						</table>
						</div>
					</div>
					<br>
			<?php
				$ClsEdu = new ClsEducacion();
				$cant_cursos = $ClsEdu->count_cursos($codigo,"M");
				
			?>			
					<p class="text-muted text-center">Cursos Militares</p>
					<div class="row">
						<div class="col-xs-6 col-xs-offset-1">
							<label class="col-sm-8 control-label">Cantidad de Cursos Militares: <span class = "text-danger">*</span></label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="cantcursos" name="cantcursos" placeholder="Cantidad de Cursos" value = "<?php echo $cant_cursos; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Cursos)" onchange = "Filas_Cursos()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "CursosContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Nivel</th>
								<th class="text-center">Curso</th>
								<th class="text-center">Escuela</th>
								<th class="text-center">Pa&iacute;s</th>
								<th class="text-center">A&ntilde;o</th>
							</tr>
			<?php
				$result = $ClsEdu->get_cursos($codigo,"M");
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_cursos   
						$cur_nivel = $row["cur_nivel"];
						$cur_titulo = $row["cur_titulo"];
						$cur_lugar = $row["cur_lugar"];
						$cur_pais = $row["cur_pais"];
						$cur_anio = $row["cur_anio"];
				
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<select id="nivelmil<?php echo $i; ?>" name="nivelmil<?php echo $i; ?>" class="form-control">
										<option value = "">Profesionalizaci&oacute;n</option>
										<option value = "FORM">FORMACION</option>
										<option value = "PROF">PROFESIONALIZACION</option>
										<option value = "TEC">TECNIFICACION</option>
										<option value = "ESP">ESPECIALIZACION</option>
									</select>
									<script>
										document.getElementById("nivelmil<?php echo $i; ?>").value = "<?php echo $cur_nivel; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="curso<?php echo $i; ?>" name="curso<?php echo $i; ?>" value = "<?php echo $cur_titulo; ?>" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="escuela<?php echo $i; ?>" name="escuela<?php echo $i; ?>" value = "<?php echo $cur_lugar; ?>" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<?php echo Paises_html("paiscur$i","Pa&iacute;s de Estudio"); ?>
									<script>
										document.getElementById("paiscur<?php echo $i; ?>").value = "<?php echo $cur_pais; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="aniocur<?php echo $i; ?>" name="aniocur<?php echo $i; ?>" value = "<?php echo $cur_anio; ?>" onkeyup = "enteros(this);" maxlength="4" disabled>
								</td>
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<select id="nivelmil1" name="nivelmil1" class="form-control" disabled>
										<option value = "">Profesionalizaci&oacute;n</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="curso1" name="curso1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="escuela1" name="escuela1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<select id="paiscur1" name="paiscur1" class="form-control" disabled>
										<option value = "">Pa&iacute;s de Estudio</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="aniocur1" name="aniocur1" onkeyup = "enteros(this);" maxlength="4" disabled>
								</td>
								</td>
							</tr>	
			<?php
				}
			?>
						</table>
						</div>
					</div>
					<br>
			<?php
				$ClsEdu = new ClsEducacion();
				$cant_cursos = $ClsEdu->count_cursos($codigo,"C");
				
			?>
					<p class="text-muted text-center">Otros Cursos, T&iacute;tulos o Capacitaciones</p>
					<div class="row">
						<div class="col-xs-6 col-xs-offset-1">
							<label class="col-sm-8 control-label">Cantidad de Cursos: <span class = "text-danger">*</span></label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="cantotroscursos" name="cantotroscursos" placeholder="Cantidad de Cursos" value = "<?php echo $cant_cursos; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Otros_Cursos)" onchange = "Filas_Otros_Cursos()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "OtrosCursosContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Nivel</th>
								<th class="text-center">Curso</th>
								<th class="text-center">Instituci&oacute;n</th>
								<th class="text-center">Pa&iacute;s</th>
								<th class="text-center">A&ntilde;o</th>
							</tr>
			<?php
				$result = $ClsEdu->get_cursos($codigo,"C");
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_cursos   
						$cur_nivel = $row["cur_nivel"];
						$cur_titulo = $row["cur_titulo"];
						$cur_lugar = $row["cur_lugar"];
						$cur_pais = $row["cur_pais"];
						$cur_anio = $row["cur_anio"];
				
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<select id="nivelciv<?php echo $i; ?>" name="nivelciv<?php echo $i; ?>" class="form-control">
										<option value = "">Seleccione</option>
										<option value = "TALL">TALLER</option>
										<option value = "SEM">SEMINARIO</option>
										<option value = "DIP">DIPLOMADO</option>
										<option value = "CAP">CAPACITACI&Oacute;N</option>
									</select>
									<script>
										document.getElementById("nivelciv<?php echo $i; ?>").value = "<?php echo $cur_nivel; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="otrocurso<?php echo $i; ?>" name="otrocurso<?php echo $i; ?>" value = "<?php echo $cur_titulo; ?>" onkeyup = "texto(this);">
								</td>
								<td>
									<input type="text" class="form-control" id="instituto<?php echo $i; ?>" name="instituto<?php echo $i; ?>" value = "<?php echo $cur_lugar; ?>" onkeyup = "texto(this);">
								</td>
								<td>
									<?php echo Paises_html("paisotrocur$i","Pa&iacute;s de Estudio"); ?>
									<script>
										document.getElementById("paisotrocur<?php echo $i; ?>").value = "<?php echo $cur_pais; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="aniootrocur<?php echo $i; ?>" name="aniootrocur<?php echo $i; ?>" value = "<?php echo $cur_anio; ?>" onkeyup = "enteros(this);" maxlength="4">
								</td>
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<select id="nivelciv1" name="nivelciv1" class="form-control" disabled>
										<option value = "">Taller</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="otrocurso1" name="otrocurso1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="instituto1" name="instituto1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<select id="paisotrocur1" name="paisotrocur1" class="form-control" disabled>
										<option value = "">Pa&iacute;s de Estudio</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="aniootrocur1" name="aniootrocur1" onkeyup = "enteros(this);" maxlength="4" disabled>
								</td>
								</td>
							</tr>	
			<?php
				}
			?>
						</table>
						</div>
					</div>
				</div>
			</div>	
				
			<!--------------->		
			<div class="panel panel-default">
			<div class="panel-heading">INFORMACI&Oacute;N FAMILIAR</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
			<?php
				$ClsFam = new ClsFamilia();
				$result = $ClsFam->get_familia($codigo,"3");
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_familia   
						$fam_nombres = $row["fam_nombres"];
						$fam_apellidos = $row["fam_apellidos"];
						$fam_direccion = $row["fam_direccion"];
						$fam_telefono = $row["fam_telefono"];
						$fam_celular = $row["fam_celular"];
						$fam_profesion = $row["fam_profesion"];
						$fam_religion = $row["fam_religion"];
						$fam_pais = $row["fam_pais"];
						$fam_fecnac = $row["fam_fecnac"];
						$fam_fecnac = cambia_fecha($fam_fecnac);
						$fam_edad = Calcula_Edad($fam_fecnac);
						$fam_parentesco = $row["fam_parentesco"];
					}
				}	
				
			?>
					<p class="text-muted text-center">Datos del Padre</p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nombres: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famnombre2" name="famnombre2" placeholder="Nombres" value = "<?php echo $fam_nombres; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Apellidos: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famapellido2" name="famapellido2" placeholder="Apellidos" value = "<?php echo $fam_apellidos; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nacionalidad: </label>
							<div class="col-sm-8">
							   <?php echo Paises_html('fampais2','Pa&iacute;s de Nacimiento'); ?>
								<script>
									document.getElementById("fampais2").value = "<?php echo $fam_pais; ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Religi&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famreligion2" name="famreligion2" placeholder="Religi&oacute;n del Padre" value = "<?php echo $fam_religion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Direcci&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famdirec2" name="famdirec2" placeholder="Direcci&oacute;n Eventual" value = "<?php echo $fam_direccion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Tel&eacute;fono: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famtel2" name="famtel2" placeholder="Tel&eacute;fono Eventual" value = "<?php echo $fam_telefono; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Celular: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famcel2" name="famcel2" placeholder="Tel&eacute;fono Celular" value = "<?php echo $fam_celular; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Profesi&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famprofe2" name="famprofe2" placeholder="Profesi&oacute;n" value = "<?php echo $fam_profesion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha de Nac.: </label>
							<div class="col-sm-8">
								<div class='input-group date'>
									<input type="text" class="form-control" id="padrefecnac" name="padrefecnac" placeholder="Fecha de Nacimiento" value = "<?php echo $fam_fecnac; ?>" onchange="CalculaEdad(this.value,'padreedad')" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('padrefecnac'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Edad: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="padreedad" name="padreedad" placeholder="Edad en A&ntilde;os" value = "<?php echo $fam_edad; ?>" readonly>
							</div>
						</div>
					</div>
			<?php
				$ClsFam = new ClsFamilia();
				$result = $ClsFam->get_familia($codigo,"2");
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_familia   
						$fam_nombres = $row["fam_nombres"];
						$fam_apellidos = $row["fam_apellidos"];
						$fam_direccion = $row["fam_direccion"];
						$fam_telefono = $row["fam_telefono"];
						$fam_celular = $row["fam_celular"];
						$fam_profesion = $row["fam_profesion"];
						$fam_religion = $row["fam_religion"];
						$fam_pais = $row["fam_pais"];
						$fam_fecnac = $row["fam_fecnac"];
						$fam_fecnac = cambia_fecha($fam_fecnac);
						$fam_edad = Calcula_Edad($fam_fecnac);
						$fam_parentesco = $row["fam_parentesco"];
					}
				}	
				
			?>
					<p class="text-muted text-center">Datos de la Madre</p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nombres: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famnombre3" name="famnombre3" placeholder="Nombres" value = "<?php echo $fam_nombres; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Apellidos: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famapellido3" name="famapellido3" placeholder="Apellidos" value = "<?php echo $fam_apellidos; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nacionalidad: </label>
							<div class="col-sm-8">
							   <?php echo Paises_html('fampais3','Pa&iacute;s de Nacimiento'); ?>
								<script>
									document.getElementById("fampais3").value = "<?php echo $fam_pais; ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Religi&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famreligion3" name="famreligion3" placeholder="Religi&oacute;n de la Madre" value = "<?php echo $fam_religion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Direcci&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famdirec3" name="famdirec3" placeholder="Direcci&oacute;n Eventual" value = "<?php echo $fam_direccion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Tel&eacute;fono: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famtel3" name="famtel3" placeholder="Tel&eacute;fono Eventual" value = "<?php echo $fam_telefono; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Celular: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famcel3" name="famcel3" placeholder="Tel&eacute;fono Celular" value = "<?php echo $fam_celular; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Profesi&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famprofe3" name="famprofe3" placeholder="Profesi&oacute;n" value = "<?php echo $fam_profesion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha de Nac.: </label>
							<div class="col-sm-8">
								<div class='input-group date'>
									<input type="text" class="form-control" id="madrefecnac" name="madrefecnac" placeholder="Fecha de Nacimiento" value = "<?php echo $fam_fecnac; ?>" onchange="CalculaEdad(this.value,'madreedad')" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('madrefecnac'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Edad: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="madreedad" name="madreedad" placeholder="Edad en A&ntilde;os" value = "<?php echo $fam_edad; ?>" readonly>
							</div>
						</div>
					</div>
					<p class="text-muted text-center">Datos de la(el) Esposa(o)</p>
			<?php
				$ClsFam = new ClsFamilia();
				$result = $ClsFam->get_familia($codigo,"1");
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_familia   
						$fam_nombres = $row["fam_nombres"];
						$fam_apellidos = $row["fam_apellidos"];
						$fam_direccion = $row["fam_direccion"];
						$fam_telefono = $row["fam_telefono"];
						$fam_celular = $row["fam_celular"];
						$fam_profesion = $row["fam_profesion"];
						$fam_religion = $row["fam_religion"];
						$fam_pais = $row["fam_pais"];
						$fam_fecnac = $row["fam_fecnac"];
						$fam_fecnac = cambia_fecha($fam_fecnac);
						$fam_edad = Calcula_Edad($fam_fecnac);
						$fam_parentesco = $row["fam_parentesco"];
					}
				}	
				
			?>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nombres: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famnombre4" name="famnombre4" placeholder="Nombres" value = "<?php echo $fam_nombres; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Apellidos: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famapellido4" name="famapellido4" placeholder="Apellidos" value = "<?php echo $fam_apellidos; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nacionalidad: </label>
							<div class="col-sm-8">
							   <?php echo Paises_html('fampais4','Pa&iacute;s de Nacimiento'); ?>
								<script>
									document.getElementById("fampais4").value = "<?php echo $fam_pais; ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Religi&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famreligion4" name="famreligion4" placeholder="Religi&oacute;n de la Esposa" value = "<?php echo $fam_religion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Direcci&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famdirec4" name="famdirec4" placeholder="Direcci&oacute;n Eventual" value = "<?php echo $fam_direccion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Tel&eacute;fono: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famtel4" name="famtel4" placeholder="Tel&eacute;fono Eventual" value = "<?php echo $fam_telefono; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Celular: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famcel4" name="famcel4" placeholder="Tel&eacute;fono Celular" value = "<?php echo $fam_celular; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Profesi&oacute;n: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="famprofe4" name="famprofe4" placeholder="Profesi&oacute;n" value = "<?php echo $fam_profesion; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha de Nac.: </label>
							<div class="col-sm-8">
								<div class='input-group date'>
									<input type="text" class="form-control" id="esposafecnac" name="esposafecnac" placeholder="Fecha de Nacimiento" value = "<?php echo $fam_fecnac; ?>" onchange="CalculaEdad(this.value,'esposaedad')" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('esposafecnac'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Edad: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="esposaedad" name="esposaedad" placeholder="Edad en A&ntilde;os" value = "<?php echo $fam_edad; ?>" readonly>
							</div>
						</div>
					</div>
					<br>
					<p class="text-muted text-center">Datos de los Hijos</p>
			<?php
				$ClsFam = new ClsFamilia();
				$cant_hijos = $ClsFam->count_familia($codigo,4);
				
			?>
					<div class="row">
						<div class="col-xs-12">
							<label class="col-sm-4 control-label">Cantidad de Hijos: <span class = "text-danger">*</span></label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="canthijos" name="canthijos" placeholder="Cantidad de Hijos" value = "<?php echo $cant_hijos; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Hijos)" onchange = "Filas_Hijos()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "HijosContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Nombres</th>
								<th class="text-center">Apellidos</th>
								<th class="text-center">Nacionalidad</th>
								<th class="text-center">Religi&oacute;n</th>
								<th class="text-center">Fecha/Nacimiento</th>
							</tr>
			<?php
				$result = $ClsFam->get_familia($codigo,4);
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_cursos   
						$fam_nombres = $row["fam_nombres"];
						$fam_apellidos = $row["fam_apellidos"];
						$fam_pais = $row["fam_pais"];
						$fam_religion = $row["fam_religion"];
						$fam_fecnac = $row["fam_fecnac"];
						$fam_fecnac = cambia_fecha($fam_fecnac);
						
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<input type="text" class="form-control" id="nomhijo<?php echo $i; ?>" name="nomhijo<?php echo $i; ?>" value = "<?php echo $fam_nombres; ?>" onkeyup = "texto(this);">
								</td>
								<td>
									<input type="text" class="form-control" id="apehijo<?php echo $i; ?>" name="apehijo<?php echo $i; ?>" value = "<?php echo $fam_apellidos; ?>" onkeyup = "texto(this);">
								</td>
								<td>
									<?php echo Paises_html("paishijo$i",'Pa&iacute;s de Nacimiento'); ?>
									<script>
										document.getElementById("paishijo<?php echo $i; ?>").value = "<?php echo $fam_pais; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="religionhijo<?php echo $i; ?>" name="religionhijo<?php echo $i; ?>" value = "<?php echo $fam_religion; ?>" onkeyup = "texto(this);">
								</td>
								<td>
									<div class='input-group date'>
									<input type="text" class="form-control" id="fecnachijo<?php echo $i; ?>" name="fecnachijo<?php echo $i; ?>" value = "<?php echo $fam_fecnac; ?>" title="Click para seleccionar la fecha" style="cursor:pointer" onclick="displayCalendar(this,'dd/mm/yyyy', this)" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecnachijo<?php echo $i; ?>'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<input type="text" class="form-control" id="nomhijo1" name="nomhijo1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="apehijo1" name="apehijo1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<select id="paishijo1" name="paishijo1" class="form-control" disabled>
										<option value = "">Nacionalidad</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="religionhijo1" name="religionhijo1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<div class='input-group date'>
									<input type="text" class="form-control" id="fecnachijo1" name="fecnachijo1" title="Click para seleccionar la fecha" style="cursor:pointer" onclick="displayCalendar(this,'dd/mm/yyyy', this)" disabled >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecnachijo1'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								</td>
							</tr>
			<?php
				}
			?>
						</table>
						</div>
					</div>
			<?php
				$ClsFam = new ClsFamilia();
				$cant_hermanos = $ClsFam->count_familia($codigo,7);
				
			?>
					<p class="text-muted text-center">Datos de los Hermanos</p>
					<div class="row">
						<div class="col-xs-12">
							<label class="col-sm-4 control-label">Cantidad de Hermanos: <span class = "text-danger">*</span></label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="canthermanos" name="canthermanos" placeholder="Cantidad de Hermanos" value = "<?php echo $cant_hermanos; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Hermanos)" onchange = "Filas_Hermanos()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "HermanosContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Nombres</th>
								<th class="text-center">Apellidos</th>
								<th class="text-center">Nacionalidad</th>
								<th class="text-center">Religi&oacute;n</th>
								<th class="text-center">Fecha/Nacimiento</th>
							</tr>
			<?php
				$result = $ClsFam->get_familia($codigo,7);
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_cursos   
						$fam_nombres = $row["fam_nombres"];
						$fam_apellidos = $row["fam_apellidos"];
						$fam_pais = $row["fam_pais"];
						$fam_religion = $row["fam_religion"];
						$fam_fecnac = $row["fam_fecnac"];
						$fam_fecnac = cambia_fecha($fam_fecnac);
						
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<input type="text" class="form-control" id="nomhermano<?php echo $i; ?>" name="nomhermano<?php echo $i; ?>" value = "<?php echo $fam_nombres; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="apehermano<?php echo $i; ?>" name="apehermano<?php echo $i; ?>" value = "<?php echo $fam_apellidos; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<?php echo Paises_html("paishermano$i",'Pa&iacute;s de Nacimiento'); ?>
									<script>
										document.getElementById("paishermano<?php echo $i; ?>").value = "<?php echo $fam_pais; ?>"; 
									</script>
								</td>
								<td>
									<input type="text" class="form-control" id="religionhermano<?php echo $i; ?>" name="religionhermano<?php echo $i; ?>" value = "<?php echo $fam_religion; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<div class='input-group date'>
									<input type="text" class="form-control" id="fecnachermano<?php echo $i; ?>" name="fecnachermano<?php echo $i; ?>" value = "<?php echo $fam_fecnac; ?>" title="Click para seleccionar la fecha" style="cursor:pointer" onclick="displayCalendar(this,'dd/mm/yyyy', this)" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecnachermano<?php echo $i; ?>'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<input type="text" class="form-control" id="nomhermano1" name="nomhermano1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="apehermano1" name="apehermano1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<select id="paishermano1" name="paishermano1" class="form-control" disabled>
										<option value = "">Nacionalidad</option>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" id="religionhermano1" name="religionhermano1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<div class='input-group date'>
									<input type="text" class="form-control" id="fecnachermano1" name="fecnachermano1" title="Click para seleccionar la fecha" style="cursor:pointer" onclick="displayCalendar(this,'dd/mm/yyyy', this)" disabled >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecnachermano1'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								</td>
							</tr>
			<?php
				}
			?>
						</table>
						</div>
					</div>
					<p class="text-muted text-center">En caso de Emergencia Avisar a</p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Parentesco: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
								<select id="emergencia" name="emergencia" class="form-control" onchange = "trasladar_datos_emergenia(this.value);">
									<option value = "1" selected>OTRO</option>
									<option value = "2">PADRE</option>
									<option value = "3">MADRE</option>
									<option value = "4">ESPOSA(O)</option>
								</select>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Direcci&oacute;n: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="emerdirec" name="emerdirec" placeholder="Direcci&oacute;n del Pariente" value = "<?php echo $per_emergencia_dir; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nombres: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="emernombre" name="emernombre" placeholder="Nombres" value = "<?php echo $per_emergencia_nombre; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Apellidos: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="emerapellido" name="emerapellido" placeholder="Apellidos" value = "<?php echo $per_emergencia_apellido; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Tel&eacute;fono: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="emertel" name="emertel" placeholder="Tel&eacute;fono Eventual" value = "<?php echo $per_emergencia_tel; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Celular: </label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="emercel" name="emercel" placeholder="Tel&eacute;fono Celular" value = "<?php echo $per_emergencia_cel; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
					</div>
					<br>
			<?php
				$ClsFam = new ClsFamilia();
				$cant_famil = $ClsFam->count_familia_militar($codigo);
				
			?>
					<p class="text-muted text-center">Indique el nombre de familiares dentro de la instituci&oacute;n o halla sido parte de ella</p>
					<div class="row">
						<div class="col-xs-12">
							<label class="col-sm-4 control-label">Cantidad de Familiares: <span class = "text-danger">*</span></label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="cantfamil" name="cantfamil" placeholder="Cantidad de Familiares en la Insituci&oacute;n" value = "<?php echo $cant_famil; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Famil)" onchange = "Filas_Famil()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "FamilContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Grado</th>
								<th class="text-center">Nombres</th>
								<th class="text-center">Parentesco</th>
								<th class="text-center">Lugar</th>
								<th class="text-center">A&ntilde;o</th>
							</tr>
			<?php
				$result = $ClsFam->get_familia_militar($codigo);
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_cursos   
						$famil_grado = $row["famil_grado"];
						$famil_nombre = $row["famil_nombre"];
						$famil_parentesco = $row["famil_parentesco"];
						$famil_lugar = $row["famil_lugar"];
						$famil_anio = $row["famil_anio"];
						
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<input type="text" class="form-control" id="grafamil<?php echo $i; ?>" name="grafamil<?php echo $i; ?>" value = "<?php echo $famil_grado; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="nomfamil<?php echo $i; ?>" name="nomfamil<?php echo $i; ?>" value = "<?php echo $famil_nombre; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="parenfamil<?php echo $i; ?>" name="parenfamil<?php echo $i; ?>" value = "<?php echo $famil_parentesco; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="lugarfamil<?php echo $i; ?>" name="lugarfamil<?php echo $i; ?>" value = "<?php echo $famil_lugar; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="aniofamil<?php echo $i; ?>" name="aniofamil<?php echo $i; ?>" value = "<?php echo $famil_anio; ?>" onkeyup = "enteros(this);" maxlength="4" >
								</div>
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<input type="text" class="form-control" id="grafamil1" name="grafamil1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="nomfamil1" name="nomfamil1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="parenfamil1" name="parenfamil1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="lugarfamil1" name="lugarfamil1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="aniofamil1" name="aniofamil1" onkeyup = "enteros(this);" maxlength="4" disabled>
								</div>
								</td>
							</tr>
			<?php
				}
			?>
						</table>
						</div>
					</div>
				</div>
			</div>
			
			<!--------------->		
			<div class="panel panel-default">
			<div class="panel-heading">INFORMACI&Oacute;N SOCIAL</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
			<?php
				$ClsRefS = new ClsRefSocial();
				$cant_refs = $ClsRefS->count_referencia_social($codigo);
				
			?>		
					<p class="text-muted text-center">Indique el nombre de almenos tres (03) personas que <strong>NO</strong> sean familiares suyos y que tengan conocimiento directo de su trabajo y honradez</p>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-5 control-label">Cantidad de Referencias: <span class = "text-danger">*</span></label>
							<div class="col-sm-7">
							  <input type="text" class="form-control" id="cantrefsocial" name="cantrefsocial" placeholder="Cantidad de Referencias Sociales" value = "<?php echo $cant_refs; ?>" onkeyup = "enteros(this);KeyEnter(this,Filas_Refsocial)" onchange = "Filas_Refsocial()">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 col-xs-offset-1" id = "RefsocialContainer">
						<br>
						<table class="table table-striped table-bordered">
							<tr>
								<th class="text-center">No.</th>
								<th class="text-center">Nombres</th>
								<th class="text-center">Direcci&oacute;n</th>
								<th class="text-center">Tel&eacute;fono</th>
								<th class="text-center">Lugar de Trabajo</th>
								<th class="text-center">Cargo</th>
							</tr>
			<?php
				$result = $ClsRefS->get_referencia_social($codigo);
				if(is_array($result)){
					$i = 1;
					foreach($result as $row){
						//rrhh_referencia_social   
						$refso_nombre = $row["refso_nombre"];
						$refso_direccion = $row["refso_direccion"];
						$refso_telefono = $row["refso_telefono"];
						$refso_trabajo = $row["refso_trabajo"];
						$refso_cargo = $row["refso_cargo"];
						
			?>
							<tr>
								<th class="text-center"><?php echo $i; ?>.</th>
								<td>
									<input type="text" class="form-control" id="nomsocial<?php echo $i; ?>" name="nomsocial<?php echo $i; ?>" value = "<?php echo $refso_nombre; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="dirsocial<?php echo $i; ?>" name="dirsocial<?php echo $i; ?>" value = "<?php echo $refso_direccion; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="telsocial<?php echo $i; ?>" name="telsocial<?php echo $i; ?>" value = "<?php echo $refso_telefono; ?>" onkeyup = "enteros(this);" maxlength="12" >
								</td>
								<td>
									<input type="text" class="form-control" id="trabajosocial<?php echo $i; ?>" name="trabajosocial<?php echo $i; ?>" value = "<?php echo $refso_trabajo; ?>" onkeyup = "texto(this);" >
								</td>
								<td>
									<input type="text" class="form-control" id="cargosocial<?php echo $i; ?>" name="cargosocial<?php echo $i; ?>" value = "<?php echo $refso_cargo; ?>" onkeyup = "texto(this);" >
								</div>
								</td>
							</tr>
			<?php
						$i++;
					}
				}else{
			?>
							<tr>
								<th class="text-center">1.</th>
								<td>
									<input type="text" class="form-control" id="nomsocial1" name="nomsocial1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="dirsocial1" name="dirsocial1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="telsocial1" name="telsocial1" onkeyup = "enteros(this);" maxlength="12" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="trabajosocial1" name="trabajosocial1" onkeyup = "texto(this);" disabled>
								</td>
								<td>
									<input type="text" class="form-control" id="cargosocial1" name="cargosocial1" onkeyup = "texto(this);" disabled>
								</div>
								</td>
							</tr>
			<?php
				}
			?>
						</table>
						</div>
					</div>
					<p class="text-muted text-center">Pasatiempos</p>
					<div class="row">
						<div class="col-xs-12">
							<label class="col-sm-3 control-label">Deportes que Practica: <span class = "text-danger">*</span></label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="deportes" name="deportes" placeholder="Deportes que Parctica (Futbol, Basketbol, Voleybol, etc.)" value = "<?php echo $per_deportes; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<br>
				</div>
			</div>
			
			<!--------------->		
			<div class="panel panel-default">
			<div class="panel-heading">INFORMACI&Oacute;N ECON&Oacute;MICA</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Esta su conyugue Empleada(o): </label>
							<div class="col-sm-6">
								<select id="empleadoconyugue" name="empleadoconyugue" class="form-control">
									<option value = "" >Seleccione</option>
									<option value = "SI">SI</option>
									<option value = "NO">NO</option>
								</select>
								<script>
									document.getElementById("empleadoconyugue").value = "<?php echo trim($eco_trabaja_conyugue); ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Ingresos Conyugue: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="ingresosconyugue" name="ingresosconyugue" placeholder="Q.0.00 (Aproximado)" value = "<?php echo $eco_sueldo_conyugue; ?>" onkeyup = "decimales(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Lugar donde Trabaja: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="trabajoconyugue" name="trabajoconyugue" placeholder="Lugar de Trabajo" value = "<?php echo $eco_lugar_trabajo_conyuge; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Cargas Familiares: <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="cargasfam" name="cargasfam" placeholder="Numero de personas que sostiene" value = "<?php echo $eco_cargas_familiares; ?>" onkeyup = "enteros(this);" maxlength="2">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Lugar de Vivienda: <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<select id="casa" name="casa" class="form-control">
									<option value = "">Seleccione</option>
									<option value = "PROPIA PAGADA">PROPIA PAGADA</option>
									<option value = "PROPIA PAGANDO">PROPIA PAGANDO (DEUDA o PRESTAMO)</option>
									<option value = "ALQUILER">ALQUILER</option>
									<option value = "HUESPED DE FAMILIAR O AMIGO">HUESPED DE FAMILIAR O AMIGO</option>
								</select>
								<script>
									document.getElementById("casa").value = "<?php echo trim($eco_vivienda); ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Cuanto Paga?: <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="costocasa" name="costocasa" placeholder="Q.0.00" value = "<?php echo $eco_pago_vivienda; ?>" onkeyup = "decimales(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Posee Cuentas Bancarias? <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<select id="cuentasbanco" name="cuentasbanco" class="form-control">
									<option value = "">Seleccione</option>
									<option value = "SI">SI</option>
									<option value = "NO">NO</option>
								</select>
								<script>
									document.getElementById("cuentasbanco").value = "<?php echo trim($eco_cuenta_banco); ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Bancos: &nbsp;&nbsp;</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="bancos" name="bancos" placeholder="BANRURAL, BI, G&T, ETC." value = "<?php echo $eco_banco; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Posee Tarjetas de Cr&eacute;dito? <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<select id="tarjetascred" name="tarjetascred" class="form-control">
									<option value = "">Seleccione</option>
									<option value = "SI">SI</option>
									<option value = "NO">NO</option>
								</select>
								<script>
									document.getElementById("tarjetascred").value = "<?php echo trim($eco_tarjeta); ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Empresas o Bancos: &nbsp;&nbsp;</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="bancostarjeta" name="bancostarjeta" placeholder="VISA, MASTERCARD, ETC." value = "<?php echo $eco_operador_tarjeta; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Otros Ingresos: &nbsp;&nbsp;</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="otrosingresos" name="otrosingresos" placeholder="Alquileres, Negocios, Etc." value = "<?php echo $eco_otros_ingresos; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Monto Aprox.: &nbsp;&nbsp;</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="montootros" name="montootros" placeholder="Q.00.00" value = "<?php echo $eco_monto_otros; ?>" onkeyup = "decimales(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Sueldo Liquido: <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="sueldo" name="sueldo" placeholder="Q.00.00" value = "<?php echo $eco_sueldo; ?>" onkeyup = "decimales(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Descuentos: <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="descuentos" name="descuentos" placeholder="Q.00.00" value = "<?php echo $eco_descuentos; ?>" onkeyup = "decimales(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Tiene Presatamos? <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<select id="prestamos" name="prestamos" class="form-control">
									<option value = "">Seleccione</option>
									<option value = "SI">SI</option>
									<option value = "NO">NO</option>
								</select>
								<script>
									document.getElementById("prestamos").value = "<?php echo trim($eco_prestamos); ?>"; 
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Saldo: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="saldo" name="saldo" placeholder="Q.0.00" value = "<?php echo $eco_saldo_prestamos; ?>" onkeyup = "decimales(this);">
							</div>
						</div>
					</div>
					<br>
				</div>
			</div>	
			
			<!--------------->		
			<div class="panel panel-default">
			<div class="panel-heading">INFORMACI&Oacute;N PENAL</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Ha sido detenido(a): <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<select id="detenido" name="detenido" class="form-control">
									<option value = "">Seleccione</option>
									<option value = "SI">SI</option>
									<option value = "NO">NO</option>
								</select>
								<script>
									document.getElementById("detenido").value = "<?php echo trim($pen_detenido); ?>"; 
								</script>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Motivo: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="motivodetenido" name="motivodetenido" placeholder="Motivo de la Detenci&oacute;n" value = "<?php echo $pen_motivo_detenido; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Donde: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="dondedetenido" name="dondedetenido" placeholder="Donde fue detenido" value = "<?php echo $pen_donde_detenido; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Cuando (Aprox.): </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="cuandodetenido" name="cuandodetenido" placeholder="Cuando ocurrio la detenci&oacute;n" value = "<?php echo $pen_cuando_detenido; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Porque: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="porquedetenido" name="porquedetenido" placeholder="Por que fue detenido" value = "<?php echo $pen_porque_detenido; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Cuando Recobro la Libertad: </label>
							<div class="col-sm-6">
								<div class='input-group date'>
									<input type="text" class="form-control" id="feclibertad" name="feclibertad" placeholder="Fecha en la que quedo en libertad" value = "<?php echo $pen_fec_libertad; ?>" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('feclibertad'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Ha sido Arraigado? <span class = "text-danger">*</span></label>
							<div class="col-sm-6">
								<select id="arraigado" name="arraigado" class="form-control">
									<option value = "">Seleccione</option>
									<option value = "SI">SI</option>
									<option value = "NO">NO</option>
								</select>
								<script>
									document.getElementById("arraigado").value = "<?php echo trim($pen_arraigado); ?>";
								</script>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Motivo: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="motivoarraigado" name="motivoarraigado" placeholder="Motivo de Arraigo" value = "<?php echo $pen_motivo_arraigo; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Donde: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="dondearraigo" name="dondearraigo" placeholder="Donde" value = "<?php echo $pen_donde_arraigo; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Cuando (Aprox.): </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="cuandoarraigo" name="cuandoarraigo" placeholder="Cuando fue Arraigado" value = "<?php echo $pen_cuando_arraigo; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Fecha de Penales: </label>
							<div class="col-sm-6">
								<div class='input-group date'>
									<input type="text" class="form-control" id="fecpenales" name="fecpenales" placeholder="Fecha de Antecendentes Penales" value = "<?php echo $per_fec_penales; ?>" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecpenales'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha de Policiacos: </label>
							<div class="col-sm-6">
								<div class='input-group date'>
									<input type="text" class="form-control" id="fecpoliciacos" name="fecpoliciacos" placeholder="Fecha de Antecendentes Policiacos" value = "<?php echo $per_fec_policiacos; ?>" onclick="displayCalendar(this,'dd/mm/yyyy', this)" title="Click para seleccionar la fecha" style="cursor:pointer" readonly >
									<span class="input-group-addon" style="cursor:pointer" onclick="displayCalendar(document.getElementById('fecpoliciacos'),'dd/mm/yyyy', this)"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					</div>
					<br>
				</div>
			</div>
			
			<!--------------->		
			<div class="panel panel-default">
			<div class="panel-heading">INFORMACI&Oacute;N LABORAL ANTERIOR</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">&Uacute;ltimo Empleo: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="ultimoempleo" name="ultimoempleo" placeholder="Ultimo Empleo Civil" value = "<?php echo $lab_empleo; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Tel&eacute;fono: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="telultimoempleo" name="telultimoempleo" placeholder="Tel&eacute;fono donde Labor&oacute;" value = "<?php echo $lab_telefono; ?>" onkeyup = "enteros(this);" maxlength="12">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3 text-right">
							<label class="control-label">Direcci&oacute;n &Uacute;ltimo Empleo: </label>
						</div>
						<div class="col-xs-5">
							<input type="text" class="form-control" id="dirultimoempleo" name="dirultimoempleo" placeholder="Direcci&oacute;n Ultimo Empleo Civil" value = "<?php echo $lab_direccion; ?>" onkeyup = "texto(this);">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Puesto que Desempe&ntilde;&oacute;: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pueultimoempleo" name="pueultimoempleo" placeholder="Puesto Labor&oacute;" value = "<?php echo $lab_puesto; ?>" onkeyup = "texto(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Nombre de la Empresa: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="empultimoempleo" name="empultimoempleo" placeholder="Empresa Ultimo Empleo" value = "<?php echo $lab_sucursal; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="col-sm-6 control-label">Sueldo: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="sueldoultimoempleo" name="sueldoultimoempleo" placeholder="Q.00.00" value = "<?php echo $lab_sueldo; ?>" onkeyup = "decimales(this);">
							</div>
						</div>
						<div class="col-xs-6">
							<label class="col-sm-4 control-label">Fecha de Ingreso: </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="fecultimoempleo" name="fecultimoempleo" placeholder="Mes y A&ntilde;o Aprox." value = "<?php echo $lab_fecha; ?>" onkeyup = "texto(this);">
							</div>
						</div>
					</div>
					<br>
				</div>
			</div>
			
			<!--------------->		
			<div class="panel panel-default">
			<div class="panel-heading">INFORMACI&Oacute;N SOMATOMETRICA</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-xs-12 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<p class="text-muted text-center">Uniforme</p>
					<div class="row">
						<br>
						<div  class="col-sm-10 col-xs-offset-1">
							<table class="table table-striped table-bordered">
								<tr>
									<th class="text-center">Talla Camisa <span class = "text-danger">*</span></th>
									<th class="text-center">Talla Pantal&oacute;n <span class = "text-danger">*</span></th>
									<th class="text-center">Talla Chumpa <span class = "text-danger">*</span></th>
									<th class="text-center">Talla Botas <span class = "text-danger">*</span></th>
									<th class="text-center">Talla Gorra <span class = "text-danger">*</span></th>
								</tr>
								<tr>
									<td>
										<input type="text" class="form-control" id="tcamisa" name="tcamisa" placeholder="15" value = "<?php echo $per_talla_camisa; ?>" onkeyup = "decimales(this);" maxlength="5">
									</td>
									<td>
										<input type="text" class="form-control" id="tpantalon" name="tpantalon" placeholder="32" value = "<?php echo $per_talla_pantalon; ?>" onkeyup = "decimales(this);" maxlength="5">
									</td>
									<td>
										<input type="text" class="form-control" id="tchumpa" name="tchumpa" placeholder="S, M, L o XL" value = "<?php echo $per_chumpa; ?>" onkeyup = "texto(this);" maxlength="3">
									</td>
									<td>
										<input type="text" class="form-control" id="tbotas" name="tbotas" placeholder="40" value = "<?php echo $per_talla_botas; ?>" onkeyup = "decimales(this);" maxlength="5">
									</td>
									<td>
										<input type="text" class="form-control" id="tgorra" name="tgorra" placeholder="S, M, L o XL" value = "<?php echo $per_talla_gorra; ?>" onkeyup = "texto(this);" maxlength="3">
									</td>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<br>
					<p class="text-muted text-center">Caracter&iacute;sticas F&iacute;sicas</p>
					<div class="row">
						<br>
						<div  class="col-sm-10 col-xs-offset-1">
							<table class="table table-striped table-bordered">
								<tr>
									<th class="text-center">Estatura (mts.) <span class = "text-danger">*</span></th>
									<th class="text-center">Peso (lbs.) <span class = "text-danger">*</span></th>
									<th class="text-center">Color de Tez <span class = "text-danger">*</span></th>
									<th class="text-center">Color de Ojos <span class = "text-danger">*</span></th>
									<th class="text-center">Nariz <span class = "text-danger">*</span></th>
								</tr>
								<tr>
									<td>
										<input type="text" class="form-control" id="estatura" name="estatura" placeholder="1.70" value = "<?php echo $per_estatura; ?>" onkeyup = "decimales(this);" maxlength="5">
									</td>
									<td>
										<input type="text" class="form-control" id="peso" name="peso" placeholder="170" value = "<?php echo $per_peso; ?>" onkeyup = "decimales(this);" maxlength="7">
									</td>
									<td>
										<input type="text" class="form-control" id="tez" name="tez" placeholder="Morena, Clara, Color, etc." value = "<?php echo $per_tez; ?>" onkeyup = "texto(this);">
									</td>
									<td>
										<input type="text" class="form-control" id="ojos" name="ojos" placeholder="Negros, Verdes, Azules, etc." value = "<?php echo $per_ojos; ?>" onkeyup = "texto(this);">
									</td>
									<td>
										<input type="text" class="form-control" id="nariz" name="nariz" placeholder="chata, respingada, aguilosa, etc." value = "<?php echo $per_nariz; ?>" onkeyup = "texto(this);">
									</td>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" onclick = "Limpiar();" title="Cancelar transacci&oacute;n y limpiar la p&aacute;gina">
								<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> Cancelar
							</button>
							&nbsp;&nbsp;&nbsp;
							<button type="button" class="btn btn-success" onclick = "Modificar();" title="Grabar Informaci&oacute;n de en el formulario">
								<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Grabar
							</button>
						</div>
					</div>
				</div>	
			</div>
			
		<nav class="navbar navbar-default footer" role="navigation">
			<div class="row">
				<div class="col-xs-12 text-center">
					<img src = "../../CONFIG/images/escudo.png" width = "35px">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 text-center">
					Powered by Escuela Polit&eacute;cnica Web Development Team. PBX: 6630-2222 Inform&aacute;tica
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 text-center">
					<strong> :. EP &copy; 2016 COPYRIGHT Espa&ntilde;ol .:</strong>
				</div>
			</div>
		</nav>
		
	<!-- //////////////////////////////////////////////////////// -->
	<!-- Modal -->
	    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      <div id = "ModalDialog" class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
		    <h4 class="modal-title text-left" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "60px;" /> &nbsp; Escuela Polit&eacute;cnica</h4>
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
	
	</div>
	<!-- jQuery -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
    
	<!-- Bootstrap Core JavaScript -->
	<script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
	<!-- Librerias Propias Utilitarias -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/isp.js"></script>
  </body>
</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>