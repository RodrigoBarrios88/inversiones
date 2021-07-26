<?php
	include_once('xajax_funct_curso.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	
	//$_POST
	$tema = $_REQUEST["tema"];
	$curso = $_REQUEST["curso"];
	
	$ClsCur = new ClsCursoLibre();
	$result = $ClsCur->get_tema_archivo($cod,$curso,$tema);
	
	if(is_array($result)){
		$cantidad = 0;
		foreach($result as $row){
			$arrdoc[$cantidad]["codigo"] = trim($row["arch_codigo"]);
			$arrdoc[$cantidad]["curso"] = trim($row["arch_curso"]);
			$arrdoc[$cantidad]["tema"] = trim($row["arch_tema"]);
			$arrdoc[$cantidad]["extension"] = trim($row["arch_extencion"]);
			$arrdoc[$cantidad]["archivo"] = trim($row["arch_codigo"])."_".trim($row["arch_curso"])."_".trim($row["arch_tema"]).".".trim($row["arch_extencion"]);
			$arrdoc[$cantidad]["fecha"] = cambia_fechaHora($row["arch_fecha_registro"]);
			$arrdoc[$cantidad]["nombre"] = utf8_decode($row["arch_nombre"]);
			$arrdoc[$cantidad]["desc"] = utf8_decode($row["arch_descripcion"]);
			$cantidad++;
		}
	}
	
	//hashkey para regresar a temas
	$hashkey = $ClsCur->encrypt($curso, $usuario);
	
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets.3.6.2/js/core/jquery.min.js"></script>
    
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
	<!-- Estilos Utilitarios -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
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
    <div class="visualizador">
		<br>
		<div class="row">
			<div class="col-xs-6 col-xs-offset-3">
				<?php
				
					$disco = folderSize("../../CONFIG/DATALMS/");
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
				<a class="btn btn-block btn-info" href = "FRMtema.php?hashkey='<?php echo $hashkey; ?>" title = "Regresar a Temas"><i class="fa fa-reply"></i></a>
			</div>
			<div class="col-xs-1"></div>
			<div class="col-xs-6">
				<button type="button" class="btn btn-block btn-default" onclick = "window.location.reload();" title = "Refrescar Archivos"><i class="fa fa-refresh text-info"></i></button>
			</div>
			<div class="col-xs-1 col-xs-offset-1">
				<button type="button" class="btn btn-outline btn-primary" onclick = "NewFile(<?php echo $tema; ?>,<?php echo $curso; ?>,1);" title="Cargar material de auxiliar o Gu&iacute;a"><i class="fa fa-cloud-upload"></i> <i class="fa fa-file-picture-o"></i></button>
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
						case "doc": $icono = '<i class = "fa fa-file-word-o fa-5x text-info"></i>'; break;
						case "docx": $icono = '<i class = "fa fa-file-word-o fa-5x text-info"></i>'; break;
						case "ppt": $icono = '<i class = "fa fa-file-powerpoint-o fa-5x text-danger"></i>'; break;
						case "pptx": $icono = '<i class = "fa fa-file-powerpoint-o fa-5x text-danger"></i>'; break;
						case "xls": $icono = '<i class = "fa fa-file-excel-o fa-5x text-success"></i>'; break;
						case "xlsx": $icono = '<i class = "fa fa-file-excel-o fa-5x text-success"></i>'; break;
						case "jpg": $icono = '<i class = "fa fa-file-picture-o fa-5x text-muted"></i>'; break;
						case "jpeg": $icono = '<i class = "fa fa-file-picture-o fa-5x text-muted"></i>'; break;
						case "png": $icono = '<i class = "fa fa-file-picture-o fa-5x text-muted"></i>'; break;
						case "pdf": $icono = '<i class = "fa fa-file-pdf-o fa-5x text-warning"></i>'; break;
					}
			?>
					<div class="grid-item col-xs-6">
						<div class="thumbnail">
							<a href="EXEdownload_archivo.php?archivo=<?php echo $arrdoc[$i]["archivo"]; ?>" class="btn btn-default"><?php echo $icono; ?></a>
							<label><?php echo $arrdoc[$i]["fecha"]; ?></label>
							<div class="caption">
								<h5><?php echo $arrdoc[$i]["nombre"]; ?></h3>
								<p class="text-justify"><?php echo $arrdoc[$i]["desc"]; ?></p>
								<div>
									<a href="#" class="btn btn-danger btn-xs" role="button" title="Eliminar Archivo" onclick = "Eliminar_Archivo(<?php echo $arrdoc[$i]["codigo"]; ?>,<?php echo $arrdoc[$i]["curso"]; ?>,<?php echo $arrdoc[$i]["tema"]; ?>,'<?php echo $arrdoc[$i]["archivo"]; ?>');"><i class="fa fa-trash"></i></a> 
									<a href="EXEdownload_archivo.php?archivo=<?php echo $arrdoc[$i]["archivo"]; ?>" class="btn btn-primary btn-xs" role="button" title="Descargar Archivo"><i class="fa fa-download"></i></a>
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
								<a class="btn btn-primary btn-xs" role="button" disabled ><i class="fa fa-download"></i></a>
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
	
	<!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Masonry -->
	<script src="../assets.3.6.2/js/plugins/masonry/masonry.pkgd.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/lms/tema.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$('.grid').masonry({
			// options
			itemSelector: '.grid-item',
			percentPosition: true
		});
    </script>	
    </div>
</body>

</html>