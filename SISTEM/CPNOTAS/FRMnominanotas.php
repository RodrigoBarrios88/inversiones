<?php
	include_once('xajax_funct_notas.php');
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum_vigente = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$pensum = ($pensum == "")?$pensum_vigente:$pensum;
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$tipo = $_REQUEST["tipo"];
	$num = $_REQUEST["num"];
	$tipo = ($tipo == "")?"1":$tipo;
	//--- Configuraciones de impresión
	$materiarows = $_REQUEST["materiarows"];
	$notaminima = $_REQUEST["notaminima"];
	$notaminima = ($notaminima == "")?"65":$notaminima;
	$font = $_REQUEST["font"];
	$font = ($font == "")?"6":$font;
	$anchocols = $_REQUEST["anchocols"];
	$anchocols = ($anchocols == "")?"12":$anchocols;
	$orientacion = $_REQUEST["orientacion"];
	$orientacion = ($orientacion == "")?"L":$orientacion;
	$papel = $_REQUEST["papel"];
	$papel = ($papel == "")?"Legal":$papel;
	
	$ClsAcadem = new ClsAcademico();
	$ClsPen = new ClsPensum();
	
	if($tipo_usuario == 2){ //// MAESTRO
		$result_niveles = $ClsAcadem->get_nivel_maestro($pensum,'',$tipo_codigo);
		$result_grados = $ClsAcadem->get_grado_maestro($pensum,$nivel,'',$tipo_codigo);
		$result_secciones = $ClsAcadem->get_seccion_maestro($pensum,$nivel,$grado,'',$tipo_codigo,'','',1);
	}else if($tipo_usuario == 1){ ////// DIRECTORA
		$result_niveles = $ClsAcadem->get_nivel_otros_usuarios($pensum,'',$tipo_codigo);
		$result_grados = $ClsAcadem->get_grado_otros_usuarios($pensum,$nivel,'',$tipo_codigo);
		$result_secciones = $ClsPen->get_seccion($pensum,$nivel,$grado,'','',1);
	}else if($tipo_usuario == 5){ /////// ADMINISTRADOR
		$result_niveles = $ClsPen->get_nivel($pensum,'',1);
		$result_grados = $ClsPen->get_grado($pensum,$nivel,'',1);
		$result_secciones = $ClsPen->get_seccion($pensum,$nivel,$grado,'','',1);
	}else{
		$valida = "";
	}
	
	if(is_array($result_niveles)){
		$combo_nivel = combos_html_onclick($result_niveles,"nivel","niv_codigo","niv_descripcion","Submit();");
	}else{
		$combo_nivel = combos_vacios("nivel");
	}
	if(is_array($result_grados)){
		$combo_grado = combos_html_onclick($result_grados,"grado","gra_codigo","gra_descripcion","Submit();");
	}else{
		$combo_grado = combos_vacios("grado");
	}
	if(is_array($result_secciones)){
		$combo_seccion = combos_html_onclick($result_secciones,"seccion","sec_codigo","sec_descripcion","Submit();");
	}else{
		$combo_seccion = combos_vacios("grado");
	}
	
	///////////////////////// T&Iacute;TULO DE LA NOMINA //////////////////////////////////////////
	
	if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
		$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion,'',1);
		if(is_array($result)){
			foreach($result as $row){
				$grado_desc = utf8_decode($row["gra_descripcion"]);
				$seccion_desc = utf8_decode($row["sec_descripcion"]);
			}
		}
		$titulo = trim("Informe de Notas para $grado_desc Sección $seccion_desc");
	}else if($pensum != "" && $nivel != "" && $grado != ""){
		$result = $ClsPen->get_grado($pensum,$nivel,$grado,1);
		if(is_array($result)){
			foreach($result as $row){
				$grado_desc = utf8_decode($row["gra_descripcion"]);
				$seccion_desc = utf8_decode($row["sec_descripcion"]);
			}
		}
		$titulo = trim("Informe de Notas para $grado_desc");
	}else{
		$titulo = "Informe de Notas";
	}
	
	
	if($tipo == 1){
		switch($num){
			case 1: $num_desc = "1ra."; break;
			case 2: $num_desc = "2da."; break;
			case 3: $num_desc = "3ra."; break;
			case 4: $num_desc = "4ta."; break;
			case 5: $num_desc = "5ta."; break;
			default: $num_desc = "Presente";
		}
		$titulo = utf8_decode("$titulo");
	}else if($tipo == 3){
		$titulo = utf8_decode("Informe Final de Notas");
	}else{
		$titulo = utf8_decode("$titulo");
	}
	
	////////////////// -- EXONERACIONES -- ///////////////////////
	$chkexonera = $_REQUEST["chkexonera"];
	////////////////// -- FORMATO DE NOTAS -- ///////////////////////
	$chkzona = $_REQUEST["chkzona"];
	$chknota = $_REQUEST["chknota"];
	$chktotal = $_REQUEST["chktotal"];
	
	//echo "$nombre, $valida";
