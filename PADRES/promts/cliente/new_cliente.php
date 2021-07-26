<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$nivel = $_SESSION["nivel"];
	//_POST
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
			<div class="panel-heading"><label>Nuevo Cliente</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-md-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 text-right"><label>Nit:  </label> <span class="text-danger">*</span></div>
					<div class="col-md-3">
						<input type = "text" class = "form-control" name = "cnit1" id = "cnit1"  onkeyup = "texto(this)" value = "<?php echo $nit; ?>" />
						<input type = "hidden" name = "cod" id = "cod" />
					</div>	
					<div class="col-md-2 text-right"><label>Nombre:  </label> <span class="text-danger">*</span></div>
					<div class="col-md-3"><input type = "text" class = "form-control" name = "cnom1" id = "cnom1"  onkeyup = "texto(this)"/></div>	
				</div>
				<div class="row">
					<div class="col-md-2 text-right"><label>Direcci&oacute;n:  </label> <span class="text-danger">*</span></div>
					<div class="col-md-8"><input type = "text" class = "form-control" name = "cdirec1" id = "cdirec1" onkeyup = "texto(this)" value="CIUDAD" /></div>	
				</div>
				<div class="row">
					<div class="col-md-2 text-right"><label>Telefono 1:  </label> </div>
					<div class="col-md-3"><input type = "text" class = "form-control" name = "ctel1" id = "ctel1"  onkeyup = "enteros(this)" maxlength = "15" /></div>	
					<div class="col-md-2 text-right"><label>Telefono 2:  </label> </div>
					<div class="col-md-3"><input type = "text" class = "form-control" name = "ctel2" id = "ctel2" onkeyup = "enteros(this)" maxlength = "15" /></div>	
				</div>
				<div class="row">
					<div class="col-md-2 text-right"><label>e-mail:</label></div>
					<div class="col-md-3"><input type = "text" class = "form-control text-libre" name = "cmail1" id = "cmail1" /></div>
				</div>
				<br><br>
				<div class="row">
					<div class="12 text-center">
					   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-info" id = "busc" onclick = "GrabarCliente(<?php echo $fila; ?>)"><span class="fa fa-check"></span> Aceptar</button>
					 </div>
				</div>
				<br>
			</div>		
		</div>	
	</body>
</html>

