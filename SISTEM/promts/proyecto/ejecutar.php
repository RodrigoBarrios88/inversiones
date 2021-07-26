<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$monto = $_REQUEST["Total"];
	$monto = round($monto, 2);
	$filas = $_REQUEST["Filas"];
	$tipoP = $_REQUEST["Tipo"];
	switch($tipoP){
		case 2: $Tpago = "TARJETA"; $desc = "Cod. Cierre (POS)"; break;
		case 4: $Tpago = "CHEQUE"; $desc = "No. Deposito"; break;
	}
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
			<form name = "f1" id = "f1" onsubmit = "return false">
					<table>
						<tr>
							<td colspan = "4" align = "right">
								<span class = "obligatorio">* Campos Obligatorios</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Tipo de Cuentas: <span class = "requerido">*</span></td>
							<td>
								<input type = "text" class = "text" name = "tpago1" id = "tpago1" value = "<?php echo $Tpago; ?>" readonly  />
								<input type = "hidden" name = "tfilas" id = "tfilas" value = "<?php echo $filas; ?>"  />
							</td>
							<td class = "celda" align = "right">Tipo de Cobro: <span class = "requerido">*</span></td>
							<td>
								<select id = "tip1" name = "tip1" class = "combo" onchange="TipoCobro(this.value)">
									<option value = "1">DEPOSITO</option>
									<option value = "2">EFECTIVO</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right" id = "lbl1">Banco a Depositar: <span class = "requerido">*</span></td>
							<td id = "cnt1">
								<?php echo Banco_html_Onclick("ban1","cue1","scue1",""); ?>
							</td>
							<td class = "celda" align = "right" id = "lbl2">No. Cuenta: <span class = "requerido">*</span></td>
							<td id = "cnt2">
								<span id = "scue1" >
									<select id = "cue1" name = "cue1" class = "combo">
										<option value = "">Seleccione</option>
									</select>
								</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right" id = "lbl3" style="visibility:hidden;">Empresa: <span class = "requerido">*</span></td>
							<td id = "cnt3" style="visibility:hidden;">
								<?php echo Empresa_Dinamic_onclick("1","Empresa_CajaJS(this.value)"); ?>
							</td>
							
							<td class = "celda" align = "right" id = "lbl4" style="visibility:hidden;">Caja: <span class = "requerido">*</span></td>
							<td id = "cnt4" style="visibility:hidden;">
								<span id = "scaja1" >
									<select id = "caja1" name = "caja1" class = "combo">
										<option value = "">Seleccione</option>
									</select>
								</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right"><?php echo $desc; ?><span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "doc1" id = "doc1" onkeyup = "texto(this)" /></td>
							<td class = "celda" align = "right">% Cargo por Manejo: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "cargo1" id = "cargo1" value = "0" onkeyup = "decimales(this);descuento_x_cargos();"  /></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Monto de Ejecucion: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "montp1" id = "montp1" value = "<?php echo $monto; ?>" readonly /></td>
							<td class = "celda" align = "right">Monto a Depositar: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "total1" id = "total1" value = "<?php echo $monto; ?>" /></td>
						</tr>
						<tr>
							<td colspan = "4" align = "center">
								<div class = "boxboton" style = "width:200px;">
								<br>
									<a class="button" href="javascript:void(0)" onclick = "cerrarPromt()"><img src = "../../CONFIG/images/icons/cancel.png" class="icon" > Cancelar</a>
									<a class="button" href="javascript:void(0)" onclick = "Ejecutar_Cheque_Tarjeta()" ><img src = "../../CONFIG/images/icons/save.png" class="icon" > Aceptar</a>
								</div>
							</td>
						</tr>
					</table>
			</form>
			<script type="text/javascript">
				///Setea la moneda por defecto en la venta
				mon = document.getElementById('monP1');
				mon.value = <?php echo $moneda; ?>;
			</script>
	</body>
</html>
