<?php
	include_once('xajax_funct_padre.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$hashkey = $_REQUEST["hashkey"];
	
	$ClsMun = new ClsMundep();
	$ClsPad = new ClsPadre();
	$dpi = $ClsPad->decrypt($hashkey, $usuario);
	$result = $ClsPad->get_padre($dpi);
	if(is_array($result)){
		foreach($result as $row){
			$dpi = $row["pad_cui"];
			$tipodpi = trim($row["pad_tipo_dpi"]);
			$nombre = utf8_decode($row["pad_nombre"]);
			$apellido = utf8_decode($row["pad_apellido"]);
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
			$nacionalidad = utf8_decode($row["pad_nacionalidad"]);
			$mail = strtolower($row["pad_mail"]);
			$telcasa = $row["pad_telefono"];
			$celular = $row["pad_celular"];
			$direccion = utf8_decode($row["pad_direccion"]);
			$dep = trim($row["pad_departamento"]);
			$mun = trim($row["pad_municipio"]);
			$trabajo = utf8_decode($row["pad_lugar_trabajo"]);
			$teltrabajo = $row["pad_telefono_trabajo"];
			$profesion = utf8_decode($row["pad_profesion"]);
		}
	}
	
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario_tipo_codigo(3,$dpi);
	if(is_array($result)){
		foreach($result as $row){
			$padre_id = trim($row["usu_id"]);
			$foto = trim($row["usu_foto"]);
		}
	}
	
	if(file_exists('../../CONFIG/Fotos/USUARIOS/'.$foto.'.jpg')){
		$foto = 'USUARIOS/'.$foto.'.jpg';
	}else{
		$foto = "nofoto.png";
	}
	
if($usuario != "" && $nombre != ""){ 		
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
						<li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Perfil de Usuario</a></li>
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
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMnewpadre.php">
										<i class="fa fa-plus-circle"></i> Agregar Padre
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="#">
										<i class="fa fa-edit"></i> Editar Informaci&oacute;n
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMpadre.php">
										<i class="fa fa-list-alt"></i> Ficha de Padres
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="CPREPORTES/FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Padres
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
			<br>
         <div class="panel panel-default">
				<div class="panel-heading"> 
					<i class="fa fa-edit"></i> Actualizar Informaci&oacute;n del Padre/Madre o Encargado
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-5 col-lg-offset-1 col-xs-6">
							<button type ="button" class="btn btn-defaul" onclick="window.history.back();">
								<i class="fa fa-chevron-left"></i> Regresar
							</button>
						</div>
						<div class="col-xs-5 col-xs-6 text-right text-danger">* Campos Obligatorios</div>
					</div>
					<br>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>No. de Identificaci&oacute;n:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "dpi" name = "dpi" value="<?php echo $dpi; ?>" readonly />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Tipo de ID:</label> <span class = "text-danger">*</span></div>
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
						<div class="col-lg-4 col-lg-offset-1"><label>Nombres:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "nombre" name = "nombre" value="<?php echo $nombre; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Apellidos:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "apellido" name = "apellido" value="<?php echo $apellido; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Fecha de Nacimiento:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<div class='input-group date'>
								<?php echo input_fecha("fecnac","valida_fecha('fecnac');"); ?>
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
						<div class="col-lg-4 col-lg-offset-1"><label>Parentesco con el/los alumno(s):</label> <span class = "text-danger">*</span></div>
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
						<div class="col-lg-4 col-lg-offset-1"><label>Estado Civil:</label> <span class = "text-danger">*</span></div>
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
						<div class="col-lg-4 col-lg-offset-1"><label>Nacionalidad:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "nacionalidad" name = "nacionalidad" value="<?php echo $nacionalidad; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>E-mail:</label> </div>
						<div class="col-lg-6">
							<input class="form-control text-libre" type="text" id = "mail" name = "mail" value="<?php echo $mail; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Direcci&oacute;n:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "direccion" name = "direccion" value="<?php echo $direccion; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Departamento:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<?php echo departamento_html("departamento","xajax_depmun(this.value,'municipio','divmun');"); ?>
							<script>
								document.getElementById("departamento").value = '<?php echo $dep; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Municipio:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6" id = "divmun">
							<?php
								$tempdep = ($dep != "")?$dep:100;
								echo municipio_html($tempdep,"municipio","");
							?>
							<script>
								document.getElementById("municipio").value = '<?php echo $mun; ?>';
							</script>
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Tel&eacute;fono Casa:</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "telcasa" name = "telcasa" value="<?php echo $telcasa; ?>" onkeyup="enteros(this);" maxlength = "10" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Celular:</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "celular" name = "celular" value="<?php echo $celular; ?>" onkeyup="enteros(this);" maxlength = "10" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Lugar de Trabajo:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "trabajo" name = "trabajo" value="<?php echo $trabajo; ?>" onkeyup="texto(this);" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Tel&eacute;fono de Trabajo:</label> </div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "teltrabajo" name = "teltrabajo" value="<?php echo $teltrabajo; ?>" onkeyup="enteros(this);" maxlength = "10" />
						</div>
					</div>
					<div class = "row">
						<div class="col-lg-4 col-lg-offset-1"><label>Profesi&oacute;n u Oficio:</label> <span class = "text-danger">*</span></div>
						<div class="col-lg-6">
							<input class="form-control" type="text" id = "profesion" name = "profesion" value="<?php echo $profesion; ?>" onkeyup="texto(this);" />
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
					<ins class="text-success"><i class="fa fa-group"></i> Hijos</ins>
					<?php echo tabla_hijos($dpi); ?>
					<hr>
					<ins class="text-success"><i class="fa fa-group"></i> Familia</ins>
					<?php echo tabla_familia($dpi); ?>
				</div>
			</div>
			<!-- /.panel-success -->
			
			<!-- .panel-default -->
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 text-center">
							<button type="button" class="btn btn-default" onclick = "Limpiar();"><span class="fa fa-eraser"></span> Limpiar</button>
							<button type="button" class="btn btn-primary" onclick = "ModificarCompleto();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
						</div>
					</div>
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
	
	<!-- Metis Menu Plugin JavaScript -->
	<script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>
	
	<!-- DataTables JavaScript -->
	<script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
	
	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/padre.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 50,
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