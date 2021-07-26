<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$gremial = $_SESSION["gremial"];
	$pensum = $_SESSION["pensum"];
	
	$codigo = $_REQUEST["usuid"];
	$ClsUsu = new ClsUsuario();
	$result = $ClsUsu->get_usuario($codigo);
		foreach($result as $row){
			$cod = trim($row["usu_id"]);
			$nom = trim($row["usu_nombre"]);
			$np = trim($row["usu_nombre_pantalla"]);
			$sit = $row["usu_situacion"]; 
			$sit = ($sit == 1)? "<strong style = 'color:green'>ACTIVO</strong>":"<blink style = 'color:red'>SUSPENDIDO</blink>";
		}
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
<body>	
<br>	
<div class="panel panel-default">
	<div class="panel-heading"><label><?php echo $rotulo; ?></label></div>
	<div class="row">
		<div class="col-xs-11 col-xs-11 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
	</div>
	<div class="row">
		<div class="col-xs-2 text-right"><label>Nombres:  </label></div>
		<div class="col-xs-3">
			<input type = "text" class = "form-control" name = "nom1" id = "nom1"  value = "<?php echo $nom; ?>" readonly />
			<input type = "hidden" name = "cod1" id = "cod1" value = "<?php echo $cod; ?>" />
		</div>	
		<div class="col-xs-3 text-right"><label>Nombre en Pantalla: </label></div>
		<div class="col-xs-3">
			<input type = "text" class = "form-control" name = "np1" id = "np1"  value = "<?php echo $np; ?>" readonly />
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2 text-right"><label>Situaci&oacute; Actual: </label><span class="text-info">*</span></div>
		<div class="col-xs-3"><?php echo $sit; ?></div>
		<div class="col-xs-3 text-right"><label>Situaci&oacute; a Asignar: </label><span class="text-info">*</span></div>
		<div class="col-xs-3">
			<select id="sit1" name="sit1" class = "form-control">
				<option value="1" selected>ACTIVO</option>
				<option value="0">INACTIVO</option>
			</select>
		</div>
        </div>
	<div class="row">
		<div class="row">
                        <div class="col-xs-12 text-center">
		        <button type="button" class="btn btn-success" id = "limp" onclick = "cerrarModal();"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                	<button type="button" class="btn btn-info" id = "busc" onclick = "CambiarSit(<?php echo $band; ?>)"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>
                        </div>
                </div>
	</div>
	<br>
</div>
</body>
</html>
