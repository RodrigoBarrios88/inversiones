<?php
	include_once('xajax_funct_tarea.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	
	//$_POST
	$tarea = $_REQUEST["tarea"];
	$alumno = $_REQUEST["alumno"];
	
	$ClsTar = new ClsTarea();
	$result = $ClsTar->get_respuesta_tarea_curso_archivo('',$tarea,$alumno,'');
	
	if(is_array($result)){
		$cantidad = 0;
		foreach($result as $row){
			$arrdoc[$cantidad]["codigo"] = trim($row["arch_codigo"]);
			$arrdoc[$cantidad]["tarea"] = trim($row["arch_tarea"]);
			$arrdoc[$cantidad]["alumno"] = trim($row["arch_alumno"]);
			$arrdoc[$cantidad]["extension"] = trim($row["arch_extencion"]);
			$arrdoc[$cantidad]["archivo"] = trim($row["arch_codigo"])."_".trim($row["arch_tarea"])."_".trim($row["arch_alumno"]).".".trim($row["arch_extencion"]);
			$arrdoc[$cantidad]["fecha"] = cambia_fechaHora($row["arch_fecha_registro"]);
			$arrdoc[$cantidad]["nombre"] = utf8_decode($row["arch_nombre"]);
			$arrdoc[$cantidad]["desc"] = utf8_decode($row["arch_descripcion"]);
			$cantidad++;
		}
	}
	
	//hashkey para regresar a temas
	$hashkey = $ClsTar->encrypt($curso, $usuario);
	
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
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.modify.css" rel="stylesheet" />
	<link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
	<!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
	<link href="../assets.3.5.20/css/util.css" rel="stylesheet">
    
    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="../assets.3.5.20/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Sweet Alert -->
	<script src="../js/plugins/sweetalert/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/plugins/sweetalert/sweetalert.css">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<style>
		.grid-item{
			max-width: 400px;
		}
		
		body{
			background: #fff;
		}
	</style>

</head>
<body>
	
	<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; </a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-paste"></i> Tareas</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	
    <div class="">
		<br>
		<div class="row">
			<div class="col-xs-6 col-xs-offset-3">
				<?php
				
					$disco = folderSize("../../CONFIG/DATALMSALUMNOS/");
					$disco = round(($disco/1000000),4);
					$porcentaje = round(($disco/10),4);
					
					$disabled = "";
					if($porcentaje <= 50){
						$color = "success";
					}else if($porcentaje > 50 && $porcentaje <= 75){
						$color = "warning";
					}else if($porcentaje > 75 && $porcentaje < 100){
						$color = "danger";
					}else if($porcentaje >= 100){
						$color = "danger";
						$disabled = "disabled";
					}
				?>
				<div class="progress sin-margin">
					<div class="progress-bar progress-bar-<?php echo $color; ?>" role="progressbar" aria-valuenow="<?php echo $porcentaje; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentaje; ?>%;"></div>
				</div>
				<strong class="text-muted"><?php echo $porcentaje; ?>% Uso de Disco</strong> <small><?php echo $disco; ?> MB</small>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-1 col-xs-offset-1">
				<button type="button" class="btn btn-block btn-default" onclick="window.close();" title = "Cerrar"><i class="fa fa-times"></i></button>
			</div>
			<div class="col-xs-1"></div>
			<div class="col-xs-6">
				<button type="button" class="btn btn-block btn-default" onclick = "window.location.reload();" title = "Refrescar Archivos"><i class="fa fa-refresh text-info"></i></button>
			</div>
			<div class="col-xs-1 col-xs-offset-1">
				<button type="button" class="btn btn-outline btn-primary" onclick = "NewFile(<?php echo $tarea; ?>,<?php echo $alumno; ?>,1);" title="Cargar material de auxiliar o Gu&iacute;a"><i class="fas fa-file-upload"></i> <i class="fas fa-file-image"></i></button>
			</div>
		</div>
		<br>
		<div class="container-fluid">
			<div class="grid">
			<!-- Carusel -->
			<?php if($cantidad > 0) { ?>
			<?php
				$cols = 1;
				for($i = 0; $i < $cantidad; $i++){
					if($cols == 1){
						
					}
					
					$extension = $arrdoc[$i]["extension"];
					switch($extension){
						case "doc": $icono = '<i class = "fas fa-file-word fa-5x text-info"></i>'; break;
						case "docx": $icono = '<i class = "fas fa-file-word fa-5x text-info"></i>'; break;
						case "ppt": $icono = '<i class = "fas fa-file-powerpoint fa-5x text-danger"></i>'; break;
						case "pptx": $icono = '<i class = "fas fa-file-powerpoint fa-5x text-danger"></i>'; break;
						case "xls": $icono = '<i class = "fas fa-file-excel fa-5x text-success"></i>'; break;
						case "xlsx": $icono = '<i class = "fas fa-file-excel fa-5x text-success"></i>'; break;
						case "jpg": $icono = '<i class = "fas fa-file-image fa-5x text-muted"></i>'; break;
						case "jpeg": $icono = '<i class = "fas fa-file-image fa-5x text-muted"></i>'; break;
						case "png": $icono = '<i class = "fas fa-file-image fa-5x text-muted"></i>'; break;
						case "pdf": $icono = '<i class = "fas fa-file-pdf fa-5x text-warning"></i>'; break;
					}
			?>
					<div class="grid-item col-xs-6">
						<div class="thumbnail">
							<a href="EXEdownload_archivo_tarea_curso.php?archivo=<?php echo $arrdoc[$i]["archivo"]; ?>" class="btn btn-default"><?php echo $icono; ?></a>
							<label><?php echo $arrdoc[$i]["fecha"]; ?></label>
							<div class="caption">
								<h5><?php echo $arrdoc[$i]["nombre"]; ?></h3>
								<p class="text-justify"><?php echo $arrdoc[$i]["desc"]; ?></p>
								<div>
									<a href="#" class="btn btn-danger btn-xs" role="button" title="Eliminar Archivo" onclick = "Eliminar_Archivo(<?php echo $arrdoc[$i]["codigo"]; ?>,<?php echo $arrdoc[$i]["tarea"]; ?>,'<?php echo $arrdoc[$i]["alumno"]; ?>','<?php echo $arrdoc[$i]["archivo"]; ?>');"><i class="fa fa-trash"></i></a> 
									<a href="EXEdownload_archivo_tarea_curso.php?archivo=<?php echo $arrdoc[$i]["archivo"]; ?>" class="btn btn-primary btn-xs" role="button" title="Descargar Archivo"><i class="fas fa-file-download fa-2x"></i></a>
								</div>
							</div>
						</div>
					</div>
			<?php
				}
			?>
			<?php }else{ ?>
				<br>
				<div class="col-xs-12 text-center">
					<div class="thumbnail">
						<br>
						<button type="button" class="btn btn-default"><i class="fa fa-paperclip fa-5x"></i> <i class="fa fa-files-o fa-5x"></i> <i class="fa fa-times fa-5x"></i></button>
						<br><label>dd/mm/yyyy</label>
						<div class="caption">
							<h5>Sin Documentos</h3>
							<p class="text-center">No hay documentos cargados en este tema...</p>
							<div>
								<a href="#" class="btn btn-danger btn-xs" role="button" disabled ><i class="fa fa-trash"></i></a> 
								<a class="btn btn-primary btn-xs" role="button" disabled ><i class="fas fa-file-download fa-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	<!-- /.jumbotron -->
    
	<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="60px" /></h4>
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
    <script src="../js/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui-1.10.2.custom.min.js"></script>
	
	<!-- Masonry -->
	<script src="../js/plugins/masonry/masonry.pkgd.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../js/modules/lms/examencurso.js"></script>
    <script type="text/javascript" src="../js/modules/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$('.grid').masonry({
			// options
			itemSelector: '.grid-item',
			percentPosition: true
		});
    </script>	
</body>

</html>