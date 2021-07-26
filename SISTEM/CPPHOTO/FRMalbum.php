<?php
	include_once('xajax_funct_photo.php');
	$usuario = $_SESSION["codigo"];
	$usunombre = $_SESSION["nombre"];
	$usunivel = $_SESSION["nivel"];
	$valida = $_SESSION["codigo"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsAsi = new ClsAsignacion();
	
	if($tipo_usuario == 3){ //// PADRE DE ALUMNO
		$result = $ClsAsi->get_alumno_padre($tipo_codigo,"");
		////////// CREA UN ARRAY CON TODOS LOS DATOS DE SUS HIJOS
		if (is_array($result)) {
			$i = 0;
			foreach($result as $row){
				$cui = $row["alu_cui"];
				///------------------
				$result_grado_alumno = $ClsAcad->comprueba_seccion_alumno($pensum,'','','','',$cui,'',1);  ////// este array se coloca en la columna de combos
				if(is_array($result_grado_alumno)){
					foreach($result_grado_alumno as $row_grado_alumno){
						$info_pensum.= $row_grado_alumno["seca_pensum"].",";
						$info_nivel.= $row_grado_alumno["seca_nivel"].",";
						$info_grado.= $row_grado_alumno["seca_grado"].",";
						$info_seccion.= $row_grado_alumno["seca_seccion"].",";
					}
				}
				///------------------
				$result_grupo_alumno = $ClsAsi->get_alumno_grupo('',$cui,1);  ////// este array se coloca en la columna
				if(is_array($result_grupo_alumno)){
					foreach($result_grupo_alumno as $row_grupo_alumno){
						$info_grupo.= $row_grupo_alumno["gru_codigo"].",";
					}
				}
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
			$info_seccion = substr($info_seccion,0,-1);
			//--
			$info_grupo = substr($info_grupo,0,-1);
		}
	}else if($tipo_usuario == 2){ //// MAESTRO
		$maestro = $tipo_codigo;
		$result_secciones = $ClsAcad->get_seccion_maestro($pensum,'','','',$tipo_codigo,'','',1);
		if(is_array($result_secciones)){
			foreach($result_secciones as $row){
				$info_pensum.= $row["niv_pensum"].",";
				$info_nivel.= $row["niv_codigo"].",";
				$info_grado.= $row["gra_codigo"].",";
				$info_seccion.= $row["sec_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
			$info_seccion = substr($info_seccion,0,-1);
			//--
			$info_grupo = substr($info_grupo,0,-1);							
		}
	}else if($tipo_usuario == 1){ //// DIRECTORA
		$result = $ClsAcad->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
		if(is_array($result)){
			foreach($result as $row){
				$info_pensum.= $row["gra_pensum"].",";
				$info_nivel.= $row["gra_nivel"].",";
				$info_grado.= $row["gra_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
		}
	}else if($tipo_usuario == 5){ //// ADMINISTRADOR
		$result = $ClsPen->get_grado($pensum,'','',1);
		if(is_array($result)){
			foreach($result as $row){
				$info_pensum.= $row["gra_pensum"].",";
				$info_nivel.= $row["gra_nivel"].",";
				$info_grado.= $row["gra_codigo"].",";
			}
			$info_pensum = substr($info_pensum,0,-1);
			$info_nivel = substr($info_nivel,0,-1);
			$info_grado = substr($info_grado,0,-1);
		}
	}else{
		$valida = "";
	}
	
if($usunivel != "" && $usunombre != ""){	
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
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	<link href="../assets.3.6.2/css/photos.css" rel="stylesheet">
	
	<!-- Chosen CSS -->
	<link href="../assets.3.6.2/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
	<link href="../assets.3.6.2/css/plugins/chosen/chosen.css" rel="stylesheet">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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
							<a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2  || $tipo_usuario == 5 ){ ?>
								<li>
									<a href="FRMgestor.php">
										<i class="fa fa-camera"></i> Nuevo Album
									</a>
								</li>
								<?php } ?>
								<li>
									<a href="FRMalbum.php">
										<i class="fa fa-image"></i> Photo Album
									</a>
								</li>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMlectura.php">
										<i class="fa fa-info-circle"></i> Confirmaci&oacute;n de Lectura
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../CPMENU/MENUcomunicacion.php">
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
         <div class="panel panel-default">
				<div class="panel-heading"> 
					<i class="fa fa-image"></i>
					Photo Album
				</div>
				<div class="panel-body">
					<?php
						$ClsPho = new ClsPhoto();
						$result = $ClsPho->get_album_accesos('',$pensum,$info_nivel, $info_grado,'','',1);
						if(is_array($result)){
							$codigos = "";
							foreach($result as $row){
								$codigos.= trim($row["pho_codigo"]).",";
							}
							$codigos = substr($codigos, 0, -1); 
						}else{
							$codigos = 0;
						}
						/////////////////////////////////////////////////////////////////////////////////////////////////
						$result = $ClsPho->get_album_unique($codigos,'','','',1);
						if(is_array($result)){
					?>
						<div class="article-wrapper-img grid">
					<?php	
							foreach($result as $row){
								$codigo = trim($row["pho_codigo"]);
								$fecha = cambia_fechaHora($row["pho_fecha_registro"]);
								$imagen = utf8_decode($row["pho_portada"]);
								$desc = utf8_decode($row["pho_descripcion"]);
								$desc = nl2br($desc);
								$cantidad = $row["pho_cantidad"];
								//--
								$usu = $_SESSION["codigo"];
								$hashkey = $ClsPho->encrypt($codigo, $usu);
					?>
							<div>
								<div class="thumbnail text-center">
									<a href="FRMdetalle.php?hashkey=<?php echo $hashkey; ?>" title="Ver Album">
										<img src="../../CONFIG/Fotos/PHOTO/<?php echo $imagen; ?>" width = "100%" />
									</a>
									<?php if($cantidad > 1){ ?>
										<div class="img-fab">
											<a class="img-fab-count" title="">
												+ <?php echo ($cantidad - 1); ?>
											</a>
										</div>
									<?php } ?>
									<label><?php echo $fecha; ?></label>
									<p class="text-info text-justify"><?php echo $desc; ?></p>
									<div class="thumbnail-control">
										<a href="javascript:void(0);" onclick="editAlbum(<?php echo $codigo; ?>);" class="fa fa-pencil fa-2x text-muted pull-left"></a> 
										<a href="javascript:void(0);" onclick="targetAlbum(<?php echo $codigo; ?>);" class="fa fa-group fa-2x text-muted pull-left"></a> 
										<a href="javascript:void(0);" onclick="deleteAlbum(<?php echo $codigo; ?>);" class="fa fa-trash fa-2x text-danger pull-right"></a>
									</div>
								</div>
							</div>
					<?php
							}
					?>
						</div>
					<?php
						}
					?>
				</div>
			</div>
			<!-- /.panel-default -->
			<div id="fab">
				<a class="open-fab-primary" href="FRMgestor.php" title="Nuevo Album">
					<i class="fa fa-plus"></i>
				</a>
			</div>
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
	
	<!-- Chosen -->
   <script src="../assets.3.6.2/js/plugins/chosen/chosen.jquery.js"></script>
	
	<!-- Columnsto JS -->
	<script src="../assets.3.6.2/js/plugins/columnstojs/columnstojs.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/modules/app/photo.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
		var column4 = $('.grid').columnsToJs({
			count: 3,
			gap: 0
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