if($nombre != "" && $valida != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
    
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
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

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
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
						 <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario Gestor de Usuarios</a></li>
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
						<li class="active">
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_vernotas.php">
										<i class="fa fa-list-ol"></i> ver  Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_sabana.php">
										<i class="fa fa-list-ol"></i> ver  Notas Sabana
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 ||$tipo_usuario == 5 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_asignotas.php">
										<i class="fa fa-save"></i> Ingreso de Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlist_certificanotas.php">
										<i class="fa fa-check-square-o"></i> Certificar  Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlist_editnotas.php">
										<i class="fa fa-edit"></i> Modificar de Notas
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMnominanotas.php">
										<i class="fa fa-file-text-o"></i> Nomina de Notas  por Grados
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlist_alumnosnotas.php">
										<i class="fa fa-file-text-o"></i> Tarjeta de Calificaciones
									</a>
								</li>	
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
									<a href="FRMlist_alumnoscuadro.php">
										<i class="fa fa-trophy"></i> Cuadro de Honor por Grado y Unidad
									</a>
								</li>	
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUacademico.php">
										<i class="fa fa-indent"></i> Men&uacute
									</a>
								</li>
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
			<br>
			<form name = "f1" id = "f1" method="get">
			<div class="panel panel-default">
				<div class="panel-heading"> 
					<span class="fa fa-file-text-o" aria-hidden="true"></span>
					Generar Nominas de Notas
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Programa Acad&eacute;mico:</label></div>
						<div class="col-xs-5"><label>Nivel:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<?php echo pensum_html("pensum","Submit();"); ?>
							<?php if($pensum != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("pensum").value = '<?php echo $pensum; ?>';
							</script>
							<?php } ?>
						</div>
						<div class="col-xs-5" id = "divnivel">
							<?php if($pensum != ""){
								echo $combo_nivel;
							?>
							<script type = "text/javascript">
								document.getElementById("nivel").value = '<?php echo $nivel; ?>';
							</script>
							<?php }else{
									echo combos_vacios("nivel");
								}	
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>Grado de los Alumnos: </label></div>
						<div class="col-xs-5"><label>Secci&oacute;n:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1" id = "divgrado">
							<?php if($pensum != "" && $nivel != ""){
									echo $combo_grado; 
								}else{
									echo combos_vacios("grado");
								}	
							?>
							<?php if($pensum != "" && $nivel != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("grado").value = '<?php echo $grado; ?>';
							</script>
							<?php } ?>
						</div>
						<div class="col-xs-5" id = "divseccion">
							<?php if($pensum != "" && $nivel != "" && $grado != ""){
									echo $combo_seccion;
								}else{
									echo combos_vacios("seccion");
								}	
							?>
							<?php if($pensum != "" && $nivel != "" && $grado != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("seccion").value = '<?php echo $seccion; ?>';
							</script>
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1"><hr></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1"><label>T&iacute;po Evaluaciones:</label></div>
						<div class="col-xs-5"><label>Numero de Unidad:</label></div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<select id = "tipo" name = "tipo" class = "form-control" onchange="Submit();">
								<option value = "">Selecciones</option>
								<option value = "1" selected >EVALUACION PARCIAL O DE UNIDAD</option>
								<option value = "3">EVALUACION FINAL</option>
							</select>
							<?php if($tipo != ""){ ?>
							<script type = "text/javascript">
								document.getElementById("tipo").value = '<?php echo $tipo; ?>';
							</script>
							<?php } ?>
						</div>
						<div class="col-xs-5" >
							<?php
								if($tipo != 1){
									$disabled = "disabled";
									$num = 0;
								}else{
									$disabled = "";
									$num = $num;
								}	
							?>
							<?php
								if($nivel != ""){
									echo unidades_html($nivel,'num','',$disabled);
								}else{
									echo combos_vacios("num");
								}
							?>
							<script type = "text/javascript">
								<?php if($num != ""){ ?>
									document.getElementById("num").value = '<?php echo $num; ?>';
							   <?php } ?>
							   <?php if($tipo != 1){ ?>
									document.getElementById("num").value = '';
									document.getElementById("num").setAttribute("disabled","disabled");
							   <?php } ?>
							</script>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1" id = "divmateria">
							<?php
								if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
									$ClsPen = new ClsPensum();
									$ClsAcadem = new ClsAcademico();
									
									if($tipo_usuario == 2){ //// MAESTRO
										$result_materias = $ClsAcadem->get_materia_seccion_maestro($pensum,$nivel,$grado,$seccion,'',$tipo_codigo);
									}else if($tipo_usuario == 1){ //// DIRECTORA
										$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,'','1',1);
									}if($tipo_usuario == 5){ /// ADMINISTRADOR
										$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,'','1',1);
									}
									
									if(is_array($result_materias)){
										if($tipo_usuario == 2){ //// MAESTRO
											echo lista_multiple_html($result_materias,'materia','secmat_materia','materia_descripcion','Listado de Materias a Incluir');
										}else if($tipo_usuario == 1){ //// DIRECTORA
											echo lista_multiple_html($result_materias,'materia','mat_codigo','mat_descripcion','Listado de Materias a Incluir');
										}else if($tipo_usuario == 5){ //// ADMINISTRADOR
											echo lista_multiple_html($result_materias,'materia','mat_codigo','mat_descripcion','Listado de Materias a Incluir');
										}
									}else{
										echo lista_multiple_vacia('materia','Listado de Materias a Incluir');
									}
								}else{		
									echo lista_multiple_vacia("materia","Listado de Materias a Incluir");
								}
							?>
							<?php if($materiarows != ""){ ?>
								<script type = "text/javascript">
									<?php
										for($i = 1; $i <= $materiarows; $i++){
											if($_REQUEST["materia$i"] != ""){
									?>
										document.getElementById("materia<?php echo $i; ?>").checked = 'checked';
									<?php
											}
										}
									?>
								</script>
							<?php } ?>
						</div>
						<div class="col-xs-5">
							<div class="row">
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-12"><label>T&iacute;tulo:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-12">
											<input type="text" class="form-control" id ="titulo" name="titulo" onkeyup="texto(this);" value="<?php echo $titulo; ?>" readonly />
										</div>
									</div>
								</div>
							</div>
							
							<br>
							
							<div class="row">
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-6">
											<label>Nota M&iacute;nima:</label>
											<input type="text" class="form-control" id ="notaminima" name="notaminima" value = "<?php echo $notaminima; ?>" onkeyup="decimales(this)" />
										</div>
										<div class="col-xs-6">
											<label>Uso del Reporte:</label><br>
											<select id = "chkexonera" name = "chkexonera" class = "form-control">
												<option value = "">Control Acad&eacute;mico</option>
												<option value = "1">Reporte para Exoneraci&oacute;n</option>
											</select>
											<script type = "text/javascript">
												document.getElementById("chkexonera").value = '<?php echo $chkexonera; ?>';
											</script>
										</div>
									</div>
								</div>
							</div>
							
							<br>
							
							<div class="row">
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-12"><label>Formato de Data en el Reporte:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-4">
											<label>Actividades <input type="checkbox" name = "chkzona" id = "chkzona" value="1" /> &nbsp; + </label>
										</div>
										<div class="col-xs-4">
											<label>Evaluacion <input type="checkbox" name = "chknota" id = "chknota" value="1" /> &nbsp; = </label>
										</div>
										<div class="col-xs-4">
											<label>Total <input type="checkbox" name = "chktotal" id = "chktotal" value="1" checked= /> </label>
										</div>
										<script>
											var chkzona = '<?php echo $chkzona; ?>';
											var chknota = '<?php echo $chknota; ?>';
											var chktotal = '<?php echo $chktotal; ?>';
											if(chkzona == 1){
												document.getElementById("chkzona").checked = true;
											}
											if(chknota == 1){
												document.getElementById("chknota").checked = true;
											}
											if(chktotal == 1){
												document.getElementById("chktotal").checked = true;
											}
										</script>
									</div>
								</div>
							</div>
							
							<br>
							
							<div class="row">
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-6"><label>Tama&ntilde;o de Letra:</label></div>
										<div class="col-xs-6"><label>Ancho de Columnas (mm.):</label></div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<select id = "font" name = "font" class = "form-control">
												<option value = "">Selecciones</option>
												<option value = "2">2</option>
												<option value = "4">4</option>
												<option value = "6">6</option>
												<option value = "8">8</option>
												<option value = "10">10</option>
												<option value = "12">12</option>
												<option value = "14">14</option>
											</select>
											<?php if($font != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("font").value = '<?php echo $font; ?>';
											</script>
											<?php } ?>
										</div>
										<div class="col-xs-6">
											<input type="text" class="form-control" id ="anchocols" name="anchocols" value = "<?php echo $anchocols; ?>" onkeyup="enteros(this)" />
										</div>
									</div>
								</div>
							</div>
							
							<br>
							
							<div class="row">
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-6"><label>Tipo de Papel:</label></div>
										<div class="col-xs-6"><label>Orientaci&oacute;n:</label></div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<select id = "papel" name = "papel" class = "form-control">
												<option value = "">Selecciones</option>
												<option value = "Letter">CARTA</option>
												<option value = "Legal" >OFICIO</option>
											</select>
											<?php if($papel != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("papel").value = '<?php echo $papel; ?>';
											</script>
											<?php } ?>
										</div>
										<div class="col-xs-6">
											<select id = "orientacion" name = "orientacion" class = "form-control">
												<option value = "">Selecciones</option>
												<option value = "L">Horizontal</option>
												<option value = "P">Vertical</option>
											</select>
											<?php if($orientacion != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("orientacion").value = '<?php echo $orientacion; ?>';
											</script>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							
							<br>
							
							<div class="row">
								<div class="col-xs-12 text-center">
									<a class="btn btn-primary" onclick="tablaListaNotas('VI');" title = "Desplegar Listado" ><span class="fa fa-file-text"></span> &nbsp; <strong>Revisar</strong>&nbsp;  <span class="fa fa-angle-double-right"></span></a> 
									<a class="btn btn-default" onclick="tablaListaNotas('PR');" title = "Desplegar Listado" ><span class="fa fa-print text-primary"></span> &nbsp; <strong class="text-primary">Imprimir </strong>&nbsp;  <span class="fa fa-angle-double-right text-primary"></span></a> 
									<a class="btn btn-default" onclick="tablaListaNotas('EX');" title = "Desplegar Listado" ><span class="fa fa-file-excel-o text-success"></span> &nbsp; <strong class="text-success">Excel</strong>&nbsp;  <span class="fa fa-angle-double-right text-success"></span></a> 
								</div>
							</div>
							
						</div>	
					</div>	
				</div>
			</div>
			<br>
         <div class="row" id = "result"></div>
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
					<h4 class="modal-title text-left" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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
	
	<!-- Metis Menu Plugin JavaScript -->
	<script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script src="../assets.3.6.2/dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/academico/notas.js"></script>
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