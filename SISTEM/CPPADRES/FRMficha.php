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
			$padreedad = Calcula_Edad($fecnac);
			$parentesco = trim($row["pad_parentesco"]);
			$ecivil = trim($row["pad_estado_civil"]);
			$nacionalidad = utf8_decode($row["pad_nacionalidad"]);
			$mail = strtolower($row["pad_mail"]);
			$telcasa = $row["pad_telefono"];
			$celular = $row["pad_celular"];
			$direccion = utf8_decode($row["pad_direccion"]);
			$municipio = utf8_decode($row["pad_municipio"]);
			$trabajo = utf8_decode($row["pad_lugar_trabajo"]);
			$teltrabajo = $row["pad_telefono_trabajo"];
			$profesion = utf8_decode($row["pad_profesion"]);
		}
		
		$result = $ClsMun->get_municipio_especifico($municipio);
		if(is_array($result)){
			foreach($result as $row){
				$municipio = utf8_decode($row["dm_desc"]);
			}
			///concatena, departamento y municipio
			$direccion = "$direccion, $municipio";
		}
		
		//estado civil
		switch($ecivil){
			case "S": $ecivil = "SOLTERO(A)"; break;
			case "C": $ecivil = "CASADO(A)";
		}
		
		//parentesco
		switch($parentesco){
			case "P": $parentesco = "PADRE"; break;
			case "M": $parentesco = "MADRE"; break;
			case "A": $parentesco = "ABUELO(A)"; break;
			case "O": $parentesco = "ENCARGADO(A)"; break;
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
										<i class="fa fa-user"></i> Gestor de Padres
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a class="active" href="#">
										<i class="fa fa-list-alt"></i> Ficha de Padres
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMpadre.php">
										<i class="fa fa-list"></i> Lista de Padres
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
			<br><br>
         <div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-list-alt"></i> Ficha de Padres
				</div>
            <div class="panel-body">
					<div class="row">
						<div class="col-lg-4 col-xs-12 text-center">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-user"></i> Fotograf&iacute;a</div>
								<div class="panel-body">
									<button type ="button" class="btn btn-default btn-block" onclick="window.history.back();">
										<i class="fa fa-chevron-left"></i> Regresar
									</button>
									<hr>
									<img src = "../../CONFIG/Fotos/<?php echo $foto; ?>" width = "200px" class = ""class="thumbnail" />
									<br>
									<hr>
									<br>
									<a class="btn btn-default btn-lg btn-block" href = "FRMmodpadre.php?hashkey=<?php echo $hashkey; ?>">
										<i class="fa fa-pencil fa-2x"></i><br>
										Editar Datos Completos
									</a>
									<hr>
									<br>
									<button type="button" class="btn btn-primary btn-lg btn-block" onclick="invitarCorreo('<?php echo $dpi; ?>')" >
										<i class="fa fa-envelope fa-2x"></i><br>
										Invitar al Sistema
									</button>
								</div>
							</div>
						</div>
						<div class="col-lg-8 col-xs-12 ext-center">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-file-text-o"></i> Datos Generales</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-6"><label>Identificaci&oacute;n:  </label> </div>
										<div class="col-xs-6"><label>Tipo de Identificaci&oacute;n:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $dpi; ?></label>
										</div>	
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $tipodpi; ?></label>
										</div>	
									</div>
									<div class="row">
										<div class="col-xs-6"><label>Nombres:  </label> </div>
										<div class="col-xs-6"><label>Apellidos:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $nombre; ?></label>
										</div>	
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $apellido; ?></label>
										</div>	
									</div>
									<div class="row">
										<div class="col-xs-6"><label>Fecha de Nacimiento:  </label> </div>
										<div class="col-xs-6"><label>Edad:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $fecnac; ?></label>
										</div>	
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $padreedad; ?> a&ntilde;os</label>
										</div>	
									</div>
									<div class="row">
										<div class="col-xs-6"><label>Parentesco:  </label> </div>
										<div class="col-xs-6"><label>Estado Civil:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $parentesco; ?></label>
										</div>	
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $ecivil; ?></label>
										</div>	
									</div>
									<div class="row">
										<div class="col-xs-6"><label>Nacionalidad:  </label> </div>
										<div class="col-xs-6"><label>Profesi&oacute;n:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $nacionalidad; ?></label>
										</div>
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $profesion; ?></label>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6"><label>Telefono de Casa:  </label> </div>
										<div class="col-xs-6"><label>Celular:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $telcasa; ?></label>
										</div>
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $celular; ?></label>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12"><label>e-mail:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-12">
											<label class = "form-control"><?php echo $mail; ?></label>
										</div>	
									</div>
									<div class="row">
										<div class="col-xs-12"><label>Direcci&oacute;n:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-12">
											<textarea class = "form-control" disabled><?php echo $direccion; ?></textarea>
										</div>	
									</div>
									<div class="row">
										<div class="col-xs-6"><label>Lugar de Trabajo:  </label> </div>
										<div class="col-xs-6"><label>Telefono de Trabajo:  </label> </div>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $trabajo; ?></label>
										</div>
										<div class="col-xs-6">
											<label class = "form-control"><?php echo $teltrabajo; ?></label>
										</div>
									</div>
								</div>
							 </div>
						</div>
					</div>
            </div>
            <!-- /.panel-body -->
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
				responsive: true
			});
		 });
		
		$(document).ready(function() {
			$('#dataTables-psico').DataTable({
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