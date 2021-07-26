<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
	<form action="EXElectorcsv.php" name = "f2" name = "f2" method="post" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading"><label>Cargar Listado de Nuevos Art&iacute;culos</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
                    <div class="col-xs-12 text-center">
						<button type="button" class="btn btn-success btn-block" onclick = "DownloadFormato();"><span class="fa fa-file-excel-o"></span> Descargar Formato</button>
					</div>
                </div>
				<hr>
                <div class="row">
                    <div class="col-xs-5 col-xs-offset-1"><label>Grupo de Suministros: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-5"><label>Empresa a Cargar: </label> <label class = " text-danger">*</label></div>
                </div>
				<div class="row">
                    <div class="col-xs-5 col-xs-offset-1">
						<?php echo grupo_suministro_html("gru1"); ?>
					</div>
                    <div class="col-xs-5">
						<?php echo empresa_html("suc1"); ?>
					</div>
                </div>
				<div class="row">
                    <div class="col-xs-5 col-xs-offset-1"><label>Seleccione el archivo (*.csv): </label> <label class = " text-danger">*</label></div>
                </div>
				<div class="row">
                    <div class="col-xs-5 col-xs-offset-1">
						<div class="form-group">
							<input id="doc" name="doc" type="file" multiple="false" >
							<input type = "hidden" id="chequeados" name = "chequeados" />
						</div>
					</div>
                </div>
                <br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
					    <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-info" id = "busc" onclick = "ConfirmCargar();"><span class="fa fa-check"></span> Aceptar</button>
					 </div>
				</div>
				<br>
			</div>		
		</div>
	</form>
	<script>
		$("#doc").fileinput({
			showUpload: false,
			showCaption: true,
			browseClass: "btn btn-success btn-md",
			fileType: "any",
			allowedFileExtensions : ['csv'],
			previewFileIcon: "<i class='fa fa-file-excel-o'></i>",
			minImageWidth: 600,
			minImageHeight: 600,
			maxImageWidth: 5000,
			maxImageHeight: 5000,
			maxFileSize: 2000
		});
    </script>
	</body>
</html>