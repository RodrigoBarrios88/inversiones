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
		<div class="panel panel-default">
			<div class="panel-heading"><label>Nuevo Art&iacute;culo de Venta</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
				<div class="row">
                <div class="col-xs-3 text-right"><label>Codigo Interno: </label> </div>
                    <div class="col-xs-3 text-left">
						<input id="barc1" name="barc1" class="form-control" type="text" onkeyup="texto(this);KeyEnter(this,Buscar);" />
					</div>
                    <div class="col-xs-6 text-center">
						<input id="chkb1" type="checkbox" checked="" onclick="document.getElementById('barc1').value = ''" name="chkb1" /> 
						<strong class="text-info"> * Generar Codigo Automaticamente</strong>
					</div>
                </div>
                <div class="row">
                    <div class="col-xs-3 text-right"><label>Grupo: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-3 text-left">
						<?php echo grupo_art_html("gru1"); ?>
					</div>
                    <div class="col-xs-3 text-right"><label>Marca: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-3 text-left"><input type = "text" class="form-control" name = "marca1" id = "marca1" onkeyup = "texto(this)" /></div>
                </div>
                <div class="row">
                    <div class="col-xs-3 text-right"><label>Nombres: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-3 text-left"><input type = "text" class="form-control" name = "artnom1" id = "artnom1" onkeyup = "texto(this)" /></div>
                    <div class="col-xs-3 text-right"><label>Descripci&oacute;n: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-3 text-left"><input type = "text" class="form-control" name = "desc1" id = "desc1" onkeyup = "texto(this)" /></div>
                </div>
                <div class="row">
                    <div class="col-xs-3 text-right"><label>Clase Unidad Med.: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-3 text-left">
						<select id = "umclase1" name = "umclase1" class = "form-control" onchange = "xajax_UnidadMedida(this.value)" >
							<option value = "">Seleccione</option>
							<option value = "U">UNIDAD</option>
							<option value = "M">MEDIDA</option>
							<option value = "P">PESO</option>
							<option value = "S">SUPERFICIE</option>
							<option value = "C">CAPACIDAD</option>
						</select>
					</div>
                    <div class="col-xs-3 text-right"><label>Unidad de Medida: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-3" id = "sumed1">
						<select id = "umed1" name = "umed1" class = "form-control">
							<option value = "">Seleccione</option>
							<option value = "0">UNIDAD</option>
						</select>
					</div>
                </div>
				<div class="row">
                    <div class="col-xs-3 text-right"><label>Moneda: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-3 text-left"><?php echo moneda_html("mon1"); ?></div>
                    <div class="col-xs-3 text-right"><label>Precio: </label> <label class = " text-danger">*</label></div>
                    <div class="col-xs-3 text-left"><input type = "text" class="form-control" name = "precio1" id = "precio1" onkeyup = "decimales(this)" /></div>
                </div>
				<br><br>
				<div class="row">
					<div class="col-xs-12 text-center">
					   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
						<button type="button" class="btn btn-info" id = "busc" onclick = "GrabarArticulo();"><span class="fa fa-check"></span> Aceptar</button>
					 </div>
				</div>
				<br>
			</div>		
		</div>	
	</body>
</html>
