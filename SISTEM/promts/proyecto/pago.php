<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$monto = $_REQUEST["monto"];
	$monto = round($monto, 2);
	$moneda = $_REQUEST["mon"];
	$montext = $_REQUEST["montex"];
	$tipoP = $_REQUEST["tipo"];
	switch($tipoP){
		case 1: $Tpago = "EFECTIVO"; break;
		case 4: $Tpago = "CHEQUE"; break;
		case 5: $Tpago = "VENTA AL CREDITO"; break;
		case 6: $Tpago = "VENTA A CONSIGNACION"; break;
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
			<form name = "f1" id = "f1" onsubmit = "return false">
				<h3 class="encabezado"> Pago de Venta </h3>
					<table>
						<tr>
							<td colspan = "4" align = "right">
								<span class = "obligatorio">* Campos Obligatorios</span>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Tipo de Pago: <span class = "requerido">*</span></td>
							<td>
								<?php if($tipoP == 2 || $tipoP == 3){ ?>
								<select id = "tpag1" name = "tpag1" class = "combo">
									<option value = "2">TARJETA DE DEBITO</option>
									<option value = "3">TARJETA DE CREDITO</option>
								</select>
								<?php }else{ ?>
								<input type = "text" class = "text" name = "tpago1" id = "tpago1" value = "<?php echo $Tpago; ?>" readonly  />
								<input type = "hidden" name = "tpag1" id = "tpag1" value = "<?php echo $tipoP; ?>"  />
								<?php } ?>
							</td>
							<td class = "celda" align = "right">Moneda: <span class = "requerido">*</span></td>
							<td>
								<?php echo Moneda_Transacciones_html("P1"); ?>
							</td>
						</tr>
					<?php if($tipoP == 2 || $tipoP == 3){ ?>
						<tr>
							<td class = "celda" align = "right">Operador: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></td>
							<td class = "celda" align = "right">Boucher: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></td>
						</tr>
					<?php }else if($tipoP == 4){ ?>
						<tr>
							<td class = "celda" align = "right">Banco: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></td>
							<td class = "celda" align = "right">No. Cheque: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></td>
						</tr>
					<?php }else if($tipoP == 5 || $tipoP == 6){ ?>
						<tr>
							<td class = "celda" align = "right">Autoriza: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></td>
							<td class = "celda" align = "right">No. Doc.: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></td>
						</tr>
					<?php }else{ ?>
						<tr>
							<td>
								<input type = "hidden" name = "opera1" id = "opera1" value = ""  />
								<input type = "hidden" name = "bouch1" id = "bouch1" value = ""  />
								<input type = "hidden" name = "obs1" id = "obs1" value = ""  />
							</td>
						</tr>
					<?php } ?>
						<tr>
							<td class = "celda" align = "right">Monto a Pagar: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "montp1" id = "montp1" value = "<?php echo $monto; ?>" onkeyup = "decimales(this)"  /></td>
							<td class = "celda" align = "right">Monto venta: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "montv1" id = "montv1" value = "<?php echo $monto; ?>" readonly  /></td>
						</tr>
						<?php if($tipoP != 1){ ?>
							<?php if($tipoP == 4){ ?>
							<tr>
								<td class = "celda" align = "right">Quién gira el Cheque: <span class = "requerido">*</span></td>
								<td colspan = "3">
									<input type = "text" class = "textmd" name = "obs1" id = "obs1" onkeyup = "texto(this)" />
								</td>
							</tr>
							<?php }else{ ?>
							<tr>
								<td class = "celda" align = "right">Observaciones: </td>
								<td colspan = "3">
									<input type = "text" class = "textmd" name = "obs1" id = "obs1" onkeyup = "texto(this)" />
								</td>
							</tr>
							<?php } ?>
						<?php } ?>
						<tr>
							<td colspan = "4" align = "center">
								<div class = "boxboton" style = "width:200px;">
								<br>
									<a class="button" href="javascript:void(0)" onclick = "cerrarPromt()"><img src = "../../CONFIG/images/icons/cancel.png" class="icon" > Cancelar</a>
									<a class="button" href="javascript:void(0)" onclick = "NewFilaPago()" ><img src = "../../CONFIG/images/icons/save.png" class="icon" > Aceptar</a>
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
