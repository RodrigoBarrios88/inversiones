<?php
	include_once('../../html_fns.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$situacion = $_REQUEST["situacion"];
	$situacion = ($situacion == "")?1:$situacion;
	
	$columnas = $_REQUEST["columnas"];
	//print_r($columnas);
	
	$ClsAlu = new ClsAlumno();
	$ClsAlu->get_alumno_reportes('1234567890101');
	
if($usuario != "" && $nombre != "" && $valida != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
    <!-- CSS personalizado -->
    <link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- Dual Listbox -->
	<link rel="stylesheet" type="text/css" href="../../assets.3.6.2/css/plugins/dualListbox/bootstrap-duallistbox.css">
    
    <!-- MetisMenu CSS -->
    <link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!-- Custom CSS -->
    <link href="../../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                <?php echo $_SESSION["rotulos_colegio_subpantalla"]; ?>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Perfil de Usuario</a></li>
                        <li class="divider"></li>
                        <li><a href="../../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
                        </li>
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
									<a href="../FRMnewalumno.php">
										<i class="fa fa-plus-circle"></i> Agregar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=1">
										<i class="fa fa-edit"></i> Actualizar Datos de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=4">
										<i class="fa fa-list-alt"></i> Ficha T&eacute;cnica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../../CPFICHAPRESCOOL/FRMsecciones.php">
										<i class="fa fa-file-text-o"></i> Ficha Preescolar
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=5">
										<i class="fa fa-comments"></i> Bit&aacute;cora Psicopedag&oacute;gica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=3">
										<i class="fa fa-camera"></i> Re-Ingreso de Fotograf&iacute;as
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=2">
										<i class="fa fa-group"></i> Asignaci&oacute;n Extracurricular
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=6">
										<i class="fa fa-ban"></i> Inhabilitar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=7">
										<i class="fa fa-check-circle-o"></i> Activar Alumnos
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMrepasiggrupo.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos/Grupos
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../../menu.php">
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
            <div class="panel panel-default">
				<div class="panel-heading"><i class="glyphicon glyphicon-print"></i> Reporte y Listado de Alumnos</div>
                <div class="panel-body">
					<form name = "f1" id = "f1" method="get">
						<div class="row">
							<div class="col-xs-5 col-xs-offset-1">
								<label>Programa Acad&eacute;mico:</label>
								<?php echo pensum_html("pensum","Submit();"); ?>
								<?php if($pensum != ""){ ?>
								<script type = "text/javascript">
									document.getElementById("pensum").value = '<?php echo $pensum; ?>';
								</script>
								<?php } ?>
							</div>
							<div class="col-xs-5" id = "divnivel">
								<label>Nivel:</label>
								<?php if($pensum != ""){
									echo nivel_html($pensum,"nivel","Submit();");
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
							<div class="col-xs-5 col-xs-offset-1" id = "divgrado">
								<label>Grado de los Alumnos:</label>
								<?php if($pensum != "" && $nivel != ""){
										echo grado_html($pensum,$nivel,"grado","Submit();");
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
							<div class="col-xs-5">
								<label>Secci&oacute;n:</label>
								<?php if($pensum != "" && $nivel != "" && $grado != ""){
										echo seccion_html($pensum,$nivel,$grado,"","seccion","Submit();");
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
							<div class="col-xs-5 col-xs-offset-1" id = "divgrado">
								<label>Situaci&oacute;n del Alumno:</label>
								<select class="form-control" id = "situacion" name="situacion" >
									<option value="1" selected>Activo</option>
									<option value="2">Inactivo</option>
								</select>
								<script type = "text/javascript">
									document.getElementById("situacion").value = '<?php echo $situacion; ?>';
								</script>
							</div>
							<div class="col-xs-5">
								
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label>Datos del Alumno:</label>
								<select class="dual_select"  id = "columnas1" name="columnas1[]" multiple style="min-height: 250px;" >
									<option value="cui" selected>ID (CUI o Pasaporte)</option>
									<option value="tipo_cui">Tipo de ID</option>
									<option value="codigo_interno">C&oacute;digo Interno (Colegio)</option>
									<option value="codigo_mineduc">C&oacute;digo MINEDUC</option>
									<option value="nombre" selected>Nombres</option>
									<option value="apellido" selected>Apellidos</option>
									<option value="fecha_nacimiento" selected>Fecha de Nacimiento</option>
									<option value="edad" selected>Edad</option>
									<option value="nacionalidad">Nacionalidad</option>
									<option value="religion">Religi&oacute;n</option>
									<option value="idioma">Idioma</option>
									<option value="genero">Genero</option>
									<option value="tipo_sangre">Tipo de Sangre</option>
									<option value="alergico_a">Alergico a</option>
									<option value="emergencia">Emergencia/Avisar a</option>
									<option value="emertel">Tel&eacute;fono/Emergencia</option>
									<option value="mail">Email del Alumno</option>
									<option value="nit">NIT de Facturaci&oacute;n</option>
									<option value="cliente">Nombre para Facturaci&oacute;n</option>
									<option value="recoge">Quien llega a recoger en el colegio</option>
									<option value="redes_sociales">Autoriza publicar en Redes Sociales</option>
									<option value="nivel">Nivel</option>
									<option value="grado">Grado</option>
									<option value="seccion">Secci&oacute;n</option>
									<option value="seguro">Cuenta con Seguro M&eacute;dico</option>
									<option value="poliza">No. de Poliza de Seguro</option>
									<option value="aseguradora">Aseguradora</option>
									<option value="plan">Plan de Seguro</option>
									<option value="asegurado">Asegurado Principal</option>
									<option value="instrucciones">Instrucciones al Seguro</option>
									<option value="comentarios">Comentarios por Seguro</option>
									<option value="situacion">Situaci&oacute;n</option>
								</select>
							</div>
						</div>
						<!-- -->
						<hr>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label>Datos del Padre:</label>
								<select class="dual_select"  id = "columnas2" name="columnas2[]" multiple style="min-height: 250px;" >
									<option value="padre_cui">ID del Padre (DPI o Pasaporte)</option>
									<option value="padre_tipo_dpi">Tipo ID del Padre</option> 
									<option value="padre_nombre">Nombres del Padre</option> 
									<option value="padre_apellido">Apellidos del Padre</option> 
									<option value="padre_fecha_nacimiento">Fecha de Nacimiento del Padre</option> 
									<option value="padre_edad">Edad del Padre</option> 
									<option value="padre_estado_civil">Estado Civil del Padre</option> 
									<option value="padre_nacionalidad">Nacionalidad del Padre</option> 
									<option value="padre_telefono">Tel&eacute;fono del Padre</option> 
									<option value="padre_celular">Celular del Padre</option> 
									<option value="padre_mail">E-Mail Padre</option> 
									<option value="padre_direccion">Direcci&oacute;n del Padre</option> 
									<option value="padre_lugar_trabajo">Lugar de Trabajo del Padre</option> 
									<option value="padre_telefono_trabajo">Tel&eacute;fono del Trabajo del Padre</option> 
									<option value="padre_profesion">Profesi&oacute;n del Padre</option>
								</select>
							</div>
						</div>
						<!-- -->
						<hr>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label>Datos de la Madre:</label>
								<select class="dual_select"  id = "columnas3" name="columnas3[]" multiple style="min-height: 250px;" >
									<option value="madre_cui">ID de la Madre (DPI o Pasaporte)</option>
									<option value="madre_tipo_dpi">Tipo ID de la Madre</option> 
									<option value="madre_nombre">Nombres de la Madre</option> 
									<option value="madre_apellido">Apellidos de la Madre</option> 
									<option value="madre_fecha_nacimiento">Fecha de Nacimiento de la Madre</option> 
									<option value="madre_edad">Edad de la Madre</option> 
									<option value="madre_estado_civil">Estado Civil de la Madre</option> 
									<option value="madre_nacionalidad">Nacionalidad de la Madre</option> 
									<option value="madre_telefono">Tel&eacute;fono de la Madre</option> 
									<option value="madre_celular">Celular de la Madre</option> 
									<option value="madre_mail">E-Mail Madre</option> 
									<option value="madre_direccion">Direcci&oacute;n de la Madre</option> 
									<option value="madre_lugar_trabajo">Lugar de Trabajo de la Madre</option> 
									<option value="madre_telefono_trabajo">Tel&eacute;fono del Trabajo de la Madre</option> 
									<option value="madre_profesion">Profesi&oacute;n de la Madre</option>
								</select>
							</div>
						</div>
						<!-- -->
						<hr>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<label>Datos de Alg&uacute;n Otro Encargado:</label>
								<select class="dual_select"  id = "columnas4" name="columnas4[]" multiple style="min-height: 250px;" >
									<option value="encargado_cui">ID de Otro Encargado (DPI o Pasaporte)</option>
									<option value="encargado_tipo_dpi">Tipo ID de Otro Encargado</option> 
									<option value="encargado_nombre">Nombres de Otro Encargado</option> 
									<option value="encargado_apellido">Apellidos de Otro Encargado</option> 
									<option value="encargado_parentesco">Parentesco de Otro Encargado</option> 
									<option value="encargado_fecha_nacimiento">Fecha de Nacimiento de Otro Encargado</option> 
									<option value="encargado_edad">Edad de Otro Encargado</option> 
									<option value="encargado_estado_civil">Estado Civil de Otro Encargado</option> 
									<option value="encargado_nacionalidad">Nacionalidad de Otro Encargado</option> 
									<option value="encargado_telefono">Tel&eacute;fono de Otro Encargado</option> 
									<option value="encargado_celular">Celular de Otro Encargado</option> 
									<option value="encargado_mail">E-Mail Madre</option> 
									<option value="encargado_direccion">Direcci&oacute;n de Otro Encargado</option> 
									<option value="encargado_lugar_trabajo">Lugar de Trabajo de Otro Encargado</option> 
									<option value="encargado_telefono_trabajo">Tel&eacute;fono del Trabajo de Otro Encargado</option> 
									<option value="encargado_profesion">Profesi&oacute;n de Otro Encargado</option>
								</select>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-12 text-center">
								<a class="btn btn-default" href = "FRMreplistado.php"><span class="fa fa-eraser"></span> Limpiar</a>
								<button type="button" class="btn btn-danger btn-outline" onclick="PDF();" ><span class="fa fa-file-pdf-o"></span> PDF</button>
								<button type="button" class="btn btn-success btn-outline" onclick="Excel();" ><span class="fa fa-file-excel-o"></span> Excel</button>
							</div>
						</div>
					</form>
				</div>
            </div>
             <!-- /.panel-default -->
			 <br>
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
				<h4 class="modal-title text-left" id="myModalLabel"><img src="../../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?></h4>
			 </div>
			 <div class="modal-body text-center" id= "lblparrafo">
				<img src = "../../../CONFIG/images/img-loader.gif" width="100px" /><br>
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
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Dual List Box -->
    <script src="../../assets.3.6.2/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../assets.3.6.2/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/app/alumno.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		var dual = $('select[name="columnas1[]"]').bootstrapDualListbox();
		var dual = $('select[name="columnas2[]"]').bootstrapDualListbox();
		var dual = $('select[name="columnas3[]"]').bootstrapDualListbox();
		var dual = $('select[name="columnas4[]"]').bootstrapDualListbox();
		
		function PDF(){
			var columnas = 0;
			$('#columnas1 option:selected').each(function() {
				columnas++;
		    });
			$('#columnas2 option:selected').each(function() {
				columnas++;
		    });
			$('#columnas3 option:selected').each(function() {
				columnas++;
		    });
			$('#columnas4 option:selected').each(function() {
				columnas++;
		    });
			if(columnas >= 1){
				if(columnas <= 10){
					myform = document.forms.f1;
					myform.method = "get";
					myform.target ="_blank";
					myform.action ="REPlista.php";
					myform.submit();
					myform.action ="";
					myform.target ="";
					myform.method = "get";
				}else{
					swal("Alto", "Para generar este listado en PDF no debe de exceder mas de 11 columnas, podr\u00EDan desplegarse fuera de la p\u00E1gina...", "warning");
				}
			}else{
				swal("Alto", "Para generar este listado en PDF debe seleccionar al menos 1 columna...", "info");
			}
		}
		
		function Excel(){
			var columnas = 0;
			$('#columnas1 option:selected').each(function() {
				columnas++;
		    });
			$('#columnas2 option:selected').each(function() {
				columnas++;
		    });
			$('#columnas3 option:selected').each(function() {
				columnas++;
		    });
			$('#columnas4 option:selected').each(function() {
				columnas++;
		    });
			if(columnas >= 1){
				myform = document.forms.f1;
				myform.method = "get";
				myform.target ="_blank";
				myform.action ="EXCELlista.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
				myform.method = "get";
			}else{
				swal("Alto", "Para generar este listado en PDF debe seleccionar al menos 1 columna...", "info");
			}
		}
    </script>	

</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>