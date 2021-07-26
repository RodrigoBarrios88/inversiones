<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$nivel = $_SESSION["nivel"];
	$nit = $_REQUEST["nit"];
	$fila = $_REQUEST["fila"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-user"></i> Nuevo Cliente
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-xs-12 text-right">
					<span class = "text-danger">* Campos Obligatorios</span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5 col-xs-offset-1">
					<label>Nit:  </label> <span class="text-danger">*</span>
					<input type = "text" class = "form-control" name = "cnit1" id = "cnit1"  onkeyup = "texto(this)" value = "<?php echo $nit; ?>" />
					<input type = "hidden" name = "cod" id = "cod" />
				</div>	
				<div class="col-lg-5">
					<label>Nombre:  </label> <span class="text-danger">*</span>
					<input type = "text" class = "form-control" name = "cnom1" id = "cnom1" onkeyup = "texto(this)"/>
				</div>	
			</div>
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1">
					<label>Direcci&oacute;n:  </label> <span class="text-danger">*</span>
					<input type = "text" class = "form-control" name = "cdirec1" id = "cdirec1" onkeyup = "texto(this)" />
				</div>	
			</div>
			<div class="row">
				<div class="col-lg-5 col-xs-offset-1">
					<label>Telefono 1:  </label> 
					<input type = "text" class = "form-control" name = "ctel1" id = "ctel1"  onkeyup = "enteros(this)" maxlength = "15" />
				</div>	
				<div class="col-lg-5">
					<label>Telefono 2:  </label> 
					<input type = "text" class = "form-control" name = "ctel2" id = "ctel2" onkeyup = "enteros(this)" maxlength = "15" />
				</div>	
			</div>
			<div class="row">
				<div class="col-lg-5 col-xs-offset-1">
					<label>e-mail:</label>
					<input type = "text" class = "form-control" name = "cmail1" id = "cmail1" onkeyup = "texto(this)" />
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 text-center">
				   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
					<button type="button" class="btn btn-primary" onclick = "GrabarCliente(<?php echo $fila; ?>)"><span class="fa fa-save"></span> Grabar</button>
				 </div>
			</div>
			<br>
		</div>		
	</div>	
</body>
</html>