<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$sucursal = $_SESSION["sucursal"];
	$sucCodigo = $_SESSION["sucCodigo"];
	$nivel = $_SESSION["nivel"];
	//_POST
	$codigo = $_REQUEST["codigo"];
	$fila = $_REQUEST["fila"];
	
	$ClsCli = new ClsCliente();
   //$respuesta->alert("$cod");
	$result = $ClsCli->get_cliente($codigo,"","");
	if(is_array($result)){
		foreach($result as $row){
			$nit = utf8_decode($row["cli_nit"]);
			$nom = utf8_decode($row["cli_nombre"]);
			$dir = utf8_decode($row["cli_direccion"]);
			$tel1 = $row["cli_tel1"];
			$tel2 = $row["cli_tel2"];
			$mail = $row["cli_mail"];
		}
	}
	
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
						<input type = "hidden" name = "cod1" id = "cod1" value = "<?php echo $codigo; ?>" />
					</div>	
					<div class="col-md-2 text-right"><label>Nombre:  </label> <span class="text-danger">*</span></div>
					<div class="col-md-3"><input type = "text" class = "form-control" name = "cnom1" id = "cnom1" value = "<?php echo $nom; ?>" onkeyup = "texto(this)"/></div>	
				</div>
				<div class="row">
					<div class="col-md-2 text-right"><label>Direcci&oacute;n:  </label> <span class="text-danger">*</span></div>
					<div class="col-md-8"><input type = "text" class = "form-control" name = "cdirec1" id = "cdirec1" value = "<?php echo $dir; ?>" onkeyup = "texto(this)" /></div>	
				</div>
				<div class="row">
					<div class="col-md-2 text-right"><label>Telefono 1:  </label> </div>
					<div class="col-md-3"><input type = "text" class = "form-control" name = "ctel1" id = "ctel1" value = "<?php echo $tel1; ?>" onkeyup = "enteros(this)" maxlength = "15" /></div>	
					<div class="col-md-2 text-right"><label>Telefono 2:  </label> </div>
					<div class="col-md-3"><input type = "text" class = "form-control" name = "ctel2" id = "ctel2" value = "<?php echo $tel2; ?>" onkeyup = "enteros(this)" maxlength = "15" /></div>	
				</div>
				<div class="row">
					<div class="col-md-2 text-right"><label>e-mail:</label></div>
					<div class="col-md-3"><input type = "text" class = "form-control text-libre" name = "cmail1" id = "cmail1" value = "<?php echo $mail; ?>" /></div>
				</div>
				<br><br>
				<div class="row">
					<div class="12 text-center">
					   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-info" id = "busc" onclick = "ModificarCliente(<?php echo $fila; ?>)"><span class="fa fa-check"></span> Aceptar</button>
					 </div>
				</div>
				<br>
			</div>		
		</div>	
	</body>
</html>

