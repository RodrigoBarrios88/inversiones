<?php
	include_once('xajax_funct_alumno.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAlu = new ClsAlumno();
	$alumnos = $_REQUEST["alumnos"];
	$padres = $_REQUEST["padres"];
	// valida //
	$alumnos = ($alumnos != "")?$alumnos : 1;
	$padres = ($padres != "")?$padres : 1; 
	
if($usuario != "" && $nombre != "" && $valida != ""){ 	
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
									<a href="FRMsecciones.php?acc=1">
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
		<form action="FRMnewalumno.php" name = "f1" name = "f1" method="get" enctype="multipart/form-data">
			<br>
			<!-- .panel-default -->
         <div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-user"></i> Formulario de Inscripci&oacute;n de Alumnos
				</div>
            <div class="panel-body" id = "formulario">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1 text-danger">* Campos Obligatorios</div>
						<div class="col-xs-5 text-right">
							<div class="btn-group" role="group" aria-label="Botones de + y -">
								<button type="button" class="btn btn-primary" onclick="MenosFilasHijos()" ><span class="fa fa-minus" aria-hidden="true"></span></button>
								<button type="button" class="btn btn-default" disabled="disabled"># Alumnos</button>
								<button type="button" class="btn btn-primary" onclick="MasFilasHijos()" ><span class="fa fa-plus" aria-hidden="true"></span></button>
								<input type = "hidden" name = "alumnos" id = "alumnos" value = "<?php echo $alumnos; ?>" />
							</div>
						</div>
					</div>
				<?php for($i = 1; $i <= $alumnos; $i++){ ?>	
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>CUI:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "cui<?php echo $i; ?>" id = "cui<?php echo $i; ?>" value = "<?php echo $_REQUEST["cui$i"]; ?>" onkeyup = "enteros(this)" maxlength = "13"/>
						</div>	
						<div class="col-xs-5">
							<label>C&oacute;digo Interno:  </label>
							<input type = "text" class = "form-control" name = "codigo<?php echo $i; ?>" id = "codigo<?php echo $i; ?>" value = "<?php echo $_REQUEST["codigo$i"]; ?>" onkeyup = "enteros(this)" maxlength = "15"/>
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nombre:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "nombre<?php echo $i; ?>" id = "nombre<?php echo $i; ?>"  value = "<?php echo $_REQUEST["nombre$i"]; ?>" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>Apellido:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "apellido<?php echo $i; ?>" id = "apellido<?php echo $i; ?>" value = "<?php echo $_REQUEST["apellido$i"]; ?>" onkeyup = "texto(this)" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Fecha de Nacimiento:  </label> <span class="text-danger">*</span>
							<div class='input-group date'>
								<input type='text' class="form-control" id = "fecnac<?php echo $i; ?>" name="fecnac<?php echo $i; ?>" value = "<?php echo $_REQUEST["fecnac$i"]; ?>" onblur="xajax_Calcular_Edad(this.value,<?php echo $i; ?>);" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>	
						<div class="col-xs-5">
							<label>Edad:  </label> <span class="text-danger">*</span>
							<strong class="form-control text-center" id = "sedad<?php echo $i; ?>"><?php echo $_REQUEST["edad$i"]; ?> a&ntilde;os</strong>
							<input type = "hidden" name = "edad<?php echo $i; ?>" id = "edad<?php echo $i; ?>" value = "<?php echo $_REQUEST["edad$i"]; ?>" />
						</div>	
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nivel:  </label> <span class="text-danger">*</span>
							<?php echo nivel_html($pensum,"nivel$i","xajax_Nivel_Grado($pensum,this.value,'grado$i','divgra$i',$i);"); ?>
							<input type="hidden" id = "pensum<?php echo $i; ?>" name = "pensum<?php echo $i; ?>" value = "<?php echo $pensum; ?>" />
						</div>
						<div class="col-xs-5">
							<label>Genero:  </label> <span class="text-danger">*</span>
							<select class = "form-control" name = "genero<?php echo $i; ?>" id = "genero<?php echo $i; ?>" >
								<option value ="">Seleccione</option>
								<option value ="M">MASCULINO</option>
								<option value ="F">FEMENINO</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Grado:  </label> <span class="text-danger">*</span>
							<div id = "divgra<?php echo $i; ?>">
							<?php
								if($_REQUEST["nivel$i"] != ""){
									$nivel = $_REQUEST["nivel$i"];
									echo grado_html($pensum,$_REQUEST["nivel$i"],"grado$i","xajax_Grado_Seccion_Alumno($pensum,$nivel,this.value,'seccion$i','divsec$i');");
								}else{
									echo combos_vacios("grado$i");
								}	
							?>
							</div>
						</div>	
						<div class="col-xs-5">
							<label>Secci&oacute;n:  &nbsp; </label>
							<div id = "divsec<?php echo $i; ?>">
							<?php
								if($_REQUEST["nivel$i"] != "" && $_REQUEST["grado$i"] != ""){
									echo seccion_html($pensum,$_REQUEST["nivel$i"],$_REQUEST["grado$i"],"","seccion$i","");
								}else{
									echo combos_vacios("seccion$i");
								}	
							?>
							</div>
						</div>
						<script>
							document.getElementById("genero<?php echo $i; ?>").value = '<?php echo $_REQUEST["genero$i"]; ?>';
							document.getElementById("nivel<?php echo $i; ?>").value = '<?php echo $_REQUEST["nivel$i"]; ?>';
							document.getElementById("grado<?php echo $i; ?>").value = '<?php echo $_REQUEST["grado$i"]; ?>';
							document.getElementById("seccion<?php echo $i; ?>").value = '<?php echo $_REQUEST["seccion$i"]; ?>';
						</script>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nit a Facturar:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "nit<?php echo $i; ?>" id = "nit<?php echo $i; ?>"  value = "<?php echo $_REQUEST["nit$i"]; ?>" onkeyup = "texto(this);" onblur = "Cliente(<?php echo $i; ?>);" />
						</div>	
						<div class="col-xs-5">
							<label>Nombre del Cliente:  </label> <span class="text-danger">*</span>
							<input type="text" class="form-control" name = "clinombre<?php echo $i; ?>" id = "clinombre<?php echo $i; ?>" value = "<?php echo $_REQUEST["clinombre$i"]; ?>"  onkeyup = "texto(this);" />
						</div>	
					</div>
					<br>
					<hr>
				<?php } ?>
				</div>
         </div>
			<!-- /.panel-default -->
			
			<!-- .panel-succes -->
			<div class="panel panel-success">
				<div class="panel-heading">
					<i class="fa fa-group"></i> Formulario de Padres o Responsables
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1 text-danger">* Campos Obligatorios</div>
						<div class="col-lg-5 col-xs-5 text-right">
							<div class="btn-group" role="group" aria-label="Botones de + y -">
								<button type="button" class="btn btn-success" onclick="MenosFilasPadres()" ><span class="fa fa-minus" aria-hidden="true"></span></button>
								<button type="button" class="btn btn-default" disabled="disabled"># Padres</button>
								<button type="button" class="btn btn-success" onclick="MasFilasPadres()" ><span class="fa fa-plus" aria-hidden="true"></span></button>
								<input type = "hidden" name = "padres" id = "padres" value = "<?php echo $padres; ?>" />
							</div>
						</div>
					</div>
				<?php for($j = 1; $j <= $padres; $j++){ ?>	
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>DPI:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "dpi<?php echo $j; ?>" id = "dpi<?php echo $j; ?>" value = "<?php echo $_REQUEST["dpi$j"]; ?>" onkeyup = "enteros(this)" onblur = "xajax_Buscar_Padre(this.value,<?php echo $j; ?>);" onchange = "xajax_Buscar_Padre(this.value,<?php echo $j; ?>);" maxlength = "13"/>
						</div>
						<div class="col-xs-5">
							<label>Parentesco:  </label> <span class="text-danger">*</span>
							<select class = "form-control" name = "parentesco<?php echo $j; ?>" id = "parentesco<?php echo $j; ?>" >
								<option value ="">Seleccione</option>
								<option value ="P">Padre</option>
								<option value ="M">Madre</option>
								<option value ="A">Abuelo(a)</option>
								<option value ="O">Encargado (otro)</option>
							</select>
							<script>
								document.getElementById("parentesco<?php echo $j; ?>").value = '<?php echo $_REQUEST["parentesco$j"]; ?>';
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>e-mail:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control text-libre" name = "mail<?php echo $j; ?>" id = "mail<?php echo $j; ?>" value = "<?php echo $_REQUEST["mail$j"]; ?>" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>Telefono:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "tel<?php echo $j; ?>" id = "tel<?php echo $j; ?>" value = "<?php echo $_REQUEST["tel$j"]; ?>" onkeyup = "enteros(this)" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Nombre:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "nom<?php echo $j; ?>" id = "nom<?php echo $j; ?>" value = "<?php echo $_REQUEST["nom$j"]; ?>" onkeyup = "texto(this)" />
						</div>	
						<div class="col-xs-5">
							<label>Apellido:  </label> <span class="text-danger">*</span>
							<input type = "text" class = "form-control" name = "ape<?php echo $j; ?>" id = "ape<?php echo $j; ?>" value = "<?php echo $_REQUEST["ape$j"]; ?>" onkeyup = "texto(this)" />
							<input type = "hidden" id ="existe<?php echo $j; ?>" name = "existe<?php echo $j; ?>" value = "<?php echo $_REQUEST["existe$j"]; ?>">
						</div>	
					</div>
					<br>
					<hr>
				<?php }?>
				</div>
			</div>
			<!-- /.panel-success -->
			
			<!-- .panel-default -->
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" id = "gra" onclick = "Grabar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
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
		$(function () {
		<?php for($i = 1; $i <= $alumnos; $i++){ ?>	
			$('#fecnac<?php echo $i; ?>').datetimepicker({
				 format: 'DD/MM/YYYY'
			});
		<?php } ?>
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