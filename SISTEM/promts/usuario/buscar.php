<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	$band = $_REQUEST['ban'];
	
		if($band == 1){ 
			$rotulo = "Busqueda de Usuario para Asignaci&oacute;n de Rol";
		}else if($band == 2){ 	
			$rotulo = "Busqueda de Usuario para Despliegue de Informaci&oacute;n";
		}else if($band == 3){ 	
			$rotulo = "Busqueda de Usuario para Cambio de Situaci&oacute;n";
		}else if($band == 4){ 	
			$rotulo = "Busqueda de Usuario para Despliegue de Permisos";
		}else if($band == 5){ 	
			$rotulo = "Busqueda de Usuario para Despliegue de Historial de Permisos";
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
		<div class="col-xs-11 col-xs-11 text-right"><label class = " text-info">* Campos de Busqueda</label></div>
	</div>
	<div class="row">
		<div class="col-xs-3 text-right"><label>Tipo de Usuario: </label> <span class="text-info">*</span></div>
                <div class="col-xs-3">
			<select name = "tipo1" id = "tipo1" class="form-control">
				<option>Seleccione</option>
				<option value="5">ADMINISTRADOR</option>
				<option value="1">DIRECTOR O AUTORIDAD</option>
				<option value="2">DOCENTE O MAESTO</option>
				<option value="3">PADRE DE FAMILIA</option>
				<option value="6">USUARIO ADMINISTRATIVO</option>
			</select>
		</div>
		<div class="col-xs-2 text-right"><label>Situaci&oacute;n: </label> <span class="text-info">*</span></div>
		<div class="col-xs-3">
			<select id="sit1" name="sit1" class = "form-control">
				<option value="1" selected >ACTIVO</option>
				<option value="0">INACTIVO</option>
			</select>
		</div>
        </div>
	<div class="row">
		<div class="col-xs-3 text-right"><label>Nombre: </label> <span class="text-info">*</span></div>
		<div class="col-xs-3"><input type = "text" class="form-control" name = "nom1" id = "nom1" onkeyup = "texto(this);KeyEnter(this,Buscar2);" /></div>
		<div class="col-xs-2 text-right"><label>Usuario: </label> <span class="text-info">*</span></div>
		<div class="col-xs-3"><input type = "text" class="form-control text-libre" name = "usu1" id = "usu1" onkeyup = "texto(this);KeyEnter(this,Buscar2);" /></div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-xs-12 text-center">
			<button type="button" class="btn btn-info" id = "busc" onclick = "Buscar2(<?php echo $band; ?>)"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                        <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
		</div>
        </div>
	<br>
</div>
</body>
</html>
