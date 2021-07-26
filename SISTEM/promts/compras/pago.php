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
	switch($tipoP){
		case 1: $Tpago = "EFECTIVO"; break;
		case 2: $Tpago = "TARJETA DE DEBITO"; break;
		case 3: $Tpago = "TARJETA DE CREDITO"; break;
		case 4: $Tpago = "CHEQUE"; break;
		case 5: $Tpago = "VENTA AL CREDITO"; break;
		case 6: $Tpago = "VENTA A CONSIGNACION"; break;
		case 7: $Tpago = "VENTA CON CHEQUE PAGADO"; break;
	}
	
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label><i class="fa fa-money"></i> Forma de Pago</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
					</div>
				</div>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Tipo de Pago: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3">
								<input type = "text" class = "form-control" name = "tpago1" id = "tpago1" value = "<?php echo $Tpago; ?>" readonly  />
								<input type = "hidden" name = "tpag1" id = "tpag1" value = "<?php echo $tipoP; ?>"  />
							</div>
							<div class="col-xs-2 text-right"><label>Moneda: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3">
								<?php echo moneda_transacciones_html("monP1"); ?>
							</div>
						</div>
					<?php if($tipoP == 2){ ?>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Banco: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3">
								<?php echo banco_html("ban1","xajax_Combo_Cuenta_Banco(this.value,'cue1','scue1','')"); ?>
							</div>
							<div class="col-xs-2 text-right"><label>No. Cuenta: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3" id = "scue1">
								<select id = "cue1" name = "cue1" class = "form-control">
									<option value = "">Seleccione</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Operador: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
							<div class="col-xs-2 text-right"><label>Boucher: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></div>
						</div>
					<?php }else if($tipoP == 3){ ?>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Operador:<span class = "requerido">*</span> </div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
							<div class="col-xs-2 text-right"><label>Boucher: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<input type = "hidden" name = "ban1" id = "ban1" value = ""  />
								<input type = "hidden" name = "cue1" id = "cue1" value = ""  />
							</div>
						</div>
					<?php }else if($tipoP == 4){ ?>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Banco: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3">
								<?php echo banco_html("ban1","xajax_Combo_Cuenta_Banco(this.value,'cue1','scue1','Num_Cheque()')"); ?>
							</div>
							
							<div class="col-xs-2 text-right"><label>No. Cuenta: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3">
								<span id = "scue1" >
									<select id = "cue1" name = "cue1" class = "form-control">
										<option value = "">Seleccione</option>
									</select>
								</span>
								<input type = "hidden" name = "opera1" id = "opera1" value = ""  />
								<input type = "hidden" name = "caja1" id = "caja1" value = ""  />
								<input type = "hidden" name = "suc1" id = "suc1" value = "<?php echo $empCodigo; ?>"  />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-2 text-right"><label>No. Cheque: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></div>
						</div>
					<?php }else if($tipoP == 5 || $tipoP == 6){ ?>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Autoriza: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "opera1" id = "opera1" onkeyup = "texto(this)" /></div>
							<div class="col-xs-2 text-right"><label>No. Doc.: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "bouch1" id = "bouch1" onkeyup = "texto(this)" /></div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<input type = "hidden" name = "ban1" id = "ban1" value = ""  />
								<input type = "hidden" name = "cue1" id = "cue1" value = ""  />
							</div>
						</div>
					<?php }else{ ?>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Empresa: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3">
								<?php echo empresa_html("suc1","Empresa_CajaJS(this.value)"); ?>
								<script>
									document.getElementById("suc1").value = '<?php echo $empCodigo; ?>';
								</script>
							</div>
							<div class="col-xs-2 text-right"><label>Caja: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3" id = "scaja1">
								<?php
									if($empCodigo != ""){
										echo caja_sucursal_html($empCodigo,'caja1','');
									}else{
										echo combos_vacios("caja1");
									}
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<input type = "hidden" name = "ban1" id = "ban1" value = ""  />
								<input type = "hidden" name = "cue1" id = "cue1" value = ""  />
								<input type = "hidden" name = "opera1" id = "opera1" value = ""  />
								<input type = "hidden" name = "bouch1" id = "bouch1" value = ""  />
								<input type = "hidden" name = "obs1" id = "obs1" value = ""  />
							</div>
						</div>
					<?php } ?>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Monto a Pagar: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "montp1" id = "montp1" value = "<?php echo $monto; ?>" onkeyup = "decimales(this)"  /></div>
							<div class="col-xs-2 text-right"><label>Monto Compra: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-3"><input type = "text" class = "form-control" name = "montv1" id = "montv1" value = "<?php echo $monto; ?>" readonly  /></div>
						</div>
						<?php if($tipoP != 1 && $tipoP != 4){ ?>
						<div class="row">
							<div class="col-xs-2 text-right"><label>Observaciones: </div>
							<div class="col-xs-8">
								<input type = "text" class = "form-control" name = "obs1" id = "obs1" onkeyup = "texto(this)" />
								<input type = "hidden" name = "suc1" id = "suc1" value = ""  />
								<input type = "hidden" name = "caja1" id = "caja1" value = ""  />
							</div>
						</div>
						<?php }else if($tipoP == 4){ ?>
						<div class="row">
							<div class="col-xs-2 text-right"><label>A Nombre de quien: </label><span class = "text-danger">*</span></div>
							<div class="col-xs-8">
								<input type = "text" class = "form-control" name = "obs1" id = "obs1" onkeyup = "texto(this)" />
							</div>
						</div>
						<?php } ?>
						<br><br>
					<div class="row">
						<div class="col-xs-12 text-center">
						   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
							<button type="button" class="btn btn-info" id = "busc" onclick = "NewFilaPago();"><span class="fa fa-check"></span> Aceptar</button>
						 </div>
					</div>
				<br>
			</div>		
		</div>	
		<script type="text/javascript">
			///Setea la moneda por defecto en la venta
			mon = document.getElementById('monP1');
			mon.value = '<?php echo $moneda; ?>';
		</script>
	</body>
</html>