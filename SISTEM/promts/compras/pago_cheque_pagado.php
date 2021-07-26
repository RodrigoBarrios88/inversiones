<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$monto = $_REQUEST["monto"];
	$monto = round($monto, 2);
	$moneda = $_REQUEST["mon"];
	$montext = $_REQUEST["montex"];
	$tipoP = $_REQUEST["tipo"];
	$banco = $_REQUEST["banco"];
	$cuenta = $_REQUEST["cuenta"];
	$chenum = $_REQUEST["cheqnum"];
	
$ClsBan = new ClsBanco();
$result = $ClsBan->get_cheque("",$cuenta,$banco,$chenum);
	
if(is_array($result)){
	foreach($result as $row){
		$cue = $row["cueb_codigo"];
		$ban = $row["ban_codigo"];
		$cuedesc = $row["cueb_ncuenta"];
		$bandesc = $row["ban_desc_ct"];
		$chenum = $row["che_ncheque"];
		$quien = $row["che_quien"];
		$montoP = $row["che_monto"];
		$moneda = $row["cueb_moneda"];
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
							<td class = "celda" align = "right">Tipo de Pago: <span class = "requerido">*</span></td>
							<td>
								<input type = "text" class = "text" name = "tpago1" id = "tpago1" value = "CHEQUE PAGADO ANTICIPADO" readonly  />
								<input type = "hidden" name = "tpag1" id = "tpag1" value = "<?php echo $tipoP; ?>"  />
							</td>
							<td class = "celda" align = "right">Moneda: <span class = "requerido">*</span></td>
							<td>
								<?php echo Moneda_Transacciones_html("P1"); ?>
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Banco: <span class = "requerido">*</span></td>
							<td>
								<input type = "text" class = "text" name = "bandesc" id = "bandesc" value = "<?php echo $bandesc; ?>" readonly  />
								<input type = "hidden" name = "ban1" id = "ban1" value = "<?php echo $ban; ?>"  />
							</td>
							
							<td class = "celda" align = "right">No. Cuenta: <span class = "requerido">*</span></td>
							<td>
								<input type = "text" class = "text" name = "cuedesc" id = "cuedesc" value = "<?php echo $cuedesc; ?>" readonly  />
								<input type = "hidden" name = "cue1" id = "cue1" value = "<?php echo $cue; ?>"  />
								<input type = "hidden" name = "opera1" id = "opera1" value = "<?php echo $bandesc; ?>"  />
								<input type = "hidden" name = "caja1" id = "caja1" value = ""  />
								<input type = "hidden" name = "suc1" id = "suc1" value = "<?php echo $empCodigo; ?>"  />
							</td>
						</tr>
						<tr>
							<td class = "celda" align = "right">No. Cheque: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "bouch1" id = "bouch1" value = "<?php echo $chenum; ?>" readonly /></td>
							<td class = "celda" align = "right">A Nombre de quien: <span class = "requerido">*</span></td>
							<td colspan = "3"><input type = "text" class = "text" name = "obs1" id = "obs1" value = "<?php echo $quien; ?>" readonly /></td>
						</tr>
						<tr>
							<td class = "celda" align = "right">Monto a Pagar: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "montp1" id = "montp1" value = "<?php echo $montoP; ?>" /></td>
							<td class = "celda" align = "right">Monto venta: <span class = "requerido">*</span></td>
							<td><input type = "text" class = "text" name = "montv1" id = "montv1" value = "<?php echo $monto; ?>" readonly /></td>
						</tr>
						<tr>
							<td colspan = "4" align = "center">
								<div class = "boxboton" style = "width:200px;">
								<br>
									<a class="button" href="javascript:void(0)" onclick = "cerrarBigPromt()" ><img src="../../CONFIG/images/icons/cancel.png" class="icon" > Cancelar</a>
									<a class="button" href="javascript:void(0)" onclick = "NewFilaPago();" ><img src="../../CONFIG/images/icons/save.png" class="icon" > Aceptar</a>
								</div>
							</td>
						</tr>
					</table>
			</form>
		<script type="text/javascript">
			///Setea la moneda por defecto en la venta
			mon = document.getElementById('monP1');
			mon.value = <?php echo $moneda; ?>;
			mon.style.disabled = true;
		</script>
	</body>
</html>

<?php }else{ ?>

	<table>
		<tr>
			<td align = "right">
				<h3>Ese No. de Cheque no se encuentra registrado en el Sistema...</h3>
			</td>
		</tr>
		<tr>
			<td align = "center">
				<div class = "boxboton" style = "width:100px;">
				<br>
				<a class="button" href="javascript:void(0)" onclick = "cerrarBigPromt()"><img src="../../CONFIG/images/icons/cancel.png" class="icon" > Cancelar</a>
				</div>
			</td>
		</tr>
	</table>
<?php } ?>