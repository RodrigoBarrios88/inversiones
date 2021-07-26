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
		<br>
			<form name = "f1" id = "f1" onsubmit = "return false">
				<h3 class="encabezado"> Nuevo Articulo </h3>
					<table>
						<tr>
							<td colspan = "4" align = "right">
								<span class = "obligatorio">* Campos Obligatorios</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Barcode: </td>
							<td><input type = "text" class = "text" name = "barc1" id = "barc1" onkeyup = "texto(this);KeyEnter(this,Buscar);"  /></td>
							<td class = "celda" align = "center" colspan = "3">
								<input type = "checkbox" class = "textct" name = "chkb1" id = "chkb1" onclick = "document.getElementById('barc1').value = ''" checked />
								<span class = "busqueda"> * Generar Barcode Automaticamente</span>  
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Grupo: <span class = "requerido">*</span></td>
							<td><?php echo Grupo_Art_html(1); ?></td>
							<td class = "celda" align = "right">Marca: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "marca1" id = "marca1" onkeyup = "texto(this)" /></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Nombre: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "artnom1" id = "artnom1" onkeyup = "texto(this)" /></td>
							<td class = "celda" align = "right">Descripci&oacute;n: <span class = "requerido">*</span></td>
							<td align = "right"><input type = "text" class = "text" name = "desc1" id = "desc1" onkeyup = "texto(this)" /></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Clase Unidad Med.: <span class = "requerido">*</span></td>
							<td>
								<select id = "umclase1" name = "umclase1" class = "combo" onchange = "xajax_UnidadMedida(this.value)" >
									<option value = "">Seleccione</option>
									<option value = "U">UNIDAD</option>
									<option value = "M">MEDIDA</option>
									<option value = "P">PESO</option>
									<option value = "S">SUPERFICIE</option>
									<option value = "C">CAPACIDAD</option>
								</select>
							</td>
							<td class = "celda" align = "right">Unidad Medida: <span class = "requerido">*</span></td>
							<td>
								<span id = "sumed1" >
									<select id = "umed1" name = "umed1" class = "combo">
										<option value = "">Seleccione</option>
										<option value = "0">UNIDAD</option>
									</select>
								</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Precio venta: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "precio1" id = "precio1" onkeyup = "decimales(this)"  /></td>
							<td class = "celda" align = "right">Moneda: <span class = "requerido">*</span></td>
							<td><?php echo Moneda_html(1); ?></td>
						</tr>
						<tr>
							<td colspan = "4" align = "center">
								<div class = "boxboton" style = "width:200px;">
								<br>
									<a class="button" href="javascript:void(0)" onclick = "GrabarArticulo()" ><img src="../../CONFIG/images/icons/save.png" class="icon" > Grabar</a>
									<a class="button" href="javascript:void(0)" onclick = "cerrarPromt()"><img src="../../CONFIG/images/icons/cancel.png" class="icon" > Cancelar</a>
								</div>
							</td>
						</tr>
					</table>
			</form>	
	</body>
</html>
