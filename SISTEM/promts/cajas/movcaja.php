<?php
	include_once('../../html_fns.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION['empCodigo'];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
	$caja = $_REQUEST["caj"];
	$suc = $_REQUEST["suc"];
	$desc = Agrega_Ceros($caja)."-".Agrega_Ceros($suc);
	$sucn = $_REQUEST["sucn"];
	$tipo = $_REQUEST["tip"];
	$fecha = date("d/m/Y");
	//--
	$movimiento = ($tipo == "I")?"Deposito o Ingreso":"Retiro o Egreso";
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<form name = "f1" id = "f1" onsubmit = "return false">
		<div class="panel panel-default">
			<div class="panel-heading"><label>Movimiento de Caja (<?php echo $movimiento; ?>)</label></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-xs-12 text-right">
						<span class = "text-danger">* Campos Obligatorios</span>
						<input type = "hidden" name = "caj1" id = "caj1" value = "<?php echo $caja; ?>" />
						<input type = "hidden" name = "suc1" id = "suc1" value = "<?php echo $suc; ?>" />
						<input type = "hidden" name = "mov1" id = "mov1" value = "<?php echo $tipo; ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>No. Caja: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<label class = "text-info"><?php echo $desc; ?></label>
					</div>
					<div class="col-xs-3 text-right"><label>Empresa: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<label class = "text-info"><?php echo $sucn; ?></label>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Motivo: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<select id = "tip1" name = "tip1" class = "form-control">
							<?php if($tipo == "E"){ ?>
							<option value = "RT">RETIRO</option>
							<option value = "TR">TRASLADO A CUENTA</option>
							<?php }else if($tipo == "I"){ ?>
							<option value = "RB">REMBOLSO DE FONDOS</option>
							<option value = "DP">DEPOSITO</option>
							<?php } ?>
						</select>
					</div>
					<div class="col-xs-3 text-right"><label>Fecha: </label><span class = "text-danger">*</span></div>
					<div class="col-xs-3">
						<div class="">
							<div class='input-group date' id='fini'>
								<input type='text' class="form-control" id = "fecha1" name='fecha1' value="<?php echo $fecha; ?>" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2 text-right"><label>Monto: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "mont1" id = "mont1" onkeyup = "desc(this)" /></div>
					<div class="col-xs-3 text-right"><label>No. de Doc.: </label> <span class = "text-danger">*</span></div>
					<div class="col-xs-3"><input type = "text" class = "form-control" name = "doc1" id = "doc1" onkeyup = "texto(this)" /></div>
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
							<button type="button" class="btn btn-info" id = "busc" onclick = "GrabarMovimiento()"><span class="fa fa-check"></span> Aceptar</button>
						 </div>
					</div>
				<br>
			</div>		
		</div>	
		</form>
		
		<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	    <script>
		  $(function () {
			   $('#fecha1').datetimepicker({
				   format: 'DD/MM/YYYY'
			   });
		   });
	    </script>
		
	</body>
</html>
