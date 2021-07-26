<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION['empCodigo'];
	$pensum = $_SESSION["pensum"];
	//--
	$cuenta = $_REQUEST["cue"];
	$banco = $_REQUEST["ban"];
	$num = $_REQUEST["num"];
	$bann = $_REQUEST["bann"];
	$tipo = $_REQUEST["tip"];
	//--
	$movimiento = ($tipo == "I")?"Deposito o Ingreso":"Retiro o Egreso";
	$doc = ($tipo == "I")?"No. Deposito":"No. Doc. Retiro";
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading"><label>Movimiento de Cuenta (<?php echo $movimiento; ?>)</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
						<input type = "hidden" name = "cue1" id = "cue1" value = "<?php echo $cuenta; ?>" />
						<input type = "hidden" name = "ban1" id = "ban1" value = "<?php echo $banco; ?>" />
						<input type = "hidden" name = "mov1" id = "mov1" value = "<?php echo $tipo; ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>No. Cuenta: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<label class = "form-control text-info" disabled><?php echo $num; ?></label>
					</div>
					<div class="col-xs-3 text-right"><label>Banco: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<label class = "form-control text-info" disabled><?php echo $bann; ?></label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Monto: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "mont1" id = "mont1" onkeyup = "desc(this)" /></div>
					<div class="col-xs-3 text-right"><label><?php echo $doc; ?>: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "doc1" id = "doc1" onkeyup = "texto(this)" /></div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Motivo: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<select id = "tip1" name = "tip1" class = "form-control">
							<option value = "">Seleccione</option>
									<?php if($tipo == "E"){ ?>
									<option value = "RT">RETIRO</option>
									<option value = "FI">FIN DE INVERSION</option>
									<option value = "DI">DES-INVERSION</option>
									<?php }else if($tipo == "I"){ ?>
									<option value = "DP">DEPOSITO</option>
									<option value = "IN">INTERESES</option>
									<option value = "IV">INVERSION</option>
									<?php } ?>
						</select>
					</div>
					<div class="col-xs-3 text-right"><label>Fecha Hora: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<div class="">
							<div class='input-group date' id='fini'>
								<input type='text' class="form-control" id = "fecha1" name='fecha1' value="<?php echo date("d/m/Y"); ?>" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Justificaci&oacute;n: </label> </div>
					<div class="col-xs-9">
						<input type = "text" class = "form-control" name = "mot1" id = "mot1" onkeyup = "texto(this)" />
					</div>
				</div>
					<br><br>
					<div class="row">
						<div class="col-xs-12 text-center">
						   <button type="button" class="btn btn-default" id = "limp" onclick = "cerrarModal();"><span class="fa fa-remove"></span> Cancelar</button>
							<button type="button" class="btn btn-info" id = "busc" onclick = "GrabarMovimiento();"><span class="fa fa-check"></span> Aceptar</button>
						 </div>
					</div>
				<br>
			</div>		
		</div>	
		<script>
			$(function () {
				$('#fecha1').datetimepicker({
					format: 'DD/MM/YYYY'
				});
			});
		</script>
	</body>
</html>
