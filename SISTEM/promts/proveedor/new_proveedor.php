<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$nit = $_REQUEST["nit"];
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<form name = "f1" id = "f1" onsubmit = "return false;">
		<div class="panel panel-default">
			<div class="panel-heading"><label>Nuevo Proveedor</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3 text-right"><label>Nit:  </label> <span class="text-danger">*</span></div>
					<div class="col-xs-3">
						<input type = "text" class = "form-control" name = "pnit1" id = "pnit1"  onkeyup = "texto(this)" value = "<?php echo $nit; ?>" />
						<input type = "hidden" name = "cod" id = "cod" />
					</div>	
					<div class="col-xs-2 text-right"><label>Nombre:  </label> <span class="text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "pnom1" id = "pnom1"  onkeyup = "texto(this);" /></div>	
				</div>
				<div class="row">
					<div class="col-xs-3 text-right"><label>Direcci&oacute;n:  </label> <span class="text-danger">*</span></div>
					<div class="col-xs-8"><input type = "text" class = "form-control" name = "pdirec1" id = "pdirec1" onkeyup = "texto(this);" /></div>	
				</div>
				<div class="row">
					<div class="col-xs-3 text-right"><label>Telefono 1:  </label> </label><span class="text-danger">*</span> </div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "ptel1" id = "ptel1"  onkeyup = "enteros(this);" maxlength = "15" /></div>	
					<div class="col-xs-2 text-right"><label>Telefono 2:  </label> </div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "ptel2" id = "ptel2" onkeyup = "enteros(this);" maxlength = "15" /></div>	
				</div>
				<div class="row">
					<div class="col-xs-3 text-right"><label>e-mail:</label></div>
					<div class="col-xs-3"><input type = "text" class = "form-control text-libre" name = "pmail1" id = "pmail1" /></div>
				</div>
				<div class="row">
					<div class="col-xs-3 text-right"><label>Nombre del Contacto:  </label><span class="text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "pcontac1" id = "pcontac1" onkeyup = "texto(this);" /></div>	
					<div class="col-xs-2 text-right"><label>Tel. del Contacto:  </div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "ptelc1" id = "ptelc1" onkeyup = "enteros(this);" /></div>	
				</div>
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
					   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-info" id = "busc" onclick = "GrabarProveedor();"><span class="fa fa-check"></span> Aceptar</button>
					 </div>
				</div>
				<br>
			</div>		
		</div>	
		</form>
	</body>
</html>
